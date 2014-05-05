<?php require('includes/users_connect.php');
if (!empty($_POST)) {
    /* Ensure that the user fills out fields, needed in case user
      does not have js enabled */
    if (empty($_POST['username'])) {
        ?>
        <script type="text/javascript">
            alert("Please enter a username."); 
            history.back(); 
        </script>
        <?php
        die('Please enter a username.');
    }
    if (empty($_POST['password'])) {
        ?>
        <script type="text/javascript">
            alert("Please enter a password."); 
            history.back(); 
        </script>
        <?php
        die('Please enter a password.');
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        ?>
        <script type="text/javascript">
            alert("Please enter a valid email."); 
            history.back(); 
        </script>
        <?php
        die('Please enter a valid email.');
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
        ?>
        <script type="text/javascript"> 
            alert("This username is already in use."); 
            history.back(); 
        </script>
        <?php
        die('This username is already in use.');
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
        ?>
        <script type="text/javascript"> 
            alert("This email address is already in use."); 
            history.back(); 
        </script>
        <?php
        die('This email address is already in use.');
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
    ?>
    <script type="text/javascript">
        alert("Congratulations! You registered successfully."); 
        location.href="index.php";
    </script>
    <?php
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
        <link href="fancyBox/source/jquery.fancybox.css" rel="stylesheet">
        <link href="DataTables-1.10.0/media/css/jquery.dataTables.css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
        <title>Educademy Register</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Registration</div>
                <div class="panel-body">
                <form id="theform" action="register.php" method="post" role="form"> 
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" value="" placeholder="Email"> 
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-lg">Register!</button>
                            <button type="reset" class="btn">Clear</button>
                        </div>
                    </fieldset>
                </form>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <!-- JS placed at the end of the document so the page loads faster -->
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/jquery.raty.js"></script>
        <script src="DataTables-1.10.0/media/js/jquery.dataTables.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="fancyBox/source/jquery.fancybox.pack.js"></script>
        <script src="js/application.js"></script>
    </body>
</html>
