<?php require('includes/users_connect.php');
    unset($_SESSION['username']);
    unset($_SESSION['user_data']);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>
