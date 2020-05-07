<?php
session_name('signIn');
session_start();

require_once('userAccountsDB.php');
$userOps=new userAccount;
$userOps->signOut();
?>