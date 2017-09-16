<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/14/2017
 * Time: 5:22 PM
 */

class UserCtr extends MY_controller{

    public function __construct(){
        parent :: __construct();
        $this->load_model("user");
    }

    public  function  login(){

        $username = isset($_POST["username"]) ? $_POST["username"] : NULL;
        $password = isset($_POST["password"]) ? $_POST["password"] : NULL;

        $inValidUsername = validateString("username","Tên Đăng Nhập", $username);
        $inValidPass = validateString("password","Mật Khẩu", $password);

        // neu du lieu khong hop le bao loi
        if(!$inValidUsername | !$inValidPass){

            die(json_encode(
                [
                    "err_username" => get_error("username"),
                    "err_password" => get_error("password"),
                ]
            ));
        }

        $name  = $this->user->getUserBy(["where" => " username = '{$username}' AND active = ''"]);

        if(!$name){
            die(json_encode(["err_username" => "Tên đăng nhập không tồn tại"]));
        }
        else {
            $user = $this->user->getUserBy(['where' => "username = '$username'AND password ='" . md5($password) . "'"]);
            if (!$user) {
                die(json_encode(["err_password" => "Mật Khẩu không hợp lệ"]));
            }

            set_login(["id" => $user->getId(), "username" => $user->getUsername()],"user");
            delete_error();
            die(json_encode(["success" => true]));
        }
    }

    public  function  logout(){

        if(is_loged("user")) {

            delete_login("user");
            redirect_to(base_url());
        }
    }

    public  function  sign(){

        if(!empty($_POST)) {

            delete_error();

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $re_password = isset($_POST['re-password']) ? $_POST['re-password'] : '';
            $captcha  = isset($_POST['captcha']) ? $_POST['captcha'] : '';

            $inValidName = validateString("username","Tên Đăng Nhập",$username);
            $inValidPass = validateString("password","Mật Khẩu",$password);
            $inValidEmail = validateEmail($email);
            $inValidCaptcha = $captcha != $_SESSION['captcha'];

            if(!$inValidName | !$inValidPass  | !$inValidEmail){
                goto next;
            }

            if($password && $password != $re_password ){
                set_error("re_password","Mật Khẩu nhập lại không đúng");
                goto next;
            }

            if($inValidCaptcha){
                set_error("captcha","Mã xác nhận không đúng");
                goto next;
            }

            if($this->checkData("username","Tên Đăng Nhập",$username) & $this->checkData("email","Email",$email)) {

                $active = substr(md5(rand(0,9999)),0,32);
                $user = new User([
                    "username" => $username,
                    "password" => md5($password),
                    "email" => $email,
                    "active" => $active,
                    "level" => 2
                ]);

                // send mail
                $config = [
                    "email" => $email,
                    "title" => "Active Your Account",
                    "body" => "Cảm ơn bạn đã đăng kí tài khoản tại VietTravel.\n Vui lòng Click vào link sau
                                để active tài khoản\n".base_url("user/active/e={$email}&ac={$active}")
                ];

                if($this->sendMail($config)){
                    $this->user->add($user);
                    delete_error();
                    $message = "Bạn Đã đăng kí thành công.\n Một email đã được gửi tới email của bạn\n
                    Bạn vui lòng đăng nhập vào email để kích hoạt tài khoản";
                    $this->alert($message);
                }else{
                    print_r(error_get_last());
                    $message = "Chúng Tôi Không Thể gửi email đến tài khoản của bạn vui lòng thử lại sau";
                    $this->alert($message);
                }

            }
        }

        next :
        $data["title"]=" Đăng Kí Thành Viên ";
        $data["subView"]="site/user/sign";
        $this->load_view("site/index",$data);
    }

    public  function  active(){

        $e = isset($_GET['e']) && filter_var($_GET['e'],FILTER_VALIDATE_EMAIL)
            ? $this->user->escape($_GET['e']) : "";

        $ac = isset($_GET['ac']) && strlen($_GET['ac'])== 32 ? $this->user->escape($_GET['ac']) : "";

        if($e && $ac){

            if($this->user->activeUser($e,$ac)){
                $message = "Tài Khoản của bạn đã kích hoạt thành công";
            }else{
                $message = "Đã có lỗi chúng tôi không thể kích hoạt tài khoản của bạn";
            }
            $this->alert($message);
        }else{
            redirect_to(base_url());
        }
    }

    public  function forgetPassword()
    {
        if($email = $this->checkEmail(true)) {

            $newPass = substr(md5(rand(0,9999)),0,7);
            $config = [
                "email" => $email,
                "title" => "Retrieve new password from VietTravel",
                "body" => "Mật Khẩu mới của bạn tại VietTravel là: {$newPass}
                    Bạn có thể sử dụng password này để đăng nhập vào website của chúng tôi.
                    Thank You"
            ];

            if($this->sendMail($config)){
                delete_error();
                $this->user->updatePassword(md5($newPass),$email);
                exit(json_encode(["success" => TRUE]));
            }else{
                exit(json_encode(["success" => FALSE]));
            }
        }
    }

    public  function  profile(){

        // neu chua dang nhap thi dieu hương ve trang chu.
        if(!is_loged("user") && !is_loged("admin")){
            redirect_to(base_url());
        }

        $user = $this->user->getUserById($_SESSION["user"]["id"]);

        delete_error();

        $new_username = isset($_POST["new_username"]) ? $_POST["new_username"] : "";
        $old_password = isset($_POST["old_password"]) ? $_POST["old_password"] : "";
        $new_password = isset($_POST["new_password"]) ? $_POST["new_password"] : "";
        $confirm_password = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";
        $new_address = isset($_POST["new_address"]) ? $_POST["new_address"] : "";
        $new_email = isset($_POST["new_email"]) ? $_POST["new_email"] : "";
        $new_phone = isset($_POST["new_phone"]) ? $_POST["new_phone"] : "";


        if($new_username){
            $inValidUsername = validateString("username","Tên Đăng Nhập",$new_username);
        }

        if($old_password | $new_password | $confirm_password){

            $inValidNewPassword = validateString("new_password","Mật Khẩu Mới",$new_password);
            $inValidOldPassword = validateString("password","Mật Khẩu Cũ",$old_password);
            $inValidConfirmPassword = $new_password == $confirm_password ? TRUE : FALSE;


            if(!$inValidConfirmPassword){
                set_error("confirm_password","Mật khẩu nhập lại không đúng");
            }
        }

        if($new_address){
            $inValidAddress = validateString("new_address","Địa Chỉ",$new_address);
        }

        if($new_phone){
            $inValidPhone = validNumeric("phone","Số Điện Thoại",$new_phone);
        }

        if($new_email){
            $inValidEmail = validateEmail($new_email);
        }


        $inValidCaptcha = isset($_POST['captcha']) && $_SESSION['captcha'] == $_POST['captcha'] ? TRUE : FALSE;

        if($_POST && !$inValidCaptcha){
            set_error("captcha","Mã xác nhận không đúng");
        }

        $list = ["Username","NewPassword","OldPassword","ConfirmPassword","Captcha","Email","Phone","Address"];

        foreach($list as $item){

            $var = "inValid{$item}";

            if(isset(${$var}) && !${$var}){
                goto next;
            }
        }


        $check_exist = TRUE;
        // kiem tra ton tai.
        $fields = [
            "username" => "Tên đăng nhập",
            "password" => "Mật khẩu hiện tại",
            "email" => "Email",
            "phone" => "Số Điện Thoại"
        ];


        foreach($fields as $key => $val){

            $field = ( $key == "password" ) ? "old_".$key : "new_".$key;

            if(${$field}){
                if(!$this->checkData($key,$val,$key != "password" ? ${$field} : md5(${$field}))){
                    $check_exist = false;
                    if($key == "password"){
                        $check_exist = true;
                        delete_error("password");
                    }
                }else if($key == "password"){
                    $check_exist = false;
                    set_error("password","Mật khẩu hiện tại bạn nhập không đúng");
                }
            }
        }


        if(!$check_exist){
            goto next;
        }

        // neu khong co loi thuc hien cap nhat du lieu.
        foreach(["username","password","email","phone","address"] as $iterator){

            if(${"new_".$iterator}){
                $ac = "set".ucfirst($iterator);
                $user->{$ac}($iterator == "password" ? md5(${"new_".$iterator}) : ${"new_".$iterator});
            }
        }

        if($this->user->update($user)){
            $_POST = [];
            set_login(["id" => $user->getId(), "username" => $user->getUsername()],"user");
            redirect_to(base_url("user/profile/"));
        }

        next :
        $data["user"] = $user;
        $data["subView"]="site/user/profile";
        $data["title"]="Thông Tin Người Dùng";
        $this->load_view("site/index",$data);
    }

    private function  checkData($field, $alias, $data, $id = 0){
        delete_error($field);
        if($id) {
            if ($this->user->getRecord(["where" => "{$field} = '{$data}' AND id!= {$id}"])){
                set_error($field,ucfirst($alias) . " Đã Tồn Tại");
                return false;
            }
        }
        else {
            if ($this->user->getRecord(["where" => "{$field} = '{$data}'"])){
                set_error($field,ucfirst($alias) . " Đã Tồn Tại");
                return false;
            }
        }
        return true;
    }

    private  function sendMail($config){

        if(!$config){
            return false;
        }
        return mail($config["email"],$config["title"],$config["body"],"FROM : localhost");

    }

    public   function  checkEmail($check = ""){

        $email = isset($_POST["forget_email"]) ? $_POST['forget_email'] : FALSE;
        $inValidEmail  = validateEmail($email);

        if(!$inValidEmail){
            echo(json_encode(["error" => get_error("email")]));
            return FALSE;
        }

        // kiem tra su ton tai cua email
        if(!$this->user->getRecord(["where" => "email = '{$email}'"])){
            echo(json_encode(["error" => "Email không tồn tại"]));
            return FALSE;
        }

        delete_error();
        if(!$check){
            echo(json_encode(["error" => FALSE]));
        }
        return $email;
    }
}
