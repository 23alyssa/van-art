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

<section class="container-fluid bg-alt">
    <div class="container pb-5">
        <div class="row pt-5 pb-5">
            <div class="col-6 pt-5">
                <h1 class="pt-5">Vancouver Public Art</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet dui, tincidunt sit tellus cursus tortor, blandit. Nulla non lorem nisi, ullamcorper cras egestas purus, adipiscing enim. Natoque turpis convallis nisl orci est.</p>
                <a href="browse.php" class="btn btn-primary btn-lg">Browse Artwork</a>
            </div>
            <div class="col-6 pt-5">
                <img class="img-display" src="assets/mural.jpg">
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container">
        <div class="row pt-5">
            <div class="col-8 offset-2">
                <h2 class="text-center">About</h2>
                <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet dui, tincidunt sit tellus cursus tortor, blandit. Nulla non lorem nisi, ullamcorper cras egestas purus, adipiscing enim. Natoque turpis convallis nisl orci est.</p>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container pt-5 pb-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-5 pt-5">
                <img class="img-display" src="assets/paint2.jpg">
            </div>
            <div class="col-5 pt-5">
                <h4 class="">More Info...</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Amet dui, tincidunt sit tellus cursus tortor, blandit. Nulla non lorem nisi, ullamcorper cras egestas purus, adipiscing enim. Natoque turpis convallis nisl orci est.</p>
            </div>
        </div>
    </div>
</section>

<section> 
        <div class="container">
            <div class="row d-flex justify-content-center">
                <h2 class="text-center">Features</h2>
                <div class="col-md-3 m-3">
                    <div class="d-flex justify-content-center">
                        <img class=" img-fluid img-display-xsm" src="assets/illustration1.png">
                    </div>
                    <h4 class="text-center">Ideation</h4>
                    <p class="text-center">
                        Creating a design concept and deciding on scope sets the foundation of a project. This includes building a sitemap, creating user flows, and categorizing features.
                    </p>
                </div>
                <div class="col-md-3 m-3">
                    <div class="d-flex justify-content-center">
                        <img class=" img-fluid img-display-xsm" src="assets/illustration2.png">
                    </div>
                    <h4 class="text-center">Iteration</h4>
                    <p class="text-center">
                        Finding the best design solution rarely happens on the first try. Its takes a lot of experimentation and iteration to find unique and creative solutions for complex problems. 
                    </p>
                </div>
                <div class="col-md-3 m-3">
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid img-display-xsm" src="assets/illustration3.png">
                    </div>
                    <h4 class=" mt-2 text-center">Implementation</h4>
                    <p class="text-center">
                        Considering the impacts of a project in use by prototyping, developing and testing ensures it can be applied to real world scenarios and promotes understanding.
                    </p>
                </div>
            </div>
        </div>
    </section>
                


<!-- <iframe frameborder="0" width="800" height="600" src="https://opendata.vancouver.ca/map/embed/all_art_locations/?&static=false&scrollWheelZoom=false"></iframe> -->

<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>