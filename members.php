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
  <h1>Hello <?php echo $_SESSION['username']?></h1>

  <form action="updatemembers.php" method="post">
  <?php 
  $username = $_SESSION['username'];
  $sql = "SELECT * FROM member WHERE username='$username'";
  $result = $connection ->query($sql);
  $row = mysqli_fetch_assoc($result);
  echo "First Name: ". $row['first_name']."<br>";
  echo "Last Name: ". $row['last_name']."<br>";
  echo "Email: ". $row['email'];
  ?>
  <br>
  <input type="submit" value="Edit Information"/>
  </form>
  <h1> Favorites </h1>
</div>

<section class="container-fluid bg-alt">
    <div class="container">
        <div class="row pt-5">
            <div class="col-9"> 
                <div class="row" id="result">
                    <h3 class="text-center" id="textChange">Favorites</h3>
                    <?php
                    
                    $user = $row['user_id'];
                    $favsql = "SELECT art_id FROM favorite WHERE user_id = '$user' ORDER BY timestamp DESC";
                    $favresults = $connection -> query($favsql);
                    while ($favrow = $favresults -> fetch_array(MYSQLI_ASSOC)) {
                      $sql = "SELECT public_art.RegistryID, public_art.PhotoURL, public_art.YearOfInstallation, public_art.Type, public_art.Neighbourhood, SUBSTRING(public_art.DescriptionOfwork,1,70) FROM public_art WHERE RegistryID = '".$favrow['art_id']."'";
                      $results = mysqli_query($connection, $sql);
                      if ($results != NULL) {
                        while ($row = mysqli_fetch_array($results)) {
                            $output =createCard($row);
                            // print_r($row);
                        }    
                    }
                    }

                    ?>
                </div>
            </div>
        </div>
        <?php
            
        ?>
    </div>

</section>



<?php include('utilities/footer.php'); ?>