<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {

	// new or join button
	public function index()
	{
		$this->load->view('home');
	}

	// manual create
	public function create()
	{
		$this->load->view('create');
	}

	// ocr
	public function ocr()
	{
		$this->load->view('ocr');
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
}
