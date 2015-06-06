<?php


class Md_category extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_category($parent = 0)
    {
        $this->db->where('parent_id',$parent);
        $query = $this->db->get('tbl_category');
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function get_subcategory($category_id)
    {
        $this->db->where('parent_id',$category_id);
        $query = $this->db->get('tbl_category');
        if($query->result())
        {
            return $query->result();
        }else{
            return FALSE;
        }

    }
}