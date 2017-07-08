<?php
include_once(dirname(__FILE__).'/IDbConnection/IConnectInfo.php');

class DbConnect implements IConnectInfo{

    private static $server = IConnectInfo::HOST;
    private static $name = IConnectInfo::NAME;
    private static $password = IConnectInfo::PASS;
    private static $port = IConnectInfo::PORT;
    private static $dbName = IConnectInfo::DBNAME;
    private static $conn ;

    public static function connect(){
        try {
		 	self::$conn = new PDO("mysql:host=".self::$server.";port=".self::$port.";dbname=".self::$dbName,
                            self::$name, self::$password,
                            array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
		 	self::$conn->setAttribute(PDO::ATTR_ERRMODE, 
                                PDO::ERRMODE_EXCEPTION);
		 	//echo 'connect successfully<br/>';
		 } catch(PDOException $pdoException) {
		 	echo $pdoException->getMessage();
		 	//echo 'failed connect<br/>';
		 }
		 return self::$conn;
    }
}
?>