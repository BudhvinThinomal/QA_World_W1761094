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
        $username = $this->user_model->get_username();

        if ($username) {
            $modelResponse = $this->user_model->check_availability($username);

            $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else{
            $response["message"] = "User does not Exist!!";
            $response["isValid"] = false;
            $response["result"] = [];

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for check login
    function isLoggedIn_get()
    {
        $response = $this->user_model->is_loggedin();

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        
    }

    //Function for return username
    function getUserName_get()
    {
        $response = $this->user_model->get_username();

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        
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

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for logout
    function logout_get()
    {
        if ($this->user_model->get_username()) {
            $modelResponse = $this->user_model->logout_user($this->user_model->get_username());

            $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
        } else{
            $response = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
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

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for update user full name
    function updateUserFullname_post() {
        $fullName = $this->input->post('fullName');
        $username = $this->user_model->get_username();

        if ($fullName and $username) {

            $response = $this->user_model->update_fullName($fullName, $username);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Full Name Updating Process Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }

    //Function for update user password
    function updateUserPassword_post() {
        $password = $this->input->post('password');
        $prePassword = $this->input->post('prePassword');
        $username = $this->user_model->get_username();

        if ($password and $prePassword and $username) {

            $response = $this->user_model->update_password($password, $prePassword, $username);

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
        } else {
            $response["message"] = "Password Updating Process Unsuccessful!!";
            $response["isValid"] = false;

            $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
        }
    }
}
