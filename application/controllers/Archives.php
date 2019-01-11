<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archives extends CI_Controller {

	function __construct(){
        parent::__construct();

        $this->load->library('util');

        $this->load->model('article_model');
        $this->load->model('admin_model');
	}

	public function index(){
		$this->view();
    }
    
    public function view($id = 0){
        $data = array();

        if($id > 0){
            $data["articleData"] = $this->article_model->articleFrontData($id);

            if($data["articleData"] != NULL){
                $data["title"] = $data["articleData"]->ARTICLE_TITLE;

                $data["writerData"] = $this->admin_model->adminFrontData($data["articleData"]->ADMIN_SEQ);

                $this->load->template('archives', $data);
            }else{
                $this->util->alert("잘못된 접근입니다.","/");
            }
        }else{
            $this->util->alert("잘못된 접근입니다.","/");
        }
    }

    public function author($id = ""){
        $data["title"] = "아카이브 타이틀";

        $this->load->template('author', $data);
    }
}
