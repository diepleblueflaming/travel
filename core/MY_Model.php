<?php

class MY_Model
{
    private static $dbConnect;
    protected $table;

    public function __construct(){
        $this->dbConnect = mysqli_connect(SERVER_NAME, USER_NAME, PASSWORD, DATABASE, PORT) or die ('Không thể kết nối....'.mysqli_error($this->dbConnect));
        mysqli_set_charset($this->dbConnect,"utf8");
        date_default_timezone_set("Asia/Ho_Chi_Minh");
    }

    // update or add data
    public function  storeData($data = [], $options = []){

        if(is_object($data)){
            $data = json_decode($data->__toString());
        }

//        if(isset($data['id']))
//            unset($data['id']);

        $where = $values = $keys = $vals = [];
        // Lưu trũ data UPDATE/INSERT

        if ((is_object($data) && isset($data->id)) || (is_array($data) && isset($data["id"])))
            $id = is_object($data) ? intval($data->id) : (int)$data["id"];
        else
            $id = 0;


        if((isset($options['where']) && $options['where']) || $id){
            $where = ($id == 0) ? "WHERE {$options['where']}" : "WHERE id = {$id}";
        }

        unset($data->id);

        foreach ($data as $key => $val) {
            $values[] = " {$key} = '{$val}'";
            $keys[] = $key;
            $vals[] = is_numeric($val) || $val === NULL ?  $val : "'" . $val . "'";
        }

        if ($where)
            $sql = "UPDATE {$this->table} SET " . implode(' ,', $values) . " {$where}";

        else{
            $sql = "INSERT INTO {$this->table} (" . implode(" ,", $keys) . " ) VALUES  (" . implode(" ,", $vals) . ")";
        }

        //mysqli_query($this->dbConnect,"SET NAMES utf8;");
        $r = mysqli_query($this->dbConnect, $sql) or exit(mysqli_error($this->dbConnect));
        return ((int)($this->dbConnect->affected_rows > 0));
    }


    public function my_delete($option = array()){
        $where = isset($option['where']) ? ' WHERE ' . $option['where'] : '';
        $sql = "DELETE FROM {$this->table} $where";
        $r = mysqli_query($this->dbConnect, $sql) or exit ($this->dbConnect->error);
        return ($this->dbConnect->affected_rows > 0);
    }

    public function  get_list($options = array())
    {
        $select = isset($options['select']) && $options['select'] ? $options['select'] : '*';
        $where = isset($options['where']) && $options['where'] ? 'WHERE ' . $options['where'] : '';
        $order_by = isset($options['order_by']) && $options['order_by'] ? 'ORDER BY ' . $options['order_by'] : '';
        $limit = isset($options['limit']) && $options["limit"] && isset($options['offset']) && $options["offset"] ? ' LIMIT ' . $options['offset'] . ' ,' . $options['limit'] : '';

        $sql = "SELECT $select FROM {$this->table} $where $order_by $limit ";

        $result = mysqli_query($this->dbConnect, $sql) or die($this->dbConnect->error);
        if($result) {
            $results = [];
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $results[] = $row;
                }
                mysqli_free_result($result);
                return arr_to_obj($results,$this->table);
            }
        }
        return false;
    }

    public  function getRecord($options = []){

        $select = isset($options['select']) ? $options['select'] : '*';
        $where = isset($options['where']) ? 'WHERE ' . $options['where'] : '';

        $sql = "SELECT $select FROM {$this->table} $where";

        $result = mysqli_query($this->dbConnect,$sql);

        if($result) {
            return arr_to_obj(mysqli_fetch_assoc($result),$this->table);
        }
        return false;
    }


    public function get($sql){
        $result = $this->dbConnect->query($sql) or die($this->dbConnect->error);

        $arr = [];
        while($row = mysqli_fetch_assoc($result)) {
            $arr[] = $row;
        }
        return $arr;
    }

    public  function escape($string){
        return mysqli_real_escape_string($this->dbConnect,$string);
    }


    public function getTotalRecord(){

        $sql = "SELECT id FROM {$this->table}";

        $result = $this->get($sql);
        return count($result);
    }

}?>
