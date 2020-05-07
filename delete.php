<?php
session_name('signIn');
if(!isset($_SESSION['uid'])) header('Location: index.php');

if(!isset($_GET['id'])){
    die('No id, go back to the <a href="index.php">Tenants Page</a>');
};
require_once('tenantDB.php');
if(!is_numeric($_GET['id']) || $_GET['id']<0){
    die('Invalid, go back to the <a href="index.php">Hotels Page</a>');
}
$tenants=new tenantDB;
try{
    $tenants->create();
    $tenant=$tenants->pdo->query('SELECT first, last FROM tenant WHERE tenantID='.$_GET['id']);
    $name=$tenant->fetch();
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}
$first=$name['first'];
$last=$name['last'];
   
    
$tenants->delete($_GET['id']);

        

echo "$first $last".' has been successfully deleted, go back to the <a href="index.php">Tenants Page</a>'
?>