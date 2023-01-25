<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - User Details</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/userDetails.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        //Post fullname model and view
        var PostNameModel = Backbone.Model.extend({
        defaults: {
            fullName: ""
        },
        validate: function(attributes) {
            if (!attributes.fullName) {
                return "Full Name is required!!";
            }
        }
        });

        var PostNameView = Backbone.View.extend({
            el: "#post-name-form",
            events: {
                "submit": "submitForm"
            },
            initialize: function() {
                this.model = new PostNameModel();
                this.render();
            },
            render: function() {
                var template = _.template($("#post-name-template").html());
                this.$el.html(template(this.model.toJSON()));
            },
            submitForm: function(e) {
                e.preventDefault();

                var fullName = this.$("#fullName").val();

                this.model.set({fullName: fullName});

                if (this.model.isValid()) {  
                    // Login validation
                    $.ajax({
                        url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                        type: "GET",
                        success: function(response) {
                            
                            if (response == true) {
                                // Submit the form to the server
                                $.ajax({
                                url: "<?php echo (base_url()); ?>index.php/api/User/updateUserFullname",
                                type: "POST",
                                data: {
                                    fullName: fullName
                                },
                                success: function(res) {
                                    // Handle the response from the server
                                    if (res["isValid"] == true) {
                                        window.location.href = "<?php echo(base_url());?>index.php/UserDetails";
                                    } else {
                                        showToast(res["message"]);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Handle any errors that occur during the request
                                    console.log(error);
                                }
                                });
                            } else {
                                showToast("User need to Log In to Edit User Details!!");
                            } 
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            // Handle any errors that occur during the request
                        }
                    });
                    
                } else {
                    showToast(this.model.validationError);
                }
            }
        });

        $(document).ready(function() {
            var postNameView = new PostNameView();
        });
    </script>

    <script>
        //Post password model and view
        var PostPasswordModel = Backbone.Model.extend({
        defaults: {
            password: "",
            prePassword: "",
            confirm_password: ""
        },
        validate: function(attributes) {
            if (!attributes.prePassword) {
                return "Previous Password is required!!";
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
        }
        });

        var PostPasswordView = Backbone.View.extend({
            el: "#post-password-form",
            events: {
                "submit": "submitForm"
            },
            initialize: function() {
                this.model = new PostPasswordModel();
                this.render();
            },
            render: function() {
                var template = _.template($("#post-password-template").html());
                this.$el.html(template(this.model.toJSON()));
            },
            submitForm: function(e) {
                e.preventDefault();

                var password = this.$("#password").val();
                var prePassword = this.$("#prePassword").val();
                var confirm_password = this.$("#confirm_password").val();

                this.model.set({
                    password: password, 
                    prePassword: prePassword,
                    confirm_password: confirm_password
                });

                if (this.model.isValid()) {  
                    // Login validation
                    $.ajax({
                        url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                        type: "GET",
                        success: function(response) {
                            
                            if (response == true) {
                                // Submit the form to the server
                                $.ajax({
                                url: "<?php echo (base_url()); ?>index.php/api/User/updateUserPassword",
                                type: "POST",
                                data: {
                                    password: password,
                                    prePassword: prePassword
                                },
                                success: function(res) {
                                    // Handle the response from the server
                                    if (res["isValid"] == true) {
                                        window.location.href = "<?php echo(base_url());?>index.php/UserDetails";
                                    } else {
                                        showToast(res["message"]);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Handle any errors that occur during the request
                                    console.log(error);
                                }
                                });
                            } else {
                                showToast("User need to Log In to Edit User Details!!");
                            } 
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            // Handle any errors that occur during the request
                        }
                    });
                    
                } else {
                    showToast(this.model.validationError);
                }
            }
        });

        $(document).ready(function() {
            var postPasswordView = new PostPasswordView();
        });
    </script>

</head>

<body>
    <div class="container">
        
        <?php
            include 'commonNavBar.php';
        ?>
        
        <div class="container__section headings">
            <div class="headingContainer">
                <div class="headings__text">
                    <h2>User Details</h2>
                </div>
            </div>
        </div>

        <div class="container__section headings">
            <div class="bodyContainer">
                <h3 id="user-name">Username : </h3>
                <h3 id="full-name">Full Name : </h3>
            </div>
        </div>

        <form id="post-name-form">
            <div id="post-name-template">
                <div class="container__section createAnsSection">
                    <div class="createAnsSection__container section" >
                        <h2>Change your Full Name</h2>
                        <input type="text" id="fullName" placeholder="Enter your Full Name" required/>

                        <div class="postBtn">
                            <input type="submit" id='postFullNameBtn' value="Edit"/>
                        </div>
                    </div>
                            
                </div>
            </div>
        </form> 

        <form id="post-password-form">
            <div id="post-password-template">
                <div class="container__section createAnsSection">
                    <div class="createAnsSection__container section" >
                        <h2>Change your Password</h2>
                        <input type="password" id="prePassword" placeholder="Enter your Previous Passowrd" required/>

                        <input type="password" id="password" placeholder="Enter your New Passowrd" required/>

                        <input type="password" id="confirm_password" placeholder="Confirm your New Passowrd" required/>

                        <div class="postBtn">
                            <input type="submit" id='postPasswordBtn' value="Edit"/>
                        </div>
                    </div>
                            
                </div>
            </div>
        </form> 
    </div>

    <!-- Load user details -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/User/checkUserDataAvailability",
                type: "GET",
                success: function(response) {

                    if (response['isValid'] == true) {
                        $("#user-name").append(response['result'][0]['username']);
                        $("#full-name").append(response['result'][0]['fullName']);
                    } else {
                        showToast(response['message']);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    // Handle any errors that occur during the request
                }
            });
        });
    </script>

    <?php
        include 'commonNavBarOpt.php';
    ?>

    <?php
        include 'commonToastMsg.php';
    ?>

</body>
</html>