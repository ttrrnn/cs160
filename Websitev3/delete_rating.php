<?php require('includes/db_connect.php'); 

session_start();

foreach ($_POST['deleted_course'] as $courseId) {
	$rating_stmt = $db->prepare("DELETE FROM course_rating WHERE course_id = ? AND username = ?");
	$rating_stmt->bind_param('is', $_POST['courseId'], $_SESSION['username']);
	$rating_result = $rating_stmt->execute();
	unset($_SESSION['user_ratings'][$courseId]); 
	echo $courseId . " has been deleted by " . $_SESSION['username'] . "\n";
}

$db->close();

?> 