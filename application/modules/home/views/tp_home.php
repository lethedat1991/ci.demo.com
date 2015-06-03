<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?></title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta name="description" content="" />
<meta name="keywords" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>	
<link rel="Shortcut Icon" href="#" type="image/x-icon" />	
<link href="<?php echo base_url('pub/css/home-css.css') ?>" rel="stylesheet" />
    <?php echo $map['js']; ?>
</head>
<body>
    <div class="header-wrapper">
        <div class="ct-wrapper">
            <div class="home_demo">
                <div class="ct_demo">
                    <p>Chào bạn :<strong style="color: red;"><?php echo $this->session->userdata('username'); ?></strong>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="logout" href="<?php echo base_url('logout.html') ?>" style="color: black;">LOGOUT</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="logout" href="<?php echo base_url('home/addplace') ?>" style="color: black;">Add Place</a>
                    </p>
                    <p>Bạn vừa đăng nhập vào hệ thống , xin vui lòng lựa chọn :</p>
                    <h1>DEMO - Login CodeIgniter  </h1>
                    <?php echo $map['html']; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>