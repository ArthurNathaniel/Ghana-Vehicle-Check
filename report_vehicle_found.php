<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $license_plate = $_POST['vehicle_license_plate'];
    $found_date = $_POST['found_date'];
    $report_details = $_POST['report_details'];

    // Remove the stolen record from the database
    $stmt = $conn->prepare("DELETE FROM stolen_vehicles WHERE license_plate = ?");
    $stmt->bind_param("s", $license_plate);

    if ($stmt->execute()) {
        $success_message = "Vehicle reported as found successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Vehicle Found</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="title">
            <h2>Report Vehicle Found</h2>
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
        <form method="post" action="">
            <div class="headings">
                <h3>Search for Vehicle</h3>
            </div>
            <div class="forms">
                <label>Search License Plate: </label>
                <input type="text" id="search_license_plate" placeholder="Enter license plate number">
       
            </div>
            <div class="forms">
            <button type="button" onclick="searchLicensePlate()">Search</button>
            </div>
            <div class="forms">
                <label>License Plate Number: </label>
                <select name="vehicle_license_plate" id="vehicle_license_plate" required>
                    <option value="" disabled selected>Select License Plate</option>
                    <!-- Search results will be populated here -->
                </select>
            </div>
            <div class="forms">
                <label>Date Found: </label>
                <input type="date" name="found_date" required>
            </div>
            <div class="forms">
                <label>Report Details: </label>
                <textarea name="report_details" rows="4" required></textarea>
            </div>
            <div class="forms forms_submit">
                <button type="submit">Report Vehicle Found</button>
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

        function searchLicensePlate() {
            const searchQuery = $('#search_license_plate').val();

            $.ajax({
                url: 'search_vehicle_found.php',
                method: 'GET',
                data: { query: searchQuery },
                success: function(data) {
                    $('#vehicle_license_plate').html(data);
                }
            });
        }
    </script>
</body>
</html>
