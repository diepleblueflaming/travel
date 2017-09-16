<?php

    // include cac file can thiet.
    include_once '../library/database/database.php';
    include_once '../config.php';
    include_once "helper/simpleRest.php";
    include_once "helper/RestHandler.php";
    include_once "models/model.php";
    include_once "controller/P_Controller.php";

    // lay ra controller.
    $controller = $_GET['c'];
    $action = $_GET['a'];
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = strtolower($_SERVER['REQUEST_METHOD']). $action;
    }

    // neu khong ton tai controller
    if(!file_exists("controller/".$controller.".php")){
        exit("Khong Ton Tai Controller");
    }

    // load file controller vao.
    require_once "controller/".$controller.".php";
    // khoi tao doi tuong va chay method index.
    $c = new $controller();

    // neu khong ton tai phuong thuc.
    if(!method_exists($c,$action)){
        die("Khong ton tai action");
    }

    // ham chay phuong thuc.
    $c->$action();

?>