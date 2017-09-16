<?php if (!defined("PATH_SYSTEM")) die("Bad Requested"); ?>
<div class="col-sm-8 col-sm-offset-2" id="sign">

        <h1>Đăng Kí Thành Viên</h1>
        <form role="form" action="" method="post" class="form-horizontal" id="forms">
            <div class="panel-body">

                <div class="col-sm-6">
                    <label for="username" class="control-label">Tên Đăng Nhập</label>
                    <input type="text" class="form-control" name="username" id="username"
                           placeholder="Nhập tên sử dụng"
                           value="<?=get_data("username")?>">
                    <p class="error"><?=get_error("username")?></p>
                </div>

                <div class="col-sm-6">
                    <label for="password" class="control-label">Mật Khẩu</label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Nhập mật khẩu">
                    <p class="error"><?=get_error("password")?></p>
                </div>

                <div class="col-sm-6">
                    <label for="email" class="control-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email"
                           placeholder="nhập vào địa chỉ email"
                           value="<?=get_data("email")?>">
                    <p class="error"><?=get_error("email")?></p>
                </div>

                <div class="col-sm-6">
                    <label for="re-password" class="control-label">Nhập Lại Mật Khẩu</label>
                    <input type="password" class="form-control" name="re-password" id="re-password"
                           placeholder="Nhập lại mật khẩu">
                    <p class="error"><?=get_error("re_password")?></p>
                </div>

                <div class="col-sm-8" id="captcha">
                    <div class="col-sm-8"><input type="text" class="form-control" name="captcha" id="captcha"
                           placeholder="Nhập chuỗi xác nhận"
                           value="<?php if(isset($_POST['captcha'])) echo trim($_POST["captcha"]);?>">
                        <p class="error"><?=get_error("captcha")?></p>
                    </div>
                    <img src="<?php echo base_url("library/captcha/captcha.php")?>">
                </div>

                <div id="action">
                    <input type="submit" value="Đăng Kí" name="btn-sign" class="btn btn-success" id="btn-sign">
                    <input type="button" value="Quay Lại" name="btn-cancel" class="btn btn-danger" id="btn-cancel">
                </div>
            </div>
    </form>
</div>

