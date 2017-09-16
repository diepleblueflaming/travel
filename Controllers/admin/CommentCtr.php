<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/19/2016
 * Time: 9:55 AM
 */

class CommentCtr extends MY_controller{

    public function __construct(){
        parent::__construct();
        $this->load_model("comment");
        delete_sort();
    }

    public  function index(){

        $this->load_library("pagination");
        // phan tim kiem.
        $field = isset($_POST["field"]) && in_array($_POST["field"],["content","user_comment","news_comment"])
            ? $_POST["field"] : "";
        $keyword = isset($_POST["keyword"]) && validateString("data","data",$_POST["keyword"]) ?  $_POST["keyword"] : "";
        delete_error();
        $where  = $field && $keyword ? ["field" => $field,"key" => $keyword ] : "";

        $options = [
            "where" => $where,
            "orderBy" => $this->sort(["id","date_create","news_comment","user_comment","status"])
        ];
        $list = $this->comment->getList($options);

        $configs = array(
            'current_page'=>isset($_GET['page']) ? $_GET['page'] : 1,
            'total_page'=> 0,
            'total_record' => count($list),
            'limit'=> 7,
            'start'=> 0,
            'max'=> 0,
            'min'=> 0,
            'link_full'=>base_url("admin/commentCtr/page/{page}"),
            'link_first'=>'',
            'range'=>5
        );

        $pagination = new pagination();
        $pagination->init($configs);
        $data["list"]= array_splice($list,$pagination->config["start"],$pagination->config["limit"]);

        $data["pagination"] = $pagination;
        $data["title"]="Quản Lý Bình Luận";
        $data["subView"]="admin/comment/index";
        $data["module"]="commentCtr";
        $this->load_view("admin/index",$data);
    }

    public function delete()
    {
        if (filter_var($_POST['comment_del'], FILTER_VALIDATE_INT)) {
            $id  = (int)$_POST['comment_del'];

            if ($this->comment->delete($id)) { ?>
                <script>
                    alert("Xóa Thành Công!!!!");
                    window.location = '<?=base_url("admin/commentCtr/")?>';
                </script>

            <?php } else { ?>
                <script>
                    alert('Đã có lỗi xảy ra không thể xóa');
                    window.location = '<?base_url("admin/commentCtr/")?>';
                </script>
            <?php }
            exit;
        }
        else
            exit("Are you hacking my website ???");
    }

    public function deleteSelected()
    {
        $ids = json_decode($_POST["ids"]);
        foreach($ids as $id)
        {
            if(filter_var($id,FILTER_VALIDATE_INT)){
                $this->comment->delete($id);
            }
        }
    }

    public  function changeStatus(){

        $id = isset($_POST["id"]) && preg_match("/^[0-9]+$/",$_POST["id"]) ? (int)$_POST["id"] : '';
        $status = isset($_POST["status"]) && in_array((int)$_POST["status"],[0,1]) ? (int)$_POST["status"] : '';

        if($id && is_numeric($status)) {
            if( $this->comment->change_status($id,$status)){
                exit(json_encode(["success" => true]));
            };
            exit(json_encode(["success" => false]));
        }
    }

}
?>