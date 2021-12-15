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

// on page load the comment is defined as empty
$comment = "";
$sqlComment ="";

//select which tabpane should be open when page reloads based on requests 
//if working on comments page should re-load with comments tab open
$comment_active ="tab-pane fade";
$location_active ="tab-pane fade in show active";

// if (!empty($_POST['post'])) {
        
    // get and initialize the varables from the comment form once submitted
    if( isset($_POST['comment'])) {
        $comment=($_POST['comment']); 

        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";

    } 

    //get and initalize the varibles from the upadated comment form
    if( isset($_POST['comment-update'])) {
        $comment_update=($_POST['comment-update']); 
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    }
  
// }

    // read the url passed into browser to determine which artwork to load 
    $artIDpass = $_GET['RegistryID'];

    //determine if a comment has been selected and records the comment id for updating 
    if (isset($_GET['id'])) {
        $comment_id_edit = $_GET['id'];
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    } 

    //determine if a comment has been selected and records the comment id for deleting
    if (isset($_GET['id-delete'])) {
        $comment_id_delete = $_GET['id-delete'];
        
        $comment_active = "tab-pane fade in show active";
        $location_active ="tab-pane fade";
    } 

    // create the query to read from the database for the artwork selected and passed into url 
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

    //store the variables seperately for easy access and less syntax problems
    $registryID = $detailsOpts['RegistryID'];
    $_SESSION['art'] = $registryID;

?>

<!-- display artwork content below -->
<section class="container">
    <div class="mt-5">
        <div class="row pt-5">
            <sidebar class="col-6">
                <!-- display header with year location and artists -->
                <h4><?php echo $detailsOpts['YearOfInstallation'];?>  |  <?php echo $detailsOpts['Neighbourhood'];?>  |  <?php echo $detailsOpts['FirstName']. " " .$detailsOpts['LastName'] ;?></h4>

                <!-- display more details about the artwork -->
                <ul class="list-unstyled">
                    <li>Type: <?php echo $detailsOpts['Type'];?></li>
                    <li>Status: <?php echo $detailsOpts['Status'];?></li>
                    <li>Site Address: <?php echo $detailsOpts['SiteAddress'];?></li>
                    <li>Primary Material: <?php echo $detailsOpts['PrimaryMaterial'];?></li>
                </ul>

                <?php 
                    // check if the user is logged in and retrieve their user_id information 
                    if (isset($_SESSION['username'])) {
                        $name = $_SESSION['username'];
                        $sql = "SELECT user_id FROM member WHERE username='$name'";
                        $result = $connection ->query($sql);
                        $row = mysqli_fetch_assoc($result);
                        $user_id = $row['user_id'];
                    } else {
                        $user_id = "";
                    }
                    
                    //checks if the artwork is favorited by the member
                    $existing_query = "SELECT COUNT(*) as count FROM favorite WHERE user_id = '".$user_id."' AND art_id = '".$registryID."'";
                    $existing_res = mysqli_query($connection, $existing_query);

                    //checks if the member have favorite the artwork and displays the corrospending favorite/unfavorite button for the artwork to interact with
                    // If the count is not 0, that means already in favorites
                    if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
                    // displays a button for members to unfavorite the artwork
                    echo '<form method="post" action="unfavorite.php">';
                    echo '<button type="submit" name="fav" id="';
                    echo $detailsOpts['RegistryID'];
                    echo '" class="btn btn-outline-primary">';
                    echo '<i class="bi bi-bookmark-plus-fill card-link"></i> Unfavourite </button></form>';
                    } else {
                        // displays a button for members to favorite the artwork
                        echo '<form method="post" action="favorites.php">';
                        echo '<button type="submit" name="fav" id="';
                        echo $detailsOpts['RegistryID'];
                        echo '" class="btn btn-outline-primary">';
                        echo '<i class="bi bi-bookmark-plus-fill card-link"></i> favourite </button></form>';
                    }
               
                    //retrieve ip address
                    $ip_address = get_ip();

                    //query for checking if the user have upvoted the artwork or not using ip address
                    $existing_query = "SELECT COUNT(*) as count FROM upvote WHERE IP_address = '".$ip_address."' AND art_id = '".$registryID."'";
                    $existing_res = mysqli_query($connection, $existing_query);
            
                    // If the count is not 0, that means already upvoted
                    if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
                        // clicking upvote causes to unupvote
                        echo '<form action="unupvote.php" method="post" class="mt-auto">';
                    } else {
                        // clicking upvote causes to upvote
                        echo '<form action="upvote.php" method="post" class="mt-auto">';
                    }
                ?>
                    <!-- display the upvotes button -->
                    <button type="submit" name="vote" id="<?= $detailsOpts['RegistryID']; ?>" class="btn btn-outline-dark">
                        <i class="far fa-arrow-alt-circle-up card-link"></i> 
                    
                    <!-- display the number of upvotes in the button -->
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
            
            </sidebar>

            <!-- display the image on the right side -->
            <div class="col-6 limit"> 
                <?php 
                    // check if the photo URL is empty use no image
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

<!-- display the tabs -->
<section class="container">
    <div class="mt-5">
        <ul class="nav nav-tabs">
            <!-- tab name and id link -->
            <li class="active m-2"><a data-toggle="tab" href="#location">Location</a></li>
            <li class="m-2"><a data-toggle="tab" href="#description">Description</a></li>
            <li class="m-2"><a data-toggle="tab" href="#artist-stat">Artist Statment</a></li>
            <li class="m-2"><a data-toggle="tab" href="#comments">Comments</a></li>

        </ul>

        <div class="tab-content">
            <!-- GOOGLE MAPS INFORMATION -->
            <div id="location" class="<?php echo $location_active ?>">
                <h3 class="mt-5">Map</h3>
                
                
                <?php 
                    // seperate the format of geom as used in database to get individual latitude and longitude
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

                        // final values stored in $lng_lat
                        $lng_lat = explode(",", $loc);

                        // if statment is contintued until displaying the map
                ?>

                <!-- google maps CSS -->
                <style type="text/css">
                /* Set the size of the div element that contains the map */
                #map {
                    height: 400px;
                    /* The height is 400 pixels */
                    width: 100%;
                    /* The width is the width of the web page */
                }
                </style>

                <!-- Google maps javascript -->
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
   
                <!--The div element for the map to display -->
                <div id="map"></div>
                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
         
                <script 
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN3oCpOvP7l-434QFxdfY32wBdo2DEPic&callback=initMap&libraries=&v=weekly"
                async
                ></script>
                <?php 
                // end if statment - if no geom avalible then display message
                    } else {
                        echo "<h5>Location information not avaliable<h5>";
                    }
                ?>
            </div>

            <!-- DESCRIPTION OF WORK -->
            <div id="description" class="tab-pane fade">
                <h3 class="mt-5">Description of Work</h3>
                <?php 
                    // check if the description is empty
                    if ($detailsOpts['DescriptionOfwork'] ==""){
                        echo "<h5 class=\"mb-5\">No description avaliable</h5>";
                    } else {
                        echo "<p class=\"mb-5\">";
                        echo $detailsOpts['DescriptionOfwork'];
                        echo "</p>";
                    }
                ?>
            </div>

             <!-- ARTIST STATEMENT -->
            <div id="artist-stat" class="tab-pane fade">
                <h3 class="mt-5">Artist Statment</h3>
                <?php 
                     // check if the statement is empty
                    if ($detailsOpts['ArtistProjectStatement'] ==""){
                        echo "<h5 class=\"mb-5\">No artist statement avaliable</h5>";
                    } else {
                        echo "<p class=\"mb-5\">";
                        echo $detailsOpts['ArtistProjectStatement'];
                        echo "</p>";
                    }
                ?>
            </div>

            <!-- COMMENTS -->
            <div id="comments" class="<?php echo $comment_active ?>">
                <h3 class="mt-5">Comments</h3>
                <div class="container mb-5">
                    <?php 
                        
                        //display the comment form
                        comment_form($registryID);
                        

                        //only if the user is logged in can they insert comments into the databse
                        if (is_post_request()) {
                            $user_id = get_user_id($connection);
                            //insert the newest comment into the database before displaying all comments
                            if( isset($_POST['comment'])) {
                                $sqlComment = "INSERT INTO comment (message, art_id, user_id)
                                            VALUES ('$comment', '$registryID', '$user_id');";

                                if(mysqli_query($connection, $sqlComment)){
                                    // echo "<h3>Succesfully added</h3>"; 
                                } else {
                                    echo "Opps there was an erorr: . " 
                                        . mysqli_error($connection);
                                }
                            } 

                            //only if users are logged in can they edit their comments
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

                        //query for displaying all the comments for that artwork
                        $sqlReadComment = "SELECT comment.user_id, comment.art_id, comment.message, comment.timestamp, member.username, comment.comment_id FROM `comment` INNER JOIN member ON member.user_id=comment.user_id WHERE art_id = $registryID ORDER BY comment.timestamp DESC;";

                        //process the query results
                        $resultReadComment = mysqli_query($connection, $sqlReadComment);
            
                        echo "<ul class=\"media-list list-group\">";
                        //display the retrieved result on the webpage  
                        if (mysqli_num_rows($resultReadComment) > 0) {
                            while ($row = mysqli_fetch_array($resultReadComment)) {
                                //if the user deleted their comment remove it from the database first 
                                if (isset($_GET['id-delete']) && $_GET['id-delete'] == $row['comment_id']) {
                                    comment_delete($connection, 'id-delete', $comment_id_delete, $user_id, $row['user_id']);
                                } 
                                
                                // display all the comments
                                comment_display($row['timestamp'], $row['username'], $row['message'], $user_id, $row['user_id'], $row['comment_id'], $row['art_id']);

                                // display the comment editing form 
                                if (isset($_GET['id']) && $_GET['id'] == $row['comment_id']) {
                                    comment_edit($registryID, $comment_id_edit, $user_id, $row['user_id']);
                                }
                            }    
                        } else {
                            // if there are no comments to display specificy they are first 
                            echo "<h4 class=\"mt-5 mb-5\">Be the first to write a comment!</h4>";
                        }
                        echo "</ul>";
                        comment_end(); 
                        // close the remaining div blocks 
                    ?>
                </div>
            </div>
        </div> 
        </div>
    </div>
</section>

<?php 
//page footer for bootstrap and copyright
require('utilities/footer.php');
?>