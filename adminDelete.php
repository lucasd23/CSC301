<?php
session_name('signIn');
session_start();
if(!isset($_SESSION['uid'])) header('LOCATION:signIn.php');
if($_SESSION['uid'] != 'admin') header('Location: index.php');

if(!isset($_GET['id'])){
    die('No id, go back to the <a href="admin.php">Admin Page</a>');
};
require_once('userAccountsDB.php');
if(!is_string($_GET['id'])){
    die('Invalid, go back to the <a href="admin.php">Admin Page</a>');
}
$users=new userAccount;
try{
    $users->create();
    $user=$users->pdo->query('SELECT email FROM useraccounts WHERE email="'.$_GET['id'].'"');
    $email=$user->fetch();
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
$id=$email['email'];
   
    
$users->delete($id);

        

echo "$id".' has been successfully deleted, go back to the <a href="admin.php">Users Page</a>'
?>