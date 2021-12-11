<?php
require_once('private/initialize.php');

$errors = [];

// Import the db configuration file here and create a connection to the DB
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Make sure the connection is successfully established, otherwise stop processing the rest of the script.
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

// TODO: This page should not show if a session is present.
// Redirect to staff index if a session is detected.
// if(isset($_SESSION['username'])) {redirect_to(url_for('van-art/browse.php'));}

// END TODO
if(is_post_request()) {
  // TODO: check for existing user account, if there is none, encrypt the password and save the entry
  // Make sure password matches
  // After the entry is inserted successfully, redirect to dashboard page

  // Check password match first to save time
  if($_POST['password'] === $_POST['password_confirm']) {
    // If password matches, check for existing user
    $existing_query = "SELECT COUNT(*) as count FROM member WHERE username = '" . $_POST['username'] . "'";
    $existing_res = mysqli_query($db, $existing_query);

    // If the count is not 0, that means an account with the same username already exists
    if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
      array_push($errors, 'The username already exists in the database, please try another username instead');
    } else {
      // Else encrpyt the password
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      
      echo "<h1>".$_POST['username']."</h1>";

      $insert_user_query = "INSERT INTO member(username, email, hashed_password, first_name, last_name) VALUES (
                            '" . mysqli_real_escape_string($db, $_POST['username'])  . "',
                            '" . mysqli_real_escape_string($db, $_POST['email']) . "',
                            '" . mysqli_real_escape_string($db, $hashed_password) . "',
                            '" . mysqli_real_escape_string($db, $_POST['first_name']) . "',
                            '" . mysqli_real_escape_string($db, $_POST['last_name']) . "')";

      if(mysqli_query($db, $insert_user_query)) {
        // INSERT is successful, save a session then redirect to dashboard
        $_SESSION['username'] = $_POST['username'];
        redirect_to(url_for('/van-art/members.php'));
      } else {
        // Display the mysql error if failed
        array_push($errors, mysqli_error($db));
      }
    }
  } else {
    array_push($errors, 'Password do not match');
  }


  // END TODO
}

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/../utilities/header.php'); ?>

<div id="content">
  <h1>Register</h1>

  <?php echo display_errors($errors); ?>

  <form action="register.php" method="post">
    First Name:<br />
    <input type="text" name="first_name" value="" required /><br />
    Last Name:<br />
    <input type="text" name="last_name" value="" required /><br />
    Email:<br />
    <input type="text" name="email" value="" required /><br />
    Username:<br />
    <input type="text" name="username" value="" required /><br />
    Password:<br />
    <input type="password" name="password" value="" required /><br />
    Confirm Password:<br />
    <input type="password" name="password_confirm" value="" required /><br />
    <input type="submit" />
  </form>
</div>

<?php include(SHARED_PATH . '/../utilities/footer.php'); ?>
