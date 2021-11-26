<?php
require_once('private/initialize.php');

$errors = [];
$username = '';
$password = '';

// TODO: This page should not show if a session is present.
// Redirect to staff index if a session is detected.
// if(isset($_SESSION['username'])) {redirect_to(url_for('van-art/browse.php'));}


// END TODO
if(is_post_request()) {
  // TODO: Verify the password matches the record
  // if it does not, throw an error message
  // otherwise set the session and redirect to dashboard
  if(!empty($_POST['username']) && !empty($_POST['password'])) {
    // Write a query to retrieve the hashed_password
    $user_query = "SELECT hashed_password FROM member WHERE username = '" . $_POST['username'] . "'";
    $user_res = mysqli_query($db, $user_query);

    // If there is no record, then it should just display the error message
     if(mysqli_num_rows($user_res) != 0) {
      // Save the hashed password from db into a variable
        $hashed_password = mysqli_fetch_assoc($user_res)['hashed_password'];

        // Use password verify to check if the entered password matches
        if(password_verify($_POST['password'], $hashed_password)) {

          // Store session and redirect
          $_SESSION['username'] = $_POST['username'];
          redirect_to(url_for('/../van-art/browse.php'));
        } else {
          // If verify fails, display an error message
          array_push($errors, "The entered password do not match our record.");
        }
      } else  {
        array_push($errors, "The account does not exist.");
      }
  } else {
    array_push($errors, "Username or password field is not filled.");
  }

  // END TODO
}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/../utilities/header.php'); ?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" />
  </form>

</div>

<?php include(SHARED_PATH . '/../utilities/footer.php'); ?>
