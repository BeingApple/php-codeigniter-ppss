<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model{
    public $CATEGORY_SEQ;
    public $PARENT_SEQ;
    public $CATEGORY_LEVEL;
    public $CATEGORY_NAME;
    public $CATEGORY_SLUG;
    public $CATEGORY_DESC;
    public $VIEW_YN;
    public $DEL_YN;
    public $REG_DATE;

    function __construct(){
        parent::__construct();
        
        $this->load->database();
    }
    
    public function categoryList(){
        $this->db->order_by('PARENT_SEQ', 'ASC');
        $this->db->order_by('CATEGORY_LEVEL', 'ASC');

        $query = $this->db->get_where('TBL_CATEGORY', array('DEL_YN' => 'N'));

        return $query->result();
    }

    public function categoryFrontList(){
        $this->db->order_by('PARENT_SEQ', 'ASC');
        $this->db->order_by('CATEGORY_LEVEL', 'ASC');

        $query = $this->db->get_where('TBL_CATEGORY', array('DEL_YN' => 'N', 'VIEW_YN' => 'Y'));

        return $query->result();
    }

    public function categoryData($idx){
        $query = $this->db->get_where('TBL_CATEGORY', array('CATEGORY_SEQ' => $idx, 'DEL_YN' => 'N'));

        return $query->row();
    }

    public function categoryDataBySlug($slug){
        $query = $this->db->get_where('TBL_CATEGORY', array('CATEGORY_SLUG' => $slug, 'DEL_YN' => 'N', 'VIEW_YN' => 'Y'));

        return $query->row();
    }

    public function categoryDataByNames($list_name){
        $this->db->where_in("CATEGORY_NAME", $list_name);
        $this->db->where(array('DEL_YN' => 'N', 'VIEW_YN' => 'Y'));
        $query = $this->db->get('TBL_CATEGORY');

        return $query->result();
    }

    public function categoryInsert($data){
        $result1 = $this->db->insert("TBL_CATEGORY", $data);

        if($data["CATEGORY_LEVEL"] == 1){
            $categorySeq = $this->db->insert_id();

            $result2 = $this->db->update("TBL_CATEGORY", array("PARENT_SEQ" => $categorySeq), array("CATEGORY_SEQ" => $categorySeq));

            return $result1 && $result2;
        }else{
            return $result1;
        }
    }

    public function categoryUpdate($data, $where){
        return $this->db->update("TBL_CATEGORY", $data, $where);
    }

    public function categoryDelete($where_in){
        $data['DEL_YN'] = 'Y';

        $this->db->where_in('CATEGORY_SEQ', $where_in); 
        $this->db->or_where_in('PARENT_SEQ', $where_in); 
        return $this->db->update("TBL_CATEGORY", $data);
    }

    public function slugCheck($slug){
        $query = $this->db->get_where('TBL_CATEGORY', array('DEL_YN' => 'N', 'CATEGORY_SLUG' => $slug));

        return $query->num_rows();
    }
}
?>