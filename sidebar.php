<div class="sidebar_all">
    <div class="logo"></div>
    <div class="links">
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') : ?>
        <h3><span class="icon"><i class="fa-solid fa-chart-simple"></i></span> Admin</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="register_police.php">Register Police</a>
        <a href="view_registered_police.php">View Registered Police</a>
        <a href="register_vehicle.php">Register Vehicle</a>
        <a href="view_registered_vehicles.php">View Registered Vehicles</a>
        <a href="logout.php">
            <h3><i class="fas fa-sign-out-alt"></i> LOGOUT</h3>
        </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['police'])): ?>
    <h3><span class="icon"><i class="fa-solid fa-chart-simple"></i></span> Police</h3>
    <a href="police_dashboard.php">Dashboard</a>
    <a href="view_police_profile.php">Profile</a>
    <a href="">Search Vechile</a>
    <a href="police_logout.php">
        <h3><i class="fas fa-sign-out-alt"></i> LOGOUT</h3>
    </a>
<?php endif; ?>

</div>


        
       
  
</div>

<button id="toggleButton">
    <i class="fa-solid fa-bars-staggered"></i>
</button>

<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".sidebar_all");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "block";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>
