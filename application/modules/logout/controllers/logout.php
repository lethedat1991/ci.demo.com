<?php
class Logout extends CI_Controller {
//constructor
    function __construct()
        {
            parent::__construct();
        }
    function index() {
        $this->session->sess_destroy();
        $data['title']='Bạn đã thoát khỏi hệ thống ! Xin mời đăng nhập để vào hệ thống';       
        $this->load->view('login/tp_login',$data);
        }
}
?>