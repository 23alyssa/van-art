<?php 

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

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

// require('browse.php');
//  echo "connected";

if( isset($_POST['action'])) {
    $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, public_art.Type, public_art.Neighbourhood, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art WHERE public_art.RegistryID IS NOT NULL ";
    

    if( isset($_POST['types'])) {
        $types = implode("','", $_POST['types']);
        $sql .= "AND public_art.Type IN('".$types."')";
    }

    if( isset($_POST['neighbourhood'])) {
        $neighbourhood = implode("','", $_POST['neighbourhood']);
        $sql .= "AND public_art.Neighbourhood IN('".$neighbourhood."')";
    }

    echo $sql;
    $resultFilter = mysqli_query($connection, $sql); 
    $output = "";

    if ($resultFilter != NULL) {
        if (mysqli_num_rows($resultFilter)>0) {
            while ($row = mysqli_fetch_array($resultFilter)) {
                $output =createCard($row);
                // $cardOpts[] = [$row['RegistryID'],$row['PhotoURL'],$row['YearOfInstallation'], $row['SUBSTRING(public_art.DescriptionOfwork,1,70)']];
            } 
        } else { 
            $output = "<h3>No results found</h3>";
        }
    }
    // foreach($cardOpts as $card) {
    //     createCard($card);
    // }

    // if ($cardOpts == []) {
    //     echo "No results";
    // }

    echo $output;
}




?>


