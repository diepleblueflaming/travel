$(document).ready(function () {
    id = 0;
    // call function get_data()
    get_data();
    // su ly su kien khi submit form
    submit_handler();

    // su ly su kien khi click nut them moi
    $("#add").click(function(){
        handler();
        reset();
    });
    // su ly su kien khi click nut danh sach
    $("#btn_display").click(function(){
        //
        handler_2();
        // loai bo toan bo loi tai cac the bao loi.
        reset_err();
    });
});

// ham lay du lieu ban dau.
function get_data() {

    // gui ajax lay du lieu tren webservice.
    $.get("http://localhost/travel/api/user/list/", {}, function (resonse) {
        var html = '';
        $(resonse).find("user").each(function (index, item) {
            var level = $(item).find("level").text() == 1 ? "<span style='color: red'>admin</span>" : "member";

            html += "<tr>";
            html += "<td>" + $(item).find("id").text() + "</td>";
            html += "<td>" + $(item).find("username").text() + "</td>";
            html += "<td>" + $(item).find("email").text() + "</td>";
            html += "<td>" + $(item).find("address").text() + "</td>";
            html += "<td>" + $(item).find("phone").text() + "</td>";
            html += "<td>" + level + "</td>";
            html += "<td><a href='#' class='user_update' id='" + $(item).find("id").text() + "'>" +
            "<span class='glyphicon glyphicon-edit'></span></a></td>";
            html += "<td><a href='#' class='user_delete' id='" + $(item).find("id").text() + "'>" +
            "<span class='glyphicon glyphicon-remove'></span></a></td>";
            html += "</tr>";
        });

        // gan vao table
        $(".table > tbody").html(html);

        // call function edit_data()
        edit_data();

        // call function delete_data()
        delete_data();
    }, "xml"); // end post
}

// ham sua du lieu
function edit_data() {

    // su ly su kien khi nhat nut edit.
    $(".user_update").click(function () {

        id = $(this).attr("id");
        var url = "http://localhost/travel/api/user/single/" + id;
        // hui ajax request de lay du lieu ve ban ghi tuong ung.
        $.get(url, {}, function (res) {
            // gan du lieu vao form nhap lieu.
            var data = res[0];
            $("#username").val(data.username);
            $("#email").val(data.email);
            $("#address").val(data.address);
            $("#phone").val(data.phone);
            $("#level").val(data.level);
        }, "json");

        handler();
    })
}

// xu ly su kien khi nhan nut submit.
function submit_handler() {

    var base_url = "http://localhost/travel/api/user/add_or_edit_User";

    $("#submit").click(function () {
        var username = $("#username").val();
        var email = $("#email").val();
        var address = $("#address").val();
        var phone = $("#phone").val();
        var level = $("#level").val();

        // gui request duoi dang post.
        $.post(base_url, {id: id, username: username, email: email,address: address,
            phone : phone,level : level }, function (res) {

            if (jQuery.isEmptyObject(res)) {
                // cap nhat du lieu neu thannh cong.
                get_data();
                handler_2();
                // gan lai cac thong bao loi bang rong.
                reset_err();
                // gan lai cac form bang rong.
                reset();
                // gan lai id.
                id = 0;

            } else {
                reset_err();
                // neu that bai
                // gan loi ra man hinh
               get_error(res);
            }
        }, "json");
    });
} // end submit_handler()


// ham xoa chuyen muc.
function delete_data() {

    // xu li su kien khi nhan nut xoa.
    $(".user_delete").click(function () {
        var url = "http://localhost/travel/api/user/deleteUser/";
        var id = $(this).attr("id");
        // gui request den server.
        $.ajax({
            'url': url,
            'method': 'DELETE',
            'data': {id: id},
            'dataType': "JSON",
            'success': function (res) {

                if (jQuery.isEmptyObject(res)) {
                    get_data();
                } else {
                    alert(res.error);
                }
            } // end success function.
        }); // end ajax.
    }); // end .user_delete click();
}

function handler(){
    $("#add").fadeOut(500);
    $("#display").fadeOut(500,function(){
        $("#btn_display").fadeIn(500);
        $("#add_edit").fadeIn(500);
    });
}

function handler_2(){
    $("#btn_display").fadeOut(500);
    $("#add_edit").fadeOut(500,function(){
        $("#add").fadeIn(500);
        $("#display").fadeIn(500);
    });
}

function reset(){
     $("#username").val("");
     $("#email").val("");
     $("#address").val("");
     $("#phone").val("");
     $("#level").val("");
}

function reset_err(){
    $("#err_username").html("");
    $("#err_email").html("");
    $("#err_address").html("");
    $("#err_phone").html("");
    $("#err_level").html("");
    $("#err").html("");
}

function get_error(error){

    for(var item in error){
        if(item !== 'error'){
            $("#err_"+item).html(error[item]);
        }else if(item === 'error'){
            $("#err").html(error[item]);
        }
    }
}