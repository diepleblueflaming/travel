<div class="container" id="login">
    <div class="row">
        <div class="panel panel-default col-sm-8 col-sm-offset-2">
            <div class="panel-heading text-center" id="head">
                <span class="glyphicon glyphicon-lock"></span> Login
            </div>
            <div class="panel-body">
                <form role="form" action="" method="post" id="form_login">
                    <div class="form-group has-feedback">
                        <label for="username">Username</label>
                        <input type="text" placeholder="Nhập Tên Đăng Nhập" id="username" class="form-control"
                        name="username" title="Tên đăng nhập không co kí tự đặc biệt và co 5-10 kí tự">
                        <span class="glyphicon glyphicon-user  form-control-feedback"></span>
                    </div>
                    <p class="error"><?=get_error("username")?></p>
                    <br>
                    <div class="form-group has-feedback">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Nhập Mật Khẩu" id="password" class="form-control"
                        name="password"  title="Pasword không co kí tự đặc biệt và co 5-10 kí tự">
                                    <span class="glyphicon glyphicon-eye-close  form-control-feedback">

                    </div>
                    <p class="error"><?=get_error("password")?></p>
                </form>
            </div>
            <div class="row panel-footer">
                <button class="btn btn-success btn-block"  type="submit" form="form_login">Login</button>
            </div>
        </div>
    </div>
</div>

