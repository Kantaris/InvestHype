<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $language = $this->session->userdata('language');
        $language = !$language || $language=='' ? 'english' : $language ;
        
        $this->lang->load('common', $language);
        $this->lang->load('interface', $language);

        $this->load->model('utility_model');
    }

    public function switch_language($language=''){
        $language = ($language == "") ? "english" : $language;
        $this->session->set_userdata('language', $language);
        print_r(json_encode(array('errCode'=>0)));
    }
    
    public function switch_currency($currency=''){
        $currency = ($currency == "") ? "usd" : $currency;
        $this->session->set_userdata('currency', $currency);
        print_r(json_encode(array('errCode'=>0)));
    }
    
    public function submit_email() {
        $email = $this->input->get_post('email');
        if ($this->utility_model->insert('email', array( 'address'=>$email))){
                    print_r(json_encode(array('errCode'=>0)));
                } else {
                    print_r(json_encode(array('errCode'=>1)));
                }
    }
    
    public function submit_subscribe() {
        $l = time();
        $t = mdate('%Y%m%d%H%i%s', $l);
        
        $email = $this->input->get_post('email');
        $status = $this->input->get_post('status');
        $status = $status!==false ? $status : "0";
        
        if ($email) {
//            $this->load->library('mailchimp_library');
//            $result = $this->mailchimp_library->call('lists/subscribe', array(
//                'id'                => '0771720b63',
//                'email'             => array('email'=>$email),
//                'merge_vars'        => array('FNAME'=>'Anonymous', 'LNAME'=>'Anonymous'),
//                'double_optin'      => false,
//                'update_existing'   => true,
//                'replace_interests' => false,
//                'send_welcome'      => false,
//            ));
//            print_r($result);            
            
//            if ($status=="0") {
//                $this->utility_model->delete('ih_subscribe', array('email'=>$email));
//                print_r(json_encode(array('errCode'=>0)));
//            } else {
//                $subscribe = $this->utility_model->get('ih_subscribe', array('email'=>$email));
//                if ($subscribe) {
//                    print_r(json_encode(array('errCode'=>0)));
//                } else {
//                    if ($this->utility_model->insert('ih_subscribe', array( 'email'=>$email, 'created_at'=>$t))){
//                        print_r(json_encode(array('errCode'=>0)));
//                    } else {
//                        print_r(json_encode(array('errCode'=>1)));
//                    }
//                }
                
                //API Url
                $url = "https://us10.api.mailchimp.com/2.0/lists/subscribe?apikey=73e5b102a4e1eb0482079e088660d780-us10&id=0771720b63&email[email]=" . $email;
                $result = file_get_contents($url);
                
//                $ch = curl_init();
//                curl_setopt($ch, CURLOPT_URL, $url);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                curl_setopt($ch, CURLOPT_HEADER, 1);                
                
//                //Initiate cURL.
//                $ch = curl_init($url);
////                curl_setopt($ch, CURLOPT_USERAGENT, 'MailChimp-PHP/2.0.6');
//
//                //The JSON data.
//                $jsonData = array(
//                    'apikey' => '73e5b102a4e1eb0482079e088660d780-us10',
////                    'email_address'=>$email,
//                    'status'=>'subscribed',
////                    'merge_vars' => null
//                );
//
//                //Encode the array into JSON.
//                $jsonDataEncoded = json_encode($jsonData);
//
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                
//                //Tell cURL that we want to send a POST request.
//                curl_setopt($ch, CURLOPT_POST, 1);
////                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
//
//                //Attach our encoded JSON string to the POST fields.
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
//
//                //Set the content type to application/json
////                curl_setopt($ch, CURLOPT_HEADER, true);
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

                //Execute the request
//                $result = curl_exec($ch);
//                curl_close($ch);
                
                if ($result) {
                    print_r(json_encode(array('errCode'=>0, 'result'=>  json_decode($result))));
                } else {
                    print_r(json_encode(array('errCode'=>1)));
                }
//            }
        } else {
            print_r(json_encode(array('errCode'=>1)));
        }
    }
    
    public function remove_subscribe(){
        $this->session->set_userdata('subscribe', 'remove');
        print_r(json_encode(array('errCode'=>0)));
    }

    public function submit_comment() {
        $l = time();
        $t = mdate('%Y%m%d%H%i%s', $l);
        
        $c = $this->input->get_post('comment');
        $news_id = $this->input->get_post('news_id');
        
        $user_id = $this->session->userdata('front_user');
        if ($user_id!==false && $news_id!==false) {
            $comment = $this->utility_model->get('ih_comment', array('user_id'=>$user_id, 'news_id'=>$news_id));
            if ($comment) {
                if ($this->utility_model->update('ih_comment', array( 'content'=>$c, 'updated_at'=>$t, 'updated_time'=>$l ), array('user_id'=>$user_id, 'news_id'=>$news_id))){
                    print_r(json_encode(array('errCode'=>0)));
                } else {
                    print_r(json_encode(array('errCode'=>1)));
                }
            } else {
                if ($this->utility_model->insert('ih_comment', array( 'content'=>$c, 'created_at'=>$t, 'updated_at'=>$t, 'updated_time'=>$l, 'user_id'=>$user_id, 'news_id'=>$news_id))){
                    print_r(json_encode(array('errCode'=>0)));
                } else {
                    print_r(json_encode(array('errCode'=>1)));
                }
            }
        } else {
            print_r(json_encode(array('errCode'=>1)));
        }
    }
    
    public function news($section='') {
        $result = array();
        $t = mdate('%Y%m%d%H%i%s', time()-60*60*24);
        $category_id = "";
        
        $section_const = array(
            'startup'=>'1', 
            'emission'=>'2',
            'finansnytt'=>'3'
        );
        $section_v_const = array(
            '0'=>'mest hypeat',
            '1'=>'startup news', 
            '2'=>'emissionserbjudanden',
            '3'=>'finansnytt'
        );
        $section_background_const = array(
            '0'=>'background-mest_hypeat',
            '1'=>'background-startup_news', 
            '2'=>'background-emission',
            '3'=>'background-finansnytt'
        );
        
        if ($section!="" && isset($section_const[$section])) {
            $category_id = $section_const[$section];
        }
        
        $result['category_id']=$category_id;
        
        $sql = " select a.sourceId, s.name as source_name, a.id, s.categoryId, a.title, a.link, a.date, a.description, a.image, a.facebook, a.twitter, a.linkedin from article a, source s where s.id=a.sourceId ";
        if ($category_id!='') {
            $sql .= " and s.category_id='$category_id' ";
        }
        
        $sql .= " and a.pub_at>='$t' ";
        
        $sql .= " order by a.facebook desc ";
//        $sql .= " limit 84 ";

$result['sql']=$sql;
        
        $query = $this->db->query($sql);
        $r = $query->result_array();
        if ($r) {
            foreach ($r as $row) {
                $category_id = $row['category_id'];
                if (isset($section_v_const[$category_id])) {
                    $row['category_name'] = $section_v_const[$category_id];
                    $row['title_background'] = $section_background_const[$category_id];
                }
                
               // $row['comments'] = $this->utility_model->get_count('ih_comment', array('news_id'=>$row['id']));
               // $row['images'] = $this->utility_model->get_list('ih_news_image', array('news_id'=>$row['id']));
                
                array_push($result, $row);
            }
        }
        
        $result['category_id']=$category_id;
        
        if (count($result)<10) {
            $t = mdate('%Y%m%d%H%i%s', time()-60*60*24*2);
            $sql = " select a.source_id, s.name as source_name, a.id, s.category_id, a.title, a.author, a.link, a.pubdate, a.pub_at, a.description, a.image, a.facebook, a.twitter, a.linkedin from article a, ih_source s where s.id=a.source_id ";
            if ($category_id!='') {
                $sql .= " and s.category_id='$category_id' ";
            }

            $sql .= " and a.pub_at>='$t' ";

            $sql .= " order by a.facebook desc ";
//            $sql .= " limit 84 ";

            $query = $this->db->query($sql);
            $r = $query->result_array();
            if ($r) {
                foreach ($r as $row) {
                    $category_id = $row['category_id'];
                    if (isset($section_v_const[$category_id])) {
                        $row['category_name'] = $section_v_const[$category_id];
                        $row['title_background'] = $section_background_const[$category_id];
                    }

                    $row['comments'] = $this->utility_model->get_count('ih_comment', array('news_id'=>$row['id']));
                    $row['images'] = $this->utility_model->get_list('ih_news_image', array('news_id'=>$row['id']));

                    array_push($result, $row);
                }
            }
        }
        
        print_r(json_encode($result));
    }
    
    public function load_comment($news_id=''){
        $comments = array();
        $response = array('errCode'=>1);
        
        if ($news_id=='') {
            
        } else {
            $l = time();
            $t = mdate('%Y%m%d%H%i%s', $l);
            
            $news = $this->utility_model->get('article', array('id'=>$news_id));
            
            $source = $this->utility_model->get('source', array('id'=>$news['sourceId']));
            $source_name = "";
            
            
            
            if (isset($source['twitter']) && $source['twitter']!="") {
                $tt = explode("/", $source['twitter']);
                foreach ($tt as $row) {
                    $source_name = $row;
                }
            }

            

            $twitter_count =  0;
            
            if ($source_name!="") {
                $this->load->library('twitteroauth');
                $this->config->load('twitter');

                $twitter = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
                if ($twitter) {
                    $params = array(
                            'screen_name'=>$source_name,
                            'count'=>$twitter_count,
                            'exclude_replies'=>false
                        );

                    $r = $twitter->get('statuses/user_timeline', $params);
                    if ($r && is_array($r)) {
                        foreach ($r as $row) {
                            $item = array('screen'=>'', 'author'=>'', 'updated_at'=>'000000000000');
                            $item['created_at'] = isset($row->created_at) ? $row->created_at : "";
                            $item['content'] = isset($row->text) ? $row->text : "";
                            if (strpos($item['content'], "http://")>-1){
                                $item['content'] = substr($item['content'], 0, strpos($item['content'], "http://"));
                            }
                            if (strpos($item['content'], "https://")>-1){
                                $item['content'] = substr($item['content'], 0, strpos($item['content'], "https://"));
                            }

                            $item['link'] = array('name'=>'', 'url'=>'');
                            $item['media'] = array('type'=>'', 'url'=>'');

                            if (isset($row->entities)) {
                                $entities = $row->entities;
                                if (isset($entities->urls) && is_array($entities->urls)){
                                    foreach ($entities->urls as $row1) {
                                        $link_url = isset($row1->url) ? $row1->url : "";
                                        $link_name = isset($row1->display_url) ? $row1->display_url : "";

                                        if ($link_url!="" && $link_name!="" && $item['link']['url']=="" && $item['link']['name']=="") {
                                            $item['link']['url'] = $link_url;
                                            $item['link']['name'] = $link_name;
                                        }
                                    }
                                }

                                if (isset($entities->media) && is_array($entities->media)){
                                    foreach ($entities->media as $row1) {
                                        $link_url = isset($row1->media_url) ? $row1->media_url : "";
                                        $link_type = isset($row1->type) ? $row1->type : "";

                                        if ($link_url!="" && $link_name!="" && $item['media']['url']=="" && $item['media']['type']=="") {
                                            $item['media']['url'] = $link_url;
                                            $item['media']['type'] = $link_type;
                                        }
                                    }
                                }
                            }

                            if (isset($row->user)) {
                                $item['author'] = isset($row->user->name) ? $row->user->name : "";
                                $item['screen'] = isset($row->user->screen_name) ? $row->user->screen_name : "";
                            }

                            if ($item['created_at']!="") {
                                $date = new DateTime($item['created_at']);
                                $item['updated_at'] = $date->format('YmdHis');
                                $item['time'] = $this->utility_model->get_diff_time($item['updated_at'], $t);
                            }

                            array_push($comments, $item);
                        }
                    }
                } 
                
                uasort($comments, function($row1, $row2){
                    return strcmp($row1['updated_at'], $row2['updated_at']);
                });
            }
            
            $response['list'] = $comments;
            $response['errCode'] = 0;
        }
        
        print_r(json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    }
    
}
