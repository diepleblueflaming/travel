$(function(){

    smooth_Scroll();

    $("#hot_list").als({
        visible_items: 10,
        scrolling_items: 1,
        orientation: "vertical",
        circular: "yes",
        autoscroll: "yes",
        interval: 3000
    });

    // su ly tim kiem
    search_handling();

    // ham xu ly su kien xap xep cac bang.
    handingSort();

    delete_handling();

    comment();

    btnMenuMobileClick();
});

// ham xu ly su kien khi cuon trang.
function smooth_Scroll(){
    $(window).scroll(function(){
        // neu thanh cuon trang cach top > 50 hien thi nut quay len.
        if($(document).scrollTop() > 50){
            $("#back_to_top").fadeIn(500);
        }
        else{
            // nguoc lai an di.
            $("#back_to_top").fadeOut(500);
        }
    });

    // khi click vao thi quay ve top.
    $("#back_to_top").click(function(){
        $("html,body").animate({
            scrollTop:0
        },1000);
    });
}

function isValid(str,hasNumeric,checkAmount) {
    if(str=='')
        return "Bạn chưa nhập thông tin";
    if(checkAmount==true&& str.length > 120)
        return "Chuỗi có độ dài quá lớn!!!!!!!!!!"
    if(hasNumeric==false)
        var iChars = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?";
    else
        var iChars = "~`!#$%^&*+=-[]\\\';,/{}|\":<>?1234567890";
    for (var i = 0; i < str.length; i++) {
        if (iChars.indexOf(str.charAt(i)) != -1) {
            return "chuỗi đã nhập có ký tự đặc biệt.Nhập Lại!!!";
        }
    }
    return '';
}

function base_url($url)
{
    return "http://vitravel.000webhostapp.com/"+$url;
}


function getImage(image)
{
    var $path="http://vitravel.000webhostapp.com/public/images/"+image;
    var img = "<img src='"+$path+"' style='max-width:70px; max-height:70px' alt=image>";
    return img;
}

function handingSort() {

    $(".field_sort").click(function(){
        var type = $(this).attr("class");
        type = type.match(/\s[A-Z]+/g)[0];

        $("#input_type").val(type.trim());
        $("#input_sort").val($(this).attr("id"));
        $("#form_sort").submit();
        return true;
    });
}

function search_handling(){

    $("#form_search").submit(function(e){

        var $key = $(this).find("#key_search").val();
        var $field = $(this).find("#field_search").val();

        if(!$field){
            alert("Bạn Chưa Chọn Kiểu Tìm Kiếm");
        } else if(!$key ){
            alert("Bạn Chưa Nhập Từ Khóa Tím Kiếm");
        }

        if(!$field || !$key){
            e.preventDefault();
            return;
        }
        $("#form_search").submit();
    });
}

function delete_handling() {
    $(".a_del").click(function (e) {
        e.preventDefault();
        $(this).parent().submit();
    });
}


function comment(){

    $("#com_btn").click(function () {
        var name = $("#your_name").val();
        var content = $("#com_content").val();
        var news_id = parseInt(window.location.pathname.match(/[0-9]+\./gi))
        var captcha=$("#captcha").val();

        $.post(base_url("comment/add/"), {
            user_comment: name, content: content,
            news_id: news_id, captcha: captcha
        }, function (res) {
            if (res.success != undefined) {

                var timeout = setTimeout(function () {
                    $("#alert").show().html("Comment của bạn đang chờ phê duyệt").removeClass().addClass("success");
                    $("#your_name").val('');
                    $("#captcha").val("");
                    $("#com_content").val("");
                    $("#comment #cap_img").attr("src",base_url("library/captcha/captcha.php"));
                }, 1000);

            }// end of if
            else {
                $("#comment #alert").show().html(res.error).removeClass().addClass("error");
            }
        },"json") // end post function
    });
}


function notification(){
    var a = 10;
    loading();
    function loading()
    {
        if(a == 0){
            window.location=base_url("");
            return false;
        }
        $("#notification #loading").html(a);
        a--;
        t = setTimeout(function(){
            loading();
        },1000);
    }
}

/*
    fnc handling menu_mobile_button click event
 */
function btnMenuMobileClick() {
    $("#menu_mobile_button").on("click",() => {
        "use strict";
        var i = $("#menu_mobile_button i");
        if(i.hasClass("glyphicon-menu-hamburger")){
            i.removeClass("glyphicon-menu-hamburger").addClass("glyphicon-remove");
            $("#mobile_menu").animate({left:"0"});
        }else {
            i.removeClass("glyphicon-remove").addClass("glyphicon-menu-hamburger");
            $("#mobile_menu").animate({left:"-100%"});
        }
    });
}

