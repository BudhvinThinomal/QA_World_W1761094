<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Answer Question</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/question.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">
</head>

<body>
    <div class="container">
        
        <?php
            include 'commonNavBar.php';
        ?>
        
        <div class="container__section questionNanswers">
            <div class="questionContainer">
                <div class="questionContainer__top">
                    <h2>How to perform form validation for a required field in HTML ?</h2>
                </div>
            </div>
        </div>

        <div class="container__section headings">
            <div class="headingContainer">
                <div class="headings__text">
                    <h2>Answers</h2>
                </div>
            </div>
        </div>

        <div class="container__section questionNanswers">
            <div class="answerContainer">
                <div class="answerContainer__bottom">
                    <p>Required attribute: If you want to make an input mandatory to be entered by the user, you can use the required attribute. This attribute can be used with any input type such as email, URL, text, file, password, checkbox, radio, etc. This can help to make any input field mandatory.</p>
                </div>
            </div>
        </div>

        <div class="container__section createAnsSection">
            <div class="createAnsSection__container section" >

                <h2>Your Answer</h2>
                <textarea rows="20" maxlength="500" style="resize:none;"></textarea>

                <div class="postBtn">
                    <a href="#">Post</a>
                </div>
            </div>
                    
        </div>
    </div>

</body>
</html>