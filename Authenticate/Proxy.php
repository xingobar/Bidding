<?php
include_once('../DbConnection/DbConnect.php');
include_once(dirname(__FILE__).'/IHandler/IHandler.php');

class Proxy implements IHandler{

    /*
    @param1 : db connect 
    @param2 : error message (type :error)
    @param3 : user email
    @param4 : user password
    @param5 : login success (type : boolean)
    */
    private $conn;
    private $message;
    private $email;
    private $password;
    private $isSuccess;

    public function __construct(){
        session_start();
        $this->message = array();
        $this->conn = DbConnect::connect();
        $this->isSuccess= false;
    }

    public function login(){
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        
        $this->isAuth();
        if($this->isSuccess){
           return header('location:../views/index.php');
        }
        $this->addErrorMsg();
        return header('location: ../views/login.php');
    }

    public function isAuth(){
        session_unset();
        $tempPassword = md5($this->password);
        $sql = 'select * from user where email=:email and password = :password';
        $query = $this->conn->prepare($sql);
        $query->execute(array(
            'email'=>$this->email,
            'password'=>$tempPassword
        ));
        $user = $query->fetchAll();
        $userExists = count($user);
        if($userExists === 1){
            $_SESSION['username'] = $user[0]['name'];
            $_SESSION['type'] = $user[0]['type'];
            $this->isSuccess = true;
        }
        return $this->isSuccess;
    }

    public function addErrorMsg(){
        $_SESSION['error_msg'] = '帳號或密碼輸入錯誤';   
        $_SESSION['login_email_error'] = $this->email;
        $_SESSION['login_password_error'] = $this->password;
    }
    public function request(){
        return ;
    }
}

?>