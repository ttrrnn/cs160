$(document).ready(function() {
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
    $userData = "";
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
            $('.raty').raty({
                score: function() {
                    return $(this).attr("value");
                },
            
                readOnly : true,
                starHalf : 'images/star-half.png',
                starOff  : 'images/star-off.png',
                starOn   : 'images/star-on.png'
            });

            // Disable rate button for anonymous users
            if ($userData.username == null) {
                $(".rateButton").hide();
            }
            // Disable rate button for courses already rated by logged in user
            else {
                $(".rateButton").show();

                for (var buttonId in $userData.ratedCourses) {
                    $("#" + $userData.ratedCourses[buttonId]).hide();
                }
            }
        },
    });

    $.get("get_courses.php", function(result) {
        ratyModalInit();
        $("#table").dataTable().fnAddData(JSON.parse(result));
    });
});

// My hackish way to keep track of which rate button is clicked on the coursePage
function attachCourseId(courseButton) {
    $("#confirmRateButton").prop("courseId", courseButton.prop("id"));
}

function rateCourse() {
    var courseId = $("#confirmRateButton").prop('courseId');
    var username = $userData.username;
    var stars = $("#raty-in-modal input[name=score]").prop('value');
    
    $.post("rate_course.php", { courseId: courseId, username: username, stars: stars}, function() {
        $userData.ratedCourses.push(courseId);
        $("#" + courseId).hide();
        ratyModalInit();
    });
}

function ratyModalInit() {
    $("#confirmRateButton").prop("disabled", true);

    $("#raty-in-modal").raty({
        starOff : 'images/star-off.png',
        starOn  : 'images/star-on.png',
        score   : 0,

        click: function(score, evt) {
            $("#confirmRateButton").prop("disabled", false);
        }
    });
}
