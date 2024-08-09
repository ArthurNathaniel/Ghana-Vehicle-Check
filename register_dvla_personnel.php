<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload
    $default_image = 'dvla_profile.png'; // Replace with your default image path
    $profile_picture = $default_image;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $upload_dir = 'uploads/'; // Ensure this directory exists and is writable
        $profile_picture = $upload_dir . $file_name;

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($file_tmp, $profile_picture)) {
            $error_message = "Error uploading profile picture.";
        }
    }

    // Check if email already exists
    $sql = "SELECT * FROM dvla_personnel WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email already exists.";
    } else {
        // Insert new personnel
        $insert_sql = "INSERT INTO dvla_personnel (first_name, middle_name, last_name, email, phone_number, password, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $email, $phone_number, $hashed_password, $profile_picture);

        if ($insert_stmt->execute()) {
            $success_message = "Personnel registered successfully.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register DVLA Personnel</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="register_title">
            <h2>Register DVLA Personnel</h2>
        </div>
        <?php if ($error_message != ""): ?>
            <div class="error_message" id="error-message">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeError()">x</span>
            </div>
        <?php endif; ?>
        <?php if ($success_message != ""): ?>
            <div class="success_message" id="success-message">
                <?php echo $success_message; ?>
                <span class="close-btns" onclick="closeSuccess()">x</span>
            </div>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
    <div class="forms">
        <label>Profile Picture:</label>
        <input type="file" name="profile_picture">
    </div>
    <div class="forms">
        <label>First Name:</label>
        <input type="text" name="first_name" required>
    </div>
    <div class="forms_grid">
        <div class="forms">
            <label>Middle Name:</label>
            <input type="text" name="middle_name">
        </div>
        <div class="forms">
            <label>Last Name:</label>
            <input type="text" name="last_name" required>
        </div>
    </div>
    <div class="forms_grid">
        <div class="forms">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="forms">
            <label>Phone Number:</label>
            <input type="number" min="0" name="phone_number" required>
        </div>
    </div>
    <div class="forms">
        <label>Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="show_password">
        <input type="checkbox" id="showPassword">
        Show password
    </div>
    <div class="forms forms_submit">
        <button type="submit">Register Personnel</button>
    </div>
</form>

    </div>
    <?php include 'footer.php'; ?>
    <script>
        // Close error message with animation
        function closeError() {
            document.getElementById('error-message').style.display = 'none';
        }

        // Close success message with animation
        function closeSuccess() {
            document.getElementById('success-message').style.display = 'none';
        }

          // Show password toggle
    document.getElementById('showPassword').addEventListener('change', function() {
        var pinInput = document.getElementById('password');
        pinInput.type = this.checked ? 'text' : 'password';
    });
    </script>
</body>

</html>