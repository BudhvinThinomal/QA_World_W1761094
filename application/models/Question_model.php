<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Question_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        date_default_timezone_set("Asia/Colombo");
    }

    function all_questions()
    {
        $result = $this->db->query("SELECT * FROM `question_details`;");

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Questions Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        } else {
            $response["message"] = "Questions does not Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        }
    }

    function question($questionID)
    {
        $this->db->where('questionID', $questionID);
        $result = $this->db->get('question_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Question Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        } else {
            $response["message"] = "Question does not Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        }
    }

    function create_question($questionTitle, $questionDescription, $tags, $username, $isLoggedIn)
    {
        $timeSatmp = date("Y-m-d h:i:s");

        $createdTime = $timeSatmp;
        $lastModified = $timeSatmp;            

        $result = $this->db->insert('question_details', array(
            'questionTitle' => $questionTitle,
            'questionDescription' => $questionDescription,
            'createdTime' => $createdTime,
            'lastModified' => $lastModified,
            'likes' => 0,
            'dislikes' => 0,
            'username' => $username,
            'views' => 0,
            'tags' => $tags
        ));

        if ($result) {
            $response["message"] = "Question Created Successfully!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Question Creation Unsuccessful!";
            $response["isValid"] = $result;

            return $response;
        }
    }


    function update_question($questionID, $questionTitle, $questionDescription, $tags, $username, $isLoggedIn)
    {
        $timeSatmp = date("Y-m-d h:i:s");

        $updatedData = array(
            'questionTitle' => $questionTitle,
            'questionDescription' => $questionDescription,
            'tags' => $tags,
            'lastModified' => $timeSatmp
        );

        $this->db->where('questionID', $questionID);
        $result = $this->db->update('question_details', $updatedData);

        if ($result) {
            $response["message"] = "Question Updated Successfully!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Question Updating Process Unsuccessful!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    function remove_question($questionID, $username, $isLoggedIn)
    {
        $result = $this->db->delete('question_details', array('questionID' => $questionID));

        return $result;       
    }
}
