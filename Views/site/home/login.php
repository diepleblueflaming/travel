<?php if (!defined("PATH_SYSTEM")) die("Bad Requested");?>
<style>
    .modal-header{background-color:#5cb85c; height:100px; text-align:center; color:#FFF;}
    [class="modal-header"] > h4{font-size:32px;}
</style>
<div class="modal fade" id="mymodal" role="dialog">
<!-- Model -->
<div class="modal-dialog">
    <!-- model content -->
    <div class="modal-content">
        <div class="modal-header">
            <button data-dismiss="modal" class="close">&times;</button>
            <h4 ><span class="glyphicon glyphicon-lock"></span>Login</h4>
        </div>
        <div class="modal-body">
            <!-- start form-login -->
            <form role="form" id="form-login">

                <div class="form-group">
                    <label for="log-username"><span class="glyphicon glyphicon-user"></span> Tên Đăng Nhập</label>
                    <input type="text" class="form-control" id="log-username" placeholder="Nhập vào tên đăng nhập">
                    <p class="error" id="err_name"><p>
                </div>

                <div class="form-group">
                    <label for="log-password"><span class="glyphicon glyphicon-eye-open"></span> Mật Khẩu</label>
                    <input type="password" id="log-password" class="form-control" placeholder="Mật Khẩu">
                    <p class="error" id="err_pass"></p>
                </div>

                <input class="btn btn-success btn-block" type="button" name="btn-login" id="btn-lg" value="Login">
            </form> <!-- end of form-login -->

            <!-- start form-forget -->
            <form role="form" id="form-forget">

                <div class="form-group">
                    <label for="forget-email"><span class="glyphicon glyphicon-user">
                    </span> Input Your Email to receive new password</label>
                    <p class="error" id="err_email"><p>
                    <input type="text" class="form-control" id="forget-email" placeholder="Nhập vào email của bạn">
                </div>

                <input class="btn btn-success btn-block" type="button" name="btn-forget" id="btn-forget" value="Retrieve Password">
            </form> <!-- start form-forget -->

        </div> <!-- end modal body -->

        <div class="modal-footer">
            <button class="btn btn-danger pull-left" data-dismiss="modal">
                <span class="glyphicon glyphicon-remove"></span> Cancel
            </button>
            <p>
                <label><a href="#" id="btn-login"> Login </a>
                    <a href="#" id="btn-forget"> ForgetPassword </a>
                    Not a member ? <a href="<?php echo base_url("user/sign/")?>">SignIn</a>
                </label>
            </p>
        </div><!-- end modal footer -->
    </div> <!-- end modal -->
</div>
</div>
