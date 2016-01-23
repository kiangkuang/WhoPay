<?php

class User_item_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_name = 'user_item';
    }

    public function get_raw_result($receipt_id) 
    {
    	$this->db->select('`item`.`id`, `item`.`name`, `item`.`cost`, `user`.`id` AS `userId`, `user`.`name` AS `userName`');
    	$this->db->from('user_item');
    	$this->db->join('user', '`user_item`.`user_id` = `user`.`id`');
    	$this->db->join('item', '`item`.`id` = `user_item`.`item_id`');
    	$this->db->where('`user_item`.`receipt_id`', $receipt_id);
    	$this->db->order_by('`item`.`id`', 'ASC');

    	$query = $this->db->get();

    	if ($query->num_rows() > 0) {
            return $query->result();
        }

        return false;
    }

}
