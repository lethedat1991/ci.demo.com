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
        $this->load->view('login', $ad_data);
    }

    function login()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'User', 'required');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            $ad_data = array(
                'title' => "Đăng nhập không thành công do chưa điền đầy đủ thông tin vào !"
            );
            $this->load->view('login', $ad_data);
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
                $this->load->view('login', $users_err);
                return false;
            }
        }
    }

    function addplace()
    {
        $data['titlePage'] = 'Add A Place';

        $this->load->model("md_login");
        $data['category'] = $this->md_login->getcategory();

        $data['place_images'] = array();
        if (isset($this->request->post['place_image'])) {
            $place_images = $this->request->post['place_image'];
        } elseif (($this->uri->segment(3))) {
            $place_images = $this->md_login->get_imageall($this->uri->segment(3));
        } else {
            $place_images = array();
        }
        foreach ($place_images as $place_image) {
            $data['place_images'][] = array(
                'image' => $place_image['image'],
                'sort_order' => $place_image['sort_order']
            );
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        if (empty($_FILES['image']['name'])) {
            $this->form_validation->set_rules('image', 'Image', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = " Hãy nhập đầy đủ thông tin vào !";
            $this->load->view('addplace', $data);
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

            $this->md_login->insertplace($data_insert);
            $id_current = $this->db->insert_id();

            // Multi Images
            $img_array = array();
            $count = count($_FILES['userfile']['size']);
            foreach ($_FILES as $key => $value) {
                for ($s = 0; $s <= $count - 1; $s++) {
                    $_FILES['userfile']['name'] = $value['name'][$s];
                    $_FILES['userfile']['type'] = $value['type'][$s];
                    $_FILES['userfile']['tmp_name'] = $value['tmp_name'][$s];
                    $_FILES['userfile']['error'] = $value['error'][$s];
                    $_FILES['userfile']['size'] = $value['size'][$s];
                    $this->upload->do_upload();
                    $data_imgs = $this->upload->data();
                    $img_array[] = $data_imgs['file_name'];
                }
            }

            foreach ($img_array as $index => $data) {
                if ($data == $img_data['file_name']) {
                    unset($img_array[$index]);
                }
            }

            foreach ($img_array as $img) {
                $data_img = array(
                    "place_id" => $id_current,
                    "image" => 'pub/img/' . $img
                );
                $this->md_login->insertimage($data_img);
            };

            // Images Tab
//            $imgtab_array = array();
//            $count2 = count($_FILES['place_image']['size']);
//                for ($s = 0; $s <= $count2 - 1; $s++) {
//                    $_FILES['place_image'.'['.$s.']'.'[image]']['name'] = $_FILES['place_image']['name'][$s];
//                    $_FILES['place_image'.'['.$s.']'.'[image]']['type'] = $_FILES['place_image']['type'][$s];
//                    $_FILES['place_image'.'['.$s.']'.'[image]']['tmp_name'] = $_FILES['place_image']['tmp_name'][$s];
//                    $_FILES['place_image'.'['.$s.']'.'[image]']['error'] = $_FILES['place_image']['error'][$s];
//                    $_FILES['place_image'.'['.$s.']'.'[image]']['size'] = $_FILES['place_image']['size'][$s];
//                    $this->upload->do_upload('place_image'.'['.$s.'][image]');
//                    $data_imgs_place = $this->upload->data();
//                    $img_place_array[] = $data_imgs_place['file_name'];
//                }
//
//            var_dump($img_place_array) ; die;
//
//            foreach ($data['place_images'] as $place_imgs) {
//                $place_imgs = array(
//                    "place_id" => $id_current,
//                    "image" => 'pub/img/' . $place_imgs['image']
//                );
//                $this->md_login->insertimage($place_imgs);
//            };

            redirect(base_url() . "index.php/home");
            $this->load->view('addplace', $data);
        }
    }
}

?>