<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions

require_once('utilities/functions.php');


// Remove the username session
unset($_SESSION['username']);

redirect_to('browse.php');

?>
