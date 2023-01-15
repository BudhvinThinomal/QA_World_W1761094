<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Answer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('question_model');
        date_default_timezone_set("Asia/Colombo");
    }

    function all_answers($questionID, $username)
    {
        $this->db->where('questionID', $questionID);
        $result = $this->db->get('answer_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Answers Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        } else {
            $response["message"] = "Answers does not Exist";
            $response["isValid"] = $isValid;
            $response["result"] = $resultArray;

            return $response;
        }
    }

    function create_answer($answerDescription, $questionID, $username)
    {

        $timeSatmp = date("Y-m-d h:i:s");

        $createdTime = $timeSatmp;
        $lastModified = $timeSatmp;

        $result = $this->db->insert('answer_details', array(
            'answerDescription' => $answerDescription,
            'createdTime' => $createdTime,
            'lastModified' => $lastModified,
            'likes' => 0,
            'dislikes' => 0,
            'questionID' => $questionID,
            'username' => $username
        ));

        if ($result) {
            $response["message"] = "Answer Created Successfully!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Answer Creation Unsuccessful!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    function update_answer($answerDescription, $answerID, $username)
    {
        $timeSatmp = date("Y-m-d h:i:s");

        $updatedData = array(
            'answerDescription' => $answerDescription,
            'lastModified' => $timeSatmp
        );

        $this->db->where('answerID', $answerID);
        $result = $this->db->update('answer_details', $updatedData);

        if ($result) {
            $response["message"] = "Answer Updated Successfully!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Answer Updating Process Unsuccessful!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    function remove_answer($answerID, $username)
    {
        $result = $this->db->delete('answer_details', array('answerID' => $answerID));

        return $result;       
    }
}
