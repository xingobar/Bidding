<?php session_start();?>
<?php include_once('../middleware/auth.php');?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>競標王</title>
    </head>
    <body>
        <?php include_once('./shared/navbar.php'); ?>
        <div class="container">
            <div class="panel panel-default" style="width:50%;margin:0 auto;">
                <div class="panel-heading">
                    <h3><strong>產品</strong> <small>檔案上傳</small></h3>
                </div>
                <div class="panel-body">
                    <!-- Standar Form -->
                    <h4>從本機選擇檔案上傳</h4>
                    <form action="../File/upload.php" method="post" enctype="multipart/form-data" id="js-upload-form">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="file" name="productImg" id="js-upload-files">
                            </div>
                        </div>
                        <div class="form-group" style="padding-top:20px;">
                            <label for="name">產品名稱</label>
                            <input class="form-control" type="text" name="name" value="" placeholder="產品名稱">
                        </div>
                        <div class="form-group">
                            <label for="promotion">促銷</label>
                            <select name="promotion"  class="form-control">
                                <option value="0">False</option>
                                <option value="1">True</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="timer">時間（小時）</label>
                            <input class="form-control" type="number" name="timer" value="" placeholder="請輸入時間">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="description">產品敘述</label>
                                <textarea name="description" rows="10" cols="70" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">產品價格</label>
                            <input type="number" name="price" class="form-control" value="" placeholder="請輸入產品價格">
                        </div>
                        <div class="form-inline" style="padding-top:20px;">
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-md  btn-primary" id="js-upload-submit">檔案上傳</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
        <script>
            $(document).ready(function(){
                var li = $('ul.nav').find('li');
                $(li).each(function(){
                    $(this).removeClass('active');
                });
                var a_tag = $('ul.nav li').find("a[href='./upload.php']");
                $(a_tag).parent().addClass('active');
            });
        </script>
    </body>
</html>