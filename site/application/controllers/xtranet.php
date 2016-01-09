<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Xtranet extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $language = $this->session->userdata('language');
        $language = !$language || $language=='' ? 'english' : $language ;
        
        $this->lang->load('common', $language);
        $this->lang->load('interface', $language);

        $this->load->model('utility_model');
    }
    
    public function index($section=''){
        if ( $section=='' || ($section!='mest_hypeat' && $section!='startup' && $section!="emission" && $section!="finansnytt" )) {
            $section = "mest_hypeat";
        }
        $ssid = "";
		$lurl = $_SERVER['REQUEST_URI'];
		
        $news_id = '800000';
        $page_data['page_name'] = 'nyheter';
        $page_data['section'] = $section;
        $page_data['news_id'] = $news_id;
        
        if ($news_id=='') {
            $page_data['news'] = array();
            $this->load->view('home', $page_data);
            
        } else {
            $l = time();
            $t = mdate('%Y%m%d%H%i%s', $l);
            
            $news = $this->utility_model->get('article', array('id'=>$news_id));
            
            $content = $news['summary'];
            $content = str_replace("<br>", "", $content);
            
            $news_list = explode(".", $content);

            $news['list'] = $news_list;
            $page_data['news'] = $news;
            
            $user_id = $this->session->userdata('front_user');
            if ($user_id!==false) {
                $comment = $this->utility_model->get('ih_comment', array('user_id'=>$user_id, 'news_id'=>$news_id));
                if ($comment) {
                    $comment['time'] = $this->utility_model->get_diff_time($comment['updated_at'], $t);
                    $comment['screen'] = "investhype";
                }
                
                $user = $this->utility_model->get('ih_user', array('id'=>$user_id));
                $page_data['user'] = $user;
                $page_data['comment'] = $comment;
            }
            
            $page_data['images'] = $news['image'];
 
            $this->load->view('emission', $page_data);
        }
        
    }
}
