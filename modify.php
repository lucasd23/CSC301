<?php
session_start();
if(!isset($_SESSION['id'])) header('Location: index.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    require_once('JSONutility.php');
    modifyJSON("data.json",$_GET['id'], $_POST);
}

if(!isset($_GET['id'])){
    die('No id, go back to the <a href="index.php">Hotels Page</a>');
};
$json_string = file_get_contents('data.json');
$tenants=json_decode($json_string, true);
   
    if(!is_numeric($_GET['id']) || $_GET['id']<0 || $_GET['id']>=count($tenants)){
        die('Invalid, go back to the <a href="index.php">Tenants Page</a>');
    }



?>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?= $tenants[$_GET['id']]['first'].' '.$tenants[$_GET['id']]['last'] ?></title>
</head>

<body>
    <div class="container">
        <?= '<p><a href="detail.php?id='.$_GET['id'].'"><-Go Back</a></p>'?>
        <h1>Edit Tenant</h1>
        <form action="<?='modify.php?id='.$_GET['id']?>" method="POST">
            First: <input name="first" type="text" value="<?= $tenants[$_GET['id']]['first']?>"> Last: <input name="last" type="text" value="<?= $tenants[$_GET['id']]['last']?>"><br><br>
            Link to Photo: <input name="picture" type="text" value="<?= $tenants[$_GET['id']]['picture']?>"><br><br>
            Apartment Number: <input name="aptNum" type="text" value="<?= $tenants[$_GET['id']]['aptNum']?>"><br><br>
            Rent: $<input name="rent" type="number" step="0.01" value="<?= $tenants[$_GET['id']]['rent']?>"><br><br>
            Number of Late Payments: <input name="latePayments" type="number" value="<?= $tenants[$_GET['id']]['latePayments']?>"><br><br>
            <button type="submit">Submit</button>
        </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>