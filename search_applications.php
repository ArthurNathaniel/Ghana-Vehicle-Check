<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT license_id, full_name, license_start_date, license_end_date, profile_picture, license_category, purpose_of_license FROM driver_license_applications";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE license_id LIKE '%$search%' OR full_name LIKE '%$search%' OR purpose_of_license LIKE '%$search%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td><img src="' . htmlspecialchars($row['profile_picture']) . '" alt="Profile Picture" width="50" height="50"></td>
                <td>' . htmlspecialchars($row['license_id']) . '</td>
                <td>' . htmlspecialchars($row['full_name']) . '</td>
                <td>' . htmlspecialchars($row['license_start_date']) . '</td>
                <td class="' . (strtotime($row['license_end_date']) < time() ? 'expired' : 'valid') . '">' . htmlspecialchars($row['license_end_date']) . '</td>
                <td>' . htmlspecialchars($row['license_category']) . '</td>
                <td>' . htmlspecialchars($row['purpose_of_license']) . '</td>
                <td><button class="view" onclick="viewApplication(\'' . $row['license_id'] . '\')">View</button></td>
              </tr>';
    }
} else {
    echo '<tr><td colspan="8">No driver license applications available.</td></tr>';
}

$conn->close();
?>
