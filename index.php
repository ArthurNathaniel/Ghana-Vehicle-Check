<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ghana Vehicle Check connects the MTTD and DVLA to verify vehicle details during traffic stops.">
    <meta name="author" content="Nathaniel Kwabena Larbi Arthur">
    <title>Ghana Vehicle Check</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
<?php include 'navbar.php'?>

    <section id="home" class="home-section">
        <div class="home-content">
            <h2>Welcome to Ghana Vehicle Check</h2>
            <p>Ensuring road safety by verifying vehicle details during traffic stops.</p>
            <a href="#features" class="btn">Learn More</a>
        </div>
    </section>

    <section id="about" class="about-section">
        <h2>About Ghana Vehicle Check</h2>
        <p>This platform connects the Motor Traffic and Transport Department (MTTD) of the Ghana Police Service and the Driver and Vehicle Licensing Authority (DVLA) to ensure vehicles on the road meet safety standards.</p>
    </section>

    <section id="features" class="features-section">
        <h2>Features</h2>
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-car"></i>
                <h3>Vehicle Registration</h3>
                <p>DVLA can easily register new vehicles in the system.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-search"></i>
                <h3>License Plate Check</h3>
                <p>MTTD officers can verify vehicle details using license plate numbers.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <h3>Stolen Vehicle Alerts</h3>
                <p>Identify and flag stolen vehicles during routine checks.</p>
            </div>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <h2>Contact Us</h2>
        <p>For more information, please reach out to us.</p>
        <ul>
            <li>Email: info@ghanavehiclecheck.gov.gh</li>
            <li>Phone: +233 123 456 789</li>
        </ul>
    </section>

    <footer>
        <p>&copy; 2024 Ghana Vehicle Check. All Rights Reserved.</p>
    </footer>
</body>
</html>

<style>
    header {
    background-color: #004080;
    color: white;
    padding: 10px 0;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.logo h1 {
    margin: 0;
    font-size: 24px;
}

.nav-links {
    list-style: none;
    display: flex;
    gap: 20px;
}

.nav-links li {
    display: inline;
}

.nav-links a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
}

.nav-links a:hover {
    color: #ffcc00;
}

.auth-buttons .btn {
    background-color: #ffcc00;
    color: #004080;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    margin-left: 10px;
    transition: background-color 0.3s ease;
}

.auth-buttons .btn:hover {
    background-color: #e6b800;
}

.home-section {
    background: url('images/dvla_01.jpg') no-repeat center center/cover;
    color: white;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 20px;
    margin-top: 60px; /* Adjust for fixed header */
}

.home-content h2 {
    font-size: 48px;
    margin-bottom: 20px;
}

.home-content p {
    font-size: 24px;
    margin-bottom: 20px;
}

.home-content .btn {
    background-color: #ffcc00;
    color: #004080;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

.home-content .btn:hover {
    background-color: #e6b800;
}

.about-section,
.features-section,
.contact-section {
    padding: 60px 20px;
    background-color: #ffffff;
    text-align: center;
}

.about-section h2,
.features-section h2,
.contact-section h2 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #004080;
}

.features-section .features-grid {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.features-section .feature-item {
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    max-width: 300px;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.features-section .feature-item i {
    font-size: 40px;
    color: #004080;
    margin-bottom: 10px;
}

.features-section .feature-item h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.features-section .feature-item p {
    font-size: 16px;
    color: #666;
}

.contact-section ul {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    font-size: 18px;
}

.contact-section li {
    margin: 10px 0;
}

footer {
    background-color: #004080;
    color: white;
    text-align: center;
    padding: 20px 0;
    margin-top: 20px;
}

footer p {
    margin: 0;
}
</style>