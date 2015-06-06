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
<link href="<?php echo base_url('pub/css/login-css.css') ?>" rel="stylesheet" />
</head>
<body style="background: #3883cc;">
    <div class="ad_container">
        <form id="customForm" action="<?php echo base_url('login/hethong'); ?>" method="post"  class="login" > 
                <h1 class="login-title">ĐĂNG NHẬP HỆ THỐNG</h1>
                <input id="username" type="text" name="username" class="login-input" placeholder="Username"/>
                <?php echo form_error('username'); ?>
                <input id="password" type="password" name="password" class="login-input" placeholder="Password"/>
                <?php echo form_error('password'); ?>
                <input type="submit" value="Lets Go" class="login-button"/>
                <p class="p_error"><?php if(isset($error_login)) { echo $error_login;} ?></p>      
        </form>
    </div>
</body>
</html>