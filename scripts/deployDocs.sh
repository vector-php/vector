#! bash

php ./scripts/deps/generateMkdocs.php
mkdocs gh-deploy --clean
