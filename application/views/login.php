<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Log In</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/login.css">
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/global.css">

</head>

<body>
    <div class="container">
        <div class="container__left">
             <!-- Section 01 Description -->
            <p class="container__left-p">
                Technology like art is a soaring exercise of the human imagination
            </p>
            
            <!-- Section 02 link to sign up page -->
            <div class="btm a">
                <p >Not a member yet ?</p>
                <a href="#">Sign In</a>
            </div>
        </div>

        <div class="container__right">
            <!-- Section 01 Logo -->
            <div class="container__right-logo">
                <img src="<?php echo (base_url()); ?>assets/images/QAWorldMain.png" alt="QAWorld" />
            </div>

            <!-- Section 02 input Container 01 -->
            <div class="container__right-sec input">
                <div>
                    <p>Username</p>
                    <input type="text" placeholder="Enter your Username" />
                </div>
            </div>
            <!-- Section 03 input Container 02 -->
            <div class="container__right-sec input">
                <div>
                    <p>Password</p>
                    <input type="password" placeholder="Enter your Password" />
                </div>
            </div>

            <!-- Section 04 Checkbox and fergot password part -->
            <div class="container__right-sec">
                <div>
                    <div class="chk">
                        <div class="checboxContainer">
                            <input type="checkbox" id="rememberCheck" />
                            <label for="rememberCheck">Remember me</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 05 Submit button section -->
            <div class="container__right-sec btn">
                <button>Log In</button>
            </div>
        </div>
    </div>
</body>

</html>