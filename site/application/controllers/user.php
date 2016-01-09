<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $language = $this->session->userdata('language');
        $language = !$language || $language=='' ? 'english' : $language ;
        
        $this->lang->load('common', $language);
        $this->lang->load('interface', $language);

        $this->load->model('user_model');
        $this->load->model('utility_model');
    }
    
    /**
     * User registeration Page.
     */
    public function register() {
        $page_data['page_name'] = 'register';
        $this->load->view('register', $page_data);
    }

    /**
     * Login Page.
     */
    public function login() {
        $page_data['page_name'] = 'login';
        $page_data['login_email'] = '';
        $this->load->view('login', $page_data);
    }

    /**
     * Logout Page.
     */
    public function logout() {
        $this->session->unset_userdata('front_user');
        $this->session->unset_userdata('front_email');
        redirect(base_url() . "welcome/index.html");
    }

    public function profile() {
        $user_id = $this->session->userdata('front_user');
        $result = $this->user_model->get_user__by_id($user_id);
        $page_data['page_name'] = 'profile';
        $page_data['account'] = $result;
        $page_data['user_subscribe'] = "";
        
        $subscribe = $this->utility_model->get('ih_subscribe', array('email'=>$result['email']));
        if ($subscribe) {
            $page_data['user_subscribe'] = 'remove';
        }
        
        $this->load->view('profile', $page_data);
    }
    
    
    /**
     * SIgnin.
     * if valid, move to firstpage.  
     * others, refresh Login page.
     */
    public function signin() {
        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');

        $result = $this->user_model->get($email);
        if ($result) {
            if ($result['password'] != sha1($password . PASSWORD)) {
                $this->session->set_userdata('message', "Wrong Password");
            } else {
                $subscribe = $this->utility_model->get('ih_subscribe', array('email'=>$email));
                if ($subscribe) {
                    $this->session->set_userdata('subscribe', 'remove');
                }
                
                $this->session->set_userdata('front_user', $result['id']);
                $this->session->set_userdata('front_email', $result['email']);

                redirect(base_url() . "welcome/index.html");
            }
        } else {
            $this->session->set_userdata('message', "Invalid Email Address!");
        }

        $page_data['page_name'] = 'login';
        $page_data['login_email'] = $email;
        $this->load->view('login', $page_data);
    }
    
    /**
     * Create User.
     * if success, move to Login page.
     * others, refresh Register Page.
     */
    public function signup() {
        $t = mdate('%Y%m%d%H%i%s', time());
        
        $username = $this->input->get_post('username');
        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');
        $password2 = $this->input->get_post('password2');

        $ret=false;
        $result = $this->user_model->get($email);
        if ($result) {
            $this->session->set_userdata('message', 'Already Exist!');
        } else {
            if ($password!=$password2){
                $this->session->set_userdata('message', 'Wrong Password!');
            } else {
                $data = array('name' => $username, 'email' => $email, 'password' => sha1($password . PASSWORD) , 'created_at'=>$t, 'updated_at'=>$t );

                if ($this->user_model->insert_user($data)) {
                    $user_id = mysql_insert_id();

                    $this->session->set_userdata('message', 'Successfully Created!');
                    $ret = true;
                } else {
                    $this->session->set_userdata('message', 'Failed to Create!');
                }
            }
        }
        
        if ($ret){
//            $this->load->library('uuid');
//            $uu_id = $this->uuid->v4();
//            
//            $config = array(
//                "protocol" => "smtp",
//                "smtp_host" => "ssl://smtp.gmail.com",
//                "smtp_port" => 465,
//                "smtp_user" => "jinhechen124@gmail.com",
//                "smtp_pass" => "aifakftys19881204",
//                "_smtp_auth"=> TRUE
//            );
//            
//            $this->load->library('email', $config);
//            $this->email->initialize($config);
//            $this->email->set_newline("\r\n");
//
//            $this->email->from('jinhechen124@gmail.com', 'support');
//            $this->email->to($email);
//            $this->email->subject("Email Activation");
//            $this->email->message('Please click this url.    ' . base_url() . "user/activate.html?uuid=" . $uu_id . "&email=" . $email . "&kind=1");
//
//            $ret = $this->email->send();
//            if ($ret){
//                $data = array('kind' => '1', 'email' => $email, 'uu_id' => $uu_id, 'time' => mdate('%Y%m%d%H%i%s', time()));
//                $this->user_model->insert_verify($data);
////                $this->utility_model->insert('cl_activate', array('uu_id'=>$uu_id, 'email'=>$email, 'kind'=>'1'));
//            }
//                
//            $page_data['page_name'] = 'login';
//            $page_data['login_email'] = $email;
//            $page_data['facebook_url'] = '';
//            $this->load->view('verify', $page_data);
            
            $this->session->set_userdata('message', 'Successfully Created!');
            redirect(base_url() . "user/login.html");
        }else{
            redirect(base_url() . "user/register.html");
        }
    }
    
    public function update_profile() {
        $t = mdate('%Y%m%d%H%i%s', time());
        
        $username = $this->input->get_post('username');
        $email = $this->input->get_post('email');
        $password1 = $this->input->get_post('password1');
        $password = $this->input->get_post('password');
        $password2 = $this->input->get_post('password2');

        $user_id = $this->session->userdata('front_user');
        $rrr = $this->user_model->get_user__by_id($user_id);

        $bRet = false;
        
        if ($rrr) {
            $result = $this->user_model->get($email);
            if ($result) {
                if ($result['id']!=$user_id) {
                    $this->session->set_userdata('message', 'Already Exist!');
                } else {
                    $bRet = true;
                }
            } else {
                $bRet = true;
            }
            
            if ($bRet) {
                if ($password!=$password2){
                    $this->session->set_userdata('message', 'Wrong Password!');
                } else if ($rrr['password']!= sha1($password1 . PASSWORD)) {
                    $this->session->set_userdata('message', 'Wrong Password!');
                } else {
                    $data = array('name' => $username, 'email' => $email, 'password' => sha1($password . PASSWORD) , 'updated_at'=>$t );

                    if ($this->user_model->update_user($user_id,  $data)) {
                        $this->session->set_userdata('message', 'Successfully Updated!');
                        $bRet = true;
                    } else {
                        $this->session->set_userdata('message', 'Failed to Update!');
                    }
                }
            }
        }
        
        redirect(base_url() . "user/profile.html");
    }
    
    
}
