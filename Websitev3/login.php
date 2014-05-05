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
            $_SESSION['username'] = $_POST['username'];         
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
        <title>Educademy Login</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="container">
            <div class="panel panel-info">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form id="theform" action="login.php" method="post" role="form">
                        <fieldset>
                            <div class="form-group">
                                <div class="controls">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $submitted_username; ?>" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls">
                                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password" required> 
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-info btn-lg">Login</button>
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
