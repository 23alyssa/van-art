<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions
require_once('utilities/functions.php');

require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

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
    $user_res = mysqli_query($connection, $user_query);

    // If there is no record, then it should just display the error message
     if(mysqli_num_rows($user_res) != 0) {
      // Save the hashed password from db into a variable
        $hashed_password = mysqli_fetch_assoc($user_res)['hashed_password'];

        // Use password verify to check if the entered password matches
        if(password_verify($_POST['password'], $hashed_password)) {

          // Store session and redirect
          $_SESSION['username'] = $_POST['username'];
          redirect_to('members.php');
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
<?php include('utilities/header.php'); ?>
<?php echo display_errors($errors); ?>

<div id="content">
  <section class="">
    <div class="container-fluid bg-light-blue">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-sm-6 text-black">

          <div class="h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 bg-alt border-r">

            <form action="login.php" method="post" style="width: 23rem;">
              <h3 class="fw-normal mb-3 pb- mt-5 pt-5" style="letter-spacing: 1px;">Login</h3>

              <!-- USERNAME -->
              <div class="form-outline mb-4">
                <label class="form-label" for="username">Username:</label>
                <input type="text" name="username" value="" id="username" class="form-control form-control-lg" />
              </div>

              <!-- PASSWORD -->
              <div class="form-outline mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" value="" id="password" class="form-control form-control-lg" />
              </div>

              <!-- LOGIN BTN -->
              <div class="pt-1 mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit" value="login">Login</button>
              </div>

              <!-- LINK TO REGISTER PAGE -->
              <p class="pb-5">Don't have an account? <a href="register.php" class="link-primary">Register here</a></p>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<!-- <div id="content">
  <h1>Log in</h1>

  

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" value="login"/>
  </form>

</div> -->

<?php include('utilities/footer.php'); ?>
