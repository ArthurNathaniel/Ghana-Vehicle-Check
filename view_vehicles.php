<?php
include 'db.php';

// Fetch vehicles from the database
$sql = "SELECT * FROM vehicles";
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
    <div class="view_vehicles_all">
        <div class="title">
            <h2>View Vehicles</h2>
        </div>
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
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['license_plate']; ?></td>
                        <td><?php echo $row['make']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td>
                            <?php
                            // Fetch license details
                            $vehicle_id = $row['id'];
                            $license_sql = "SELECT * FROM licenses WHERE vehicle_id = ?";
                            $stmt = $conn->prepare($license_sql);
                            $stmt->bind_param("i", $vehicle_id);
                            $stmt->execute();
                            $license_result = $stmt->get_result();
                            $license = $license_result->fetch_assoc();
                            ?>
                            Start Date: <?php echo $license['start_date']; ?><br>
                            Expiry Date: <?php echo $license['expiry_date']; ?>
                        </td>
                        <td>
                            <a href="#" class="view-btn" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye"></i></a>
                            <a href="edit_vehicle.php?id=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="delete_vehicle.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this vehicle?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Vehicle Details</h2>
            <div id="modal-body"></div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
    // JavaScript for modal functionality
    var modal = document.getElementById("viewModal");
    var close = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.view-btn').forEach(function(button) {
        button.onclick = function() {
            var vehicleId = this.getAttribute('data-id');
            fetch('get_vehicle_details.php?id=' + vehicleId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modal-body').innerHTML = `
                        <p><strong>License Plate:</strong> ${data.license_plate}</p>
                        <p><strong>Make:</strong> ${data.make}</p>
                        <p><strong>Model:</strong> ${data.model}</p>
                        <p><strong>Year:</strong> ${data.year}</p>
                        <p><strong>Color:</strong> ${data.color}</p>
                        <h2> Owner Information</h2>
                                                ${data.owner_profile_picture ? `<img src="uploads/owners/${data.owner_profile_picture}" alt="Owner Profile Picture" style="max-width: 100px; height: auto; border-radius: 50%;">` : 'No image available'}

                        <p><strong>Owner ID:</strong> ${data.owner_id}</p>
                        <p><strong>Owner Name:</strong> ${data.owner_name}</p>
                        <p><strong>Owner DOB:</strong> ${data.owner_dob}</p>
                        <p><strong>Owner Address:</strong> ${data.owner_address}</p>
                        <p><strong>Owner Phone:</strong> ${data.owner_phone}</p>
                        <p><strong>Owner Email:</strong> ${data.owner_email}</p>
                        <p><strong>Owner Profile Picture:</strong></p>
                              <h2> Driver Information</h2>
                                                      ${data.driver_profile_picture ? `<img src="uploads/drivers/${data.driver_profile_picture}" alt="Driver Profile Picture" style="max-width: 100px; height: auto; border-radius: 50%;">` : 'No image available'}

                        <p><strong>Driver Name:</strong> ${data.driver_name}</p>
                        <p><strong>Driver DOB:</strong> ${data.driver_dob}</p>
                        <p><strong>Driver Address:</strong> ${data.driver_address}</p>
                        <p><strong>Driver Phone:</strong> ${data.driver_phone}</p>
                        <p><strong>Driver Email:</strong> ${data.driver_email}</p>
                        <p><strong>Driver Profile Picture:</strong></p>
                        <p><strong>License Start Date:</strong> ${data.start_date}</p>
                        <p><strong>License Expiry Date:</strong> ${data.expiry_date}</p>
                    `;
                    modal.style.display = "block";
                });
        };
    });

    close.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>



</body>

</html>
