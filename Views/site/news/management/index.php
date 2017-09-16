<div class="col-sm-10 col-sm-offset-1">
    <div class="row news clearfix" id="tool">
        <div class="col-xs-6 col-sm-6 col-md-2">
            <a href="<?=base_url("management/add/")?>" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span> Thêm Mới </a>
        </div>
        <div class="pull-right col-xs-12 col-sm-12 col-md-6" id="div_search">
            <div class="row">
                <form action="" method="post" id="form_search">
                    <div class="col-xs-4 col-sm-4">
                        <select class="form-control" name="field" id="field_search">
                            <option value="">Tìm Kiếm Theo</option>
                            <option value="title">Tiêu Đề</option>
                            <option value="content">Nội Dung</option>
                            <option value="category">Chuyên Mục</option>
                        </select>
                    </div>
                    <div class="col-xs-8 col-sm-8">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm" id="key_search">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row news table-responsive" id="table_container">
        <table class="table table-bordered table-hover" id="tab-content">
        <thead>
            <th><input type="checkbox" id="check_all"></th>
            <form action="<?php base_url("admin/newsCtr/")?>" method="post" id="form_sort">
                <input type="hidden" name="field" value="" id="input_sort">
                <input type="hidden" name="type" value="" id="input_type">
            </form>
            <th><a class="field_sort <?=get_sort("id")?>" id="id">Id</a></th>
            <th><a class="field_sort <?=get_sort("title")?>" id="title">Tiêu Đề</a></th>
            <th><a class="field_sort <?=get_sort("content")?>" id="content">Nội Dung</a></th>
            <th>Nội Dung Chi Tiết</th>
            <th><a class="field_sort <?=get_sort("category")?>" id="category">Chuyên Mục</a></th>
            <th><a class="field_sort <?=get_sort("view")?>" id="view">Lượt Xem</a></th>
            <th>Ảnh Đại Diện</th>
            <th>Xóa</th>
            <th>Cập Nhật</th>
        </thead>
        <tbody>
        <?php
        if ($list) {
            foreach ($list as $key => $val) {
                echo '<tr>';
                echo '<td><input name="check[]" type="checkbox" value="' . $val['id'] . '"></td>';
                echo '<td>' . $val['id'] . '</td>';
                echo '<td><div class="large_data">' . $val['title'] . '</div></td>';
                echo '<td><div class="large_data">' . $val['content'] . '</div></td>';
                echo '<td><div class="large_data">' . $val['detail_content'] . '</div></td>';
                echo '<td>' . $val['category'] . '</td>';
                echo '<td>' . $val['view'] . '</td>';
                echo '<td>' . get_image($val['image']) . '</td>'; ?>
                <td>
                    <a href="<?=base_url("management/delete/".$val["id"]."/")?>">Xóa</a>
                </td>
                <td>
                    <form action="<?php echo base_url("management/update/".$val["id"])?>" method="post" class="form_del">
                        <input type="hidden" name="news_del" value="<?php echo $val['id']; ?>">
                        <a href="" class="a_del"><span class="glyphicon glyphicon-edit"></span></a>
                    </form>
                </td>
            </tr>
             <?php }
        }
        ?>
        </tbody>
        </table>
    </div>
</div>
<?php if(isset($pagination))
    echo "<div class='text-center'>".$pagination->html()."</div>";?>