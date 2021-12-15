<?php
require('utilities/functions.php');
// connect to database
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
         // redirect if not logged in
        if (!isset($_SESSION['username'])) {
            redirect_to("login.php");
        } else {
            // create variables for sessions
            $name = $_SESSION['username'];
            $art_id = $_SESSION['art'];

            // delete favorite artwork from user
            $sql = "DELETE FROM favorite WHERE user_id = (SELECT user_id FROM member WHERE username='$name') AND art_id = '".$art_id."'";
            if ($connection->query($sql) ===  TRUE) {
                echo "Record Deleted successfully";
                redirect_to("artwork-details.php?RegistryID=".$art_id);
            } else {
                echo "error deleting record";
            }
        }
    }
    // unset the art session variable
    unset($_SESSION['art']);
?>