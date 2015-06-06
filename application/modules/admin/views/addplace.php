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
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/jquery-1.js'></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/tabs.js'></script>
    <script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
    <script type='text/javascript' src='<?php echo base_url(); ?>pub/js/view.js'></script>
</head>
<body>
<div class="header-wrapper">

    <div id="tabs" class="htabs">
        <a href="#tab-data">Place information</a> <a href="#tab-image">Place images</a>
    </div>
    <form action="<?php echo base_url(); ?>index.php/admin/login/addplace" method="POST" enctype="multipart/form-data">

        <div id="tab-data">
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
                <div class="place_info">
                    <label>Name:</label><input type="text" name="name" size="28" class="input"/>
                    <label>Image:</label><input type="file" name="image"/>
                    <label>Image Multi:</label><input type="file" name="userfile[]" id="userfile" multiple=""  />
                    <label>Description:</label> <textarea name="description" cols="40" rows="5"> </textarea>
                    <label>Longtitude:</label><input type="text" name="longitude" id="long" size="28" class="input"/>
                    <label>Lattitude:</label><input type="text" name="latitude" id="lat" size="28" class="input"/>
                    <label>Category:</label><select name="category_id">
                        <?php
                        foreach ($category as $cate) {
                            ?>
                            <option value="<?php echo $cate['id'] ?>"><?php echo $cate['name'] ?></option>
                        <?php } ?>
                    </select></br />
                    <label>&nbsp;</label><input type="submit" name="ok" value="Add Place" class="btn"/>
                </div>
                <div id="map"></div>

            </fieldset>
        </div>

        <div id="tab-image">
            <table id="images" class="list">
                <thead>
                <tr>
                    <td class="left">Image</td>
                    <td class="left">Upload</td>
                    <td class="right">Sort order</td>
                    <td></td>
                </tr>
                </thead>
                <?php $image_row = 0; ?>
                <?php foreach ($place_images as $place_image) { ?>
                    <tbody id="image-row<?php echo $image_row; ?>">
                    <tr>
                        <td class="left">
                            <img src="<?php echo $place_image['image']; ?>" />
                            <input type="hidden" name="place_image[<?php echo $image_row; ?>][image]" value="<?php echo $place_image['image']; ?>" />
                        </td>
                        <td class="left">
                            <input type="file" name="place_image[<?php echo $image_row; ?>][image]"/>
                        </td>
                        <td class="right">
                            <input type="text" name="place_image[<?php echo $image_row; ?>][sort_order]"
                                   value="<?php echo $place_image['sort_order']; ?>"
                                   size="2"/>
                        </td>
                        <td class="left">
                            <a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="button"> Remove </a>
                        </td>
                    </tr>
                    </tbody>
                    <?php $image_row++; ?>
                <?php } ?>
                <tfoot>
                <tr>
                    <td colspan="3"></td>
                    <td class="left">
                        <a onclick="addimage();" class="button">Add Image </a></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </form>

</div>
<script type="text/javascript">
    $('#tabs a').tabs();
</script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        (function () {
            window.onload = function () {
                // Creating a MapOptions object with the required properties
                var options = {
                    zoom: 15,
                    center: new google.maps.LatLng(20.991583, 105.848670),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                // Creating the map
                var map = new google.maps.Map(document.getElementById('map'), options);

                // Attaching click events to the buttons
                google.maps.event.addListener(map, "click", function (event) {
                    var lat = event.latLng.lat();
                    var lng = event.latLng.lng();
                    // populate yor box/field with lat, lng
                    alert("Lat=" + lat + "; Lng=" + lng);
                    $('#lat').val(lat);
                    $('#long').val(lng);
                });
            };
        })();
    });
</script>

<script type="text/javascript"><!--
    var image_row = <?php echo $image_row; ?>;
    function addimage(){
        html = '<tbody id="image-row' + image_row + '">';
        html += '  <tr>';
        html += '    <td class="left">' + 'Image ' + image_row + '<input type="hidden" name="place_image[' + image_row + '][image]" /></td>';
        html += '    <td class="left"><input type="file" name="place_image[' + image_row + '][image]" /></td>';
        html += '    <td class="right"><input type="text" name="place_image[' + image_row + '][sort_order]" value="" size="2" /></td>';
        html += '    <td class="left"><a onclick="$(\'#image-row' + image_row + '\').remove();" class="button">Remove</a></td>';
        html += '  </tr>';
        html += '</tbody>';

        $('#images tfoot').before(html);

        image_row++;
    }
    //--></script>
</body>
</html>