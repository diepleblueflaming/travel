/**
 * Created by Administrator on 4/14/2017.
 */
$(document).ready(function(){

    // ham xu ly su kien khi nhan nut login
    login();
    // ham xu ly su kien khi nhan nut forget password
    forgetPassword();

    // ham xu ly su kien click
    handling_click();

    // ham xu ly su kien khi nhan nut cancel
    cancel_handling();

});


function login(){

    $("#btn-lg").click(function(){

        $name = $("#log-username").val();
        $password = $("#log-password").val();

        $.post(base_url("user/login/"),{username:$name,password:$password},function(response){

            if(response.success != undefined) {
                location.reload();
            }
            else {
                $err_name = response.err_username != undefined ? response.err_username : "";
                $err_password = response.err_password != undefined ? response.err_password : "";
                $("#err_name").html($err_name);
                $("#err_pass").html($err_password);
            }
        },"json");
    })// end of $("#btn-lg").click()
}

function forgetPassword(){

    $("#btn-forget").click(function(){

        var email=$("#forget-email").val().trim();

        $.post(base_url("user/checkEmail/"),{forget_email:email},function(r){

            if(r.error == true){
                $("#err_email").html(r.error);
                return;
            }else{

                $("#err_email").html("Xin Chờ giây trong lát");
                $("input[id='btn-forget']").prop("disabled",true);

                $.post(base_url("user/forgetPassword/"),{forget_email:email},function(r){

                    if(r.success != undefined){
                        if(r.success == true){
                            $("#form-forget").html("<h3>Mật Khẩu Mới Đã được gửi tới email của bạn</h3>");
                        }else{
                            $("#form-forget").html("<h3>Rất Tiếc đã xảy ra lỗi vui lòng thử lại sau</h3>")
                        }
                        // hien thi lai form login va an chuc năng forget password.
                        var timeout = setTimeout(function(){
                            location.reload();
                        },5000); // end of function timeout
                    }
                },"json") // end of function post
            }
        },"json");
    }) // end of $("#btn-forget").click()
}

function handling_click(){

    $("#mymodal a[id^='btn']").click(function(){
        $("#mymodal form[id^='form']").slideUp();
        var module = $(this).attr("id").match(/([a-z]+)/g)[1];
        $("#mymodal a[id^='btn']").show();
        $(this).hide();
        $("#form-"+module).slideDown();
    });
}

function cancel_handling(){
    $("#btn-cancel").click(function(){
        window.history.back();
    });
}