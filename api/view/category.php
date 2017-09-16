<html>
<head>
    <link href="http://vitravel.000webhostapp.com/library/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://vitravel.000webhostapp.com/library/js/jquery-1.10.2.min.js"></script>
    <script src="http://localhost/travel/api/view/js_category.js"></script>
    <style>
        .error{color: red}
        #add_edit{display: none}
        #btn_display{display: none}
    </style>
</head>

<body>
<div class="well text-center"><h3>Quản Lý Người Dùng</h3></div>
<div class="container-fluid" style="margin-top: 100px">
    <div class="row">

        <div class="col-sm-2 col-sm-offset-2" style="margin-bottom: 20px" id="btn_display">
            <input type="button" class="btn btn-success btn-block" value="Danh Sách" >
        </div>

        <div class="col-sm-2 col-sm-offset-8" style="margin-bottom: 20px" id="add">
            <input type="button" class="btn btn-warning btn-block" value="Thêm Mới" >
        </div>

        <!-- phan hien thi du lieu -->
        <div class="col-sm-8 col-sm-offset-2" id="display">
            <table class="table table-hover table-bordered">
                <thead>
                <th>id</th>
                <th>username</th>
                <th>email</th>
                <th>address</th>
                <th>phone</th>
                <th>level</th>
                <th>edit</th>
                <th>delete</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <!-- phan them sua du lieu -->
        <div class="col-sm-8 col-sm-offset-2" id="add_edit">
            <form action="" method="post" id="user_form">
                <!-- ten su dung -->
                <div class="form-group">
                    <label for="username"> Tên Sử Dụng</label>
                    <input class="form-control" name="username" id="username" required="required">
                    <p class="error" id="err_username"></p>
                </div>
                <!-- dia chi email -->
                <div class="form-group">
                    <label for="email"> Email</label>
                    <input class="form-control" name="email" id="email" required="required">
                    <p class="error" id="err_email"></p>
                </div>
                <!-- dia chi  -->
                <div class="form-group">
                    <label for="address"> Address</label>
                    <input class="form-control" name="address" id="address" required="required">
                    <p class="error" id="err_address"></p>
                </div>
                <!-- so dien thoai -->
                <div class="form-group">
                    <label for="phone"> Phone Number</label>
                    <input class="form-control" name="phone" id="phone" required="required">
                    <p class="error" id="err_phone"></p>
                </div>
                <!-- level nguoi dung -->
                <div class="form-group">
                    <label for="level"> Level</label>
                    <input class="form-control" name="level" id="level" required="required">
                    <p class="error" id="err_level"></p>
                </div>
                <p class="error" id="err"></p>
                <input class="btn btn-success btn-block" type="button" value="submit" id="submit">
            </form>
        </div> <!-- end.div#add_edit -->
    </div>  <!-- end.div row -->
</div>  <!-- end.div container -->
</body>
</html>
