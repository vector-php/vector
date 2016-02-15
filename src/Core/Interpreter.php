<?php

namespace Vector\Core;

use Nette\Utils\Tokenizer;

class Interpreter
{
    private $tokenQueue;
    private $tokens = [
        'V_INTEGER'     => '\d+',
        'V_OPEN_PAREN'  => '\(',
        'V_CLOSE_PAREN' => '\)',
        'V_WHITESPACE'  => '\s+',
        'V_FUNCTION'    => '\w+'
    ];

    public function __construct($expression)
    {
        $this->tokenQueue = array_reduce($this->tokenize($expression), function($carry, $token) {
            $carry->enqueue($token); return $carry;
        }, new \SplQueue());
    }

    private function tokenize($expression)
    {
        $tokenizer = new Tokenizer($this->tokens);

        return array_filter($tokenizer->tokenize($expression), function($t) {
            return $t[Tokenizer::TYPE] !== 'V_WHITESPACE';
        });
    }

    public function evaluateStackFrame()
    {
        $executionState = \Vector\Lib\Lambda::using('id');
        $dictionary = [
            'add' => \Vector\Lib\Math::using('add')
        ];

        while (!$this->tokenQueue->isEmpty()) {
            $operator = $this->tokenQueue->dequeue();

            switch ($operator[Tokenizer::TYPE]) {
                case 'V_FUNCTION':
                    $operation = $dictionary[$operator[Tokenizer::VALUE]];
                    break;
                case 'V_INTEGER':
                    $operation = $operator[Tokenizer::VALUE];
                    break;
                case 'V_OPEN_PAREN':
                    $operation = $this->evaluateStackFrame();
                    break;
                case 'V_CLOSE_PAREN';
                    return $executionState;
                    break;
            }

            $executionState = $executionState($operation);
        }

        return $executionState;
    }
}
