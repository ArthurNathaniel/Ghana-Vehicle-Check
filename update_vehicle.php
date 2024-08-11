<?php
include 'db.php';

$vehicle_id = intval($_POST['vehicle_id']);
$license_plate = $_POST['license_plate'];
$make = $_POST['make'];
$model = $_POST['model'];
$year = intval($_POST['year']);
$color = $_POST['color'];

$owner_name = $_POST['owner_name'];
$owner_dob = $_POST['owner_dob'];
$owner_address = $_POST['owner_address'];
$owner_phone = $_POST['owner_phone'];
$owner_email = $_POST['owner_email'];

$driver_name = $_POST['driver_name'];
$driver_dob = $_POST['driver_dob'];
$driver_address = $_POST['driver_address'];
$driver_phone = $_POST['driver_phone'];
$driver_email = $_POST['driver_email'];

$start_date = $_POST['start_date'];
$expiry_date = $_POST['expiry_date'];

// Handle profile picture uploads
$owner_profile_picture = $_FILES['owner_profile_picture']['name'];
$driver_profile_picture = $_FILES['driver_profile_picture']['name'];

if ($owner_profile_picture) {
    move_uploaded_file($_FILES['owner_profile_picture']['tmp_name'], "uploads/owners/" . $owner_profile_picture);
}

if ($driver_profile_picture) {
    move_uploaded_file($_FILES['driver_profile_picture']['tmp_name'], "uploads/drivers/" . $driver_profile_picture);
}

// Update vehicle
$update_vehicle_sql = "UPDATE vehicles SET license_plate = ?, make = ?, model = ?, year = ?, color = ? WHERE id = ?";
$stmt = $conn->prepare($update_vehicle_sql);
$stmt->bind_param("sssisi", $license_plate, $make, $model, $year, $color, $vehicle_id);
$stmt->execute();

// Update owner
$update_owner_sql = "UPDATE owners SET name = ?, dob = ?, address = ?, phone = ?, email = ?, profile_picture = ? WHERE vehicle_id = ?";
$stmt = $conn->prepare($update_owner_sql);
$stmt->bind_param("ssssssi", $owner_name, $owner_dob, $owner_address, $owner_phone, $owner_email, $owner_profile_picture, $vehicle_id);
$stmt->execute();

// Update driver
$update_driver_sql = "UPDATE drivers SET name = ?, dob = ?, address = ?, phone = ?, email = ?, profile_picture = ? WHERE vehicle_id = ?";
$stmt = $conn->prepare($update_driver_sql);
$stmt->bind_param("ssssssi", $driver_name, $driver_dob, $driver_address, $driver_phone, $driver_email, $driver_profile_picture, $vehicle_id);
$stmt->execute();

// Update license
$update_license_sql = "UPDATE licenses SET start_date = ?, expiry_date = ? WHERE vehicle_id = ?";
$stmt = $conn->prepare($update_license_sql);
$stmt->bind_param("ssi", $start_date, $expiry_date, $vehicle_id);
$stmt->execute();

header('Location: view_vehicles.php');
exit;
?>
