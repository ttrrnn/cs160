<?php include('variables/variables.php');

    $db = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($db->connect_errno) {
        echo "Failed to connect to MySQL: " . $db->connect_error;
        exit();
    }

?>
