<?php
session_name('signIn');
session_start();
if(!isset($_SESSION['uid'])) header('Location: index.php');
require_once('tenantDB.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    $tenant=new tenantDB;
    $tenant->processCreateForm();
    header('Location: index.php');
}
require_once('header.php');
?>
<div class="container">
    <h1>Create Tenant</h1>
    <?php $tenant=new tenantDB;
    $tenant->showCreateForm();
    ?>
</div>
<?php require_once("footer.php")?>
