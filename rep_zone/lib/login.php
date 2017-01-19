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


function createDatabaseConnection()
{
    try {
        $con = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset='. ENCODING, USER, PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    } catch (PDOException $e) {
        $con = "PDO database connection problem: " . $e->getMessage();
    } catch (Exception $e) {
        $con = "General problem: " . $e->getMessage();
    }

    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $con;
}

class Login
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
        // start the session, always needed!
        $this->doStartSession();
        $this->db_connection = createDatabaseConnection(); // get database connection credentials

        // check for possible user interactions (login with session/post data or logout)
        $this->performUserLoginAction();
    }

    /**
     * Handles the flow of the login/logout process. According to the circumstances, a logout, a login with session
     * data or a login with post data will be performed
     */
    private function performUserLoginAction()
    {

        if (isset($_POST["login_submitted"])) {
            $this->login_user = htmlspecialchars($_POST["user_name"]);
            $this->doLoginWithPostData();
            echo $this->feedback; 
        }
    }

    /**
     * Simply starts the session.
     * It's cleaner to put this into a method than writing it directly into runApplication()
     */
    private function doStartSession()
    {
        session_start();
    }

    /**
     * Process flow of login with POST data
     */
    private function doLoginWithPostData()
    {
        if ($this->checkLoginFormDataNotEmpty()) {
                if($this->getUser())
                {
                    fb($_SESSION);
                    return true;
                }
                
        }

        return false;
    }

    /**
     * Validates the login form data, checks if username and password are provided
     * @return bool Login form data check success state
     */
    private function checkLoginFormDataNotEmpty()
    {
        $empty = false;

        $empty = (empty($this->login_user)) ? false : true;

        return $empty;
    }

    /**
     * Checks if user exits, if so: check if provided password matches the one in the database
     * @return bool User login success status
     */
    private function getUser()
    {
        $uname = strtolower($this->login_user);

        // remember: the user can log in with username or email address
        $sql =  "SELECT rep_id
                FROM reps
                WHERE email = :user_name
                LIMIT 1";

        $query = $this->db_connection->prepare($sql);
        $query->bindValue(':user_name', $uname);
        $query->execute();

        $result_row = $query->fetchObject();

        if ($result_row) {
            // using PHP 5.5's password_verify() function to check password
             
            $_SESSION['rep_zone_user'] = $result_row->rep_id;
            $this->rememberUser($result_row->rep_id);
            $this->user_is_logged_in = true;
            $this->feedback = 'access';
            return true;
            
        } else {
            //Redirect to registration page
            $this->feedback = 'register';
        }
        // default return
        return false;
    }

    /**
     * Check remember me submission and set a cookie
     */
    public function rememberUser($user_id){
        
        //Modify and make cookie more secure
        $cookie = $user_id;
        setcookie('remember_repzone', $cookie, time() + (86400 * 150),"/", ".dxlink.ca", 1,1);//Cookie should be user:random_key:keyed_hash

    }

    /**
     * Simply returns the current status of the user's login
     * @return bool User's login status
     */
    public function getUserLoginStatus()
    {
        return $this->user_is_logged_in;
    }

    /**
     * This function may be used (if modified) to generate a hash value, and token, for saving the cookie
     * @return bool User's login status
     */
    private function ValidateHashSalt($pass, $hash, $salt){
        $Passhash = new PasswordHash();
        $hashArray = $Passhash->Create_Custom_Hash($hash, $salt);
        if($Passhash->validate_password($pass, $hashArray)){
            return true;
        }

        else return false;
    }
}

if(isset($_POST['login_submitted']))
{
    // run the application
    $application = new Login();
}
