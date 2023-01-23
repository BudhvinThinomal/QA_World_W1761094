<div class="container__section navigation">
    <div class="navigation_logo">
        <a href="<?php echo(base_url());?>index.php/Home">
            <img src="<?php echo(base_url());?>assets/images/QAWorldNav.png" alt="QAWorldLogo"/>
        </a>
    </div>

    <div class="navigation__title">
            <h2>Question Time!!</h2>
    </div>
    
    <div class="navigation__btn">
        <img src="<?php echo(base_url());?>assets/images/notifications-outline.svg" alt="Notifications"/>
        <img src="<?php echo(base_url());?>assets/images/person-outline.svg" alt="Account"  onclick="openNav()" id="open-side-nav-btn"/>
    </div>
</div>

<div id="side-nav-popup">
    <a href="<?php echo(base_url());?>index.php/Login">Log In</a> <br>
    <a href="<?php echo(base_url());?>index.php/Signin">Sign In</a> <br>
    <a style="cursor: pointer;" id="logout-btn">Log Out</a>
</div>

<script>
    // Get the side navigation popup
    var navPopup = document.getElementById("side-nav-popup");

    // Get the button that opens the side navigation popup
    var openNavBtn = document.getElementById("open-side-nav-btn");

    // Add a click event listener to the button
    openNavBtn.addEventListener("click", openNav);

    // Add a click event listener to the document
    document.addEventListener("click", function(event) {
        // If the user clicks outside of the side navigation popup and the button, close the side navigation popup
        if (!navPopup.contains(event.target) && !openNavBtn.contains(event.target)) {
            closeNav();
        }
    });

    // Open side navigation popup function
    function openNav() {
        navPopup.style.display = "block";
    }

    // Close side navigation popup function
    function closeNav() {
        navPopup.style.display = "none";
    }

</script>

<script>
    // Get the logout button
    var logoutBtn = document.getElementById("logout-btn");

    var isLoggedIn = Backbone.View.extend({
    el: "#open-side-nav-btn",
    events: {
        "click": "getData"
    },
    getData: function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
            type: "GET",
            success: function(response) {
                
                if (response == true) {
                    logoutBtn.style.display = "block";
                } else {
                    logoutBtn.style.display = "none";
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                // Handle any errors that occur during the request
            }
        });
    }
    });

    var logoutView = new isLoggedIn();
</script>

<div id="logout-popup">
    <div class="logout-content">
        <h3>Are you sure you want to log out?</h3>
        <div class="logout-btns">
            <button id="logout-yes-btn">Yes</button>
            <button id="logout-no-btn">No</button>
        </div>
    </div>
</div>

<script>
    // Get the logout button
    var logoutBtn = document.getElementById("logout-btn");

    // Get the logout popup
    var logoutPopup = document.getElementById("logout-popup");

    // Get the yes and no buttons in the popup
    // var logoutYesBtn = document.getElementById("logout-yes-btn");
    var logoutNoBtn = document.getElementById("logout-no-btn");

    // Add a click event listener to the logout button
    logoutBtn.addEventListener("click", function() {
        logoutPopup.style.display = "block";
    });

    // Add a click event listener to the document
    document.addEventListener("click", function(event) {
        // If the user clicks outside of the spopup and the button, close the popup
        if (!logoutPopup.contains(event.target) && !logoutBtn.contains(event.target)) {
            closePopup();
        }
    });

    // Add a click event listener to the no button
    logoutNoBtn.addEventListener("click", function() {
        closePopup();
    });

    // Close side popup function
    function closePopup() {
        logoutPopup.style.display = "none";
    }
</script>

<script>
    // Get the logout popup
    var logoutPopup = document.getElementById("logout-popup");

    var LogoutView = Backbone.View.extend({
    el: "#logout-yes-btn",
    events: {
        "click": "getData"
    },
    getData: function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo (base_url()); ?>index.php/api/User/logout",
            type: "GET",
            success: function(response) {
                logoutPopup.style.display = "none";
                if (response == true) {
                    window.location.href = "<?php echo (base_url()); ?>index.php/Login"
                } else {
                    alert("Cannot logout at the moment!!")
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                // Handle any errors that occur during the request
            }
        });
    }
    });

    var logoutView = new LogoutView();
</script>