<?php require('includes/db_connect.php'); 

session_start();

$rating_stmt = $db->prepare("INSERT INTO wishlist VALUES(?, ?)");
$rating_stmt->bind_param('si', $_SESSION['username'], $_POST['courseId']);
$rating_result = $rating_stmt->execute();

$db->close();

$_SESSION['wishlist'][] = $_POST['courseId'];

?> 