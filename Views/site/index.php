<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?php echo base_url("public/icon/favicon.png")?>"/>
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="<?php echo base_url("library/js/jquery-1.10.2.min.js")?>" type="text/javascript"></script>
        <script src="<?php echo base_url("library/js/jquery.als-1.7.min.js")?>" type="text/javascript"></script>
        <script src="<?php echo base_url("library/js/bootstrap.min.js")?>" type="text/javascript"></script>
        <script src="<?php echo base_url("library/js/common.js")?>" type="text/javascript"></script>
        <script src="<?php echo base_url("library/js/user.js")?>" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url("library/css/bootstrap.min.css")?>">
        <script src="<?php echo base_url("library/ckeditor/ckeditor.js")?>" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo base_url("library/css/common.css")?>" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url("library/css/style_hover_img.css")?>" type="text/css" />
    </head>
    <body data-target=".nav_bar" data-offset="50px" data-spy="scroll">

    <!--header of this document -->
    <div class="container-fluid">
        <!-- include phan banner va header -->
        <?php $this->load_view("site/common/banner")?>
        <?php $this->load_view("site/common/menu")?>
        <?php $this->load_view("site/common/mobile_menu")?>
        <!-- include giao dien con -->
        <div id="main_view">
            <?php $this->load_view($subView)?>
        </div>

        <!-- include footer -->
        <?php $this->load_view("site/common/footer")?>
    </div>

    <!-- end of div container -->
    <div id="back_to_top">
        <a ><img id="scroll" src="<?php echo base_url("public/images/top.png")?>"></a>
    </div>

    <!-- include form đăng nhập -->
    <?php $this->load_view("site/home/login")?>
    <!-- include form contact -->
    <?php //$this->load_view("site/home/contact")?>
    </body>
</html>
