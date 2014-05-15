<?php include('variables.php');
    $db = new mysqli($db_host, $db_user, $db_password, $db_name);
    $db->set_charset("utf8");
    
    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: " . $db->connect_error;
        exit();
    }
?>
