<?php include('variables/variables.php');

session_start();

function echoActiveClass($requestUri) {
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
?>

<div class="navbar-wrapper">
    <div class="container">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img alt="<?php echo $heading ?>" src="images/educademy-logo.png"></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                       <li <?= echoActiveClass("index") ?>><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                        <li <?= echoActiveClass("courses") ?>><a href="courses.php"><span class="glyphicon glyphicon-book"></span>Courses</a></li>
                        <li <?= echoActiveClass("about") ?>><a href="about.php"><span class="glyphicon glyphicon-bookmark"></span>About</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                            <?php if (!isset($_SESSION['username'])): ?>
                            <li <?= echoActiveClass("register") ?>><a href="register.php">Register</a></li>
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">Log In <strong class="caret"></strong></a>
                                <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                                    <form id="login-form" action="login.php" method="post">
                                        <fieldset>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="text" id="username" name="username" value="<?php echo $submitted_username; ?>" placeholder="Username" required>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="password" id="password" name="password" value="" placeholder="Password" required> 
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-info" value="">Login</button> 
                                            </div>
                                        </fieldset>
                                    </form> 
                                </div>
                            </li>
                            <?php else: ?>
                            <li><a href=""><span class="glyphicon glyphicon-user"></span>User Profile</a></li>
                            <li class="divider-vertical"></li>
                            <li><a href="logout.php">Log Out</a></li>
                            <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>          
</div>
