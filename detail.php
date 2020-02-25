<?php
session_start();
if(!isset($_GET['id'])){
    die('No id, go back to the <a href="index.php">Tenants Page</a>');
};
$json_string = file_get_contents('data.json');
$tenants=json_decode($json_string, true);
   
    if(!is_numeric($_GET['id']) || $_GET['id']<0 || $_GET['id']>=count($tenants)){
        die('Invalid, go back to the <a href="index.php">Tenants Page</a>');
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?= $tenants[$_GET['id']]['first'].' '.$tenants[$_GET['id']]['last'] ?></title>
  </head>
  <body>
    <div class="container">
    <a href="/csc301/index.php" ><-Go Back</a>
    <h1><?= $tenants[$_GET['id']]['first'].' '.$tenants[$_GET['id']]['last'] ?></h1>
    <img src="<?= $tenants[$_GET['id']]['picture'] ?>" style="max-width:500px"/>
    <p>Apartment Number: <?= $tenants[$_GET['id']]['aptNum'] ?></p>
    <p> Rent: $<?= $tenants[$_GET['id']]['rent'] ?></p>
    <p>Late Payments: <?php
    if($tenants[$_GET['id']]['latePayments'] < 2){
        echo '<span class="badge badge-success">'.$tenants[$_GET['id']]['latePayments'].'</span>';
    }
    elseif($tenants[$_GET['id']]['latePayments'] < 7){
        echo '<span class="badge badge-warning">'.$tenants[$_GET['id']]['latePayments'].'</span>';
    }
    else{
        echo '<span class="badge badge-danger">'.$tenants[$_GET['id']]['latePayments'].'</span>';
    }
    if(isset($_SESSION['id'])) echo '<p><a href="modify.php?id='.$_GET['id'].'">Edit</a></p>';
    if(isset($_SESSION['id'])) echo '<p><a href="delete.php?id='.$_GET['id'].'" style="color:red">Delete</a></p>'
    ?> </p>
    
    
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>

