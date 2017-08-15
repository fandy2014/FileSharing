<?php ini_set("display_errors",0);
$title = 'Logout';
include('includes/connect.php');
include('includes/header.php');
session_destroy();
go($url.'/masuk.php');
include('includes/footer.php');
?>
