<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    //Function for check and authenticates user by username and password to login
    function authenticate_user($username, $password)
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

        // if($availableUser.isValid) {
            
        //     if (password_verify($password, $responseArray['password'])) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
    }

    //Function for check and register user by username, fullname and password
    function create_user($username, $fullName, $password)
    {
        $this->db->where('username', $username);
        $verification = $this->db->get('user_details');

        $responseArray = $verification->row_array();

        if(!empty($responseArray)) {
            $response["message"] = "Username already exists!";
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
