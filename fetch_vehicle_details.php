<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $license_plate = $_POST['license_plate'];

    // Fetch vehicle details based on license plate
    $stmt = $conn->prepare("SELECT * FROM vehicle_registration WHERE license_plate = ?");
    $stmt->bind_param("s", $license_plate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Vehicle Details</h2>";
        echo "<p><strong>Registration Date:</strong> " . htmlspecialchars($row['registration_date']) . "</p>";
        echo "<p><strong>License Plate:</strong> " . htmlspecialchars($row['license_plate']) . "</p>";
        echo "<p><strong>Make:</strong> " . htmlspecialchars($row['make']) . "</p>";
        echo "<p><strong>Model:</strong> " . htmlspecialchars($row['model']) . "</p>";
        echo "<p><strong>Year:</strong> " . htmlspecialchars($row['year']) . "</p>";
        echo "<p><strong>Color:</strong> " . htmlspecialchars($row['color']) . "</p>";
        echo "<p><strong>Owner ID:</strong> " . htmlspecialchars($row['owner_id_number']) . "</p>";
        echo "<p><strong>Owner Name:</strong> " . htmlspecialchars($row['owner_name']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($row['owner_dob']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['owner_phone']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($row['owner_email']) . "</p>";
        echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['owner_gender']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($row['owner_address']) . "</p>";
        echo "<p><strong>Insurance Start Date:</strong> " . htmlspecialchars($row['insurance_start_date']) . "</p>";
        echo "<p><strong>Insurance Expiry Date:</strong> " . htmlspecialchars($row['insurance_expiry_date']) . "</p>";
        echo "<p><strong>Profile Picture:</strong></p><img src='uploads/owner_profile_pictures/" . htmlspecialchars($row['profile_picture']) . "' alt='Profile Picture' style='width: 100px; height: 100px;'>";
    } else {
        echo "<p>No details found for this license plate.</p>";
    }

    $stmt->close();
}
?>
