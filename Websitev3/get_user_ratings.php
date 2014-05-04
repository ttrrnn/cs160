<?php 

require('variables/variables.php'); 
$db2 = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($db2->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
    exit();
}

$rating_stmt = $db2->prepare("SELECT course_id FROM course_rating WHERE username = ?");
$rating_stmt->bind_param('s', $_GET['username']);
$rating_result = $rating_stmt->execute();
$rating_stmt->bind_result($course_id);
$user_ratings = array();

while ($rating_stmt->fetch()) {
    $user_ratings[$course_id] = true; // This course was rated by user already
}

echo json_encode($user_ratings);

?> 
