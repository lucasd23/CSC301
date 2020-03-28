<?php
session_start();

require_once('userOps.php');
$userOps=new userOps;
$userOps->signOut();
?>