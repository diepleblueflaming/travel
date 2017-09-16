<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/17/2016
 * Time: 11:34 PM
 */
if (!defined("PATH_SYSTEM")) die("Bad Requested");

class CategoryCtr extends MY_controller {

    public  function  __construct(){
        parent::__construct();
        $this->load_model("category");
        delete_sort();
    }

    public  function index()
    {
        $this->load_library("pagination");

        // xu ly tim kiem.
        $field = isset($_POST["field"]) && in_array($_POST["field"],["content","title","sender","category"])
            ? $_POST["field"] : "";
        $keyword = isset($_POST["keyword"]) && validateString("data","data",$_POST["keyword"]) ?  $_POST["keyword"] : "";
        delete_error();
        $where  = $field && $keyword ? ["field" => $field,"key" => $keyword ] : "";

        $options = [
            "where" => $where,
            "orderBy" => $this->sort(["id","title","parent_id"])
        ];
        $list = $this->category->getList($options);

        $configs = array(
            'current_page'=>isset($_GET['page']) ? $_GET['page'] : 1,
            'total_page'=> 0,
            'total_record'=>count($list),
            'limit'=> 7,
            'start'=> 0,
            'max'=> 0,
            'min'=> 0,
            'link_full'=>base_url("admin/categoryCtr/page/{page}"),
            'link_first'=>'',
            'range'=>5
        );

        $pagination = new pagination();
        $pagination->init($configs);
        $data["list"]= array_splice($list,$pagination->config["start"],$pagination->config["limit"]);

        $data["pagination"] = $pagination;
        $data["title"]="Category Management";
        $data["subView"]="admin/category/index";
        $data["module"]="categoryCtr";

        $this->load_view("admin/index",$data);
    }

    public function add()
    {
        $data["parentCategory"] = $this->category->get_list(["where"=>"parent_id = 0"]);

        if(!empty($_POST))
        {
            $title = isset($_POST['title']) ? $_POST['title'] : '';

            if(!validateString("title","Tiêu Đề",$title,["no_numeric" => true])){
                goto next;
            }

            $parent_id = isset($_POST['parent_id']) && preg_match_all("/[\d]+/",$_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;

            if($this->checkData("title",$title))
            {
                $category = new Category([
                    "title" => $title,
                    "parent_id" => $parent_id,
                    "created" => date("Y-m-d H:i:s",time())
                ]);

                if($this->category->add($category)){ ?>
                    <script>
                        alert("Thêm Chuyên Mục Thành Công!!!!");
                        window.location = '<?=base_url("admin/categoryCtr/")?>';
                    </script>
                <?php }else{ ?>
                    <script>
                        alert("Thêm Chuyên Mục Thành Công!!!!");
                        window.location = '<?=base_url("admin/categoryCtr/")?>';
                    </script>
                <?php }
                exit;
            }
        }

        next:
        $data["title"]="Thêm Chuyên Mục";
        $data["subView"]="admin/category/add_or_update";
        $this->load_view("admin/index",$data);
    }

    public function update()
    {
        $data["parentCategory"]=$this->category->get_list(["where"=>"parent_id = 0"]);

        $id = isset($_GET["id"]) && filter_var($_GET["id"],FILTER_VALIDATE_INT) ? (int)$_GET["id"] : 0;

        $category = $this->category->getCategoryById($id);

        if(!$category){
            redirect_to(base_url("admin/categoryCtr/"));
        }

        if(!empty($_POST)) {

            $title = isset($_POST['title']) ? $_POST['title'] : '';

            if(!validateString("title","Tiêu Đề",$title,["no_numeric" => true])){
                goto next;
            }

            $parent_id = isset($_POST['parent_id']) && preg_match_all("/[\d]+/",$_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;


            if($this->checkData("title",$title,$id)) {

                $category = new Category([
                    "title" => $title,
                    "parent_id" => $parent_id,
                    "id" => $id,
                    "created" => $category->getCreated()
                ]);

                if ($this->category->update($category)) { ?>
                    <script>
                        alert("Sửa Chuyên Mục Thành Công !!!");
                        window.location = '<?=base_url("admin/categoryCtr/")?>';
                    </script>
                <?php
                } else { ?>
                    <script>
                        alert("Sửa Chuyên Mục Thất Bại!!!");
                        window.location = '<?=base_url("admin/categoryCtr/")?>';
                    </script>
               <?php }
                exit;
            }
        }

        next :

        $data["category"] = $category;
        $data["title"]="Sửa Chuyên Mục";
        $data["subView"]="admin/category/add_or_update";
        $this->load_view("admin/index",$data);
    }

    public function delete()
    {
        if (filter_var($_POST['category_del'], FILTER_VALIDATE_INT)) {
            $id  = (int)$_POST['category_del'];

            if ($this->category->delete($id)) { ?>
                <script>
                    alert("Xóa Thành Công!!!!");
                    window.location = '<?=base_url("admin/categoryCtr/")?>';
                </script>

            <?php } else { ?>
                <script>
                    alert('Đã có lỗi xảy ra không thể xóa');
                    window.location = '<?base_url("admin/categoryCtr/")?>';
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
        foreach ($ids as $id) {
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $this->category->delete($id);
            }
        }
    }

    private  function  checkData($field,$data, $id = 0){
        delete_error();

        if($id) {
            if ($this->category->getRecord(["where" => "{$field} = '{$data}' AND id != {$id}"])){
                set_error("title",ucfirst($field) . " Đã Tồn Tại");
                return false;
            }
        }
        else {
            if ($this->category->getRecord(["where" => "{$field} = '{$data}'"])){
                set_error("title",ucfirst($field) . " Đã Tồn Tại");
                return false;
            }
        }
        return true;
    }
}
?>