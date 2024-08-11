<?php
include 'db.php';

// Get search query from URL parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare SQL query with search filter
$sql = "SELECT license_id, full_name, license_start_date, license_end_date, profile_picture, license_category, purpose_of_license FROM driver_license_applications";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE license_id LIKE '%$search%' OR full_name LIKE '%$search%' OR purpose_of_license LIKE '%$search%'";
}

$result = $conn->query($sql);

// Generate HTML for the table rows
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><img src="uploads/profile_pictures/' . $row['profile_picture'] . '" alt="Profile Picture" class="profile_table"></td>';
        echo '<td>' . $row['license_id'] . '</td>';
        echo '<td>' . $row['full_name'] . '</td>';
        echo '<td>' . $row['license_start_date'] . '</td>';
        echo '<td>' . $row['license_end_date'] . '</td>';
        echo '<td>' . $row['license_category'] . '</td>';
        echo '<td>' . $row['purpose_of_license'] . '</td>';
        echo '<td class="actions"><button class="btn btn-info btn-sm" onclick="viewApplication(\'' . $row['license_id'] . '\')"><i class="fas fa-eye"></i></button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8">No applications found.</td></tr>';
}

$conn->close();
?>
