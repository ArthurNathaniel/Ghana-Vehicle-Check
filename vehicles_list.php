<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}

// Fetch all vehicles from the database
$stmt = $conn->prepare("SELECT id, license_plate, make, model, year FROM vehicle_registration");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles List</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/vehicles_list.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="vehicles_list">
        <h2>Vehicles List</h2>
        
        <table>
            <thead>
                <tr>
                    <th>License Plate</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($vehicle = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($vehicle['license_plate']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['make']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                        <td><?php echo htmlspecialchars($vehicle['year']); ?></td>
                        <td>
                            <a href="view_vehicle.php?id=<?php echo $vehicle['id']; ?>" class="btn btn-view">View Details</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if ($result->num_rows === 0): ?>
            <p>No vehicles found.</p>
        <?php endif; ?>

        <?php $stmt->close(); ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
