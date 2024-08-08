<?php
session_start();
session_destroy();
header("Location: police_login.php");
exit();
?>
