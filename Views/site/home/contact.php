<!-- giao dien phan contact-->
<div class="contact">
    <div class="contact-header">
        <b><span class="glyphicon glyphicon-earphone"></span> Contact us</b>
    </div>
    <div class="contact-body">
        <form action="" method="post">
            <div id="result"></div>
            <textarea name="contact-content" rows="10" cols="10" class="form-control" id="contact-content"><?php if(isset($_POST["contact-content"]))
                            echo outputString($_POST["contact-content"]);?></textarea>
            <input type="email" name="contact-email" placeholder="email của bạn"
                   value="<?php if(isset($_POST["contact-email"])) echo outputString($_POST["contact-email"])?>"
                    class="form-control" id="contact-email">
            <div class="row" id="contact-email">
                <div class="col-sm-7">
                    <input type="text" name="contact-captcha" placeholder="chuỗi xác nhận"
                           value="<?php
                                if(isset($_POST["contact-captcha"])) echo outputString($_POST["contact-captcha"])?>"
                           class="form-control" id="contact-captcha">
                </div>
                <img id="img-captcha" src="<?php echo base_url("library/captcha/captcha.php")?>" alt="chuỗi xác nhận">
            </div>
            <input type="button" name="contact-submit" class="btn btn-primary btn-block"
                   value="send" id="contact-submit">
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){

        // xu li khi nhan contact
        $(".contact-header").click(function(){
            // hien form nhap lieu
            $(".contact-body").slideToggle(1000);
        });

        // gui du lieu len server
        $("#contact-submit").click(function(){

            // lay ra du lieu
            var content=$("#contact-content").val();
            var email=$("#contact-email").val();
            var captcha=$("#contact-captcha").val();

            // gui du lieu qua ham post
            $.post(base_url("home/contact"),{contact_content:content,contact_email:email,contact_captcha:captcha},function(res){
                if(res.status==true){
                    // bao thong bao thanh cong
                    $("#result").html(res.message);
                    // gan gia tri rong cho cac truong input
                    $("#contact-content").val("");
                    $("#contact-email").val("");
                    $("#contact-captcha").val("");
                    // gan lai gia tri captcha.
                    $("#img-captcha").attr("src",base_url("library/captcha/captcha.php"));
                }else{
                    // bao thong bao loi
                    $("#result").html(res.message);
                }
            },"json"); // end of post function
        });
    });
</script>