<?php require('includes/db_connect.php');

session_start();

if (empty($_SESSION['username'])) {
	echo json_encode(null);
	return;
}

$statement = $db->prepare("SELECT course_id, title, rating
							 FROM course_data, course_rating
							 WHERE username = ? 
							 AND course_data.id = course_rating.course_id
							 ORDER BY title");

$statement->bind_param('s', $_SESSION['username']);
$result = $statement->execute();
$statement->bind_result($course_id, $title, $rating);
$user_data = array (
	"ratedCourses" => array(),
	"wishlist" => array()
);

while ($statement->fetch()) {
    $user_data['ratedCourses'][$course_id] = array (
    	"title" => $title,
    	"rating" => $rating
    );
}

$db->close();
$_SESSION['user_data'] = $user_data;
echo json_encode($user_data);

?> 
