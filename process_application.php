<?php
include 'db.php';
session_start();

// Helper function to upload files
function uploadFile($file, $target_dir) {
    // Ensure the target directory exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($file["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if file is an image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        $_SESSION['error_message'] = "File is not an image.";
        return false;
    }
    
    // Allow certain file formats
    if (!in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
        $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return false;
    }
    
    // If everything is ok, try to upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return basename($file["name"]);
    } else {
        $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        return false;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $license_id = htmlspecialchars($_POST['license_id']);
    $full_name = htmlspecialchars($_POST['full_name']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    $place_of_birth = htmlspecialchars($_POST['place_of_birth']);
    $nationality = htmlspecialchars($_POST['nationality']);
    $gender = htmlspecialchars($_POST['gender']);
    $residential_address = htmlspecialchars($_POST['residential_address']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $email_address = htmlspecialchars($_POST['email_address']);
    $id_type = htmlspecialchars($_POST['id_type']);
    $id_number = htmlspecialchars($_POST['id_number']);
    $license_category = htmlspecialchars($_POST['license_category']);
    $purpose_of_license = htmlspecialchars($_POST['purpose_of_license']);
    $license_start_date = htmlspecialchars($_POST['license_start_date']);
    $license_end_date = htmlspecialchars($_POST['license_end_date']);
    $emergency_name = htmlspecialchars($_POST['emergency_name']);
    $relationship = htmlspecialchars($_POST['relationship']);
    $emergency_phone_number = htmlspecialchars($_POST['emergency_phone_number']);

    // Handle file uploads
    $profile_picture = uploadFile($_FILES['profile_picture'], 'uploads/profile_pictures/');
    $medical_fitness_declaration = uploadFile($_FILES['medical_fitness_declaration'], 'uploads/medical_fitness_declarations/');
    $eye_test_results = uploadFile($_FILES['eye_test_results'], 'uploads/eye_test_results/');
    
    if (!$profile_picture || !$medical_fitness_declaration || !$eye_test_results) {
        header("Location: drivers_license.php");
        exit();
    }

    // Check for duplicate license_id
    $stmt = $conn->prepare("SELECT * FROM driver_license_applications WHERE license_id = ?");
    $stmt->bind_param("s", $license_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "A record with this License ID already exists.";
        header("Location: drivers_license.php");
        exit();
    }

    $stmt->close();

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO driver_license_applications 
        (license_id, full_name, date_of_birth, place_of_birth, nationality, gender, residential_address, phone_number, email_address, id_type, id_number, license_category, purpose_of_license, license_start_date, license_end_date, emergency_name, relationship, emergency_phone_number, profile_picture, medical_fitness_declaration, eye_test_results) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssssssssssssssssssss", 
        $license_id, $full_name, $date_of_birth, $place_of_birth, $nationality, $gender, $residential_address, $phone_number, $email_address, $id_type, $id_number, $license_category, $purpose_of_license, $license_start_date, $license_end_date, $emergency_name, $relationship, $emergency_phone_number, $profile_picture, $medical_fitness_declaration, $eye_test_results);

    // Execute statement
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Application submitted successfully!";
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: drivers_license.php");
    exit();
}
?>
