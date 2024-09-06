<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}
// Fetch stolen vehicle details
$sql = "SELECT sv.id, sv.license_plate, sv.stolen_date, sv.report_details, vr.make, vr.model, vr.year
        FROM stolen_vehicles sv
        LEFT JOIN vehicle_registration vr ON sv.license_plate = vr.license_plate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Stolen Vehicles</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_vehicles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="view_all">
        <div class="title">
            <h2>View Stolen Vehicles</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>License Plate</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Stolen Date</th>
                    <th>Report Details</th>
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
                            <td><?php echo htmlspecialchars($row['stolen_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['report_details']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No stolen vehicles reported.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
