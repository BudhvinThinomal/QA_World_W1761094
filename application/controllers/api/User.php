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

    //Validation about user availability
    function checkAvailability_get()
    {
        $username = $this->input->get('username');

        $response = $this->user_model->check_availability($username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    //Function for check and authenticates user by username and password to login
    function login_post()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $modelResponse = $this->user_model->authenticate_user($username, $password);

        $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    //Function for check and register user by username, fullname and password
    function signin_post()
    {
        $fullName = $this->input->post('fullName');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $modelResponse = $this->user_model->create_user($fullName, $username, $password);

        $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }
}
