<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
/**
 * Class Login
 *
 * An entire php application with user registration, login and logout in one file.
 * Uses very modern password hashing via the PHP 5.5 password hashing functions.
 * This project includes a compatibility file to make these functions available in PHP 5.3.7+ and PHP 5.4+.
 */

class Repzone
{
    /**
     * @var object Database connection
     */
    private $db_connection = null;

    /**
     * @var object Database connection
     */
    public $login_user = '';

    /**
     * @var bool Login status of user
     */
    private $user_is_logged_in = false;

    /**
     * @var bool Login status of user
     */
    private $hash_salt = "";

    /**
     * @var string System messages, likes errors, notices, etc.
     */
    public $feedback = "";

    /**
     * Does necessary checks for PHP version and PHP password compatibility library and runs the application
     */
    public function __construct()
    {
        $this->runApplication();
    }

    /**
     * This is basically the controller that handles the entire flow of the application.
     */
    public function runApplication()
    { 
        $this->doStartSession();
        $this->userAccess();

        if(!$this->user_is_logged_in){$this->RedirectToURL("../login.html");}
        if(isset($_SESSION['temp_dir']) && !empty($_SESSION['temp_dir'])){ $this->remove_temp_dir(); }
    }

    private function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }

    /**
     * Handles the flow of the login/logout process. According to the circumstances, a logout, a login with session
     * data or a login with post data will be performed
     */
    private function userAccess()
    {   
        if(isset($_COOKIE['remember_repzone']) && !empty($_COOKIE['remember_repzone']) ){ $this->user_is_logged_in = true; }
        if(isset($_SESSION['rep_zone_user']) && !empty($_SESSION['rep_zone_user'])) { $this->user_is_logged_in = true; }
    }

    /**
     * Simply starts the session.
     * It's cleaner to put this into a method than writing it directly into runApplication()
     */
    private function doStartSession()
    {
        if(!isset($_SESSION)){session_start();}  
    }

    public function LogOut()
    {   
        if(isset($_COOKIE['remember_repzone'])){setcookie('remember_repzone', "", time() - 3600, "/", ".dxlink.ca", 1,1);}
        if(isset($_SESSION["repzone_admin"])){ unset($_SESSION["repzone_admin"]); }
        unset($_SESSION['rep_zone_user']);
    }

    public function remove_temp_dir()
    {   
        $folder = UPLOAD_DIR.$_SESSION['temp_dir'];

        if (file_exists($folder) && is_dir($folder)) { 
            $this->delTree($folder);
            unset($_SESSION['temp_dir']);
        } 
         
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
          (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}

$repzone = new Repzone();

if(isset($_POST['action']))
{
    $action = $_POST['action'];
    if(strcmp($action,'logout') == 0) {$repzone->Logout();}
}
