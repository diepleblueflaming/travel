<div class="row" id="list_news">
<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 9/12/2016
 * Time: 7:40 PM
 */

    echo '<div class="col-xs-12 col-sm-7 col-md-8" id="category">';
    echo "<h4 class='path'>Travel / ".$cat->getTitle()."</h4>";
    foreach($list_news as $item)
    {
        $uri = createURl($item["category"]."/".$item["title"]." ".$item["id"]);
       ?>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <a href="<?=$uri?>"><img src="<?php echo get_path_image($item["image"])?>" width="100%">
                    </a>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <h3 class="title">
                        <a href="<?=$uri?>"><?php echo $item["title"];?></a>
                    </h3>
                    <div class="con_item_time"><i class="glyphicon glyphicon-time"></i> <?php echo convertTime($item["date_create"])?></div>
                    <p class="con_item_content"> <?php  echo strip_tags(getCertainWord($item["content"]));?>
                </div>
            </div>
        <hr>
    <?php
    }
    echo '</div>';
    $this->load_view("site/news/hot_news");
?>
</div>
