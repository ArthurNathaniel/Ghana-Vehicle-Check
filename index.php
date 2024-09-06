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
    <?php include 'navbar.php' ?>
    <section>
        <div class="hero">
            <div class="swiper mySwiper2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="hero_text">
                            <h1>Welcome to Ghana Vehicle Check</h1>
                            <p>Ensuring road safety by verifying vehicle details during traffic stops.</p>
                        </div>
                        <img src="./images/police_01.jpg" alt="">
                    </div>

                    <div class="swiper-slide">
                        <div class="hero_text">
                            <h1>Welcome to Ghana Vehicle Check</h1>
                            <p>Ensuring road safety by verifying vehicle details during traffic stops.</p>
                        </div>
                        <img src="./images/dvla_04.jpg" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section>
        <div class="about_grid">
            <div class="about_img">
                <img src="./images/gvc.png" alt="">
            </div>
            <div class="about_text">
                <h2>About Ghana Vehicle Check</h2>
                <p>
                    At Ghana Vehicle Check, we are committed to enhancing road safety and vehicle
                    regulation in Ghana. Our platform serves as a bridge between the Ghana Police
                    Service (MTTD) and the Driver and Vehicle Licensing Authority (DVLA), ensuring
                    that every vehicle on the road meets legal and safety standards.
                </p>
                <p>
                    Through our innovative system, the DVLA can seamlessly register vehicles and keep
                    track of their details, while the MTTD has real-time access to crucial vehicle information.
                    Whether it's verifying a vehicle’s registration, checking for stolen vehicles, or ensuring
                    compliance with insurance and road safety regulations, our platform is designed to support
                    law enforcement and protect the public
                </p>
                <p>
                    Our mission is to provide a reliable, efficient, and secure service that aids the MTTD in
                    maintaining order on the roads while giving the DVLA the tools they need to manage vehicle
                    registrations effectively. By bringing these two essential agencies together, we aim to reduce
                    vehicle-related crimes and promote a safer driving environment for everyone in Ghana
                </p>
                <p>
                    Join us in our mission to make Ghana's roads safer and more secure for all.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="features_grid">
           
        <div class="feature_box">
                <i class="fas fa-car"></i>
                <h3>Vehicle Registration</h3>
                <p>DVLA can easily register new vehicles in the system.</p>
            </div>

            <div class="feature_box">
            <i class="fas fa-search"></i>
                <h3>License Plate Check</h3>
                <p>MTTD officers can verify vehicle details using license plate numbers.</p>
            </div>

            <div class="feature_box">
            <i class="fas fa-shield-alt"></i>
                <h3>Stolen Vehicle Alerts</h3>
                <p>Identify and flag stolen vehicles during routine checks.</p>
            </div>
        </div>
    </section>

   
    

    <footer class="footer">
        
        <p>
        All Copyright &copy; Reserved
        <script>
            document.write(new Date().getFullYear())
        </script>
        | Ghana Vechile Check
        </p>
        <br>
        <p><a href="login.php"> <i class="fas fa-user"></i> Login as an Administrator</a></p>
    </footer>
    <script src="./js/swiper.js"></script>
</body>

</html>

