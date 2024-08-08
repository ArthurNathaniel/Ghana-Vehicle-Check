<?php
session_start();
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Dashboard</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>
<?php include 'header.php'; ?>
    <h2>Welcome to the Police Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['police']; ?>!</p>
    <a href="police_logout.php">Logout</a>
</body>

</html>
