<?php require_once("db_connect.php");

    $stmt = $db->prepare("SELECT course_image, title, category, start_date, course_length, course_link, site, profname FROM course_data, coursedetails WHERE course_data.id = coursedetails.course_id GROUP BY course_data.id");
    $stmt->execute();
    $stmt->bind_result($course_image, $title, $category, $start_date, $course_length, $course_link, $site, $professor_name);
    $course_data = array();
                            
    while ($stmt->fetch()) {
        if (false === strpos($course_image, '://')) {
            $course_image = 'http://' . $course_image;
        }

        if ($start_date == "0000-00-00") {
            $start_date = "Self Paced";
        }
        
        if ($course_length <= 0) {
            $course_length = "Self Paced";
        }
        
        $course = array (
            '<div class="bw pic"><a href="' . $course_link . '"><img src="' . $course_image . '"/></a></div>',
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
   
?>
