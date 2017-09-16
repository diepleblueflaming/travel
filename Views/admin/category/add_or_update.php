<div class="col-sm-12 category">
    <div class="panel panel-primary col-sm-10 col-sm-offset-1" id="main-content">
        <div class="row panel panel-heading">
            <span class="glyphicon glyphicon-plus"></span>
            <?php echo isset($category) ? "Cập Nhật" : "Thêm Mới"; ?>
        </div>
        <div class="panel panel-body">
            <form action="" method="post">
                <div class="form-group has-feedback">
                    <label for="title"> Tiêu Đề </label> <input type="text"
                    placeholder="Nhập Tên Chuyên Mục"  id="title" class="form-control"name='title'
                    value="<?= isset($category) ? $category->getTitle() : ""?>">
                    <span class="glyphicon glyphicon-user  form-control-feedback"></span>
                    <p class="error"><?=get_error("title")?></p>
                </div>
                <br>
                <div class="form-group has-feedback">
                    <label for="category">Chuyên Mục Cha</label>
                    <select class="form-control" id="category" name="parent_id">
                        <option class="0"> Không Có</option>
                        <?php
                        if (isset($parentCategory)) {
                            /** @var  $val Category */
                            foreach ($parentCategory as $key => $val) {
                                if (isset($category) && $val->getId() == $category->getParentId())
                                    echo '<option value="' . $val->getId() . '" selected=selected>' . $val->getTitle() . '</option>';
                                else
                                    echo '<option value="' . $val->getId() . '">' . $val->getTitle() . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <br>
                <input class="btn btn-success" name="<?php echo isset($category) ? "btn-edit" : "btn-add"; ?>"
                 type="submit" value="<?php echo isset($category) ? "cập nhật" : "Thêm Mới"; ?>">
                <input class="btn btn-danger" id="btn-cancel"  value="Cancel"  type="button">
            </form>
        </div>
    </div>
</div>
