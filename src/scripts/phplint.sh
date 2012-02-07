#!/bin/sh

echo 'Coletando arquivos para averiguar'
files=`find $1 -name *.php -or -name *.ctp -type f`
count=`echo -n "$files" | wc -l`
i=0

echo "$count arquivos encontrados."; echo

for file in $files
do
	result=`php -l $file` # | grep -v '^No syntax errors'`
	i=$(($i+1))
	porcent=$(($i*100/$count))
	echo -n "Fazendo lint: $porcent%\r"
done

exit 0
