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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $house_address = $_POST['house_address'];
    $new_username = $_POST['username'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                $profile_picture = $target_file;
            } else {
                echo "Error uploading the profile picture.";
                exit();
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    } else {
        $profile_picture = $police['profile_picture'];
    }

    // Update the police details in the database
    $sql = "UPDATE police SET phone_number = ?, email = ?, house_address = ?, username = ?, profile_picture = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $phone_number, $email, $house_address, $new_username, $profile_picture, $username);

    if ($stmt->execute()) {
        $_SESSION['police'] = $new_username; // Update session username if it has changed
        header("Location: view_police_profile.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="register_all">
        <div class="forms_title">
        <h2>Edit Profile</h2>
        <br>
        <p><strong><?php echo htmlspecialchars($police['mttd_rank']); ?></strong> <?php echo htmlspecialchars($police['last_name']); ?>, you are only allowed to edit this.
         <br> Contact the admin <a href="info">Click here</a>for other changes</p>
        </div>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="forms">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($police['phone_number']); ?>" required>
            </div>
            <div class="forms">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($police['email']); ?>" required>
            </div>
            <div class="forms">
                <label for="house_address">House Address</label>
                <input type="text" id="house_address" name="house_address" value="<?php echo htmlspecialchars($police['house_address']); ?>" required>
            </div>
            <div class="forms">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($police['username']); ?>" required>
            </div>
            <div class="forms">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture">
                <?php if (!empty($police['profile_picture'])): ?>
                    <img src="<?php echo htmlspecialchars($police['profile_picture']); ?>" alt="Profile Picture" style="width: 100px; height: 100px;">
                <?php endif; ?>
            </div>
            <div class="forms">
                <button type="submit" class="btn">Save Changes</button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
