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
            <div class="col-6 pt-5 d-flex justify-content-center align-items-center">
                <div>
                    <h1 class="pt-5">Vancouver Public Art</h1>
                    <p>Vancouver Public Art is an index of artwork available publically in Vancouver with addition information to learn more about the installations and where they are. Because oftentimes public art can be a hidden surprise, but sometimes difficult to find when you want to.</p>
                    <a href="browse.php" class="btn btn-primary btn-lg">Browse Artwork</a>
                </div>
            </div>
            <div class="col-6 pt-5">
                <img class="img-display-lg" src="assets/mural.jpg">
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container">
        <div class="row pt-5">
            <div class="col-10 offset-2">
                <h2 class="text-center">About</h2>
                <p  class="text-center">
                    This is a student web development project to learn about database deveopment, PHP, ajax and web service api. While working on the project we hope to incorporate our existing database knowledge to populate the data and use queries to filter browsed content, as well as develop new skills to create user comments and work with API's. These skills are great to showcase for a portfolio project because they are transferable to many different types of web development projects Our goal is to highlight the gorgeous public art around Vancouver and increase exposure to the installations by creating a digital space for users to find information on exhibits.
                    </p>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container pt-5 pb-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-5 pt-5 pb-5">
                <img class="img-display rounded-lg" src="assets/paint2.jpg">
            </div>
            <div class="col-5 pt-5 pb-5">
                <h4 class="">Find artwork</h4>
                <p>Using the browse page you can view an index of all publically avalible art in Vancouver. Filter the results to find artwork that matches you interest or location. You can learn more about the artwork including its location, description, and art statement. Find your next piece!</p>
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
                <h4 class="text-center">Browse</h4>
                <p class="text-center">
                    Going for a walk downtown? Why not plan a route where you can stop and look at some amazing art on the way. 
                </p>
            </div>
            <div class="col-md-3 m-3">
                <div class="d-flex justify-content-center">
                    <img class=" img-fluid img-display-xsm" src="assets/illustration2.png">
                </div>
                <h4 class="text-center">Upvote</h4>
                <p class="text-center">
                    Did you like an artwork? Show your apprieciation by upvoting the art piece so that others can find it.
                </p>
            </div>
            <div class="col-md-3 m-3">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid img-display-xsm" src="assets/illustration3.png">
                </div>
                <h4 class=" mt-2 text-center">Favourite</h4>
                <p class="text-center">
                    Don't lose track of your favourite artwrok by adding it your favuorites list.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container pt-5 pb-5">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-5 pt-5 pb-5">
                <h4 class="">Creat an account</h4>
                <p>Registering with Vancouver Public Art will unlock additional features that you can use to customize your experience. Never forget a piece of art you want to visit by adding it to your favourites. Connect with other art lovers throught the comments on artwork.</p>
            </div>
            <div class="col-5 pt-5 pb-5">
                <img class="img-display rounded-lg" src="assets/paint.jpg">
            </div>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="container mb-5">
        <div class="row pt-5 mb-5">
            <div class="col d-flex justify-content-center align-items-center">
                <div>
                    <h2 class="text-center mb-4">Map of all artwork</h2>
                    <iframe class="mb-5" frameborder="0" width="1000" height="600" src="https://opendata.vancouver.ca/map/embed/all_art_locations/?&static=false&scrollWheelZoom=false"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
                



<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>