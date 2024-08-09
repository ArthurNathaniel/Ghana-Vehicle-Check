<div class="sidebar_all">
    
    <div class="links">
   
    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === 'admin') : ?>
        <div class="logo"></div>
        <h3><span class="icon"><i class="fa-solid fa-chart-simple"></i></span> MTTD DEPARTMENT</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="register_police.php">Register Police</a>
        <a href="view_registered_police.php">Registered Police</a>
        <h3><span class="icon"><i class="fa-solid fa-chart-simple"></i></span> DVLA DEPARTMENT</h3>
        <a href="">Dashboard</a>
        <a href="register_dvla_personnel.php">Register DVLA Personmel</a>
        <a href="view_dvla_personnel.php">Registered DVLA Personnels</a>
        <a href="logout.php">
            <h3><i class="fas fa-sign-out-alt"></i> LOGOUT</h3>
        </a>
    <?php endif; ?>

    <?php if (isset($_SESSION['police'])): ?>
        <div class="logo"></div>
    <h3><span class="icon"><i class="fa-solid fa-chart-simple"></i></span> MTTD - POLICE</h3>
    <a href="police_dashboard.php">Dashboard</a>
    <a href="view_police_profile.php">Profile</a>
    <a href="">Search Vechile</a>
 
    <a href="police_logout.php">
        <h3><i class="fas fa-sign-out-alt"></i> LOGOUT</h3>
    </a>
<?php endif; ?>

<?php if (isset($_SESSION['dvla_personnel'])): ?>
    <div class="logo dvla_logo"></div>
    <h3><span class="icon"><i class="fas fa-car"></i>
    </span> DVLA</h3>
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
