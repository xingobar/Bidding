<?php
include_once('../DbConnection/DbConnect.php');

class PromotionProduct { 

    private $conn;

    public function __construct(){
        $this->conn = DbConnect::connect();
    }

    public function show(){
        $sql = 'select * from product where promotion = 1';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $products = $query->fetchAll();

        foreach($products as $product){
                           echo    <<<REQUEST
                           
        <div class="carousel-inner">
            <div class="item active">
            <img src="{$product['file_dir']}" alt="Chania">
            <div class="carousel-caption">
                <h3><strong>{$product['name']}</strong></h3>
                <p>LA is always so much fun!</p>
            </div>
            </div>               
REQUEST;
        }
    }
}
?>