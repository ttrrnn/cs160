<?php require('includes/db_connect.php'); 

session_start();

$statement = $db->prepare("INSERT INTO wishlist VALUES(?, ?)");
$statement->bind_param('si', $_SESSION['username'], $_POST['courseId']);
$result = $statement->execute();

$statement = $db->prepare("SELECT title
						   FROM course_data
						   WHERE id = ?");

$statement->bind_param('i', $_POST['courseId']);
$result = $statement->execute();
$statement->bind_result($title);
$statement->fetch();

$db->close();

$_SESSION['user_data']['wishlist'][$_POST['courseId']] = $title;

echo json_encode($title);

?> 