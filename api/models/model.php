<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/2/2016
 * Time: 10:19 AM
 */

class model extends database{

        // lay ra danh sach cac chuyen muc.
        public function  getListCategory(){
            return $this->get_list("category c LEFT JOIN category cat ON c.parent_id=cat.id",array(
                        "select"=>"c.id,c.title,cat.title as chuyen_muc_cha"));
        }

        // lay chuyen muc theo id
        public function getCategory( $id){
            return $this->get_list("category c LEFT JOIN category cat ON c.parent_id=cat.id",array(
                "select"=>"c.id,c.title,cat.title as chuyen_muc_cha","where"=>" c.id = {$id}"));
        }

        // lay ra danh sach cac tin tuc
        public function  getListNews(){
            return $this->get_list("news n join user u on n.sender=u.id left join page_view p on n.id=p.page_id
                join category c on n.category=c.id group by(p.page_id)",
                array("select"=>"n.id,n.title,n.content,n.detail_content,n.date_create,u.username as sender
                ,c.title as category,count(p.page_id) as views"));
        }

        // lay ra mot tin tuc theo id
        public function getNews($id){
            return $this->get_list("news n join user u on n.sender=u.id left join page_view p on n.id=p.page_id
                join category c on n.category=c.id",
                array("select"=>"n.id,n.title,n.content,n.detail_content,n.date_create,u.username as sender
                ,c.title as category,count(p.page_id) as views","where"=>"n.id = {$id} group by(p.page_id)"));
        }

        // ham lay tat ca cac comment
        public function getListComment(){
            return $this->get_list(" comment c JOIN news n ON c.news_comment = n.id",
                array("select"=>"c.*,n.title as news"));
        }

        // ham lay ra mot comment theo id
        public function getComment($id){
            return $this->get_list(" comment c JOIN news n ON c.news_comment = n.id",
                array("select"=>"c.*,n.title as news","where"=>"c.id= {$id}"));
        }

        // ham lay tat ca cac nguoi dung
        public function getListUser(){
            return $this->get_list("user",array("select"=>"id,username,phone,address,phone,level,email"));
        }

        // ham lay ra mot nguoi dung theo id
        public function getUser($id){
            return $this->get_list("user",
                array("select"=>"id,username,phone,address,phone,level,email","where"=>"id= {$id}"));
        }
}
?>