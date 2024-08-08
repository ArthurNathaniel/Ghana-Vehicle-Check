<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome to the Admin Dashboard</h2>
    <p>Hello, <?php echo $_SESSION['admin']; ?>!</p>
    <a href="logout.php">Logout</a>
</body>
</html>
