<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public $SUPER_ADMIN = array("adminList", "adminWrite", "adminWriteProc", "category", "categoryProc", "categoryDelete");
    public $POSITION = "";

	function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->library('util');
        $this->load->library('image_lib');
        $this->load->library('pagination');

        $this->load->model('admin_model');
        $this->load->model('article_model');
        $this->load->model('category_model');

        $this->config->load('pagination', TRUE);
	}

	public function index(){
        if($this->_loginCheck()){
            $adminData =  $this->session->userdata('adminData');
            $adminGrade = $adminData->ADMIN_GRADE;

            if($adminGrade == "S"){
                redirect(base_url('/admin/adminList'));
            }else{
                redirect(base_url('/admin/articleList'));
            }
            
        }else{
            redirect(base_url('/admin/login'));
        }
    }
    
    public function login(){
        if($this->_loginCheck()){
            $adminData =  $this->session->userdata('adminData');
            $adminGrade = $adminData->ADMIN_GRADE;

            if($adminGrade == "S"){
                redirect(base_url('/admin/adminList'));
            }else{
                redirect(base_url('/admin/articleList'));
            }
        }else{
            $adminId = $this->input->post('adminId', TRUE);
            $adminPassword = $this->input->post('adminPassword', TRUE);
            $rememberMe = $this->input->post('rememberMe', TRUE);

            //아이디 저장
            if($adminId != NULL && $rememberMe != NULL){
                //10일간 유지됩니다.
                $this->input->set_cookie("rememberId", $adminId, 864000);
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
                    $this->admin_model->lastLoginUpdate($result->ADMIN_SEQ);

                    $adminGrade = $result->ADMIN_GRADE;

                    if($adminGrade == "S"){
                        redirect(base_url('/admin/adminList'));
                    }else{
                        redirect(base_url('/admin/articleList'));
                    }
                }else{
                    $this->util->alert("아이디 / 비밀번호를 확인하여 주시기 바랍니다.","/admin/login");
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

        $this->POSITION = "admin";

        //검색
        $where['ADMIN_NAME'] = $this->input->get('adminName', true);
        $where['ADMIN_ID'] = $this->input->get('adminId', true);
        $where['ADMIN_GRADE'] = $this->input->get('adminGrade', true);
        $where['ADMIN_WRITE_AUTH'] = $this->input->get('adminWriteAuth', true);
        $where['USE_YN'] = $this->input->get('useYn', true);

        $data["search"] = $where; 

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

    public function adminWrite($adminSeq = 0){
        $data = array();

        $this->POSITION = "admin";

        $data["userData"] = $this->admin_model;

        if($adminSeq > 0){
            $data["userData"] = $this->admin_model->adminData($adminSeq);

            if($data["userData"] == NULL){
                $this->util->alert("잘못된 접근입니다.", "/admin/adminList");
            }
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
                $data["ADMIN_WRITE_AUTH"] = $this->input->post("adminWriteAuth", TRUE); 
                $data["ADMIN_DESC"] = $this->input->post("adminDesc", TRUE);
                $data["ADMIN_SNS"] = $this->input->post("adminSns", TRUE);
                $data["ADMIN_BLOG"] = $this->input->post("adminBlog", TRUE);

                if($data["ADMIN_SNS"] != NULL){
                    $data["ADMIN_SNS"] = prep_url($data["ADMIN_SNS"]);
                }

                if($data["ADMIN_BLOG"] != NULL){
                    $data["ADMIN_BLOG"] = prep_url($data["ADMIN_BLOG"]);
                }

                if(! $files = $this->util->multipleImageUpload("admin")) {
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
                $this->util->alert("중복된 아이디입니다.", "/admin/adminList");
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
                $data["ADMIN_WRITE_AUTH"] = $this->input->post("adminWriteAuth", TRUE); 
                $data["ADMIN_DESC"] = $this->input->post("adminDesc", TRUE);
                $data["ADMIN_SNS"] = $this->input->post("adminSns", TRUE);
                $data["ADMIN_BLOG"] = $this->input->post("adminBlog", TRUE);

                if($data["ADMIN_SNS"] != NULL){
                    $data["ADMIN_SNS"] = prep_url($data["ADMIN_SNS"]);
                }

                if($data["ADMIN_BLOG"] != NULL){
                    $data["ADMIN_BLOG"] = prep_url($data["ADMIN_BLOG"]);
                }

                $where = array();
                $where['ADMIN_SEQ'] = $seq;

                if(! $files = $this->util->multipleImageUpload("admin")) {
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
                $this->util->alert("중복된 아이디입니다.", "/admin/adminList");
            }
        }

        if($queryResult == 1){
            $this->util->alert("입력 됐습니다.", "/admin/adminList");
        }else{
            $this->util->alert("입력에 실패했습니다. 관리자에게 문의해주시기 바랍니다.", "/admin/adminList");
        }

        redirect(base_url("/admin/adminList"));
    }

    public function myProfile(){
        $data = array();

        $this->POSITION = "profile";

        $data["userData"] = $this->admin_model;

        $adminData =  $this->session->userdata('adminData');
        $adminSeq = $adminData->ADMIN_SEQ;

        if($adminSeq > 0){
            $data["userData"] = $this->admin_model->adminData($adminSeq);
        }

        $this->load->admin('admin/adminWrite', $data);
    }

    public function myProfileProc(){
        $data = array();

        $mode = $this->input->post("mode", TRUE);

        $queryResult = 0;

        if($mode == "modify"){
            $adminData =  $this->session->userdata('adminData');

            $seq = $adminData->ADMIN_SEQ;
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
                $data["ADMIN_DESC"] = $this->input->post("adminDesc", TRUE);
                $data["ADMIN_SNS"] = $this->input->post("adminSns", TRUE);
                $data["ADMIN_BLOG"] = $this->input->post("adminBlog", TRUE);

                if($data["ADMIN_SNS"] != NULL){
                    $data["ADMIN_SNS"] = prep_url($data["ADMIN_SNS"]);
                }

                if($data["ADMIN_BLOG"] != NULL){
                    $data["ADMIN_BLOG"] = prep_url($data["ADMIN_BLOG"]);
                }

                $where = array();
                $where['ADMIN_SEQ'] = $seq;

                if(! $files = $this->util->multipleImageUpload("admin")) {
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
                $this->util->alert("중복된 아이디입니다.", "/admin/myProfile");
            }
        }

        if($queryResult == 1){
            $this->util->alert("입력 됐습니다.", "/admin/myProfile");
        }else{
            $this->util->alert("입력에 실패했습니다. 관리자에게 문의해주시기 바랍니다.", "/admin/myProfile");
        }

        redirect(base_url("/admin/myProfile"));
    }

    public function articleList($page = 1){
        $data = array();
        $where = array();

        $this->POSITION = "article";

        $adminData =  $this->session->userdata('adminData');

        //조건
        if($adminData->ADMIN_GRADE != "S"){
            $where['ADMIN_SEQ'] = $adminData->ADMIN_SEQ;
        }else{
            $where['ADMIN_SEQ'] = NULL;
        }

        //검색
        $where['ARTICLE_TITLE'] = $this->input->get('articleTitle', true);
        $where['ADMIN_NAME'] = $this->input->get('adminName', true);
        $where['ARTICLE_CATEGORY'] = $this->input->get('articleCategory', true);
        $where['ARTICLE_CONTENTS'] = $this->input->get('articleContents', true);
        $where['VIEW_YN'] = $this->input->get('viewYn', true);
        $where['AUTH_YN'] = $this->input->get('authYn', true);

        $data["search"] = $where; 

        $where['DEL_YN'] = 'N'; 
        
        //페이징
        $config = $this->config->config['pagination'];
        $config['base_url'] = '/admin/articleList';
        $config['total_rows'] = $this->article_model->articleListCount($where);

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        //리스트
        $perPage = $config['per_page'];
        $offset = $perPage * ($page - 1);

        $data['offset'] = $offset;
        $data['page'] = $page;

        $data['articleList'] = $this->article_model->articleList($where, $perPage, $offset);

        $this->load->admin('admin/articleList', $data);
    }

    public function articleWrite($articleSeq = 0){
        $data = array();

        $this->POSITION = "article";

        $data["articleData"] = $this->article_model;

        if($articleSeq > 0){
            $articleData = $this->article_model->articleData($articleSeq);

            if($articleData != NULL){
                //슈퍼 관리자가 아닐 경우 본인의 글인지 체크
                $adminData =  $this->session->userdata('adminData');
                if($adminData->ADMIN_GRADE != "S"){
                    if($articleData->ADMIN_SEQ != $adminData->ADMIN_SEQ){
                        $this->util->alert("잘못된 접근입니다.", "/admin/articleList");
                    }
                }

                $data["articleData"] = $articleData;
            }
        }

        $this->load->admin('admin/articleWrite', $data);
    }

    public function editorImageUpload(){
        if(! $files = $this->util->multipleImageUpload("article")) {
            //error
        }else{
            foreach($files as $key => $value){
                //이미지일 때만 반영
                if($value["is_image"] == 1){
                    echo "top.$('.mce-btn.mce-open').parent().find('.mce-textbox').val('".base_url("/uploads/ppss/article/".$value["file_name"])."').closest('.mce-window').find('.mce-primary').click();";
                }
            }
        }
    }

    public function articleDelete(){
        $articleSeqs = $this->input->post("articleSeqs", TRUE);
        $adminData =  $this->session->userdata('adminData');

        if($articleSeqs != NULL && count($articleSeqs) > 0){
            if($adminData->ADMIN_GRADE == "S"){
                //슈퍼 관리자
                $this->article_model->articleDelete($articleSeqs);

                echo "TRUE";
            }else{
                //일반 필자는 본인의 글인지 확인 함
                foreach($articleSeqs as $index => $articleSeq){
                    $articleData = $this->article_model->articleData($articleSeq);

                    if($articleData == NULL || ($articleData->ADMIN_SEQ != $adminData->ADMIN_SEQ)){
                        echo "FALSE";

                        break;
                    }else{
                        $this->article_model->articleDelete($articleSeq);
                    }
                }

                echo "TRUE";
            }
        }else{
            echo "FALSE";
        }
    }

    public function articleAuth(){
        $articleSeqs = $this->input->post("articleSeqs", TRUE);
        $authYn = $this->input->post("authYn", TRUE);

        $adminData =  $this->session->userdata('adminData');

        if(($articleSeqs != NULL && count($articleSeqs) > 0) && $authYn != NULL ){
            if($adminData->ADMIN_GRADE == "S"){
                $data = array("AUTH_YN" => $authYn);
                
                $this->article_model->articleAuth($data, $articleSeqs);

                echo "TRUE";
            }else{
                echo "FALSE";
            }
        }else{
            echo "FALSE";
        }
    }

    public function articleWriteProc(){
        $data = array();

        $mode = $this->input->post("mode", TRUE);

        $queryResult = 0;

        $adminData =  $this->session->userdata('adminData');

        if($mode == "write"){
            $data["ADMIN_SEQ"] = $adminData->ADMIN_SEQ;
            $data["ADMIN_NAME"] = $adminData->ADMIN_NAME;
            $data["ARTICLE_CATEGORY"] = $this->input->post("articleCategory", TRUE);
            $data["ARTICLE_TITLE"] = $this->input->post("articleTitle", TRUE);
            $data["ARTICLE_CONTENTS"] = $this->input->post("articleContents", TRUE);
            $data["VIEW_YN"] = $this->input->post("viewYn", TRUE);

            if($adminData->ADMIN_WRITE_AUTH == "N"){
                $data["AUTH_YN"] = "Y";
            }

            if(! $files = $this->util->multipleImageUpload("article")) {
                //error
            }else{
                foreach($files as $key => $value){
                    //이미지일 때만 반영
                    if($value["is_image"] == 1){
                        $data["ARTICLE_FILE_NAME"] = $value["file_name"];
                        $data["ARTICLE_FILE_ORG"] = $value["orig_name"];

                        //이미지 사이즈 수정
                        $config =  array(
                            'image_library'   => 'gd2',
                            'source_image'    =>  $value['full_path'],
                            'create_thumb'    =>  TRUE,
                            'maintain_ratio'  =>  FALSE,
                            'width'           =>  150,
                            'height'          =>  150,
                        );

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }
                }
            }

            $queryResult = $this->article_model->articleInsert($data);
        }else if($mode == "modify"){
            $seq = $this->input->post("articleSeq", TRUE);

            $checkData = $this->article_model->articleData($seq);

            if($adminData->ADMIN_GRADE == "S" || ($checkData->ADMIN_SEQ == $adminData->ADMIN_SEQ)){
                $data["ARTICLE_CATEGORY"] = $this->input->post("articleCategory", TRUE);
                $data["ARTICLE_TITLE"] = $this->input->post("articleTitle", TRUE);
                $data["ARTICLE_CONTENTS"] = $this->input->post("articleContents", TRUE);
                $data["VIEW_YN"] = $this->input->post("viewYn", TRUE);

                if(! $files = $this->util->multipleImageUpload("article")) {
                    //error
                }else{
                    foreach($files as $key => $value){
                        //이미지일 때만 반영
                        if($value["is_image"] == 1){
                            $data["ARTICLE_FILE_NAME"] = $value["file_name"];
                            $data["ARTICLE_FILE_ORG"] = $value["orig_name"];

                            //이미지 사이즈 수정
                            $config =  array(
                                'image_library'   => 'gd2',
                                'source_image'    =>  $value['full_path'],
                                'create_thumb'    =>  TRUE,
                                'maintain_ratio'  =>  FALSE,
                                'width'           =>  150,
                                'height'          =>  150,
                            );

                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                    }
                }

                $where = array();
                $where['ARTICLE_SEQ'] = $seq;

                $queryResult = $this->article_model->articleUpdate($data, $where);
            }else{
                $this->util->alert("잘못된 접근입니다.", "/admin/articleList");
            }
        }

        if($queryResult == 1){
            $this->util->alert("입력 됐습니다.", "/admin/articleList");
        }else{
            $this->util->alert("입력에 실패했습니다. 관리자에게 문의해주시기 바랍니다.", "/admin/articleList");
        }

        redirect(base_url("/admin/articleList"));
    }

    public function category($idx = 0){
        $data = array();

        $this->POSITION = "category";

        $data["parentList"] = $this->category_model->categoryParentList();
        $data["categoryList"] = $this->category_model->categoryList();
        $data["categoryData"] = $this->category_model;

        if($idx > 0){
            $data["categoryData"] =$this->category_model->categoryData($idx);
        }

        if(count($data["categoryList"]) > 0){
			foreach($data["categoryList"] as $index => $categoryData){
                $prefix = "";
                $level = $categoryData->CATEGORY_LEVEL;

                for($i = 1 ; $i < $level ; $i++){
                    $prefix .= "└";
                }

                $categoryData->CATEGORY_NAME = $prefix.$categoryData->CATEGORY_NAME;
                
				$data["categoryList"][$index] = $categoryData;
			}
		}

        $this->load->admin('admin/category', $data);
    }

    public function categoryProc(){
        $data = array();

        $mode = $this->input->post("mode", TRUE);

        $queryResult = 0;
        
        if($mode == "write"){
            $slug = $this->input->post("categorySlug", TRUE);

            $count = $this->category_model->slugCheck($slug);

            if($count == 0){
                $parentSeq = $this->input->post("parentSeq", TRUE);
                
                if($parentSeq > 0){
                    $data["PARENT_SEQ"] = $parentSeq;
                }
                
                $data["CATEGORY_LEVEL"] = $this->input->post("categoryLevel", TRUE);
                $data["CATEGORY_NAME"] = $this->input->post("categoryName", TRUE);
                $data["CATEGORY_SLUG"] = $this->input->post("categorySlug", TRUE);
                $data["CATEGORY_DESC"] = $this->input->post("categoryDesc", TRUE);
                $data["VIEW_YN"] = $this->input->post("viewYn", TRUE);

                
                $queryResult = $this->category_model->categoryInsert($data);
            }else{
                $this->util->alert("중복된 슬러그입니다.", "/admin/category");
            }
        }else if($mode == "modify"){
            $seq = $this->input->post("categorySeq", TRUE);
            $slug = $this->input->post("categorySlug", TRUE);
            $beforeData = $this->category_model->categoryData($seq);

            $count = $this->category_model->slugCheck($slug);

            if($count == 0 || ($beforeData->CATEGORY_SLUG == $slug)){
                if($seq > 0){
                    $parentSeq = $this->input->post("parentSeq", TRUE);
                    if($parentSeq > 0){
                        $data["PARENT_SEQ"] = $parentSeq;
                    }

                    $data["CATEGORY_LEVEL"] = $this->input->post("categoryLevel", TRUE);
                    $data["CATEGORY_NAME"] = $this->input->post("categoryName", TRUE);
                    $data["CATEGORY_SLUG"] = $this->input->post("categorySlug", TRUE);
                    $data["CATEGORY_DESC"] = $this->input->post("categoryDesc", TRUE);
                    $data["VIEW_YN"] = $this->input->post("viewYn", TRUE);

                    $where = array();
                    $where['CATEGORY_SEQ'] = $seq;

                    $queryResult = $this->category_model->categoryUpdate($data, $where);
                }else{
                    $this->util->alert("잘못된 접근입니다.", "/admin/category");
                }
            }else{
                $this->util->alert("중복된 슬러그입니다.", "/admin/category");
            }
        }

        if($queryResult == 1){
            $this->util->alert("입력 됐습니다.", "/admin/category");
        }else{
            $this->util->alert("입력에 실패했습니다. 관리자에게 문의해주시기 바랍니다.", "/admin/category");
        }

        redirect(base_url("/admin/category"));
    }

    public function categoryDelete(){
        $categorySeqs = $this->input->post("categorySeqs", TRUE);

        if($categorySeqs != NULL && count($categorySeqs) > 0){
            $this->category_model->categoryDelete($categorySeqs);

            echo "TRUE";
        }else{
            echo "FALSE";
        }
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
