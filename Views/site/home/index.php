<link href="<?=base_url("library/css/home.css")?>" rel="stylesheet">
<?php
/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 9/11/2016
 * Time: 5:13 PM
 */
    foreach($list as $key => $val)
    { ?>
        <div class="rows">
        <?php if(!empty($val)) { ?>
            <a><h4 class="title"><?=mb_strtoupper($key,"utf-8")?></h4></a>
            <?php $uri = createURl($val[0]["category"]."/".$val[0]["title"]." ".$val[0]["id"]); ?>
        <div class="row">
        <div id="main_image" class="col-xs-12 col-sm-6">
            <div class="grid">
                <figure class="effect-lily">
                    <img src="<?=get_path_image($val[0]["image"]);?>">
                    <figcaption>
                        <div><?php
                            if(strlen($val[0]["title"]) < 65) {
                                echo "<h2>{$val[0]["title"]}</h2>";
                            }
                            else {
                                echo "<h3>{$val[0]["title"]}</h3>";
                            }
                                echo '
								<p>'.getCertainWord($val[0]["content"]).'
								</div>
							<a href="'.$uri.'"></a>
					</figcaption>
                </figure>
            </div>
        </div>
        <div id="hot_big_content" class="col-xs-12 col-sm-6">
            <div class="main_title"><a href="'.$uri.'">'.$val[0]["title"].'</a></div>
            <div class="description">
                <p><strong>Created </strong>'.convertTime($val[0]['date_create']).'
                <p><strong>Comment </strong><span class="badge">'.$val[0]['comment_count'].'</span>
                <p><strong>View </strong><span class="badge">'.$val[0]['view_count'].'</span>
            </div>
            <div class="hot_content"><h4>'.$val[0]["content"].'</h4></div>
            <div class="detailbutton">
                <a href="'.$uri.'" class="btn btn-success">Xem Chi Tiết</a>
            </div>
        </div>
    </div>';

    echo '<ul class="row hot_small">';
    for($i = 1; $i < count($val); $i++) {
        $id = $val[$i]['id'];
        $uri = createURl($val[$i]["category"]."/".$val[$i]["title"]." ".$val[$i]["id"]); ?>
       <li class="col-xs-12 col-sm-3 hot_small_content">
           <div class="hot_small_content_pic">
               <div class="grid">
                    <figure class="effect-lily" id="small-effect-lily">
                        <img src="<?=get_path_image($val[$i]["image"])?>">
                        <figcaption>
                            <div><h4 style="margin-top:-15px"> <?=getCertainWord($val[$i]["title"],15)?></h4></div>
                            <a href="<?=$uri?>"></a>
                        </figcaption>
                    </figure>
               </div>
           </div>
       </li>
    <?php } ?>
    </ul>
        <?php } ?>
    </div>
<?php } ?>

