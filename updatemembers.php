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
  <h1>Update Data for <?php echo $_SESSION['username']?></h1>

  <?php echo display_errors($errors); ?>

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
                redirect_to(url_for('/van-art/members.php'));
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

  <form action="" method="post">
    
    First Name:<br />
    <input type="text" name="newfirstname" value="<?php echo $row['first_name'] ?>" /><br />
    Last Name:<br />
    <input type="text" name="newlastname" value="<?php echo $row['last_name'] ?>" /><br />
    Email:<br />
    <input type="text" name="newemail" value="<?php echo $row['email'] ?>" /><br />
    <input type="submit" name="update" value="update"/>
  </form>
<?php 
/*
if (empty($_POST['newfirstname'])) {
    $firstname = "";
} else {
    $firstname = $_POST['newfirstname'];
}

if (empty($_POST['newlastname'])) {
    $lastname = "";
} else {
    $lastname = $_POST['newlastname'];
}

if (empty($_POST['newemail'])) {
    $email = "";
} else {
    $email = $_POST['newemail'];
} 
*/

?>
  
</div>



<?php include(SHARED_PATH . '/../utilities/footer.php'); ?>