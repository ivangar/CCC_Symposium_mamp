<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/formvalidator.php");

/*
** This file is used to update an already submitted event.  It is called from update_event.js from the page "My Events -> Event clicked"
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

class UpdateEvent
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
     * @var event ID
     */
    private $event_ID = 0;

    /**
     * @var current agenda ID for the event ID
     */
    private $agenda_ID = NULL;    

    /**
     * @var current moderator ID for the event ID
     */
    private $moderator_ID = NULL;    

    /**
     * @var current moderator ID for the event ID
     */
    private $address_ID = NULL;  

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
        $this->setEventInfo();

        $this->processEvent();
    }

    public function setEventInfo()
    {
        $this->event_ID = $_POST["eventID"];
        $this->agenda_ID = $_POST["agendaID"];
        $this->moderator_ID = $_POST["moderatorID"];
        $this->address_ID = $_POST["addressID"];
        $_POST = $_POST["fields"];
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
     * Process event
     */
    private function processEvent()
    {
        if ($this->validateEmpty()) {
              echo $this->feedback;
              return false;
        }

        $this->compileData();  //Compile all fields from $_POST

        if(!$this->eventSectionsExist()){
            $this->registerMissingSection();
        }

        if($this->updateEvent()){  
            $_SESSION['updated'] = true;
            echo $this->feedback;
            return true;
        }

    }

    public function eventSectionsExist(){
        if( !empty($this->agenda_ID) && !empty($this->moderator_ID) && !empty($this->address_ID) )
        { 
            return true;
        }

        else return false;
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
        $validator->addValidation("program_start_time","req","Please fill in the program start time *");
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
        //$validator->addValidation("moderator_fax","req","Please fill in the moderator's fax number *");
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

        return $empty;
    }

    /**
     * Check which ID is missing and register corresponding event section (in case these sections were not registered initially)
     */
    private function registerMissingSection(){
        if(empty($this->agenda_ID)){
            $this->agenda_ID = $this->registerAgenda();
        }

        if(empty($this->address_ID)){
            $this->address_ID = $this->registerModeratorAddress();
        }

        if(empty($this->moderator_ID)){
            $this->moderator_ID = $this->registerModerator();
        }

        return true;
    }

    /**
     * Update Event and all sections related to it
     * @return bool User login success status
     */
    private function updateEvent()
    {   
        $this->updateAgenda();
        $this->updateModeratorAddress();
        $this->updateModerator();

        $update_query = "UPDATE events SET event_date = :event_date, event_time = TIME( STR_TO_DATE( :event_time, '%h:%i %p' ) ), location = :location, attendees = :attendees, catering = :catering, agenda_id = :agenda_id, moderator_id = :moderator_id
                         WHERE event_id = :event_id AND rep_id = :rep_id";
        $query = $this->db_connection->prepare($update_query);
        $query->execute(array(':event_date'=>$this->event_data["eventDate"],
                              ':event_time'=>$this->event_data["eventTime"],
                              ':location'=>$this->event_data["eventLocation"],
                              ':attendees'=>$this->event_data["attendees"],
                              ':catering'=>$this->event_data["event_catering"], 
                              ':agenda_id'=>$this->agenda_ID,
                              ':moderator_id'=>$this->moderator_ID,
                              ':event_id'=>$this->event_ID,                         
                              ':rep_id'=>$this->user,

                        ));

        $this->feedback = "submitted";

        return true;
    }

    /**
     * Registers Agenda
     * @return int of last ID inserted
     */
    private function registerAgenda()
    {

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
     * Updates Agenda
     */
    private function updateAgenda()
    {

        $update_query = "UPDATE agendas SET arrrival_meal_time = TIME( STR_TO_DATE( :arrrival_time, '%h:%i %p' ) ), program_start_time = TIME( STR_TO_DATE( :program_start_time, '%h:%i %p' ) ), QA_time = TIME( STR_TO_DATE( :qa_time, '%h:%i %p' ) ), program_end_time = TIME( STR_TO_DATE( :end_time, '%h:%i %p' ) )
                         WHERE agenda_id = :agendaId";
        $query = $this->db_connection->prepare($update_query);
        $query->execute(array(':arrrival_time'=>$this->event_data["arrrival_time"],
                              ':program_start_time'=>$this->event_data["program_start_time"],
                              ':qa_time'=>$this->event_data["qa_time"],
                              ':end_time'=>$this->event_data["end_time"],
                              ':agendaId'=>$this->agenda_ID
                        ));

        return true;
    }

    /**
     * Registers Moderator
     * @return int of last ID inserted
     */
    private function registerModerator()
    {

        $insert_query = "INSERT INTO moderators (mod_name, mod_credentials, mod_email, mod_institution, address_id) VALUES (:name, :credentials, :email, :institution, :address_id)";
        $query = $this->db_connection->prepare($insert_query);
        $query->execute(array(':name'=>$this->event_data["moderator_name"],
                              ':credentials'=>$this->event_data["moderator_credentials"],
                              ':email'=>$this->event_data["moderator_email"],
                              ':institution'=>$this->event_data["moderator_institution"],
                              ':address_id'=>$this->address_ID
                        ));
        $mod_ID = $this->db_connection->lastInsertId();

        return $mod_ID;
    }

    /**
     * Update Moderator
     */
    private function updateModerator()
    {
        $update_query = "UPDATE moderators SET mod_name = :name, mod_credentials = :credentials, mod_email = :email, mod_institution = :institution, address_id = :address_id
                         WHERE moderator_id = :moderator_id";
        $query = $this->db_connection->prepare($update_query);
        $query->execute(array(':name'=>$this->event_data["moderator_name"],
                              ':credentials'=>$this->event_data["moderator_credentials"],
                              ':email'=>$this->event_data["moderator_email"],
                              ':institution'=>$this->event_data["moderator_institution"],
                              ':address_id'=>$this->address_ID,
                              ':moderator_id'=>$this->moderator_ID
                        ));

        return true;
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
     * Update Moderator's full address
     */
    private function updateModeratorAddress()
    {
        $update_query = "UPDATE address SET street_address = :street_address, suite = :suite, city = :city, province = :province, postal_code = :postal_code, telephone = :phone, fax = :fax
                         WHERE address_id = :addressID";
        $query = $this->db_connection->prepare($update_query);
        $query->execute(array(':street_address'=>$this->event_data["moderator_street"],
                              ':suite'=>$this->event_data["moderator_suite"],
                              ':city'=>$this->event_data["moderator_city"],
                              ':province'=>$this->event_data["moderator_province"],
                              ':postal_code'=>$this->event_data["moderator_pc"],
                              ':phone'=>$this->event_data["moderator_phone"],
                              ':fax'=>$this->event_data["moderator_fax"],
                              ':addressID'=>$this->address_ID
                        ));

        return true;
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
        $this->event_data["moderator_street"] = htmlspecialchars($_POST["moderator_street"]);
        (!empty($_POST["moderator_suite"])) ? $this->event_data["moderator_suite"] = htmlspecialchars($_POST["moderator_suite"]) : $this->event_data["moderator_suite"] = NULL;
        $this->event_data["moderator_city"] = htmlspecialchars($_POST["moderator_city"]);
        $this->event_data["moderator_province"] = htmlspecialchars($_POST["moderator_province"]);
        $this->event_data["moderator_pc"] = htmlspecialchars($_POST["moderator_pc"]);
        $this->event_data["moderator_phone"] = htmlspecialchars($_POST["moderator_phone"]);
        (!empty($_POST["moderator_fax"])) ? $this->event_data["moderator_fax"] = htmlspecialchars($_POST["moderator_fax"]) : $this->event_data["moderator_suite"] = NULL;        
    }

}

if(isset($_POST["update"]))
{
    // run the application
    $application = new UpdateEvent();
}
