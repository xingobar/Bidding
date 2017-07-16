<?php include_once('../Cart/ShoppingCart.php');?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../public/css/history.css">
        <title>競標王</title>
    </head>
    <body>
        <?php include_once('./shared/navbar.php'); ?>
        <div class="container">
            <div class="table-title">
                <h3>得標紀錄</h3>
            </div>
            <div style="height:450px;overflow:scroll;width:auto">
                <table class="table-fill">
                    <thead>
                        <tr>
                            <th class="text-left">得標日期</th>
                            <th class="text-left">產品</th>
                            <th class="text-left">產品名稱</th>
                            <th class="text-left">得標金額</th>
                        </tr>
                    </thead>
                    <tbody class="table-hover">
                        <?php 
                            $shoppingCart = new ShoppingCart();
                            $shoppingCart->getBelongsToUserProduct();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                var li = $('ul.nav').find('li');
                $(li).each(function(){
                    $(this).removeClass('active');
                });
                var a_tag = $('ul.nav li').find("a[href='./cart.php']");
                $(a_tag).parent().addClass('active');
            });
        </script>
    </body>
</html>