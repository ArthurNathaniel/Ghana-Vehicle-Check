<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['license_id'])) {
    $license_id = $_POST['license_id'];

    $sql = "SELECT * FROM driver_license_applications WHERE license_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $license_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $license = $result->fetch_assoc();
    } else {
        $error = "No license found with the given ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_license'])) {
    $license_id = $_POST['license_id'];
    $full_name = $_POST['full_name'];
    $license_category = $_POST['license_category'];
    $purpose_of_license = $_POST['purpose_of_license'];
    $license_start_date = $_POST['license_start_date'];
    $license_end_date = $_POST['license_end_date'];

    // Handling profile picture upload
    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_picture);
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);

    $sql = "UPDATE driver_license_applications SET full_name = ?, license_category = ?, purpose_of_license = ?, license_start_date = ?, license_end_date = ?, profile_picture = ? WHERE license_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $full_name, $license_category, $purpose_of_license, $license_start_date, $license_end_date, $profile_picture, $license_id);

    if ($stmt->execute()) {
        $success = "License information updated successfully.";
    } else {
        $error = "Failed to update license information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Driver License</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/drivers_license.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <h2>Renew Driver License</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="forms">
                <label for="license_id">Enter License ID Number:</label>
                <input type="text" name="license_id" id="license_id" required>
            </div>
            <div class="forms">
                <button type="submit">Search</button>
            </div>
        </form>

        <?php if (isset($license)) : ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="forms">
                    <input type="hidden" name="license_id" value="<?php echo $license['license_id']; ?>">
                </div>

                <div class="forms">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo $license['full_name']; ?>" required>
                </div>
                <div class="forms">
                    <label for="license_category">License Category:</label>
                    <input type="text" name="license_category" id="license_category" value="<?php echo $license['license_category']; ?>" required>
                </div>

                <div class="forms">
                    <label for="purpose">Purpose of the License:</label>
                    <input type="text" name="purpose_of_license" id="purpose_of_license" value="<?php echo $license['purpose_of_license']; ?>" required>
                </div>

                <div class="forms">
                    <label for="license_start_date">License Start Date:</label>
                    <input type="date" name="license_start_date" id="license_start_date" value="<?php echo $license['license_start_date']; ?>" required>
                </div>
                <div class="forms">

                    <label for="license_end_date">License End Date:</label>
                    <input type="date" name="license_end_date" id="license_end_date" value="<?php echo $license['license_end_date']; ?>" required>
                </div>

                <div class="forms">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" name="profile_picture" id="profile_picture">
                    <?php if (!empty($license['profile_picture'])) : ?>
                        <img src="uploads/profile_pictures/<?php echo $license['profile_picture']; ?>" alt="Profile Picture" width="100">
                    <?php endif; ?>
                </div>
                <div class="forms forms_submit">
                    <button type="submit" name="update_license">Update License</button>
                </div>
            </form>
        <?php endif; ?>

        <?php if (isset($success)) : ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>