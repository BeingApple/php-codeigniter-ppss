<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archives extends CI_Controller {

	function __construct(){
        parent::__construct();
        
        $this->load->model('test_model');
	}

	public function index(){
		$this->view();
    }
    
    public function view($id = NULL){
        $data["title"] = "아카이브 타이틀";
        $data["data"] = $this->test_model->get_last_one();

        $this->load->template('archives', $data);
    }
}
