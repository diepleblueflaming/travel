<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/18/2016
 * Time: 3:34 PM
 */
if (!defined("PATH_SYSTEM")) die("Bad Requested");
class UserCtr extends MY_controller{

    public function __construct(){
        parent::__construct();
        $this->load_model("user");
        delete_sort();
    }

    public function  index()
    {
        $this->load_library("pagination");

        // neu co loc ket qua
        $field = isset($_POST["field"]) && in_array($_POST["field"],["username","email","address","phone"])
            ? $_POST["field"] : "";
        $keyword = isset($_POST["keyword"]) && validateString("data","data",$_POST["keyword"],["except" => ["@","\."]]) ?  $_POST["keyword"] : "";
        delete_error();
        $where  = $field && $keyword ? ["field" => $field,"key" => $keyword ] : "";

        $options = [
            "where" => $where,
            "orderBy" => $this->sort(["id","username","email","address","level","phone"])
        ];

        $list = $this->user->getList($options);

        $configs = array(
            'current_page'=>isset($_GET['page']) ? $_GET['page'] : 1,
            'total_page'=>0,
            'total_record'=> count($list),
            'limit'=>7,
            'start'=>0,
            'max'=>0,
            'min'=>0,
            'link_full'=>base_url("admin/userCtr/page/{page}"),
            'link_first'=>'',
            'range'=>5
        );

        $pagination = new pagination();
        $pagination->init($configs);
        $data["list"]= array_splice($list,$pagination->config["start"],$pagination->config["limit"]);

        $data["pagination"] = $pagination;
        $data["title"]="User Management";
        $data["subView"]="admin/user/index";
        $data["module"]="userCtr";
        $this->load_view("admin/index",$data);
    }


    public  function add()
    {
        if(!empty($_POST)) {

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $level = isset($_POST['level']) ? (int)$_POST['level'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';


            $inValidName = validateString("username","Tên Đăng Nhập",$username);
            $inValidPass = validateString("password","Mật Khẩu",$password);
            $inValidLevel = validNumeric("level","Level",$level);
            $inValidEmail = validateEmail($email);
            $inValidAddress = validateString("address","Địa Chỉ",$address);
            $inValidPhone = validNumeric("phone","Số Điện Thoại",$phone);

            if(!$inValidName || !$inValidPass || !$inValidLevel || !$inValidEmail || !$inValidAddress || !$inValidPhone){
                goto next;
            }

            if($this->checkData("username","Tên Đăng Nhập",$username) & $this->checkData("email","Email",$email)
                & $this->checkData("phone","Số Điện Thoại",$phone)) {

                $user = new User([
                    "username" => $username,
                    "password" => md5($password),
                    "level" => $level,
                    "email" => $email,
                    "address" => $address,
                    "phone" => $phone,
                    "active" => NULL
                ]);

                if($this->user->add($user)){ ?>
                    <script>
                        alert("Thêm Thành Viên Thành Công !!!");
                        window.location.href = '<?=base_url("admin/userCtr/")?>';
                    </script>
                <?php } else { ?>
                    <script>
                        alert("Thêm Thành Viên Thất Bại !!!!");
                        window.location.href = '<?=base_url("admin/userCtr/")?>';
                    </script>
                <?php }
                delete_data();
                exit;
            }
        }

        next :
        $data["title"]=" Thêm Người Dùng ";
        $data["subView"]="admin/user/add_or_update";
        $this->load_view("admin/index",$data);
    }


    public  function update(){

        $id = isset($_GET["id"]) && filter_var($_GET["id"],FILTER_VALIDATE_INT) ? (int)$_GET["id"] : 0;

        $user = $this->user->getUserById($id);

        if(!$user){
            redirect_to(base_url("admin/userCtr/"));
        }

        if(!empty($_POST)) {

            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $level = isset($_POST['level']) ? (int)$_POST['level'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $address=isset($_POST['address']) ? $_POST['address'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';


            $inValidName = validateString("username","Tên Đăng Nhập",$username);
            $inValidPass = $password ? validateString("password","Mật Khẩu",$password) : true ;
            $inValidLevel = validNumeric("level","Level",$level);
            $inValidEmail = validateEmail($email);
            $inValidAddress = validateString("address","Địa Chỉ",$address);
            $inValidPhone = validNumeric("phone","Số Điện Thoại",$phone);

            if(!$inValidName || !$inValidPass || !$inValidLevel || !$inValidEmail || !$inValidAddress || !$inValidPhone){
                goto next;
            }

            if($this->checkData("username","Tên Đăng Nhập",$username,$id) & $this->checkData("email","Email",$email,$id)
                & $this->checkData("phone","Số Điện Thoại",$phone,$id)) {

                $user = new User([
                    "id" => $id,
                    "password" => $password ? md5($password) : $user->getPassword(),
                    "username" => $username,
                    "level" => $level,
                    "email" => $email,
                    "address" => $address,
                    "phone" => $phone,
                    "active" => NULL
                ]);


                if($this->user->update($user)){ ?>
                    <script>
                        alert("Cập Nhật Thành Viên Thành Công !!!");
                        window.location.href = '<?=base_url("admin/userCtr/")?>';
                    </script>
                <?php } else { ?>
                    <script>
                        alert("Cập Nhật Thành Viên Thất Bại !!!!");
                        window.location.href = '<?=base_url("admin/userCtr/")?>';
                    </script>
                <?php }
                delete_data();
                exit;
            }
        }

        next :
        $data["user"] = $user;
        $data["title"]=" Cập Nhật Người Dùng ";
        $data["subView"]="admin/user/add_or_update";
        $this->load_view("admin/index",$data);
    }


    public function delete()
    {
        if (filter_var($_POST['user_del'], FILTER_VALIDATE_INT)) {
            $id  = (int)$_POST['user_del'];

            if ($this->user->delete($id)) { ?>
                <script>
                    alert("Xóa Thành Công!!!!");
                    window.location = '<?=base_url("admin/userCtr/")?>';
                </script>

            <?php } else { ?>
                <script>
                    alert('Đã có lỗi xảy ra không thể xóa');
                    window.location = '<?base_url("admin/userCtr/")?>';
                </script>
            <?php }
            exit;
        }
        else
            exit("Are you hacking my website ???");
    }

    public function deleteSelected()
    {
        $ids = json_decode($_POST["ids"]);
        foreach($ids as $id)
        {
            if(filter_var($id,FILTER_VALIDATE_INT)){
                $this->user->delete($id);
            }
        }
    }

    private function  checkData($field, $alias, $data, $id = 0){
        delete_error($field);

        if($id) {
            if ($this->user->getRecord(["where" => "{$field} = '{$data}' AND id != {$id}"])){
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

}