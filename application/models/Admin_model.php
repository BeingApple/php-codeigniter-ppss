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
    public $ADMIN_DESC;
    public $ADMIN_WRITE_AUTH;
    public $ADMIN_BLOG;
    public $ADMIN_SNS;
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

    public function lastLoginUpdate($idx = 0){
        if($idx > 0){
            $data['LAST_LOGIN_DATE'] =  date("Y-m-d H:i:s",time());
            $where['ADMIN_SEQ'] = $idx;
            return $this->db->update("TBL_ADMIN", $data, $where);
        }
    }

    public function logout(){
        $this->session->unset_userdata('adminData');
    }

    public function adminListCount($where = array()){
        if($where['ADMIN_NAME'] != NULL && $where['ADMIN_NAME'] != ""){
            $this->db->like('ADMIN_NAME', $where['ADMIN_NAME'], 'both');
        }

        if($where['ADMIN_ID'] != NULL && $where['ADMIN_ID'] != ""){
            $this->db->like('ADMIN_ID', $where['ADMIN_ID'], 'both');
        }

        if($where['ADMIN_GRADE'] != NULL && $where['ADMIN_GRADE'] != ""){
            $this->db->where('ADMIN_GRADE', $where['ADMIN_GRADE']);
        }

        if($where['ADMIN_WRITE_AUTH'] != NULL && $where['ADMIN_WRITE_AUTH'] != ""){
            $this->db->where('ADMIN_WRITE_AUTH', $where['ADMIN_WRITE_AUTH']);
        }

        if($where['USE_YN'] != NULL && $where['USE_YN'] != ""){
            $this->db->where('USE_YN', $where['USE_YN']);
        }

        $this->db->where('DEL_YN', $where['DEL_YN']);

        $query = $this->db->get('TBL_ADMIN');

        return $query->num_rows();
    }

    public function adminList($where = array(), $limit, $offset){
        if($where['ADMIN_NAME'] != NULL){
            $this->db->like('ADMIN_NAME', $where['ADMIN_NAME'], 'both');
        }

        if($where['ADMIN_ID'] != NULL){
            $this->db->like('ADMIN_ID', $where['ADMIN_ID'], 'both');
        }

        if($where['ADMIN_GRADE'] != NULL){
            $this->db->where('ADMIN_GRADE', $where['ADMIN_GRADE']);
        }

        if($where['ADMIN_WRITE_AUTH'] != NULL && $where['ADMIN_WRITE_AUTH'] != ""){
            $this->db->where('ADMIN_WRITE_AUTH', $where['ADMIN_WRITE_AUTH']);
        }

        if($where['USE_YN'] != NULL){
            $this->db->where('USE_YN', $where['USE_YN']);
        }

        $this->db->where('DEL_YN', $where['DEL_YN']);

        $query = $this->db->get('TBL_ADMIN', $limit, $offset);

        return $query->result();
    }

    public function adminData($idx){
        $query = $this->db->get_where('TBL_ADMIN', array('ADMIN_SEQ' => $idx, 'DEL_YN' => 'N'));

        return $query->row();
    }

    public function adminFrontData($idx){
        $query = $this->db->get_where('TBL_ADMIN', array('ADMIN_SEQ' => $idx, 'DEL_YN' => 'N', 'USE_YN' => 'Y'));

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