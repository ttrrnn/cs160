<?php require('includes/users_connect.php');
    unset($_SESSION['username']);
    unset($_SESSION['user_ratings']);
    header("Location: index.php"); 
    die("Redirecting to: index.php");
?>
