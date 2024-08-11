<?php
include 'db.php';
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}
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

    // Check if a new profile picture is uploaded
    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        // Keep the existing profile picture
        $profile_picture = $_POST['existing_profile_picture'];
    }

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

        <?php if (isset($error) && !isset($license)) : ?>
            <p class="error error_message"><?php echo $error; ?> <span class="close-btn" onclick="closeError()">x</span></p>
        <?php endif; ?>

        <?php if (isset($license)) : ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <?php if (isset($success)) : ?>
                    <p class="success success_message"><?php echo $success; ?> <span class="close-btns" onclick="closeSuccess()">x</span></p>
                <?php endif; ?>

                <div class="forms">
                    <input type="hidden" name="license_id" value="<?php echo $license['license_id']; ?>">
                    <input type="hidden" name="existing_profile_picture" value="<?php echo $license['profile_picture']; ?>">
                </div>

                <div class="forms">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo $license['full_name']; ?>" required>
                </div>
                <div class="forms">
                    <label for="license_category">License Category:</label>
                    <select name="license_category" id="license_category" required>
                        <option value="A" <?php echo $license['license_category'] == 'A' ? 'selected' : ''; ?>>A</option>
                        <option value="B" <?php echo $license['license_category'] == 'B' ? 'selected' : ''; ?>>B</option>
                        <option value="C" <?php echo $license['license_category'] == 'C' ? 'selected' : ''; ?>>C</option>
                        <option value="D" <?php echo $license['license_category'] == 'D' ? 'selected' : ''; ?>>D</option>
                        <option value="E" <?php echo $license['license_category'] == 'E' ? 'selected' : ''; ?>>E</option>
                        <option value="F" <?php echo $license['license_category'] == 'F' ? 'selected' : ''; ?>>F</option>
                    </select>
                </div>

                <div class="forms">
                    <label for="purpose_of_license">Purpose of the License:</label>
                    <select name="purpose_of_license" id="purpose_of_license" required>
                        <option value="personal" <?php echo $license['purpose_of_license'] == 'personal' ? 'selected' : ''; ?>>Personal</option>
                        <option value="commercial" <?php echo $license['purpose_of_license'] == 'commercial' ? 'selected' : ''; ?>>Commercial</option>
                        <option value="both" <?php echo $license['purpose_of_license'] == 'both' ? 'selected' : ''; ?>>Both</option>
                    </select>
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
    </div>

    <script>
        function closeError() {
            document.querySelector('.error_message').style.display = 'none';
        }

        function closeSuccess() {
            document.querySelector('.success_message').style.display = 'none';
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
