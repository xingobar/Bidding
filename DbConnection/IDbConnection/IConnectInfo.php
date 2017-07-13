<?php
interface IConnectInfo{
    const HOST  = '127.0.0.1';
    const NAME = 'root';
    const PASS = 'root';
    const PORT = '8889';
    const DBNAME = 'bidding';

    public static function connect();
}
?>