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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>
</head>

<body>
    <div class="container">

        <?php
            include 'commonNavBar.php';
        ?>

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
            <div class="postQuestion">
                <button id="post-question-btn">Post a Question</button>
            </div>
        </div>
       
       <!-- question section -->
       <div class="container__section questions" id="question-element"></div>
    </div>

    
    <script type="text/template" id="question-template">
        <% _.each(data, function(item) { %>
            <div class="questionContainer">
                <div class="questionContainer__inner">
                    <div class="questionContainer__inner__top">
                        <a href="<?php echo(base_url());?>index.php/Question?questionID=<%= item?.questionID %>"><%= item?.questionTitle %></a>
                        <h2>Description: <%= item?.questionDescription %></h2>
                        
                    </div>
                    <div class="questionContainer__inner__bottom">
                       
                        <div class="left">
                            <p>Created by: <%= item?.username %></p>
                        </div>

                        <div class="right">
                            <button class="likes">
                                <img src="<?php echo(base_url());?>assets/images/like.svg" alt="like"/>
                                <p><%= item?.likes %></p>
                            </button>
                            <button class="dislikes">
                                <img src="<?php echo(base_url());?>assets/images/dislike.svg" alt="dislike"/>
                                <p><%= item?.dislikes %></p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <% }); %>
    </script>

    <!-- Backbone model for display all questions -->
    <script>
        var QuestionModel = Backbone.Model.extend({
            url: "<?php echo (base_url()); ?>index.php/api/Question/allQuestions",
            parse: function(response) {
                return response;
            }
        });

        var QuestionView = Backbone.View.extend({
        el: '#question-element',
        template: _.template($('#question-template').html()),
        initialize: function() {
            this.model = new QuestionModel();
            this.model.fetch();
            this.listenTo(this.model, 'sync', this.render);
        },
        render: function() {
            var data = this.model.toJSON();
            this.$el.html(this.template({data: data?.result}));
        }
        });

        var questionView = new QuestionView();
    </script>

    <!-- Login validation -->
    <script>
        var isLoggedIn = Backbone.View.extend({
        el: "#post-question-btn",
        events: {
            "click": "getData"
        },
        getData: function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo (base_url()); ?>index.php/api/User/isLoggedIn",
                type: "GET",
                success: function(response) {
                    
                    if (response == true) {
                        window.location.href = "<?php echo (base_url()); ?>index.php/CreateQuestion"
                    } else {
                        showToast("User need to Log In to Post a Question!!")
                    } 
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    // Handle any errors that occur during the request
                }
            });
        }
        });

        var logoutView = new isLoggedIn();
    </script>

    <?php
        include 'commonNavBarOpt.php';
    ?>

    <?php
        include 'commonToastMsg.php';
    ?>

</body>
</html>