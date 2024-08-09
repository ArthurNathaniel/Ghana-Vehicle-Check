<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$sql = "SELECT * FROM dvla_personnel";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View DVLA Personnel</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/view_registered_police.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="view_all">
    <div class="title">
        <h2>Registered DVLA Personnel</h2>
    </div>
    <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search DVLA personnel">
        </div>
    <?php if ($result->num_rows > 0): ?>
        <table id="dvlaTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Profile Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['middle_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td class="profile"><img src="<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" class="profile-picture" ></td>

                        <td class="actions act">
                            <a href="#" class="view-btn" data-id="<?php echo $row['id']; ?>"><i class="fas fa-eye"></i></a>
                            <a href="edit_personnel.php?id=<?php echo $row['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i></a>
                            <a href="delete_personnel.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div id="noResults" style="display:none;">No DVLA personnel found.</div>

    <?php else: ?>
        <p>No personnel found.</p>
    <?php endif; ?>
</div>

<!-- View Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" id="viewClose">&times;</span>
        <h2>View Personnel</h2>
        <div id="viewDetails"></div>
    </div>
</div>
<?php include 'footer.php'?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // View Personnel
        $('.view-btn').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'get_personnel.php',
                type: 'GET',
                data: { id: id },
                success: function(response) {
                    $('#viewDetails').html(response);
                    $('#viewModal').show();
                }
            });
        });

        $('#viewClose').on('click', function() {
            $('#viewModal').hide();
        });

        // Close modals when clicking outside
        $(window).on('click', function(event) {
            if ($(event.target).is('.modal')) {
                $('.modal').hide();
            }
        });
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
            var filter = this.value.toLowerCase();
            var rows = document.querySelectorAll('#dvlaTable tbody tr');
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
