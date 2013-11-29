#!/bin/bash

command -v git > /dev/null 2>&1
if [ $? -eq 0 ]; then
	rootDir=$(git rev-parse --show-toplevel 2>/dev/null)
	if [ -d "$rootDir" ]; then
		cd "$rootDir/src/cake/app/views/layouts"
	fi
elif [ -d "src" ]; then
	cd "src/cake/app/views/layouts"
elif [ -d "app" ]; then
	cd "app/views/layouts"
else
	exit 1
fi

for file in *.ctp; do
	echo "Updating file $file..."
	sed -i -r 's/(.*)stamp_([0-9]+)(.*)/echo "\1stamp_$((\2+1))\3"/ge' "$file"
done
