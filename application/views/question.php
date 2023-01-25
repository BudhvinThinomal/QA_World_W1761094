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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>

    <script>
        var global = {getUserName: ""};
        $searchParams = new URLSearchParams(window.location.search);
        
        //Post answer model and view
        var PostModel = Backbone.Model.extend({
        defaults: {
            answerDescription: "",
            questionID: ""
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
                var questionID = $searchParams.get('questionID');

                this.model.set({answerDescription: answerDescription, questionID: questionID});

                if (this.model.isValid()) {  
                    // Login validation
                    $.ajax({
                        url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                        type: "GET",
                        success: function(response) {
                            
                            if (response == true) {
                                // Submit the form to the server
                                $.ajax({
                                url: "<?php echo (base_url()); ?>index.php/api/Answer/createAnswers",
                                type: "POST",
                                data: {
                                    answerDescription: answerDescription,
                                    questionID: questionID
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
        
        <div class="container__section questionNanswers">
            <div class="questionContainer">
                <!-- question section -->
                <div class="questionContainer__top" id="question-element"></div>
                <div class="questionContainer__inner__bottom"></div>
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
            <div class="answerContainer" id="answer-element"></div>  
        </div>

        <form id="post-ans-form">
            <div id="post-ans-template">
                <div class="container__section createAnsSection">
                    <div class="createAnsSection__container section" >

                        <h2>Your Answer</h2>
                        <textarea rows="20" maxlength="500" style="resize:none;" id="answerDescription" required></textarea>

                        <div class="postBtn">
                            <input type="submit" id='postAnsBtn' value="Post"/>
                        </div>
                    </div>
                            
                </div>
            </div>
        </form> 
    </div>

    <!-- Check user log in and username for enabled disabled Edit and Delete-->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                type: "GET",
                success: function(response) {
                
                    if (response == true) {
                        $.ajax({
                            url: "<?php echo (base_url()); ?>index.php/api/User/getUserName",
                            type: "GET",
                            success: function(res) {
                                global.getUserName = res;
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                                // Handle any errors that occur during the request
                            }
                        });
                    } else {
                        $('.container__inner__bottom').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    // Handle any errors that occur during the request
                }
            });
        });
    </script>

    <!-- Display question template -->
    <script type="text/template" id="question-template">
        <% _.each(data, function(item) { %>
            <h2><%= item?.questionTitle %></h2>
            <h3>Description: <%= item?.questionDescription %></h3>  
            <p>Created by: <%= item?.username %></p>   

            <div class="container__inner__bottom" <% if (item?.username !== global.getUserName) { %> style="display: none" <% } %>>  
                <div class="left"></div>
                <div class="rightQuestion">
                    <button onClick="$(location).attr('href', '<?php echo(base_url());?>index.php/EditQuestion?questionID=' + <%= item?.questionID %> )">
                        Edit
                    </button>
                    <button onClick="deleteQuestion(<%= item?.questionID %>)">
                        Delete
                    </button>
                </div>
            </div>
        <% }); %>
    </script>

    <!-- Backbone model for display a question -->
    <script>
        var QuestionModel = Backbone.Model.extend({
            url: "<?php echo (base_url()); ?>index.php/api/Question/question?questionID="+$searchParams.get('questionID'),
            parse: function(response) {
                return response;
            }
        });

        var model = new QuestionModel();

        var QuestionView = Backbone.View.extend({
            el: '#question-element',
            template: _.template($('#question-template').html()),
            initialize: function() {
                model.fetch();
                this.listenTo(model, 'sync', this.render);
                setInterval(this.fetchData, 3000);  // fetch data every 5 seconds
            },
            fetchData: function() {
                model.fetch();
            },
            render: function() {
                var data = model.toJSON();
                this.$el.html(this.template({data: data?.result}));
            }
        });

        var questionView = new QuestionView();
    </script>

    <!-- Display answers template -->
    <script type="text/template" id="answer-template">
        <% _.each(data, function(item) { %>
            <div class="answerContainer_inner" >
                <h3><%= item?.answerDescription %></h3> 
                <p <% if (!item?.username) { %> style="display: none" <% } %>>Posted by: <%= item?.username %></p>

                <div class="container__inner__bottom" <% if (item?.username !== global.getUserName) { %> style="display: none" <% } %>>   
                    <div class="left">
                        <button class="likes">
                            <img src="<?php echo(base_url());?>assets/images/like.svg" alt="like"/>
                            <p id="'likes' + <%= item?.answerID %>"><%= item?.likes %></p>
                        </button>
                        <button class="dislikes">
                            <img src="<?php echo(base_url());?>assets/images/dislike.svg" alt="dislike"/>
                            <p id="'dislikes' + <%= item?.answerID %>"><%= item?.dislikes %></p>
                        </button>
                    </div>
                    <div class="right">
                        <button onClick="$(location).attr('href', '<?php echo(base_url());?>index.php/EditAnswer?answerID=' + <%= item?.answerID %> + '&questionID=' + <%= item?.questionID %> )">
                            Edit
                        </button>
                        <button onClick="deleteAnswer(<%= item?.answerID %>)">
                            Delete
                        </button>
                    </div>
                </div>
            </div>  
        <% }); %>
    </script>

    <!-- Backbone model for display answers -->
    <script>
        var AnswerModel = Backbone.Model.extend({
            url: "<?php echo (base_url()); ?>index.php/api/Answer/allAnswers?questionID="+$searchParams.get('questionID'),
            parse: function(response) {
                return response;
            }
        });

        var ansModel = new AnswerModel();

        var AnswerView = Backbone.View.extend({
        el: '#answer-element',
        template: _.template($('#answer-template').html()),
        initialize: function() {
            ansModel.fetch();
            this.listenTo(ansModel, 'sync', this.render);
            setInterval(this.fetchData, 3000);  // fetch data every 5 seconds
        },
        fetchData: function() {
            ansModel.fetch();
        },
        render: function() {
            var data = ansModel.toJSON();
            if (data?.result?.length == 0) {
                data.result[0] = {answerDescription: "No Answers Posted Yet!!"};
            }
            this.$el.html(this.template({data: data?.result}));
        }
        });

        var answerView = new AnswerView();
    </script>

    <!-- Delete Method for delete question -->
    <script>
        function deleteQuestion(questionID) {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/Question/removeQuestion",
                type: 'POST',
                data: {
                    questionID: questionID
                },
                success: function(response) {
                    if (response == true) {
                        window.location.href = "<?php echo (base_url()); ?>index.php/Home";
                    } else {
                        showToast("Question Delete Process Unsuccessful!!");
                    }   
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the request
                    console.log(error);
                }
            });
        }
    </script>

    <!-- Delete Method for delete answer -->
    <script>
        function deleteAnswer(answerID) {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/Answer/removeAnswer",
                type: 'POST',
                data: {
                    answerID: answerID
                },
                success: function(response) {
                    if (response == true) {
                        window.location.href = "<?php echo(base_url());?>index.php/Question?questionID="+$searchParams.get('questionID');
                    } else {
                        showToast("Answer Delete Process Unsuccessful!!");
                    }   
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the request
                    console.log(error);
                }
            });
        }
    </script>

    <!-- Answer Voting System -->
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/User/getUserName",
                type: "GET",
                success: function(response) {
                   console.log(response);
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