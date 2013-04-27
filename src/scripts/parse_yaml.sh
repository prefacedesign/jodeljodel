#!/bin/bash

echo;

# TESTING FOR PHP
command -v php >/dev/null 2>&1
if [ "$?" -ne 0 ];then
    echo -e "\e[1;31mPHP CLI needed to run this test\e[0m"
    exit 1;
fi

# TESTING FOR PHP YAML FUNCTIONS
code="fwrite(STDOUT, function_exists('yaml_parse_file') ? 1 : 0);"
result=`php -r "$code"`
if [ "$result" -ne 1 ]; then
    echo -e "\e[1;31mYAML extension not found on PHP instalation.\e[0m"
    exit 1;
fi

# TESTING FOR THE FILE
file=`readlink -f "$1"`
filename=`basename "$file"`
echo -n "Scanning \"$filename\"... "

if [ ! -f "$file" ]; then
    echo "\"$file\" was not found"
    exit 1
fi

code="
    \$yaml = @yaml_parse_file('$file');
    if (empty(\$yaml))
    {
        \$error = error_get_last();
        \$error = \$error['message'];
        fwrite(STDOUT, \$error);
    }
    else
        fwrite(STDOUT, '1');
"

result=`php -r "$code"`

if [ "$result" = "1" ]; then
    echo -e "\e[1;32mYAML syntax is ok.\e[0m"
else
    echo -e "\e[1;31mYAML has some issues.\e[0m"
    echo "-------------------ISSUES-------------------"
    echo "$result"
    echo "-------------------ISSUES-------------------"
    echo "File is located at $file"
fi
