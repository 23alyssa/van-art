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

$comment = "";
$sqlComment ="";
$comment_active ="tab-pane fade";
$location_active ="tab-pane fade in show active";

// if (!empty($_POST['post'])) {
        
    // get and initialize the varables from the form once submitted
    if( isset($_POST['comment'])) {
        $comment=($_POST['comment']); 

        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";

    } 

    if( isset($_POST['comment-update'])) {
        $comment_update=($_POST['comment-update']); 
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    }
  
// }

    $artIDpass = $_GET['RegistryID'];

    if (isset($_GET['id'])) {
        $comment_id_edit = $_GET['id'];
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    } 

    if (isset($_GET['id-delete'])) {
        $comment_id_delete = $_GET['id-delete'];
        
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    } 

    // read database 
    $detailsQuery = "SELECT public_art.RegistryID, public_art.ArtistProjectStatement, public_art.Type, public_art.Status, public_art.SiteAddress, public_art.PrimaryMaterial, public_art.PhotoURL, public_art.Neighbourhood, public_art.LocationOnsite, public_art.Geom, public_art.DescriptionOfwork, public_art.Artists, public_art.PhotoCredits, public_art.YearOfInstallation, artists.FirstName, artists.LastName FROM `public_art` INNER JOIN artists ON public_art.Artists=artists.ArtistID 
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

    $registryID = $detailsOpts['RegistryID'];
    $_SESSION['art'] = $registryID;

    // echo "<h1> Hello World </h1>";
    // echo "<pre>";
    // print_r($detailsOpts);
    // echo "<pre>";

?>


<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<section class="container">
    <div class="mt-5">
        <div class="row pt-5">
            <sidebar class="col-6">
                <!-- <h1><?php //echo $detailsOpts['RegistryID'];?></h1> -->
                <h4><?php echo $detailsOpts['YearOfInstallation'];?>  |  <?php echo $detailsOpts['Neighbourhood'];?>  |  <?php echo $detailsOpts['FirstName']. " " .$detailsOpts['LastName'] ;?></h4>

                <ul class="list-unstyled">
                    <li>Type: <?php echo $detailsOpts['Type'];?></li>
                    <li>Status: <?php echo $detailsOpts['Status'];?></li>
                    <li>Site Address: <?php echo $detailsOpts['SiteAddress'];?></li>
                    <li>Primary Material: <?php echo $detailsOpts['PrimaryMaterial'];?></li>
                </ul>
                <!-- <form method="post" action="favorites.php">
                <button type="submit" name="fav" id="<?//= $detailsOpts['RegistryID']; ?>" class="btn btn-outline-primary">
                    <i class="bi bi-bookmark-plus-fill card-link"></i> Favourite
                </button> -->

                <?php 
                
                
                // if (is_post_request()) {
                    if (isset($_SESSION['username'])) {
                        $name = $_SESSION['username'];
                        $sql = "SELECT user_id FROM member WHERE username='$name'";
                        $result = $connection ->query($sql);
                        $row = mysqli_fetch_assoc($result);
                        $user_id = $row['user_id'];
                    } else {
                        $user_id = "";
                    }
                    
                //     $art_id = $detailsOpts['RegistryID'];
                //     // echo $user_id. " and " . $art_id;
                //     $errors = [];

                    // $insertsql = "INSERT INTO favorite(user_id, art_id) VALUES ('$user_id', '$art_id')";
                    $existing_query = "SELECT COUNT(*) as count FROM favorite WHERE user_id = '".$user_id."' AND art_id = '".$registryID."'";
                    $existing_res = mysqli_query($connection, $existing_query);


                    // If the count is not 0, that means already in favorites
                    if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
                    // echo "Added to Favorites";
                    echo '<form method="post" action="unfavorite.php">';
                    echo '<button type="submit" name="fav" id="';
                    echo $detailsOpts['RegistryID'];
                    echo '" class="btn btn-outline-primary">';
                    echo '<i class="bi bi-bookmark-plus-fill card-link"></i> Unfavourite </button></form>';
                    } else {
                        echo '<form method="post" action="favorites.php">';
                        echo '<button type="submit" name="fav" id="';
                        echo $detailsOpts['RegistryID'];
                        echo '" class="btn btn-outline-primary">';
                        echo '<i class="bi bi-bookmark-plus-fill card-link"></i> favourite </button></form>';
                    }
                
                // }
                ?>
                <!-- </form>

                <form method="post" action="unfavorite.php">
                <button type="submit" name="fav" id="<?= $detailsOpts['RegistryID']; ?>" class="btn btn-outline-primary">
                    <i class="bi bi-bookmark-plus-fill card-link"></i> Unfavourite
                </button>
                </form> -->
                    <?php
                        // $upvotesql = "SELECT COUNT(*) as count FROM upvote WHERE art_id='".$registryID."'";
                        // $existing_upvote = mysqli_query($connection, $upvotesql);
                        
                        // $numvotes = mysqli_fetch_assoc($existing_upvote)['count'];
                        // echo '<form action="upvote.php" method="post" class="mt-auto">';
                        // echo '<button type="submit" name="vote" id="';
                        // echo $detailsOpts['RegistryID'];
                        // echo '" class="btn btn-outline-dark">';
                        // echo '<i class="far fa-arrow-alt-circle-up card-link"></i>';
                        // if ($numvotes == 1) {
                        //     echo $numvotes." Upvote";
                        // } else {
                        //     echo $numvotes. " Upvotes";
                        // }
                        // echo '</button></form>';
                    ?>
                    <?php 
                        $ip_address = get_ip();
                        $existing_query = "SELECT COUNT(*) as count FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$registryID."'";
                        $existing_res = mysqli_query($connection, $existing_query);
                
                        // If the count is not 0, that means already in favorites
                        if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
                            echo '<form action="unupvote.php" method="post" class="mt-auto">';
                        } else {
                            echo '<form action="upvote.php" method="post" class="mt-auto">';
                        }
                    ?>
                <!-- <form action="upvote.php" method="post" class="mt-auto"> -->
                    <button type="submit" name="vote" id="<?= $detailsOpts['RegistryID']; ?>" class="btn btn-outline-dark">
                        <i class="far fa-arrow-alt-circle-up card-link"></i> 
                    

                    <?php 
                        $upvotesql = "SELECT COUNT(*) as count FROM upvote WHERE art_id='".$registryID."'";
                        $existing_upvote = mysqli_query($connection, $upvotesql);
                        
                        $numvotes = mysqli_fetch_assoc($existing_upvote)['count'];
                        if ($numvotes == 1) {
                            echo $numvotes." Upvote";
                        } else {
                            echo $numvotes. " Upvotes";
                        }
                    ?>
                    </button>
                </form>
                <!-- <a class="ml-3"><i class="upvote far fa-arrow-alt-circle-up fa-2x"></i></a> -->

                <!--
                <form method="POST">
                    <input type="submit" name="heart" value="" class="heart fa fa-heart-o fa-2x">
                </form>
                -->

            
            </sidebar>
            <div class="col-6 limit"> 
                
                
                <?php 
                echo "<img class=\"img-details\" src=\"";
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
            <li class="m-2"><a data-toggle="tab" href="#comments">Comments</a></li>

        </ul>

        <div class="tab-content">
            <div id="location" class="<?php echo $location_active ?>">
                <h3 class="mt-5">Map</h3>
                <!-- <p class="mb-5"><?php echo $detailsOpts['Geom'];?></p> -->
                
                <?php 
                    if ($detailsOpts['Geom'] != ""){
                    // decode format to retrieve longitute and latitude for map
                    $string = $detailsOpts['Geom'];
                    $pattern = '{"type": "Point", "coordinates":}';
                    $replacement = '';
                    $edit = preg_replace($pattern, $replacement, $string);

                    $pattern2 = '{[\}\{]}';
                    $replacement2 = '';
                    $edit2 = preg_replace($pattern2, $replacement2, $edit);

                    $loc = str_replace( array('[',']') , ''  , $edit2 );
                    $lng_lat = explode(",", $loc);

                    // print_r($lng_lat);
                    //  echo "$lng_lat[1],$lng_lat[0]"; 
                ?>

                <style type="text/css">
                /* Set the size of the div element that contains the map */
                #map {
                    height: 400px;
                    /* The height is 400 pixels */
                    width: 100%;
                    /* The width is the width of the web page */
                }
                </style>
                <script>
                // Initialize and add the map
                function initMap() {
                    // The location of Uluru
                    const uluru = { lat: <?php echo "$lng_lat[1]"; ?>, lng: <?php echo "$lng_lat[0]"; ?> };
                    // The map, centered at Uluru
                    const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 16,
                    center: uluru,
                    });
                    // The marker, positioned at Uluru
                    const marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                    });
                }
                </script>

                 <!-- ENABLE BILLING FOR API KEY --> 
   
                <!--The div element for the map -->
                <div id="map"></div>
                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
         
                <script 
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN3oCpOvP7l-434QFxdfY32wBdo2DEPic&callback=initMap&libraries=&v=weekly"
                async
                ></script>
                <?php 
                    } else {
                        echo "<h5>Location information not avaliable<h5>";
                    }
                ?>

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
            <div id="comments" class="<?php echo $comment_active ?>">
            <h3 class="mt-5">Comments</h3>
                <div class="container mb-5">
                <?php 
                    
                    //write the comment form form users
                    comment_form($registryID);
                    

                    if (is_post_request()) {
                        $user_id = get_user_id($connection);
                        //insert the newest comment into the database before displaying all comments
                        if( isset($_POST['comment'])) {
                            $sqlComment = "INSERT INTO comment (message, art_id, user_id)
                                        VALUES ('$comment', '$registryID', '$user_id');";

                            // echo $sqlComment;

                            if(mysqli_query($connection, $sqlComment)){
                                // echo "<h3>Succesfully added</h3>"; 
                            } else {
                                echo "Opps there was an erorr: . " 
                                    . mysqli_error($connection);
                            }
                        } 

                        if( isset($_POST['comment-update'])) {
                            $sqlCommentUpdate = "UPDATE comment
                            SET message = \" ".$_POST['comment-update']." \"
                            WHERE comment_id =". $comment_id_edit.";" ;

                            if(mysqli_query($connection, $sqlCommentUpdate)){
                                echo "<p>Succesfully updated</p>"; 
                            } else {
                                echo "Opps there was an erorr: . " 
                                    . mysqli_error($connection);
                            }

                        }
                    }

                    // if( isset($_GET['id-delete'])) {
                    //     $sqlCommentDelete = "DELETE FROM comment
                    //     WHERE comment_id = ".$comment_id_delete.";" ;

                    //     if(mysqli_query($connection, $sqlCommentDelete)){
                    //         echo "<p>Succesfully deleted</p>"; 
                    //     } else {
                    //         echo "Opps there was an erorr: . " 
                    //             . mysqli_error($connection);
                    //     }

                    // }
                
                    

                    //read and format all the comments
                    $sqlReadComment = "SELECT comment.user_id, comment.art_id, comment.message, comment.timestamp, member.username, comment.comment_id FROM `comment` INNER JOIN member ON member.user_id=comment.user_id WHERE art_id = $registryID ORDER BY comment.timestamp DESC;";

                    $resultReadComment = mysqli_query($connection, $sqlReadComment);
        
                    echo "<ul class=\"media-list list-group\">";
                    //display the retrieved result on the webpage  
                    if (mysqli_num_rows($resultReadComment) > 0) {
                        while ($row = mysqli_fetch_array($resultReadComment)) {
                            if (isset($_GET['id-delete']) && $_GET['id-delete'] == $row['comment_id']) {
                                comment_delete($connection, 'id-delete', $comment_id_delete, $user_id, $row['user_id']);
                            } 
                            
                            comment_display($row['timestamp'], $row['username'], $row['message'], $user_id, $row['user_id'], $row['comment_id'], $row['art_id']);

                            if (isset($_GET['id']) && $_GET['id'] == $row['comment_id']) {
                                comment_edit($registryID, $comment_id_edit, $user_id, $row['user_id']);
                            }

                            // echo "<pre>";
                            // print_r($row);
                            // echo "</pre>";
                        }    
                    } else {
                        echo "<h4 class=\"mt-5 mb-5\">Be the first to write a comment!</h4>";
                    }
                    echo "</ul>";
                    comment_end();
                ?>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<section>
    
</section




<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>