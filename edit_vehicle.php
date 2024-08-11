<?php
include 'db.php';

// Fetch the vehicle ID from the query string
$vehicle_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the vehicle details
$vehicle_sql = "SELECT * FROM vehicles WHERE id = ?";
$stmt = $conn->prepare($vehicle_sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$vehicle = $stmt->get_result()->fetch_assoc();

// Fetch the owner details
$owner_sql = "SELECT * FROM owners WHERE vehicle_id = ?";
$stmt = $conn->prepare($owner_sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$owner = $stmt->get_result()->fetch_assoc();

// Fetch the driver details
$driver_sql = "SELECT * FROM drivers WHERE vehicle_id = ?";
$stmt = $conn->prepare($driver_sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$driver = $stmt->get_result()->fetch_assoc();

// Fetch the license details
$license_sql = "SELECT * FROM licenses WHERE vehicle_id = ?";
$stmt = $conn->prepare($license_sql);
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$license = $stmt->get_result()->fetch_assoc();
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
    <div class="edit_vehicle">
        <h2>Edit Vehicle Details</h2>
        <form action="update_vehicle.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="vehicle_id" value="<?php echo $vehicle['id']; ?>">

            <fieldset>
                <legend>Vehicle Information</legend>
                <label for="license_plate">License Plate:</label>
                <input type="text" id="license_plate" name="license_plate" value="<?php echo htmlspecialchars($vehicle['license_plate']); ?>" required>
                
                <label for="make">Make:</label>
                <input type="text" id="make" name="make" value="<?php echo htmlspecialchars($vehicle['make']); ?>" required>
                
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
                
                <label for="year">Year:</label>
                <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($vehicle['year']); ?>" required>
                
                <label for="color">Color:</label>
                <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($vehicle['color']); ?>" required>
            </fieldset>

            <fieldset>
                <legend>Owner Information</legend>
                <label for="owner_name">Name:</label>
                <input type="text" id="owner_name" name="owner_name" value="<?php echo htmlspecialchars($owner['name']); ?>" required>
                
                <label for="owner_dob">Date of Birth:</label>
                <input type="date" id="owner_dob" name="owner_dob" value="<?php echo htmlspecialchars($owner['dob']); ?>" required>
                
                <label for="owner_address">Address:</label>
                <textarea id="owner_address" name="owner_address" required><?php echo htmlspecialchars($owner['address']); ?></textarea>
                
                <label for="owner_phone">Phone:</label>
                <input type="text" id="owner_phone" name="owner_phone" value="<?php echo htmlspecialchars($owner['phone']); ?>" required>
                
                <label for="owner_email">Email:</label>
                <input type="email" id="owner_email" name="owner_email" value="<?php echo htmlspecialchars($owner['email']); ?>" required>
                
                <label for="owner_profile_picture">Profile Picture:</label>
                <input type="file" id="owner_profile_picture" name="owner_profile_picture">
                <?php if ($owner['profile_picture']): ?>
                    <img src="uploads/owners/<?php echo htmlspecialchars($owner['profile_picture']); ?>" alt="Owner Profile Picture" style="max-width: 100px;">
                <?php endif; ?>
            </fieldset>

            <fieldset>
                <legend>Driver Information</legend>
                <label for="driver_name">Name:</label>
                <input type="text" id="driver_name" name="driver_name" value="<?php echo htmlspecialchars($driver['name']); ?>" required>
                
                <label for="driver_dob">Date of Birth:</label>
                <input type="date" id="driver_dob" name="driver_dob" value="<?php echo htmlspecialchars($driver['dob']); ?>" required>
                
                <label for="driver_address">Address:</label>
                <textarea id="driver_address" name="driver_address" required><?php echo htmlspecialchars($driver['address']); ?></textarea>
                
                <label for="driver_phone">Phone:</label>
                <input type="text" id="driver_phone" name="driver_phone" value="<?php echo htmlspecialchars($driver['phone']); ?>" required>
                
                <label for="driver_email">Email:</label>
                <input type="email" id="driver_email" name="driver_email" value="<?php echo htmlspecialchars($driver['email']); ?>" required>
                
                <label for="driver_profile_picture">Profile Picture:</label>
                <input type="file" id="driver_profile_picture" name="driver_profile_picture">
                <?php if ($driver['profile_picture']): ?>
                    <img src="uploads/drivers/<?php echo htmlspecialchars($driver['profile_picture']); ?>" alt="Driver Profile Picture" style="max-width: 100px;">
                <?php endif; ?>
            </fieldset>

            <fieldset>
                <legend>License Information</legend>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($license['start_date']); ?>" required>
                
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?php echo htmlspecialchars($license['expiry_date']); ?>" required>
            </fieldset>

            <button type="submit">Update Vehicle</button>
        </form>
    </div>
</body>

</html>
