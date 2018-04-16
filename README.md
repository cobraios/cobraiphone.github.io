UDID Cydia Repo
===============

PHP Script to create a UDID protected Cydia Repository.

Usage
-----
 - Upload all the files
 - Edit the config.php and adjust the paths
 - Edit allowedUDID.csv with your beta testers info. You can also use the numbers spreadsheet in /Other Stuff for easier editing and export it as csv
 - Make sure the repo folder is OUTSIDE the web root and is not accessable from the web
 - Redirect all requests except for repo_file.php to repo_file.php?file=RequestedFile
     - You can do that using Mod Rewrite or Mod Alias. Check my /Other Stuff/apache2-vhost.conf for a Mod Alias exmaple
 - Put your .deb files in the repo/deb folder
 - Run scanPackages.sh
 - To automate this use /Other Stuff/deploy_beta.sh
