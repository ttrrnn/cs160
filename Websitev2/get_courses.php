<?php

$db = new mysqli("127.0.0.1", "sjsucsor_s5g414s", "N0VACITY", "sjsucsor_160s5g42014s");
    
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
}
else {
    $stmt = $db->prepare("SELECT course_image, title, category, start_date, course_length, course_link, site, profname, profimage FROM course_data, coursedetails WHERE course_data.id = coursedetails.course_id");
    $result = $stmt->execute();
    $stmt->bind_result($course_image, $title, $category, $start_date, $course_length, $course_link, $site, $professor_name, $professor_image);
    $course_data = array();
                            
    while ($stmt->fetch()) {
        if (false === strpos($course_image, '://')) {
            $course_image = 'https://' . $course_image;
        }

        if (false === strpos($professor_image, '://')) {
            $professor_image = 'https://' . $profimage;
        }

        $course = array (
            "course_link" => $course_link,
            "course_image" => $course_image,
            "title" => $title,
            "category" => $category,
            "start_date" => $start_date,
            "course_length" => $course_length,
            "professor_name" => $professor_name,
            "professor_image" => $professor_image,
            "site" => $site
        );

        $course_data[] = $course;
    }

    $db->close();
    echo json_encode($course_data);
}  
   
?>
