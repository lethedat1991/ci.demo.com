<?php

class Md_login extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function login($username, $password)
    {
        $this->db->select('id, username, password');
        $this->db->from('tbl_user');
        $this->db->where('username', $username);
        $this->db->where('password', sha1($password));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>