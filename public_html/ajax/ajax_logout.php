<?php
require '../config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


session_unset();
session_destroy();




echo "success";
exit;
?>
