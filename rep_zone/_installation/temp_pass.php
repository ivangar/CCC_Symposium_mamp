<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/php/PasswordHash.php");
/**
 * This is the installation file for the 0-one-file version of the php-login script.
 * It simply creates a new and empty database.
 */

// error reporting config
error_reporting(E_ALL);

// config
$db_type = "sqlite";
$db_sqlite_path = "../repzone.db";

// create new database file / connection (the file will be automatically created the first time a connection is made up)
$db_connection = new PDO($db_type . ':' . $db_sqlite_path);

// check for success
if (file_exists($db_sqlite_path)) {
    echo "Database $db_sqlite_path exists!";
} else {
    echo "Database $db_sqlite_path Does not exist";
}

//Call hash function and create hash and salt
    $Passhash = new PasswordHash();
    $Passhash->SetPassword("sta_repzone");
    $hash_salt = $Passhash->GetSalt();
    $user_password = $Passhash->GetHash();

//Insert new admin 
$sql = 'INSERT INTO password (user_password, hash_salt)
        VALUES(:user_password, :hash_salt)';
$query = $db_connection->prepare($sql);
$query->bindValue(':user_password', $user_password);
$query->bindValue(':hash_salt', $hash_salt);
// PDO's execute() gives back TRUE when successful, FALSE when not
// @link http://stackoverflow.com/q/1661863/1114320
$registration_success_state = $query->execute();

if ($registration_success_state) {
    echo "Password was inserted successfully";
    return true;
} else {
    echo "Sorry, password was not registered correctly.";
}

?>