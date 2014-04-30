<ul class="nav nav-tabs">
    <li <?=echoActiveClass("index")?>><a href="index.php">Home</a></li>
    <li <?=echoActiveClass("results")?>><a href="results.php">Courses</a></li>
    <li <?=echoActiveClass("about")?>><a href="about.php">About</a></li>	
</ul> <!-- end nav -->

<?php 

function echoActiveClass($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

?>
