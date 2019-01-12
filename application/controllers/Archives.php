<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archives extends CI_Controller {

	function __construct(){
        parent::__construct();

        $this->load->library('session');
        $this->load->library('util');
        $this->load->library('pagination');

        $this->load->model('article_model');
        $this->load->model('admin_model');

        $this->config->load('pagination_front', TRUE);
	}

	public function index(){
        //전체글
		$this->author();
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

    public function author($id = 0, $page = 1){
        $data = array();
        $title = " | ㅍㅍㅅㅅ";
        $header = "전체글";

        //페이징 설정 초기화
        $config = $this->config->config['pagination_front'];
        $perPage = $config['per_page'];
        $offset = $perPage * ($page - 1);

        if($page > 1){
            $title = " | 페이지 $page".$title;
        }

        if($id == 0){
            //전체글
            //페이징 설정
            $config['base_url'] = "/archives/page";
            $config['total_rows'] = $this->article_model->articleFrontListCount();

            $data['articleList'] = $this->article_model->articleFrontList($perPage, $offset);

            $title = "전체글".$title;
        }else{
            //필자
            //페이징 설정
            $config['base_url'] = "/archives/author/$id/page";
            $config['total_rows'] = $this->article_model->articleAuthorListCount($id);

            $data["writerData"] = $this->admin_model->adminFrontData($id);

            if($data["writerData"] != NULL){
                $data['articleList'] = $this->article_model->articleAuthorList($id, $perPage, $offset);

                $title = $data["writerData"]->ADMIN_NAME.$title;
                $header = $data["writerData"]->ADMIN_NAME;
            }else{
                $this->util->alert("잘못된 접근입니다.","/");
            }
        }

        //태그 제거
        if(count($data["articleList"]) > 0){
			foreach($data["articleList"] as $index => $articleData){
                $articleData->ARTICLE_CONTENTS = substr($this->util->stripTags($articleData->ARTICLE_CONTENTS), 0, 501)."&nbsp;…";
                
				$data["articleList"][$index] = $articleData;
			}
		}

        //페이징 생성
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['offset'] = $offset;
        $data['page'] = $page;
        
        $data["title"] = $title;
        $data["header"] = $header;

        $this->load->template('author', $data);
    }
}
