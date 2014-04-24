var st; // For debugging only

$(document).ready(function() {
  var html = $.trim($("#template").html())
  var template = Mustache.compile(html);
  var $summary = $('#summary');
  var $found = $('#found');
  var $record_count = $('#record_count');
  var view = function(record, index) {
    return template({record: record, index: index});
  };

  $.get("get_courses.php", function(result) {
    var callbacks = {
      pagination: function(summary) {
        $summary.text( summary.from + ' to '+ summary.to +' of '+ summary.total +' entries');
      }
    };

    st = StreamTable('#stream_table',
      {
        view: view, 
        per_page: 10,
        stream_after: 0.5,
        fetch_data_limit: 100,
        callbacks: callbacks,
        pagination: {span: 5, next_text: 'Next &rarr;', prev_text: '&larr; Previous'}
      }
    , JSON.parse(result));

    $("#stream_table").tablesorter();
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