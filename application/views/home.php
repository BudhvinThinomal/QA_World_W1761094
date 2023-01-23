<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Home</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/home.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>
</head>

<body>
    <div class="container">
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

        <div class="container__section">
            <div class="navigation__search">
                <div class="searchContainer">
                    <img src="<?php echo(base_url());?>assets/images/search-outline.svg" alt="Search"/>
                    <input type="text" placeholder="Search"/>
                </div>
            </div>
        </div>

        <!-- Filtering section -->
        <div class="container__section midSection">
            
            <div class="filter">
                <img src="<?php echo(base_url());?>assets/images/options-outline.svg" alt="Filter"/>
                <p>2</p>
            </div>
            <div class="postQuestion">
                <button id="post-question-btn">Post a Question</button>
            </div>
        </div>
       
       <!-- question section -->
       <div class="container__section questions">
            <!-- <div class="questionContainer">
                <div class="questionContainer__left">
                    <div class="questionContainer__left__top">
                        <a href="<?php echo(base_url());?>index.php/Question">How to perform form validation for a required field in HTML ?</a>
                    </div>
                    <div class="questionContainer__left__bottom">
                       
                            <div class="left"></div>

                            <div class="right">
                            <div class="likes">
                                <img src="<?php echo(base_url());?>assets/images/like.svg" alt="like"/>
                                <p>12</p>
                            </div>
                            <div class="dislikes">
                                <img src="<?php echo(base_url());?>assets/images/dislike.svg" alt="dislike"/>
                                <p>01</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

    </div>

    <!-- question section -->
    <script>
        $(document).ready(function () {
                $.ajax({
                    url: "<?php echo (base_url()); ?>index.php/api/Question/allQuestions",
                    method: "GET",
                    dataType: "json"
                }).done(function (response) {
                    $.each(response.result, function(key, value) {
                            $('.questions').append('<div class="questionContainer"><div class="questionContainer__left"><div class="questionContainer__left__top"><a href="<?php echo(base_url());?>index.php/Question"><p>'+value.questionTitle+'</p></a></div><div class="questionContainer__left__bottom"><div class="left"></div><div class="right"><div class="likes"><img src="<?php echo(base_url());?>assets/images/like.svg" alt="like"/><p>12</p></div><div class="dislikes"><img src="<?php echo(base_url());?>assets/images/dislike.svg" alt="dislike"/><p>01</p></div></div></div></div></div>'); 
                        });
                    })
                })
   </script>

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

    <script>
        // Get the logout button
        var postQuesBtn = document.getElementById("post-question-btn");

        var isLoggedIn = Backbone.View.extend({
        el: "#post-question-btn",
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
                        window.location.href = "<?php echo (base_url()); ?>index.php/CreateQuestion"
                    } else {
                        alert("User need to log in to Post a Question!!")
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

</body>
</html>