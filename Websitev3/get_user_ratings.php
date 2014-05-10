<?php require('includes/db_connect.php');

session_start();

$rating_stmt = $db->prepare("SELECT course_id, title, rating
							 FROM course_data, course_rating
							 WHERE username = ? 
							 AND course_data.id = course_rating.course_id
							 ORDER BY title");

$rating_stmt->bind_param('s', $_SESSION['username']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($course_id, $title, $rating);
$user_ratings = array();

while ($rating_stmt->fetch()) {
    $user_ratings[$course_id] = array (
    	"title" => $title,
    	"rating" => $rating
    );
}

$db->close();
$_SESSION['user_ratings'] = $user_ratings;
echo json_encode($user_ratings);

?> 
