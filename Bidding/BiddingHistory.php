<?php
include_once('../DbConnection/DbConnect.php');

class BiddingHistory{

    private $conn;
    private $floor_price;
    private $bidding_price ;
    private $user;
    private $productId;

    public function __construct(){
        session_start();
        $this->conn = DbConnect::connect();
        $this->floor_price = $_POST['floor_price'];
        $this->bidding_price = $_POST['price'];
        $this->user = $_SESSION['username'];
        $this->productId = $_POST['productId'];
    }

    public function insert(){
        if($this->IsPointGreaterThanBiddingPrice()){
            $cdate = new DateTime();
            $cdate = $cdate->format('Y-m-d H:i:s');
            $userId = $this->getUserId();
            $sql = 'INSERT INTO history (user_id,price,product_id,created_at)
                    VALUES(:user_id,:price,:product_id,:created_at)';
            $query = $this->conn->prepare($sql);
            $query->execute(array(
                'user_id'=>$userId,
                'price'=>$this->bidding_price,
                'product_id'=>$this->productId,
                'created_at'=> $cdate
            ));
            $this->minusUserPoint();
            echo json_encode(array('msg'=>'success'));
            return;
        }
        echo json_encode(array('msg'=>'error'));
        return;
    }

    public function getUserId(){
        $sql = " SELECT id FROM user WHERE name = '$this->user'";
        $query = $this->conn->query($sql);
        $userId = $query->fetch()['id'];
        return $userId;
    }

    public function minusUserPoint(){
        $amount = $this->getUserPoint();
        $amount -= $this->bidding_price;
        $sql = "UPDATE user SET point = $amount WHERE name = '$this->user'";
        $query = $this->conn->prepare($sql);
        $query->execute();
        $_SESSION['point'] = $amount;
    }

    public function IsPointGreaterThanBiddingPrice(){
        return ($this->getUserPoint() >= $this->bidding_price);
    }

    public function getUserPoint(){
        $sql = "SELECT point FROM user WHERE name = '$this->user'";
        $query = $this->conn->query($sql);
        $amount = $query->fetch()['point'];
        return $amount;
    }
}
$history = new BiddingHistory();
$history->insert();
?>