<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$data = array();

		$data["title"] = "ㅍㅍㅅㅅ | 필자와 독자의 경계가 없는 이슈 큐레이팅 매거진";

		$this->load->template('main', $data);
	}
}
