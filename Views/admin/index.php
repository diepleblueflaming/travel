<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/18/2016
 * Time: 2:40 PM
 */
if (!defined("PATH_SYSTEM")) die("Bad Requested");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?php echo base_url("public/icon/favicon.png")?>"/>
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url("library/css/bootstrap.min.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("library/css/admin/header.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("library/css/admin/common.css")?>">
    <script src="<?php echo base_url("library/js/jquery-1.10.2.min.js")?>" type="text/javascript"></script>
    <script src="<?php echo base_url("library/js/bootstrap.min.js")?>" type="application/javascript"></script>
    <script src="<?php echo base_url("library/ckeditor/ckeditor.js")?>" type="application/javascript"></script>
    <script src="<?php echo base_url("library/js/custom_admin.js")?>" type="text/javascript"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <?php
            if($subView!="admin/home/login"){
                $this->load_view("admin/common/nav-bar");
            }
        ?>
        <!--body of this document -->
        <div class="col-sx-12 col-sm-12 col-md-10" id="main_container">
            <!--header of this document -->
            <?php $this->load_view("admin/common/header"); ?>

            <?php $this->load_view($subView); ?>
            <?php if(isset($pagination))
                echo "<div class='text-center'>".$pagination->html()."</div>";?>
        </div>
        <!--navigation of this document -->
    </div>
</div>
<!--footer of this document -->
</body>
</html>