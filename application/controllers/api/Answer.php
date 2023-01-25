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

    //Function for return one particular answer from database
    function getAnswer_get() {
        $answerID = $this->input->get('answerID');

        if ($answerID) {
            $response = $this->answer_model->get_answer($answerID);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $response["message"] = "Answer does not Exist!!";
            $response["isValid"] = false;
            $response["result"] = [];

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
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

        if ($answerDescription and $answerID) {
            $response = $this->answer_model->update_answer($answerDescription, $answerID);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Answer Updating Process Unsuccessful!!";
            $response["isValid"] = false;

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

    //Function for get votes for each answer
    function getAnswerVote__get() {
        $questionID  = $this->input->get('questionID');

        if ($questionID) {
            $response = $this->answer_model->get_votes($questionID);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response['message'] = "Cannot Find Number of Votes!!";
            $response['isValid'] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
    
    //Function for update votes for each answer
    function updateAnswerVote_post() {
        $answerID  = $this->input->post('answerID');
        $questionID  = $this->input->post('questionID');
        $username = $this->user_model->get_username();
        $like  = $this->input->post('like');
        $dislike  = $this->input->post('dislike');

        if ($answerID and $questionID and $username and $like and $dislike) {
            $response = $this->answer_model->update_answer_votes($answerID, $questionID, $username, $like , $dislike);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Vote Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
}