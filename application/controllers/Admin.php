<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->model('admin_model');
	}

	public function index(){
        if($this->_loginCheck()){
            echo "로그인 하셨네요";
        }else{
            $this->login();
        }
    }
    
    public function login(){
        if($this->_loginCheck()){
            echo "로그인 하셨네요";
        }else{
            $adminId = $this->input->post('adminId', TRUE);
            $adminPassword = $this->input->post('adminPassword', TRUE);
            $rememberMe = $this->input->post('rememberMe', TRUE);

            //아이디 저장
            if($adminId != NULL && $rememberMe != NULL){
                //10일간 유지됩니다.
                $this->input->set_cookie("rememberId", $adminId, 86400);
            }

            if($adminId == NULL && $adminPassword == NULL){
                //로그인 페이지
                $data = array();
                $data['rememberId'] = $rememberId = $this->input->cookie("rememberId", TRUE);

                $this->load->view('admin/login', $data);
            }else{
                //로그인 처리
                $result = $this->admin_model->login($adminId, $adminPassword);

                if($result != NULL){
                    echo "로그인 되셨네요";
                    $this->session->set_userdata('adminData', $result);
                }else{
                    echo "로그인 실패";
                }
            }
        }
    }

    public function logout(){
        $this->admin_model->logout();

        redirect(base_url('/admin/login'));
    }

    private function _loginCheck(){
        $adminData =  $this->session->userdata('adminData');

        if($adminData == NULL){
            return FALSE;
        }else{
            return TRUE;
        }
    }
}
