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

		$data['userId'] = $userId;

		$this->load->view('receipt', $data);
	}

	public function ready()
	{
		$input = $this->input->post();
		if ($input['items']){
			foreach ($input['items'] as $item) {
				$data[] = ['receipt_id'=>$this->session->receiptId, 'user_id' => $input['userId'], 'item_id' => $item];
			}
			$this->user_item_model->insertBatch($data);
		}
	}

	// result
	public function result()
	{
		$results = $this->user_item_model->get_raw_result($this->session->receiptId);

		$itemTable = $this->orderByItem($results);
		$userTable = $this->orderByUser($itemTable);

		$data['itemTable'] = $itemTable;
		$data['userTable'] = $userTable;

		$this->load->view('result', $data);
	}

	private function orderByItem($results) {
		$itemTable = array();

		$currentItemId = 0;
		$sameItemCount = 0;
		$totalItems = count($results);

		for ($i = 0; $i < $totalItems; $i++) {

			$results_row = $results[$i];

			//we have a new item
			if ($results_row->id != $currentItemId) {

				//Update all costs person needs to pay
				for ($j = 0; $j < $sameItemCount; $j++) {
					$itemTable[$currentItemId][$j + 1][2] /= $sameItemCount;
				}

				//Associate the itemId with itemName
				$currentItemId = $results_row->id;

				//Put a new entry under the new name
				$newEntry = array($results_row->name, array($results_row->userId, $results_row->userName, $results_row->cost));
				$itemTable[$currentItemId] = $newEntry;

				$sameItemCount = 0;
			} else {
				array_push($itemTable[$currentItemId], array($results_row->userId, $results_row->userName, $results_row->cost));
			}

			if ($i == $totalItems - 1) {
				$sameItemCount++;
				for ($j = 0; $j < $sameItemCount; $j++) {
					$itemTable[$currentItemId][$j + 1][2] /= $sameItemCount;
				}
			}

			$sameItemCount++;
		}

		return $itemTable;
	}

	private function orderByUser($itemTable) {
		$userTable = array();

		$totalItems = count($itemTable);

		foreach ($itemTable as $payers) {
			$totalPayers = count($payers);

			for ($j = 1; $j < $totalPayers; $j++) {
				$payer = $payers[$j];
				if (isset($userTable[$payer[0]])) {
					$userTable[$payer[0]][1] += $payer[2];
					array_push($userTable[$payer[0]], array($payers[0], $payer[2]));
				} else {
					$userTable[$payer[0]] = array($payer[1], $payer[2], array($payers[0], $payer[2]));
				}	
			}	
		}

		return $userTable;
	}	
}
