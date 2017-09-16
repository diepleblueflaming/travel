<?php

class comment extends P_Controller{

    // ham lay ra danh sach chuyen muc.
    public function getList(){

        // lay du lieu tu model.
        $data = $this->model->getListComment();

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("comment",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
    // lay ra 1 chuyen muc.
    public function getSingle(){
        // lay ra id cua chuyen muc.
        $id = intval($_GET['id']);
        // lay du lieu tu model.
        $data = $this->model->getComment($id);

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("comment",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
}
?>