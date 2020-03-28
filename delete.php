<?php
session_start();
if(!isset($_SESSION['id'])) header('Location: index.php');

if(!isset($_GET['id'])){
    die('No id, go back to the <a href="index.php">Tenants Page</a>');
};
require_once('FileUtility.php');
require_once('tenant.php');
$tenants=FileUtility::readJSON('tenants.json', $_GET['id']);
$first=$tenants['first'];
$last=$tenants['last'];
   
    if(!is_numeric($_GET['id']) || $_GET['id']<0 || $_GET['id']>=count($tenants)){
        die('Invalid, go back to the <a href="index.php">Hotels Page</a>');
    }
$tenant=new Tenant;
$tenant->delete($_GET['id']);

        

echo "$first $last".' has been successfully deleted, go back to the <a href="index.php">Tenants Page</a>'
?>