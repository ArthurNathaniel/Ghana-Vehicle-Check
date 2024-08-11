<?php
include 'db.php';
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}

// Fetch vehicles from the database
$query = "SELECT * FROM vehicle_registration";
$result = $conn->query($query);

$vehicles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }
}
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
    <style>
        /* Basic modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
     
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="view_all">
        <h2>Registered Vehicles</h2>

        <div class="forms">
        <input type="text" id="searchInput" placeholder="Search for vehicles..." onkeyup="searchTable()">
        </div>

        <table id="vehiclesTable">
            <thead>
                <tr>
                    <th>License Plate Number</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Owner ID Number</th>
                    <th>Full Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?php echo htmlspecialchars($vehicle['license_plate']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['make']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['owner_id_number']); ?></td>
                    <td><?php echo htmlspecialchars($vehicle['owner_name']); ?></td>
                    <td><button onclick="viewDetails(<?php echo htmlspecialchars(json_encode($vehicle)); ?>)">View</button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for vehicle details -->
    <div id="vehicleModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Vehicle Details</h2>
            <p><strong>License Plate Number:</strong> <span id="modalLicensePlate"></span></p>
            <p><strong>Make:</strong> <span id="modalMake"></span></p>
            <p><strong>Model:</strong> <span id="modalModel"></span></p>
            <p><strong>Year:</strong> <span id="modalYear"></span></p>
            <p><strong>Color:</strong> <span id="modalColor"></span></p>
            <p><strong>Owner ID Number:</strong> <span id="modalOwnerID"></span></p>
            <p><strong>Owner Name:</strong> <span id="modalOwnerName"></span></p>
            <p><strong>Date of Birth:</strong> <span id="modalOwnerDOB"></span></p>
            <p><strong>Phone Number:</strong> <span id="modalOwnerPhone"></span></p>
            <p><strong>Email:</strong> <span id="modalOwnerEmail"></span></p>
            <p><strong>Gender:</strong> <span id="modalOwnerGender"></span></p>
            <p><strong>Address:</strong> <span id="modalOwnerAddress"></span></p>
            <p><strong>Profile Picture:</strong> <img id="modalProfilePicture" src="" alt="Profile Picture"></p>
            <p><strong>Insurance Start Date:</strong> <span id="modalInsuranceStart"></span></p>
            <p><strong>Insurance Expiry Date:</strong> <span id="modalInsuranceExpiry"></span></p>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('vehiclesTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                tr[i].style.display = found ? '' : 'none';
            }
        }

        function viewDetails(vehicle) {
            document.getElementById('modalLicensePlate').textContent = vehicle.license_plate;
            document.getElementById('modalMake').textContent = vehicle.make;
            document.getElementById('modalModel').textContent = vehicle.model;
            document.getElementById('modalYear').textContent = vehicle.year;
            document.getElementById('modalColor').textContent = vehicle.color;
            document.getElementById('modalOwnerID').textContent = vehicle.owner_id_number;
            document.getElementById('modalOwnerName').textContent = vehicle.owner_name;
            document.getElementById('modalOwnerDOB').textContent = vehicle.owner_dob;
            document.getElementById('modalOwnerPhone').textContent = vehicle.owner_phone;
            document.getElementById('modalOwnerEmail').textContent = vehicle.owner_email;
            document.getElementById('modalOwnerGender').textContent = vehicle.owner_gender;
            document.getElementById('modalOwnerAddress').textContent = vehicle.owner_address;
            document.getElementById('modalProfilePicture').src = 'uploads/Owner_profile_pictures/' + vehicle.profile_picture;
            document.getElementById('modalInsuranceStart').textContent = vehicle.insurance_start_date;
            document.getElementById('modalInsuranceExpiry').textContent = vehicle.insurance_expiry_date;

            document.getElementById('vehicleModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('vehicleModal').style.display = 'none';
        }

        // Close modal when clicking outside of the modal
        window.onclick = function(event) {
            const modal = document.getElementById('vehicleModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
