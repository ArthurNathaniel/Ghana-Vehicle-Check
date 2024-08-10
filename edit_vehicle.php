<?php
include 'db.php';

if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    // Fetch vehicle details
    $sql = "SELECT v.id, v.license_plate, v.make, v.model, v.year, 
                   l.start_date AS license_start_date, l.expiry_date AS license_expiry_date,
                   o.name AS owner_name, o.dob AS owner_dob, o.address AS owner_address, 
                   o.phone AS owner_phone, o.email AS owner_email, o.profile_picture AS owner_profile_picture,
                   d.name AS driver_name, d.dob AS driver_dob, d.address AS driver_address, 
                   d.phone AS driver_phone, d.email AS driver_email, d.profile_picture AS driver_profile_picture
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
    } else {
        die("Vehicle not found.");
    }
} else {
    die("Invalid vehicle ID.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $license_plate = $_POST['license_plate'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license_start_date = $_POST['license_start_date'];
    $license_expiry_date = $_POST['license_expiry_date'];
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

    // Update vehicle details
    $sql = "UPDATE vehicles SET license_plate = ?, make = ?, model = ?, year = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $license_plate, $make, $model, $year, $vehicle_id);
    $stmt->execute();

    // Update license details
    $sql = "UPDATE licenses SET start_date = ?, expiry_date = ? WHERE vehicle_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $license_start_date, $license_expiry_date, $vehicle_id);
    $stmt->execute();

    // Update owner details
    $sql = "UPDATE owners SET name = ?, dob = ?, address = ?, phone = ?, email = ? WHERE vehicle_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $owner_name, $owner_dob, $owner_address, $owner_phone, $owner_email, $vehicle_id);
    $stmt->execute();

    // Update driver details
    $sql = "UPDATE drivers SET name = ?, dob = ?, address = ?, phone = ?, email = ? WHERE vehicle_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $driver_name, $driver_dob, $driver_address, $driver_phone, $driver_email, $vehicle_id);
    $stmt->execute();

    // Redirect to view page
    header("Location: view_vehicles.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/edit_vehicle.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Edit Vehicle</h2>
        <form action="edit_vehicle.php?id=<?php echo $vehicle_id; ?>" method="post">
            <fieldset>
                <legend>Vehicle Details</legend>
                <label for="license_plate">License Plate Number:</label>
                <input type="text" id="license_plate" name="license_plate" value="<?php echo htmlspecialchars($vehicle['license_plate']); ?>" required>

                <label for="make">Make:</label>
                <input type="text" id="make" name="make" value="<?php echo htmlspecialchars($vehicle['make']); ?>" required>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>

                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($vehicle['year']); ?>" required>

                <label for="license_start_date">License Start Date:</label>
                <input type="date" id="license_start_date" name="license_start_date" value="<?php echo htmlspecialchars($vehicle['license_start_date']); ?>" required>

                <label for="license_expiry_date">License Expiry Date:</label>
                <input type="date" id="license_expiry_date" name="license_expiry_date" value="<?php echo htmlspecialchars($vehicle['license_expiry_date']); ?>" required>
            </fieldset>

            <fieldset>
                <legend>Owner Details</legend>
                <label for="owner_name">Name:</label>
                <input type="text" id="owner_name" name="owner_name" value="<?php echo htmlspecialchars($vehicle['owner_name']); ?>" required>

                <label for="owner_dob">Date of Birth:</label>
                <input type="date" id="owner_dob" name="owner_dob" value="<?php echo htmlspecialchars($vehicle['owner_dob']); ?>" required>

                <label for="owner_address">Address:</label>
                <textarea id="owner_address" name="owner_address" required><?php echo htmlspecialchars($vehicle['owner_address']); ?></textarea>

                <label for="owner_phone">Phone:</label>
                <input type="text" id="owner_phone" name="owner_phone" value="<?php echo htmlspecialchars($vehicle['owner_phone']); ?>" required>

                <label for="owner_email">Email:</label>
                <input type="email" id="owner_email" name="owner_email" value="<?php echo htmlspecialchars($vehicle['owner_email']); ?>" required>
            </fieldset>

            <fieldset>
                <legend>Driver Details</legend>
                <label for="driver_name">Name:</label>
                <input type="text" id="driver_name" name="driver_name" value="<?php echo htmlspecialchars($vehicle['driver_name']); ?>" required>

                <label for="driver_dob">Date of Birth:</label>
                <input type="date" id="driver_dob" name="driver_dob" value="<?php echo htmlspecialchars($vehicle['driver_dob']); ?>" required>

                <label for="driver_address">Address:</label>
                <textarea id="driver_address" name="driver_address" required><?php echo htmlspecialchars($vehicle['driver_address']); ?></textarea>

                <label for="driver_phone">Phone:</label>
                <input type="text" id="driver_phone" name="driver_phone" value="<?php echo htmlspecialchars($vehicle['driver_phone']); ?>" required>

                <label for="driver_email">Email:</label>
                <input type="email" id="driver_email" name="driver_email" value="<?php echo htmlspecialchars($vehicle['driver_email']); ?>" required>
            </fieldset>

            <button type="submit">Update Vehicle</button>
        </form>
    </div>
</body>
</html>
