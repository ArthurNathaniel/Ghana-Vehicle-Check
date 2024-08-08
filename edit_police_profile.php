<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch police details
$id = $_GET['id'];
$sql = "SELECT * FROM police WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$police = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $house_address = $_POST['house_address'];
    $badge_number = $_POST['badge_number'];
    $mttd_rank = $_POST['mttd_rank'];
    $police_station = $_POST['police_station'];
    $username = $_POST['username'];
    $profile_picture = $_FILES['profile_picture']['name'];

    // Handle profile picture upload
    if ($profile_picture) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
    } else {
        $target_file = $police['profile_picture'];
    }

    // Update police details
    $sql = "UPDATE police SET first_name = ?, middle_name = ?, last_name = ?, dob = ?, phone_number = ?, email = ?, house_address = ?, badge_number = ?, mttd_rank = ?, police_station = ?, username = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssi", $first_name, $middle_name, $last_name, $dob, $phone_number, $email, $house_address, $badge_number, $mttd_rank, $police_station, $username, $target_file, $id);

    if ($stmt->execute()) {
        header("Location: view_registered_police.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Police Profile</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="register_all">
        <h2>Edit Police Profile</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="forms">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($police['first_name']); ?>" required>
            </div>

            <div class="forms">
                <label for="middle_name">Middle Name:</label>
                <input type="text" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($police['middle_name']); ?>">
            </div>

            <div class="forms">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($police['last_name']); ?>" required>
            </div>

           <div class="forms">
           <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($police['dob']); ?>" required>

           </div>
           
           <div class="forms">
           <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($police['phone_number']); ?>" required>

           </div>

         <div class="forms">
         <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($police['email']); ?>" required>

         </div>
          <div class="forms">
          <label for="house_address">House Address:</label>
            <input type="text" id="house_address" name="house_address" value="<?php echo htmlspecialchars($police['house_address']); ?>" required>

          </div>
           <div class="forms">
           <label for="badge_number">Badge Number:</label>
            <input type="text" id="badge_number" name="badge_number" value="<?php echo htmlspecialchars($police['badge_number']); ?>" required>

           </div>
         <div class="forms">
         <label for="mttd_rank">MTTD Rank:</label>
            <input type="text" id="mttd_rank" name="mttd_rank" value="<?php echo htmlspecialchars($police['mttd_rank']); ?>" required>

         </div>
          <div class="forms">
          <label for="police_station">Police Station:</label>
            <input type="text" id="police_station" name="police_station" value="<?php echo htmlspecialchars($police['police_station']); ?>" required>

          </div>
         <div class="forms">
         <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($police['username']); ?>" required>

         </div>
            <div class="forms">
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture">
<div class="profile_image">
<img src="<?php echo htmlspecialchars($police['profile_picture']); ?>" alt="Profile Picture" class="current-profile-picture">

</div>
            </div>
           <div class="forms">
           <button type="submit">Update Profile</button>
           </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>