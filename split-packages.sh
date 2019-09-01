#!/bin/bash
set -e

rm -rf .subsplit
git subsplit init "$(git config --get remote.origin.url)"
git subsplit update
find -- */composer.json | while IFS='' read -r file; do
  target="$(node getValueFromJsonFile.js "$file" extra.component.target)"
  repo_uri=$(echo "$target" | cut -d "." -f1)
  desc=$(node getValueFromJsonFile.js "$file" description)
  dir_name=$(dirname "$file")
  hub create -d "$desc" "$repo_uri"
  git subsplit publish \
    "$dir_name":git@github.com:"$target" \
    --heads=master \
    --no-tags

  # create tag
  echo -e "\ncreate tag"
  version=$(node getValueFromJsonFile.js "$file" version)
  repo_name=$(echo "$repo_uri" | cut -d "/" -f2)
  rm -rf /tmp/"$repo_name"
  pushd /tmp/
  git clone git@github.com:"$target"
  pushd /tmp/"$repo_name"
  tag_exists=$(git ls-remote origin refs/tags/"$version")
  if [ -z "$tag_exists" ]; then
    git tag -a "$version" -m 'new version'
    git push --tags
  fi
  pushd +2
  dirs -c
  dirs -v
done
