<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Prepare SQL statements to delete associated records and vehicle
    $delete_licenses_sql = "DELETE FROM licenses WHERE vehicle_id = ?";
    $delete_owners_sql = "DELETE FROM owners WHERE vehicle_id = ?";
    $delete_drivers_sql = "DELETE FROM drivers WHERE vehicle_id = ?";
    $delete_vehicle_sql = "DELETE FROM vehicles WHERE id = ?";

    // Prepare and execute the statements
    if ($stmt = $conn->prepare($delete_licenses_sql)) {
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
    }

    if ($stmt = $conn->prepare($delete_owners_sql)) {
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
    }

    if ($stmt = $conn->prepare($delete_drivers_sql)) {
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
    }

    if ($stmt = $conn->prepare($delete_vehicle_sql)) {
        $stmt->bind_param("i", $vehicle_id);
        $stmt->execute();
    }

    // Redirect to a page that lists vehicles or a confirmation page
    header("Location: view_vehicles.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
