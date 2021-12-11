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
                        form_dropdown('Year Install: ', 'year', $yearOpts, $yearOpts, $year);
                        form_check('Type:','type[]', $typeOpts, $typeOpts, $type, 'types');
                        form_check('Neighbourhood: ', 'neighbourhood[]', $neighbourhoodOpts, $neighbourhoodOpts, $neighbourhood, 'neighbourhood');
                        form_end();
                    ?>
            </sidebar>
            <div class="col-9"> 
                <div class="row" id="result">
                    <h3 class="text-center" id="textChange">All Artwork</h3>
                    <?php
                    //Card Information: -----

                    //loader 
                    // echo "<img src=\"assets/loader.svg\" id=\"loader\" width=\"100\" style=\"display:none;\">";

                    // // check form 
                    // $where = "";
                    
                    // if (!empty($year)){
                    //     $where = " WHERE public_art.YearOfInstallation = '$year'";
                    // } 

                    // // on pageload automatically show all the coloumns for results (auto check all boxes)
                    // $typeFilter = "";
                    // if (isset($type) && !empty($type)) {
                    // //turn the array of selected checkboxes into a string to use in Select statement
                    // $typeFilter = "'" . implode("' , '", $type) . "'";
                    // $where = " WHERE public_art.Type IN ($typeFilter)";
                    // } 

                    // // $where = " WHERE $yearF AND $typeF";

                    // print_r($typeFilter);
                    // echo"<br><br>";

                    // populate the dropdown with all the types for users to pick from 
                    // $cardQuery = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art $where";
                    // $cardQueryResult = mysqli_query($connection, $cardQuery);

                    // //define total number of results you want per page  
                    // $results_per_page = 25;  
                                    
                    // //find the total number of results stored in the database    
                    // $number_of_result = mysqli_num_rows($cardQueryResult);  

                    // //determine the total number of pages available  
                    // $number_of_page = ceil ($number_of_result / $results_per_page);  

                    // //determine which page number visitor is currently on  
                    // if (!isset ($_GET['page']) ) {  
                    //     $page = 1;  
                    // } else {  
                    //     $page = $_GET['page'];  
                    // }  

                    // //determine the sql LIMIT starting number for the results on the displaying page  
                    // (int)$page_first_result = ((int)$page-1) * (int)$results_per_page;  

                    // // //retrieve the selected results from database   
                    $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art LIMIT 10";
                    // $where LIMIT " . $page_first_result . ',' . $results_per_page;  

                    // echo $sql;

                    $resultPaging = mysqli_query($connection, $sql); 

                    //make a new array to hold the value from the query to use in the form_dropdown function
                    $cardOpts = [];

                    //display the retrieved result on the webpage  
                    if ($resultPaging != NULL) {
                        while ($row = mysqli_fetch_array($resultPaging)) {
                            $cardOpts[] = [$row['RegistryID'],$row['PhotoURL'],$row['YearOfInstallation'], $row['SUBSTRING(public_art.DescriptionOfwork,1,70)']];
                        }    
                    }
                        foreach($cardOpts as $card) {
                            createCard($card);
                        } 

                    ?>
                </div>
            </div>
        </div>
        <?php
            // paging($page, $number_of_page, $page);
        ?>
    </div>

</section>

<!-- <script type="text/javascript">

    $(document).ready(function(){
        // alert("hello"); //check is jquery library is working

        $(".art_check").click(function(){
            $("#loader").show();

            var action = 'data';
            var types = get_filter_text('types');
            var neighbourhood = get_filter_text('neighbourhood');

            $.ajax({
                url:'browse-action.php', 
                method: 'POST', 
                data: {action:action, types:types, neighbourhood:neighbourhood},
                sucess:function(response){
                    $("#result").html(response);
                    $("#loader").hide();
                    $("textChange").text("Filtered Artwork");
                }
            })
        });

        function get_filter_text(text_id) {
            var filterData = [];
            $('#'+text_id+':checked').each(function(){
                filterData.push($(this).val());
            });
            return filterData;
        }
    });
    
</script> -->

<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>
