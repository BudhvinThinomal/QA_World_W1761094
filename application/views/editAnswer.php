<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Edit Answer</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/editAnswer.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        $searchParams = new URLSearchParams(window.location.search);
        
        //Post answer model and view
        var PostModel = Backbone.Model.extend({
        defaults: {
            answerDescription: "",
            answerID: ""
        },
        validate: function(attributes) {
            if (!attributes.answerDescription) {
                return "Answer is required!!";
            }
        }
        });

        var PostView = Backbone.View.extend({
            el: "#post-ans-form",
            events: {
                "submit": "submitForm"
            },
            initialize: function() {
                this.model = new PostModel();
                this.render();
            },
            render: function() {
                var template = _.template($("#post-ans-template").html());
                this.$el.html(template(this.model.toJSON()));
            },
            submitForm: function(e) {
                e.preventDefault();

                var answerDescription = this.$("#answerDescription").val();
                var answerID = $searchParams.get('answerID');

                this.model.set({answerDescription: answerDescription, answerID: answerID});

                if (this.model.isValid()) {  
                    // Login validation
                    $.ajax({
                        url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                        type: "GET",
                        success: function(response) {
                            
                            if (response == true) {
                                // Submit the form to the server
                                $.ajax({
                                url: "<?php echo (base_url()); ?>index.php/api/Answer/updateAnswers",
                                type: "POST",
                                data: {
                                    answerDescription: answerDescription,
                                    answerID: answerID
                                },
                                success: function(res) {
                                    // Handle the response from the server
                                    if (res["isValid"] == true) {
                                        window.location.href = "<?php echo (base_url()); ?>index.php/Question?questionID="+$searchParams.get('questionID');
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
                                showToast("User need to Log In to Post a Answer!!");
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
            var postView = new PostView();
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
                    <h2>Edit your Answer</h2>
                </div>
            </div>
        </div>

        <form id="post-ans-form">
            <div id="post-ans-template">
                <div class="container__section createAnsSection">
                    <div class="createAnsSection__container section" >

                        <textarea rows="20" maxlength="500" style="resize:none;" id="answerDescription" required></textarea>

                        <div class="postBtn">
                            <input type="submit" id='postAnsBtn' value="Edit Answer"/>
                        </div>
                    </div>
                            
                </div>
            </div>
        </form> 
    </div>

    <!-- Load answer details -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/Answer/getAnswer?answerID="+$searchParams.get('answerID'),
                type: "GET",
                success: function(response) {

                    if (response['isValid'] == true) {
                        $("#answerDescription").val(response['result'][0]['answerDescription']);
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