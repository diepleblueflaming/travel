<?php
if (!defined("PATH_SYSTEM")) die("Bad Requested");

class Category extends MY_Model{

    private $id;
    private $title;
    private $parent_id;
    private $created;

    public function __construct($rows = []){
        foreach($rows as $key => $val){
            if($key != $this->table){
                $this->{$key} = $val;
            }
        }
    }

    public function  create(){
        parent::__construct();
        $this->table = "category";
    }


    /**
     * @return String
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param  $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
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
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function __toString(){
        return json_encode([
            "id" => $this->id,
            "title" => $this->title,
            "parent_id" => $this->parent_id,
            "created" => $this->created,
        ]);
    }

    public function getCategoryById($id){
        return $this->getRecord(['where' =>"id = {$id}"]);
    }

    public function getList($options){

        $where = $limit = $orderBy = "";

        if(isset($options["where"]) && $where = $options["where"]){
            $field  =  ( $where["field"] == "category" ) ? "cat.title" : "c.".$where["field"];
            $where = "WHERE {$field} LIKE  '%{$where['key']}%'";
        }

        if(isset($options["limit"]) && $options["limit"] && isset($options["offset"]) && $options["offset"]){
            $limit = "LIMIT {$options["offset"]},{$options["limit"]}";
        }

        if(isset($options["orderBy"]) && $options["orderBy"]){
            if(isset($options["orderBy"]) && $options["orderBy"]){
                $orderBy = "ORDER BY {$options['orderBy']}";
            }
        }

        $sql = "SELECT c.title,c.id,cat.title as parent_id
                FROM category c LEFT JOIN category cat ON c.parent_id = cat.id
                {$where}
                {$orderBy}
                {$limit}";

        return arr_to_obj($this->get($sql),$this->table);
    }


    public function delete($id){
        return parent:: my_delete(['where' => "id = {$id}"]);
    }

    public function add($category){
        return $this->storeData($category);
    }

    public function update($category){
        return $this->storeData($category);
    }
}