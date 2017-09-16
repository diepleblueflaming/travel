<?php

class news extends P_Controller{

    // ham lay ra danh sach chuyen muc.
    public function getList(){

        // lay du lieu tu model.
        $data = $this->model->getListNews();

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("news",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
    // lay ra 1 chuyen muc.
    public function getSingle(){

        // lay ra id cua tin ruc.
        $id = intval($_GET['id']);

        // lay du lieu tu model.
        $data = $this->model->getNews($id);

        // chuyen doi du lieu tuy thuoc va dang request.
        $res = $this->rest_handler->getData("news",$this->contentType,$data);

        if($res){
            echo $res;
        }
    }
}
?>