#!/bin/bash

rm -rf docs
mkdir -p docs
cp README.md docs/
echo "site_name: 'Laravel Socialite Providers'
theme: 'readthedocs'
nav:
    - index: 'README.md'" > mkdocs.yml

for file in `ls */composer.json`; do
    package_id=`node getValueFromJsonFile.js $file extra.component.id`
    echo $package_id
    dir_name=`dirname $file`
    cp $dir_name/README.md docs/$package_id.md
    grep $package_id.md mkdocs.yml || echo "    - $dir_name: '$package_id.md'" >> mkdocs.yml
done

mkdocs build --clean
