<?php

class Header extends MX_Controller
{
//constructor
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->model("md_map");
        $data['menu']  = $this->get_category();
        $this->load->view('index',$data);
    }

    function get_category()
    {
        $str = "";
        $this->load->model('md_category');
        $categorys  =   $this->md_category->get_category();
        $str .= "<ul>";
        foreach ($categorys as $category)
        {
            $str .= "<li class='has-sub'>";
            $str .= "<a href='#'><span>".$category->name."</span></a>";
            $str .= $this->get_subcategory($category->id,$i = 0);
            $str .= "</li>";

        }
        $str .= "</ul>";
        return $str;
    }
    function get_subcategory($category_ids,$i = 0)
    {
        $str = "";
        $sub_categorys  =   $this->md_category->get_subcategory($category_ids);
        //kiem tra get subcategory co ton ai hay
        if($sub_categorys){
            $str .= "<ul>";
            foreach ($sub_categorys as $sub_category)
            {
                //kiem tra con parent hay ko
                $str .= "<li class='".$this->check_parent_menu($sub_category->id)."'>";
                $str .= "<a href='#'><span>".$sub_category->name."</span></a>";
                if($sub_category->id)
                {
                    $str .= $this->get_subcategory($sub_category->id,$i++);
                }
                $str .= "</li>";

            }
            $str .= "</ul>";
        }
        return $str;
    }
    function check_parent_menu($category_id)
    {
        $this->load->model('md_category');
        if($this->md_category->get_subcategory($category_id)){
            $str = "has-sub";
        }else{
            $str = "last";
        }
        return $str;
    }

}

?>