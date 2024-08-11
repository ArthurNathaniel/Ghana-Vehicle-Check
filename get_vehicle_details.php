<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Fetch vehicle, owner, driver, and license details
    $sql = "SELECT vehicles.*, 
                   owners.owner_id AS owner_id,
                   owners.name AS owner_name, 
                   owners.dob AS owner_dob,
                   owners.address AS owner_address,
                   owners.phone AS owner_phone,
                   owners.email AS owner_email,
                   owners.profile_picture AS owner_profile_picture,
                   drivers.driver_id AS driver_id,
                   drivers.name AS driver_name,
                   drivers.dob AS driver_dob,
                   drivers.address AS driver_address,
                   drivers.phone AS driver_phone,
                   drivers.email AS driver_email,
                   drivers.profile_picture AS driver_profile_picture,
                   licenses.start_date, 
                   licenses.expiry_date
            FROM vehicles
            LEFT JOIN owners ON vehicles.id = owners.vehicle_id
            LEFT JOIN drivers ON vehicles.id = drivers.vehicle_id
            LEFT JOIN licenses ON vehicles.id = licenses.vehicle_id
            WHERE vehicles.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle = $result->fetch_assoc();

    echo json_encode($vehicle);
}
