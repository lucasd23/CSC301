<?php
session_start();
if(!isset($_SESSION['id'])) header('Location: index.php');
require_once('FileUtility.php');
require_once('tenant.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    $tenant=new Tenant;
    $tenant->processCreateForm();
    header('Location: signIn.php');
}
require_once('header.php');
?>
<h1>Create Tenant</h1>
<?php $tenant=new Tenant;
$tenant->showCreateForm();
?>
<?php require_once("footer.php")?>
