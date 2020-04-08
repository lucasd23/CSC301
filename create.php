<?php
session_start();
if(!isset($_SESSION['id'])) header('Location: index.php');
require_once('tenantDB.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    $tenant=new tenantDB;
    $tenant->processCreateForm();
    header('Location: index.php');
}
require_once('header.php');
?>
<h1>Create Tenant</h1>
<?php $tenant=new tenantDB;
$tenant->showCreateForm();
?>
<?php require_once("footer.php")?>
