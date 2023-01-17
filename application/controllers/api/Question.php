<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Question extends \Restserver\Libraries\REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('question_model');
        $this->load->model('user_model');
    }

    function allQuestions_get() {
        $response = $this->question_model->all_questions();

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        
    }

    function question_get() {
        $questionID = $this->input->get('questionID');

        $response = $this->question_model->question($questionID);
        
        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        
    }
    
    function createQuestion_post() {
        $questionTitle = $this->input->post('questionTitle');
        $questionDescription = $this->input->post('questionDescription');
        $tags = $this->input->post('tags');
        $username = $this->input->post('username');
        $isLoggedIn = $this->input->post('isLoggedIn');
        
        $response = $this->question_model->create_question($questionTitle, $questionDescription, $tags, $username, $isLoggedIn);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    } 

    function updateQuestion_post() {
        $questionID = $this->input->post('questionID');
        $questionTitle = $this->input->post('questionTitle');
        $questionDescription = $this->input->post('questionDescription');
        $tags = $this->input->post('tags');
        $username = $this->input->post('username');
        $isLoggedIn = $this->input->post('isLoggedIn');

        $response = $this->question_model->update_question($questionID, $questionTitle, $questionDescription, $tags, $username, $isLoggedIn);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

    function removeQuestion_post() {
        $questionID = $this->input->post('questionID');
        $username = $this->input->post('username');
        $isLoggedIn = $this->input->post('isLoggedIn');
        
        $response = $this->question_model->remove_question($questionID, $username, $isLoggedIn);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

        
    function filterQuestion_get() {
        $response = $this->question_model->get_filter();

        if ($response) {
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function updateQuetionVotes_post() {
        $requestJson['questionID'] = $this->input->post('questionID');
        $requestJson['username'] = $this->input->post('username'); // Current user username;
        $requestJson['isLoggedIn'] = (boolean)$this->input->post('isLoggedIn');
        $requestJson['voteType'] = $this->input->post('voteType');

        if ($requestJson['questionID'] and $requestJson['username'] and $requestJson['voteType']) {
            $response = $this->question_model->update_question_votes($requestJson);

            if ($response['isUpdated']) {
                $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
            } else {
                $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }

        } else {
            $response['message'] = "Error processing input";
            $response['isUpdated'] = false;
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}