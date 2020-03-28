<?php
session_start();
require_once('FileUtility.php');
require_once('tenant.php');
//$json_string = file_get_contents('data.json');
//$tenants=json_decode($json_string, true);
$tenants=FileUtility::readJSON('tenants.json');
require_once("header.php");
?>



  
    <div class="container">
    <?php
    if(isset($_SESSION['id'])) echo '<a href="/csc301/signOut.php" >SIGN OUT</a>';
    else echo '<a href="/csc301/signIn.php" >SIGN IN</a> OR <a href="/csc301/signUp.php" >SIGN UP</a>';
    ?>
    <h1>All Tenants</h1>
    <?php
    $id=0;
    foreach ($tenants as $one){
        
      $tenant=new Tenant;
      echo $tenant->showPreview($one,$id);
      $id++;
    }
    ?>
    <?php if(isset($_SESSION['id'])) echo '<p><h4><a href="create.php" style="color:green">Create New Tenant</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
