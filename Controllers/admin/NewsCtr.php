<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/19/2016
 * Time: 9:55 AM
 */

class NewsCtr extends MY_controller{

    public function __construct(){
        parent::__construct();
        $this->load_model("news");
        $this->load_model("category");
        delete_sort();
    }

    public  function index(){

        $this->load_library("pagination");

        // xu ly tim kiem.
        $field = isset($_POST["field"]) && in_array($_POST["field"],["content","title","sender","category"])
                    ? $_POST["field"] : "";
        $keyword = isset($_POST["keyword"]) && validateString("data","data",$_POST["keyword"]) ?  $_POST["keyword"] : "";
        delete_error();

        if($field == "category"){
            $field = "c.title";
        }else if($field == "sender"){
            $field = "u.username";
        }else{
            $field = "n.".$field;
        }
        $where = $field && $keyword ? "WHERE {$field} LIKE '%{$keyword}%'" : "";

        $options = [
            "where" => $where,
            "orderBy" => $this->sort(["id","title","category","content","status","sender","view"])
        ];
        $list = $this->news->getList($options);

        // xu ly phan trang.
        $configs = array(
            'current_page' => isset($_GET['page']) ? $_GET['page'] : 1,
            'total_page' => 0,
            'total_record' => count($list),
            'limit'=> 5,
            'start' => 0,
            'max' => 0,
            'min' => 0,
            'link_full' => base_url("admin/newsCtr/page/{page}"),
            'link_first' => '',
            'range' => 5
        );

        $pagination = new pagination();
        $pagination->init($configs);
        $data["list"]= array_splice($list,$pagination->config["start"],$pagination->config["limit"]);

        $data["pagination"] = $pagination;
        $data["title"]="Quản Lý Bài Viết";
        $data["subView"]="admin/news/index";
        $data["module"]="newsCtr";
        $this->load_view("admin/index",$data);
    }

    public  function add(){

        if(!empty($_POST)){

            $title = isset($_POST["title"]) && $_POST["title"] ? $_POST["title"] : "";
            $content = isset($_POST["content"]) && $_POST["content"] ? $_POST["content"] : "";
            $detail_content = isset($_POST["detail_content"]) && $_POST["detail_content"] ? $_POST["detail_content"] : "";
            $category = isset($_POST["category"]) && $_POST["category"] ? $_POST["category"] : "";

            // validate data
            $validTitle = validateString("title","Tiêu Đề",$title,["min_length" => 10,"except" => ["-"]]);
            $validContent = validateString("content","Nội dung",$content,["except" => ["-","\."]]);
            $validCategory = validateString("category","Chuyên Mục",$category);
            $validDetail_content = TRUE;

            if(!$detail_content){
                set_error("detail_content","Nội Dung Chi Tiêt là bắt buộc");
                $validDetail_content = FALSE;
            }else{
                delete_error("detail_content");
            }

            set_data("detail_content",$detail_content);

            if(!$validTitle | !$validContent  | !$validCategory | !$validDetail_content){
                goto next;
            }

            // thuc hien upload anh
            $options = [
                "allowed_exts" => "jpg|png|gif|jpeg",
                "upload_path" => "public/images/"
            ];

            $image = upload("image",$options,"Ảnh Đại Diện");

            if(!$image){
                goto next;
            }


            // thuc hien insert du lieu va database
            $news = new News([
                "title" => $title,
                "content" => $content,
                "detail_content" => $detail_content,
                "image" => $image,
                "category" => $category,
                "sender" => isset($_SESSION["admin"]["id"]) ? (int)$_SESSION["admin"]["id"] : "",
                "date_create" => date("Y-m-d : H:i:s",time()),
                "status" => 1,
            ]);

            if($this->news->add($news)){ ?>
                <script>
                    alert("Thêm Bài Viết Thành Công!!!!");
                    window.location = '<?=base_url("admin/newsCtr/")?>';
                </script>
            <?php }else{ ?>
                <script>
                    alert("Thêm Bài Viết Thành Công!!!!");
                    window.location = '<?=base_url("admin/newsCtr/")?>';
                </script>
            <?php }
            delete_data();
            delete_error();
            exit;
        }

        next :

        $data["category"] = $this->category->get_list(["where" => "parent_id != 0"]);
        $data["subView"] = "admin/news/add_or_update";
        $data["title"] = "Thêm Mới Bài Viết";
        $this->load_view("admin/index",$data);
    }

    public function delete()
    {
        if (filter_var($_POST['news_del'], FILTER_VALIDATE_INT)) {
            $id  = (int)$_POST['news_del'];

            $news = $this->news->getNewsById($id);

            if(!$news){
                redirect_to(base_url("admin/newsCtr/"));
            }

            if ($this->news->delete($id)) {
                    // xoa anh
                    if(file_exists("public/images/".$news->getImage())){
                        unlink("public/images/".$news->getImage());
                    }
                ?>
                <script>
                    alert("Xóa Thành Công!!!!");
                    location.reload();
                </script>

            <?php } else { ?>
                <script>
                    alert('Đã có lỗi xảy ra không thể xóa');
                    location.reload();
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
            $news = $this->news->getNewsById($id);
            if(!$news){
                redirect_to(base_url("admin/newsCtr/"));
            }

            if(filter_var($id,FILTER_VALIDATE_INT)){
                $this->news->delete($id);
                if(file_exists("public/images/".$news["image"])){
                    unlink("public/images/".$news["image"]);
                }
            }
        }
    }

    public  function changeStatus(){

        $id = isset($_POST["id"]) && preg_match("/^[0-9]+$/",$_POST["id"]) ? (int)$_POST["id"] : '';
        $status = isset($_POST["status"]) && in_array((int)$_POST["status"],[0,1]) ? (int)$_POST["status"] : '';


        if($id && is_numeric($status)) {

            if( $this->news->change_status($id,$status)){
                exit(json_encode(["success" => true]));
            };
            exit(json_encode(["success" => false]));
        }
    }

} 