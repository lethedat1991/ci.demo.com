<div class="content_detail">
    <ul class="pgwSlider">
        <?php foreach($images as $img) { ?>
            <li>
                <img src="<?php echo base_url().$img['image'] ?>">
            </li>
        <?php } ?>
    </ul>
    <div style="clear: both"></div>
    <div class="place_name"><?php echo $info['name'] ?></div>
    <div class="place_description"><?php echo $info['description'] ?></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.pgwSlider').pgwSlider();
    });
</script>