<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission{
    function adminPermission(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->library('util');

        $adminData =  $CI->session->userdata('adminData');

        if(strpos($CI->uri->uri_string,"admin") !== FALSE){
            if($CI->uri->uri_string != "admin/login" && $adminData == NULL){
                $CI->util->alert("로그인이 필요합니다.","/admin/login");
            }
        }
    }

    function adminAuth(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->library('util');

        $adminData =  $CI->session->userdata('adminData');

        if(strpos($CI->uri->uri_string,"admin") !== FALSE){
            if($CI->uri->uri_string != "admin/login" && $CI->uri->uri_string != "admin/logout" && $adminData != NULL){
                $adminGrade = $adminData->ADMIN_GRADE;

                if($adminGrade != "S" && isset($CI->SUPER_ADMIN) && in_array($CI->router->method, $CI->SUPER_ADMIN)){
                    $CI->util->alert("권한이 없습니다.","/admin/myProfile");
                }
            }
        }
    }
}

?>