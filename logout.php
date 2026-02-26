<?php
ob_start();
session_start();
session_destroy();
echo "<script>window.open('login.php','_self')</script>";
exit;
?>