<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$error_message = "";
$success_message = "";

// Generate unique badge number
$badge_number = 'MTTD-' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $house_address = $_POST['house_address'];
    $mttd_rank = $_POST['mttd_rank'];
    $police_station = $_POST['police_station'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Handle file upload
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        if (in_array($file_extension, $allowed_extensions)) {
            $file_name = 'profile_' . $badge_number . '.' . $file_extension;
            $file_path = 'uploads/' . $file_name;
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                $profile_picture = $file_path;
            } else {
                $error_message = "Error uploading the profile picture.";
            }
        } else {
            $error_message = "Invalid file type for profile picture. Only jpg, jpeg, and png are allowed.";
        }
    }

    // Check for duplicates
    $check_sql = "SELECT * FROM police WHERE username='$username' OR email='$email' OR badge_number='$badge_number'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $error_message = "Username, Email, or Badge Number already exists.";
    } else {
        $sql = "INSERT INTO police (first_name, middle_name, last_name, dob, phone_number, email, house_address, badge_number, mttd_rank, police_station, username, password, profile_picture) 
                VALUES ('$first_name', '$middle_name', '$last_name', '$dob', '$phone_number', '$email', '$house_address', '$badge_number', '$mttd_rank', '$police_station', '$username', '$password', '$profile_picture')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Police personnel registered successfully.";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a Police</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="register_all">
        <div class="register_title">
            <h2>Register Police</h2>
            <p>GHANA VEHICLE CHECK - MOTOR TRAFFIC AND TRANSPORT DEPARTMENT (MTTD)</p>
        </div>
        <?php if ($error_message != ""): ?>
            <div class="error_message error">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeError()">x</span>
            </div>
        <?php endif; ?>
        <?php if ($success_message != ""): ?>
            <div class="success_message">
                <?php echo $success_message; ?>
                <span class="close-btns" onclick="closeSuccess()">x</span>
            </div>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="forms">
                <label>First Name:</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Middle Name:</label>
                    <input type="text" name="middle_name">
                </div>

                <div class="forms">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Date of Birth:</label>
                    <input type="date" name="dob" required>
                </div>

                <div class="forms">
                    <label>Phone Number:</label>
                    <input type="number" min="0" name="phone_number" required>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Email Address:</label>
                    <input type="email" name="email" required>
                </div>

                <div class="forms">
                    <label>House Address:</label>
                    <input type="text" name="house_address" required>
                </div>
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Badge Number:</label>
                    <input type="text" name="badge_number" value="<?php echo $badge_number; ?>" disabled>
                </div>

                <div class="forms">
                    <label for="mttd-rank">MTTD Rank:</label>
                    <select id="mttd-rank" name="mttd_rank" required>
                        <option value="" selected hidden>Select MTTD Rank</option>
                        <option value="traffic_warden">Traffic Warden</option>
                        <option value="junior_officer">Junior Officer</option>
                        <option value="senior_officer">Senior Officer</option>
                        <option value="inspector">Inspector</option>
                        <option value="chief_inspector">Chief Inspector</option>
                        <option value="asp">Assistant Superintendent of Police (ASP)</option>
                        <option value="dsp">Deputy Superintendent of Police (DSP)</option>
                        <option value="superintendent">Superintendent of Police</option>
                        <option value="chief_superintendent">Chief Superintendent of Police</option>
                        <option value="acp">Assistant Commissioner of Police (ACP)</option>
                        <option value="dcop">Deputy Commissioner of Police (DCOP)</option>
                    </select>
                </div>
            </div>

            <div class="forms">
                <label for="police-station">Police Station/Office:</label>
                <select id="police-station" name="police_station" required>
                    <option value="" selected hidden>Select Police Station/Office</option>
                    <option value="accra_central_police_station">Accra Central Police Station</option>
                    <option value="kumasi_central_police_station">Kumasi Central Police Station</option>
                    <option value="cape_coast_police_station">Cape Coast Police Station</option>
                    <option value="takoradi_police_station">Takoradi Police Station</option>
                    <option value="tema_police_station">Tema Police Station</option>
                    <option value="ho_police_station">Ho Police Station</option>
                    <option value="tamale_police_station">Tamale Police Station</option>
                    <option value="koforidua_police_station">Koforidua Police Station</option>
                    <option value="bolgatanga_police_station">Bolgatanga Police Station</option>
                    <option value="wa_police_station">Wa Police Station</option>
                    <option value="sunnyani_police_station">Sunyani Police Station</option>
                    <option value="techiman_police_station">Techiman Police Station</option>
                    <option value="asokwa_police_station">Asokwa Police Station</option>
                    <option value="madina_police_station">Madina Police Station</option>
                    <option value="kaneshie_police_station">Kaneshie Police Station</option>
                    <option value="osu_police_station">Osu Police Station</option>
                    <option value="teshie_police_station">Teshie Police Station</option>
                </select>
            </div>

            <div class="forms">
                <label>Profile Picture:</label>
                <input type="file" name="profile_picture" accept="image/*">
            </div>

            <div class="forms_grid">
                <div class="forms">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>

                <div class="forms">
                    <label>Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <div class="show_password">
                <input type="checkbox" id="showPassword">
                Show password
            </div>
            <div class="forms forms_submit">
                <button type="submit">Register a Police Personnel</button>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        function closeError() {
            document.querySelector('.error_message').style.display = 'none';
        }
        function closeSuccess() {
            document.querySelector('.success_message').style.display = 'none';
        }

        // Show password toggle
        document.getElementById('showPassword').addEventListener('change', function() {
            var pinInput = document.getElementById('password');
            pinInput.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
