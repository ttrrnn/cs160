<?php require('includes/db_connect.php'); 

session_start();

$rating_stmt = $db->prepare("INSERT INTO course_rating VALUES(?, ?, ?)");
$rating_stmt->bind_param('isi', $_POST['courseId'], $_SESSION['username'], $_POST['rating']);
$rating_result = $rating_stmt->execute();

$rating_stmt = $db->prepare("SELECT title, AVG(rating)
							 FROM course_data, course_rating
							 WHERE course_data.id = course_rating.course_id
							 AND course_id = ?
							 AND username = ?
							 GROUP BY course_id");

$rating_stmt->bind_param('is', $_POST['courseId'], $_SESSION['username']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($title, $rating);

if (!$rating_stmt->fetch()) {
    $rating = 0;
}

$db->close();

$course_rating = array (
	"title" => $title,
    "rating" => $rating
);

$_SESSION['user_data']['ratedCourses'][$_POST['courseId']] = $course_rating;

echo json_encode($course_rating);

?> 
