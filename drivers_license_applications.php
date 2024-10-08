<?php
include 'db.php';
session_start();
if (!isset($_SESSION['police'])) {
    header("Location: police_login.php");
    exit();
}

// Get search query from URL parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with search filter
$sql = "SELECT license_id, full_name, license_start_date, license_end_date, profile_picture, license_category, purpose_of_license FROM driver_license_applications";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE license_id LIKE '%$search%' OR full_name LIKE '%$search%' OR purpose_of_license LIKE '%$search%'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver License Applications</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/drivers_license.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="view_all">
    <div class="title">
        <h2>Verify Driver License Details</h2>
    </div>
    <form id="searchForm">
        <div class="forms">
            <input type="text" id="searchInput" name="search" placeholder="Search by License ID, Name, or Purpose" value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="forms forms_submit">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="title">
        <h2>Driver License Applications</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Profile Picture</th>
                <th>License ID Number</th>
                <th>Full Name</th>
                <th>License Start Date</th>
                <th>License End Date</th>
                <th>License Type</th>
                <th>Purpose</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="applicationsTableBody">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src='uploads/profile_pictures/<?php echo htmlspecialchars($row['profile_picture']); ?>' alt='Profile Picture' width='100'></td>
                        <td><?php echo htmlspecialchars($row['license_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['license_start_date']); ?></td>
                        <td class="<?php echo strtotime($row['license_end_date']) < time() ? 'expired' : 'valid'; ?>">
                            <?php echo htmlspecialchars($row['license_end_date']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['license_category']); ?></td>
                        <td><?php echo htmlspecialchars($row['purpose_of_license']); ?></td>
                        <td><button class="view" onclick="viewApplication('<?php echo $row['license_id']; ?>')">View</button></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No driver license applications available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal for viewing application details -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="logo dvla_logo"></div>
                <h2>Driver License Application Details</h2>
                <hr>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewModalBody">
                <!-- Details will be loaded here by JavaScript -->
            </div>
            <hr>
            <div class="modal-footer">
                <p>All Copyright &copy; Reserved
                <script>
                    document.write(new Date().getFullYear())
                </script>
                | Ghana Vehicle Check</p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Handle search form submission
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        var query = $('#searchInput').val();
        window.location.href = '?search=' + encodeURIComponent(query);
    });

    // Function to view application details
    window.viewApplication = function(license_id) {
        $.ajax({
            url: 'view_application.php',
            method: 'POST',
            data: { license_id: license_id },
            success: function(response) {
                $('#viewModalBody').html(response);
                $('#viewModal').modal('show');
            }
        });
    };
});
</script>
</body>
</html>

<?php
$conn->close();
?>
