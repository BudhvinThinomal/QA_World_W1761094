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

    function get_answer($answerID)
    {
        $this->db->where('answerID', $answerID);
        $result = $this->db->get('answer');

        $response = array();

        foreach ($result->result() as $row) {
            $response[] = $row;
        }

        if (empty($response)) {
            return false;
        }

        return $response;
    }

    function get_vote($voteType, $answerID)
    {
        if ($voteType == "like") {
            $sql = "SELECT upVotes FROM `answer` WHERE `answerID` = ?";
        }
        if ($voteType == "dislike") {
            $sql = "SELECT downVotes FROM `answer` WHERE `answerID` = ?";
        }

        $query = $this->db->query($sql, array($answerID));

        $dataObject = array();

        foreach ($query->result() as $row) {
            $dataObject[] = $row;
        }

        return $dataObject[0];
    }

    function update_answer_votes($request)
    {
        $requestParm['username'] = $request['username'];
        $requestParm['isLoggedIn'] = $request['isLoggedIn'];

        $answerData = $this->get_answer($request['answerID']);

        if ($this->question_model->validate_parameters($requestParm) and $answerData and $answerData[0]->username == $request['username']) {
            $answerData = $this->get_vote($request['voteType'], $request['answerID']);

            if ($request['voteType'] == 'like') {
                $voteCount = $answerData->upVotes;
                $updatingData = array(
                        'upVotes' => (int)$voteCount + 1
                );

                $this->db->where('answerID', $request['answerID']);
                $result = $this->db->update('answer', $updatingData);
            } else {
                $voteCount = $answerData->downVotes;
                $updatingData = array(
                        'downVotes' => (int)$voteCount + 1
                );

                $this->db->where('answerID', $request['answerID']);
                $result = $this->db->update('answer', $updatingData);
            }

            if ($result) {
                $response['message'] = "Votes updated successfully.";
                $response['isUpdated'] = true;
                return $response;
            } else {
                $error = $this->db->error();

                $response['message'] = "Something went wrong.";
                $response['isUpdated'] = false;
                $response['data'] = $error;
                return $response;
            }
        } else {
            $possErr['possible_error_01'] = "User not logged in.";
            $possErr['possible_error_02'] = "answer id not valid.";
            $possErr['possible_error_03'] = "Illegal attempt to update answer";
            $response['message'] = $possErr;
            $response['isUpdated'] = false;
            return $response;
        }
    }

    function remove_answer($request)
    {
        $requestParm['username'] = $request['username'];
        $requestParm['isLoggedIn'] = $request['isLoggedIn'];

        if ($this->question_model->validate_parameters($requestParm)) {
            if ($request['deleteType'] == "single" and $this->get_answer($request['answerID'])) {

                $result = $this->db->delete('answer', array('answerID' => $request['answerID']));

                if ($result) {
                    $response['message'] = "Answer deleted successfully.";
                    $response['isDeleted'] = true;
                    return $response;
                } else {
                    $error = $this->db->error();

                    $response['message'] = "Something went wrong.";
                    $response['isDeleted'] = false;
                    $response['data'] = $error;
                    return $response;
                }
            } else if ($request['deleteType'] == "multi" and $this->question_model->check_question($request['questionID'])) { // Need rechecking
                $result = $this->db->delete('answer', array('questionID' => $request['questionID']));

                if ($result) {
                    $response['message'] = "All answers deleted successfully.";
                    $response['isDeleted'] = true;
                    return $response;
                } else {
                    $error = $this->db->error();

                    $response['message'] = "Something went wrong.";
                    $response['isDeleted'] = false;
                    $response['data'] = $error;
                    return $response;
                }
            } else {
                $response['message'] = "Request is not valid. Please check and try again.";
                $response['isDeleted'] = true;
                return $response;
            }
        } else {
            $response['message'] = "User not valid.";
            $response['isDeleted'] = false;
            return $response;
        }
    }
}
