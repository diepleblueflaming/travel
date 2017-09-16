<?php
/**
 * Created by PhpStorm.
 * user: Administrator
            * Date: 9/7/2016
        * Time: 9:47 PM
        */
if(!defined("PATH_SYSTEM")) die("Bad Requested");
class Comment extends MY_Model {

    private $id;
    private $content;
    private $news_comment;
    private $user_comment;
    private $status;
    private $date_create;

    public function __construct($rows = []){
        foreach($rows as $key => $val){
            if($key != $this->table){
                $this->{$key} = $val;
            }
        }
    }

    public function create(){
        parent::__construct();
        $this->table = "comment";
    }

    /**
     * @return String
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param String $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Int
     */
    public function getNewsComment()
    {
        return $this->news_comment;
    }

    /**
     * @param Int $news_comment
     */
    public function setNewsComment($news_comment)
    {
        $this->news_comment = $news_comment;
    }

    /**
     * @return Int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return String
     */
    public function getUserComment()
    {
        return $this->user_comment;
    }

    /**
     * @param String $user_comment
     */
    public function setUserComment($user_comment)
    {
        $this->user_comment = $user_comment;
    }

    /**
     * @return String
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param String $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }



    public function __toString(){
        return json_encode([
            "id" => $this->id,
            "content" => $this->content,
            "news_comment" => $this->news_comment,
            "user_comment" => $this->user_comment,
            "status" => $this->status,
            "date_create" => $this->date_create
        ]);
    }

    public function getCommentById($id){
        return $this->getRecord(['where' => "id = {$id}"]);
    }

    public  function getList($options){

        $where = $limit = $orderBy = "";

        if(isset($options["where"]) && $where = $options["where"]){
            $field = in_array($where["field"],["content","user_comment"]) ? "c.".$where["field"] : "n.title";
            $where = "WHERE {$field} LIKE '%{$where['key']}%'";
        }

        if(isset($options["limit"]) && $options["limit"] && isset($options["offset"]) && $options["offset"]){
            $limit = "LIMIT {$options["offset"]},{$options["limit"]}";
        }

        if(isset($options["orderBy"]) && $options["orderBy"]){
            $orderBy = "ORDER BY {$options['orderBy']}";
        }


        $sql = "SELECT c.id,c.content,c.date_create,n.title as news_comment,c.user_comment,c.status
                FROM comment c JOIN news n ON c.news_comment = n.id
                {$where}
                {$orderBy}
                {$limit} ";

        $result = $this->get($sql);
        return arr_to_obj($result,$this->table);
    }

    public  function  add($comment){
        return $this->storeData($comment);
    }

    public function delete($id){
        return parent::my_delete(['where'=>"id= {$id}"]);
    }

    public function change_status($id,$status){
        return $this->storeData(["status" => $status, "id" => $id]);
    }
}