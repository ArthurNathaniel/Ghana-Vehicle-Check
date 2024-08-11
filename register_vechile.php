<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}

// Function to generate unique Owner ID
function generateOwnerID($registration_date) {
    $year = date('y', strtotime($registration_date));
    $random_number = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    return "GH-DVLA-$random_number-$year";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $registration_date = $_POST['vehicle_registration_date'];
    $license_plate = $_POST['vehicle_license_plate'];
    $make = $_POST['vehicle_make'];
    $model = $_POST['vehicle_model'];
    $year = $_POST['vehicle_year'];
    $color = $_POST['vehicle_color'];
    $owner_id_number = $_POST['owner_id_number'];
    $owner_name = $_POST['owner_name'];
    $owner_dob = $_POST['owner_dob'];
    $owner_phone = $_POST['owner_phone'];
    $owner_email = $_POST['owner_email'];
    $owner_gender = $_POST['owner_gender'];
    $owner_address = $_POST['owner_address'];
    $insurance_start_date = $_POST['insurance_start_date'];
    $insurance_expiry_date = $_POST['insurance_expiry_date'];
    
    // Handle file upload for profile picture
    $profile_picture = $_FILES['owner_profile_picture']['name'];
    $target_dir = "uploads/owner_profile_pictures/";
    $target_file = $target_dir . basename($profile_picture);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES['owner_profile_picture']['tmp_name']);
    if ($check === false) {
        $error_message = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['owner_profile_picture']['size'] > 500000) {
        $error_message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error_message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['owner_profile_picture']['tmp_name'], $target_file)) {
            // File upload successful
        } else {
            $error_message = "Sorry, there was an error uploading your file.";
        }
    }

    // Check for duplicate license plate number
    if (empty($error_message)) {
        $stmt = $conn->prepare("SELECT id FROM vehicle_registration WHERE license_plate = ?");
        $stmt->bind_param("s", $license_plate);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "A vehicle with this license plate number is already registered.";
        }
        $stmt->close();
    }

    // If no errors, insert data into the database
    if (empty($error_message)) {
        $stmt = $conn->prepare("INSERT INTO vehicle_registration (registration_date, license_plate, make, model, year, color, owner_id_number, owner_name, owner_dob, owner_phone, owner_email, owner_gender, owner_address, profile_picture, insurance_start_date, insurance_expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssss", $registration_date, $license_plate, $make, $model, $year, $color, $owner_id_number, $owner_name, $owner_dob, $owner_phone, $owner_email, $owner_gender, $owner_address, $profile_picture, $insurance_start_date, $insurance_expiry_date);

        if ($stmt->execute()) {
            $success_message = "Vehicle registered successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Vehicle</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="title">
            <h2>Register Vehicle</h2>
        </div>
        <?php if (!empty($error_message)): ?>
            <div class="error_message error" id="error-message">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeError()">x</span>
            </div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success_message success" id="success-message">
                <?php echo $success_message; ?>
                <span class="close-btns" onclick="closeSuccess()">x</span>
            </div>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="headings">
                <h3>Vehicle Information</h3>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Registration Date: </label>
                    <input type="date" name="vehicle_registration_date" required>
                </div>
                <div class="forms">
                    <label>License Plate Number: </label>
                    <input type="text" name="vehicle_license_plate" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Make: </label>
                    <input type="text" name="vehicle_make" required>
                </div>
                <div class="forms">
                    <label>Model: </label>
                    <input type="text" name="vehicle_model" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Year: </label>
                    <input type="number" name="vehicle_year" required>
                </div>
                <div class="forms">
                    <label>Color: </label>
                    <input type="text" name="vehicle_color" required>
                </div>
            </div>
            <div class="headings">
                <h3>Owner Information</h3>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Owner ID Number: </label>
                    <input type="text" name="owner_id_number" value="<?php echo isset($_POST['owner_id_number']) ? $_POST['owner_id_number'] : generateOwnerID(date('Y-m-d')); ?>" readonly required>
                </div>
                <div class="forms">
                    <label>Full Name: </label>
                    <input type="text" name="owner_name" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Date of Birth: </label>
                    <input type="date" name="owner_dob" required>
                </div>
                <div class="forms">
                    <label>Phone Number: </label>
                    <input type="text" name="owner_phone" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Email: </label>
                    <input type="email" name="owner_email" required>
                </div>
                <div class="forms">
                    <label>Gender: </label>
                    <select name="owner_gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Address: </label>
                    <input type="text" name="owner_address" required>
                </div>
                <div class="forms">
                    <label>Profile Picture: </label>
                    <input type="file" name="owner_profile_picture" accept="image/*" required>
                </div>
            </div>
            <div class="headings">
                <h3>Insurance Information</h3>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Start Date: </label>
                    <input type="date" name="insurance_start_date" required>
                </div>
                <div class="forms">
                    <label>Expiry Date: </label>
                    <input type="date" name="insurance_expiry_date" required>
                </div>
            </div>
            <div class="forms forms_submit">
                <button type="submit">Register Vehicle</button>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>
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
