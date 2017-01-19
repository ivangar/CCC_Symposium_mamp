<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/formvalidator.php");


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

class Register
{
    /**
     * @var object Database connection
     */
    private $db_connection = null;

    /**
     * @var object Database connection
     */
    public $user_id = 0;

    /**
     * @var bool Login status of user
     */
    private $hash_salt = "";

    /**
     * @var string System messages, likes errors, notices, etc.
     */
    public $feedback = "";

    /**
     * @var string if POST vars
     */
    public $data = array();


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
        $this->userRegistration();
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
    private function userRegistration()
    {
        if ($this->validateEmpty()) {
              echo $this->feedback;
              return false;
        }
         
        else{
            if($this->registerUser())
                {   
                    $this->setUserId();
                    echo $this->feedback;
                    return true;
                }
        }
        
    }

    /**
     * Validates the login form data, checks if username and password are provided
     * @return bool Login form data check success state
     */
    private function validateEmpty()
    {

        $empty = false;

        //Instanciate new Form Validator object and set validations
        $validator = new FormValidator();
        $validator->addValidation("rep_name","req","Please fill in your name *");
        $validator->addValidation("rep_company","req","Please fill in your company name *");
        $validator->addValidation("rep_email","email","The input for Email should be a valid email value *");
        $validator->addValidation("rep_email","req","Please fill in Email *");
        $validator->addValidation("rep_phone","req","Please fill in your phone number *");

        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $this->feedback .= $inp_err . "<br>";
            }

            $empty = true;
        }

  
        return $empty;
    }

    /**
     * Checks if user exits, if so: check if provided password matches the one in the database
     * @return bool User login success status
     */
    private function registerUser()
    {
        $this->compileData();
        
        $insert_query = "INSERT INTO reps (rep_name, company, email, phone) VALUES (:rep_name,:company,:email,:phone)";
        $query = $this->db_connection->prepare($insert_query);
        
        $query->execute(array(':rep_name'=>$this->data["rep_name"],
                  ':company'=>$this->data["rep_company"],
                  ':email'=>$this->data["rep_email"],
                  ':phone'=>$this->data["rep_phone"]                 
                  ));

        $this->user_id = $this->db_connection->lastInsertId();
        $this->feedback = "registered";

        return true;
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
     * Set the session with user ID
     * @return bool User's login status
     */
    public function setUserId()
    {
        if (isset($this->user_id) && !empty($this->user_id)) { $_SESSION['rep_zone_user'] = $this->user_id; $this->rememberUser($this->user_id); }
    }

    private function compileData()
    {
        $this->data["rep_name"] = htmlspecialchars($_POST["rep_name"]);
        $this->data["rep_company"] = htmlspecialchars($_POST["rep_company"]);
        $this->data["rep_email"] = htmlspecialchars($_POST["rep_email"]);
        $this->data["rep_phone"] = htmlspecialchars($_POST["rep_phone"]);
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

if(isset($_POST["register_submitted"]))
{
    // run the application
    $application = new Register();
}
