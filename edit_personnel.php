<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = $_GET['id'] ?? '';
$personnel = null;

if ($id) {
    $sql = "SELECT * FROM dvla_personnel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $personnel = $result->fetch_assoc();
    } else {
        echo "No record found.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    
    $profile_picture = $personnel['profile_picture']; // Default to current picture

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $upload_dir = 'uploads/'; // Make sure this directory exists and is writable
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp_name, $file_path)) {
            $profile_picture = $file_path; // Update to new picture path
        } else {
            echo "Error uploading file.";
        }
    }

    $update_sql = "UPDATE dvla_personnel SET first_name = ?, middle_name = ?, last_name = ?, email = ?, phone_number = ?, profile_picture = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssi", $first_name, $middle_name, $last_name, $email, $phone_number, $profile_picture, $id);

    if ($update_stmt->execute()) {
        header("Location: view_dvla_personnel.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit DVLA Personnel</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="register_all">
    <div class="register_title">
        <h2>Edit DVLA Personnel</h2>
    </div>
    <?php if ($personnel): ?>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($personnel['id']); ?>">
            <div class="forms">
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($personnel['first_name']); ?>" required>
            </div>
            <div class="forms">
                <label>Middle Name:</label>
                <input type="text" name="middle_name" value="<?php echo htmlspecialchars($personnel['middle_name']); ?>">
            </div>
            <div class="forms">
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($personnel['last_name']); ?>" required>
            </div>
            <div class="forms">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($personnel['email']); ?>" required>
            </div>
            <div class="forms">
                <label>Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($personnel['phone_number']); ?>" required>
            </div>
            <div class="forms">
                <label>Profile Picture:</label>
                <?php if ($personnel['profile_picture']): ?>
                    <div>
                        <img src="<?php echo htmlspecialchars($personnel['profile_picture']); ?>" alt="Profile Picture" width="100" height="100">
                    </div>
                <?php endif; ?>
                <input type="file" name="profile_picture">
            </div>
            <div class="forms">
                <button type="submit">Update Personnel</button>
            </div>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
