<?php

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $ad_data = array(
            'title' => "Demo Login CodeIgniter  "
        );
        $this->load->view('tp_login', $ad_data);
    }

    function hethong()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'User', 'required');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            $ad_data = array(
                'title' => "Đăng nhập không thành công do chưa điền đầy đủ thông tin vào !"
            );
            $this->load->view('tp_login', $ad_data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $this->load->model('md_login'); // Call login model
            $query = $this->md_login->login($username, $password);
            if ($query) {
                foreach ($query as $row) {
                    $newdata = array(
                        'id' => $row->id,
                        'username' => $row->username
                    );
                    $this->session->set_userdata($newdata); // Tạo Session cho Users
                    redirect('home.html');
                }
                return TRUE;
            } else {
                $users_err = array(
                    'title' => "Đăng nhập không thành công vào hệ thống website !",
                    'error_login' => "Tên đăng nhập hoặc Mật khẩu nhập sai."
                );
                $this->load->view('tp_login', $users_err);
                return false;
            }
        }
    }
}

?>