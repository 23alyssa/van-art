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
        $sql = "SELECT user_id FROM member WHERE username='$name'";
        $result = $connection ->query($sql);
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $art_id = $_SESSION['art'];
        // echo $user_id. " and " . $art_id;
        $errors = [];

        $insertsql = "INSERT INTO favorite(user_id, art_id) VALUES ('$user_id', '$art_id')";
        $existing_query = "SELECT COUNT(*) as count FROM favorite WHERE user_id = '".$user_id."' AND art_id = '".$art_id."'";
        $existing_res = mysqli_query($connection, $existing_query);

        // If the count is not 0, that means already in favorites
        if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
        array_push($errors, 'already added to favorites');
        echo "Already in Favorites";
        redirect_to("artwork-details.php?RegistryID=".$art_id);
        } else {
        if ($connection->query($insertsql) === TRUE) {
            echo "data inserted";
            redirect_to("artwork-details.php?RegistryID=".$art_id);
            } else {
            echo "failed";
            }
        }
    }
    }
    unset($_SESSION['art']);
?>