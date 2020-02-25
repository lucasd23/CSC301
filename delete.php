<?php
session_start();
if(!isset($_SESSION['id'])) header('Location: index.php');

if(!isset($_GET['id'])){
    die('No id, go back to the <a href="index.php">Tenants Page</a>');
};
$json_string = file_get_contents('data.json');
$tenants=json_decode($json_string, true);
$first=$tenants[$_GET['id']]['first'];
$last=$tenants[$_GET['id']]['last'];
   
    if(!is_numeric($_GET['id']) || $_GET['id']<0 || $_GET['id']>=count($tenants)){
        die('Invalid, go back to the <a href="index.php">Hotels Page</a>');
    }


        require_once('JSONutility.php');
        deleteJSON("data.json",$_GET['id']);

echo "$first $last".' has been successfully deleted, go back to the <a href="index.php">Tenants Page</a>'
?>