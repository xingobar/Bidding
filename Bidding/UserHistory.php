<?php
include_once('../DbConnection/DbConnect.php');

class UserHistory{

    private $conn ;

    public function __construct(){
        session_start();
        $this->conn = DbConnect::connect();
    }

    public function get(){
        $user_id = $this->getUerId();
        $sql = "SELECT history.created_at,history.price,product.name 
                FROM history
                INNER JOIN product ON history.product_id = product.id
                WHERE history.user_id = $user_id";
        
        $query = $this->conn->query($sql);
        $results = $query->fetchAll();

        foreach($results as $result){
            echo <<<REQUEST
                <tr>
                    <td class="text-left">{$result['created_at']}</td>
                    <td class="text-left">{$result['name']}</td>
                    <td class="text-left">{$result['price']}</td>
                </tr>
REQUEST;

        }
    }

    public function getUerId(){
        $name = $_SESSION['username'];
        $sql = "SELECT * FROM user WHERE name = '$name'";
        $query = $this->conn->query($sql);
        return $query->fetch()['id'];
    }

}
?>