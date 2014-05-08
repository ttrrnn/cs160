<?php require('includes/db_connect.php'); 

$rating_stmt = $db->prepare("SELECT course_id, rating FROM course_rating WHERE username = ?");
$rating_stmt->bind_param('s', $_GET['username']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($course_id, $rating);
$user_ratings = array();

while ($rating_stmt->fetch()) {
    $user_ratings[$course_id] = $rating; // This course was rated by user already
}

$db->close();
echo json_encode($user_ratings);

?> 
