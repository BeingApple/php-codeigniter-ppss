<?php
 class MY_Loader extends CI_Loader{
     public function template($template_name, $vars = array(), $return = FALSE){
        $param = array();

		$nav = isset($vars['nav']) ? $vars['layout_header'] : 'template/nav';
		$aside = isset($vars['aside']) ? $vars['layout_footer'] : 'template/aside';
		$footer = isset($vars['footer']) ? $vars['html_footer'] : 'template/footer';

		$param['nav'] = $nav;
		$param['aside'] = $aside;
        $param['footer'] = $footer;
        
		$param['template_name'] = $template_name;
		$param['vars'] = $vars;

		$this->view('template/layout', $param);
     }
 }
?>