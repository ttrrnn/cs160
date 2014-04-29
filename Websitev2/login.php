<?php require_once("db_connect.php");

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
   
?>
