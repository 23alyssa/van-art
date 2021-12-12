<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions

//display all errors on screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Make sure the connection is successfully established, otherwise stop processing the rest of the script.
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

//header.php has information for bootstrap and page title
require('utilities/header.php');

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

?>

<?php
	$name = $_SESSION['username'];
	$sql = "SELECT user_id FROM member WHERE username='$name'";
    $result = $connection ->query($sql);
    $user_id = mysqli_fetch_assoc($result);
    $art_id = $_SESSION['artIDpass'];

    $insertsql = "INSERT INTO favorite ('user_id', 'art_id') VALUES ('$user_id', '$art_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "data inserted";
    }
    else 
    {
        echo "failed";
    }

?>