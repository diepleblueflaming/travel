<div class="row category clearfix" id="tool">
    <div class="col-xs-6 col-sm-6 col-md-2" id="<?=$module?>">
        <select class="form-control" id="action">
            <option>Tác vụ</option>
            <option>Delete Selected</option>
        </select>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-2">
        <button type="button" class="btn btn-primary" name="btn-category-add" id="btn-submit-categoryCtr">
            <span class="glyphicon glyphicon-plus"></span> Thêm Mới </button>
    </div>
    <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-6" id="div_search">
        <div class="row">
            <form action="" method="post" id="form_search">
                <div class="col-xs-4 col-sm-4">
                    <select class="form-control" name="field" id="field_search">
                        <option value="">Tìm Kiếm Theo</option>
                        <option value="title">Tiêu Đề</option>
                        <option value="category">Chuyên Mục Cha</option>
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
    <form action="<?php base_url("admin/categoryCtr/")?>" method="post" id="form_sort">
        <input type="hidden" name="field" value="" id="input_sort">
        <input type="hidden" name="type" value="" id="input_type">
    </form>
    <th><a class="field_sort <?=get_sort("id")?>"  id="id">Id</a></th>
    <th><a class="field_sort <?=get_sort("title")?>"  id="title">Title</a></th>
    <th><a class="field_sort <?=get_sort("parent_id")?>"  id="parent_id">Chuyên Mục cha</a></th>
    <th>Delete</th>
    <th>Edit</th>
    </thead>
    <tbody>
    <?php
    if ($list) {
        /**
         * @var  $key
         * @var  $val Category
         */
        for($i = 0 ; $i < count($list); $i++) {
            echo '<tr>';
            echo '<td><input name="check[]" class="checks" type="checkbox" value="' . $list[$i]->getId() . '"></td>';
            echo '<td>' . $list[$i]->getId() . '</td>';
            echo '<td>' . $list[$i]->getTitle() . '</td>';
            echo '<td>' . $list[$i]->getParentId() . '</td>'; ?>
                <td>
                    <form action="<?php echo base_url("admin/categoryCtr/delete")?>" method="post" class="form_del">
                        <input type="hidden" name="category_del" value="<?= ($i < count($list) - 1) ? $list[$i+1]->getId() : $list[$i]->getId()?>">
                        <a href="" class="a_del"><span class="glyphicon glyphicon-remove">
                                </span></a></form>
                </td>
                <td>
                    <a href="<?=base_url("admin/categoryCtr/update/{$list[$i]->getId()}")?>">
                                <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
            </tr>
         <?php }
    } ?>
    </tbody>
    </table>
</div>