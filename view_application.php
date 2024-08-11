<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $license_id = $_POST['license_id'];
    
    $sql = "SELECT * FROM driver_license_applications WHERE license_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $license_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p><strong>License ID:</strong> " . $row['license_id'] . "</p>";
        echo "<p><strong>Full Name:</strong> " . $row['full_name'] . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . $row['date_of_birth'] . "</p>";
        echo "<p><strong>Place of Birth:</strong> " . $row['place_of_birth'] . "</p>";
        echo "<p><strong>Nationality:</strong> " . $row['nationality'] . "</p>";
        echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
        echo "<p><strong>Residential Address:</strong> " . $row['residential_address'] . "</p>";
        echo "<p><strong>Phone Number:</strong> " . $row['phone_number'] . "</p>";
        echo "<p><strong>Email Address:</strong> " . $row['email_address'] . "</p>";
        echo "<p><strong>ID Type:</strong> " . $row['id_type'] . "</p>";
        echo "<p><strong>ID Number:</strong> " . $row['id_number'] . "</p>";
        echo "<p><strong>License Category:</strong> " . $row['license_category'] . "</p>";
        echo "<p><strong>Purpose of License:</strong> " . $row['purpose_of_license'] . "</p>";
        echo "<p><strong>License Start Date:</strong> " . $row['license_start_date'] . "</p>";
        echo "<p><strong>License End Date:</strong> " . $row['license_end_date'] . "</p>";
        echo "<p><strong>Emergency Contact Name:</strong> " . $row['emergency_name'] . "</p>";
        echo "<p><strong>Relationship:</strong> " . $row['relationship'] . "</p>";
        echo "<p><strong>Emergency Contact Phone Number:</strong> " . $row['emergency_phone_number'] . "</p>";
        echo "<p><strong>Profile Picture:</strong> <img src='uploads/profile_pictures/" . $row['profile_picture'] . "' alt='Profile Picture' width='100'></p>";
        echo "<p><strong>Medical Fitness Declaration:</strong> <a href='uploads/medical_fitness_declarations/" . $row['medical_fitness_declaration'] . "' target='_blank'>View Document</a></p>";
        echo "<p><strong>Eye Test Results:</strong> <a href='uploads/eye_test_results/" . $row['eye_test_results'] . "' target='_blank'>View Document</a></p>";
    } else {
        echo "<p>Application not found.</p>";
    }

    $stmt->close();
}

$conn->close();
?>
