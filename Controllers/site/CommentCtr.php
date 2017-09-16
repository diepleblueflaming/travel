<?php
if (!defined("PATH_SYSTEM")) die("Bad Requested");

class CommentCtr extends MY_Controller{


    public function  __construct(){
        parent::__construct();
        $this->load_model("comment");
        $this->load_model("news");
    }


    public  function  add(){

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {

            $user_comment = isset($_POST["user_comment"]) ? $_POST["user_comment"] : "";
            $inValidUserComment = validateString("user_comment","Họ Tên",$user_comment);
            $content= isset($_POST["content"]) ? $this->news->escape(strip_tags($_POST["content"])) : "";
            $news_comment = (int)$_POST['news_id'];
            $captcha = $_POST["captcha"];


            if(!$content){
                exit(json_encode(["error" => "Bạn chưa nhập nội dung bình luận"]));
            }

            if(!$inValidUserComment){
                exit(json_encode(["error" => get_error("user_comment")]));
            }

            if($captcha != $_SESSION['captcha']) {
                exit(json_encode(["error"=>"Chuỗi Bạn Nhập Không Đúng"]));
            }


            $news = $this->news->getNewsById($news_comment);

            if(!$news){
                exit(json_encode(["error" => "Đã có lỗi xảy ra vui lòng thử lại sau"]));
            }

            $comment = new Comment([
                "user_comment" => $user_comment,
                "news_comment" => $news_comment,
                "content" => $content,
                "status" => 0,
                "date_create" => date("Y-m-d : H:i:s",time())
            ]);

            if($this->comment->add($comment)){
                exit(json_encode(["success" => TRUE]));
            }else{
                exit(json_encode(["error" => "Đã có lỗi xảy ra vui lòng thử lại sau"]));
            }
        }
    }

}
?>
