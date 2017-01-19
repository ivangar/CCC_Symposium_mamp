<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start(); // Turn on output buffering. From this point output is stored in an internal buffer 

/*
** This file is used to load the file that has been uploaded. It is called from the file update_event.js.
** update_event.js is called from rep_zone/pages/myevent.php
*/

$ret= array();

if(	isset($_POST["folderID"]) && !empty($_POST["folderID"]) )
{
    $folderID = $_POST["folderID"];
    $form = $_POST["form"];
	$dir="../uploads/$folderID/$form"; 
	$files = scandir($dir);
	foreach($files as $file)
	{
		if($file == "." || $file == ".." || $file == ".DS_Store")
			continue;
		$filePath=$dir."/".$file;
		$details = array();
		$details['name']=$file;
		$details['path']=$filePath;
		$details['size']=filesize($filePath);
		$ret[] = $details;
	}
}

echo json_encode($ret);
?>