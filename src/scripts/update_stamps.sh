#!/bin/bash

function stampfile () {
	found=$(grep -E "cachestamp_[0-9]+" "$1")
	filename=$(basename "$1")
	if [ -z "$found" ]; then
		echo "File $filename doesn't need update"
	else
		sed -i -r 's/(.*)(cachestamp_)([0-9]+)(.*)/echo "\1\2$((\3+1))\4"/ge' "$1"
		echo "File $filename updated"
	fi
}

function stampdir () {
	echo -n "Searching files in '$1'... "
	files=$(find "$1" -maxdepth 1 -type f -name \*.ctp)
	if [ -z "$files" ]; then
		echo "Nothing found!"
	else
		echo
		for file in $files; do
			echo -n " "
			stampfile "$file"
		done
	fi
}

if [ ! $# -eq 0 ]; then
	while [ $# -gt 0 ]; do
		echo
		if [ -d "$1" ]; then
			stampdir "$1"
		elif [ -f "$1" ]; then
			stampfile "$1"
		else
			echo "Error: '$1' is not accessible"
		fi
		shift
	done
else
	command -v git > /dev/null 2>&1
	dir=""
	if [ $? -eq 0 ]; then
		rootDir=$(git rev-parse --show-toplevel 2>/dev/null)
		if [ -d "$rootDir" ]; then
			dir="$rootDir/src/cake/app/views/layouts"
		fi
	elif [ -d "src" ]; then
		dir="src/cake/app/views/layouts"
	elif [ -d "app" ]; then
		dir="app/views/layouts"
	else
		exit 1
	fi

	if [ ! -z "$dir" ]; then
		stampdir "$dir"
	fi
fi
