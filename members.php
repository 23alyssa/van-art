<?php
ob_start(); // output buffering is turned on

session_start(); // turn on sessions

//display all errors on screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//header.php has information for bootstrap and page title
require('utilities/header.php');

require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

?>



<?php $page_title = 'Member'; ?>

<div id="content">
    <section class="container-fluid">
        <div class="">
            <div class="row">
                <sidebar class="col-3">
                        <div class="m-3">
                            <!-- display the username of loggen in user -->
                            <h3 class="mt-2 mb-1"><?php echo $_SESSION['username']?></h3>
                            <!-- form to detect the edit information button -->
                            <form action="updatemembers.php" method="post">
                                <?php 
                                    // takes the session's username and fetches the account information
                                    $username = $_SESSION['username'];
                                    $sql = "SELECT * FROM member WHERE username='$username'";
                                    $result = $connection ->query($sql);
                                    $row = mysqli_fetch_assoc($result);
                                    // display more account details 
                                    echo "<h6>".$row['first_name']." ".$row['last_name']."<br></h6>";
                                    echo "<h6>Email: ". $row['email']. "</h6>";
                                ?>
                            <!-- edit information button -->
                            <input class="mt-3 btn btn-primary px-4" type="submit" value="Edit Information"/>
                            </form>
                        </div>
                </sidebar>
                <div class="col-9 bg-alt"> 
                    <div class="row m-5" id="result">
                        <!-- username in the favoruties title -->
                        <h3 class="text-center mb-5"><?php echo $_SESSION['username']."'s Favourites"?></h3>
                            <?php
                                //display the favourites information from the database
                                $user = $row['user_id'];
                                // reorganize in descending order of which artwork is last favorited by member
                                $favsql = "SELECT art_id FROM favorite WHERE user_id = '$user' ORDER BY timestamp DESC";
                                $favresults = $connection -> query($favsql);
                                // if there is data on favorites for this member using user_id then display results
                                while ($favrow = $favresults -> fetch_array(MYSQLI_ASSOC)) {
                                    $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, public_art.Type, public_art.Neighbourhood, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art WHERE RegistryID = '".$favrow['art_id']."'";
                                    $results = mysqli_query($connection, $sql);
                                    if ($results != NULL) {
                                        // display the artwork in card form
                                        while ($row = mysqli_fetch_array($results)) {
                                            $output =createCard($row);
                                        }    
                                    }
                                }

                            ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('utilities/footer.php'); ?>