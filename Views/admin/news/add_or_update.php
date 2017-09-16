<div class="col-sm-12 news">
    <div class="panel panel-primary col-sm-10 col-sm-offset-1" id="main-content">
        <div class="row panel-heading">
            <span class="glyphicon glyphicon-plus"></span> Đăng Bài
        </div>
        <div class="panel-body ">
            <form action="" method="post" class="form-horizontal" id="forms"
                  enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Tiêu Đề</label>
                    <input type="text" placeholder="Nhập Tiêu Đề Bài Viết" id="title" class="form-control" name="title"
                         title="Tiêu đề bài viết." value="<?=isset($news) ? $news->getTitle() : get_data("title")?>">
                    <p class="error" id="err_title"><?=get_error("title")?></p>
                </div>

                <div class="form-group">
                    <label for="tieude">Chuyên Mục</label>
                    <select class="form-control" id="category" name="category">
                        <option value="0">Chuyên Mục</option>
                        <?php
                            /** @var  $val Category */
                        foreach ($category as $key => $val) {
                                $selected = (isset($news) && $news->getCategory() == $val->getId()) || (int)$val->getId() == get_data("category") ? "selected" : ""; ?>
                                <option value="<?=$val->getId()?>" <?=$selected?> ><?=$val->getTitle()?></option>
                        <?php }; ?>
                    </select>
                    <div class="error"><?=get_error("category")?></div>
                </div>

                <div class="form-group">
                    <label for="image"> Ảnh Đại Diện </label>
                    <input type="file" name="image" id="image" class="form-control">
                    <div class="error"><?=get_error("image")?></div>
                </div>

                <div class="form-group">
                    <label for="content"> Nội Dung Tóm Tắt</label>
                    <textarea rows="5" cols="70" name="content" id="content" class="form-control"><?=isset($news) ? $news->getContent() : get_data("content")?></textarea>
                    <div class="error"><?=get_error("content")?></div>
                </div>

                <div class="form-group">
                    <label for="image" class="control-label"> Nội Dung Chi Tiết </label>
                    <textarea rows="5" cols="70" name="detail_content" id="detail_content" class="form-control"><?=isset($news) ? $news->getDetailContent() : get_data("detail_content")?></textarea>
                    <script>CKEDITOR.replace("detail_content")</script>
                    <div class="error"><?=get_error("detail_content")?></div>
                </div>
            </form>
        </div>
        <div class="row panel-footer">
            <input class="btn btn-success" name="btn-submit" id="btn-submit" type="submit" value="Thêm Mới" form="forms">
            <input class="btn btn-danger" id="btn-cancel" value="Cancel" type="button">
        </div>
    </div>
</div>
