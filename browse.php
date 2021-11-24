<?php

//display all errors on screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!empty($_GET['submit-search'])) {
        
    // get and initialize the varables from the form once submitted
    if( isset($_GET['neighbourhood'])) $neighbourhood=$_GET['neighbourhood']; 
    if( isset($_GET['type'])) $type=$_GET['type']; 
    if( isset($_GET['year'])) $year=$_GET['year']; 
  
}

// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Make sure the connection is successfully established, otherwise stop processing the rest of the script.
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }


//header.php has information for bootstrap and page title
require('utilities/header.php');

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

?>

<?php

//POPULATE FILTER CONTENT ---------------------------------------

// Neighbourhood: ------
    // populate the dropdown with all the neighbourhoods for users to pick from 
    $neighbourhoodQuery = "SELECT DISTINCT public_art.Neighbourhood FROM public_art WHERE public_art.Neighbourhood IS NOT NULL ORDER BY `Neighbourhood`";
    $neighbourhoodQueryResult = mysqli_query($connection, $neighbourhoodQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    $neighbourhood = array();

    //loop through the results and populate the new array to hold the values for dropdown
    if ($neighbourhoodQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($neighbourhoodQueryResult)) {
        $neighbourhoodOpts[] = $row['Neighbourhood'];
        }    
    }

    //$neighbourhood is undefined on page load but needed to keep track of submitted values 
    // set the variable to empty string - use !empty to check the value of $orderDrop later on
    if (!isset($neighbourhood)) {
        $neighbourhood = "";
    } 

// Type:-----
    // populate the dropdown with all the types for users to pick from 
    $typeQuery = "SELECT DISTINCT public_art.Type FROM public_art  WHERE public_art.Type IS NOT NULL ORDER BY `Type`";
    $typeQueryResult = mysqli_query($connection, $typeQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    $type = array();

    //loop through the results and populate the new array to hold the values for dropdown
    if ($typeQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($typeQueryResult)) {
        $typeOpts[] = $row['Type'];
        }    
    }

    //$type is undefined on page load but needed to keep track of submitted values 
    // set the variable to empty string - use !empty to check the value of $orderDrop later on
    if (!isset($type)) {
        $type = "";
    } 

//Year Of Installation: -----
    // populate the dropdown with all the types for users to pick from 
    $yearQuery = "SELECT DISTINCT public_art.YearOfInstallation FROM public_art ORDER BY `YearOfInstallation` DESC";
    $yearQueryResult = mysqli_query($connection, $yearQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    $year = array();

    //loop through the results and populate the new array to hold the values for dropdown
    if ($yearQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($yearQueryResult)) {
        $yearOpts[] = $row['YearOfInstallation'];
        }    
    }

    //$type is undefined on page load but needed to keep track of submitted values 
    // set the variable to empty string - use !empty to check the value of $orderDrop later on
    if (!isset($year)) {
        $year = "";
    } 

//Card Information: -----
    // populate the dropdown with all the types for users to pick from 
    $cardQuery = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art LIMIT 25";
    $cardQueryResult = mysqli_query($connection, $cardQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    // $card = array();
    // $cardOpts = [ "RegistryID" => "", "PhotoURL" => "", "YearOfInstallation" => "", "SUBSTRING(public_art.DescriptionOfwork,1,70)" => ""];
    $cardOpts = [];

    //loop through the results and populate the new array to hold the values for dropdown
    if ($cardQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($cardQueryResult)) {
            $cardOpts[] = [$row['RegistryID'],$row['PhotoURL'],$row['YearOfInstallation'], $row['SUBSTRING(public_art.DescriptionOfwork,1,70)']];
        
        // $cardOpts['RegistryID'] = $row['RegistryID'];
        // $cardOpts['PhotoURL'] = $row['PhotoURL'];
        // $cardOpts['YearOfInstallation'] = $row['YearOfInstallation'];
        // $cardOpts['SUBSTRING(public_art.DescriptionOfwork,1,70)'] = $row['SUBSTRING(public_art.DescriptionOfwork,1,70)'];
        }    
    }

?>

<section class="container-fluid bg-alt">
    <div class="container">
        <div class="row pt-5">
            <sidebar class="col-3">
                <h3>Filters:</h3>
                <form class='form-group' action='dbquery.php' method='get'>
                    <?php  
                        // display and populate the filters from the stored array queries 
                        form_start(); 
                        form_dropdown('Year Install: ', 'year', $yearOpts, $yearOpts, $year);
                        form_check('Type:','type[]', $typeOpts, $typeOpts, $type);
                        form_check('Neighbourhood: ', 'neighbourhood', $neighbourhoodOpts, $neighbourhoodOpts, $neighbourhood);
                        form_end();
                    ?>
            </sidebar>
            <div class="col-9"> 
                <div class="row">
                    <!-- <div class="card-columns"> -->
                        <?php
                        // echo "<pre>";
                        // print_r($cardOpts);
                        // echo "<pre>";
                        foreach($cardOpts as $card) {
                            createCard($card);
                            // echo "<br>";
                            // print_r($card);
                            // echo "<br>";
                        }
                        ?>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>

</section>



<?php

// Bootstrap carousel




?>




<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>