<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
session_start();
ob_start(); // Turn on output buffering. From this point output is stored in an internal buffer 


$output_dir = "../uploads/";
$error = '';
$files = array("COI", "honorarium", "hello", "world");
$file = '';

foreach ($files as $i => $string) {
    if(isset($_FILES[$string])){
        $file = $_FILES[$string];
    }
}

$tmp_name = substr(strrchr($file["tmp_name"], "/"), 1);
$temp_dir = $output_dir.$tmp_name;
mkdir($temp_dir, 0777, true);
$temp_dir .= "/";

fb($temp_dir, ' temporary directory ');
fb($file, ' FILE ');

if(isset($file))
{
    $ret = array();
    
//  This is for custom errors;  
/*  $custom_error= array();
    $custom_error['jquery-upload-file-error']="File already exists";
    echo json_encode($custom_error);
    die();
*/
    $error =$file["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if(!is_array($file["name"])) //single file
    {
            $fileName = $file["name"];
            move_uploaded_file($file["tmp_name"],$temp_dir.$fileName);
            $ret[]= $fileName;
    }
    else  //Multiple files, file[]
    {
          $fileCount = count($file["name"]);
          for($i=0; $i < $fileCount; $i++)
          {
            $fileName = $file["name"][$i];
            move_uploaded_file($file["tmp_name"][$i],$temp_dir.$fileName);
            $ret[]= $fileName;
          }
    
    }
    echo json_encode($ret);
 }

 function checkFileExists($target_file){
    if (file_exists($target_file)) { return true; } 
    else {return false;} 
 }

function setError($error_str){
    $custom_error= array();
    $custom_error['jquery-upload-file-error']="$error_str";
    echo json_encode($custom_error);
 }

 ?>