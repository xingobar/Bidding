<?php

include_once('../DbConnection/DbConnect.php');

class BiddingDetail{

    private $conn;
    private $productId;

    public function __construct($productId){
        $this->conn = DbConnect::connect();
        $this->productId = $productId;
    }

    public function getAll(){
        $sql = "select history.created_at,user.name,history.price from history 
                inner join user on history.user_id = user.id
                where history.product_id = $this->productId
                order by history.created_at desc";
        $query = $this->conn->query($sql);
        $history = $query->fetchAll();
        $response = '';
        foreach($history as $row){
            $response = $response . <<<REQUEST
                 <tr>
                    <td>{$row['created_at']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['price']}</td>
                </tr>
REQUEST;
        }
        return $response;
    }
}
?>