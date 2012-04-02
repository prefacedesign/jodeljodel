#!/bin/sh

echo 'Collecting files for lint...'
files=`find $1 -name *.php -or -name *.ctp -type f`
count=`echo -n "$files" | wc -l`
i=0
errors=0

echo "...$count files found."; echo

for file in $files
do
	php -l $file > /dev/null
	if [ $? -ne 0 ]; then
		errors=$(($errors+1))
	fi
	porcent=$(($i*100/$count))
	i=$(($i+1))
	echo -n "Lint: $porcent% done\r"
done

echo ; echo

case "$errors" in
	0) echo "No error found! Congratulations!"
		;;
	1) echo "One error found... thats sad..."
		;;
	*) echo "OMG! Found $errors files with errors!"
		;;
esac
exit 0
