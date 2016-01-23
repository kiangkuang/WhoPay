<?php

class Receipt_model extends MY_Model {

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_name = 'receipt';
    }
    
    public function getByCode($code)
    {
        $this->db->where('code', $code);

        $query = $this->db->get($this->db_name);

        if ($query->num_rows() > 0) {
            return $query->first_row();
        }

        return false;
    }
}
