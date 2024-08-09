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
           <div class="search-container">
           <input type="text" id="searchInput" placeholder="Search police personnel...">
           </div>
        </div>
        <table id="policeTable">
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
                        <td class="profile"><img src="<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" class="profile-picture"></td>
                        <td><?php echo htmlspecialchars($row['mttd_rank']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['badge_number']); ?></td>
                        <td class="actions act">
                            <button class="view-details" data-id="<?php echo $row['id']; ?>"><i class="fas fa-eye"></i></button>
                            <button class="edit-details" data-id="<?php echo $row['id']; ?>"><i class="fas fa-edit"></i></button>
                            <a href="#" class="delete-details" data-id="<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="noResults" style="display:none;">No police personnel found.</div>
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
        var viewButtons = document.querySelectorAll(".view-details");

        viewButtons.forEach(function(button) {
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

        // Handle "Edit" button click
        var editButtons = document.querySelectorAll(".edit-details");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var id = this.getAttribute("data-id");
                // Redirect to the edit profile page with the police id
                window.location.href = 'edit_police_profile.php?id=' + id;
            });
        });

        // Handle "Delete" link click
        var deleteLinks = document.querySelectorAll(".delete-details");

        deleteLinks.forEach(function(link) {
            link.addEventListener("click", function(event) {
                event.preventDefault();
                var id = this.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this police profile?")) {
                    // Send delete request via AJAX
                    fetch('delete_police_profile.php?id=' + id, {
                        method: 'GET'
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            // Reload the page to reflect the deletion
                            location.reload();
                        } else {
                            alert('Error deleting profile: ' + data);
                        }
                    });
                }
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

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var filter = this.value.toLowerCase();
            var rows = document.querySelectorAll('#policeTable tbody tr');
            var found = false;

            rows.forEach(function(row) {
                var cells = row.getElementsByTagName('td');
                var match = false;
                for (var i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
                if (match) {
                    row.style.display = '';
                    found = true;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('noResults').style.display = found ? 'none' : 'block';
        });
    </script>
</body>
</html>
