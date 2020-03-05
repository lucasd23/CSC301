<?php
session_start();
$json_string = file_get_contents('data.json');
$tenants=json_decode($json_string, true);
require_once("header.php");
?>



  
    <div class="container">
    <?php
    if(isset($_SESSION['id'])) echo '<a href="/csc301/signOut.php" >SIGN OUT</a>';
    else echo '<a href="/csc301/signIn.php" >SIGN IN</a> OR <a href="/csc301/signUp.php" >SIGN UP</a>';
    ?>
    <h1>All Tenants</h1>
    <?php
    for ($i=0;$i<count($tenants);$i++){
        
        echo '<div class="media">
        <img src="'.$tenants[$i]['picture'].'" class="mr-3"  alt="..." style="max-width:96px">
        <div class="media-body">
          <h5 class="mt-0">'.$tenants[$i]['first'].' '.$tenants[$i]['last'].'</h5>
          <p>Apt. '.$tenants[$i]['aptNum'].'</p>
          <p><a href="detail.php?id='.$i.'">Click to see details</a></p>
        </div>
      </div>';
      echo '<hr>';
    }
    ?>
    <?php if(isset($_SESSION['id'])) echo '<p><h4><a href="create.php" style="color:green">Create New Tenant</a></h4></p>' ?>
    </div>
<?php require_once("footer.php")?>
