$(document).ready(function() {
    var ratyInitialized = false;

    // Fancybox with media helper
    $(".fancybox").fancybox({
        helpers : {
            media : {}
        }
    });
    
    // Validation
    $("#theform").validate(
    {
        rules: {
            username: {
                minlength: 2,
                required: true
            },
            email: {
                required: true,
                email: true
            },
            password: {
                minlength: 6,
                required: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        }
    });
                
    // Back-to-top
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });
    
    $('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({
            scrollTop: 0
        }, duration);
        return false;
    })
    
    // Datatables
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
            if (!ratyInitialized) {
                ratyInitialized = true;

                $('.raty').raty({
                    score: function() {
                        return $(this).attr("value");
                    },
                
                    readOnly    : true,
                    starHalf    : 'images/star-half.png',
                    starOff     : 'images/star-off.png',
                    starOn      : 'images/star-on.png'
                });
            }
        },
        "fnCreatedRow": function(nRow, aData, iDataIndex) {

        }
    });

    $.get("get_courses.php", function(result) {
        $("#table").dataTable().fnAddData(JSON.parse(result));
    });
});
