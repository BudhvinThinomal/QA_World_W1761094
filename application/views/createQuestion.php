<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Create Question</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/createQuestion.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        var PostModel = Backbone.Model.extend({
        defaults: {
            questionTitle: "",
            questionDescription: ""
        },
        validate: function(attributes) {
            if (!attributes.questionTitle) {
            return "Question Title is required!!";
            }
            if (!attributes.questionDescription) {
            return "Question Description is required!!";
            }
        }
        });

        var PostView = Backbone.View.extend({
            el: "#post-ques-form",
            events: {
                "submit": "submitForm"
            },
            initialize: function() {
                this.model = new PostModel();
                this.render();
            },
            render: function() {
                var template = _.template($("#post-ques-template").html());
                this.$el.html(template(this.model.toJSON()));
            },
            submitForm: function(e) {
                e.preventDefault();

                var questionTitle = this.$("#questionTitle").val();
                var questionDescription = this.$("#questionDescription").val();

                this.model.set({questionTitle: questionTitle, questionDescription: questionDescription});

                if (this.model.isValid()) { 
                    // Login validation
                    $.ajax({
                        url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                        type: "GET",
                        success: function(response) {
                            
                            if (response == true) {
                               // Submit the form to the server
                                $.ajax({
                                url: "<?php echo (base_url()); ?>index.php/api/Question/createQuestion",
                                type: "POST",
                                data: {
                                    questionTitle: questionTitle, 
                                    questionDescription: questionDescription
                                },
                                success: function(response) {
                                    // Handle the response from the server
                                    if (response["isValid"] == true) {
                                        window.location.href = "<?php echo (base_url()); ?>index.php/Home"
                                    } else {
                                        showToast(response["message"])
                                    }
                                },
                                error: function(xhr, status, error) {
                                    // Handle any errors that occur during the request
                                    console.log(error);
                                }
                                });
                            } else {
                                showToast("User need to log in to Post a Question!!")
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
    <form id="post-ques-form">
        <div id="post-ques-template">
            <div class="container">
                        
                <?php
                    include 'commonNavBar.php';
                ?>
                
                <div class="container__section createQuesSection">
                    
                    <div class="createQuesSection__container section" >
                        <h2>Enter the Question Title</h2>
                        <input type="text" id="questionTitle" name="questionTitle" placeholder="Type Title in here" required/>

                        <h2>Describe your Problem</h2>
                        <textarea rows="20" id="questionDescription" name="questionDescription" maxlength="200" style="resize:none;" required></textarea>

                        <!-- Submit button section -->
                        <div class="postBtn">
                            <input type="submit" id='postQuesBtn' value="Post a Question"/>
                        </div>
                    </div>
                            
                </div>
            </div>

        </div>
    </form> 

    <?php
        include 'commonNavBarOpt.php';
    ?>

    <?php
        include 'commonToastMsg.php';
    ?>

</body>
</html>