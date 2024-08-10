<?php
include 'db.php';
session_start();

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_registration_date = $_POST['vehicle_registration_date'];
    $vehicle_license_plate = $_POST['vehicle_license_plate'];
    $vehicle_make = $_POST['vehicle_make'];
    $vehicle_model = $_POST['vehicle_model'];
    $vehicle_year = $_POST['vehicle_year'];
    $vehicle_color = $_POST['vehicle_color'];

    $owner_name = $_POST['owner_name'];
    $owner_dob = $_POST['owner_dob'];
    $owner_address = $_POST['owner_address'];
    $owner_phone = $_POST['owner_phone'];
    $owner_email = $_POST['owner_email'];
    $owner_profile_picture = $_FILES['owner_profile_picture']['name'];
    $owner_profile_picture_tmp = $_FILES['owner_profile_picture']['tmp_name'];
    move_uploaded_file($owner_profile_picture_tmp, "uploads/owners/$owner_profile_picture");

    $driver_name = $_POST['driver_name'];
    $driver_dob = $_POST['driver_dob'];
    $driver_address = $_POST['driver_address'];
    $driver_phone = $_POST['driver_phone'];
    $driver_email = $_POST['driver_email'];
    $driver_profile_picture = $_FILES['driver_profile_picture']['name'];
    $driver_profile_picture_tmp = $_FILES['driver_profile_picture']['tmp_name'];
    move_uploaded_file($driver_profile_picture_tmp, "uploads/drivers/$driver_profile_picture");

    $license_start_date = $_POST['license_start_date'];
    $license_expiry_date = $_POST['license_expiry_date'];

    // Check for duplicate vehicle
    $sql = "SELECT * FROM vehicles WHERE license_plate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $vehicle_license_plate);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $error_message = "Vehicle with this license plate already exists.";
    } else {
        // Insert vehicle
        $sql = "INSERT INTO vehicles (registration_date, license_plate, make, model, year, color) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $vehicle_registration_date, $vehicle_license_plate, $vehicle_make, $vehicle_model, $vehicle_year, $vehicle_color);
        if ($stmt->execute()) {
            $vehicle_id = $stmt->insert_id;

            // Check for duplicate owner
            $sql = "SELECT * FROM owners WHERE name = ? AND dob = ? AND phone = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $owner_name, $owner_dob, $owner_phone);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $error_message = "Owner with these details already exists.";
            } else {
                // Insert owner
                $sql = "INSERT INTO owners (vehicle_id, name, dob, address, phone, email, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("issssss", $vehicle_id, $owner_name, $owner_dob, $owner_address, $owner_phone, $owner_email, $owner_profile_picture);
                if ($stmt->execute()) {
                    // Check for duplicate driver
                    $sql = "SELECT * FROM drivers WHERE name = ? AND dob = ? AND phone = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $driver_name, $driver_dob, $driver_phone);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $error_message = "Driver with these details already exists.";
                    } else {
                        // Insert driver
                        $sql = "INSERT INTO drivers (vehicle_id, name, dob, address, phone, email, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("issssss", $vehicle_id, $driver_name, $driver_dob, $driver_address, $driver_phone, $driver_email, $driver_profile_picture);
                        if ($stmt->execute()) {
                            // Insert license
                            $sql = "INSERT INTO licenses (vehicle_id, start_date, expiry_date) VALUES (?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("iss", $vehicle_id, $license_start_date, $license_expiry_date);
                            if ($stmt->execute()) {
                                $success_message = "Vehicle registered successfully!";
                            } else {
                                $error_message = "Error registering license.";
                            }
                        } else {
                            $error_message = "Error registering driver.";
                        }
                    }
                } else {
                    $error_message = "Error registering owner.";
                }
            }
        } else {
            $error_message = "Error registering vehicle.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Vehicle</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="title">
            <h2>Register Vehicle</h2>
        </div>
        <?php if ($error_message != ""): ?>
            <div class="error_message error" id="error-message">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeError()">x</span>
            </div>
        <?php endif; ?>
        <?php if ($success_message != ""): ?>
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
                    <label>Name: </label>
                    <input type="text" id="owner_name" name="owner_name" required>
                </div>
                <div class="forms">
                    <label>Date of Birth: </label>
                    <input type="date" id="owner_dob" name="owner_dob" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Address: </label>
                    <input type="text" id="owner_address" name="owner_address" required>
                </div>
                <div class="forms">
                    <label>Phone Number: </label>
                    <input type="text" id="owner_phone" name="owner_phone" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Email: </label>
                    <input type="email" id="owner_email" name="owner_email" required>
                </div>
                <div class="forms">
                    <label>Profile Picture: </label>
                    <input type="file" id="owner_profile_picture" name="owner_profile_picture" accept="image/*" required>
                </div>
               
            </div>
            <div class="forms_grid">
            <div class="forms">
                <label>Owner's ID Number:</label>
                <input type="text" name="owner_id_number">
                </div>
                <div class="forms">
                <label for="owner-gender">Owner's Gender:</label>
            <select id="owner-gender" name="owner_gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
                </div>
            </div>
            <div class="form">
                <input type="checkbox" id="same_as_owner" onclick="copyOwnerDetails()">
                <p>Tick if the owner details is the same as driver details</p>
            </div>
            <div class="headings">
                <h3>Driver Information</h3>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Name: </label>
                    <input type="text" id="driver_name" name="driver_name" required>
                </div>
                <div class="forms">
                    <label>Date of Birth: </label>
                    <input type="date" id="driver_dob" name="driver_dob" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Address: </label>
                    <input type="text" id="driver_address" name="driver_address" required>
                </div>
                <div class="forms">
                    <label>Phone Number: </label>
                    <input type="text" id="driver_phone" name="driver_phone" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Email: </label>
                    <input type="email" id="driver_email" name="driver_email" required>
                </div>
                <div class="forms">
                    <label>Profile Picture: </label>
                    <input type="file" id="driver_profile_picture" name="driver_profile_picture" accept="image/*" required>
                </div>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>Driver's ID Number:</label>
                    <input type="text" name="driver_id_number">
                </div>
                <div class="forms">
                    <label for="driver-gender">Driver's Gender:</label>
                    <select id="driver-gender" name="driver_gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="headings">
                <h3>License Information</h3>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label>License Start Date: </label>
                    <input type="date" name="license_start_date" required>
                </div>
                <div class="forms">
                    <label>License Expiry Date: </label>
                    <input type="date" name="license_expiry_date" required>
                </div>
            </div>
            <div class="forms forms_submit">
                <button type="submit">Register Vehicle</button>
            </div>
        </form>
    </div>
    <script>
        function copyOwnerDetails() {
            const ownerName = document.getElementById('owner_name').value;
            const ownerDob = document.getElementById('owner_dob').value;
            const ownerAddress = document.getElementById('owner_address').value;
            const ownerPhone = document.getElementById('owner_phone').value;
            const ownerEmail = document.getElementById('owner_email').value;


            if (document.getElementById('same_as_owner').checked) {
                document.getElementById('driver_name').value = ownerName;
                document.getElementById('driver_dob').value = ownerDob;
                document.getElementById('driver_address').value = ownerAddress;
                document.getElementById('driver_phone').value = ownerPhone;
                document.getElementById('driver_email').value = ownerEmail;
            } else {
                document.getElementById('driver_name').value = '';
                document.getElementById('driver_dob').value = '';
                document.getElementById('driver_address').value = '';
                document.getElementById('driver_phone').value = '';
                document.getElementById('driver_email').value = '';
            }
        }

        function closeError() {
            document.getElementById('error-message').style.display = 'none';
        }

        function closeSuccess() {
            document.getElementById('success-message').style.display = 'none';
        }
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>