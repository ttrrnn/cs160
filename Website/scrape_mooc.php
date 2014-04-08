<?php

$db = new mysqli("127.0.0.1", "sjsucsor_s5g414s", "N0VACITY", "sjsucsor_160s5g42014s");
    
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
}
else {
    $stmt = $db->prepare("SELECT course_image, title, category, start_date, course_length, site FROM course_data");
    $result = $stmt->execute();
    $stmt->bind_result($course_image, $title, $category, $start_date, $course_length, $course_link);
    $course_data = "<tbody>";
                            
    while ($stmt->fetch()) {
        $course_data .= "<tr>";
        $course_data .= "<td>" . $title . "</td>";
        $course_data .= "<td>" . $category . "</td>";
        $course_data .= "<td>" . $start_date . "</td>";
        $course_data .= "<td>" . $course_length . "</td>";
        $course_data .= "<td>" . "TODO" . "</td>";
        $course_data .= "<td>" . "TODO" . "</td>";
        $course_data .= "<td>" . $site . "</td>";
        if (false === strpos($course_image, '://')) {
            $course_image = 'https://' . $course_image;
        }
        $course_data .= "<td><img src= '" . $course_image . "'></td>";
        $course_data .= "</tr>";
    }

    $course_data .= "</tbody>";
    $db->close();
    echo $course_data;
}  
   
?>
