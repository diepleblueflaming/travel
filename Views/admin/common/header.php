<div class="col-xs-12" id="header">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9">
            <a href="<?php echo base_url("admin/homeCtr/")?>"><span class="glyphicon glyphicon-user"> </span>
                Administrator</a>
        </div>
        <?php
        if ($userName) { ?>
            <div class="col-xs-12 col-sm-3 col-md-3" id="user_name">
                <?=$userName?> &nbsp;
                <a href="<?=base_url("admin/homeCtr/logout/")?>">
                    <span class="glyphicon glyphicon-log-out"></span>
                </a>
            </div>
        <?php }; ?>
    </div>
</div>
