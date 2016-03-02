# Contributing to Vector

Guidelines
- All code should follow PSR standards for code style and namespacing
- Any functions you add should have test coverage
- Any functions you add should have docblocks with examples and a @type annotation

## Doc Blocks
Your docblocks should follow this style, since they're used in generating the documentation.

```

/**
 * <Function Name in Plain English, single line, < 10 words>
 * -- Blank Line --
 * <Function Description in Plain English, multi-line okay>
 * -- Blank Line --
 * ```
 * Example Code here.
 * You can assume your function is in scope already
 * ```
 * -- Blank Line --
 * @type <Type Annotation>
 * -- Blank Line --
 * @param <Param tags here, with type>
 * @return <Return tag here, with type>
 */

```

## Generating documentation
__ This only applied to Github users with contributor access! __
Documentation for Lib-namespaced functions are auto-generated from doc-blocks. To preview the documentation, run `sh ./sripts/previewDocs.sh` from the project root. Once you're happy with it after proofreading it, you can deploy the docs using `sh ./scripts/deployDocs.sh`.
