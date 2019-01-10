<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{
    public $ADMIN_SEQ;
    public $ADMIN_ID;
    public $ADMIN_PASSWORD;
    public $ADMIN_NAME;
    public $ADMIN_GRADE;
    public $ADMIN_FILE_NAME;
    public $ADMIN_FILE_ORG;
    public $USE_YN;
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
            $query = $this->db->get_where('TBL_ADMIN', array('ADMIN_ID' => $id, 'ADMIN_PASSWORD' => $password, 'USE_YN' => 'Y'));

            return $query->row();
        }

        return NULL;
    }

    public function logout(){
        $this->session->unset_userdata('adminData');
    }

    public function adminListCount($where = array()){
        $query = $this->db->get_where('TBL_ADMIN', $where);

        return $query->num_rows();
    }

    public function adminList($where = array(), $limit, $offset){
        $query = $this->db->get_where('TBL_ADMIN', $where, $limit, $offset);

        return $query->result();
    }

    public function adminData($idx){
        $query = $this->db->get_where('TBL_ADMIN', array('ADMIN_SEQ' => $idx, 'DEL_YN' => 'N'));

        return $query->row();
    }

    public function adminInsert($data){
        return $this->db->insert("TBL_ADMIN", $data);
    }

    public function adminUpdate($data, $where){
        return $this->db->update("TBL_ADMIN", $data, $where);
    }


    public function idCheck($id){
        $query = $this->db->get_where('TBL_ADMIN', array('DEL_YN' => 'N', 'ADMIN_ID' => $id));

        return $query->num_rows();
    }
}
?>