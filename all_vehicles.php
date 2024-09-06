<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}

// Fetch vehicle details
$sql = "SELECT vr.registration_date, vr.license_plate, vr.make, vr.model, vr.year, vr.color,
               vr.owner_id_number, vr.owner_name, vr.owner_dob, vr.owner_phone, vr.owner_email,
               vr.owner_gender, vr.owner_address, vr.profile_picture, vr.insurance_start_date,
               vr.insurance_expiry_date, IFNULL(sv.id, 'Not Reported') AS stolen_status
        FROM vehicle_registration vr
        LEFT JOIN stolen_vehicles sv ON vr.license_plate = sv.license_plate";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
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
    <div class="view_all">
        <div class="title">
            <h2>Verify Vehicle Details</h2>
        </div>
        
        <!-- Search Input -->
        <div class="forms">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for license plate, make, or model.." title="Type in a name">
        </div>
        <table>
            <thead>
                <tr>
                    <th>License Plate</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Insurance Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="vehicleTable">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        // Check if insurance expiry date is due
                        $expiry_date = new DateTime($row['insurance_expiry_date']);
                        $current_date = new DateTime();
                        $date_diff = $expiry_date < $current_date ? 'expired' : 'valid';
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['license_plate']); ?></td>
                            <td><?php echo htmlspecialchars($row['make']); ?></td>
                            <td><?php echo htmlspecialchars($row['model']); ?></td>
                            <td><?php echo htmlspecialchars($row['year']); ?></td>
                            <td style="color: <?php echo $date_diff === 'expired' ? 'red' : 'green'; ?>;">
                                <?php echo htmlspecialchars($row['insurance_expiry_date']); ?>
                            </td>
                            <td><?php echo $row['stolen_status'] === 'Not Reported' ? 'Not Stolen' : 'Stolen'; ?></td>
                            <td><button class="view" onclick="showModal('<?php echo $row['license_plate']; ?>')">View</button></td>
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

    <!-- Modal -->
    <div id="vehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        function showModal(licensePlate) {
            // Fetch details from the database using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_vehicle_details.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    document.getElementById('modalContent').innerHTML = this.responseText;
                    document.getElementById('vehicleModal').style.display = 'block';
                }
            };
            xhr.send('license_plate=' + licensePlate);
        }

        function closeModal() {
            document.getElementById('vehicleModal').style.display = 'none';
        }

        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('vehicleTable');
            const tr = table.getElementsByTagName('tr');
            let noResults = true;

            for (let i = 0; i < tr.length; i++) {
                const tdLicense = tr[i].getElementsByTagName('td')[0];
                const tdMake = tr[i].getElementsByTagName('td')[1];
                const tdModel = tr[i].getElementsByTagName('td')[2];
                if (tdLicense || tdMake || tdModel) {
                    const txtValueLicense = tdLicense.textContent || tdLicense.innerText;
                    const txtValueMake = tdMake.textContent || tdMake.innerText;
                    const txtValueModel = tdModel.textContent || tdModel.innerText;
                    if (txtValueLicense.toUpperCase().indexOf(filter) > -1 ||
                        txtValueMake.toUpperCase().indexOf(filter) > -1 ||
                        txtValueModel.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                        noResults = false;
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }

            const noResultRow = document.getElementById('noResultRow');
            if (noResults) {
                if (!noResultRow) {
                    const row = table.insertRow();
                    row.id = 'noResultRow';
                    const cell = row.insertCell(0);
                    cell.colSpan = 7;
                    cell.textContent = 'No search results found.';
                }
            } else {
                if (noResultRow) {
                    noResultRow.remove();
                }
            }
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
