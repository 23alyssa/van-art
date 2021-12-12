<?php

ob_start(); // output buffering is turned on

session_start(); // turn on sessions

require_once('utilities/functions.php');


// TODO: Remove the username session
unset($_SESSION['username']);
// or you could use
// $_SESSION['username'] = NULL;

// End of TODO

redirect_to('browse.php');

?>
