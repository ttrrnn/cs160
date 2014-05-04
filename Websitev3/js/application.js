$(document).ready(function() {
    $("#table").dataTable ( {
        "bDeferRender": true,
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
        null,
        null
        ]
    });

    $.get("get_courses.php", function(result) {
        $("#table").dataTable().fnAddData(JSON.parse(result));

        $(".raty").raty({
            score: function() {
                return $(this).attr("value");
            },

            starHalf    : 'images/star-half.png',
            starOff     : 'images/star-off.png',
            starOn      : 'images/star-on.png'
        });
    });
});
