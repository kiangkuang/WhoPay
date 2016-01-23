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
	public function receipt()
	{
		$input = $this->input->post();
		if (!$input) {
			header('Location: '.'/');
			exit;
		}

		if (isset($input['receiptCode'])) {
			// join receipt
			$receiptCode = $this->input->post('receiptCode');
			$receipt = $this->receipt_model->getByCode($receiptCode);
			if ($receipt !== false) {
				$receiptId = $receipt->id;
			} else {
				header('Location: '.'/');
				exit;
			}
		} else {
			// create receipt
			$receiptCode = substr(uniqid(), -6);
			$receiptId = $this->receipt_model->insert(['code' => $receiptCode]);
		}
		$this->session->set_userdata('receiptId', $receiptId);
		
		// generate user session
		$name = $input['name']; // user name
		$userId = $this->user_model->insert(['name' => $name, 'receipt_id' => $receiptId]);
		$this->session->set_userdata('userId', $userId);

		if (!isset($input['receiptCode'])) {	
			// generate items
			$items = $input['items']; // array of item names
			$itemcosts = $input['itemcosts']; // array of item prices
			$itemArray = []; // array of item name and prices
			foreach ($items as $i => $item) {
				$itemArray[] = [
					'name' => $items[$i],
					'cost' => $itemcosts[$i],
					'receipt_id' => $receiptId,
				];
			}
			$this->item_model->insertBatch($itemArray);
		}

		$receipt = $this->receipt_model->getById($receiptId);
		$data['receiptCode'] = $receipt->code;
		
		$items = $this->item_model->getByReceiptId($receipt->id);
		$data['items'] = $items;

		$this->load->view('receipt', $data);
	}

	// result
	public function result($receipt_id)
	{
		$this->load->view('result');
	}
}
