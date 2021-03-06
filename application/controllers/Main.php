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
		$data = [];
		if ($this->session->error){
			$data['error'] = $this->session->error;
		}

		$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';
		$this->load->view('home', $data);
	}

	// manual create. submits name and items to createManual()
	public function create()
	{
		$data = [];
		$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';

		$this->load->view('create', $data);
	}

	// ocr
	public function ocr()
	{
			$config['upload_path']		  = './uploads/';
			$config['allowed_types']		= 'gif|jpg|png';
			$config['max_size']			 =  15000;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file'))
			{
				$this->session->set_flashdata('error', $this->upload->display_errors('', ''));
				header('Location: '.'/');
				exit;
			}
			else
			{
				$upload = $this->upload->data();
			}

			$fileName = $upload['full_path'];
			
			list($width_orig, $height_orig) = getimagesize($fileName);

			if ($width_orig > 2500 || $height_orig >2500) {
				$width = 2500;
				$height = 2500;

				$ratio_orig = $width_orig/$height_orig;

				if ($width/$height > $ratio_orig) {
					$width = $height*$ratio_orig;
				} else {
					$height = $width/$ratio_orig;
				}

				$image_p = imagecreatetruecolor($width, $height);
				$image = imagecreatefromjpeg($fileName);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				imagejpeg($image_p, $fileName, 100);
			}

			$command = "curl --form \"file=@".$fileName."\" --form \"apikey=helloworld\" --form \"language=eng\" https://api.ocr.space/Parse/Image";
			$parsedData = (array) json_decode(shell_exec($command));

			$parsedString = $parsedData['ParsedResults'][0]->ParsedText;
			$items = explode("\r\n", $parsedString);

			$displayItems = array();

			foreach($items as $item) {
				if (!$this->isInBlackList($item)) {
					array_push($displayItems, $item);
				} else {
					break;
				}
			}

			$data['displayItems'] = $displayItems;

			$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';

			$this->load->view('create', $data);
	}

	//join
	public function join()
	{
		$data = [];
		$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';

		$this->load->view('join', $data);
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
				$this->session->set_flashdata('error', 'Access code not found!');
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
			$hasServiceCharge = isset($input['serviceCharge']);
			$serviceCharge = $input['serviceChargeValue'];
			$hasTax = isset($input['tax']);
			$tax = $input['taxValue'];
			$itemArray = []; // array of item name and prices
			foreach ($items as $i => $item) {

				$itemArray[] = [
					'name' => $items[$i],
					'cost' => $this->getRealCost($hasServiceCharge, $serviceCharge, $hasTax, $tax, $itemcosts[$i]),
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

		$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';

		$this->load->view('receipt', $data);
	}

	private function getRealCost($hasServiceCharge, $serviceCharge, $hasTax, $tax, $cost) {
		if ($hasServiceCharge) {
			$charge = 1 + (int) $serviceCharge / 100.0;
			$cost *= $charge;
		}

		if ($hasTax) {
			$charge = 1 + (int) $tax / 100.0;
			$cost *= $charge;
		}

		return $cost;
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
		$this->user_model->update(['id' => $this->session->userId, 'is_ready' => 1]);
	}

	public function unready()
	{
		$this->user_model->update(['id' => $this->session->userId, 'is_ready' => 0]);
		$this->user_item_model->deleteByUserId($this->session->userId);
	}

	public function status()
	{
		$receiptSubmitted = $this->receipt_model->getById($this->session->receiptId)->submitted;
		$users = $this->user_model->getByReceiptId($this->session->receiptId);
		$count = 0;
		foreach ($users as $user) {
			if ($user->is_ready) {
				$count++;
			}
		}
		$output = json_encode(['readied' => $count, 'total' => count($users), 'submitted' => $receiptSubmitted]);
		$this->output->set_content_type('text/event-stream')->set_output("data: ".$output."\n\n");
		$this->output->set_header('Cache-Control: no-cache');
		flush();
	}

	// result
	public function result($receiptCode = null)
	{
		if ($receiptCode === null) {
			$receiptId = $this->session->receiptId;
		} else {
			$receiptId = $this->receipt_model->getByCode($receiptCode)->id;
		}
		$this->receipt_model->update(['id' => $receiptId, 'submitted' => 1]);

		$results = $this->user_item_model->get_raw_result($receiptId);

		$itemTable = $this->orderByItem($results);
		$userTable = $this->orderByUser($itemTable);

		$data['itemTable'] = $itemTable;
		$data['userTable'] = $userTable;

		$data['isMobile'] = $this->agent->is_mobile();
		$data['url'] = $_SERVER['SERVER_NAME'].'/index.php/'.uri_string();

		$data['ogImg'] = $_SERVER['SERVER_NAME'].'/assets/img/opengraph.png';

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
					$itemTable[$currentItemId][$j + 2][2] /= $sameItemCount;
				}

				//Associate the itemId with itemName
				$currentItemId = $results_row->id;

				//Put a new entry under the new name
				$newEntry = array($results_row->name, $results_row->cost, array($results_row->userId, $results_row->userName, $results_row->cost));
				$itemTable[$currentItemId] = $newEntry;

				$sameItemCount = 0;
			} else {
				array_push($itemTable[$currentItemId], array($results_row->userId, $results_row->userName, $results_row->cost));
			}

			if ($i == $totalItems - 1) {
				$sameItemCount++;
				for ($j = 0; $j < $sameItemCount; $j++) {
					$itemTable[$currentItemId][$j + 2][2] /= $sameItemCount;
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

			for ($j = 2; $j < $totalPayers; $j++) {
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

	private function isInBlackList($name) {
		$strip = trim(strtolower($name));
		return is_numeric($name) || $strip === 'total' || $strip === 'change' || $strip === 'subtotal' || $strip === 'cash' || $strip === 'tax';
	}
}
