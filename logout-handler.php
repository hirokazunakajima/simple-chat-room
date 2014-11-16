<?php
session_start();

if (!isset($_SESSION['nickname'])) {
    header('location:index.php?logout=fail');
    exit();
}

$_SESSION['nickname']=array();
session_destroy();
header('location:index.php?logout=success');
