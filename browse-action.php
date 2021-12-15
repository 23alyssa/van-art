
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


if( isset($_GET['action']) || isset($_GET['action2'])) {
    $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, public_art.Type, public_art.Neighbourhood, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art WHERE public_art.RegistryID IS NOT NULL ";

    if( isset($_GET['types'])) {
        $types = implode("','", $_GET['types']);
        $sql .= " AND public_art.Type IN('".$types."')";
    }

    if( isset($_GET['neighbourhood'])) {
        $neighbourhood = implode("','", $_GET['neighbourhood']);
        $sql .= " AND public_art.Neighbourhood IN('".$neighbourhood."')";
    }

    if( isset($_GET['year'])) {
        $year = implode("','", $_GET['year']);
        $sql .= " AND public_art.YearOfInstallation IN('".$year."')";
    }

    echo $sql;

    $resultFilter = mysqli_query($connection, $sql);
    
    //define total number of results you want per page  
    $results_per_page = 10;  
                    
    //find the total number of results stored in the database    
    $number_of_result = mysqli_num_rows($resultFilter);  

    //determine the total number of pages available  
    $number_of_page = ceil ($number_of_result / $results_per_page);  

    //determine which page number visitor is currently on  
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  

    //determine the sql LIMIT starting number for the results on the displaying page  
    (int)$page_first_result = ((int)$page-1) * (int)$results_per_page;  
    $sql .= " LIMIT " .$page_first_result. ',' .$results_per_page. ';';

    $resultFilter = mysqli_query($connection, $sql);
    // echo $sql; 
    echo "count:" .mysqli_num_rows($resultFilter);

    if ($resultFilter != NULL) {
        if (mysqli_num_rows($resultFilter)>0) {
            while ($row = mysqli_fetch_array($resultFilter)) {
                $output =createCard($row);
            } 
        } else { 
            $output = "<h3>No results found</h3>";
        }
    }

//PAGING ISSUE: 
//when moving to the next page after filtering it goes back to all results
    // echo $_SERVER['REQUEST_URI'];
    echo $output;
    paging($page, $number_of_page, $page);
?>

    <?php
}

?>


