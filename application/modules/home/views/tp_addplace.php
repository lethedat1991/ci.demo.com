<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="Shortcut Icon" href="#" type="image/x-icon"/>
    <link href="<?php echo base_url('pub/css/add-css.css') ?>" rel="stylesheet"/>
</head>
<body>
<div class="header-wrapper">
    <form action="<?php echo base_url(); ?>index.php/home/addplace" method="POST" enctype="multipart/form-data"  id="categories">
        <?php
        echo "<div class='mess_error'>";
        echo "<ul>";
        if (validation_errors() != '') {
            echo "<li>" . validation_errors() . "</li>";
        }
        echo "</ul>";
        echo "</div>";
        ?>
        <fieldset class="show">
            <legend align="center">Place Infomations</legend>
            <label>Name:</label><input type="text" name="name" size="28" class="input"/>
            <label>Image:</label><input type="file" name="image" />
            <label>Description:</label> <textarea name="description" cols="40" rows="5"> </textarea>
            <label>Longtitude:</label><input type="text" name="longitude" size="28" class="input"/>
            <label>Lattitude:</label><input type="text" name="latitude" size="28" class="input"/>
            <label>Category:</label><select name="category_id">
                <?php
                foreach ($category as $cate){?>
                    <option value="<?php echo $cate['id'] ?>"><?php echo $cate['name'] ?></option>
                <?php  } ?>
            </select></br />
            <label>&nbsp;</label><input type="submit" name="ok" value="Add Place" class="btn"/>
        </fieldset>
    </form>

</div>
</body>
</html>