<?php
session_start();
if (!isset($_SESSION['police'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch police details from the database for the logged-in user
$username = $_SESSION['police'];
$sql = "SELECT * FROM police WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $police = $result->fetch_assoc();
} else {
    echo "No profile found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Profile</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/police_profile.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile_container">
        <h2>Police Profile</h2>
        <div class="profile_details">
            <img src="<?php echo htmlspecialchars($police['profile_picture']); ?>" alt="Profile Picture" class="profile_picture">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($police['first_name']); ?></p>
            <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($police['middle_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($police['last_name']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($police['dob']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($police['phone_number']); ?></p>
            <p><strong>Email Address:</strong> <?php echo htmlspecialchars($police['email']); ?></p>
            <p><strong>House Address:</strong> <?php echo htmlspecialchars($police['house_address']); ?></p>
            <p><strong>Badge Number:</strong> <?php echo htmlspecialchars($police['badge_number']); ?></p>
            <p><strong>MTTD Rank:</strong> <?php echo htmlspecialchars($police['mttd_rank']); ?></p>
            <p><strong>Police Station:</strong> <?php echo htmlspecialchars($police['police_station']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($police['username']); ?></p>
        </div>
        <div class="profile_actions">
            <a href="edit_profile.php" class="btn">Edit Profile</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
