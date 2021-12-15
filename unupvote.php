<?php
require('utilities/functions.php');
// connect to database
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
        //get ip address
        $ip_address = get_ip();
        // set variables for the artwork
        $art_id = $_SESSION['art'];
        // deletes the upvote from the artwork associated with ip address
        $sql = "DELETE FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$art_id."'";
        if ($connection->query($sql) ===  TRUE) {
            echo "data inserted";
            redirect_to("artwork-details.php?RegistryID=".$art_id);
        } else {
            echo $ip_address . $art_id;
            echo "failed";
        }
        // unset temp session artwork
    unset($_SESSION['art']);
    }

?>