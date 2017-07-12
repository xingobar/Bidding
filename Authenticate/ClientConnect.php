<?php
include_once(dirname(__FILE__).'/IHandler/IHandler.php');
include_once('Proxy.php');

class ClientConnect{

    public function __construct(){
        $proxy = new Proxy();
        $this->authenticate($proxy);
    }
    public function authenticate(IHandler $proxy){
        $proxy->login();
    }
}
$clientConnect = new ClientConnect();
?>