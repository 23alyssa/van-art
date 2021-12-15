<?php
require('utilities/functions.php');
// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
        //whether ip is from share internet
        $ip_address = get_ip();
        // echo $ip_address;

        $art_id = $_SESSION['art'];
        $insertsql = "INSERT INTO upvote(IP_address, art_id) VALUES ('$ip_address', '$art_id')";
        $existing_query = "SELECT COUNT(*) as count FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$art_id."'";
        $existing_res = mysqli_query($connection, $existing_query);

        // If the count is not 0, that means already in favorites
        if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
            echo "Already upvoted";
        redirect_to("artwork-details.php?RegistryID=".$art_id);
        } else {
            if ($connection->query($insertsql) === TRUE) {
                echo "data inserted";
                redirect_to("artwork-details.php?RegistryID=".$art_id);
            } else {
                echo "failed";
            }
        }
    unset($_SESSION['art']);
    }


?>