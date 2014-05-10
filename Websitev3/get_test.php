<?php require('includes/db_connect.php');

    $stmt = $db->prepare("SELECT title,
                                 category,
                                 site
                                 
                          FROM   course_data
                          
                          ORDER BY RAND()
                          
                          LIMIT 10");
    $stmt->execute();
    $stmt->bind_result($title, $category, $site);
    $course_data = array();
                            
    while ($stmt->fetch()) {
        $course = array (
            "name" => 'course.' . $title,
            "imports" => 'site.' . $site,
        );

        $course_data[] = $course;
    }

    $db->close();
    echo json_encode($course_data);
    
?>