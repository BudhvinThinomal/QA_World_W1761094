<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" href="<?php echo (base_url()); ?>assets/images/LogoScratch.png" type="image/png">
    <title>QA WORLD - Edit Question</title>

    <!-- File specific styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/editQuestion.css">
    <!-- Navbar styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo (base_url()); ?>assets/css/navbar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        $searchParams = new URLSearchParams(window.location.search);

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
                                url: "<?php echo (base_url()); ?>index.php/api/Question/updateQuestion",
                                type: "POST",
                                data: {
                                    questionID: $searchParams.get('questionID'),
                                    questionTitle: questionTitle, 
                                    questionDescription: questionDescription
                                },
                                success: function(res) {
                                    // Handle the response from the server
                                    if (res["isValid"] == true) {
                                        window.location.href = "<?php echo(base_url());?>index.php/Question?questionID="+$searchParams.get('questionID');
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
                                showToast("User need to Log In to Post a Question!!");
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

        <form id="post-ques-form">
            <div id="post-ques-template">
                
                <div class="container__section createQuesSection">
                    
                    <div class="createQuesSection__container section" >
                        <h2>Edit the Question Title</h2>
                        <input type="text" id="questionTitle" name="questionTitle" placeholder="Type Title in here" required/>

                        <h2>Edit Problem Describe</h2>
                        <textarea rows="20" id="questionDescription" name="questionDescription" maxlength="200" style="resize:none;" required></textarea>

                        <!-- Submit button section -->
                        <div class="postBtn">
                            <input type="submit" id='postQuesBtn' value="Edit Question"/>
                        </div>
                    </div>
                            
                </div>

            </div>
        </form> 
    </div>

    <!-- Load question details -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/Question/question?questionID="+$searchParams.get('questionID'),
                type: "GET",
                success: function(response) {

                    if (response['isValid'] == true) {
                        $("#questionTitle").val(response['result'][0]['questionTitle']);
                        $("#questionDescription").val(response['result'][0]['questionDescription']);
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