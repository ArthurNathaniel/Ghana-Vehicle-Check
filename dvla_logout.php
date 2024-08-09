<?php
session_start();
session_destroy();
header("Location: dvla_login.php");
exit();
?>