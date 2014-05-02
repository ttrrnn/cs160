<?php require('includes/users_connect.php');
if (!empty($_POST)) {
    // Ensure that the user fills out fields 
    if (empty($_POST['username'])) {
        die("Please enter a username.");
    }
    if (empty($_POST['password'])) {
        die('Please enter a password.');
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die('Please enter an email.');
    }

    // Check if the username is already taken
    $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        ";
    $query_params = array(':username' => $_POST['username']);
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    $row = $stmt->fetch();
    if ($row) {
        die('This username already in use.');
    }
    $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        ";
    $query_params = array(
        ':email' => $_POST['email']
    );
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    $row = $stmt->fetch();
    if ($row) {
        echo "<script type='text/javascript'>alert('This email address already in use.');</script>";
    }

    // Add row to database 
    $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt, 
                email 
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email 
            ) 
        ";

    // Security measures
    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    $password = hash('sha256', $_POST['password'] . $salt);
    for ($round = 0; $round < 65536; $round++) {
        $password = hash('sha256', $password . $salt);
    }
    $query_params = array(
        ':username' => $_POST['username'],
        ':password' => $password,
        ':salt' => $salt,
        ':email' => $_POST['email']
    );
    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    } catch (PDOException $ex) {
        die("Failed to run query: " . $ex->getMessage());
    }
    header("Location: index.php");
    die("Redirecting to index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
        <title>Educademy Register</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="container">
            <h1>Registration</h1>
            <form class="form" id="form" action="register.php" method="post"> 
                <fieldset>
                    <div class="form-group">
                        <label class="control-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>                        
                        <input type="text" class="form-control" id="email" name="email" value=""> 
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label> 
                        <input type="password" class="form-control" id="password" name="password" value="">
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success btn-large">Register!</button>
                        <button type="reset" class="btn">Clear</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <?php include('includes/footer.php'); ?>
        <!-- JS placed at the end of the document so the page loads faster -->
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#form"").validate(
                {
                    rules: {
                        username: {
                            minlength: 2,
                            required: true
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            minlength: 6,
                            required: true
                        }
                    }
                    highlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }
                });
            });   
        </script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
