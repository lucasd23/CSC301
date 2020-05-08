<?php
session_name('signIn');
session_start();
if(!isset($_SESSION['uid'])) header('LOCATION:signIn.php');
if($_SESSION['uid'] != 'admin') header('Location: index.php');
require_once('aptDB.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    $apt=new aptDB;
    $apt->processNewApt($_POST['aptNum']);
    header('Location: adminApts.php');
}
require_once('header.php');
?>
<div class="container">
    <h1>Create Tenant</h1>
    <?php $apt=new aptDB;
    $apt->showNewAPT();
    ?>
</div>
<?php require_once("footer.php")?>
