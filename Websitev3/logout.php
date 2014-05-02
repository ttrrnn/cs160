<?php require('includes/users_connect.php'); 
    unset($_SESSION['username']);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>
