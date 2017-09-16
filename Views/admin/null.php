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
    <link rel="stylesheet" href="<?php echo base_url("library/css/admin/common.css")?>">
    <script src="<?php echo base_url("library/js/jquery-1.10.2.min.js")?>" type="text/javascript"></script>
    <script src="<?php echo base_url("library/js/bootstrap.min.js")?>" type="text/javascript"></script>
</head>
<body>

<div class="container-fluid">
    <?=$this->load_view($subView)?>
</div>
<!--footer of this document -->
</body>
</html>