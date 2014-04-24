<?php

session_start();

if (isset($_GET['logout'])) {
  unset($_SESSION['username']);
  header("Location: index.php");
}
else if (isset($_POST['create-account'])) {

}

?>

<!DOCTYPE html>

<html lang="en-us">

  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script src="js/jquery-2.1.0.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/mustache.js" type="text/javascript"></script>
    <script src="js/stream_table.js" type="text/javascript"></script>
    <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
    <script src="js/application.js" type="text/javascript"></script>   
  </head>

  <body>
    <div id="header-login">
      <ul class="nav navbar-left">
        <li id="login-error"></li>
      </ul>
      <ul class="nav navbar-right">

        <?php

        if (isset($_POST['login']) && $_POST['login-username'] != "") {
          $_SESSION['username'] = $_POST['login-username'];
        }

        if ($_POST['login-username'] == ""):

        ?>

        <li>
          <form id="login-form" role="form" method="post">
            <input type="text" name="login-username" id="login-username" class="input-sm" placeholder="Username" required />
            <input type="password" name="login-password" id="login-password" class="input-sm" placeholder="Password" required />
            <input type="hidden" name="login" id="login" class="input-sm" />
          </form>
        </li>
        <li>
          <button action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" form="login-form" id="login-button" type="submit" class="btn btn-primary">Login</button>
        </li>
        <li>
          <button id="register-toggle" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registration-form">
            Register <span class="caret"></span>
          </button>
        </li>

        <?php else: ?>

        <form id="logout-form" role="form" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
          <input type="hidden" name="logout" id="logout" class="input-sm" />
        </form>

        <li>
          <?php echo "Logged in as " . $_POST['login-username']; ?>
        </li>
        <li>
          <button form="logout-form" id="logout-button" type="submit" class="btn btn-primary">Logout</button>
        </li>
        <li>
          <button id="account-button" type="button" class="btn btn-primary">Account <span class="caret"></span></button>
        </li>

        <?php endif; ?>
      </ul>    
    </div>

    <div class="modal fade" id="registration-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Register for an account. It's free!</h4>
          </div>
          <div class="modal-body">
            <form id="registration-form-data" role="form" method="post">
              <inpur type="hidden" name="create-account" />
              <div class="form-group">
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" required />
              </div>
              <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required />
              </div>
              <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
              </div>
              <div class="form-group">
                <input type="password" name="password-confirmation" id="password-confirmation" class="form-control" placeholder="Confirm Password" required />
              </div>
              <div class="form-group" id="registration-error"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button form="registration-form-data" type="button" class="btn btn-primary" data-dismiss="modal" onclick="register()">Create</button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="title">
        <h1>Educademy</h1>
      </div>
      <span id="found" class="label label-info"></span>
      <table id="stream_table" class='table tablesorter table-striped table-bordered'>
        <thead>
          <tr>
            <th><a href="#"></th>
            <th style="width: 200px;"><a href="#">Course</a></th>
            <th><a href="#">Category</a></th>
            <th style="width: 100px;"><a href="#">Start Date</a></th>
            <th><a href="#">Duration (weeks)</a></th>
            <th><a href="#">Professor</a></th>
            <th></th>
            <th><a href="#">Site</a></th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <div id="summary"><div>
    </div>

    <!-- Some {{record.course_link}} should be changed later to link to our own generated page for each course -->
    <script id="template" type="text/html">
      <tr>
        <td><a href="{{record.course_link}}"><img src="{{record.course_image}}" width="200px" height="150px" /></a></td>
        <td><a href="{{record.course_link}}">{{record.title}}</a></td>
        <td>{{record.category}}</td>
        <td>{{record.start_date}}</td>
        <td>{{record.course_length}}</td>
        <td>{{record.professor_name}}</td>
        <td><img src="{{record.professor_image}}" width="150px" height="150px" /></td>
        <td><a href="http://{{record.site}}.com">{{record.site}}<a></td>
      </tr>
    </script>

  </body>
</html>