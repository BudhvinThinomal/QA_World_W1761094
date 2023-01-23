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

    //Function for return all the questions from database
    function all_questions()
    {
        $result = $this->db->query("SELECT * FROM `question_details`;");

        $resultArray = array();

        foreach ($result->result() as $row) {
            $resultArray[] = $row;
        }

        $isValid = !empty($resultArray);

        if ($isValid) {
            $response["message"] = "Questions Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        } else {
            $response["message"] = "Questions does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        }
    }

    //Function for return one perticular question
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
            $response["message"] = "Question Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        } else {
            $response["message"] = "Question does not Exist!!";
            $response["isValid"] = $isValid;
            $response["result"] = json_decode(json_encode($resultArray), true);

            return $response;
        }
    }

    //Function for create new question
    function create_question($questionTitle, $questionDescription, $username)
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
            'username' => $username
        ));

        if ($result) {
            $response["message"] = "Question Created Successfully!!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Question Creation Unsuccessful!!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    //Function for update existing question
    function update_question($questionID, $questionTitle, $questionDescription)
    {
        $timeSatmp = date("Y-m-d h:i:s");

        $updatedData = array(
            'questionTitle' => $questionTitle,
            'questionDescription' => $questionDescription,
            'lastModified' => $timeSatmp
        );

        $this->db->where('questionID', $questionID);
        $result = $this->db->update('question_details', $updatedData);

        if ($result) {
            $response["message"] = "Question Updated Successfully!!";
            $response["isValid"] = $result;

            return $response;
        } else {
            $response["message"] = "Question Updating Process Unsuccessful!!";
            $response["isValid"] = $result;

            return $response;
        }
    }

    //Function for remove existing question
    function remove_question($questionID)
    {
        $result = $this->db->delete('question_details', array('questionID' => $questionID));

        return $result;       
    }

    //Function for return all the questions in releavant time period from database 
    function getTimed_questions($t) {
        $time = date('Y-m-d H:i:s', strtotime('-' . $t . ' hour'));

        $sql = "SELECT * FROM `question` WHERE `createdTime` > ?";
        $query = $this->db->query($sql, array($time));

        $dataObject = array();

        foreach ($query->result() as $row) {
            $dataObject[] = $row;
        }

        $response['searchTime'] = $time;
        $response['resultLength'] = $query->num_rows();
        $response['data'] = $dataObject;

        return $response;
    }


    function get_filter() {
        $response = $this->getTimed_questions(1);

        for ($i = 2; $i <= 10; $i++) {
            $response = $this->getTimed_questions($i);
        }

        return $response;
    }

    //Function for update votes for each question
    function update_question_votes($request) {
        $requestParm['username'] = $request['username'];
        $requestParm['isLoggedIn'] = $request['isLoggedIn'];

        if ($this->validate_parameters($requestParm) and $this->check_question($request['questionID'], $request['username'])) {
            // $voteData = $this->get_vote($request['voteType'], $request['questionID']);
            $sql = "SELECT * FROM `questionvote` WHERE `questionID` = ? AND `username` = ?;";
            $voteData =  $this->db->query($sql, array($request['questionID'], $request['username']));

            $dataObject = array();

            foreach ($voteData->result() as $row) {
                $dataObject[] = $row;
            }

            if ($dataObject != []) {
                // There are data
                // update votes
                if ($request['voteType'] == 'like') {
                    $updateData = array(
                        'like' => true,
                        'dislike' => false,
                        'questionID' => $dataObject[0]->questionID,
                        'username' => $dataObject[0]->username,
                        'voteID' => $dataObject[0]->voteID,
                    );

                    $sql = "UPDATE `questionvote` SET `like`= ?,`dislike`= ? WHERE questionID = ? AND username = ? AND voteID = ?";
                    $result = $this->db->query($sql , $updateData);

                    if ($result) {
                        $response['message'] = "Votes Updated Successfully!!";
                        $response['isUpdated'] = true;
                        return $response;
                    } else {
                        $error = $this->db->error();

                        $response['message'] = "Something went wrong!!";
                        $response['isUpdated'] = false;
                        $response['data'] = $error;
                        return $response;
                    }
                } else {
                    $updateData = array(
                        'like' => false,
                        'dislike' => true,
                        'questionID' => $dataObject[0]->questionID,
                        'username' => $dataObject[0]->username,
                        'voteID' => $dataObject[0]->voteID,
                    );

                    $sql = "UPDATE `questionvote` SET `like`= ?,`dislike`= ? WHERE questionID = ? AND username = ? AND voteID = ?";
                    $result = $this->db->query($sql, $updateData);

                    if ($result) {
                        $response['message'] = "Votes Updated Successfully!!";
                        $response['isUpdated'] = true;
                        return $response;
                    } else {
                        $error = $this->db->error();

                        $response['message'] = "Something went wrong!!";
                        $response['isUpdated'] = false;
                        $response['data'] = $error;
                        return $response;
                    }
                }
            } else {
                if ($request['voteType'] == 'like') {
                    $result = $this->db->insert('questionvote', array(
                        'like' => true,
                        'dislike' => false,
                        'questionID' => $request['questionID'],
                        'username' => $request['username'],
                    ));

                    if ($result) {
                        $response['message'] = "Votes Created successfully!!";
                        $response['isUpdated'] = true;
                        return $response;
                    } else {
                        $error = $this->db->error();

                        $response['message'] = "Something went wrong!!";
                        $response['isUpdated'] = false;
                        $response['data'] = $error;
                        return $response;
                    }
                } else {
                    $result = $this->db->insert('questionvote', array(
                        'like' => false,
                        'dislike' => true,
                        'questionID' => $request['questionID'],
                        'username' => $request['username'],
                    ));

                    if ($result) {
                        $response['message'] = "Votes Created successfully!!";
                        $response['isUpdated'] = true;
                        return $response;
                    } else {
                        $error = $this->db->error();

                        $response['message'] = "Something went wrong!!";
                        $response['isUpdated'] = false;
                        $response['data'] = $error;
                        return $response;
                    }
                }
            }
        } else {
            $response['message'] = "User not valid or question does not exist!!";
            $response['isUpdated'] = false;
            return $response;
        }
    }

}
