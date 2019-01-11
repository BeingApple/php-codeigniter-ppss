<?php
 class MY_Loader extends CI_Loader{
	function __construct(){
        parent::__construct();
	}

     public function template($template_name, $vars = array(), $return = FALSE){
        $param = array();

		$nav = isset($vars['nav']) ? $vars['nav'] : 'template/nav';
		$aside = isset($vars['aside']) ? $vars['aside'] : 'template/aside';
		$footer = isset($vars['footer']) ? $vars['footer'] : 'template/footer';

		$param['nav'] = $nav;
		$param['aside'] = $aside;
        $param['footer'] = $footer;
        
		$param['template_name'] = $template_name;
		$param['vars'] = $vars;

		$this->view('template/layout', $param);
	 }
	 
	 public function admin($template_name, $vars = array(), $return = FALSE){
		$CI =& get_instance();
		$CI->load->library('session');
		
		$adminData =  $CI->session->userdata('adminData');

		if($adminData != NULL){
			$param = array();

			if($adminData->ADMIN_GRADE == "S"){
				$nav = isset($vars['nav']) ? $vars['nav'] : 'admin/template/nav';
			}else{
				$nav = isset($vars['nav']) ? $vars['nav'] : 'admin/template/nav_normal';
			}

			$param['nav'] = $nav;
			
			$param['template_name'] = $template_name;

			$vars['adminData'] = $adminData;
			$param['vars'] = $vars;

			$this->view('admin/template/layout', $param);
		}else{
			redirect(base_url('/admin/login'));
		}
     }
 }
?>