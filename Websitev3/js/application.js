$(document).ready(function() {
    $("#table").dataTable ( {
        "sPaginationType": "full_numbers",
        "aoColumns": [
        {
            "bSortable": false, 
            "bSearchable": false
        },
        null,
        null,
        null,
        null,
        null,
        null
        ]
    });

    $.get("get_courses.php", function(result) {
        $("#table").dataTable().fnAddData(JSON.parse(result));
    });
});
