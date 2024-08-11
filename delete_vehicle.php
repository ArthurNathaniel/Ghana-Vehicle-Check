<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Fetch the profile picture file paths for the owner and driver
    // Fetch owner profile picture
    $get_owner_pictures_sql = "SELECT profile_picture FROM owners WHERE vehicle_id = ?";
    $stmt = $conn->prepare($get_owner_pictures_sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $owner_result = $stmt->get_result()->fetch_assoc();
    $owner_profile_picture = $owner_result['profile_picture'];

    // Fetch driver profile picture
    $get_driver_pictures_sql = "SELECT profile_picture FROM drivers WHERE vehicle_id = ?";
    $stmt = $conn->prepare($get_driver_pictures_sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $driver_result = $stmt->get_result()->fetch_assoc();
    $driver_profile_picture = $driver_result['profile_picture'];

    // Prepare SQL statements to delete associated records and vehicle
    $delete_licenses_sql = "DELETE FROM licenses WHERE vehicle_id = ?";
    $delete_owners_sql = "DELETE FROM owners WHERE vehicle_id = ?";
    $delete_drivers_sql = "DELETE FROM drivers WHERE vehicle_id = ?";
    $delete_vehicle_sql = "DELETE FROM vehicles WHERE id = ?";

    // Execute deletion of licenses, owners, drivers, and vehicle
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

    // Delete profile pictures from the server
    if ($owner_profile_picture && file_exists("uploads/owners/" . $owner_profile_picture)) {
        unlink("uploads/owners/" . $owner_profile_picture);
    }

    if ($driver_profile_picture && file_exists("uploads/drivers/" . $driver_profile_picture)) {
        unlink("uploads/drivers/" . $driver_profile_picture);
    }

    // Redirect to a page that lists vehicles or a confirmation page
    header("Location: view_vehicles.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
