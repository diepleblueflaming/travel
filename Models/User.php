<?php
if (!defined("PATH_SYSTEM")) die("Bad Requested");

class User extends MY_Model{

    private $id;
    private $username;
    private $address;
    private $phone;
    private $email;
    private $password;
    private $active;
    private $level;

    public function __construct($rows = []){
        foreach($rows as $key => $val){
            if($key != $this->table){
                $this->{$key} = $val;
            }
        }
    }

    public function create(){
        parent::__construct();
        $this->table = "user";
    }

    /**
     * @return String
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param String $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return String
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param String $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param Int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return Int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param String $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function __toString(){
        return json_encode([
           "id" => $this->id,
           "username" => $this->username,
           "password" => $this->password,
           "address" => $this->address,
           "email" => $this->email,
           "phone" => $this->phone,
           "active" => $this->active,
           "level" => $this->level
        ]);
    }


    public function add($user)
    {
        return $this->storeData($user);
    }

    public function update($user)
    {
        return $this->storeData($user);
    }

    public function getList($options)
    {
        $where = isset($options["where"]) && $options["where"] ?
            "{$options['where']["field"]} LIKE '%{$options['where']["key"]}%'" : "";
        $orderBy = isset($options["orderBy"]) && $options["orderBy"] ? $options["orderBy"] : "";
        $limit = isset($options["limit"]) && $options["limit"] ? $options["limit"] : "";
        $offset = isset($options["offset"]) && $options["offset"] ? $options["offset"] : "";

        $result = $this->get_list(["limit" => $limit,"offset" => $offset,"order_by" => $orderBy, "where" => $where]);

        if($result){
            return $result;
        }
        return [];
    }

    public function delete($id){
        return parent::my_delete(['where' => "id = {$id}"]);
    }

    public function getUserById($id){

        return $this->getRecord(['where' => "id = {$id}"]);
    }

    public  function  activeUser($e,$ac){

        $options = [
            "where" => " email = '{$e}' AND active = '{$ac}'"
        ];
        return $this->storeData(["active" => NULL],$options);
    }

    public  function  updatePassword($password,$email){

        $options = [
            "where" => " email = '{$email}'"
        ];
        return $this->storeData(["password" => $password],$options);
    }

    public function getUserBy($options){
        return $this->getRecord($options);
    }
}