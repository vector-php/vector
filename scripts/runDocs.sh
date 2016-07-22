#! /bin/bash

./scripts/buildDocs.sh

echo "Running Documentation Preview Server..."
mkdocs serve
