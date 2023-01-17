<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Create Q.</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/createQuestion.css">
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
            
            <div class="container__section crtQuestionSlider">
                
                    <div class="crtQuestion__container sec01" >
                        <h2>Enter the Question Title</h2>
                        <input type="text" placeholder="Type in here" />

                        <h2>Describe your Problem</h2>
                        <textarea rows="10" maxlength="200" style="resize:none;"></textarea>

                        <h2>Tags</h2>
                        <input type="text" placeholder="Type in here" />

                        <div class="help">
                            <p>
                               <b>Add a comma after each tag</b>.&nbsp;(Maximum &nbsp;<b>5 tags</b>&nbsp;)
                            </p>
                        </div>

                        <div class="btnSec">
                            <a href="#">Post</a>
                        </div>
                    </div>
                    
            </div>
    </div>

</body>
</html>