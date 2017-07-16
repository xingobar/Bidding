<?php
include_once('../DbConnection/DbConnect.php');

class ShoppingCart{

    private $conn;
    private $productId;
    private $userId;
    private $results;
    private $functionName;

    public function __construct(){
        $this->conn = DbConnect::connect();
    }

    public function setUserId(){
        $userName = $_POST['userName'];
        $sql = 'select id from user where name = :name';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'name' => $userName
        ));
        $this->userId = $query->fetch()['id'];
    }

    public function insert(){
        $sql = 'insert into cart (user_id,product_id)
                    values (:user_id,:product_id)';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'user_id' => $this->userId,
            'product_id' => $this->productId
        ));
    }

    public function updateProductEnd(){
        $sql = 'update product set end = :end where id = :product_id';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'end' => true,
            'product_id'=>$this->productId
        ));
    }

    public function isRecordExists(){
        $sql = 'select * from cart where user_id = :user_id and product_id = :product_id';
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
        $sql = "select * from history where product_id = :productId order by created_at desc limit 1";
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'productId' => $this->productId
        ));
        $this->results = $query->fetch();
    }

    public function getProductName(){
        $sql = "select name from product where id = $this->productId";
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
        $sql = "select * from cart 
        where user_id = $userId";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $rowCount = $query->rowCount();
        return $rowCount;
    }
    
    public function getUserId(){
        session_start();
        $userName = $_SESSION['username'];
        $sql = "select id from user where name ='$userName'";
        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetch()['id'];
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