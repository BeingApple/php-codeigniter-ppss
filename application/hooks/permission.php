<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission{
    function permission(){
        $CI =& get_instance();
        $CI->load->library('session');

        $adminData =  $CI->session->userdata('adminData');

		if($CI->uri->uri_string() != "admin/login" && $adminData == NULL){
            redirect(base_url('/admin/login'));
        }
    }
}

?>