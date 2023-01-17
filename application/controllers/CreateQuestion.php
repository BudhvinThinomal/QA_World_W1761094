<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateQuestion extends CI_Controller {
    public function index() {
        $this->load->view('createQuestion');
    }
}