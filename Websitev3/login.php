<?php require('includes/users_connect.php'); 
    $submitted_username = ''; 

    if(!empty($_POST)) { 
        $query = "SELECT password, salt FROM users WHERE username = :username"; 

        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
          
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex){
            die("Failed to run query: " . $ex->getMessage());
        } 

        $login_ok = false; 
        $row = $stmt->fetch(); 

        if ($row) { 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            
            if($check_password === $row['password']){
                $login_ok = true;
            } 
        } 
 
        if ($login_ok) {
            $db2 = new mysqli($db_host, $db_user, $db_password, $db_name);

            if ($db2->connect_errno) {
                echo "Failed to connect to MySQL: " . $db->connect_error;
                exit();
            }

            $rating_stmt = $db2->prepare("SELECT course_id FROM course_rating WHERE username = ?");
            $rating_stmt->bind_param('s', $_POST['username']);
            $rating_result = $rating_stmt->execute();
            $rating_stmt->bind_result($course_id);

            while ($rating_stmt->fetch()) {
                $user_ratings[$course_id] = true; // This course was rated my user already
            }
            
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['rated_courses'] = $user_ratings;
            unset($row['salt']); 
            unset($row['password']); 
            header("Location: index.php"); 
            die("Redirecting to: index.php"); 
        } 
        else { 
            ?>
            <script type="text/javascript"> 
                alert("Invalid username or password."); 
                history.back(); 
            </script>
            <?php
            die('Invalid username or password.'); 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
?> 
