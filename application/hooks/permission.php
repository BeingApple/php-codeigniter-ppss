<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission{
    function adminPermission(){
        $CI =& get_instance();
        $CI->load->library('session');

        $adminData =  $CI->session->userdata('adminData');

        if(strpos($CI->uri->uri_string,"admin") !== FALSE){
            if($CI->uri->uri_string != "admin/login" && $adminData == NULL){
                redirect(base_url('/admin/login'));
            }
        }
    }

    function adminAuth(){
        $CI =& get_instance();
        $CI->load->library('session');

        $adminData =  $CI->session->userdata('adminData');

        if(strpos($CI->uri->uri_string,"admin") !== FALSE){
            if($CI->uri->uri_string != "admin/login" && $CI->uri->uri_string != "admin/logout" && $adminData != NULL){
                $adminGrade = $adminData->ADMIN_GRADE;
                
                if($adminGrade != "S" && isset($CI->SUPER_ADMIN) && $CI->SUPER_ADMIN == TRUE){
                    //필자가 관리자 메뉴에 접근했을 때
                    print("GET OUT");
                }
            }
        }
    }
}

?>