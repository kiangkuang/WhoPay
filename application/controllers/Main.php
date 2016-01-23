<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('receipt_model');
        $this->load->model('user_model');
        $this->load->model('item_model');
        $this->load->model('user_item_model');
    }

	// new or join button
	public function index()
	{
		$this->load->view('home');
	}

	// manual create. submits name and items to createManual()
	public function create()
	{
		$this->load->view('create');
	}

	// ocr
	public function ocr()
	{
		$this->load->view('ocr');
	}

	//join
	public function join()
	{
		$this->load->view('join');
	}

	// lobby
	public function receipt($receipt_id)
	{
		$this->load->view('receipt');
	}

	// result
	public function result($receipt_id)
	{
		$this->load->view('result');
	}

	// posted user and items array
	public function createManual()
	{
		$input = $this->input->post();
		$items = $input['items'];

		$userId = $this->makeNewUser($input['name']);
		$this->session->set_userdata('userId', $userId);
	}

	// returns id of new user
	private function makeNewUser($name)
	{
		return $this->user_model->insert(['name' => $name]);
	}
}
