<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}

// Retrieve the email of the logged-in user
$dvla_personnel_email = $_SESSION['dvla_personnel'];

// Fetch user details from the database if needed
$sql = "SELECT * FROM dvla_personnel WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dvla_personnel_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVLA Dashboard</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="dashboard_container">
    <header>
        <div class="header_content">
            <h1>Welcome to DVLA Dashboard</h1>
            <p>Logged in as: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <nav>
            <ul>
                <li><a href="dvla_dashboard.php">Home</a></li>
                <li><a href="vehicle_check.php">Vehicle Check</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard_section">
            <h2>Dashboard Overview</h2>
            <p>This is your dashboard. From here, you can access various features and functionalities related to vehicle checks and reports.</p>
            <!-- Additional dashboard content can be added here -->
        </section>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="./js/dashboard.js"></script>
<script>
    // Add any dashboard-specific JavaScript here
</script>
</body>
</html>
