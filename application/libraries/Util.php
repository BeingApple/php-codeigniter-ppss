<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util{
    function multiple_upload() {
        if(is_dir('uploads/ppss/')){

        }else{
            if(@mkdir('uploads/ppss/', 0700, true)){}
            else{ return FALSE; }
        }
        $CI = & get_instance ();
        $files = array ();
        
        $CI->load->library ( 'upload' );
        
        $errors = FALSE;
        
        foreach ( $_FILES as $key => $value ) {
            // print_r($key);
            if (! $CI->upload->do_upload ( $key)) {
                // $data['upload_message'] = $CI->upload->display_errors(); // ERR_OPEN and ERR_CLOSE are error delimiters defined in a config file
                // $CI->load->vars($data);
                // echo "<pre>";
                // print_r($data['upload_message']);
                // echo "</pre>";
                // $errors = TRUE;
            } else {
                // Build a file array from all uploaded files
                $files[$key] = $CI->upload->data ();
            }
        }
        
        // There was errors, we have to delete the uploaded files
        if ($errors) {
            foreach ( $files as $key => $file ) {
                @unlink ( $file ['full_path'] );
            }
        } elseif (empty ( $files ) and empty ( $data ['upload_message'] )) {
            $CI->lang->load ( 'upload' );
            $data ['upload_message'] = $CI->lang->line ( 'upload_no_file_selected' );
            $CI->load->vars ( $data );
        } else {
            return $files;
        }
    }
    
    // 경고메세지를 경고창으로
    function alert($msg = '', $url = '') {
        $CI = & get_instance ();
        
        if (! $msg)
            $msg = '올바른 방법으로 이용해 주십시오.'; 
        echo "<!DOCTYPE html>";
        echo "<html lang=\"ko\">";
        echo "<head>";
        echo "<meta charset=" . $CI->config->item ( 'charset' ) . "\" />";
        echo "<title>ㅍㅍㅅㅅ | 관리자</title>";
        echo "<script type='text/javascript'>alert('" . $msg . "');";
        if ($url)
            echo "location.replace('" . $url . "');";
        else
            echo "history.go(-1);";
            echo "</script>";
            echo "</head><body></body></html>";
        exit ();
    }
}
?>