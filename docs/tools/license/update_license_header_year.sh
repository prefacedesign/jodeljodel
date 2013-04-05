#!/bin/bash

git status

echo
echo
echo "Note: the branch should be empty in order to commit this change. Look at the status above."
echo
echo "If you would like to stop and clean up the branch before making this update type CTRL+C now!!"
echo "Pressing ENTER would update files and show changes in git diff pager.."

read

YEAR=`date +%y`

echo "Updating licenses to 20$YEAR"

pushd `git root` > /dev/null

find src/cake/app -type f -print0 | xargs -0 sed -i 's/\(Copyright\)\ 2010-20[0-9][0-9]\,\ \(Preface Design LTDA\)/\1\ 2010-20'$YEAR'\,\ \2/'

popd > /dev/null

GIT_PAGER=less git diff
