<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/27/2016
 * Time: 1:04 AM
 */
if(isset($hot_news)) {
    echo '<div class="col-xs-12 col-sm-5 col-md-4">';
        echo '<h3>Bài Viết Mới</h3>';
        ?>
        <div class="als-container" id="hot_list">
            <div class="als-viewport">
                <div class="als-wrapper">
                    <?php
                    foreach($hot_news as $item){
                        $uri = createURl($item["category"]."/".$item["title"]." ".$item["id"]);
                        ?>
                        <li class='als-item'>
                            <div class="hot_item_new_img">
                                <a href="<?=$uri?>"><img id="scroll" src="<?php echo get_path_image($item["image"])?>"></a>
                            </div>
                            <div>
                                <div class="hot_item_new_title"><a href="<?=$uri?>"><?php echo getCertainWord($item["title"],10)?></a></div>
                                <div class="hot_item_new_content"><h5><?php echo strip_tags(getCertainWord($item["content"],30))?></div>
                            </div>
                        </li>
                    <?php
                    }
        echo '</div>
            </div>
        </div>
    </div>';
}
?>
