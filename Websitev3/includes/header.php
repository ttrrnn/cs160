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
                        <li <?= echoActiveClass("index") ?>><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li <?= echoActiveClass("courses") ?>><a href="courses.php"><span class="glyphicon glyphicon-book"></span> Courses</a></li>
                        <li <?= echoActiveClass("about") ?>><a href="about.php"><span class="glyphicon glyphicon-bookmark"></span> About</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (!isset($_SESSION['username'])): ?>
                        <li <?= echoActiveClass("register") ?>><a href="register.php">Register</a></li>
                        <li class="divider-vertical"></li>
                        <li <?= echoActiveClass("login") ?>><a href="login.php">Login</a></li>
                        <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi <?php echo $_SESSION['username'] ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li align="center" class="well">
                                    <div><img class="img-responsive" style="padding:2%;" src="images/user.jpg"/></div>
                                    <a href="user_profile.php" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-user"></span> Profile</a>
                                    <a href="logout.php" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>          
</div>
