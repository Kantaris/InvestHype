<?php
$basePath = base_url();
$resPath = $basePath . "resource/";
$pluginPath = $resPath . "plugins/";
$imagePath = $resPath . "images/";
$stylePath = $resPath . "layout/css/";
$scriptPath = $resPath . "scripts/";

$message = '';
$language = "english";
$subscribe = "";

$front_userid = "";

if ($this->session->userdata('message')){
    $message = $this->session->userdata('message');
    $this->session->set_userdata('message', '');
}

if ($this->session->userdata('language')){
    $language = $this->session->userdata('language');
}

if ($this->session->userdata('front_user')){
    $front_userid = $this->session->userdata('front_user');
}

if ($this->session->userdata('subscribe')){
    $subscribe = $this->session->userdata('subscribe');
}
