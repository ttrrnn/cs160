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
        <title>Educademy Courses</title>
    </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="container">
            <div class="panel panel-success">
                <div class="panel-heading">Courses</div>
                <div class="panel-body">
                    <table id="table" class="display">
                        <thead>
                            <tr>
                                <th><span class="glyphicon glyphicon-facetime-video"></span> Intro</th>
                                <th>Course</th>
                                <th>Rating</th>
                                <th>Category</a></th>
                                <th>Start Date</th>
                                <th>Duration (weeks)</th>
                                <th>Professor</th>
                                <th>Site</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rate-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Rate this course!</h4>
                    </div>
                    <div class="modal-body">
                        <div id="raty-in-modal"></div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button onclick="rateCourse()" id="confirmRateButton" type="button" class="btn btn-primary" data-dismiss="modal" disabled>Confirm</button>
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

        <?php if (isset($_SESSION['username'])): ?>
        <script>
            var username = "<?= $_SESSION['username'] ?>";

            $.get("get_user_ratings.php", { username: username }, function(result) {
                // Store courses rated by user into global variable in application.js
                // This is kind of hackish, but I don't know how to get around it right now.
                $userData = { username: username, ratedCourses: JSON.parse(result) };
            });
        </script>
        <?php endif; ?>
    </body>
</html>
