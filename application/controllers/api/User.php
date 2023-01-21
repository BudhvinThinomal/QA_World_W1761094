<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class User extends \Restserver\Libraries\REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    //index function
    public function index_get() {
        header("Location: " . base_url() . "index.php/");
        exit();
    }

    //Validation about user availability
    function checkUserDataAvailability_get()
    {
        $username = $this->input->get('username');

        if ($username) {
            $modelResponse = $this->user_model->check_availability($username);

            $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else{
            $response["message"] = "Username not entered!!";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Function for check and authenticates user by username and password to login
    function login_post()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username and $password) {
            $modelResponse = $this->user_model->authenticate_user($username, $password);

            $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else{
            $response = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Function for check and register user by username, fullname and password
    function signin_post()
    {
        $fullName = $this->input->post('fullName');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($fullName and $username and $password) {
            $modelResponse = $this->user_model->create_user($fullName, $username, $password);

            $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else{
            $response["message"] = "User Creation Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
