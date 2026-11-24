<?php
session_start();
$_SESSION = [];
session_destroy(); // Destrói a sessão atual
header('Location: login.php'); // Manda de volta pro login
exit;
?>