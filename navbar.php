<div class="header_all">
    <div class="motto">
        <p>THE NO. 1 MEDIA SCHOOL IN GHANA</p>
    </div>
    <div class="social_media">
        <a href="https://web.facebook.com/IBMandJ" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        <a href="">Police Login <i class="fas fa-shield-alt"></i></a></a> 
    </div>
</div>
<div class="navbar_all">
    <a href="index.php">
        <div class="logo">

        </div>
    </a>
    <div class="nav_links">
        <a href="index.php">Home</a>
        <a href="">About</a>
        <a href="">Features</a>
        <a href="contact.php">Contact Us</a>
    </div>
    <div class="accounts nav_links">
    <div class="dropdown">
            <a href="#">Academics <span><i class="fa-solid fa-angle-down"></i></span></a>
            <div class="dropdown-content">
              <a href="">Police Login <i class="fas fa-shield-alt"></i></a></a> 
<a href="">DVLA Login <i class="fas fa-car"></i></a>
            </div>
            
        </div>
        <a href="">Admin</a>
    </div>
       

    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="mobile">
        <a href="index.php">Home</a>
        <div class="dropdown">
            <a href="#">About the institution <span><i class="fa-solid fa-angle-down"></i></span></a>
            <div class="dropdown-content">
                <a href="about.php"> History / Our Mission & Vision</a>
                <a href="governing_council.php">Governing Council</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#">Academics <span><i class="fa-solid fa-angle-down"></i></span></a>
            <div class="dropdown-content">
                <a href="calendar.php">Calender</a>
                <a href="department.php">Department</a>
                <a href="handbook.php"> Students handbook / Statutes</a>

            </div>
        </div>
        <a href="src.php">SRC</a>

        <div class="dropdown">
            <a href="#">Admission <span><i class="fa-solid fa-angle-down"></i></span></a>
            <div class="dropdown-content">
                <a href="admission.php">How to apply</a>
                <a href="online_admission.php">Online Admission</a>
            </div>
        </div>
        <a href="alumni.php">Alumni</a>
        <a href="contact.php">Contact Us</a>
    </div>
</div>

<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".mobile");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "flex";
            sidebar.style.flexDirection = "column";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>