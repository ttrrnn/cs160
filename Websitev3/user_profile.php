<?php require("includes/users_connect.php");
    if (empty($_SESSION['username'])) {
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
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="fancyBox/source/jquery.fancybox.css" rel="stylesheet">
        <link href="DataTables-1.10.0/media/css/jquery.dataTables.css" rel="stylesheet">
        <link href="css/style.css" type="text/css" rel="stylesheet">
        <title>Educademy User Profile</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="container">
            <div class="row well">
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-stacked well">
                        <li class="active"><a href="user_profile.php"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-user"></i> Settings</a></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="panel">
                        <img class="img-circle" src="images/user.jpg" alt="avatar" style="margin-top:50px;width:120px;margin-left:50px;margin-bottom:-60px;">
                        <div style="position:absolute;padding-left:200px;font-size:30px;"><small><?php echo $_SESSION['username'] ?></small></div>
                    </div>

                    <br><br><br>
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#rated" data-toggle="tab"><i class="fa fa-star-o"></i> Rated Courses</a></li>
                        <li><a href="#wish" data-toggle="tab"><i class="fa fa-list-ol"></i> Wish List (MAYBE)</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="rated">
                                <div class="btn-toolbar well well-sm" role="toolbar"  style="margin:0px;">
                                    <div class="btn-group"><input type="checkbox"></div>
                                    <div class="btn-group col-md-3">SHOW STARS HERE</div>
                                    <div class="btn-group col-md-8"><a type="button" data-toggle="collapse" data-target="#a1"><b>COURSE NAME</b></a></div>
                                </div>
                            <div id="a1" class="collapse out well">MORE DETAILED COURSE STUFF HERE</div>
                            <br>
                            <button class="btn btn-primary btn-xs"><i class="fa fa-check-square-o"></i> Delete Checked Items</button>
                        </div>

                        <div class="tab-pane" id="wish">
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object img-thumbnail" width="100" src="http://cfi-sinergia.epfl.ch/files/content/sites/cfi-sinergia/files/WORKSHOPS/Workshop1.jpg" alt="...">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">Snooze Workshop</h4>
                                    <p>How to fall asleep anywhere and get away with it.</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <script src="fancyBox/source/helpers/jquery.fancybox-media.js"></script>
        <script src="js/application.js"></script>
    </body>
</html>
