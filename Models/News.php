<?php
if(!defined("PATH_SYSTEM")) die("Bad Requested");

class News extends MY_Model{

    private $id;
    private $category;
    private $title;
    private $content;
    private $detail_content;
    private $date_create;
    private $image;
    private $sender;
    private $status;


    public function __construct($rows = []){
        foreach($rows as $key => $val){
            if($key != $this->table){
                $this->{$key} = $val;
            }
        }
    }

    public function create(){
        parent::__construct();
        $this->table = "news";
    }

    /**
     * @return Int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * @return Date
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param Date $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }

    /**
     * @return String
     */
    public function getDetailContent()
    {
        return $this->detail_content;
    }

    /**
     * @param String $detail_content
     */
    public function setDetailContent($detail_content)
    {
        $this->detail_content = $detail_content;
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
     * @return String
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param String $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Int
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param Int $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param String $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }



    public function __toString(){
        return json_encode([
            "id" => $this->id,
            "category" => $this->category,
            "title" => $this->title,
            "content" => $this->content,
            "detail_content" => $this->detail_content,
            "image" => $this->image,
            "date_create" => $this->date_create,
            "sender" => $this->sender,
            "status" => $this->status
        ]);
    }

    public function getNewsById($id){

        return $this->getRecord(['where'=>"id = {$id}"]);
    }

    public function getList($options){

        $where = $limit = $orderBy = "";

        if(isset($options["where"]) && $where = $options["where"]){
        }

        if(isset($options["limit"]) && $options["limit"] && isset($options["offset"]) && $options["offset"]){
            $limit = "LIMIT {$options["offset"]},{$options["limit"]}";
        }

        if(isset($options["orderBy"]) && $options["orderBy"]){
            $orderBy = "ORDER BY {$options['orderBy']}";
        }

        $sql = "SELECT n.id,n.title,n.content,n.detail_content,n.date_create,n.image,c.title as category,
                        COUNT(page_id) as view,u.username as sender,n.status
                FROM news n JOIN category c ON n.category = c.id
                LEFT JOIN page_view p ON n.id = p.page_id
                JOIN user u ON n.sender = u.id
                {$where}
                GROUP BY (n.id)
                {$orderBy}
                {$limit}";

        $result = $this->get($sql);
        return $result;
    }

    public function delete($id){
        return parent::my_delete(['where'=>"id = {$id}"]);
    }

    public 	function add($news){
        return $this->storeData($news);
    }

    public  function update($news){
        return $this->storeData($news);
    }

    public function change_status($id,$status){
        return $this->storeData(["status" => $status,"id" => $id]);
    }

    public function getDetailNews($options = []){

        $limit = "";
        $order_by = "";
        $where = "";

        if($options){

            if(isset($options["limit"]) && $options["limit"]){
                $limit = "LIMIT {$options["limit"][1]},{$options["limit"][0]}";
            }

            if(isset($options["order_by"]) && $options["order_by"]){
                $order_by = "ORDER BY {$options["order_by"][0]} {$options["order_by"][1]}";
            }

            if(isset($options["where"]) && ($where = $options["where"])){

                if(isset($where["parent_category_id"]) && ($id = $where["parent_category_id"])){
                    $where = "WHERE n.category IN (SELECT id FROM category WHERE parent_id  = {$id})";
                }

                else if(isset($where["category_id"]) && ($id = $where["category_id"])){
                    $where = "WHERE n.category = {$id}";
                }

                else if(isset($where["id"]) && ($id = $where["id"])){
                    $where = "WHERE n.id = {$id}";
                }else{
                    $where = "WHERE {$where}";
                }

                $where .= " AND n.status = 1";
            }
        }


        $sql = "SELECT n.id,n.content,n.detail_content,n.date_create,n.image,n.title,
                    u.username AS sender,c.title AS category,
                    count(user_ip) AS view_count,table_comment.comment_count
                FROM news n
                JOIN user u ON n.sender = u.id
                LEFT JOIN page_view p ON n.id = p.page_id
                JOIN category c ON n.category = c.id
                JOIN (
                    SELECT news.id,count(news_comment) AS comment_count
                    FROM news
                    LEFT JOIN comment ON news.id = comment.news_comment
                    GROUP BY news.id
                    ) as table_comment ON table_comment.id = n.id
                {$where}
                GROUP BY (n.id)
                {$order_by}
                {$limit}";

        $list  = $this->get($sql);
        return $list;
    }

    public  function find($tag){

        $tag = $this->escape($tag);
        $result = $this->getDetailNews(["where" => "(n.title LIKE '%{$tag}%' OR n.content LIKE '%{$tag}%')"]);
        return $result;
    }

    public function getHotNews(){
        $options = [
            "order_by" => ["id", "DESC"],
            "limit" => [7,0]
        ] ;
        return $this->getDetailNews($options);
    }
}