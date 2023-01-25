<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Answer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('question_model');
        date_default_timezone_set("Asia/Colombo");
    }

    //Function for return one perticular answer
    function get_answer($answerID)
    {
        $this->db->where('answerID', $answerID);
        $result = $this->db->get('answer_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Answer Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        } else {
            $response["message"] = "Answer does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        }
    }

    //Function for return all the answers from database
    function all_answers($questionID)
    {
        $this->db->where('questionID', $questionID);
        $result = $this->db->get('answer_details');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Answers Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        } else {
            $response["message"] = "Answers does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        }
    }

    //Function for create new answer
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
            $response["message"] = "Answer Created Successfully!!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Answer Creation Unsuccessful!!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    //Function for update existing answer
    function update_answer($answerDescription, $answerID)
    {
        $timeSatmp = date("Y-m-d h:i:s");

        $updatedData = array(
            'answerDescription' => $answerDescription,
            'lastModified' => $timeSatmp
        );

        $this->db->where('answerID', $answerID);
        $result = $this->db->update('answer_details', $updatedData);

        if ($result) {
            $response["message"] = "Answer Updated Successfully!!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Answer Updating Process Unsuccessful!!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    //Function for return number of votes for each answer
    function get_votes($questionID)
    {
        $this->db->where('questionID', $questionID);
        $result = $this->db->get('answer_votes');

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Votes Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        } else {
            $response["message"] = "Votes does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        }
    }

    //Function for update votes for each answer
    function update_answer_votes($answerID, $questionID, $username, $like , $dislike)
    {
        $this->db->where('answerID', $answerID);
        $this->db->where('username', $username);
        $checkVoted = $this->db->get('answer_votes');


        $resultArray = array();

        foreach ($checkVoted->result() as $row) {
            $resultArray[] = $row;
        }

        $isVoted = !empty($resultArray);


        if ($isVoted) {
            if ($like == 0 and $dislike == 0) {
                $this->db->where('answerID', $answerID);
                $this->db->where('username', $username);
                $deleted = $this->db->delete('answer_votes');

                if ($deleted) {
                    $response["message"] = "Vote Removed Successfully!!";
                    $response["isValid"] = $deleted;
        
                    return $response;
                } else {
                    $response["message"] = "Vote Removed Unsuccessful!!";
                    $response["isValid"] = $deleted;
        
                    return $response;
                }
            }

            $updatedData = array(
                'like' => $like,
                'dislike' => $dislike
            );
    
            $this->db->where('answerID', $answerID);
            $this->db->where('username', $username);
            $updated = $this->db->update('answer_votes', $updatedData);

            if ($updated) {
                $response["message"] = "Vote Updated Successfully!!";
                $response["isValid"] = $updated;
    
                return $response;
            } else {
                $response["message"] = "Vote Updated Unsuccessful!!";
                $response["isValid"] = $updated;
    
                return $response;
            }
        } else {
            $created = $this->db->insert('answer_votes', array(
                'answerID' => $answerID,
                'questionID' => $questionID,
                'username' => $username,
                'like' => $like,
                'dislike' => $dislike
            ));
    
            if ($created) {
                $response["message"] = "Voted Successfully!!";
                $response["isValid"] = $created;
    
                return $response;
            } else {
                $response["message"] = "Vote Unsuccessful!!";
                $response["isValid"] = $created;
    
                return $response;
            }
        }
    }

    //Function for remove existing answer
    function remove_answer($answerID){
        $result = $this->db->delete('answer_details', array('answerID' => $answerID));

        return $result;   
    }
}
