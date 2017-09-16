<?php
if (!defined("PATH_SYSTEM")) die("Bad Requested");
function showCategories($categories, $parent_id = 0, $char = '',$username)
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $cate_child = array();
    /** @var  $item Category*/
foreach ($categories as $key => $item)
    {
        // Nếu là chuyên mục con thì hiển thị
        if ($item->getParentId() == $parent_id)
        {
            $cate_child[] = $item;
            unset($categories[$key]);
        }
    }

    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_child){

        if ($parent_id == 0) { ?>
        <ul id="nav">
            <li><a href="<?=base_url()?>"><span class="glyphicon glyphicon-home"></span> TrangChủ</a></li>
            <?php if ($username) { ?>
                <li id="management" style="float: right">
                    <a style="padding: 18px 30px ;">
                        <span class="glyphicon glyphicon-user"></span> <?= $username ?>
                    </a>
                    <div class="sub_menu" style="min-width: 119px;">
                        <ul>
                            <li><a href="<?= base_url("management/") ?>">
                                    <span class="glyphicon glyphicon-home"></span> Quản Lý </a>
                            </li>
                            <li><a href="<?= base_url("user/logout/") ?>">
                                    <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                            </li>
                            <li><a href="<?= base_url("user/profile/") ?>">
                                    <span class="glyphicon glyphicon-user"></span> Profile</a>
                            </li>
                        </ul>
                    </div>
                <li>
            <?php } else { ?>
                <li id="management" style="float: right">
                    <a href="<?= base_url("user/sign/") ?>">
                        <span class="glyphicon glyphicon-user"></span> Sign</a>
                </li>
                <li id="logout" style="float: right">
                    <a href="#mymodal" data-toggle="modal">
                        <span class="glyphicon glyphicon-log-in"></span> Login</a>
                </li>
            <?php }
            /** @var  $item Category*/
            foreach ($cate_child as $key => $item) {
                // Hiển thị tiêu đề chuyên mục
                echo '<li><a href="#">' . $item->getTitle() . '</a>';
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                showCategories($categories, $item->getId(), $char, $username);
                echo '</li>';
            }
        }else{ ?>

        <div class="sub_menu">
            <ul>
             <?php foreach ($cate_child as $key => $item) {
                // Hiển thị tiêu đề chuyên mục

                echo '<li><a href="'.base_url(alias($item->getTitle()." ".$item->getId())).'/">' . $item->getTitle() . '</a>';

                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                showCategories($categories, $item->getId(), $char, $username);
                echo '</li>';
            } ?>
            </ul>
        </div>
        <?php }
    }
}?>

<div class="row" id="desktop_menu">
    <div class="nav_bar">
        <?php
            showCategories($categories,0,'',$username);
        ?>
    </div>
</div>


