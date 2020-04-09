<?php
session_start();
if(!isset($_SESSION['id'])) header('LOCATION:signIn.php');
if($_SESSION['id'] != 'admin') header('Location: index.php');
require_once('userAccountsDB.php');
require_once("header.php");
?>



  
    <div class="container">
    <?php
    if(isset($_SESSION['id'])) echo '<a href="/csc301/signOut.php" >SIGN OUT</a>';
    else echo '<a href="/csc301/signIn.php" >SIGN IN</a> OR <a href="/csc301/signUp.php" >SIGN UP</a>';
    ?>
    <h1>All Users</h1>
    <?php
    $id=0;
    $tenant = new userAccount;
    $tenant->showPreview();
    ?>
    <?php if(isset($_SESSION['id'])) echo '<p><h4><a href="signUp.php" style="color:green">Create New User</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
