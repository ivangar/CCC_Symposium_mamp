<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/PasswordHash.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
/**
 * Class Password
 *
 * An entire php application with user registration, login and logout in one file.
 * Uses very modern password hashing via the PHP 5.5 password hashing functions.
 * This project includes a compatibility file to make these functions available in PHP 5.3.7+ and PHP 5.4+.
 */
class Password
{
    /**
     * @var string Type of used database (currently only SQLite, but feel free to expand this with mysql etc)
     */
    private $db_type = "sqlite"; //

    /**
     * @var string Path of the database file (create this with _install.php)
     */
    private $db_sqlite_path = "../repzone.db";

    /**
     * @var object Database connection
     */
    private $db_connection = null;

    /**
     * @var bool Login status of user
     */
    private $password_status = false;

    /**
     * @var string System messages, likes errors, notices, etc.
     */
    public $feedback = "";

    /**
     * @var password from the POST array
     */
    private $pwd = "";

    /**
     * @var password from the POST array
     */
    private $user_email = "";


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

        // check for possible user interactions (login with session/post data or logout)
        $this->processRequest();
    }

    /**
     * Creates a PDO database connection (in this case to a SQLite flat-file database)
     * @return bool Database creation success status, false by default
     */
    private function createDatabaseConnection()
    {
        try {
            $this->db_connection = new PDO($this->db_type . ':' . $this->db_sqlite_path);
            $this->db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            $this->feedback = "PDO database connection problem: " . $e->getMessage();
            echo $this->feedback; 
        } catch (Exception $e) {
            $this->feedback = "General problem: " . $e->getMessage();
            echo $this->feedback; 
        }
         return false;
    }

    /**
     * Handles the flow of the login/logout process. According to the circumstances, a logout, a login with session
     * data or a login with post data will be performed
     */
    private function processRequest()
    {
        if(isset($_POST["login_submitted"])) {
            $this->processPassword();
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
    private function processPassword()
    {
        if ($this->checkFormDataNotEmpty()) {
            if ($this->createDatabaseConnection()) {
                if($this->validatePassword())
                {
                    return true;
                } 

            }
            else{
                return false;
            }
            
        }

        return false;
    }

    /**
     * Validates the login form data, checks if username and password are provided
     * @return bool Login form data check success state
     */
    private function checkFormDataNotEmpty()
    {
        if (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            return true;
        } elseif (empty($_POST['user_name'])) {
            $this->feedback = "Username field is empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->feedback = "Password field is empty.";
            # code...
        }
        // default return
        return false;
    }

    /**
     * Checks if user exits, if so: check if provided password matches the one in the database
     * @return bool User login success status
     */
    private function validatePassword()
    {
        $this->pwd = htmlspecialchars($_POST['user_password']);
        $this->user_email = htmlspecialchars($_POST['user_name']);

        if( strcmp($this->user_email,"admin@sta.ca") == 0 ){
            $admin_login = true;
            $sql =  "SELECT user_password, hash_salt FROM password WHERE id = 2 LIMIT 1";  
        }

        else{
            $sql =  "SELECT user_password, hash_salt FROM password WHERE id = 1 LIMIT 1";           
        }

        $query = $this->db_connection->prepare($sql);
        $query->execute();

        $result_row = $query->fetchObject();

        if ($result_row) {
            // using PHP 5.5's password_verify() function to check password

            if($this->ValidateHashSalt($this->pwd, $result_row->user_password, $result_row->hash_salt))
            {   
                $this->password_status = true;
                if($admin_login) { $_SESSION['repzone_admin'] = true; }
                $this->feedback = 'continue';
                return true;
            } else {
                $this->feedback = "Wrong password.";
            }
        } else {
            $this->feedback = "Cannot validate password";
        }
        // default return
        return false;
    }

    /**
     * Simply returns the current status of the user's login
     * @return bool User's login status
     */
    public function getPwdStatus()
    {
        return $this->password_status;
    }

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
    $application = new Password();
}
