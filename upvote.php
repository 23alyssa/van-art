<?php
require('utilities/functions.php');
// connect database
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
        //gets the ip address
        $ip_address = get_ip();
        // set session artwork to variable
        $art_id = $_SESSION['art'];
        // create query for the upvote with ip address and artwork id
        $insertsql = "INSERT INTO upvote(IP_address, art_id) VALUES ('$ip_address', '$art_id')";
        $existing_query = "SELECT COUNT(*) as count FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$art_id."'";
        $existing_res = mysqli_query($connection, $existing_query);

        // If the count is not 0, that means already upvoted
        if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
            echo "Already upvoted";
        redirect_to("artwork-details.php?RegistryID=".$art_id);
        } else {
            // checks if insert data for upvote is correct and redirects
            if ($connection->query($insertsql) === TRUE) {
                echo "data inserted";
                redirect_to("artwork-details.php?RegistryID=".$art_id);
            } else {
                echo "failed";
            }
        }

    // unset temp art session
    unset($_SESSION['art']);
    }


?>