<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/6/2017
 * Time: 11:15 AM
 */

class MY_Controller {

    protected  $model;
    protected  $view;
    protected  $library;
    protected  $data;

    public function __construct(){

        //delete_error();
        $module = $this->getModule(1);

        if($module == "admin"){
            $this->data['userName'] = isset($_SESSION["admin"]) ? $_SESSION['admin']["username"] : "";
        }else{
            // load model
            $this->load_model("category");
            $this->data["username"] = isset($_SESSION["user"]["username"]) ?  $_SESSION['user']["username"] : "";
            $categories = $this->category->get_list();
           // trigger($categories);
            $this->data["categories"] = $categories;
        }

    }

    public function load($path,$data = []){

        $path = $path.".php";
        if(!file_exists($path)){
            exit("File Không Tồn Tại");
        }

        if($data){
            $this->data = array_merge($this->data,$data);
        }

        if($this->data){
            extract($this->data);
        }

        require_once $path;
    }

    public function load_view($view,$data = []){

       $this->view =  VIEW_PATH."/".$view;
       $this->load($this->view,$data);
    }

    public function load_model($model){

        $path =  MODEL_PATH."/".ucfirst($model);
        $this->load($path);

        $model = substr($path,strripos($path,"/")+1);
        $this->{strtolower($model)} = new $model();
        $this->{strtolower($model)}->create();
    }

    public function load_library($library){

        $this->library  = LIBRARY_PATH."/".$library;
        $this->load($this->library);
    }

    public function getModule($pos){
        $module = $_SERVER['REQUEST_URI'];
        $arr = explode("/", trim($module));
        return $arr[$pos];
    }

    public function alert($message){
        $data["title"] = "Thông Báo";
        $data["message"] = $message;
        $data["subView"]  = "site/common/notification";
        $this->load_view("site/index",$data);
        delete_data();
        delete_error();
        exit;
    }

    public function sort($fields){
        $orderBy = "";
        $module = $this->getModule(2);
        $type = isset($_POST["type"]) && in_array($_POST["type"],["ASC","DESC"]) ? strtoupper($_POST["type"]) : "";
        $field = isset($_POST["field"]) &&
        in_array($_POST["field"],$fields) ? $_POST["field"] : "";

        if($field && $type){
            set_sort($field,$type == "ASC" ? "DESC" : "ASC");
            $orderBy = $field." ".$type;
            $_SESSION["order"] = $orderBy;
        }else if (isset($_SESSION[$module]["order"])){
            $orderBy = $_SESSION[$module]["order"];
        }else{
            $orderBy = "id ASC";
        }
        return $orderBy;
    }
}
