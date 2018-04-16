<?php

	# Path the repository files.
	# Make sure it is NOT inside the webroot and NOT accessible from the web
	# Place .deb files in $repoPath/deb/
	$repoPath = '../repo/';
	# Make sure it is not in a web accissible directory or in repoPath
	$udidListPath = "../allowedUDID.csv";
	
	# Whether PHP should log errors or not
	$showErrors = false;
?>
