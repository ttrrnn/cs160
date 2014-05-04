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
        ],
        "fnDrawCallback": function (oSettings) {
            // Need code here to conditionally check if it hasn't already
            // been initialised on a particular .raty element
            $('.raty').raty({
                score    : function() {
                    return $(this).attr("value");
                },
            
                readOnly : true
                starHalf : 'images/star-half.png',
                starOff  : 'images/star-off.png',
                starOn   : 'images/star-on.png'
            });
        }
    });

    $.get("get_courses.php", function(result) {
        $("#table").dataTable().fnAddData(JSON.parse(result));
    });
});
