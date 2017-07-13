<?php

class Auth{

    public function __construct(){
        session_start();
    }

    public function auth(){
        if(empty($_SESSION['type']) || $_SESSION['type'] != 'admin' || empty($_SESSION['username'])){
            return header('location:../views/index.php');
        }
    }
}

$auth = new Auth();
$auth->auth();
?>