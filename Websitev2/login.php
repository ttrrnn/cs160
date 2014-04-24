<?php

$db = new mysqli("127.0.0.1", "sjsucsor_s5g414s", "N0VACITY", "sjsucsor_160s5g42014s");
    
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
}
else {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $db->prepare("SELECT password FROM user WHERE user.username = ?");
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();
    $stmt->bind_result($retrieved_password);
                            
    if ($stmt->fetch()) {
        echo "false";
    }

    $db->close();
    echo "true";
}  
   
?>
