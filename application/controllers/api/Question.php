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

    //Function for return all the questions from database
    function allQuestions_get() {
        $response = $this->question_model->all_questions();

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    //Function for return one perticular question from database
    function question_get() {
        $questionID = $this->input->get('questionID');

        if ($questionID) {
            $response = $this->question_model->question($questionID);
            
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else{
            $response["message"] = "Question does not Exist!!";
            $response["isValid"] = false;
            $response["result"] = [];

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
    
    //Function for create new question
    function createQuestion_post() {
        $questionTitle = $this->input->post('questionTitle');
        $questionDescription = $this->input->post('questionDescription');
        $username = $this->user_model->get_username();
        
        if ($questionTitle and $questionDescription and $username) {
            $response = $this->question_model->create_question($questionTitle, $questionDescription, $username);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Question Creation Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    } 

    //Function for update existing question
    function updateQuestion_post() {
        $questionID = $this->input->post('questionID');
        $questionTitle = $this->input->post('questionTitle');
        $questionDescription = $this->input->post('questionDescription');

        if ($questionID and $questionTitle and $questionDescription) {

            $response = $this->question_model->update_question($questionID, $questionTitle, $questionDescription);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Question Updating Process Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for remove question
    function removeQuestion_post() {
        $questionID = $this->input->post('questionID');
        
        if ($questionID) {
            $response = $this->question_model->remove_question($questionID);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for filter existing question    
    function filterQuestion_get() {
        $response = $this->question_model->get_filter();

        if ($response) {
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else {
            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

}