var st; // For debugging only

$(document).ready(function() {
  $("#table").dataTable();

  $.get("get_courses.php", function(result) {
    $("#table").dataTable().fnAddData(JSON.parse(result));
  });
});

function register() {
  $.post("register.php", $("#registration-form-data").serialize(), function(result) {
    if (result == "True") {
      var username = $("#username");
      $("#login-error").html("Created user " + username.val());
    }
    else {
      $("#login-error").html(result);
    }
  });
}

function login() {
  var success = true;
  $("#login-error").html("");

  if ($("#login-username").val() === "") { 
    $("#login-error").html("Username cannot be blank!");
  }

  if ($("#login-password").val() === "") {
    $("#login-error").append(" Password cannot be blank!");
  }

  if (success) {
    $.post("login.php", $("#login-form").serialize(), function(result) {
      if (result == "True") {
        var username = $("#username");
        $("#login-error").html("Logged in as " + username.val());
      }
      else {
        $("#login-error").html("Incorrect username or password");
      }
    });
  }
}

function logout() {
  $("#logout-form").submit();
}