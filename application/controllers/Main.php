<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->template('main');
	}

	public function test(){
		$this->load->template('test');
	}
}
