<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];
    $sql = "SELECT v.license_plate, v.make, v.model, v.year, l.start_date AS license_start_date, l.expiry_date AS license_expiry_date,
                   o.name AS owner_name, o.dob AS owner_dob, o.address AS owner_address, o.phone AS owner_phone, o.email AS owner_email, o.profile_picture AS owner_profile_picture,
                   d.name AS driver_name, d.dob AS driver_dob, d.address AS driver_address, d.phone AS driver_phone, d.email AS driver_email, d.profile_picture AS driver_profile_picture
            FROM vehicles v
            LEFT JOIN licenses l ON v.id = l.vehicle_id
            LEFT JOIN owners o ON v.id = o.vehicle_id
            LEFT JOIN drivers d ON v.id = d.vehicle_id
            WHERE v.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $vehicle = $result->fetch_assoc();
        echo "<p><strong>License Plate Number:</strong> " . htmlspecialchars($vehicle['license_plate']) . "</p>";
        echo "<p><strong>Make:</strong> " . htmlspecialchars($vehicle['make']) . "</p>";
        echo "<p><strong>Model:</strong> " . htmlspecialchars($vehicle['model']) . "</p>";
        echo "<p><strong>Year:</strong> " . htmlspecialchars($vehicle['year']) . "</p>";
        echo "<p><strong>License Start Date:</strong> " . htmlspecialchars($vehicle['license_start_date']) . "</p>";
        echo "<p><strong>License Expiry Date:</strong> " . htmlspecialchars($vehicle['license_expiry_date']) . "</p>";

        echo "<h3>Owner Details</h3>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($vehicle['owner_name']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($vehicle['owner_dob']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($vehicle['owner_address']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($vehicle['owner_phone']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($vehicle['owner_email']) . "</p>";
        if ($vehicle['owner_profile_picture']) {
            echo "<img src='uploads/owners/" . htmlspecialchars($vehicle['owner_profile_picture']) . "' alt='Owner Profile Picture' style='max-width: 100px;'>";
        }

        echo "<h3>Driver Details</h3>";
        echo "<p><strong>Name:</strong> " . htmlspecialchars($vehicle['driver_name']) . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . htmlspecialchars($vehicle['driver_dob']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($vehicle['driver_address']) . "</p>";
        echo "<p><strong>Phone:</strong> " . htmlspecialchars($vehicle['driver_phone']) . "</p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($vehicle['driver_email']) . "</p>";
        if ($vehicle['driver_profile_picture']) {
            echo "<img src='uploads/drivers/" . htmlspecialchars($vehicle['driver_profile_picture']) . "' alt='Driver Profile Picture' style='max-width: 100px;'>";
        }
    } else {
        echo "<p>No details found for this vehicle.</p>";
    }
}
?>
