<?php
include 'db.php';

// Fetch vehicles from the database
$sql = "SELECT v.id, v.license_plate, v.make, v.model, v.year, l.start_date AS license_start_date, l.expiry_date AS license_expiry_date
        FROM vehicles v
        LEFT JOIN licenses l ON v.id = l.vehicle_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Vehicles</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_vehicles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="view_all_vehicles">
        <h2>View Vehicles</h2>
        <input type="text" id="searchBox" placeholder="Search vehicles..." />

        <table>
            <thead>
                <tr>
                    <th>License Plate Number</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>License Information</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="vehicleTableBody">
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['license_plate']); ?></td>
                    <td><?php echo htmlspecialchars($row['make']); ?></td>
                    <td><?php echo htmlspecialchars($row['model']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['license_start_date']) . ' to ' . htmlspecialchars($row['license_expiry_date']); ?></td>
                    <td class="actions">
                        <a href="#" class="view-btn" data-id="<?php echo $row['id']; ?>"><i class="fas fa-eye"></i></a>
                        <a href="edit_vehicle.php?id=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                        <a href="delete_vehicle.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- View Vehicle Modal -->
    <div id="view-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Vehicle Details</h2>
            <div id="vehicle-details">
                <!-- Vehicle details will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open modal and load vehicle details
            document.querySelectorAll('.view-btn').forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const vehicleId = this.getAttribute('data-id');
                    const modal = document.getElementById('view-modal');
                    const vehicleDetails = document.getElementById('vehicle-details');

                    // Fetch vehicle details
                    fetch(`view_vehicle_details.php?id=${vehicleId}`)
                        .then(response => response.text())
                        .then(data => {
                            vehicleDetails.innerHTML = data;
                            modal.style.display = 'block';
                        });
                });
            });

            // Close modal
            document.querySelector('.close-btn').addEventListener('click', function() {
                document.getElementById('view-modal').style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === document.getElementById('view-modal')) {
                    document.getElementById('view-modal').style.display = 'none';
                }
            });
        // });
          // Search functionality
          const searchBox = document.getElementById('searchBox');
            const tableBody = document.getElementById('vehicleTableBody');

            searchBox.addEventListener('input', function() {
                const searchTerm = searchBox.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const match = Array.from(cells).some(cell =>
                        cell.textContent.toLowerCase().includes(searchTerm)
                    );
                    row.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
</body>
</html>
