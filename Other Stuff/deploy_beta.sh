#!/bin/sh

server="yourserver.com"
repoPath="~/www/beta.yourserver.com/repo/"

if [ $# -eq 0 ]; then
    echo "Usage: $0 <deb file to deploy>"
    exit 1;
fi

echo "Copying deb"
scp $1 $server:$repoPath/deb/
echo "Scanning packages"
ssh $server "(cd $repoPath; ./scanPackages.sh)"
