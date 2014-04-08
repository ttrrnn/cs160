$(document).ready(function() {
	$.get("scrape_mooc.php", function(result) {
        $("#tableContent").append(result).table("refresh");
        console.log(result);
    });
});