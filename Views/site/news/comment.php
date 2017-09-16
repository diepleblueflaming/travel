<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 9/13/2016
 * Time: 11:18 AM
 */
?>
<div class="containers" id="comment">
    <h4 id="title"> Bình Luận Của Bạn Về Bài Viết Này</h4>
    <form action="" method="post" class="form-group">

        <textarea name="com_content" rows="10" cols="50" id="com_content" class="form-control"></textarea>
        <input type="text" id="your_name" name="com_name" class="username" placeholder="Tên Bạn">
        <input type="text" name="captcha" id="captcha" class="username" placeholder="Chuỗi xác nhận">
        <img id="cap_img" style="margin-top: -8px" src="<?php echo base_url("library/captcha/captcha.php")?>">
        <input type="button" class="com-btn" value="Comment" id="com_btn">
        <p id="alert"></p>
    </form>
</div>
