<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions

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
    // $type = array();

    //loop through the results and populate the new array to hold the values for dropdown
    if ($typeQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($typeQueryResult)) {
        $typeOpts[] = $row['Type'];
        }    
    }

    //$type is undefined on page load but needed to keep track of submitted values 
    // set the variable to empty string - use !empty to check the value of $orderDrop later on
    if (!isset($type)) {
        $type = array();
    } 

//Year Of Installation: -----
    // populate the dropdown with all the types for users to pick from 
    $yearQuery = "SELECT DISTINCT public_art.YearOfInstallation FROM public_art ORDER BY `YearOfInstallation` DESC";
    $yearQueryResult = mysqli_query($connection, $yearQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    $year;

    //loop through the results and populate the new array to hold the values for dropdown
    if ($yearQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($yearQueryResult)) {
        $yearOpts[] = $row['YearOfInstallation'];
        }    
    }

    //$year is undefined on page load but needed to keep track of submitted values 
    // set the variable to empty string - use !empty to check the value of $orderDrop later on
    if (!isset($year)) {
        $year = "";
    } 



?>

<!-- connect to ajax file for filtering  -->
<script src="ajaxfilter.js"></script> 

<section class="container-fluid bg-alt">
    <div class="container">
        <div class="row pt-5">
            <sidebar class="col-3">
                <h3>Filters:</h3>
                    <?php  
                        // display and populate the filters from the stored array queries 
                        form_start(); 
                        form_dropdown('Year Install: ', 'year', $yearOpts, $yearOpts, $year, 'year');
                        form_check('Type:','type[]', $typeOpts, $typeOpts, $type, 'types');
                        form_check('Neighbourhood: ', 'neighbourhood[]', $neighbourhoodOpts, $neighbourhoodOpts, $neighbourhood, 'neighbourhood');
                        form_end();
                    ?>
            </sidebar>
            <div class="col-9"> 
                <div class="row" id="result">
                    <h3 class="text-center textChange" id="textChange">All Artwork</h3>
                    <?php
                    //Card Information: -----

                    //loader 
                    // echo "<img src=\"assets/loader.svg\" id=\"loader\" width=\"100\" style=\"display:none;\">";

                    //  include('browse-action.php');

                    // browse.php?page=1&type=TYPE1,TYPE2&neibourhood=N1,N2

                    $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, public_art.Type, public_art.Neighbourhood, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art WHERE public_art.RegistryID IS NOT NULL ";
                    
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
                    echo $sql; 
                    echo "<br><br>";
                    echo "count:" .mysqli_num_rows($resultFilter);

                    //display the retrieved result on the webpage  
                    if ($resultFilter != NULL) {
                        while ($row = mysqli_fetch_array($resultFilter)) {
                            $output =createCard($row);
                            // print_r($row);
                        }    
                    }
                    
                    echo $output;
                    
                    paging($page, $number_of_page, $page);

                    ?> 
                    <!--  -->
                    <?php
                    ?>
                </div>
            </div>
        </div>
        <?php
            
        ?>
    </div>

</section>


<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>

    <!-- $sql .= "LIMIT " .$page_first_result. ',' .$results_per_page; -->

    