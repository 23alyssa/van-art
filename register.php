<?php
ob_start(); // output buffering is turned on

session_start(); // turn on sessions
require_once('utilities/functions.php');

$errors = [];

// connect to database
require('utilities/db.php');
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// check connection is successful
if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
  }

if(is_post_request()) {

  // Check password match 
  if($_POST['password'] === $_POST['password_confirm']) {
    // If password matches, check for existing user
    $existing_query = "SELECT COUNT(*) as count FROM member WHERE username = '" . $_POST['username'] . "'";
    $existing_res = mysqli_query($connection, $existing_query);

    // If the count is not 0, that means an account with the same username already exists
    if(mysqli_fetch_assoc($existing_res)['count'] != 0) {
      array_push($errors, 'The username already exists in the database, please try another username instead');
    } else {
      // Else encrpyt the password
      $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      
      echo "<h1>".$_POST['username']."</h1>";

      // insert the information inputed by user to register
      $insert_user_query = "INSERT INTO member(username, email, hashed_password, first_name, last_name) VALUES (
                            '" . mysqli_real_escape_string($connection, $_POST['username'])  . "',
                            '" . mysqli_real_escape_string($connection, $_POST['email']) . "',
                            '" . mysqli_real_escape_string($connection, $hashed_password) . "',
                            '" . mysqli_real_escape_string($connection, $_POST['first_name']) . "',
                            '" . mysqli_real_escape_string($connection, $_POST['last_name']) . "')";

      if(mysqli_query($connection, $insert_user_query)) {
        // INSERT is successful, save a session then redirect to members page
        $_SESSION['username'] = $_POST['username'];
        redirect_to('members.php');
      } else {
        // Display the mysql error if failed
        array_push($errors, mysqli_error($connection));
      }
    }
  } else {
    array_push($errors, 'Password do not match');
  }

}

?>

<?php $page_title = 'Register'; ?>
<?php include('utilities/header.php'); ?>

<div id="content">
  <?php echo display_errors($errors); ?>
  <section class="vh-100">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 text-black">

          <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <!-- create the registration form -->
            <form action="register.php" method="post" style="width: 23rem;">

              <h3 class="fw-normal mb-2 pb-2" style="letter-spacing: 1px;">Create an Account</h3>

              <!-- FIRST NAME -->
              <div class="form-outline mb-1">
                <label class="form-label" for="fname">First Name:</label>
                <input type="text" name="first_name" value="" required id="fname" class="form-control form-control" />
              </div>

              <!-- LAST NAME -->
              <div class="form-outline mb-1">
                <label class="form-label" for="lname">Last Name:</label>
                <input type="text" name="last_name" value="" required id="lname" class="form-control form-control" />
              </div>

              <!-- EMAIL -->
              <div class="form-outline mb-1">
                <label class="form-label" for="email">Email:</label>
                <input type="text" name="email" value="" required id="email" class="form-control form-control" />
              </div>

              <!-- USERNAME -->
              <div class="form-outline mb-1">
                <label class="form-label" for="username">Username:</label>
                <input type="text" name="username" value="" required id="username" class="form-control form-control" />
              </div>

              <!-- PASSWORD -->
              <div class="form-outline mb-1">
                <label class="form-label" for="password">Password:</label>
                <input type="password" name="password" value="" required id="password" class="form-control form-control" />
              </div>

              <!-- CONFIRM PASSOWRD -->
              <div class="form-outline mb-1">
                <label class="form-label" for="password-c">Confirm password:</label>
                <input type="password" name="password_confirm" value="" required id="password-c" class="form-control form-control" />
              </div>

              <!-- LOGIN BUTTON -->
              <div class="pt-1 mb-1">
                <button class="btn btn-primary btn-lg btn-block" type="submit" value="signup">Sign up</button>
              </div>

              <!-- LINK TO REGISTER PAGE -->
              <p>Already have an account? <a href="login.php" class="link-primary">Login here</a></p>

            </form>

          </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="assets/van-art.jpeg" alt="register image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('utilities/footer.php'); ?>
