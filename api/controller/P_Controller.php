<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/27/2016
 * Time: 3:40 PM
 */

class P_Controller {

    // cac thuoc tinh.
    protected  $model;
    protected $contentType;
    protected $rest_handler;

    public function __construct(){
        $this->model = new model();
        $this->contentType = $_SERVER['HTTP_ACCEPT'];
        $this->rest_handler = new RestHandler();
    }

} 