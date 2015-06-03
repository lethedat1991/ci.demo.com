<?php
class MY_Controller extends CI_Controller 
    {
        function __construct()
        {
            parent::__construct(); 
            $url_fresh = array(
                'url_now' => $_SERVER['PHP_SELF']
            );           
            $this->session->set_userdata($url_fresh);
            if (!$this->session->userdata('username'))
                {
                    redirect('login.html');
                }        
        }
    }
?>