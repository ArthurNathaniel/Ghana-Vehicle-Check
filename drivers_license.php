<?php
include 'db.php';
session_start();
// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['dvla_personnel'])) {
    header("Location: dvla_login.php");
    exit();
}
// Generate License ID Number
$licenseID = '';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $year = date('Y');
    $random_number = mt_rand(10000000, 99999999);
    $licenseID = "DVLA-$random_number-$year";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver’s License Application Form</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/drivers_license.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="register_all">
        <div class="register_title">
            <div class="logo dvla_logo"></div>
            <h2>Driver’s License Application Form</h2>
        </div>
        <form action="process_application.php" method="post" enctype="multipart/form-data">
            <!-- Display License ID Number -->
            <div class="forms">
                <label for="license_id">License ID Number:</label>
                <input type="text" id="license_id" name="license_id" value="<?php echo htmlspecialchars($licenseID); ?>" readonly>
            </div>
            
            
            <!-- Error and success messages -->
            <?php if (isset($_SESSION['error_message']) && $_SESSION['error_message'] != ""): ?>
                <div class="error_message error">
                    <?php echo $_SESSION['error_message']; ?>
                    <span class="close-btn" onclick="closeError()">x</span>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message'] != ""): ?>
                <div class="success_message">
                    <?php echo $_SESSION['success_message']; ?>
                    <span class="close-btns" onclick="closeSuccess()">x</span>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <!-- 1. Personal Information -->
            <div class="headings">
                <h2>Personal Information</h2>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" id="profile_picture" name="profile_picture" required>
                </div>
                <div class="forms">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="forms">
                    <label for="place_of_birth">Place of Birth:</label>
                    <input type="text" id="place_of_birth" name="place_of_birth" required>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label for="nationality">Nationality:</label>
                    <select id="nationality" name="nationality" required>
                        <option value="" selected hidden>Select Nationality</option>
                        <option value="ghanaian">Ghanaian</option>
                        <option value="non_ghanaian">Non Ghanaian</option>
                    </select>
                </div>
                <div class="forms">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" selected hidden>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            
            <div class="forms_grid">
                <div class="forms">
                    <label for="residential_address">Residential Address:</label>
                    <input type="text" id="residential_address" name="residential_address" required>
                </div>
                <div class="forms">
                    <label for="phone_number">Phone Number:</label>
                    <input type="tel" id="phone_number" name="phone_number" required>
                </div>
            </div>
            <div class="forms">
                <label for="email_address">Email Address:</label>
                <input type="email" id="email_address" name="email_address" required>
            </div>

            <!-- 2. Identification Details -->
            <div class="headings">
                <h2>Identification Details</h2>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label for="id_type">Type of ID Card:</label>
                    <select id="id_type" name="id_type" required>
                        <option value="" selected hidden>Select Type of ID Card</option>
                        <option value="ghana_card">Ghana Card</option>
                        <option value="voters_id">Voter’s ID</option>
                        <option value="passport">Passport Number</option>
                    </select>
                </div>
                <div class="forms">
                    <label for="id_number">ID Card Number:</label>
                    <input type="text" id="id_number" name="id_number" required>
                </div>
            </div>

            <!-- 3. License Details -->
            <div class="headings">
                <h2>License Details</h2>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label for="license_category">License Category:</label>
                    <select id="license_category" name="license_category" required>
                        <option value="" selected hidden>Select License Category</option>
                        <option value="A">License A</option>
                        <option value="B">License B</option>
                        <option value="C">License C</option>
                        <option value="D">License D</option>
                        <option value="E">License E</option>
                        <option value="F">License F</option>
                    </select>
                </div>
                <div class="forms">
                    <label for="purpose_of_license">Purpose of License:</label>
                    <select id="purpose_of_license" name="purpose_of_license" required>
                        <option value="" selected hidden>Select Purpose</option>
                        <option value="personal">Personal</option>
                        <option value="commercial">Commercial</option>
                        <option value="both">Both</option>
                    </select>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label for="medical_fitness_declaration">Medical Fitness Declaration:</label>
                    <input type="file" id="medical_fitness_declaration" name="medical_fitness_declaration" required>
                </div>
                <div class="forms">
                    <label for="eye_test_results">Eye Test Results:</label>
                    <input type="file" id="eye_test_results" name="eye_test_results" required>
                </div>
            </div>
            
            <!-- 4. Emergency Contact -->
            <div class="headings">
                <h2>Emergency Contact</h2>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label for="emergency_name">Emergency Contact Name:</label>
                    <input type="text" id="emergency_name" name="emergency_name" required>
                </div>
                <div class="forms">
                    <label for="relationship">Relationship:</label>
                    <select id="relationship" name="relationship" required>
                        <option value="" selected hidden>Select Relationship</option>
                        <option value="parent">Parent</option>
                        <option value="sister">Sister</option>
                        <option value="brother">Brother</option>
                        <option value="friend">Friend</option>
                        <option value="wife">Wife</option>
                        <option value="husband">Husband</option>
                    </select>
                </div>
            </div>
            <div class="forms">
                <label for="emergency_phone_number">Emergency Contact Phone Number:</label>
                <input type="tel" id="emergency_phone_number" name="emergency_phone_number" required>
            </div>

            <!-- 5. License Duration -->
            <div class="headings">
                <h2>License Duration</h2>
            </div>
            <div class="forms_grid">
                <div class="forms">
                    <label for="license_start_date">License Start Date:</label>
                    <input type="date" id="license_start_date" name="license_start_date" required>
                </div>
                <div class="forms">
                    <label for="license_end_date">License End Date:</label>
                    <input type="date" id="license_end_date" name="license_end_date" required>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="forms forms_submit">
                <button type="submit">Submit Application</button>
            </div>
        </form>
    </div>
 
    <script>
        function closeError() {
            document.querySelector('.error_message').style.display = 'none';
        }

        function closeSuccess() {
            document.querySelector('.success_message').style.display = 'none';
        }
    </script>
</body>
</html>
