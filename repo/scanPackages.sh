#!/bin/sh
touch Packages
./dpkg-scanpackages -m deb /dev/null > Packages
bzip2 -fks Packages
