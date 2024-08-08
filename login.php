<?php
include 'db.php';
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No admin found with that username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
        <div class="logo">
           
        </div>
        <div class="forms_title">
            <h2>GHANA POLICE SERVICE - LOG IN</h2>
            <p>GHANA VEHICLE CHECK - MOTOR TRAFFIC AND TRANSPORT DEPARTMENT (MTTD)</p>
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
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="./js/swiper.js"></script>
<script>
    // Close error message with animation
    function closeError() {
        anime({
            targets: '#error-message',
            opacity: 0,
            translateY: -20,
            duration: 500,
            easing: 'easeOutExpo',
            complete: function() {
                document.getElementById('error-message').style.display = 'none';
            }
        });
    }

    // Show password toggle
    document.getElementById('showPassword').addEventListener('change', function() {
        var pinInput = document.getElementById('password');
        pinInput.type = this.checked ? 'text' : 'password';
    });

    // Animate logo, title, and form fields on page load
    anime({
        targets: '.logo , .show_password ',
        opacity: [0, 1],
        scale: [0.8, 1],
        duration: 1000,
        easing: 'easeOutExpo',
        delay: anime.stagger(300) // stagger title elements
    });

    anime({
        targets: '.forms_title h2, .forms_title p',
        opacity: [0, 1],
        translateY: [20, 0],
        duration: 1000,
        easing: 'easeOutExpo',
        delay: anime.stagger(400) // stagger title elements
    });

    anime({
        targets: '.forms',
        opacity: [0, 1],
        translateY: [20, 0],
        duration: 1000,
        easing: 'easeOutExpo',
        delay: anime.stagger(100, {start: 500}) // stagger form fields, starting after title
    });

    // Animate error message if it exists
    <?php if ($error_message != ""): ?>
    anime({
        targets: '#error-message',
        opacity: [0, 1],
        translateY: [-20, 0],
        duration: 1000,
        easing: 'easeOutExpo'
    });
    <?php endif; ?>
</script>
</body>
</html>
