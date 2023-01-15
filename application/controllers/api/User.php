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


    function checkAvailability_get()
    {
        $username = $this->input->get('username');

        $response = $this->user_model->check_availability($username);

        $this->set_response($response, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    function login_post()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $modelResponse = $this->user_model->authenticate_user($username, $password);

        $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_OK);
    }

    function signin_post()
    {
        $username = $this->input->post('username');
        $fullName = $this->input->post('fullName');
        $password = $this->input->post('password');

        $modelResponse = $this->user_model->create_user($username, $fullName, $password);

        $this->set_response($modelResponse, \Restserver\Libraries\REST_Controller::HTTP_CREATED);
    }
}
