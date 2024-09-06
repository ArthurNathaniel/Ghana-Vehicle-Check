<?php
include 'db.php';

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Fetch matching license plates from the database
    $stmt = $conn->prepare("SELECT license_plate FROM vehicle_registration WHERE license_plate LIKE ?");
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any results were found
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['license_plate'] . "'>" . $row['license_plate'] . "</option>";
        }
    } else {
        echo "<option value='' disabled>No matching license plates found</option>";
    }

    $stmt->close();
}
?>
