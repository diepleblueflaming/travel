<div class="row" id="detail_news">
<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 9/12/2016
 * Time: 7:41 PM
 */
    if(!defined("PATH_SYSTEM")) die("Bad Requested");

    if(isset($news)){
        $path = "Travel ".$news['category']." ".$news['title'];
        echo '<div class="col-xs-12 col-sm-7 col-md-8">';
        echo '<div class="content">';
        echo "<p class='path'>Travel / ".$news["category"]." / ".$news['title']."<p>";
        echo '<h3>'.$news['title'].'</h3>';
        echo '<div class="row" id="summary">
                <div class="col-xs-6 col-sm-4"><img src="'.get_path_image($news["image"]).'"></div>
                <div class="col-xs-6 col-sm-8 description">
                    <h5><strong>Created </strong>'.convertTime($news['date_create']).'</h5>
                    <h5><strong>comment </strong><span class="badge">'.$news['comment_count'].'</span></h5>
                    <h5><strong>View </strong><span class="badge">'.$news['view_count'].'</span></h5>
                </div>
                <div class="summary-content"><p>'.str_replace("-","",strip_tags($news["content"])).'</p></div>
             </div>';
        echo '</div>';
        echo  '<div class="detail_content">'.$news['detail_content'].'</div>';
        echo '<h4 class="text-right">Tác Giả Bài Viết <strong style="color: red">'.$news['sender'].'</strong></h4>';
        echo "<br>";
        if(isset($list_comment) && $list_comment) {
            /** @var  $item Comment*/
            foreach($list_comment as $item){ ?>
            <div style="width: 100%" class="comment">
                <div class="com_icon">
                    <img id = "cap_img" src="<?php echo base_url("public/icon/comment.jpg")?>">
                </div>
                <h4><?php echo $item->getUserComment()?></h4>
                <h5><?php echo convertTime($item->getDateCreate())?></h5>
                <p><?php echo $item->getContent()?></p>
            </div>
        <?php
            }
        }
        $this->load_view("site/news/comment");
        echo '</div>';
    }
?>
<?php $this->load_view("site/news/hot_news"); ?>
</div>
<?php //$this->load_view("site/news/modalImg"); ?>
