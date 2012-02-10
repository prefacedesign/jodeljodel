#!/bin/sh

echo 'Collecting files for lint...'
files=`find $1 -name *.php -or -name *.ctp -type f`
count=`echo -n "$files" | wc -l`
i=0

echo "...$count files found."; echo

for file in $files
do
	result=`php -l $file` # | grep -v '^No syntax errors'`
	porcent=$(($i*100/$count))
	i=$(($i+1))
	echo -n "Lint: $porcent% done\r"
done

echo 
exit 0
