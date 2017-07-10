<?php session_start();?>
<?php include_once('../Product/ProductDetail.php');?>
<?php $productDetail = new ProductDetail();?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="../public/js/bidding_socket.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <title>競標王</title>
    </head>
    <body>
        <?php include_once('./shared/navbar.php'); ?>
        <div class="container">
            <div class="row">
                <?php $productDetail->showProduct();?>
            </div>
        </div>
    </body>
</html>