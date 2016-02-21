#! bash

php ./deps/generateMkdocs.php
mkdocs gh-deploy --clean
