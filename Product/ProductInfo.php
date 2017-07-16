<?php
include_once('../DbConnection/DbConnect.php');

class ProductInfo{

    private $conn;

    public function __construct(){
        $this->conn = DbConnect::connect();
    }

    public function show(){
        $sql = 'SELECT * FROM product WHERE end = false';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $products = $query->fetchAll();

        foreach($products as $product){
                           echo    <<<REQUEST
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="{$product['file_dir']}" style="width:350px;height:222px;" alt="">
                        <div class="caption">
                            <h4 class="pull-right"><span class="symbol">$</span>{$product['price']}<span class="unit">元</span></h4>
                            <h4><a href="#">{$product['name']}</a></h4>
                            <p class="text-center" style="font-size:1.5em"><strong class="timer">{$product['end_time']}</strong></p>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-danger">產品下標</button>
                                    <a href="../views/product_detail.php?id={$product['id']}" type="button" class="btn btn-info">詳細資料</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
REQUEST;
                    }

    }

}
?>