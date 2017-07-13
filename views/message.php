<?php
session_start();
$errors = $_SESSION['error_msg'];
 // remove all session variables
 session_unset(); 


?>