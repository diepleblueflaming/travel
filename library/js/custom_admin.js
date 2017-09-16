$(document).ready(function(){

    // ham su ly su kien xoa cac muc da chon
    deleteSelected();

    // ham xu ly su kien xap xep cac bang.
    handingSort();

    // ham su ly su kien khi nhan nut xoa mot chuyen muc
    delete_handling();

    // ham su ly xu kien nhan nut them moi
    btn_click_handling();

    // ham xu ly su kien khi chon tat ca
    check_all_handling();

    // tim kiem chuyen muc.
    search_handling();

    // ham xu ly khi nhan nut thoat.
    cancel_handling();

    // ham xu ly su kien khi thay doi trang thai
    change_status();

});

function base_url($uri){
    return "http://vitravel.000webhostapp.com/"+$uri;
}

// sử lý xóa các chuyên mục được chọn trong ô checkbox
function deleteSelected() {
    $("#action").change(function () {

        var $module = $(this).parent().attr("id");

        if ($("#action option:selected").text() == "Delete Selected") {
            // hàm sau trả về giá trị của các ô chekcbox được chọn

            var ids = $('input[type = checkbox]:checked').map(function (_, el) {
                return $(el).val();
            }).get();

            $.post(base_url("admin/"+$module+"/deleteSelected"),{ids: JSON.stringify(ids)}, function (result) {
                location.reload();
            });
        }
    });
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


function delete_handling() {
    $(".a_del").click(function () {
        $(this).parent().submit();
        return false;
    });

    $(".form_del").submit(function () {
        if (!confirm("Bạn Có muốn xóa Chuyên mục này không... ?"))
            return false;
        return true;
    });
}


function btn_click_handling(){

    $("button[id^='btn-submit']").click(function () {

        var $module = $(this).attr("id");
        $module = $module.match(/([a-z]+)/gi)[2];

        $(location).attr("href",base_url("admin/"+ $module+"/add/"));
    });
}

function check_all_handling(){

    $('#check_all').change(function () {
        $('.table input:checkbox').prop('checked', this.checked);
    });
}

function cancel_handling(){

    $("#btn-cancel").click(function(){
        window.history.back();
    })
}


function change_status () {

    $("input[class $='censor']").click(function () {

        var $url  = window.location.href;

        var module = $url.split("/")[4];

        var $id = $(this).attr('id');
        var $val = $(this).val();

        var $status = ($val == 'Duyệt') ? 1 : 0

        $.post(base_url("admin/"+ module +"/changeStatus"), {id : $id, status: $status}, function (result) {

            if(result.success  != undefined && result.success){
                $("#" + $id).val( $status ? "Bỏ Duyệt" : "Duyệt");
            }
        },"json")
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


function search_category($field, $val){

    $.post(base_url("admin/category/find/"), {field: $field, key: $val}, function (result) {

        var html = '';
        console.log(result['data']);
        $(result['data']).each(function (index, element) {

            var chuyen_muc_cha= (element.parent_id==null) ? "" : element.parent_id;
            html += '<tr>';
            html += '<td><input name="cat[]" type="checkbox" value="' + element.id + '"></td>';
            html += '<td>' + element.id + '</td>';
            html += '<td>' + element.title + '</td>';
            html += '<td>' + chuyen_muc_cha + '</td>';
            html += '<td>' +
            '<form action="' + base_url("admin/category/delete/") + '"; method="post"; class="form_del">' +
            '<input type="hidden"; name="category_del"; value=' + element.id + '>' +
            '<a href="" class="a_del"><span class="glyphicon glyphicon-remove">' +
            '</span></a></form></td>';

            html += '<td><a href="' + base_url("admin/category/update/") + element.id + '" >' +
            '<span class="glyphicon glyphicon-remove"></span></a></td>';
            html += '</tr>';
        });
        $("#tab-content > tbody").html(html);
        delete_handling();
    }, "json");
}


function search_user($field, $val){
    $.post(base_url("admin/user/find/"), {field: $field, key : $val },function (result) {
        var html = '';
        $(result['data']).each(function (index, element) {
            html += '<tr>';
            html += '<td><input name="check[]" type="checkbox" value="' + element.id + '"></td>';
            html += '<td>' + element.id + '</td>';
            html += '<td>' + element.username + '</td>';
            html += '<td>' + element.email + '</td>';
            html += '<td>' + element.address + '</td>';
            html += '<td>' + element.phone + '</td>';
            html += '<td>' + element.level + '</td>';
            html += '<td>' +
            '<form action="' + base_url("admin/user/delete/") + '" method="post" class="form_del">' +
            '<input type="hidden"; name="user_del"; value=' + element.id + '>' +
            '<a href="" class="a_del"><span class="glyphicon glyphicon-remove">' +
            '</span></a></form></td>';
            html += '<td><a href="' + base_url("admin/user/update/") + element.id + '" >' +
            '<span class="glyphicon glyphicon-remove"></span></a></td>';
            html += '</tr>';
        });
        $("#tab-content > tbody").html(html);
        delete_handling();
    }, "json");
}


function search_comment($field, $val){
    $.post(base_url("admin/comment/find/"), {field : $field, key: $val}, function (result) {
        var html = '';

        $(result['data']).each(function (index, element) {
            html += '<tr>';
            html += '<td><input name="com[]" type="checkbox" value="' + element.id + '"></td>';
            html += '<td>' + element.id + '</td>';
            html += '<td>' + element.content + '</td>';
            html += '<td>' + element.date_create + '</td>';
            html += '<td>' + element.user_comment + '</td>';
            html += '<td>' + element.news_comment + '</td>';
            if (element.status == 1)
                $a = " Bỏ Duyệt";
            else
                $a = "Duyệt";
            html += '<td> <input type="button"; id="' + element.id + '" class="btn btn-default censor"' +
            'value="' + $a + '"></td>';
            html += '<td>' +
            '<form action="'+ base_url('admin/comment/delete/')+'" method="post" class="form_del">' +
            '<input type="hidden"; name="com_del"; value=' + element.id + '>' +
            '<a href="" class="a_del"><span class="glyphicon glyphicon-remove">' +
            '</span></a></form></td>';
            html += '</tr>';
        });
        $("#tab-content > tbody").html(html);
          delete_handling();
          change_status();
    }, "json");
}


function search_news($field, $val){
    $.post(base_url("admin/news/find/"), {field:$field, key : $val}, function (result) {
        var html = '';
        $(result['data']).each(function (index, element) {
            html += '<tr>';
            html += '<td><input name="cat[]" type="checkbox" value="' + element.id + '"></td>';
            html += '<td>' + element.id + '</td>';
            html += '<td >' + element.title + '</td>';
            html += '<td><div class="large_data">' + element.content + '</div></td>';
            html += '<td><div class="large_data">' + element.detail_content + '</div></td>';
            html += '<td>' + element.category + '</td>';
            html += '<td>' + element.sender + '</td>';
            html += '<td>' + element.view + '</td>';
            html+='<td>'+ getImage(element.image)+'</td>';
            if (element.status == 1)
                var $a = "Bỏ Duyệt";
            else
                $a = "Duyệt";
            html += '<td><input type="button" id="' + element.id + '" value="' + $a + '" class="btn btn-default censor"></td>';
                html += '<td>' +
                '<form action="' + base_url("admin/news/delete/") + '" method="post" class="form_del">' +
                '<input type="hidden"; name="a_del"; value=' + element.id + '>' +
                '<a href="" class="a_del"><span class="glyphicon glyphicon-remove">' +
                '</span></a></form></td>';
            html += '</tr>';
        });
        $("#tab-content > tbody").html(html);
        delete_handling();
        change_status();
    }, "json");
}
