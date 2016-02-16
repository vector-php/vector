<?php

namespace Vector\Core;

use Nette\Utils\Tokenizer;

class Interpreter
{
    /** @var SplQueue */
    private $tokenQueue;

    /** @var array */
    private $moduleDictionary;

    /** @var array */
    private $tokens = [
        'V_FLOAT'       => '\d*\.\d+',
        'V_INTEGER'     => '\d+',
        'V_OPEN_PAREN'  => '\(',
        'V_CLOSE_PAREN' => '\)',
        'V_COMPOSE'     => ' \. ',
        'V_WHITESPACE'  => '\s+',
        'V_FUNCTION'    => '\w+',
        'V_STRING'      => '\".+?\"'
    ];

    /**
     * Create a new Interpreter
     *
     * @param array $moduleDictionary List of modules to use for this interpreter
     */
    public function __construct($moduleDictionary = [])
    {
        $this->moduleDictionary = $moduleDictionary;
    }

    /**
     * Add a module to the interpreter library for parsing funciton expression
     * names
     *
     * @param  String $module Module name, fully qualified namespace
     * @return self
     */
    public function using($module)
    {
        $this->moduleDictionary[] = $module;

        return $this;
    }

    /**
     * Expand an expression. The expression should be given as a string and the following
     * syntax elements are supported:
     *
     * Strings (with double quotes), integers, floats, composition, and function names
     *
     * @param  String   $expression DSL Expression to expand into a Vector closure
     * @return Callable             A function expression that is the result of
     *                              expanding the given DSL expression
     */
    public function expand($expression)
    {
        $this->tokenQueue = array_reduce($this->tokenize($expression), function($carry, $token) {
            // Ignore Whitespace tokens
            if ($token[Tokenizer::TYPE] !== 'V_WHITESPACE') {
                $carry->enqueue($token);
            }

            return $carry;
        }, new \SplQueue());

        return $this->evaluateStackFrame();
    }

    /**
     * Evaluate the expression in a left-to-right way, consuming tokens one-by-one until
     * the token queue is exhausted. Each call results in a new evaluation context.
     *
     * @return mixed The result of evaluating the token queue within a given frame
     */
    private function evaluateStackFrame()
    {
        $executionState = \Vector\Lib\Lambda::using('id');
        $compose = \Vector\Lib\Lambda::using('compose');

        while (!$this->tokenQueue->isEmpty()) {
            $operator = $this->tokenQueue->dequeue();

            switch ($operator[Tokenizer::TYPE]) {
                case 'V_COMPOSE':
                    $operation = $this->evaluateStackFrame();
                    return $compose($executionState, $operation);
                case 'V_FUNCTION':
                    $operation = $this->lookup($operator[Tokenizer::VALUE]);
                    break;
                case 'V_OPEN_PAREN':
                    $operation = $this->evaluateStackFrame();
                    break;
                case 'V_CLOSE_PAREN';
                    return $executionState;
                case 'V_INTEGER':
                case 'V_FLOAT':
                    $operation = $operator[Tokenizer::VALUE];
                    break;
                case 'V_STRING':
                    $operation = trim($operator[Tokenizer::VALUE], '\"');
                    break;
            }

            $executionState = $executionState($operation);
        }

        return $executionState;
    }

    /**
     * Take an expression and tokenize it
     *
     * @param  String $expression DSL Expression to tokenize
     * @return array              An array of tokens transformed from the expression
     */
    private function tokenize($expression)
    {
        $tokenizer = new Tokenizer($this->tokens);

        return $tokenizer->tokenize($expression);
    }

    /**
     * Look in the interpreter dictionary and try to find the given function expression
     * Throws an Exception if it's not found.
     *
     * @throws \Exception
     *
     * @param  String   $functionName Name of the function to lookup
     * @return Callable               Function pulled from the correct module based
     *                                on the requested function name
     */
    private function lookup($functionName)
    {
        foreach ($this->moduleDictionary as $module) {
            $reflector = new \ReflectionClass($module);

            if ($reflector->hasMethod($functionName)) {
                return $module::using($functionName);
            }
        }

        throw new \Exception($functionName . ' was not found in the supplied interpreter modules.');
    }
}
