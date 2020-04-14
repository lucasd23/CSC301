<?php
session_name('signIn');
session_start();

require_once('userOps.php');
$userOps=new userOps;
$userOps->signOut();
?>