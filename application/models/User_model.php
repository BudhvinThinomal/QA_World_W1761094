<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

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
            $response["message"] = "User Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        } else {
            $response["message"] = "User does not Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        }
    }

    function authenticate_user($username, $password)
    {

        $this->db->where('username', $username);
        $result = $this->db->get('user_details');

        $responseArray = $result->row_array();

        if (password_verify($password, $responseArray['password'])) {
            return true;
        } else {
            return false;
        }
    }

    function create_user($username, $fullName, $password)
    {
        $enpassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $this->db->insert('user_details', array(
            'username' => $username, 
            'fullName' => $fullName, 
            'password' => $enpassword
        ));

        if ($result) {
            $response["message"] = "User Created Successfully!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "User Creation Unsuccessful!";
            $response["isValid"] = $result;

            return $response;
        }
    }
}
