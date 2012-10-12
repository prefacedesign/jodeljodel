#!/bin/bash

# take care of errors
set -e

# space separated paths, please ;)
APPDIRECTORIES="../views/translate_strings/ "

function usage() {
  echo "USAGE: licenser.sh /path/to/git/repository/base/dir [plugin,names,separated,by,comma]"
}


function append_license() {
  # TODO: colocar licença nos .js.
  if [[ `grep '@copyright ' $1` ]]; then
    echo $1
  fi
  if [[ ${1: -4} == ".php" ||  ${1: -4} == ".ctp" ]]; then
    sed -n '/<\?php/{:a;n;p;ba}' $1 > $1.new
    echo -e "<?php\n" > $1
  elif [[ ${1: -3} == ".js" ]]; then
    cp $1 $1.new
    echo -e "\n" > $1
  else
    return 0
  fi
  cat $2 >> $1
  cat $1.new >> $1
  rm $1.new
}

if [[ $# < 1 ]]; then
  usage
  exit 1
fi

# get the realpath to script
pushd `dirname $0` > /dev/null
  SCRIPTPATH=`pwd`
popd > /dev/null

if [[ ! -d $1 ]]; then
  usage
  exit 1
fi

# enter the repo dir
pushd $1 > /dev/null

if [[ ! -d .git ]]; then
  echo "Not a git directory"
  usage
  exit 1
fi

# get the plugins first
pushd "src/cake/app/plugins" > /dev/null

if [[ $# -ge 2 ]]; then
  PLUGINS=`echo $2 | tr ',' ' '`
else
  PLUGINS=*
fi

for d in $PLUGINS $APPDIRECTORIES; do
  if [[ ! -d $d ]]; then
    echo "there's no plugin dir like:"
    echo `pwd`/$d
    exit 1
  fi
done

for d in $PLUGINS ; do
  cp $SCRIPTPATH/LICENSE.txt $d
  for f in `find $d -type f`; do
    append_license $f $SCRIPTPATH/LICENSE_HEADER
  done
done

popd > /dev/null

popd > /dev/null

