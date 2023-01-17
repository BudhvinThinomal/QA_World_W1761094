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

        <!-- Filtering section -->
        <div class="container__section midSection">
            
            <div class="filter">
                <img src="<?php echo(base_url());?>assets/images/options-outline.svg" alt="Filter"/>
                <p>2</p>
            </div>
            <div class="question">
                <a href="<?php echo(base_url());?>index.php/Question">Post a Question</a>
            </div>
        </div>
       
       <!-- question section -->
       <div class="container__section questions">
            <div class="questionContainer">
                <div class="questionContainer__left">
                    <div class="questionContainer__left__top">
                        <a href="<?php echo(base_url());?>index.php/Home">How to perform form validation for a required field in HTML ?</a>
                    </div>
                    <div class="questionContainer__left__bottom">
                       
                            <div class="left">
                                <div class="tag">
                                    <p>#Code</p>
                                </div>
                            </div>
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
            </div>
        </div>

    </div>

</body>
</html>