<?php
function chuanhoa($string, $ucfirst = true){
    $string = trim($string, " ");
    $string = addslashes($string);
    if ($ucfirst == false)
        return $string;
    else
        return ucfirst($string);
}


function upload($field, $config = array(), $alias)
{
    //cấu hình uploads
    $options = array(
        'name' => '',
        'upload_path' => 'public/images/',
        'allowed_exts' => '*',
        'overwrite' => TRUE,
        'max_size' => 0
    );
    $options = array_merge($options, $config);

    //nếu chưa uploads? kết thúc

    if (!($_FILES[$field]["tmp_name"])){
        if($alias){
            set_error($field,ucfirst($alias." là bắt buộc"));
        }
        return FALSE;
    }

    //file uploads
    $file = $_FILES[$field];

    //lỗi uploads? kết thúc
    if ($file['error'] != 0) return FALSE;

    //phần mở rộng của file
    $temp = explode(".", $file["name"]);
    $ext = end($temp);

    //phần mở rộng không phù hợp? kết thúc
    if ($options['allowed_exts'] != '*') {
        $allowedExts = explode('|', $options['allowed_exts']);
        if (!in_array($ext, $allowedExts)){
            if($alias){
                set_error($field,ucfirst("Định dang file không hợp lệ"));
            }
            return FALSE;
        }
    }

    //kích thước quá lớn? kết thúc
    $size = $file['size'] / 1024 / 1024;
    if (($options['max_size'] > 0) && ($size > $options['max_size'])){
        if($alias){
            set_error($field,ucfirst("Kích thước file quá lớn"));
        }
        return FALSE;
    }

    $name = empty($options['name']) ? $file["name"] : $options['name'] . '.' . $ext;
    $file_path = $options['upload_path'] . $name;

    //nếu cho phép ghi đè
    if ($options['overwrite'] && file_exists($file_path)) {
        unlink($file_path);
    }

    //uploads file và trả về tên file
    if(!move_uploaded_file($file["tmp_name"], $file_path)){
        if($alias){
            set_error($field,ucfirst("Đã có lỗi xảy ra không thể upload file"));
        }
        return FALSE;
    }

    return $name;
}

function redirect_to($url){
    header("Location:".$url);
    exit();
}

function get_image($image)
{
    $path = 'http://vitravel.000webhostapp.com//public/images/' . $image;

    $img = "<img src='$path' style='max-width:70px; max-height:70px' alt=$image>";
    return $img;
}

function get_path_image($image)
{
    return base_url('public/images/' . $image);
}

function get_content($str)
{
    $result = array();
    $arr = json_decode($str);
    foreach ($arr as $item) {
        array_push($result, $item->content);
    }
    return implode("", $result);
}

function base_url($url = "")
{
    return "http://vitravel.000webhostapp.com/" . $url;
}


function strU($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = preg_replace("/[^A-Za-z0-9 \/\.]/", '', $str);
    $str = preg_replace("/\s+/", ' ', $str);
    $str = trim($str);
    return $str;
}

/**
 * Chuyển về chuỗi alias
 * @param  string
 * @return string
 */
function alias($str)
{
    $str = strU($str);
    $str = strtolower($str);
    $str = str_replace(' ', '-', $str);
    return $str;
}


function convertTime($dateTime)
{
    return date("d-m-Y", strtotime($dateTime));
}

function getCertainWord($paragraph, $num_of_word = 35)
{
    $paragraph = explode(' ', $paragraph);
    if(count($paragraph) > $num_of_word) {
        $paragraph = array_slice($paragraph, 0, $num_of_word);
        return implode(' ', $paragraph)."....";
    }
    return implode(' ', $paragraph);
}

function createURl($url)
{
    return base_url(alias($url) . ".html");
}

function captcha()
{
    $captcha=array(
        1=>array("question"=>"mot cong mot bang","answer"=>2),
        2=>array("question"=>"mot nu cuoi bang...thang thuoc bo","answer"=>10),
        3=>array("question"=>"alibaba va.....ten cuop","answer"=>40),
        4=>array("question"=>"nghin le....dem","answer"=>1),
        5=>array("question"=>"nam muoi sau cong bon muoi bon bang....","answer"=>100),
        6=>array("question"=>"....thang muoi mot la ngay nha giao viet nam","answer"=>20),
        7=>array("question"=>"...anh hung luong son bac","answer"=>108),
        8=>array("question"=>"...chua phai la tet","answer"=>30),
        9=>array("question"=>"....thang tam la dam trung thu","answer"=>15),
    );
    $capRand=array_rand($captcha);
    $_SESSION["cap_ans"]=$captcha[$capRand]["answer"];
    return $captcha[$capRand]["question"];
}

function validateString($filed,$alias,$string,$options = []){

    delete_error($filed);
    // chuoi cac ki tu khong hop le.
    $inValidString = "`-=~!@#$%^&*()}{;<>?|[]':\\/\"\.";
    $length = strlen($string);
    $numeric = "1234567890";

    if($string == ""){
        set_error($filed,$alias." Là Bắt Buộc");
        return false;
    }

    set_data($filed,$string);

    if(isset($options['min_length']) && ($min = $options['min_length'])){

        if($length < $min){
            set_error($filed, $alias ." Phải Có Ít Nhất ".$min ." Kí Tự");
            return false;
        }
    }


    if(isset($options['max_length']) && ($max = $options['max_length'])){

        if($length > $max){
             set_error($filed, $alias ." Phải Có Nhiều Nhất ".$max ." Kí Tự");
            return false;
        }
    }

    if(isset($options['no_numeric']) && $options['no_numeric']){

        $inValidString = join("",[$inValidString,$numeric]);
    }

    if(isset($options['except']) && $options['except']){

        foreach($options['except'] as $ch){
            $inValidString = preg_replace("/{$ch}/","",$inValidString);
        }
    }


    for($i = 0; $i < $length  ; $i++)
    {
        if(strpos($inValidString,$string[$i]) > 0)
        {
            if(strpos($numeric,$string[$i]) > 0){
                set_error($filed, $alias . " Không Được Chứa Số");
            }else{
                set_error($filed, $alias ." Có Chứa Kí Tự Đặc Biệt");
                //die(strpos($inValidString,$string[$i]));
            }
            return false;

        }
    }

    return $string;
}

function validateEmail($email){
    delete_error("email");

    if($email == ""){
        set_error("email","Email Là Bắt Buộc");
        return false;
    }

    set_data("email",$email);

    if(!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', trim($email))){
        set_error("email","Email Không Hợp Lệ");
        return false;
    }
    return $email;
}

function validNumeric($field,$alias,$num){
    delete_error($field);

    if($num == ""){
        set_error($field,ucfirst($alias)." Là Bắt Buộc");
        return false;
    }

    set_data($field,$num);

    if(!preg_match('/^[0-9]+$/', trim($num))){
        set_error($field,$alias." Không Hợp Lệ");
        return false;
    }
    return $num;
}


function outputString($out){
    return htmlentities(trim($out),ENT_COMPAT,"UTF-8");
}

function set_error($filed,$error){
    $_SESSION["form_error"][$filed] = $error;
}

function get_error($filed){
    if(isset($_SESSION["form_error"][$filed])){
        return $_SESSION["form_error"][$filed];
    }
    return "";
}

function delete_error($field = ""){

    if(!$field){
        if(isset($_SESSION["form_error"])){
            unset($_SESSION["form_error"]);
            delete_data();
        }
    }else{
        if(isset($_SESSION["form_error"][$field])){
            unset($_SESSION["form_error"][$field]);
            delete_data($field);
        }
    }

}

function set_data($field,$data){

    if($field & $data){
        $_SESSION["data"][$field] = $data;
    }
}


function get_data($field){

    if(isset($_SESSION["data"][$field])){
        return outputString($_SESSION["data"][$field]);
    }
    return "";
}

function delete_data($field = ""){

    if($field && isset($_SESSION["data"][$field])){
        unset($_SESSION["data"][$field]);
        return;
    }
    unset($_SESSION["data"]);
}

function set_sort($field,$type){

    if($field && $type){
        $_SESSION["sort"][$field] = strtoupper($type);
    }
}

function delete_sort($field = ""){

    if(isset($_SESSION["sort"][$field]) && $field){
        unset($_SESSION["sort"][$field]);
    }else{
        unset ($_SESSION["sort"]);
    }
}

function get_sort($field){
    if(isset($_SESSION["sort"][$field])){
        return ($_SESSION["sort"][$field]);
    }
    return "ASC";
}


function arr_to_obj($arr,$nameObj){
    if(!$arr){
        return NULL;
    }

    if(class_exists($nameObj)){
        if(isset($arr[0]) && is_array($arr[0])){
            $list = [];
            foreach($arr as $it){
                $list[] = new $nameObj($it);
            }
            return $list;
        }

        return new $nameObj($arr);
    }
    exit("Class not existed");
}

function trigger($data){

    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
}
