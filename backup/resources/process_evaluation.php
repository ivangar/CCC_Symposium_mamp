<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/FirePHP.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/FirePHPCore/fb.php');
ob_start();


if(!isset($_SESSION))
{
session_start();
}  

require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/connect_db.php");

//check if the $_GET variables are present and proceed with registration confirmation process
if(isset($_POST) && (!empty($_POST))){

	$doctor_id = $_SESSION['user_id'];
	$q_id;
	$choice;
	$answer;
	$data = $_POST; //contains questions-answer array and program section id
	$con = GetDBconnection(); // get database connection credentials
	$program_section_id; // program section id to be inserted in the foreign key column

	if(GetData($data, $program_section_id)){
		//should insert a new record with the program section answered and date.
		
		if (InsertEvaluation($con, $doctor_id, $program_section_id) ){
			$_SESSION['section_submitted'] = true;
			echo 'completed';
		}
		
		else {echo 'failed';} 

	}

	else echo 'failed';

	/* close connection */
	mysqli_close($con);

}

function GetData($data, &$program_section_id)
{
	global $doctor_id;
	global $con;
	global $q_id;
	global $choice;
	global $answer; 

	$questions_answers = $data['qas'];  //temporary array holding question and answers from post array
	$choices = $data['choices']; //answer choices
	$program_section_id = $data['program_section']; //program section id
	$no_qs = $data['no_qs']; //number of questions

	if( EmtpyFields($choices, $no_qs) ){
		return false;
	}
	
	if (EmptyAnswer($questions_answers)){
		return false;
	}

	//loop through questions array
	foreach ($questions_answers as $qas_index => $qas_block) {

	    	//Get key => value pairs sent from submitted form serialized by jQuery function
	    	foreach ($qas_block as $key => $value) {

	    		$value = Sanitize($value);  //Sanitize answers and questions before inserting into DB

	    		//field name should be question id
	    		if(strcmp($key,'name') == 0){

	    			$q_id = $value;

	    			//Get choice number (1, 2, 3, etc.)
	    			foreach ($choices as $choice_id => $choice_val) {
	    				if($choice_id == $q_id){
	    					$choice = $choice_val;
	    				}
	    			}
	    		}

	    		//field value should be the answer choice selected
	    		else{ $answer = $value; }	 

			}


			if(!empty($answer)){

				//DON'T FORGET TO UPDATE THE CHECK COMPARISON FOR EACH 'Please explain text area'  
				if(strcmp($q_id,'bias') == 0){
					$question_id = 'BMS_107_E_21';
					UpdateAnswer($con, $doctor_id, $program_section_id, $question_id, $answer);
				}

				else{
					if(!InsertAnswers($con, $doctor_id, $program_section_id, $q_id, $answer, $choice))
						return false;
				}
			}

			$choice = '';
	}

	return true;
}

//Check if there is at least one empty field in the array of questions and answers
function EmtpyFields($choices, $no_qs){
	
	$isEmpty = false;

	$choices_submitted = count($choices);

	if($choices_submitted < $no_qs){
		$isEmpty = true;
	}

	else{
		//Get key => value pairs sent from submitted form serialized by jQuery function
		foreach ($choices as $key => $value) {
    		if(!isset($value) || empty($value)){ $isEmpty = true; }
    	}	
	}

	return $isEmpty;
}

function EmptyAnswer($questions_answers){

	$isEmpty = false;
	$allQs = 0; //this will be the counter to hold number of answered questions

	//loop through questions array
	foreach ($questions_answers as $qas_index => $qas_block) {

    	//Get key => value pairs sent from submitted form serialized by jQuery function
    	foreach ($qas_block as $key => $value) {

    		//field name should be question id
    		if(strcmp($key,'name') == 0){
    			$q_id = $value;

    			switch ($q_id) {
					case 'BMS_107_E_21':
						$allQs++;
						break;					
				}

    		} 

		}
	}

	//DONT FORGET TO UPDATE THE COUNTER CHECK
	if($allQs !== 1){
		$isEmpty = true;
	}

	return $isEmpty;
}

//replace html entities
function Sanitize($str,$remove_nl=true)
{
    if($remove_nl)
    {
        $injections = array('/(\n+)/i',
            '/(\r+)/i',
            '/(\t+)/i',
            '/(%0A+)/i',
            '/(%0D+)/i',
            '/(%08+)/i',
            '/(%09+)/i'
            );
        $str = preg_replace($injections,'',$str);
    }

    return $str;
}   
 
//Escape entities
function SanitizeForSQL($con, $str)
{
    if( function_exists( "mysqli_real_escape_string" ) )
    {
          $ret_str = mysqli_real_escape_string($con, $str);
    }
    else
    {
          $ret_str = addslashes( $str );
    }
    return $ret_str;
}

//Inserts all answers in the database
function InsertAnswers($con, $doctor_id, $program_section_id, $q_id, $answer, $choice)
{
	$program_section_id =  SanitizeForSQL($con, $program_section_id);
	$q_id =  SanitizeForSQL($con, $q_id);
	$answer =  SanitizeForSQL($con, $answer);
	$choice =  SanitizeForSQL($con, $choice);

	$choice = !empty($choice) ? "'$choice'" : "NULL";

    $insert_answer_qr = "INSERT INTO doctor_answers (
            doctor_id,
            program_section_id,
            question_id,
            doctor_answer,
            answer_choice,
            date_of_answer
            )
            VALUES
            (
            '$doctor_id',
            '$program_section_id',
            '$q_id',
            '$answer',
            $choice,
            NOW()
            )"; 

    //mysqli_query() returns true on successful insertion, false otherwise
    $insert_answer = mysqli_query($con, $insert_answer_qr);

    if(!$insert_answer){
        return false;
    }

    return true;
}

function UpdateAnswer($con, $doctor_id, $program_section_id, $q_id, $comment){
	$program_section_id =  SanitizeForSQL($con, $program_section_id);
	$q_id =  SanitizeForSQL($con, $q_id);
	$comment =  SanitizeForSQL($con, $comment);

	$update_answer_query = "UPDATE `doctor_answers` SET `comments` = '$comment' WHERE `doctor_id` = '$doctor_id' AND `program_section_id` = '$program_section_id' AND `question_id` = '$q_id' LIMIT 1";

	$update_answer = mysqli_query($con, $update_answer_query);

	if(!$update_answer){
	    return false;
	}

	return true;
}

//Insert a result for the completed program section
function InsertEvaluation($con, $doctor_id, $program_section_id)
{
	$program_section_id = SanitizeForSQL($con, $program_section_id);

    $insert_evaluation_qr = 'INSERT INTO evaluations (
            doctor_id,
            program_section_id,
            date_time
            )
            VALUES
            (
            "' . $doctor_id . '",
            "' . $program_section_id . '",
            NOW()
            )'; 

    //mysqli_query() returns true on successful insertion, false otherwise
    $insert_eval = mysqli_query($con, $insert_evaluation_qr);

    if(!$insert_eval){
        return false;
    }

    return true;
}


?>