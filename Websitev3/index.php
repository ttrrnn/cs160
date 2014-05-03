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
        <title>Educademy Home</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <!-- Carousel idea from http://getbootstrap.com/examples/carousel -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class=""></li>
                <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="2" class=""></li>
            </ol>
            <div class="carousel-inner">
                <div class="item">
                    <img src="images/innovate.jpg">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Innovation at its best!</h1>
                            <p>Sign up with us and start learning right away!</p>
                            <p><a class="btn btn-lg btn-success" href="register.php" role="button">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="item active">
                    <img src="images/whoarewe.jpg">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Educademy?</h1>
                            <p>Who are we?</p>
                            <p><a class="btn btn-lg btn-primary" href="about.php" role="button">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="images/books.jpg">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Plenty of courses to choose from.</h1>
                            <p>We combined courses from eight of the best providers globally.</p>
                            <p><a class="btn btn-lg btn-info" href="courses.php" role="button">Browse courses</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div><!-- end Carousel -->
        <div class="container">
            <h1>Providers</h1>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <a href="https://www.canvas.net"><img src="images/canvas.jpg"/></a>
                </div>
                <div class="col-md-4">
                    <a href="https://www.coursera.org"><img src="images/coursera.jpg"/></a>
                </div>
                <div class="col-md-4">
                    <a href="https://www.edx.org"><img src="images/edx.jpg"/></a>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <a href="https://www.futurelearn.com"><img src="images/futurelearn.jpg"/></a>
                </div>
                <div class="col-md-4">
                    <a href="https://iversity.org"><img src="images/iversity.jpg"/></a>
                </div>
                <div class="col-md-4">
                    <a href="https://novoed.com"><img src="images/novoed.jpg"/></a>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-4">
                    <a href="https://www.open2study.com"><img src="images/open2study.jpg"/></a>
                </div>
                <div class="col-md-4">
                    <a href="https://www.udacity.com"><img src="images/udacity.jpg"/></a>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <!-- JS placed at the end of the document so the page loads faster -->
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/jquery.raty.js"></script>
        <script src="js/application.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
