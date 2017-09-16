<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/27/2016
 * Time: 5:13 PM
 */

class user extends  P_Controller{
    // ham lay ra danh sach ngupi dung.
    public function getList(){

        // lay du lieu tu model.
        $data = $this->model->getListUser();

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("user",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
    // lay ra 1  ngupi dung.
    public function getSingle(){
        // lay ra id cua chuyen muc.
        $id = intval($_GET['id']);
        // lay du lieu tu model.
        $data = $this->model->getUser($id);

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("user",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }

    // ham them hoac sua nguoi dung.
    public function add_or_edit_User(){
        // mang luu bien loi.
        $errors = array();

        $user['id'] = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $user['username'] = (isset($_POST['username']) && !empty($_POST['username']))
            ? $this->model->escape($_POST['username']) : null;
        $user['email'] = isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)
            ? $this->model->escape($_POST['email']) : null;
        $user['address'] = (isset($_POST['address']) && !empty($_POST['address']))
            ? $this->model->escape($_POST['address']) : null;
        $user['phone'] = (isset($_POST['phone']) && preg_match("/[0-9]{9,11}/",$_POST['phone']))
            ? $this->model->escape($_POST['phone']) : null;
        $user['level'] = isset($_POST['level']) && !empty($_POST['level']) ? intval($_POST['level']) : 0;

        if(!$user['username']){
            $errors['username'] = 'Ban chua nhap tieu de';
        }
        if(!$user['email']){
            $errors['email'] = 'Ban chua nhap dia chi email';
        }
        if(!$user['address']){
            $errors['address'] = 'Ban chua nhap dia chi';
        }
        if(!$user['phone']){
            $errors['phone'] = 'Ban chua nhap so dien thoai';
        }if(!$user['level']){
            $errors['level'] = 'Ban chua nhap level';
        }

        // neu co loi bao loi ve client
        if(!empty($errors)){
            exit(json_encode($errors));
        }
        // kiem tra ton tai.
        $this->check_exist($user['username'],$user['email'],$user['phone'],$user['id']);

        // neu luu tru data thanh cong bao loi rong.
        if($this->model->storeData("user",$user)){
            exit(json_encode($errors));
        }

        // neu khong bao loi.
        $errors['error'] = "Da co loi xay ra";
        exit(json_encode($errors));
    }

    // ham kiem tra neu username hoac eamil hoac phone da ton tai.
    public  function check_exist($username,$email,$phone,$id){

        // neu co tryen vao id.
        $check_id = "";
        if($id){
            $check_id = " AND id!=".$id;
        }

        $data = $this->model->get_list("user",array("where"=>" (username = '{$username}' OR email = '{$email}'
            OR phone = {$phone} ) {$check_id}"));

        if($data) {
            foreach ($data as $item) {
                if ($item['username'] === $username) {
                    $errors['username'] = 'Ten su dung da ton tai';
                }
                if ($item['email'] === $email) {
                    $errors['email'] = 'Email da ton tai';
                }
                if ($item['phone'] === $phone) {
                    $errors['phone'] = 'So dien thoai da ton tai';
                }
            }
        }

        // neu co loi bao looi ve client
        if(!empty($errors)){
            exit(json_encode($errors));
        }
    }

    // ham xoa chuyen muc.
    public function deleteUser(){

        $errors = array();
        // lay ra id.
        preg_match("/[0-9]+/",file_get_contents("php://input","id"),$id);
        $id = intval($id[0]);
        // neu chua chuyen vao id bao loi.
        if(empty($id)){
            $errors['error'] = "Ban chua chuyen vao id";
            exit(json_encode($errors));
        }
        // neu xoa thanh cong . bao loi rong.
        if($this->model->db_delete("user",array("where"=>"id = {$id}"))){
            exit(json_encode($errors));
        }

        $errors['error'] = "Da co loi xay ra";
        exit(json_encode($errors));
    }
} 