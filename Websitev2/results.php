<!DOCTYPE html>

<html lang="en-us">

  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="DataTables-1.9.4/media/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/jquery-2.1.0.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="DataTables-1.9.4/media/js/jquery.dataTables.min.js"></script>
    <script src="js/application.js" type="text/javascript"></script> 
    <title>Educademy Courses</title>
  </head>

  <body>
    <div id="wrapper">
    <?php include('includes/header.php'); ?>
    <?php include('includes/nav.php'); ?>
    <?php include('includes/header-login.php'); ?>
    <div>
      <div class="title">
        <h1>Courses</h1>
      </div>
      <span id="found" class="label label-info"></span>
      <table id="table" class='table table-striped table-bordered'>
        <thead>
          <tr>
            <th></th>
            <th>Course</th>
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
    <?php include('includes/footer.php'); ?>
    </div> <!-- End #wrapper -->
  </body>
</html>
