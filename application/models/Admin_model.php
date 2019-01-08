<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public $ADMIN_SEQ;
    public $ADMIN_ID;
    public $ADMIN_PASSWORD;
    public $ADMIN_NAME;
    public $ADMIN_GRADE;
    public $DEL_YN;
    public $REG_DATE;
    public $LAST_LOGIN_DATE;

    function __construct(){
        parent::__construct();
        
        $this->load->database();

        $this->load->library('session');
	}

    public function login($id = NULL, $password = NULL){
        if($id != null && $password != NULL){
            $password = hash('sha256', $password);
            $query = $this->db->get_where('TBL_ADMIN', array('ADMIN_ID' => $id, 'ADMIN_PASSWORD' => $password));

            return $query->row();
        }

        return NULL;
    }

    public function logout(){
        $this->session->unset_userdata('adminData');
    }

    public function adminListCount(){
        $query = $this->db->get_where('TBL_ADMIN', array('DEL_YN' => 'N'));

        return $this->db->count_all_results();
    }

    public function adminList(){
        $query = $this->db->get_where('TBL_ADMIN', array('DEL_YN' => 'N'));

        return $query->result();
    }
}
?>