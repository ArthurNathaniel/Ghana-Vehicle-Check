<?php
include 'db.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Username already exists.";
    } else {
        // Insert new admin
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/auth.css">
</head>

<body>
    <div class="auth_all">
        <div class="auth_swiper">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="./images/signup_01.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="./images/signup_02.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="auth_forms">
            <div class="logo"></div>
            <div class="forms_title">
                <h2>GHANA POLICE SERVICE - SIGN UP </h2>
                <p>GHANA VECHICLE CHECK - MOTOR TRAFFIC AND TRANSPORT DEPARTMENT (MTTD)</p>
            </div>
        
            <?php if ($error_message != ""): ?>
                <div id="error-message" class="error">
                    <?php echo $error_message; ?>
                    <span class="close-btn" onclick="closeError()">x</span>
                </div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="forms">
                    <label>Username: </label>
                    <input type="text" placeholder="Enter your username" name="username" required>
                </div>
                <div class="forms">
                    <label>Password: </label>
                    <input type="password" id="password" placeholder="Enter your password" name="password" required>
                </div>

                <div class="show_password">
                    <input type="checkbox" id="showPassword">
                    Show password
                </div>
                <div class="forms">
                    <button type="submit">Signup</button>
                </div>
            </form>
        </div>

    </div>
    <script src="./js/swiper.js"></script>
    <script>
        function closeError() {
            document.getElementById('error-message').style.display = 'none';
        }

        document.getElementById('showPassword').addEventListener('change', function() {
            var pinInput = document.getElementById('password');
            if (this.checked) {
                pinInput.type = 'text';
            } else {
                pinInput.type = 'password';
            }
        });
    </script>
</body>

</html>