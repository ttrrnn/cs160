<?php

$db = new mysqli("127.0.0.1", "sjsucsor_s5g414s", "N0VACITY", "sjsucsor_160s5g42014s");
    
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
}
else {
    $stmt = $db->prepare("SELECT course_image, title, category, start_date, course_length, course_link, site, profname FROM course_data, coursedetails WHERE course_data.id = coursedetails.course_id GROUP BY course_data.id");
    $stmt->execute();
    $stmt->bind_result($course_image, $title, $category, $start_date, $course_length, $course_link, $site, $professor_name);
    $course_data = array();
                            
    while ($stmt->fetch()) {
        if (false === strpos($course_image, '://')) {
            $course_image = 'http://' . $course_image;
        }

        $course = array (
            '<a href="' . $course_link . '"><img src="' . $course_image . '" width="200px" height="150px" /></a>',  
            $title,
            $category,
            $start_date,
            $course_length,
            $professor_name,
            $site
        );

        $course_data[] = $course;
    }

    $db->close();
    echo json_encode($course_data);
}  
   
?>
