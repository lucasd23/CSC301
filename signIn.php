<?php

session_start();
if(isset($_SESSION['id'])) header('Location: index.php');
if (!isset($_SERVER['CONTENT_LENGTH'])){}
else {
    require_once('CSVutility.php');
    if (!file_exists('userAccounts.csv')) die('This email is not associated with an account');
    else{
        $_POST['email']=strtolower($_POST['email']);
        $verified=false;
        for ($index=0;readCSV('userAccounts.csv',$index) != null && $verified==false;$index++){
            $line = readCSV('userAccounts.csv',$index);
            if ($line[0] == $_POST['email']){
                $verified = true;
                if (!password_verify(trim($_POST['password']), trim($line[1]))) die('Incorrect Password'.var_dump($line[1]));
                $_SESSION['id'] = 1;
                header('Location: index.php');

            }
             
        }
        die('This email is not associated with an account');
    }
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

    <title>Sign In</title>
  </head>
  <body>
    <div class="container">
    <h1>Sign In to your Account</h1>
<form action="signIn.php" method="POST">
    Email: <input name="email" type="email" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    <button type="submit">Sign In</button>
</form>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>