<div class="row user clearfix" id="tool">
    <div class="col-xs-6 col-sm-6 col-md-2" id="<?=$module?>">
        <select class="form-control" id="action">
            <option>Tác vụ</option>
            <option>Delete Selected</option>
        </select>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-2">
        <button type="button" class="btn btn-primary" name="btn-user-add" id="btn-submit-userCtr">
            <span class="glyphicon glyphicon-plus"></span> Thêm Mới </button>
    </div>
    <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-6" id="div_search">
        <div class="row">
            <form action="" method="post" id="form_search">
                <div class="col-xs-4 col-sm-4">
                    <select class="form-control" name="field" id="field_search">
                        <option value="">Tìm Kiếm Theo</option>
                        <option value="username">Tên Đăng Nhập</option>
                        <option value="email">Email</option>
                        <option value="address">Địa Chỉ</option>
                        <option value="phone">Số Điện Thoại</option>
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
    <form action="<?php base_url("admin/user/")?>" method="post" id="form_sort">
        <input type="hidden" name="field" value="" id="input_sort">
        <input type="hidden" name="type" value="" id="input_type">
    </form>
    <th> <a class="field_sort <?=get_sort("id")?>" id="id">Id</a></th>
    <th><a class="field_sort <?=get_sort("username")?>" id="username"> Name </a></th>
    <th><a class="field_sort <?=get_sort("email")?>" id="email"> Email </a></th>
    <th><a class="field_sort <?=get_sort("address")?>" id="address"> Address </a></th>
    <th><a class="field_sort <?=get_sort("phone")?>" id="phone"> Phone </a></th>
    <th><a class="field_sort <?=get_sort("level")?>" id="level"> Level </a></th>
    <th>Delete</th>
    <th>Edit</th>
    </thead>
    <tbody>
    <?php
    if ($list) {
        /**
         * @var  $key
         * @var  $val User
         */
        foreach ($list as $key => $val) {
            $level =($val->getLevel() == 1) ? "<b style='color: red'>admin</b>" : "member";
            echo '<tr>';
            echo '<td><input name="check[]" type="checkbox" value="' . $val->getId() . '"></td>';
            echo '<td>' . $val->getId() . '</td>';
            echo '<td>' . $val->getUsername() . '</td>';
            echo '<td>' . $val->getEmail() . '</td>';
            echo '<td>' . $val->getAddress() . '</td>';
            echo '<td>' . $val->getPhone() . '</td>';
            echo '<td>' . $level. '</td>'; ?>
                <td>
                    <form action="<?php echo base_url("admin/userCtr/delete/")?>" method="post" class="form_del">
                    <input type="hidden" name="user_del" value="<?=$val->getId()?>">
                    <a href="" class="a_del"><span class="glyphicon glyphicon-remove"></span></a></form>
                </td>
                <?php
             echo '<td><a href="'.base_url("admin/userCtr/update/").$val->getId().'" ><span class="glyphicon glyphicon-edit"></span></a></td>';
            }
            echo '</tr>';
        }
    ?>
    </tbody>
    </table>
</div>