<?php
require_once('private/initialize.php');

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

  <?php echo display_errors($errors); ?>

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
</div>



<?php include(SHARED_PATH . '/../utilities/footer.php'); ?>