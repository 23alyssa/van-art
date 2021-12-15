<?php
require('utilities/functions.php');
// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
        if (!isset($_SESSION['username'])) {
            redirect_to("login.php");
        } else {
            $name = $_SESSION['username'];
            // $sql = "SELECT user_id FROM member WHERE username='$name'";
            // $result = $connection ->query($sql);
            // $row = mysqli_fetch_assoc($result);
            // $user_id = $row['user_id'];
            $art_id = $_SESSION['favart'];
            echo $art_id;

            // $sql = "DELETE FROM favorite WHERE user_id = '".$user_id."' AND art_id = '".$art_id."'";
            $sql = "DELETE FROM favorite WHERE user_id = (SELECT user_id FROM member WHERE username='$name') AND art_id = '".$art_id."'";
            if ($connection->query($sql) ===  TRUE) {
                echo "Record Deleted successfully";
                // redirect_to("members.php");
            } else {
                echo "error deleting record";
            }
        }
    }
    unset($_SESSION['art']);
?>