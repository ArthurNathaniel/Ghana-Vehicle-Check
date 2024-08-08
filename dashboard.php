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
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
  
</head>
<body>
<?php include 'header.php'; ?>
    <h2>Welcome to the Admin Dashboard</h2>
    <p>Hello, <?php echo $_SESSION['admin']; ?>!</p>
    <a href="logout.php">Logout</a>
</body>
</html>
