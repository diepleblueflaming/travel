<?php
    if(isset($list_find)) {
           echo "<div class='row' id='search_result'>";
           echo '<div class="col-xs-12 col-sm-10 col-sm-offset-1">';
           echo '<h3> Kết Quả Tìm Kiếm</h3>';
           foreach($list_find as $item)
           {
               $uri = createURl($item["category"]."/".$item["title"]." ".$item["id"]);
               ?>
                <div class="find_item">
                    <div class="find_item_img">
                        <img src="<?php echo base_url("public/icon/find.png")?>">
                    </div>
                    <div class="find_item_content">
                    <h3><a href="<?=$uri?>"><?=$item["title"]?></a></h3>
                    <p><a href="<?=$uri?>"><?=$uri;?></a></p>
                    <p><?=$item["content"]?></p>
                    </div>
                </div>
            <?php
           }
           echo "</div></div>";
    }
?>
