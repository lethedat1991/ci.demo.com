<?php

class Home extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
    }

    function index()
    {
        $home = array(
            'title' => "List Place",
        );
        // Load the library
        $this->load->library('googlemaps');
        // Load our model
        $this->load->model('md_map', '', TRUE);
        // Initialize the map, passing through any parameters
        $config['center'] = 'auto';
        $config['zoom'] = "14";
        $config['places'] = TRUE;
        $config['sensor'] = TRUE;
        $config['directions'] = TRUE;

        $config['directionsStart'] = 'auto';
        $config['directionsEnd'] =  '20.991583,105.848670';
        $config['directionsDivID'] = 'directionsDiv';
        $config['directionsMode'] = 'WALKING';

        $config['placesLocation'] = 'auto';
        $config['placesTypes'] = array("restaurant","food","atm","bank","airport");
        $config['placesRadius'] = 200;

        $this->googlemaps->initialize($config);
        // Get the co-ordinates from the database using our model
        $coords = $this->md_map->get_coordinates();
        // Loop through the coordinates we obtained above and add them to the map
        foreach ($coords as $coordinate) {
            $marker = array();
            $marker['position'] = $coordinate->longitude . ',' . $coordinate->latitude;
            $marker['title'] = $coordinate->name;
            $marker['icon'] = base_url() . $coordinate->image;
            $id = $coordinate-> id;
            $description_intro = mb_substr(strip_tags(html_entity_decode($coordinate->description, ENT_QUOTES, 'UTF-8')), 0, 30)."...";
            $img_place = $this->md_map->get_image($coordinate->id);
            if (!empty($img_place)) {
                $information = "<img class =\"thumb_map\" src=" . base_url() . $img_place->image . "> <a class=\"view_more\" href = ".base_url() ."index.php/home/detail/$id >".
                    " <img class =\"view\" src=" . base_url() . "pub/img/view-more.png" .">"."<h3>VIEW MORE</h3>"." </a><br> <b>" .
                    $coordinate->name . "</b><br>" . $description_intro ;
            } else {
                $information = "<img class =\"thumb_map\" src=" . base_url() . $coordinate->image . "> <a class=\"view_more\" href = ".base_url() ."index.php/home/detail/$id >".
                    " <img class =\"view\" src=" . base_url() . "pub/img/view-more.png" .">"."<h3>VIEW MORE</h3>"." </a><br> <b>" .
                    $coordinate->name . "</b><br>" . $description_intro;
            }
            $marker['infowindow_content'] = $information;
            $this->googlemaps->add_marker($marker);
        }

        // Create the map
        $home['map'] = $this->googlemaps->create_map();
        // Load our view, passing through the map data

        $this->template->write_view("content","index",$home);
        $this->template->render();

    }

    function detail($id){
        $place['title'] = "Place Detail";
        $this->load->model('md_map');
        $place['info'] = $this->md_map->get_place($id);
        $place['images'] = $this->md_map->get_imageall($id);
        $this->template->write_view("content","detail",$place);
        $this->template->render();
    }

    function addplace()
    {
        $data['titlePage'] = 'Add A Place';
        $this->load->model("md_map");
        $data['category'] = $this->md_map->getcategory();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_rules('image', 'Image', 'required');
        }

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
            $img_data = "";
            if ($_FILES['image']['name'] != NULL) {
                $config['upload_path'] = './pub/img/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '50000';
                $config['max_width'] = '2000';
                $config['max_height'] = '2000';
                $config['encrypt_name'] = true; // ma hoa ten file
                $config['remove_spaces'] = true; // xoa khoang trang

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload("image")) {
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view("tp_addplace", $data);
                } else {
                    $img_data = $this->upload->data();
                    $config = array("source_image" => $img_data['full_path'],
                        "new_image" => "./pub/img",
                        "maintain_ration" => true,
                        "width" => '80',
                        "height" => "60");
                    $this->load->library("image_lib", $config);
                    $this->image_lib->resize();
                    //kết thúc công đoạn resize lại hình ảnh
                    $data_insert['image'] = 'pub/img/' . $img_data['file_name'];
                }
            }

            $this->md_map->insertplace($data_insert);
            redirect(base_url() . "index.php/home");
            $this->load->view('tp_addplace', $data);
        }
    }


}

?>