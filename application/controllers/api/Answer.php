<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Answer extends \Restserver\Libraries\REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('answer_model');
        $this->load->model('user_model');
    }

    function allAnswers_get() {
        $questionID = $this->input->get('questionID');
        $username = $this->input->post('username');

        $response = $this->answer_model->all_answers($questionID, $username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    function createAnswers_post() {
        $isLoggedIn = $this->input->post('isLoggedIn');

        $answerDescription = $this->input->post('answerDescription');
        $questionID  = $this->input->post('questionID');
        $username = $this->input->post('username');
        
        $response = $this->answer_model->create_answer($answerDescription, $questionID, $username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

    function updateAnswers_post() {
        $isLoggedIn = (boolean)$this->input->post('isLoggedIn');

        $answerDescription = $this->input->post('answerDescription');
        $answerID  = $this->input->post('answerID');
        $username = $this->input->post('username');
        
        $response = $this->answer_model->update_answer($answerDescription, $answerID, $username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }

    function updateAnswerVote_post() {
        $requestJson['answerID'] = $this->input->post('answerID');
        $requestJson['username'] = $this->input->post('username');
        $requestJson['isLoggedIn'] = (boolean)$this->input->post('isLoggedIn');
        $requestJson['voteType'] = $this->input->post('voteType');

        if ($requestJson['answerID'] and $requestJson['username'] and $requestJson['voteType']) {
            $response = $this->answer_model->update_answer_votes($requestJson);

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

    function removeAnswer_post() {
        $isLoggedIn = (boolean)$this->input->post('isLoggedIn');

        $answerID = $this->input->post('answerID');
        $username = $this->input->post('username');
        
        $response = $this->question_model->remove_answer($answerID, $username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }
}