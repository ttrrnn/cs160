<?php require('includes/db_connect.php'); 

$rating_stmt = $db->prepare("INSERT INTO course_rating VALUES(?, ?, ?)");
$rating_stmt->bind_param('isi', $_POST['courseId'], $_POST['username'], $_POST['stars']);
$rating_result = $rating_stmt->execute();

$db->close();

?> 