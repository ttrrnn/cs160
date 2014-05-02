<?php include('variables/variables.php');
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
    try { 
        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_password, $options);
    } 
    catch(PDOException $ex){
        die("Failed to connect to the database: " . $ex->getMessage());
    } 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    header('Content-Type: text/html; charset=utf-8'); 
    session_start();
?>
