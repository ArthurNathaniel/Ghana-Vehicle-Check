<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM dvla_personnel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (isset($_GET['edit'])) {
            echo json_encode($row);
        } else {
            echo "
            
              <br>  
            <p><strong>Profile Picture:</strong> <br> <img src='" . htmlspecialchars($row['profile_picture']) . "' alt='Profile Picture' width='100' height='100'><br>
           <br> <strong>First Name:</strong> " . htmlspecialchars($row['first_name']) . "</p>
           <br>     
           <p><strong>Middle Name:</strong> " . htmlspecialchars($row['middle_name']) . "</p>
           <br>     
           <p><strong>Last Name:</strong> " . htmlspecialchars($row['last_name']) . "</p>
           <br>     
           <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
           <br>    
           <p><strong>Phone Number:</strong> " . htmlspecialchars($row['phone_number']) . "</p>
           <br>    
           <p> </p>";
               
        }
    } else {
        echo "No record found.";
    }
}
?>
