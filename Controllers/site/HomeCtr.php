<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/24/2016
 * Time: 5:13 PM
 */
if (!defined("PATH_SYSTEM")) die("Bad Requested");

class HomeCtr extends  MY_controller{

    public function __construct(){
        parent::__construct();
        $this->load_model("news");
        $this->load_model("category");
    }

    public  function  index(){

        // get list category
        $list = [];
        $parentCategories = $this->category->get_list(["where" => "parent_id = 0"]);

        // lap mang chuyen muc cha.
        foreach($parentCategories as $parent){
            $options  = [
                "where" => ["parent_category_id" => (int)$parent->getId()],
                "limit" => [5,0]
            ];
            $list[$parent->getTitle()]  = $this->news->getDetailNews($options);
        }

        $data["title"] = "Trang Chủ";
        $data["subView"] = "site/home/index";
        $data["list"] = $list;
        $this->load_view("site/index",$data);
    }


    // xu ly khi nguoi dung lien he
    public  function  contact()
    {
        // bien luu tru loi

        if(1==1){
            // neu nhu chuoi xac nhan khong hop le
            if($_POST['contact_captcha']!=$_SESSION['captcha']){
                $error["message"]="Chuỗi xác nhận không hợp lệ.Vui lòng nhập lại";
            }else{
                // neu khong. lay ra du lieu
                $content=isset($_POST['contact_content']) ? $this->model->escape($_POST['contact_content']) : null;
                $email=isset($_POST['contact_email']) && validateEmail($_POST['contact_email'])
                    ? $this->model->escape($_POST['contact_email']) : null;

                // validate du lieu
                if(!$content){
                    $error["message"]="Bạn chưa nhập nội dung thư";
                }
                else if(!$email) {
                    $error["message"]="Bạn chưa nhập địa chỉ email hoặc địa chỉ email không hợp lệ";
                }
                else {
                    // neu du lieu khong co van de gi voi du lieu thi gui mail.
                    $content .= "Thư Liên lạc hỗ trợ từ {$email} đến bạn \n\n" . $content;
                    if (mail("lhdiep95@gmail.com","Email Contact from vietTravel", $content,"FROM: localhost")) {
                        $error["message"]="<p class='success'>Thư liên lạc của bạn đã được gửi đến chúng tôi.
                                Chúng tôi sẽ phản hồi sớm nhất có thể</p>";

                        // gan lai gia tri trang thai va bao thong bao thanh cong.
                        $error["status"]=true;
                        exit(json_encode($error));
                    }else{
                        $error["message"]="Đã có lỗi xảy ra.Xin bạn thử lại sau";
                    }
                }
            } // end of kiem tra captcha.
            // bao loi ve nguoi dung.
                    $error["message"]="<p class='error'>".$error["message"]."</p>";
                    exit(json_encode($error));
        } // end of isset($_POST["contact-sunmit"]) if

    } // ket thuc ham contact.
}
