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

    function removeAnswer_post() {
        $isLoggedIn = (boolean)$this->input->post('isLoggedIn');

        $answerID = $this->input->post('answerID');
        $username = $this->input->post('username');
        
        $response = $this->question_model->remove_answer($answerID, $username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }
}