<?php if (!defined("PATH_SYSTEM")) die("Bad Requested");?>
<div class="col-sm-10 col-sm-offset-1" id="profile">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3><span class="glyphicon  glyphicon-user"></span> Cập nhật thông tin </h3>
        </div> <!-- end of header -->

        <form role="form" action="" method="post">
        <div class="panel panel-body">
            <div class="form-group">
                <fieldset>
                    <legend> Tên Đăng Nhập</legend>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="username">Tên Đăng Nhập</label>
                            <div class="col-sm-7" id="username">
                                <p class="form-control-static"><b><?=$user->getUsername()?></b></p>
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-sm-3 control-label" for="new_username">Tên Đăng Nhập Mới</label>
                            <div class="col-sm-7">
                                <input type="text" name="new_username" placeholder="Tên đăng nhập mới" id="new-username"
                                   value="<?php if(isset($_POST['new_username']) && !empty($_POST['new_username']))
                                  echo htmlentities($_POST['new_username'],ENT_COMPAT,"UTF-8");?>" class="form-control">
                                <p class="error"><?=get_error("username")?></p>
                            </div>
                       </div>
                    </div>
                </fieldset> <!-- end of fieldset username-->

                <fieldset>
                    <legend> Mật Khẩu</legend>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="old_password"> Mật khẩu hiện tại</label>
                            <div class="col-sm-7">
                                <input type="password" id="old_password" name="old_password" class="form-control"
                                       value="<?php if(isset($_POST['old_password']) && !empty($_POST['old_password']))
                                           echo htmlentities($_POST['old_password'],ENT_COMPAT,"UTF-8");?>">
                                <p class="error"><?=get_error("password")?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="new_password"> Mật khẩu mới</label>
                            <div class="col-sm-7">
                                <input type="password" id="new-pass" name="new_password" class="form-control"
                                       value="<?php if(isset($_POST['new_password']) && !empty($_POST['new_password']))
                                           echo htmlentities($_POST['new_password'],ENT_COMPAT,"UTF-8");?>">
                                <p class="error"><?=get_error("new_password")?></php></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="confirm_password"> Nhập Lại mật khẩu mới</label>
                            <div class="col-sm-7">
                                <input type="password" id="cof-pass" name="confirm_password" class="form-control"
                                       value="<?php if(isset($_POST['confirm_password']) && !empty($_POST['confirm_password']))
                                           echo htmlentities($_POST['confirm_password'],ENT_COMPAT,"UTF-8");?>">
                                <p class="error"><?=get_error("confirm_password")?></php></p>
                            </div>
                        </div>
                    </div>
                </fieldset><!-- end of fieldset password-->

                <fieldset>
                    <legend> Address</legend>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa Chỉ</label>
                            <div class="col-sm-7"><p class="form-control-static"><b><?=$user->getAddress() ? $user->getAddress() : "Chưa cập nhật"?></b></p></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa Chỉ Mới</label>
                            <div class="col-sm-7">
                                <input type="text" name="new_address" placeholder="Nhập địa chỉ mới"
                                       value="<?php if(isset($_POST['new_address']) && !empty($_POST['new_address']))
                                         echo htmlentities($_POST['new_address'],ENT_COMPAT,"UTF-8");?>" class="form-control">
                                <p class="error"><?get_error("new_address")?></php></p>
                            </div>
                        </div>
                    </div>
                </fieldset><!-- end of fieldset address-->
                <fieldset>
                    <legend> Email</legend>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-7"><p class="form-control-static">
                                    <b><?=$user->getEmail()?></b></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Địa chỉ Email Mới</label>
                            <div class="col-sm-7">
                                <input type="text" name="new_email" placeholder="Nhập email mới"
                                          value="<?php if(isset($_POST['new_email']) && !empty($_POST['new_email']))
                                          echo htmlentities($_POST['new_email'],ENT_COMPAT,"UTF-8");?>" class="form-control">
                                <p class="error"><?=get_error("email")?></p>
                            </div>
                        </div>
                    </div>
                </fieldset><!-- end of fieldset email-->
                <fieldset>
                    <legend>Số Điện Thoại</legend>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số Điện Thoại</label>
                            <div class="col-sm-7"><p class="form-control-static">
                                    <b><?= $user->getPhone() ? $user->getPhone() : "Chưa cập nhật"?></b>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Số Điện Thoại Mới</label>
                            <div class="col-sm-7"><input type="text" name="new_phone" placeholder="Nhập số điện thoại mới"
                                             value="<?php if(isset($_POST['new_phone']) && !empty($_POST['new_phone']))
                                                 echo htmlentities($_POST["new_phone"],ENT_COMPAT,"UTF-8");?>"
                                             class="form-control">
                                <p class="error"><?=get_error("phone")?></p>
                            </div>
                        </div>
                    </div>
                </fieldset><!-- end of fieldset phone number-->
            </div>
                <div class="form-group form-horizontal">
                    <label for="captcha" class="col-sm-3 control-label">Nhập chuỗi xác nhận</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="captcha" id="captcha"
                         placeholder="nhập chuỗi bên " value="<?php if(isset($_POST['captcha'])) echo trim($_POST["captcha"]);?>">
                        <p class="error"><?=get_error("captcha")?></p>
                    </div>
                    <img src="<?php echo base_url("library/captcha/captcha.php")?>">
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" value="Cập Nhật" name="btn-changes" class="btn btn-success" id="btn-changes">
                <input type="button" value="Quay Lại" name="btn-cancel" class="btn btn-danger" id="btn-cancel">
            </div>
        </div>
    </form>
</div>

