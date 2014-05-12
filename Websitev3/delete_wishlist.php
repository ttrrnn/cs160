<?php require('includes/db_connect.php'); 

session_start();

foreach ($_POST['deleted_course'] as $courseId) {
	$rating_stmt = $db->prepare("DELETE FROM wishlist WHERE course_id = ? AND username = ?");
	$rating_stmt->bind_param('is', $courseId, $_SESSION['username']);
	$rating_result = $rating_stmt->execute();
	unset($_SESSION['user_data']['wishlist'][$courseId]); 
}

$db->close();

?> 