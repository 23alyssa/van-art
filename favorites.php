<?php
require('utilities/functions.php');
// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
    // when user clicks on the submit button, checks where there is a member logged in or not
	 if (is_post_request()) {
         // checks if user is logged in, if not, send them to login page
        if (!isset($_SESSION['username'])) {
            redirect_to("login.php");
        } else {
            // fetches the user_id from the session member's username
            $name = $_SESSION['username'];
            $sql = "SELECT user_id FROM member WHERE username='$name'";
            $result = $connection ->query($sql);
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            // fetches the art_id from the temperory art session variable 
            $art_id = $_SESSION['art'];

            // generate query for insert favorites value
            $insertsql = "INSERT INTO favorite(user_id, art_id) VALUES ('$user_id', '$art_id')";
            // checking to see if the data of the logged in member already favorite this artwork
            $existing_query = "SELECT COUNT(*) as count FROM favorite WHERE user_id = '".$user_id."' AND art_id = '".$art_id."'";
            $existing_res = mysqli_query($connection, $existing_query);

            // If the count is not 0, that means already in favorites
            if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
            echo "Already in Favorites";
            redirect_to("artwork-details.php?RegistryID=".$art_id);
            } else {
                // if the connection is made then insert the data to the favorites table 
            if ($connection->query($insertsql) === TRUE) {
                echo "data inserted";
                redirect_to("artwork-details.php?RegistryID=".$art_id);
                } else {
                echo "failed";
                }
            }
        }
    }
    // remove temp session variable for artwork 
    unset($_SESSION['art']);
?>