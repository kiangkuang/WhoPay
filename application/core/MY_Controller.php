<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    var $user = false;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');

        if ($this->session->userId) {
            $this->user = $this->user_model->getById($this->session->userId);
        }
    }
}
