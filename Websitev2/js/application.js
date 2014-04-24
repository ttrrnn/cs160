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

function create() {
	$("#registration-form-data").submit();
}

function login() {
  $("#login-form").submit();
}

function logout() {
  $("#logout-form").submit();
}