<?php
require('utilities/functions.php');
// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
session_start(); // turn on sessions
	 if (is_post_request()) {
        //whether ip is from share internet
        $ip_address = get_ip();

        $art_id = $_SESSION['art'];

        $sql = "DELETE FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$art_id."'";
        if ($connection->query($sql) ===  TRUE) {
            echo "data inserted";
            redirect_to("artwork-details.php?RegistryID=".$art_id);
        } else {
            echo $ip_address . $art_id;
            echo "failed";
        }
    unset($_SESSION['art']);
    }


?>