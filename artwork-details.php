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

// - registry id *
// - artist statement *
// - type *
// - status *
// - sitename 
// - site address *
// - primary material *
// - photo url *
// - ownership
// - neighbourhood *
// - location site *
// - goem *
// - geo location area
// - description *
// - artist *
// - photo credit *
// - year of install * 

    $artIDpass = $_GET['RegistryID'];

    // populate the dropdown with all the types for users to pick from 
    $detailsQuery = "SELECT public_art.RegistryID, public_art.ArtistProjectStatement, public_art.Type, public_art.Status, public_art.SiteAddress, public_art.PrimaryMaterial, public_art.PhotoURL, public_art.Neighbourhood, public_art.LocationOnsite, public_art.Geom, public_art.DescriptionOfwork, public_art.Artists, public_art.PhotoCredits, public_art.YearOfInstallation
    FROM `public_art` 
    WHERE public_art.RegistryID='$artIDpass';";
    $detailsQueryResult = mysqli_query($connection, $detailsQuery);

    //make a new array to hold the value from the query to use in the form_dropdown function
    $detailsOpts = [];

    //display the retrieved result on the webpage  
    if ($detailsQueryResult != NULL) {
        while ($row = mysqli_fetch_assoc($detailsQueryResult)) {
            $detailsOpts = $row;
        }    
    }

    // echo "<h1> Hello World </h1>";
    // echo "<pre>";
    // print_r($detailsOpts);
    // echo "<pre>";

?>

<section class="container">
    <div class="mt-5">
        <div class="row pt-5">
            <sidebar class="col-6">
                <h1><?php echo $detailsOpts['RegistryID'];?></h1>
                <h4><?php echo $detailsOpts['YearOfInstallation'];?>  |  <?php echo $detailsOpts['Neighbourhood'];?>  |  <?php echo $detailsOpts['Artists'];?></h4>

                <ul class="list-unstyled">
                    <li>Type: <?php echo $detailsOpts['Type'];?></li>
                    <li>Status: <?php echo $detailsOpts['Status'];?></li>
                    <li>Site Address: <?php echo $detailsOpts['SiteAddress'];?></li>
                    <li>Primary Material: <?php echo $detailsOpts['PrimaryMaterial'];?></li>
                </ul>
            </sidebar>
            <div class="col-6 limit"> 
                <img class="" <?php echo "src=\""; echo $detailsOpts['PhotoURL']; echo "\""; ?>
                >
                <?php 
                echo "<img src=\"";
                if ($detailsOpts['PhotoURL'] ==""){
                    echo "assets/no-image.png\"";
                } else {
                    echo $detailsOpts['PhotoURL'];
                    echo "\"";
                }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="container">
    <div class="mt-5">
        <ul class="nav nav-tabs">
            <li class="active m-2"><a data-toggle="tab" href="#location">Location</a></li>
            <li class="m-2"><a data-toggle="tab" href="#description">Description</a></li>
            <li class="m-2"><a data-toggle="tab" href="#artist-stat">Artist Statment</a></li>

        </ul>

        <div class="tab-content">
            <div id="location" class="tab-pane fade in show active">
                <h3 class="mt-5">Google Maps</h3>
                <p class="mb-5"><?php echo $detailsOpts['Geom'];?></p>
            </div>
            <div id="description" class="tab-pane fade">
                <h3 class="mt-5">Description of Work</h3>
                <?php 
                if ($detailsOpts['DescriptionOfwork'] ==""){
                    echo "<h5 class=\"mb-5\">No description avaliable</h5>";
                } else {
                    echo "<p class=\"mb-5\">";
                    echo $detailsOpts['DescriptionOfwork'];
                    echo "</p>";
                }
                ?>
            </div>
            <div id="artist-stat" class="tab-pane fade">
                <h3 class="mt-5">Artist Statment</h3>
                <?php 
                if ($detailsOpts['ArtistProjectStatement'] ==""){
                    echo "<h5 class=\"mb-5\">No artist statement avaliable</h5>";
                } else {
                    echo "<p class=\"mb-5\">";
                    echo $detailsOpts['ArtistProjectStatement'];
                    echo "</p>";
                }
                ?>
            </div>
        </div>
        </div>
    </div>
</section>



<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>