<?php
session_name('signIn');
session_start();

if(!isset($_SESSION['uid'])) header('LOCATION:signIn.php');
require_once('FileUtility.php');
require_once('tenantDB.php');
//$json_string = file_get_contents('data.json');
//$tenants=json_decode($json_string, true);
$tenants=FileUtility::readJSON('tenants.json');
require_once("header.php");
?>



  
    <div class="container">
    <?php
    if(isset($_SESSION['uid'])) {
      if($_SESSION['uid'] == 'admin') echo '<a href="/csc301/admin.php" style="color:red">ADMIN</a><br>';
      echo '<a href="/csc301/signOut.php" >SIGN OUT</a>';
    }
    else echo '<a href="/csc301/signIn.php" >SIGN IN</a> OR <a href="/csc301/signUp.php" >SIGN UP</a>';
    ?>
    <h1>All Tenants</h1>
    <?php
    $id=0;
    $tenant = new tenantDB;
    $tenant->showPreview();
    ?>
    <?php if(isset($_SESSION['uid'])) echo '<p><h4><a href="create.php" style="color:green">Create New Tenant</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
