<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Sign In</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/signin.css">
    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/global.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        var SigninModel = Backbone.Model.extend({
        defaults: {
            fullName: "",
            username: "",
            password: "",
            confirm_password: ""
        },
        validate: function(attributes) {
            if (!attributes.fullName) {
                return "Full name is required!!";
            }
            if (!attributes.username) {
                return "Username is required!!";
            }
            if (!attributes.password) {
                return "Password is required!!";
            }
            if (!attributes.confirm_password) {
                return "Confirm Password is required!!";
            }
            if (attributes.password != attributes.confirm_password) {
                return "Confirm Password does not match to Password. Please Re-enter!!";
            }
        },
        });

        var SigninView = Backbone.View.extend({
            el: "#sign-form",
            events: {
                "submit": "submitForm"
            },
            initialize: function() {
                this.model = new SigninModel();
                this.render();
            },
            render: function() {
                var template = _.template($("#sign-template").html());
                this.$el.html(template(this.model.toJSON()));
            },
            submitForm: function(e) {
                e.preventDefault();

                var fullName = this.$("#fullName").val();
                var username = this.$("#username").val();
                var password = this.$("#password").val();
                var confirm_password = this.$("#confirm_password").val();

                this.model.set({
                    fullName: fullName,
                    username: username, 
                    password: password,
                    confirm_password: confirm_password
                });

                if (this.model.isValid()) {  
                    // Submit the form to the server
                    $.ajax({
                    url: "<?php echo (base_url()); ?>index.php/api/User/signin",
                    type: "POST",
                    data: {
                        fullName: fullName,
                        username: username, 
                        password: password
                    },
                    success: function(response) {
                        // Handle the response from the server
                        if (response['isValid'] == true) {
                            window.location.href = "<?php echo (base_url()); ?>index.php/Home"
                        } else {
                            showToast(response['message'])
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors that occur during the request
                        console.log(error);
                    }
                    });
                } else {
                    showToast(this.model.validationError);
                }
            }
        });

        $(document).ready(function() {
            var siginView = new SigninView();
        });
    </script>
</head>

<body>
    <form id="sign-form">
        <div id="sign-template">
            <div class="container">
                <div class="container__left">
                    <!-- Section 01 Description -->
                    <p class="container__left-p">
                        Technology like art is a soaring exercise of the human imagination
                    </p>

                    <!-- Section 02 link to home page -->
                    <div class="btm a">
                        <p >Go to main page</p>
                        <a href="<?php echo (base_url()); ?>index.php/Home">Home Page</a>
                    </div>
                    
                    <!-- Section 03 link to sign up page -->
                    <div class="btm a">
                        <p >Already a member ?</p>
                        <a href="<?php echo (base_url()); ?>index.php/Login">Log In</a>
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
                            <p>Full Name</p>
                            <input type="text"  id='fullName' placeholder="Enter your Full Name" required/>
                        </div>
                    </div>

                    <!-- Section 03 input Container 01 -->
                    <div class="container__right-sec input">
                        <div>
                            <p>Username</p>
                            <input type="text" id='username'  placeholder="Enter your Username" required/>
                        </div>
                    </div>

                    <!-- Section 04 input Container 02 -->
                    <div class="container__right-sec input">
                        <div>
                            <p>Password</p>
                            <input type="password" id='password' placeholder="Enter your Password" required/>
                        </div>
                    </div>

                    <!-- Section 05 input Container 02 -->
                    <div class="container__right-sec input">
                        <div>
                            <p>Confirm Password</p>
                            <input type="password" id='confirm_password' placeholder="Enter the same password as above" required/>
                        </div>
                    </div>

                    <!-- Section 06 Submit button section -->
                    <div class="container__right-sec btn">
                        <input type="submit" id='loginBtn' value="Log In"/>
                    </div>
                </div>
            </div>
        </div>
    </form> 

    <?php
        include 'commonToastMsg.php';
    ?>

</body>
</html>