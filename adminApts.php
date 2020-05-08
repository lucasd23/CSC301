<?php
session_name('signIn');
session_start();
if(!isset($_SESSION['uid'])) header('LOCATION:signIn.php');
if($_SESSION['uid'] != 'admin') header('Location: index.php');
require_once('aptDB.php');
require_once("header.php");
?>



  
    <div class="container">
    <h1>All Apartments</h1>
    <?php
    $id=0;
    $apts = new aptDB;
    $apts->showApts();
    ?>
    <?php if(isset($_SESSION['uid'])) echo '<p><h4><a href="newApt.php" style="color:green">Create New Apartment</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
