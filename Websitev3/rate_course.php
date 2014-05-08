<?php require('includes/db_connect.php'); 

$rating_stmt = $db->prepare("INSERT INTO course_rating VALUES(?, ?, ?)");
$rating_stmt->bind_param('isi', $_POST['courseId'], $_POST['username'], $_POST['stars']);
$rating_result = $rating_stmt->execute();

$rating_stmt = $db->prepare("SELECT AVG(rating) FROM course_rating WHERE course_id = ?");
$rating_stmt->bind_param('i', $_POST['courseId']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($rating);

if (!$rating_stmt->fetch()) {
    $rating = 0;
}

$db->close();
echo json_encode($rating);

?> 