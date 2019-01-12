<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->library('util');

		$this->load->model("article_model");
	}

	public function index(){
		$data = array();

		$data["title"] = "ㅍㅍㅅㅅ | 필자와 독자의 경계가 없는 이슈 큐레이팅 매거진";
		$data["articleList"] = $this->article_model->articleFrontList(10, 0);

		if(count($data["articleList"]) > 0){
			foreach($data["articleList"] as $index => $articleData){
				$ext = strtolower(substr(strrchr($articleData->ARTICLE_FILE_NAME, "."), 1)); 
				$fileNameWithoutExt = substr($articleData->ARTICLE_FILE_NAME, 0, strrpos($articleData->ARTICLE_FILE_NAME, "."));
				$thumb = $fileNameWithoutExt."_thumb.".$ext;

				$articleData->ARTICLE_FILE_NAME = file_exists("/uploads/ppss/article/".$thumb)? $thumb : $articleData->ARTICLE_FILE_NAME;
				$articleData->ARTICLE_CONTENTS = substr($this->util->stripTags($articleData->ARTICLE_CONTENTS), 0, 501)."&nbsp;…";
				
				$data["articleList"][$index] = $articleData;
			}
		}

		$this->load->template('main', $data);
	}
}
