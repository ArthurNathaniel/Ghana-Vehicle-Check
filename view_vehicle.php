<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}

// Fetch vehicle details
$sql = "SELECT vr.license_plate, vr.make, vr.model, vr.year, vr.insurance_start_date, vr.insurance_expiry_date,
               IFNULL(sv.id, 'Not Reported') AS stolen_status
        FROM vehicle_registration vr
        LEFT JOIN stolen_vehicles sv ON vr.license_plate = sv.license_plate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicle Details</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_vehicles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="vehicle_details">
        <div class="title">
            <h2>View Vehicle Details</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>License Plate</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Insurance Start Date</th>
                    <th>Insurance Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['license_plate']); ?></td>
                            <td><?php echo htmlspecialchars($row['make']); ?></td>
                            <td><?php echo htmlspecialchars($row['model']); ?></td>
                            <td><?php echo htmlspecialchars($row['year']); ?></td>
                            <td><?php echo htmlspecialchars($row['insurance_start_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['insurance_expiry_date']); ?></td>
                            <td>
                                <?php echo $row['stolen_status'] === 'Not Reported' ? 'Not Stolen' : 'Stolen'; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No vehicle details available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
