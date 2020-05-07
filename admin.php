<?php
session_name('signIn');
session_start();
if(!isset($_SESSION['uid'])) header('LOCATION:signIn.php');
if($_SESSION['uid'] != 'admin') header('Location: index.php');
require_once('userAccountsDB.php');
require_once("header.php");
?>



  
    <div class="container">
    <h1>All Users</h1>
    <?php
    $id=0;
    $tenant = new userAccount;
    $tenant->showPreview();
    ?>
    <?php if(isset($_SESSION['uid'])) echo '<p><h4><a href="signUp.php" style="color:green">Create New User</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
