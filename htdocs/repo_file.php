<?php

	function forbidAccess($errorMessage = "You do not have permission to access this repository") {
		
		header("HTTP/1.0 403 Forbidden - $errorMessage");
		exit("Access denied: $errorMessage");
	}

	require_once("config.php");

	if($showErrors == true) {
		ini_set('display_errors', 1); 
		error_reporting(E_ALL);
	}
	
	$filename = $_GET["file"];
	
	
	if(isset($_SERVER['HTTP_X_UNIQUE_ID']) == false) {
		
		forbidAccess("No UDID sent: Only permitted iOS devices using Cydia may access this repository");
	}
	
	
	$udid = $_SERVER['HTTP_X_UNIQUE_ID'];
	
	$udidAllowedArray = array();
	
	$udidCsvHandle = fopen($udidListPath, "r");
	if($udidCsvHandle == false) {

		forbidAccess("Repo not configured: Could not open UDID DB");
	}
	
	while (($data = fgetcsv($udidCsvHandle, 1000, ",")) !== FALSE) {
	    
	    $dataUDID = $data[0];
	    if(strlen($dataUDID) == 40) {
	    
	    	$udidAllowedArray[] = $dataUDID;
	    }
	}
	fclose($udidCsvHandle);


	if(count($udidAllowedArray) == 0) {

		forbidAccess("Repo not configured: UDID DB is empty");
	}


    $baseFileName = basename($filename);
    $realRepoPath = realpath($repoPath);
    
    if(empty($baseFileName) == true) {
	    
		forbidAccess("Invalid File");
    }
    
    $filePath = "$realRepoPath/$baseFileName";
    if(pathinfo($baseFileName, PATHINFO_EXTENSION) == "deb") {
    	$filePath = "$realRepoPath/deb/$baseFileName";
    }

    if(in_array($udid, $udidAllowedArray) == true) {
    
	    if (file_exists($filePath) == true) {
	    
	    	$finfo = new finfo;
	       	$mime = $finfo->file($filePath, FILEINFO_MIME);
	
	    	header('Content-Length: ' . filesize($filePath));
	    	header('Content-Type: '.$mime);
	    	header('Expires: 0');
	    	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	        ob_clean();
	        flush();
	        readfile($filePath);
	    } else {
	        header('HTTP/1.1 404 File Not Found');
	    }
    } else {
	    
		forbidAccess("Invalid UDID: This is a private repository. This device does not have permission to access it.");
    }



?>