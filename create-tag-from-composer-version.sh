#!/bin/bash
set -e

file='composer.json'
echo -e "\ncreate tag"
version=$(node getValueFromJsonFile.js $file version)
tag_exists=$(git ls-remote origin refs/tags/"$version")
if [ -z "$tag_exists" ]; then
  git tag -a "$version" -m 'new version'
  git push --tags
fi
