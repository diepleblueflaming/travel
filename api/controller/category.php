<?php

class category extends P_Controller{

    // ham lay ra danh sach chuyen muc.
    public function getList(){

        // lay du lieu tu model.
        $data = $this->model->getListCategory();

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("category",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
    // lay ra 1 chuyen muc.
    public function getSingle(){
        // lay ra id cua chuyen muc.
        $id = intval($_GET['id']);
        // lay du lieu tu model.
        $data = $this->model->getCategory($id);

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("category",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
}
?>