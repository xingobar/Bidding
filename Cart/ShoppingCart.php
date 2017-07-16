<?php
include_once('../DbConnection/DbConnect.php');

class ShoppingCart{

    private $conn;
    private $productId;
    private $userId;
    private $results;
    private $functionName;

    public function __construct(){
        session_start();
        $this->conn = DbConnect::connect();
    }

    public function setUserId(){
        $userName = $_POST['userName'];
        $sql = 'SELECT id FROM user WHERE name = :name';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'name' => $userName
        ));
        $this->userId = $query->fetch()['id'];
    }

    public function insert(){
        $sql = 'INSERT INTO cart (user_id,product_id)
                    VALUES (:user_id,:product_id)';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'user_id' => $this->userId,
            'product_id' => $this->productId
        ));
    }

    public function updateProductEnd(){
        $sql = 'UPDATE product 
                SET end = :end WHERE id = :product_id';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'end' => true,
            'product_id'=>$this->productId
        ));
    }

    public function isRecordExists(){
        $sql = 'SELECT * FROM cart 
                WHERE user_id = :user_id 
                AND product_id = :product_id';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'user_id' => $this->userId,
            'product_id' => $this->productId
        ));
        $rowCount = $query->rowCount();
        if($rowCount === 0  ){
            return false;
        }
        return true;
    }

    public function getTopOneHistory(){
        $sql = "SELECT * FROM history WHERE product_id = :productId
                ORDER BY created_at DESC LIMIT 1";
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'productId' => $this->productId
        ));
        $this->results = $query->fetch();
    }

    public function getProductName(){
        $sql = "SELECT name FROM product WHERE id = $this->productId";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetch()['name'];
    }

    public function IsSameUser(){

        return ($this->userId === $this->results['user_id']);
    }

    public function IsSameProduct(){
        return($this->productId === $this->results['product_id']);
    }

    public function getFunctionName(){
        return $this->functionName;
    }

    public function setFunctionName(){
        $this->functionName = $_POST['functionName'];
    }

    public function setProductId(){
        $this->productId = $_POST['productId'];
    }

    public function getUserProductCount(){
        $userId = $this->getUserId();
        $sql = "SELECT * FROM cart 
                WHERE user_id = $userId";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $rowCount = $query->rowCount();
        return $rowCount;
    }
    
    public function getUserId(){
        $userName = $_SESSION['username'];
        $sql = "SELECT id FROM user WHERE name ='$userName'";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetch()['id'];
    }

    public function getBelongsToUserProduct(){
        $userId = $this->getUserId();
        $sql = "SELECT product.name,product.end_time,
                       product.file_dir AS image,
                       product.price as base_price,
                       sum(history.price) as totalTurnOver
                FROM cart 
                INNER JOIN product ON cart.product_id = product.id
                INNER JOIN history ON cart.product_id = history.product_id 
                WHERE history.user_id = '$userId'
                GROUP BY product.name";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $products = $query->fetchAll();
        foreach($products as $product){
            $total = $product['base_price'] + $product['totalTurnOver'];
            echo <<<REQUEST
                <tr>
                    <td>{$product['end_time']}</td>
                    <td><img class="img-responsive" src="{$product['image']}"/></td>
                    <td style="width:114px;height:114px;">{$product['name']}</td>
                    <td>{$total}</td>
                </tr>
REQUEST;
        }
    }
}

$shoppingCart = new ShoppingCart();
if(isset($_POST['functionName']) && isset($_POST['productId'])){
    $shoppingCart->setFunctionName();
    $shoppingCart->setProductId();
}
if($shoppingCart->getFunctionName() === 'insert'){
    $shoppingCart->setUserId();
    $shoppingCart->getTopOneHistory();
    $shoppingCart->updateProductEnd();
    if($shoppingCart->IsSameUser() && $shoppingCart->IsSameProduct()){
        if(!$shoppingCart->isRecordExists()){
            $shoppingCart->insert();
            $productName = $shoppingCart->getProductName();
            echo json_encode(array('msg' => 'success',
                        'productName'=>$productName));
        }
        exit();
    }
}
?>