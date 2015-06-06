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

    function insertplace($data_insert){
        $this->db->insert('tbl_place',$data_insert);
    }

    function insertimage($data_insert){
        $this->db->insert('tbl_image',$data_insert);
    }

    function get_imageall($place_id)
    {
        $this->db->select("image");
        $this->db->where('place_id', $place_id);
        $this->db->from("tbl_image");
        $query = $this->db->get();
        return $query->result_array();
    }

    function getcategory(){
        $this->db->select('id,name');
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }
}

?>