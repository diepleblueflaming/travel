<?php
    header("Content-Type: text/html; charset=utf-8");
    define('PATH_SYSTEM', __DIR__ . '/');

    require_once 'config.php';
    require_once 'library/role/role.php';
    require_once 'library/helper.php';
    require_once 'core/MY_Controller.php';
    require_once 'core/MY_Model.php';

    // kiem tra xem co ton tai controller va action hay khong.
    $controller = isset($_GET['c']) ? chuanhoa($_GET['c']) : CONTROLLER_DEFAULT;
    $action = isset($_GET['a']) ? chuanhoa($_GET['a'], false) : ACTION_DEFAULT;

    // duong dan toi file controller.
    $path = CONTROLLER_PATH.'/site/' . $controller .'.php';

    if (!file_exists($path)){
        die("Controller Không Tồn Tại !!!!!!!!!!!!!!!");
    }

    require_once $path;

    // kiem tra xem class co ton tai hay khong.
    if(!class_exists($controller)){
        die("Controller Không Tồn Tại !!!!!!!!!!!!!!!");
    }

    // khoi tao controller
    $ctr = new $controller();

    // kiem tra xem co ton tai action hay không
    if(!method_exists($ctr,$action)){
        exit("Không Tồn Tại Action");
    }

    // load action
    $ctr -> $action();
?>
