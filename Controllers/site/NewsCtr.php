<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/24/2016
 * Time: 5:13 PM
 */

class NewsCtr extends MY_controller{

    public function  __construct(){
        parent::__construct();
        // load model
        $this->load_model("news");
        $this->load_model("category");
    }

    public function detailNews(){

        $this->load_model("comment");

        $news = isset($_GET["news"]) ? $this->news->escape($_GET["news"]) : "";
        $newsId= (int)end(explode("-",$news));

        $a = end($this->news->getDetailNews(["where" => ["id" => $newsId]]));


        // neu bai viet khong ton tai dieu hương ve trang chu
        if(!$a){
            redirect_to(base_url());
        }

        // lay ra danh sach cac binh luan cua bai viet
        $list_comment = $this->comment->get_list(["where" => "news_comment={$newsId} AND status=1"]);

        // lay ra danh sach cac bai viet moi
        $hotNews = $this->news->getHotNews();

        $data["title"] = $a["title"];
        $data["hot_news"] = $hotNews;
        $data['news'] = $a;
        $data["list_comment"] = $list_comment;
        $data["subView"]="site/news/single";
        $this->load_view("site/index",$data);
    }

    public function category(){

        $category = isset($_GET['category']) ? $_GET['category'] : "";
        $categoryId = (int)end(explode("-",$category));

        $cat = $this->category->getCategoryById($categoryId);

        if(!$cat){
            redirect_to(base_url());
        }

        $list_news = $this->news->getDetailNews(["where" => ["category_id" => $categoryId]]);

        // lay ra danh sach cac bai viet moi
        $hotNews = $this->news->getHotNews();

        $data["hot_news"] = $hotNews;
        $data['cat'] = $cat;
        $data["title"] = $cat->getTitle();
        $data['list_news'] = $list_news;
        $data["subView"]="site/news/category";
        $this->load_view("site/index",$data);
    }

    public  function index(){

        if(!is_loged("user")){
              redirect_to(base_url());
        }

        $this->load_model("user");
        $user = $this->user->getUserById($_SESSION["user"]["id"]);
        $this->load_library("pagination");

        // xu ly tim kiem.
        $field = isset($_POST["field"]) && in_array($_POST["field"],["content","title","sender","category"])
            ? $_POST["field"] : "";
        $keyword = isset($_POST["keyword"]) && validateString("data","data",$_POST["keyword"]) ?  $_POST["keyword"] : "";
        delete_error();

        if($field == "category"){
            $field = "c.title";
        }else{
            $field = "n.".$field;
        }

        $where = $field && $keyword ? "WHERE {$field} LIKE '%{$keyword}%' AND n.sender = '{$user->getId()}' AND status = 1"
            : "WHERE n.sender = '{$user->getId()}' AND status = 1";

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
            'link_full' => base_url("management/page/{page}"),
            'link_first' => '',
            'range' => 5
        );

        $pagination = new pagination();
        $pagination->init($configs);
        $data["list"]= array_splice($list,$pagination->config["start"],$pagination->config["limit"]);

        $data["pagination"] = $pagination;
        $data["user"] = $user;
        $data["title"]="Quản Lý Bài Viết";
        $data["subView"]="site/news/management/index";
        $data["module"]="newsCtr";
        $this->load_view("site/index",$data);
    }

    public  function add(){

        if(!is_loged("user")){
            redirect_to(base_url());
        }

        if(!empty($_POST)){

            $title = isset($_POST["title"]) && $_POST["title"] ? $_POST["title"] : "";
            $content = isset($_POST["content"]) && $_POST["content"] ? $_POST["content"] : "";
            $detail_content = isset($_POST["detail_content"]) && $_POST["detail_content"] ? $_POST["detail_content"] : "";
            $category = isset($_POST["category"]) && $_POST["category"] ? $_POST["category"] : "";

            // validate data
            $validTitle = validateString("title","Tiêu Đề",$title,["min_length" => 10,
                "except" => ["-","\.",",","\w","!"]]);
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
                "sender" => $_SESSION["user"]["id"],
                "date_create" => date("Y-m-d : H:i:s",time()),
                "status" => 0,
            ]);

            if($this->news->add($news)){
                $message = "Bạn đã đăng bài viết thành công,<br>Bài viết của bạn sau khi được phê duyệt
                sẽ được đăng lên website";
                $this->alert($message);
            }else{ ?>
                <script>
                    alert("Thêm Bài Viết Thất bại!!!!");
                    window.location = '<?=base_url("site/management/")?>';
                </script>
            <?php }
            delete_data();
            delete_error();
            exit;
        }

        next :

        $data["category"] = $this->category->get_list(["where" => "parent_id != 0"]);
        $data["subView"] = "site/news/management/add_or_update";
        $data["title"] = "Thêm Mới Bài Viết";
        $this->load_view("site/index",$data);
    }

    public  function update(){

        if(!is_loged("user")){
            redirect_to(base_url());
        }

        // lay ra id của bài viết.
        $id = $this->getModule(3);

        $news_update = $this->news->getNewsById($id);

        if(!empty($_POST['btn-submit'])){


            $title = isset($_POST["title"]) && $_POST["title"] ? $_POST["title"] : "";
            $content = isset($_POST["content"]) && $_POST["content"] ? $_POST["content"] : "";
            $detail_content = isset($_POST["detail_content"]) && $_POST["detail_content"] ? $_POST["detail_content"] : "";
            $category = isset($_POST["category"]) && $_POST["category"] ? $_POST["category"] : "";

            // validate data
            $validTitle = validateString("title","Tiêu Đề",$title,["min_length" => 10,"except" => ["-",",","(",")"]]);
            $validContent = validateString("content","Nội dung",$content,["except" => ["-","\.","(",")",","]]);
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


            if($_FILES["image"]["tmp_name"]){
                $image = upload("image",$options,"Ảnh Đại Diện");

                if(!$image){
                    goto next;
                }
            }


            // thuc hien update du lieu vao database
            $news = new News([
                "id" => $news_update->getId(),
                "title" => $title,
                "content" => $content,
                "detail_content" => $detail_content,
                "image" => isset($image) ? $image : $news_update->getImage(),
                "category" => $category,
                "sender" => $_SESSION["user"]["id"],
                "date_create" => date("Y-m-d : H:i:s",time()),
                "status" => $news_update->getStatus(),
            ]);

            if($this->news->update($news)){

                if(isset($image)){
                    // thuc hien xoa anh
                    if(file_exists("public/images/".$news_update["image"])){
                        unlink("public/images/".$news_update["image"]);
                    }
                }?>
                <script>
                    alert("Chỉnh Sửa Bài Viết Thành Công!!!!");
                    window.location = '<?=base_url("/management/")?>';
                </script>
            <?php }else { ?>
                <script>
                    alert("Chỉnh Sửa Bài Viết Thất bại!!!!");
                    window.location = '<?=base_url("/management/")?>';
                </script>
            <?php }
            delete_data();
            delete_error();
            exit;
        }

        next :
        $data["category"] = $this->category->get_list(["where" => "parent_id != 0"]);
        $data["news"] = $news_update;
        $data["subView"] = "site/news/management/add_or_update";
        $data["title"] = "Thêm Mới Bài Viết";
        $this->load_view("site/index",$data);
    }

    public  function delete(){

        $id = $this->getModule(3);
        if($this->news->delete($id)){ ?>
            <script>
                alert("Xóa Thành Công");
                window.location = '<?=base_url("management/")?>';
            </script>
        <?php } else { ?>
            <script>
                alert("Xóa Thất Bại");
                window.location = '<?=base_url("management/")?>';
            </script>
        <?php }
        exit;
    }

    public  function find(){

        $tag = isset($_POST["tag"]) ? $this->news->escape($_POST["tag"]) : '';

        $list_find = [];

        if(!empty($tag) && strlen($tag) >= 3) {
            $list_find = $this->news->find($tag);
        }

        if($list_find){
            $data["list_find"] = $list_find;
            $data["title"]="Tìm Kiếm Bài Viết";
            $data["subView"]="site/news/find";
        }else{
            $data["title"]="Lỗi";
            $data["subView"]="site/common/notification";
            $data["message"]="Không tìm thấy bài viết phù hợp với từ khóa bạn đang tìm";
        }
        $this->load_view("site/index",$data);
    }

}
