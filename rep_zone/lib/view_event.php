<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/programs/CCC_Symposium/rep_zone/config/env_constants.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/formvalidator.php");

/*
** This file is used to load the information for the selected event for the current user (event ID of: user ID).  It is called from my_event.php ("My Events")
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

class ViewEvent
{
    /**
     * @var object Database connection
     */
    public $db_connection = null;

    /**
     * @var user ID
     */
    public $user = 0;

    /**
     * @var event ID
     */
    public $event_ID = 0;

    /**
     * @var current agenda ID for the event ID
     */
    public $agenda_ID = NULL;    

    /**
     * @var current moderator ID for the event ID
     */
    public $moderator_ID = NULL;    

    /**
     * @var current moderator ID for the event ID
     */
    public $address_ID = NULL;  

    /**
     * @var current folder ID containing the document uploads
     */
    public $folderID = NULL;

    /**
     * @var bool Login status of user
     */
    public $provinceList = "";

    /**
     * @var string System messages, likes errors, notifications, etc.
     */
    public $error_message = "";

    /**
     * @var array holding all event information from the DAtabase
     */
    public $event_info = array();

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
        $this->doStartSession();
        $this->db_connection = createDatabaseConnection();
        $this->getUserId();
        $this->getEventId();

        if (!$this->searchEvent()) {
            return false;
        }

        // check for possible user interactions (login with session/post data or logout)
        $this->getEventInfo();

    }

    /**
     * Simply starts the session.
     * It's cleaner to put this into a method than writing it directly into runApplication()
     */
    public function doStartSession()
    {
        session_start();
    }

    /**
     * Process flow of login with POST data
     */
    public function getEventInfo()
    {        
        $sql = "SELECT event_date, event_time, location, attendees, catering, agenda_id, moderator_id, folder_id FROM events WHERE event_id = :event_id";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':event_id', $this->event_ID);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $this->event_info[0] = $result_row['event_date'];
            $this->event_info[1] = $result_row['event_time'];
            $this->event_info[2] = $result_row['location'];
            $this->event_info[3] = $result_row['attendees'];
            $this->event_info[18] = $result_row['catering'];
            $this->folderID = $result_row['folder_id'];
            $this->agenda_ID = $result_row['agenda_id'];
            $this->moderator_ID = $result_row['moderator_id'];
            $this->getAgendaInfo();
            $this->getModeratorInfo();
        }

        if(empty($this->event_info)) {return false;}

        else{ return true; }

    }


    /**
     * Get all agenda information related to $this->agenda_ID
     */
    public function getAgendaInfo()
    {        
        $sql = "SELECT arrrival_meal_time, program_start_time, QA_time, program_end_time FROM agendas WHERE agenda_id = :agenda_id";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':agenda_id', $this->agenda_ID);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $this->event_info[4] = $result_row['arrrival_meal_time'];
            $this->event_info[5] = $result_row['QA_time'];
            $this->event_info[6] = $result_row['program_end_time'];
            $this->event_info[23] = $result_row['program_start_time'];
        }

    }

    /**
     * Get all moderator information related to $this->moderator_ID
     */
    public function getModeratorInfo()
    { 
        $sql = "SELECT mod_name, mod_credentials, mod_email, mod_institution, address_id FROM moderators WHERE moderator_id = :moderator_id";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':moderator_id', $this->moderator_ID);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $this->event_info[7] = $result_row['mod_name'];
            $this->event_info[8] = $result_row['mod_credentials'];
            $this->event_info[9] = $result_row['mod_email'];
            $this->event_info[10] = $result_row['mod_institution'];
            $this->address_ID = $result_row['address_id'];
            $this->getAddressInfo();
        }

    }

    /**
     * Get all Moderator's address information related to $this->address_ID
     */
    public function getAddressInfo()
    {        
        $sql = "SELECT street_address, suite, city, province, postal_code, telephone, fax FROM address WHERE address_id = :address_id";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':address_id', $this->address_ID);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $this->event_info[11] = $result_row['street_address'];
            $this->event_info[12] = $result_row['suite'];
            $this->event_info[13] = $result_row['city'];
            $this->event_info[14] = $result_row['province'];
            $this->event_info[15] = $result_row['postal_code'];
            $this->event_info[16] = $result_row['telephone'];    
            $this->event_info[17] = $result_row['fax'];                                           
        }
        $this->setProvinceList();
    }

    /**
     * Set the select list for the province and set the selected province
     */
    public function setProvinceList()
    {   
        $province_list = "<option></option>";
        $province = $this->event_info[14];  

        (strcmp($province,'Alberta') == 0) ? $province_list .= "<option selected='selected' value='Alberta'> Alberta </option>" : $province_list .= "<option value='Alberta'> Alberta </option>";
        (strcmp($province,'Colombie-Britannique') == 0 || strcmp($province,'British Columbia') == 0) ? $province_list .= "<option selected='selected' value='British Columbia'> British Columbia </option>" : $province_list .= "<option value='British Columbia'> British Columbia </option>";
        (strcmp($province,'Manitoba') == 0) ? $province_list .= "<option selected='selected' value='Manitoba'> Manitoba </option>" : $province_list .= "<option value='Manitoba'> Manitoba </option>";
        (strcmp($province,'Nouveau-Brunswick') == 0 || strcmp($province,'New Brunswick') == 0) ? $province_list .= "<option selected='selected' value='New Brunswick'> New Brunswick </option>" : $province_list .= "<option value='New Brunswick'> New Brunswick </option>";
        (strcmp($province,'Terre-Neuve et Labrador') == 0 || strcmp($province,'Newfoundland and Labrador') == 0) ? $province_list .= "<option selected='selected' value='Newfoundland and Labrador'> Newfoundland and Labrador </option>" : $province_list .= "<option value='Newfoundland and Labrador'> Newfoundland and Labrador </option>";
        (strcmp($province,'Nouvelle-Écosse') == 0 || strcmp($province,'Nova Scotia') == 0) ? $province_list .= "<option selected='selected' value='Nova Scotia'> Nova Scotia </option>" : $province_list .= "<option value='Nova Scotia'> Nova Scotia </option>";
        (strcmp($province,'Ontario') == 0) ? $province_list .= "<option selected='selected' value='Ontario'> Ontario </option>" : $province_list .= "<option value='Ontario'> Ontario </option>";
        (strcmp($province,'Île-du-Prince-Édouard') == 0 || strcmp($province,'Prince Edward Island') == 0) ? $province_list .= "<option selected='selected' value='Prince Edward Island'> Prince Edward Island </option>" : $province_list .= "<option value='Prince Edward Island'> Prince Edward Island </option>";
        (strcmp($province,'Quebec') == 0 || strcmp($province,'Québec') == 0) ? $province_list .= "<option selected='selected' value='Quebec'> Quebec </option>" : $province_list .= "<option value='Quebec'> Quebec </option>";
        (strcmp($province,'Saskatchewan') == 0) ? $province_list .= "<option selected='selected' value='Saskatchewan'> Saskatchewan </option>" : $province_list .= "<option value='Saskatchewan'> Saskatchewan </option>";  
        
        $this->provinceList = $province_list;
    }

    /**
     * Search if event corresponding to User ID and Event ID exists in the database
     */
    public function searchEvent()
    {        
        $sql = "SELECT COUNT(*) AS count FROM events WHERE event_id = :event_id AND rep_id = :user";
        $query = $this->db_connection->prepare($sql);
        $query->bindParam(':event_id', $this->event_ID);
        $query->bindParam(':user', $this->user);
        $query->execute();

        while($result_row = $query->fetch(PDO::FETCH_ASSOC) ){
            $no_total_events = $result_row['count'];  
            if($no_total_events == 1){
              return true;
            } 
            else {
              $message = "This event does not exist. Click 'My Events' tab to view your events or create a new event.";
              $this->setErrorMessage($message);
              return false;
            }
        }

        return false;

    }


    /**
     * Setter of the error message
     */
    public function setErrorMessage($message)
    {   
        $this->error_message = "<div class='row' style='margin-top:20px;'><div class='col-lg-12'><div class='alert alert-danger fade in' role='alert' ><p>$message</p></div></div></div>";
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

    /**
     * Get the event Id from url
     * @return event ID
     */
    public function getEventId()
    {
        if (isset($_GET["event_id"])) {
            $this->event_ID = $_GET["event_id"];
        }
    }

    public function PrintEventId()
    {
        return $this->event_ID;
    }

    public function PrintAgendaId()
    {
        return $this->agenda_ID;
    }

    public function PrintModeratorId()
    {
        return $this->moderator_ID;
    }

    public function PrintAddressId()
    {
        return $this->address_ID;
    }

    public function PrintFolderId()
    {   
        //Handle the case where the new directory failed to be created before
        if(!empty($this->moderator_ID) && empty($this->folderID)){
            $this->makeSubDir();
            $this->saveFolderID();
        }

        return $this->folderID;
    }

    public function makeSubDir()
    {   
        $newDir = $this->event_ID . '_' . $this->moderator_ID;
        $sub_directory = "../uploads/".$newDir;
        mkdir($sub_directory, 0777, true);
        $this->folderID = $newDir;
    }


    public function PrintModeratorName(){
      return $this->event_info[7];
    }
        /**
     * Saves the new directory field in the events and moderators tables respectively
     */
    public function saveFolderID()
    {
        //Update folder id in the events table
        $update_event_query = "UPDATE events SET folder_id = :folder_id WHERE event_id = :event_id";
        $update_event = $this->db_connection->prepare($update_event_query);
        $update_event->execute(array(':folder_id'=>$this->folderID,
                            ':event_id'=>$this->event_ID                                          
                    ));

        //Update folder id in the moderators table
        $update_moderator_query = "UPDATE moderators SET folder_id = :folder_id WHERE moderator_id = :moderator_id";
        $update_moderator = $this->db_connection->prepare($update_moderator_query);
        $update_moderator->execute(array(':folder_id'=>$this->folderID,
                            ':moderator_id'=>$this->moderator_ID                                           
                    ));         
    }
}


$myevent = new ViewEvent();
