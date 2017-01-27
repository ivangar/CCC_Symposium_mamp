<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/formvalidator.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/php/swift/swift_required.php');

/*
** This file is used to register a "New Event" and is called by Ajax from event.js
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
    public $user = 0;

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
     * @var the new inserted moderator ID
     */
    public $moderator_ID = 0;

    /**
     * @var the new inserted moderator ID
     */
    public $event_ID = 0;

    /**
     * @var array holding all data from $_POST
     */
    public $event_data = array();

    /**
     * @var public directory of upload files
     * The root directory for local server is "/Applications/MAMP/htdocs/dxlink/programs/CCC_Symposium/rep_zone/uploads/" and the root directory for remote server
     * is "/var/www/clients/client3/web13/web/programs/CCC_Symposium/rep_zone/uploads/"
     */    

    public $upload_dir = UPLOAD_DIR;

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
        $this->getUserId();

        // check for possible user interactions (login with session/post data or logout)
        $this->processEvent();

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
    private function processEvent()
    {
         
        if ($this->validateEmpty()) {
              echo $this->feedback;
              return false;
        }
        
        else{
            if($this->registerEvent()){   
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
        $validator->addValidation("eventDate","req","Please fill in the event date *");
        $validator->addValidation("eventTime","req","Please fill in the event time *");
        $validator->addValidation("eventLocation","req","Please fill in the event location *");
        $validator->addValidation("attendees","req","Please fill in the attendees *");
        $validator->addValidation("attendees","num","Please type a number *");
        $validator->addValidation("attendees","gt=0", "The attendes should be greater than 0 *");
        $validator->addValidation("arrrival_time","req","Please fill in the arrivals and meal time *");
        //added for program start time:
        $validator->addValidation("program_start_time","req","Please fill in the program start time");
        //
        $validator->addValidation("qa_time","req","Please fill in the Q&A time *");
        $validator->addValidation("end_time","req","Please fill in the Program end time *");
        $validator->addValidation("moderator_name","req","Please fill in the moderator's full name *");
        $validator->addValidation("moderator_credentials","req","Please fill in the moderator's credentials *");
        $validator->addValidation("moderator_email","req","Please fill in the moderator's email *");
        $validator->addValidation("moderator_email","email","moderator's email should be a valid email value *");
        $validator->addValidation("moderator_institution","req","Please fill in the moderator's institution *");
        $validator->addValidation("moderator_street","req","Please fill in the moderator's full street address *");
        $validator->addValidation("moderator_city","req","Please fill in the moderator's city address *");
        $validator->addValidation("moderator_province","req","Please fill in the moderator's Province *");
        $validator->addValidation("moderator_pc","req","Please fill in the moderator's postal code *");
        $validator->addValidation("moderator_phone","req","Please fill in the moderator's phone number *");
        //validator->addValidation("moderator_fax","req","Please fill in the moderator's fax number *");
        $validator->addValidation("event_catering","req","Please fill in the catering amount *");

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

        if(!$this->validateCOI()){
            $this->feedback .= "Please upload the CCS Conflict of Interest Form *<br>";
            $empty = true;
        }

        return $empty;
    }


    private function validateCOI()
    {
        if(isset($_SESSION['temp_dir']) && !empty($_SESSION['temp_dir'])){
            $tmp_dir = $_SESSION['temp_dir'];
            $dir = $this->upload_dir.$tmp_dir."/COI";     

            if($this->checkFolderIsEmptyOrNot($dir)){
                return true;
            }
        }

        else return false;
    }

    public function checkFolderIsEmptyOrNot ( $folderName ){
        $files = array ();
        if ( $handle = opendir ( $folderName ) ) {
            while ( false !== ( $file = readdir ( $handle ) ) ) {
                if ( $file != "." && $file != ".." && $file != ".DS_Store")
                    $files[] = $file;
                if(count($files) >= 1)
                    break;
            }
            closedir ( $handle );
        }
        return ( count ( $files ) > 0 ) ? TRUE: FALSE;
    }    

    /**
     * Checks if user exits, if so: check if provided password matches the one in the database
     * @return bool User login success status
     */
    private function registerEvent()
    {

        $this->compileData();

        $agenda_id = $this->registerAgenda();
        $mod_address_id = $this->registerModeratorAddress();
        $mod_id = $this->registerModerator($mod_address_id);
        $status = 'pending';

        $insert_query = "INSERT INTO events (event_date, event_time, location, attendees, catering, rep_id, agenda_id, moderator_id, status) VALUES (:event_date,TIME( STR_TO_DATE( :event_time, '%h:%i %p' ) ), :location, :attendees, :catering, :rep_id, :agenda_id, :moderator_id, :status)";
        $query = $this->db_connection->prepare($insert_query);
        $query->execute(array(':event_date'=>$this->event_data["eventDate"],
                              ':event_time'=>$this->event_data["eventTime"],
                              ':location'=>$this->event_data["eventLocation"],
                              ':attendees'=>$this->event_data["attendees"],
                              ':catering'=>$this->event_data["event_catering"],                             
                              ':rep_id'=>$this->user,
                              ':agenda_id'=>$agenda_id,
                              ':moderator_id'=>$mod_id,
                              ':status'=>$status        
                        ));

        $this->event_ID = $this->db_connection->lastInsertId();
        $new_dir = $this->renameDir();
        $this->saveFolderID($new_dir);
        $this->feedback = "submitted";
        $this->send_email_alert();

        return true;
    }

    /**
     * Registers Agenda
     * @return int of last ID inserted
     */
    private function registerAgenda()
    {
        //added program start time 
        $insert_query = "INSERT INTO agendas (arrrival_meal_time, program_start_time, QA_time, program_end_time) VALUES ( TIME( STR_TO_DATE( :arrrival_time, '%h:%i %p' ) ), TIME( STR_TO_DATE( :program_start_time, '%h:%i %p' ) ), TIME( STR_TO_DATE( :qa_time, '%h:%i %p' ) ), TIME( STR_TO_DATE( :end_time, '%h:%i %p' ) ) )";
        $query = $this->db_connection->prepare($insert_query);
        $query->execute(array(':arrrival_time'=>$this->event_data["arrrival_time"],
                              ':program_start_time'=>$this->event_data["program_start_time"],
                              ':qa_time'=>$this->event_data["qa_time"],
                              ':end_time'=>$this->event_data["end_time"]
                        ));
        $agenda_ID = $this->db_connection->lastInsertId();

        return $agenda_ID;
    }

    /**
     * Registers Moderator
     * @return int of last ID inserted
     */
    private function registerModerator($address_id)
    {

        $insert_query = "INSERT INTO moderators (mod_name, mod_credentials, mod_email, mod_institution, honorarium, address_id) VALUES (:name, :credentials, :email, :institution, :honorarium, :address_id)";
        $query = $this->db_connection->prepare($insert_query);
        $query->execute(array(':name'=>$this->event_data["moderator_name"],
                              ':credentials'=>$this->event_data["moderator_credentials"],
                              ':email'=>$this->event_data["moderator_email"],
                              ':institution'=>$this->event_data["moderator_institution"],
                              ':honorarium'=>$this->event_data["moderator_honorarium"],
                              ':address_id'=>$address_id
                        ));
        $mod_ID = $this->db_connection->lastInsertId();
        $this->moderator_ID = $mod_ID;

        return $mod_ID;
    }


    /**
     * Registers Moderator's full address
     * @return int of last ID inserted
     */
    private function registerModeratorAddress()
    {
        $insert_query = "INSERT INTO address (street_address, suite, city, province, postal_code, telephone, fax) VALUES (:street_address, :suite, :city, :province, :postal_code, :phone, :fax)";
        $query = $this->db_connection->prepare($insert_query);
        $query->execute(array(':street_address'=>$this->event_data["moderator_street"],
                              ':suite'=>$this->event_data["moderator_suite"],
                              ':city'=>$this->event_data["moderator_city"],
                              ':province'=>$this->event_data["moderator_province"],
                              ':postal_code'=>$this->event_data["moderator_pc"],
                              ':phone'=>$this->event_data["moderator_phone"],
                              ':fax'=>$this->event_data["moderator_fax"]                                              
                        ));
        
        $address_ID = $this->db_connection->lastInsertId();

        return $address_ID;
    }

    /**
     * Simply returns the current status of the user's login
     * @return bool User's login status
     */
    public function getUserId()
    {
        if (isset($_COOKIE['remember_repzone']) && !empty($_COOKIE['remember_repzone'])) { $this->user = $_COOKIE['remember_repzone']; $this->user_is_logged_in = true; }
        elseif (isset($_SESSION['rep_zone_user']) && !empty($_SESSION['rep_zone_user'])) { $this->user = $_SESSION['rep_zone_user']; $this->user_is_logged_in = true; }
    }

    private function compileData()
    {
        $this->event_data["eventTime"] = htmlspecialchars($_POST["eventTime"]);
        $this->event_data["eventDate"] = htmlspecialchars($_POST["eventDate"]);
        $this->event_data["eventLocation"] = htmlspecialchars($_POST["eventLocation"]);
        $this->event_data["attendees"] = htmlspecialchars($_POST["attendees"]);
        $this->event_data["arrrival_time"] = htmlspecialchars($_POST["arrrival_time"]);
        //added program start time
        $this->event_data["program_start_time"] = htmlspecialchars($_POST["program_start_time"]);
        //
        $this->event_data["qa_time"] = htmlspecialchars($_POST["qa_time"]);
        $this->event_data["end_time"] = htmlspecialchars($_POST["end_time"]); 
        $this->event_data["event_catering"] = htmlspecialchars($_POST["event_catering"]);   
        $this->event_data["moderator_name"] = htmlspecialchars($_POST["moderator_name"]);
        $this->event_data["moderator_credentials"] = htmlspecialchars($_POST["moderator_credentials"]);
        $this->event_data["moderator_email"] = htmlspecialchars($_POST["moderator_email"]);
        $this->event_data["moderator_institution"] = htmlspecialchars($_POST["moderator_institution"]);
        $this->event_data["moderator_honorarium"] = htmlspecialchars($_POST["moderator_honorarium"]);
        $this->event_data["moderator_street"] = htmlspecialchars($_POST["moderator_street"]);
        (!empty($_POST["moderator_suite"])) ? $this->event_data["moderator_suite"] = htmlspecialchars($_POST["moderator_suite"]) : $this->event_data["moderator_suite"] = NULL;
        $this->event_data["moderator_city"] = htmlspecialchars($_POST["moderator_city"]);
        $this->event_data["moderator_province"] = htmlspecialchars($_POST["moderator_province"]);
        $this->event_data["moderator_pc"] = htmlspecialchars($_POST["moderator_pc"]);
        $this->event_data["moderator_phone"] = htmlspecialchars($_POST["moderator_phone"]);
        //$this->event_data["moderator_fax"] = htmlspecialchars($_POST["moderator_fax"]);        
        (!empty($_POST["moderator_fax"])) ? $this->event_data["moderator_fax"] = htmlspecialchars($_POST["moderator_fax"]) : $this->event_data["moderator_suite"] = NULL;   
    }

    /**
     * Renames the temporary directory with the event and moderator IDs combined into a string
     * @return str of the new dir
     */
    private function renameDir()
    {
        $oldDir = UPLOAD_DIR . $_SESSION['temp_dir'];
        $newDir = $this->event_ID . '_' . $this->moderator_ID;
        $dirPath = UPLOAD_DIR . $this->event_ID . '_' . $this->moderator_ID;
        rename ($oldDir, $dirPath);
        unset($_SESSION['temp_dir']);
        return $newDir;
    }

    /**
     * Saves the new directory field in the events and moderators tables respectively
     */
    private function saveFolderID($folder_name)
    {
        if(isset($folder_name) && !empty($folder_name)){
          //Update folder id in the events table
          $update_event_query = "UPDATE events SET folder_id = :folder_id WHERE event_id = :event_id";
          $update_event = $this->db_connection->prepare($update_event_query);
          $update_event->execute(array(':folder_id'=>$folder_name,
                                ':event_id'=>$this->event_ID                                           
                        ));

          //Update folder id in the moderators table
          $update_moderator_query = "UPDATE moderators SET folder_id = :folder_id WHERE moderator_id = :moderator_id";
          $update_moderator = $this->db_connection->prepare($update_moderator_query);
          $update_moderator->execute(array(':folder_id'=>$folder_name,
                                ':moderator_id'=>$this->moderator_ID                                           
                        ));         
        }

    }

  private function send_email_alert(){

    $name = $this->Get_rep_name();
    $date = date("F j, Y, g:i a");   
    $body = "<h3>A new event has been created: </h3><h4>Event ID: {$this->event_ID} </h4><h4>Rep ID: {$this->user} ($name) </h4><h4>Event Date : {$this->event_data['eventDate']} </h4><h4>Event Location : {$this->event_data['eventLocation']} </h4><h4>Submitted on: $date</h4><h4>To view the event details, please login as the administrator with the following credentials:<br>site: <a href='https://dxlink.ca/programs/CCC_Symposium/rep_zone/login.html'>https://dxlink.ca/programs/CCC_Symposium/rep_zone/login.html</a><br>user: admin@sta.ca<br>password: sta_repzone</h4>";

        //setup the mailer
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -t -i');

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('dxLink Repzone - New Group Learning Session')
        ->setFrom(array('dxLink@sta.ca' => 'dxLink'))
        ->setTo(array('AmandaB@sta.ca' => 'Amanda Bell','ivang@sta.ca' => 'Ivan','DeannaC@sta.ca' => 'Deanna'))
        ->setBody($body, 'text/html')
        ;

        $result = $mailer->send($message);
        
        if(!$result)
        { return false; }
        
        return true; 
    }

    private function Get_rep_name(){

        $rep_name = '';
        $sql = "SELECT rep_name FROM reps WHERE rep_id = :rep_id";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':rep_id', $this->user);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $rep_name = $result_row['rep_name'];
        }

        $query = null;
        $this->db_connection = null;

        return $rep_name;
  }

}

if(isset($_POST["event_submitted"]))
{
    // run the application
    $application = new Register();
}
