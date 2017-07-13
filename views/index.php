<?php
include_once('../Product/ProductInfo.php');
$productInfo = new ProductInfo();
?>
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
        <?php include_once('caoursel.php'); ?>
        <div class="container" style="padding-top:15px;">
            <div class="row">
                <?php
                    $productInfo->show();
                ?>
            </div>
        </div>
        <script src="../public/js/timer.js"> </script>
    </body>
</html>