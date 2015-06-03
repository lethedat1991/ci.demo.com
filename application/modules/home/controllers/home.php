<?php

class Home extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('upload');
    }

    function index()
    {
        $home = array(
            'title' => "Home || Demo Login CodeIgniter "
        );

        // Load the library
        $this->load->library('googlemaps');
        // Load our model
        $this->load->model('md_map', '', TRUE);
        // Initialize the map, passing through any parameters
        $config['center'] = '20.997593, 105.854829';
        $config['zoom'] = "14";
        $this->googlemaps->initialize($config);
        // Get the co-ordinates from the database using our model
        $coords = $this->md_map->get_coordinates();
        // Loop through the coordinates we obtained above and add them to the map
        foreach ($coords as $coordinate) {
            $marker = array();
            $marker['position'] = $coordinate->longitude . ',' . $coordinate->latitude;
            $marker['title'] = $coordinate->name;
            $marker['icon'] = base_url() . $coordinate->image;

            $img_place = $this->md_map->get_image($coordinate->id);
            $information = "<img src=" . base_url() . $img_place->image . "> <br> <b>" . $coordinate->name . "</b><br>" . $coordinate->description;
            $marker['infowindow_content'] = $information;
            $this->googlemaps->add_marker($marker);
        }
        // Create the map
        $home['map'] = $this->googlemaps->create_map();
        // Load our view, passing through the map data

        $this->load->view('tp_home', $home);

    }

    function addplace()
    {
        $data['titlePage'] = 'Add A Place';
        $data['subview'] = 'home/addplace';
        $this->load->model("md_map");
        $data['category'] = $this->md_map->getcategory();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
//        $this->form_validation->set_rules('image', 'Image', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = " Hãy nhập đầy đủ thông tin vào !";
            $this->load->view('tp_addplace', $data);
        } else {

            $data_insert = array(
                "category_id" => $this->input->post("category_id"),
                "name" => $this->input->post("name"),
                "description" => $this->input->post("description"),
                "longitude" => $this->input->post("longitude"),
                "latitude" => $this->input->post("latitude"),
            );

            //--- Xử lý ảnh
            $img = "";
            var_dump($_FILES['image']['name']);
            if ($_FILES['image']['name'] != NULL) {
                $config['upload_path'] =  $_SERVER['DOCUMENT_ROOT'].'/pub/img/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '50000';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';
                $config['encrypt_name'] = true; // ma hoa ten file
                $config['remove_spaces'] = true; // xoa khoang trang
                var_dump($this->upload->do_upload("image"));
                var_dump($this->upload->display_errors());
                var_dump($config);
                if (!$this->upload->do_upload("image")) {
                   $data['error'] = $this->upload->display_errors();
                    $this->load->view("tp_addplace", $data);
                    echo "Errr";
                } else {
                    $img = $this->upload->data();
                    echo "AAAAA";
                    $data_insert['image'] = $img['file_name'];
                }
            }

            $this->md_map->insertplace($data_insert);
            redirect(base_url() . "index.php/home");
            $this->load->view('tp_addplace', $data);
        }
    }

}

?>