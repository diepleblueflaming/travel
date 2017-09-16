<div class="row comment clearfix" id="tool">
    <div class="col-xs-6 col-sm-6 col-md-2" id="<?=$module?>">
        <select class="form-control" id="action">
            <option>Tác vụ</option>
            <option>Delete Selected</option>
        </select>
    </div>

    <div class="col-md-offset-4 col-xs-12 col-sm-12 col-md-6" id="div_search">
        <div class="row">
            <form action="" method="post" id="form_search">
                <div class="col-xs-4 col-sm-4">
                    <select class="form-control" name="field" id="field_search">
                        <option value="">Tìm Kiếm Theo</option>
                        <option value="content">Nội Dung</option>
                        <option value="user_comment">Người Bình Luận</option>
                        <option value="news_comment">Bài Viết</option>
                    </select>
                </div>
                <div class="col-xs-8 col-sm-8">
                    <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm" id="key_search">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row table-responsive" id="table_container">
    <table class="table table-bordered table-hover" id="tab-content">
    <thead>
    <th><input type="checkbox" id="check_all"></th>
    <form action="<?php base_url("admin/commentCtr/")?>" method="post" id="form_sort">
        <input type="hidden" name="field" value="" id="input_sort">
        <input type="hidden" name="type" value="" id="input_type">
    </form>
    <th><a class="field_sort <?=get_sort("id")?>" id="id">Id</a></th>
    <th>Nội Dung</th>
    <th><a class="field_sort <?=get_sort("date_create")?>" id="date_create"> Ngày Đăng </a></th>
    <th><a class="field_sort <?=get_sort("user_comment")?>" id="user_comment"> Người Bình Luận </a></th>
    <th><a class="field_sort <?=get_sort("news_comment")?>" id="news_comment"> Bài Viết Bình Luận </a></th>
    <th><a class="field_sort <?=get_sort("status")?>" id="status"> Trang Thái </a></th>
    <th>Delete</th>
    </thead>
    <tbody>
    <?php
    if ($list) {
        /**
         * @var  $key
         * @var  $val Comment
         */
        foreach ($list as $key => $val) {
            echo '<tr>';
            echo '<td><input name="check[]" type="checkbox" value="' . $val->getId() . '"></td>';
            echo '<td>' . $val->getId() . '</td>';
            echo '<td>' . $val->getContent() . '</td>';
            echo '<td>' . $val->getDateCreate() . '</td>';
            echo '<td>' . $val->getUserComment() . '</td>';
            echo '<td>' . $val->getNewsComment() . '</td>';
            if ($val->getStatus() == 1)
                $a = " Bỏ Duyệt";
            else
                $a = "Duyệt";
            echo '<td> <input type="button" id="' . $val->getId() . '" class="btn btn-default censor"
                    value="' . $a . '"></td>'; ?>
            <td>
                <form action="<?php echo base_url("admin/commentCtr/delete/") ?>" method="post"
                      class="form_del">
                    <input type="hidden" name="comment_del" value="<?php echo $val->getId(); ?>">
                    <a href="" class="a_del"><span class="glyphicon glyphicon-remove">
                            </span></a></form>
            </td>
        </tr>
        <?php }
    }
    ?>
    </tbody>
    </table>
</div>
