#! /bin/bash

./scripts/buildDocs.sh

echo "Deploying Documentation to Github Pages..."
mkdocs gh-deploy --clean
