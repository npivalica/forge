<?php
require_once('../../private/initialize.php');

unset($_SESSION['username']);
// $_SESSION['username'] = NULL;

redirect_to(url_for('/staff/login.php'));

?>
