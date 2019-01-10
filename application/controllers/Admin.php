<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->library('util');
        $this->load->library('image_lib');
        $this->load->library('pagination');

        $this->load->model('admin_model');

        $this->config->load('pagination', TRUE);
	}

	public function index(){
        if($this->_loginCheck()){
            redirect(base_url('/admin/adminList'));
        }else{
            $this->login();
        }
    }
    
    public function login(){
        if($this->_loginCheck()){
            redirect(base_url('/admin/adminList'));
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
                    $this->session->set_userdata('adminData', $result);

                    redirect(base_url('/admin/adminList'));
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

    public function adminList($page = 1){
        $data = array();
        $where = array();

        $where['DEL_YN'] = 'N'; 
        
        //페이징
        $config = $this->config->config['pagination'];
        $config['base_url'] = '/admin/adminList';
        $config['total_rows'] = $this->admin_model->adminListCount($where);

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        //리스트
        $perPage = $config['per_page'];
        $offset = $perPage * ($page - 1);

        $data['offset'] = $offset;
        $data['page'] = $page;

        $data['adminList'] = $this->admin_model->adminList($where, $perPage, $offset);

        $this->load->admin('admin/adminList', $data);
    }

    public function adminWrite($adminIndex = 0){
        $data = array();

        $data["userData"] = $this->admin_model;

        if($adminIndex > 0){
            $data["userData"] = $this->admin_model->adminData($adminIndex);
        }

        $this->load->admin('admin/adminWrite', $data);
    }

    public function adminWriteProc(){
        $data = array();

        $mode = $this->input->post("mode", TRUE);

        $queryResult = 0;

        if($mode == "write"){
            $id = $this->input->post("adminId", TRUE);
            $count = $this->admin_model->idCheck($id);

            if($count == 0){
                $data["ADMIN_NAME"] = $this->input->post("adminName", TRUE);
                $data["ADMIN_ID"] = $id;
                $data["ADMIN_PASSWORD"] = hash('sha256', $this->input->post("adminPassword", TRUE));
                $data["USE_YN"] = $this->input->post("useYn", TRUE);
                $data["ADMIN_GRADE"] = $this->input->post("adminGrade", TRUE); 

                if(! $files = $this->util->multiple_upload('admin')) {
                    //error
                }else{
                    foreach($files as $key => $value){
                        //이미지일 때만 반영
                        if($value["is_image"] == 1){
                            $data["ADMIN_FILE_NAME"] = $value["file_name"];
                            $data["ADMIN_FILE_ORG"] = $value["orig_name"];

                            //이미지 사이즈 수정
                            
                            $config =  array(
                                'image_library'   => 'gd2',
                                'source_image'    =>  $value['full_path'],
                                'maintain_ratio'  =>  TRUE,
                                'width'           =>  70,
                                'height'          =>  70,
                            );

                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                    }
                }

                $queryResult = $this->admin_model->adminInsert($data);
            }else{
                $this->util->alert("중복된 아이디입니다.","/admin/adminList");
            }
        }else if($mode == "modify"){
            $seq = $this->input->post("adminSeq", TRUE);
            $beforeData = $this->admin_model->adminData($seq);
            $id = $this->input->post("adminId", TRUE);
            $password = $this->input->post("adminPassword", TRUE);

            $count = $this->admin_model->idCheck($id);

            if($count == 0 || ($beforeData->ADMIN_ID == $id)){
                $data["ADMIN_NAME"] = $this->input->post("adminName", TRUE);
                $data["ADMIN_ID"] = $id;
                if($password != NULL){
                    $data["ADMIN_PASSWORD"] = hash('sha256', $password);
                }
                $data["USE_YN"] = $this->input->post("useYn", TRUE);
                $data["ADMIN_GRADE"] = $this->input->post("adminGrade", TRUE); 

                $where = array();
                $where['ADMIN_SEQ'] = $seq;

                if(! $files = $this->util->multiple_upload('admin')) {
                    //error
                }else{
                    foreach($files as $key => $value){
                        //이미지일 때만 반영
                        if($value["is_image"] == 1){
                            $data["ADMIN_FILE_NAME"] = $value["file_name"];
                            $data["ADMIN_FILE_ORG"] = $value["orig_name"];

                            //이미지 사이즈 수정
                            
                            $config =  array(
                                'image_library'   => 'gd2',
                                'source_image'    =>  $value['full_path'],
                                'maintain_ratio'  =>  TRUE,
                                'width'           =>  70,
                                'height'          =>  70,
                            );

                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                    }
                }

                $queryResult = $this->admin_model->adminUpdate($data, $where);
            }else{
                $this->util->alert("중복된 아이디입니다.","/admin/adminList");
            }
        }

        if($queryResult == 1){
            $this->util->alert("입력 됐습니다.","/admin/adminList");
        }else{
            $this->util->alert("입력에 실패했습니다. 관리자에게 문의해주시기 바랍니다.","/admin/adminList");
        }

        redirect(base_url('/admin/adminList'));
    }

    public function idCheck(){
        $id = $this->input->post("adminId", TRUE);

        if($id != NULL){
            $count = $this->admin_model->idCheck($id);

            if($count > 0){
                echo "FALSE";
            }else{
                echo "TRUE";
            }

        }else{
            echo "FALSE";
        }

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
