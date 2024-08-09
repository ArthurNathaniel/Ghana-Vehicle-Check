<?php
include 'db.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $sql = "SELECT * FROM dvla_personnel WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Generate a random reset code
        $reset_code = rand(100000, 999999);

        // Store the reset code in the database
        $update_sql = "UPDATE dvla_personnel SET reset_code = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $reset_code, $email);
        $update_stmt->execute();

        // Set the success message
        $success_message = "A reset code has been sent to your email.";
    } else {
        $error_message = "No dvla_personnel found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/auth.css">
    <link rel="stylesheet" href="./css/register_police.css">
</head>
<body>
<div class="register_all">
    <div class="auth_forms">
        <div class="logo"></div>
        <div class="forms_title">
            <h2>FORGOT PASSWORD</h2>
            <p>GHANA VEHICLE CHECK - MOTOR TRAFFIC AND TRANSPORT DEPARTMENT (MTTD)</p>
        </div>
        <?php if ($error_message != ""): ?>
            <div class="error_message error" id="error-message">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeError()">x</span>
            </div>
        <?php endif; ?>
        <?php if ($success_message != ""): ?>
            <div class="success_message" id="success-message">
                <?php echo $success_message; ?>
                <span class="close-btns" onclick="closeSuccess()">x</span>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="forms">
                <label>Email: </label>
                <input type="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="forms">
                <button type="submit">Send Reset Code</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>
    // Initialize EmailJS
    (function() {
        emailjs.init('KUBS-FeyuOZceuDVf');
    })();

    // Send email with EmailJS
    <?php if ($success_message != ""): ?>
        document.addEventListener("DOMContentLoaded", function() {
            emailjs.send('service_udiacji', 'template_54jkk49', {
                email: '<?php echo $email; ?>',
                reset_code: '<?php echo $reset_code; ?>'
            }).then(function(response) {
                console.log('SUCCESS!', response.status, response.text);
                window.location.href = 'reset_password_dvla.php?email=' + encodeURIComponent('<?php echo $email; ?>');
            }, function(error) {
                console.log('FAILED...', error);
                document.getElementById('success-message').innerHTML = 'Failed to send reset code. Please try again.';
            });
        });
    <?php endif; ?>

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

    // Close success message with animation
    function closeSuccess() {
        anime({
            targets: '#success-message',
            opacity: 0,
            translateY: -20,
            duration: 500,
            easing: 'easeOutExpo',
            complete: function() {
                document.getElementById('success-message').style.display = 'none';
            }
        });
    }
</script>
</body>
</html>
