<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the personnel exists
    $check_sql = "SELECT * FROM dvla_personnel WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Personnel exists, proceed to delete
        $delete_sql = "DELETE FROM dvla_personnel WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            // Record deleted successfully
            header("Location: view_dvla_personnel.php?message=Personnel deleted successfully.");
            exit();
        } else {
            // Error occurred during deletion
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        // Personnel not found
        echo "No record found with ID: " . htmlspecialchars($id);
    }
} else {
    // ID not provided
    echo "No ID provided.";
}
?>
