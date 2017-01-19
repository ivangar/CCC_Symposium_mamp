<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start(); // Turn on output buffering. From this point output is stored in an internal buffer 

$upload = new UploadFile();

/**
 * The UploadFile class
 */
class UploadFile {
    /**
     * Main directory to upload files
     */
    public $output_dir = "../uploads/";

    /**
     * Temporary directory to upload files before submitting the event
     */
    public $temp_dirPath = "";    

    /**
     * Temporary directory to upload files before submitting the event
     */
    public $static_dirPath = "";    

    /**
     * String to contain error messages
     */
    public $error_message = '';

    /**
     * Array containing the file names to upload
     */
    public $files = array("COI", "honorarium", "signin", "evaluation");

    /**
     * Current file that is being uploaded
     */  
    public $file = '';

    /**
     * Subdirectory for each form
     */
    public $sub_dir = "";    


    /**
     * Constructor initializes database
     */
    public function __construct()
    {
        $this->executeUpload();
    }

    public function executeUpload()
    {
        $this->startSession();
        $this->setFileName();
        fb($this->file, ' $this->file ');
        fb($this->sub_dir, ' $this->sub_dir ');
        
        if(isset($_GET['update']) && $_GET['update']){
            fb('updating baby');
            fb($_GET, ' GET array ');
            if($this->makeFinalDir()){
                $this->temp_dirPath = $this->static_dirPath;  //in order to use the functions checkFileExists() and upload(), we need to set the temporary directory to the static dir
            }

            else{  echo json_encode($this->error_message); } //couldn't make the static directory
        }
        else{
            $this->makeTempDir();
        }

        if(!$this->checkFileExists()){
            $return = $this->upload();
            echo json_encode($return);
        }

        else{ echo json_encode($this->error_message); }
    }

    private function startSession()
    {
        session_start();
    }

    private function setFileName()
    {   
        foreach ($this->files as $i => $form) {
            if(isset($_FILES[$form])){
                $this->file = $_FILES[$form];
                $this->sub_dir = $form;
            }
        }
    }

    private function makeTempDir()
    {
        //unset($_SESSION['temp_dir']);
        
        if($this->getTempDirSession()){
            $tmp_dir = $_SESSION['temp_dir'];
            $this->makeSubDir($tmp_dir);
            $this->temp_dirPath = $this->output_dir.$tmp_dir."/".$this->sub_dir."/";
        }

        else{
            $tmp_dir = substr(strrchr($this->file["tmp_name"], "/"), 1);
            $this->setTempDirSession($tmp_dir);
            $this->temp_dirPath = $this->output_dir.$tmp_dir;
            mkdir($this->temp_dirPath, 0777, true);   //This function will create a folder structure like this: uploads/phprCqHx3
            $this->makeSubDir($tmp_dir);
            $this->temp_dirPath .= "/".$this->sub_dir."/";            
        }fb($_SESSION['temp_dir'], ' temporary dir session ');
    }

    private function makeFinalDir()
    {
        $this->static_dirPath = $this->output_dir.$_GET['folderID']."/".$this->sub_dir."/";

        if($this->checkDirExists()){
            return true;
        }

        else{
            if($this->makeConstantSubdir()){
                return true;
            }
            else{
                $this->setError('The directory for the ' . $this->sub_dir . ' form could not be created');
                return false;
            }
        }
    }

    /*
     * This function will create a folder structure like this: uploads/phprCqHx3/COI
    */
    private function makeSubDir($tmp_dir)
    {
        $sub_directory = $this->output_dir.$tmp_dir."/".$this->sub_dir."/";
        mkdir($sub_directory, 0777, true);
    }

    /*
     * This function will create a folder structure like this: uploads/26_19/COI
    */
    private function makeConstantSubdir()
    {
        $sub_directory = $this->output_dir.$_GET['folderID']."/".$this->sub_dir."/";
        return mkdir($sub_directory, 0777, true);
    }

    private function setTempDirSession($tmp_dir_name)
    {
        $_SESSION['temp_dir'] = $tmp_dir_name;
    }

    public function getTempDirSession()
    {
        if(isset($_SESSION['temp_dir']) && !empty($_SESSION['temp_dir'])){
            return true;
        }

        else return false;
    }

    public function upload()
    {

        if(isset($this->file))
        {
            $ret = array();
            $fileName = $this->file["name"];
            move_uploaded_file($this->file["tmp_name"],$this->temp_dirPath.$fileName);
            $ret[]= $fileName;
            return $ret;
         }

    }

    public function checkFileExists(){
        $file = $this->file["name"];
        $path = $this->temp_dirPath;
        $target_file = $path.$file;

        if (file_exists($target_file)) { 
            $this->setError('File already exists');
            return true; 
        } 
        else {return false;} 

    }

    public function checkDirExists(){

        $folder = UPLOAD_DIR.$_GET['folderID']."/".$this->sub_dir."/";

        if (file_exists($folder) && is_dir($folder)) { 
            return true;
        } 

        else return false;

    }

    public function setError($error_str){
        $this->error_message= array();
        $this->error_message['jquery-upload-file-error']="$error_str";
    }

}

ob_flush(); //This function will send the contents of the output buffer
?>