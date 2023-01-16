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
                <img src="<?php echo(base_url());?>assets/images/person-outline.svg" alt="Account"/>
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
       
        <div class="container__main">
            <!-- Section 01 Logo -->
            <!-- <div class="container__main-logo">
                <img src="<?php echo (base_url()); ?>assets/images/QAWorldMain.png" alt="QAWorld" />
            </div> -->

            <!-- Sub Section 02 Description -->
            <!-- <div class="container__sec">
                <p class="container_p">
                    Technology like art is a soaring exercise of the human imagination
                </p>
            </div> -->
            
            <!-- Sub Section 03 Start button section -->
            <!-- <div class="container__sec_two btn">
                <button>Start Journey</button>
            </div> -->
        </div>
    </div>
</body>

</html>