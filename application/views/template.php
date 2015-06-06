<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="Shortcut Icon" href="#" type="image/x-icon"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>pub/css/style.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>pub/css/menu.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>pub/css/pgwslider.css"/>
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/jquery.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/menu_jquery.js'></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/pgwslider.js'></script>
</head>
<body>
<div class="wrapper">
    <div id="top">
        <?php echo modules::run('header/index'); ?>
    </div>
    <div id="main">
        <div id="info">
            <?php echo $content; ?>
        </div>
    </div>
</div>
</body>
</html>