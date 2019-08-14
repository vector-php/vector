# Contributing to Vector

## Guidelines ##
- All code should follow PSR standards for code style and namespacing
- Any functions you add should have test coverage
- Any functions you add should have docblocks with examples and a @type annotation

## Running Tests Locally
- If you want to run tests locally, you can run them normally through phpunit
- Alternatively if you have Docker Engine installed, you can run tests in multiple PHP environments at once. Just run the following commands from the root directory:

```
> sudo composer buildTestEnvironments
> sudo composer runTests
```

`buildTestEnvironments` will build the Docker environments, and `runTests` will execute them. You only need to run `buildTestEnvironments` the first time you run them, and any time
a new PHP environment is added to the testing environments directory.

## Check Coverage
```
phpdbg -qrr ./vendor/bin/phpunit --coverage-text
```

## Doc Blocks
Your docblocks should follow this style.

```

/**
 * <Function Name in Plain English, single line, < 10 words>
 * -- Blank Line --
 * <Function Description in Plain English, multi-line okay>
 * -- Blank Line --
 * @example
 * Example Code here. Multiple example blocks OK with blank lines between.
 * -- Blank Line --
 * @type <Type Annotation>
 * -- Blank Line --
 * @param <Param tags here, with type>
 * @return <Return tag here, with type>
 */

```
