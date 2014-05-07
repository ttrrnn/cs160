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
            
                readOnly    : true,
                starHalf    : 'images/star-half.png',
                starOff     : 'images/star-off.png',
                starOn      : 'images/star-on.png'
            });
        },
        // Pseudo lazy loading. The <a> tag now has an img attribute. Extract the value and embed a new <img> tag.
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            var anchorTag = nRow.firstChild.firstChild;
            var imgUrl = anchorTag.getAttribute('img');
            var imgTag = '<img src="' + imgUrl + '" />';
            
            anchorTag.innerHTML = imgTag;
            return nRow;
        },
    });

    $.get("get_courses.php", function(result) {
        $("#table").dataTable().fnAddData(JSON.parse(result));
    });
});
