<?php
ob_start(); // output buffering is turned on

session_start(); // turn on sessions

//display all errors on screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//header.php has information for bootstrap and page title
require('utilities/header.php');

// connect to database
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//functions.php contains all the helper functions to make the form and display the table
require('utilities/functions.php');

?>



<?php $page_title = 'Member'; ?>

<div id="content">

  <?php 
    echo $_SESSION['username'];
    $username = $_SESSION['username'];
    // create query for getting information about the user
    $sql = "SELECT * FROM member WHERE username='$username'";
    
    // if user clicks update button, updates the information from the account
    if (isset($_POST['update'])) { 
      // create variables for all the input information
      $firstname = $_POST['newfirstname'];
      $lastname = $_POST['newlastname'];
      $email = $_POST['newemail'];
      // query to update member's information
      $updatesql = "UPDATE member SET 
      first_name = '$firstname',
      last_name = '$lastname',
      email = '$email'
      WHERE username='$username'";
      // update data in database, if successful redirects to members
      if ($connection->query($updatesql) === TRUE) {
          echo "Record updated successfully";
          redirect_to('members.php');
      } else {
          echo "Error updating record: " . $connection->error;
      }
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

<?php include('utilities/footer.php'); ?>