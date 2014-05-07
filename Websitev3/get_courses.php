<?php require('includes/db_connect.php');

    $stmt = $db->prepare("SELECT course_data.id,
                                 course_image,
                                 title,
                                 category,
                                 start_date,
                                 course_length,
                                 course_link,
                                 site,
                                 profname,
                                 video_link

                          FROM   course_data,
                                 coursedetails

                          WHERE  course_data.id = coursedetails.course_id

                          GROUP BY course_data.id
                        ");
    $stmt->execute();
    $stmt->bind_result($id, $course_image, $title, $category, $start_date, $course_length, $course_link, $site, $professor_name, $video_link);
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

        $db2 = new mysqli($db_host, $db_user, $db_password, $db_name);
        if ($db2->connect_errno) {
            echo "Failed to connect to MySQL: " . $db->connect_error;
            exit();
        }

        $rating_stmt = $db2->prepare("SELECT AVG(rating) FROM course_rating WHERE course_id = ?");
        $rating_stmt->bind_param('i', $id);
        $rating_result = $rating_stmt->execute();
        $rating_stmt->bind_result($rating);

        if (!$rating_stmt->fetch()) {
            $rating = 0;
        }
        
        $course = array (
            '<a class="bw pic fancybox" data-fancybox-type="iframe" href="' . $video_link . '"><img src="' . $course_image . '"/></a>',
            '<a href="' . $course_link . '">' . $title . '</a>',
            '<button type="button" id="' . $id . '">Rate</button><div class="raty" value="' . $rating . '"><span>' . $rating . '</span></div>', 
            $category,
            $start_date,
            $course_length,
            $professor_name,
            $site
        );

        $course_data[] = $course;
    }

    $db->close();
    $db2->close();
    echo json_encode($course_data);
    
?>
