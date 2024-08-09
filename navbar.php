<div class="header_all">
    <div class="motto">
        <p>Ghana Vehicle Check</p>
    </div>
    <div class="social_media">
        <a href="https://web.facebook.com/IBMandJ" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        <a href="" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    </div>
</div>
<div class="navbar_all">
    <a href="index.php">
        <div class="logo gvc_logo">

        </div>
    </a>
    <div class="nav_links">
        <a href="index.php">Home</a>
        <a href="">About</a>
        <a href="">Features</a>
 
    </div>
    <div class="accounts ">
  
 <a href="police_login.php">
 <button>  <i class="fas fa-user"></i> Login Police</button>
 </a>
 |
  <a href="dvla_login.php">
  <button>   <i class="fas fa-user"></i> Login DVLA</button>
  </a>
    </div>
       

    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="mobile">
    <a href="index.php">Home</a>
        <a href="">About</a>
        <a href="">Features</a>
        <a href=""><i class="fas fa-user"></i> Login Police</a>
        <a href=""><i class="fas fa-user"></i> Login DVLA</a>
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