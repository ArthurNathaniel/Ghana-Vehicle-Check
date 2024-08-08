<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Fetch all police personnel from the database
$sql = "SELECT * FROM police";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Police</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_registered_police.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="view_all">
       <div class="title">
       <h2>Registered Police Personnel</h2>
       </div>
        <table>
            <thead>
                <tr>
                    <th>Profile Picture</th>
                    <th>Rank</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>First Name</th>
                    <th>Badge Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" class="profile-picture"></td>
                        <td><?php echo htmlspecialchars($row['mttd_rank']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['badge_number']); ?></td>
                        <td><button class="view-details" data-id="<?php echo $row['id']; ?>">View Details</button></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Police Details</h2>
            <div id="modal-body">
                <!-- Police details will be loaded here -->
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Get the modal
        var modal = document.getElementById("detailsModal");
        var span = document.getElementsByClassName("close-btn")[0];

        // Get all "View Details" buttons
        var buttons = document.querySelectorAll(".view-details");

        buttons.forEach(function(button) {
            button.addEventListener("click", function() {
                var id = this.getAttribute("data-id");
                
                // Fetch police details via AJAX
                fetch('fetch_police_details.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        var modalBody = document.getElementById("modal-body");
                        modalBody.innerHTML = `
                            <img src="${data.profile_picture}" alt="Profile Picture" class="modal-profile-picture">
                            <p><strong>First Name:</strong> ${data.first_name}</p>
                            <p><strong>Middle Name:</strong> ${data.middle_name}</p>
                            <p><strong>Last Name:</strong> ${data.last_name}</p>
                            <p><strong>Date of Birth:</strong> ${data.dob}</p>
                            <p><strong>Phone Number:</strong> ${data.phone_number}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>House Address:</strong> ${data.house_address}</p>
                            <p><strong>Badge Number:</strong> ${data.badge_number}</p>
                            <p><strong>MTTD Rank:</strong> ${data.mttd_rank}</p>
                            <p><strong>Police Station:</strong> ${data.police_station}</p>
                            <p><strong>Username:</strong> ${data.username}</p>
                        `;
                        modal.style.display = "block";
                    });
            });
        });

        // Close the modal when the user clicks on <span> (x)
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Close the modal when the user clicks anywhere outside of the modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
