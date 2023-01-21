<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // $this->load->library('session');
    }

    //Validation about user availability
    function check_availability($request)
    {
        $this->db->where('username', $request);
        $result = $this->db->get('user_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "User Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        } else {
            $response["message"] = "User does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        }
    }

    //Function for check and authenticates user by username and password to login
    function authenticate_user($username, $password)
    {
        $this->db->where('username', $username);
        $result = $this->db->get('user_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }
        
        $isValid = !empty($resultArray);

        if($isValid) {
            $convertedPass = json_decode(json_encode($resultArray), true);

            if (password_verify($password, $convertedPass[0]['password'])) {
                
                // $this->session->set_userdata('username', $username);
                // $this->session->set_userdata('password', password_hash($password, PASSWORD_DEFAULT));
                // $this->session->set_userdata('logged_in', TRUE);
                // //$this->session->unset_userdata('logged_in');
                // $this->session->set_flashdata('error');
                return true;
            } else {
                // $this->session->set_flashdata('error', 'Invalid login credentials');
                return false;
            }
        } else {
            // $this->session->set_flashdata('error', 'Invalid login credentials');
            return false;
        }
    }

    //Function for check and register user by username, fullname and password
    function create_user($fullName, $username, $password)
    {
        $this->db->where('username', $username);
        $verification = $this->db->get('user_details');

        $responseArray = $verification->row_array();
        
        if(!empty($responseArray)) {
            $response["message"] = "Username already exists!!";
            $response["isValid"] = false;

            return $response;
        }

        $enpassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->db->insert('user_details', array(
            'username' => $username, 
            'fullName' => $fullName, 
            'password' => $enpassword
        ));

        if ($result) {
            $response["message"] = "User Created Successfully!!";
            $response["isValid"] = $result;

            // $this->session->set_userdata('username', $username);
            // $this->session->set_userdata('password', password_hash($password, PASSWORD_DEFAULT));
            // $this->session->set_userdata('logged_in', TRUE);
            // $this->session->set_flashdata('error');
            return $response;
        } else {
            $response["message"] = "User Creation Unsuccessful!!";
            $response["isValid"] = $result;

            return $response;
        }
    }
}
