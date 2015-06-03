<?php

/**
 * Created by Admin.
 * Date: 03/06/2015
 * Time: 11:23
 *
 * @name : ${NAME}
 */
class Md_map extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_coordinates()
    {
        $return = array();
        $this->db->select("id, longitude,latitude,name,description,image");
        $this->db->from("tbl_place");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($return, $row);
            }
        }
        return $return;
    }

    function get_image($place_id)
    {
        $this->db->select("image");
        $this->db->where('place_id', $place_id);
        $this->db->order_by("image", 'RANDOM');
        $this->db->from("tbl_image");
        $query = $this->db->get();
        return $query->first_row();
    }

    function insertplace($data_insert){
        $this->db->insert('tbl_place',$data_insert);
    }

    function getcategory(){
        $this->db->select('id,name');
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }
}
