<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/18/2016
 * Time: 4:12 PM
 */
class HomeCtr extends  MY_controller{

    public  function  __construct(){
        parent::__construct();
        // load model;
        $this->load_model("user");
    }

    public function index(){

        $data["title"]="Trang Chủ";
        $data["subView"]="admin/home/index";
        $this->load_view("admin/index",$data);
    }

    public  function login(){

        if(!empty($_POST))
        {
            $name = isset($_POST['username']) ? $_POST['username'] : '';
            $pass = isset($_POST['password']) ? $_POST['password'] : '';

            if(!(validateString("username","Tên Đăng Nhập",$name) || !validateString("password","Mật Khẩu",$pass))){
                goto next;
            }
            $username = $this->user->getUserBy(["where" => "username = '{$name}' AND active = ''"]);
            if(!$username){
                set_error("username","Tên đăng nhập không tồn tại");
            }
            else {
                $admin = $this->user->getUserBy(['where'=>"username = '$name' AND password ='".md5($pass)."'"]);
                if(!$admin) {
                    set_error("password","Password không hợp lệ !!!");
                }
                else {
                    // thuc hien kiem tra quyen dang nhap.
                    if($admin->getLevel() != 1){ ?>
                           <script>
                               alert("Bạn Không Có Quyền Quản Trị");
                               window.location.href = base_url("admin/");
                           </script>
                     <?php
                    }else{
                        set_login(["id" => $admin->getId(), "username" => $admin->getUsername()],"admin");
                        delete_error();
                        redirect_to(base_url("admin/homeCtr/"));
                    }
                }
            }
        }
        next:
        $data["title"]="Login";
        $data["subView"]="admin/home/login";
        $this->load_view("admin/null",$data);
    }
    public function logout(){
        if(is_loged("admin")){
            delete_login("admin");
            redirect_to(base_url("admin/homeCtr/"));
        }
    }
}
?>
