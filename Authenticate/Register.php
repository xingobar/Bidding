<?php
include_once('../DbConnection/DbConnect.php'); 

class Register{

    private $name;
    private $userName;
    private $email;
    private $password;
    private $address;
    private $confirm;
    private $message; // error message (type : array)
    private $conn; // db connection

    public function __construct(){
         session_start();
         $this->message = array();
         $this->conn = DbConnect::connect();
    }

    public function auth(){
        $this->name = $_POST['name'];
        $this->userName = $_POST['username'];
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        $this->confirm = $_POST['confirm'];
        $this->address = $_POST['address'];

        if($this->checkUserExists()){
            $this->message['user_error'] = '名稱已經存在';
        }


        if($this->checkEmailExists()){
            $this->message['email_error'] = '電子郵件已經存在';
        }

        if(!$this->isSamePassword()){
            $this->message['password_error'] ='密碼不一致';
        }

        if(!empty($this->message)){
            $this->addErrorMsgAndStoreData();
            return header('location:../views/register.php');
        }
        $this->insertData();
        session_destroy();
        return header('location:../views/index.php');
    }

    public function checkUserExists(){
        $query = $this->conn->prepare('select * from user where name = :name');
        $query->execute(array(
            'name' => $this->userName
        ));
        $existsUser = count($query->fetchAll());
        if($existsUser >=1){
            return true;
        }
        return false;
    }

    public function checkEmailExists(){
        $query = $this->conn->prepare('select * from user where email = :email');
        $query->execute(array(
            'email'=>$this->email
        ));
        $existsEmail = count($query->fetchAll());
        if($existsEmail >=1){
            return true;
        }
        return false;
    }

    public function isSamePassword(){
        return ($this->password === $this->confirm);
    }

    public function insertData(){
        $sql = 'insert into user (name,email,password,address)
                values(:name,:email,:password,:address)';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'name'=>$this->name,
            'email' => $this->email,
            'password' => md5($this->password),
            'address' => $this->address
        ));
    }

    public function addErrorMsgAndStoreData(){
        $_SESSION['user_error'] = $this->message['user_error'];
        $_SESSION['email_error'] = $this->message['email_error'];
        $_SESSION['password_error'] = $this->message['password_error'];
        $_SESSION['name'] = $this->name;
        $_SESSION['username'] = $this->userName;
        $_SESSION['email'] = $this->email;
        $_SESSION['password'] = $this->password;
        $_SESSION['confirm'] = $this->confirm;
        $_SESSION['address'] = $this->address;
    }
}
$register = new Register();
$register->auth();
?>