<link rel="stylesheet" href="<?=base_url("library/css/mobile_menu.css")?>">
<div class="container-fluid" id="mobile_menu">
    <div class="row">
        <div class="panel-group">
            <?php quay_lui($categories, 0)?>
        </div>
    </div>
</div>
<?php
    function quay_lui($categories, $parent_id){ ?>
        <?php /** @var  $it \Category*/ foreach ($categories as $it){
            if($it->getParentId() == $parent_id) {
                $check = get_child($categories, $it->getId())
                ?>
                <div class="panel panel-default" style="<?= !$check ? "margin-left : 56px" : ''?>">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <?php if($check) { ?>
                                <a data-toggle="collapse" href="#collapse_<?=$it->getId()?>">
                                    <i class="glyphicon glyphicon-menu-right" id="separate"></i><?=$it->getTitle()?></a>
                            <?php }else{ ?>
                                <a href="<?=base_url(alias($it->getTitle()." ".$it->getId())."/")?>"><?=$it->getTitle()?></a>
                            <?php } ?>
                        </h4>
                    </div>
                    <?php if($check) { ?>
                        <div id="collapse_<?=$it->getId()?>" class="panel-collapse collapse">
                            <?php quay_lui($categories, $it->getId())?>
                        </div>
                    <?php } ?>
                </div>
        <?php }
        }
    }

    function get_child($categories, $parent_id){
        return (array_filter($categories, function ($it) use ($parent_id){
            return $it->getParentId() == $parent_id;
        }) != []);
    }
 ?>

