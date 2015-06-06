<script type="text/javascript">
    $(document).ready(function () {
        $('div#box-category').hover(
            function () {
                $('div#box-category > #cssmenu').show();
            },
            function () {
                $('div#box-category > #cssmenu').hide();
            }
        )
    });
</script>
<div id="logo">
    <a href="<?php echo base_url() ?>home.html">
        <img src="/pub/img/logo-dai.png">
    </a>
</div>
<div id="box-category">
    <h3>Category
        <img src="/pub/img/down-select.png">
    </h3>
    <div id="cssmenu">
        <?php echo $menu; ?>
    </div>
</div>
<div id="search">
    <input type="text" value="" placeholder="Search" name="search">
    <div class="button-search"></div>
</div>
