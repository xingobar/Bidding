<?php
    $host = 'localhost';    // 伺服器位置
    $port = '9000';          // 連接端口

    // Create the socket and connect
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    $connection = socket_connect($socket,$host, $port);
    while($buffer = socket_read($socket, 1024, PHP_NORMAL_READ)){
        if($buffer == 'NO DATA'){
            echo('<p>NO DATA</p>');
            break;
        }
        else{
        // Do something with the data in the buffer
            echo('<p>Buffer Data: ' . $buffer . '</p>');
        }
    }
    echo('<p>Writing to Socket</p>');
    // Write some test data to our socket
    if(!socket_write($socket, 'SOME DATA\r\n')){
        echo('<p>Write failed</p>');
    }
    // Read any response from the socket
    while($buffer = socket_read($socket, 1024, PHP_NORMAL_READ)){
        echo('<p>Data sent was: SOME DATA<br> Response was:' . $buffer . '</p>');
    }
    echo('<p>Done Reading from Socket</p>');
?>