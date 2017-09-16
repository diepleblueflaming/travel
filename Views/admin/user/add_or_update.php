<div class="col-sm-12 user">
    <div class="panel panel-primary col-sm-10 col-sm-offset-1"
         id="main-content">
        <div class="row panel panel-heading">
        <span class="glyphicon glyphicon-plus"></span>
        <?php echo isset($user) ? "Cập Nhật" : "Thêm Mới"; ?>
    </div>
    <div class="panel panel-body">
        <form action="" method="post">
        <div class="form-group has-feedback">
            <label for="username">Tên Đăng Nhập</label> <input type="text"
             placeholder="Tên Đăng Nhập"  id="username"class="form-control"
             name="username" title="Tên đăng nhập không co kí tự đặc biệt và co 5-10 kí tự"
            value="<?= isset($user) ? outputString($user->getUsername()) : get_data("username") ?>" autocomplete="off">
            <span class="glyphicon glyphicon-user  form-control-feedback"></span>
            <p class="error"><?= get_error("username")?></p>
        </div>
        <br>
        <div class="form-group has-feedback">
            <label for="password">Mật Khẩu</label>
            <input type="password" placeholder="Nhập  Mật  Khẩu" id="password"
             class="form-control" name="password" autocomplete="off"
            title="Pasword không co kí tự đặc biệt và co 5-10 kí tự"> <span
                class="glyphicon glyphicon-eye-close  form-control-feedback"></span>
            <p class="error"><?=get_error("password")?></p>
        </div>
        <br>

        <div class="form-group has-feedback">
            <label for="email">Email</label> <input type="email" placeholder="Nhâp Email" id="email"
             class="form-control" name="email"
            title="Email" value="<?= isset($user) ?  $user->getEmail() : get_data("email")?>"> <span
                class="glyphicon glyphicon-email  form-control-feedback"></span>
            <p class="error"><?=get_error("email")?></p>
        </div>
        <br>

        <div class="form-group has-feedback">
            <label for="address">Địa Chỉ</label>
            <input type="text" placeholder="Nhập Địa chỉ" id="address" class="form-control" name="address"
            title="Aadress không co kí tự đặc biệt"
            value="<?= isset($user) ?  $user->getAddress() : get_data("address")?>"> <span
                class="glyphicon glyphicon-eye-close  form-control-feedback"></span>
            <div class="error"><?=get_error("address")?></div>
        </div>
        <br>

        <div class="form-group has-feedback">
            <label for="phone">Số Điện Thoại</label> <input type="tel" placeholder="Nhập Số điện thoại" id="phone"
             class="form-control" name="phone"
            title="Phone không co kí tự đặc biệt"
            value="<?=isset($user) ?  $user->getPhone() : get_data("phone")?>"> <span
                class="glyphicon glyphicon-eye-close  form-control-feedback"></span>
            <p class="error"><?=get_error("phone")?></p>
        </div>
        <br>

        <div class="form-group has-feedback">
            <label for="level">Level</label>
            <input type="text" placeholder="Level"  id="level"
             class="form-control" name="level" title="la so tu 1-3"
            value="<?=isset($user) ?  $user->getLevel() : get_data("level")?>"> <span
                class="glyphicon glyphicon-education  form-control-feedback"></span>
            <p class="error"><?=get_error("level")?></p>
        </div>
        <br>
            <input class="btn btn-success" name="<?php echo isset($user) ? "btn-edit" : "btn-add"; ?>"
         type="submit" value="<?php echo isset($user) ? "cập nhật" : "Thêm Mới"; ?>" id="btn-submit-user">
        <input class="btn btn-danger" id="btn-cancel"  value="Cancel"  type="button">
        </form>
    </div>
</div>
</div>