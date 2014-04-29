<?php require_once("db_connect.php");

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password-confirmation'];

    if ($password !== $passwordConfirmation) {
        echo "Password mismatch";
        return;
    }

    $stmt = $db->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param('s', $username);
    $result = $stmt->execute();
    $stmt->bind_result($retrieved_password);
                        
    if ($stmt->fetch()) {
        echo "Account exists";
        $db->close();
        return;
    }

    $stmt = $db->prepare("INSERT INTO user VALUES(?, ?, ?)");
    $stmt->bind_param('sss', $username, $email, $password);
    $result = $stmt->execute();
    $db->close();
    echo "True";
   
?>
