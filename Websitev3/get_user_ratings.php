<?php require('includes/db_connect.php'); 

$rating_stmt = $db->prepare("SELECT course_id, title, rating
							 FROM course_data, course_rating
							 WHERE username = ? 
							 AND course_data.id = course_rating.course_id");

$rating_stmt->bind_param('s', $_POST['username']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($course_id, $title, $rating);
$user_ratings = array();

while ($rating_stmt->fetch()) {
    $user_ratings[$course_id] = array(
    	"title" => $title,
    	"rating" => $rating
    );
}

$db->close();
echo json_encode($user_ratings);

?> 
