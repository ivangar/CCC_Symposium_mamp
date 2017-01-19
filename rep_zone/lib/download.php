<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start(); // Turn on output buffering. From this point output is stored in an internal buffer 

/*
** This file is used to download the temporary file that is being uploaded. It is called from the file update_event.js for each of the 4 forms.
** update_event.js is called from rep_zone/pages/myevent.php
*/

if(isset($_GET['filename']))
{
    $fileName=$_GET['filename'];
    if(isset($_GET['folderID'])){ $folderID = $_GET['folderID']; }
    if(isset($_GET['form'])){ $form = $_GET['form']; }
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $file = "../uploads/$folderID/$form/".$fileName;
    /*$file = str_replace("..","",$file);*/
    if (file_exists($file)) {
    	$fileName =str_replace(" ","",$fileName);
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.$fileName);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }

}
?>