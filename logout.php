<?php
session_start();
session_destroy();
$_SESSION['id'] = NULL;
header('Location: login.php');
exit;
?>