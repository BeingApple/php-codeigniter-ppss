<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_model extends CI_Model{
    public $SEQ;
    public $TEST;

    function __construct(){
        parent::__construct();
        
        $this->load->database();
	}

    public function get_last_one(){
        $query = $this->db->get('TBL_TEST', 1);
        return $query->result();
    }
}
?>