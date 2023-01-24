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

    //Function for return all the answers from database
    function allAnswers_get() {
        $questionID = $this->input->get('questionID');

        if ($questionID) {
            $response = $this->answer_model->all_answers($questionID);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $response["message"] = "Answers does not Exist!!";
            $response["isValid"] = false;
            $response["result"] = [];

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for create new answer
    function createAnswers_post() {

        $answerDescription = $this->input->post('answerDescription');
        $questionID  = $this->input->post('questionID');
        $username = $this->user_model->get_username();
        
        if ($answerDescription and $questionID and $username) {
            $response = $this->answer_model->create_answer($answerDescription, $questionID, $username);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Answer Creation Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for update existing answer
    function updateAnswers_post() {
        $answerDescription = $this->input->post('answerDescription');
        $answerID  = $this->input->post('answerID');
        $username = $this->user_model->get_username();

        if ($answerDescription and $answerID and $username) {
            $response = $this->answer_model->update_answer($answerDescription, $answerID, $username);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Answer Updating Process Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for update votes for each answer
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
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for remove answer
    function removeAnswer_post() {
        $answerID = $this->input->post('answerID');

        if ($answerID) {
        $response = $this->answer_model->remove_answer($answerID);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
}