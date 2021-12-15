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
  <!-- <h1>Update Data for <?php echo $_SESSION['username']?></h1> -->

  <?php 
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM member WHERE username='$username'";
    

    if (isset($_POST['update'])) { 
        
            $firstname = $_POST['newfirstname'];
            $lastname = $_POST['newlastname'];
            $email = $_POST['newemail'];
            $updatesql = "UPDATE member SET 
            first_name = '$firstname',
            last_name = '$lastname',
            email = '$email'
            WHERE username='$username'";
            if ($connection->query($updatesql) === TRUE) {
                echo "Record updated successfully";
                redirect_to('members.php');
            } else {
                echo "Error updating record: " . $connection->error;
            }
        
        /*
        mysqli_query($connection, "UPDATE member SET first_name='".$_POST['newfirstname']."',last_name='".$_POST['newlastname']."',email='".$_POST['newemail']."' WHERE username='$username'");
        */
    }

    $result = $connection ->query($sql);
    $row = mysqli_fetch_assoc($result);
    
  ?>

<div id="content">
  <section class="">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col text-black">

          <div class="h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 ">

            <form action="" method="post" style="width: 23rem;">
              <h3 class="fw-normal mb-3 pb- mt-5 pt-5" style="letter-spacing: 1px;">Update <?php echo $row['first_name']. "'s" ?> Account Information</h3>

              <!-- FIRSTNAME -->
              <div class="form-outline mb-4">
                <label class="form-label" for="fname">First Name:</label>
                <input type="text" name="newfirstname" value="<?php echo $row['first_name'] ?>" id="fname" class="form-control form-control-lg" />
              </div>

              <!-- LAST NAME -->
              <div class="form-outline mb-4">
                <label class="form-label" for="lname">Last Name:</label>
                <input type="text" name="newlastname" value="<?php echo $row['last_name'] ?>" id="lname" class="form-control form-control-lg" />
              </div>

              <!-- EMAIL -->
              <div class="form-outline mb-4">
                <label class="form-label" for="email">Email:</label>
                <input type="text" name="newemail" value="<?php echo $row['email'] ?>" id="email" class="form-control form-control-lg" />
              </div>

              <!-- LOGIN BTN -->
              <div class="pt-1 mb-5">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="update" value="update">Update</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- 
  <form action="" method="post">
    
    First Name:<br />
    <input type="text" name="newfirstname" value="<?php //echo $row['first_name'] ?>" /><br />
    Last Name:<br />
    <input type="text" name="newlastname" value="<?php //echo $row['last_name'] ?>" /><br />
    Email:<br />
    <input type="text" name="newemail" value="<?php //echo $row['email'] ?>" /><br />
    <input type="submit" name="update" value="update"/>
  </form>
  
</div> -->



<?php include('utilities/footer.php'); ?>