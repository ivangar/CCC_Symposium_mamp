<?php
session_start();  //ALWAYS START SESSION
$output_dir = "../uploads/";

if(isset($_SESSION['temp_dir']) && !empty($_SESSION['temp_dir'])){
    $output_dir .= $_SESSION['temp_dir']."/";
}

if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	$subdirectory = $_POST['subdirectory'];
	$fileName =$_POST['name'];
	$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files	
	$filePath = $output_dir.$subdirectory."/".$fileName;
	if (file_exists($filePath)) 
	{
        unlink($filePath);
    }
	echo "Deleted File ".$fileName."<br>";
}
?>