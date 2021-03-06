<?php
  $host = 'localhost';    // 伺服器位置
  $port = '9000';          // 連接端口
  $null = NULL;                 // 設定空值
  
  // 建立 socket
  $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
  socket_bind($socket, 0, $port);
  socket_listen($socket);
  
  // 建立監聽 socket 列表到此陣列 （有增加也重新定義）
  $clients = array($socket);
  
  while (true) {
    $changed = $clients;
    
    // 指定這些連線超時作業
    socket_select($changed, $null, $null, 0, 10);
    
    // 判斷是否有新建立連線
    if (in_array($socket, $changed)) {
      $socket_new = socket_accept($socket);
      $clients[] = $socket_new;// 更新列表
         
      $header = socket_read($socket_new, 1024);
      // 回覆 ws protocol 連線資料
      perform_handshaking($header, $socket_new, $host, $port);
      
      socket_getpeername($socket_new, $ip);    // 取得對方 ip
      
      // 建立訊息資料，使用 json 資料傳遞，可自行定義，並經過 fun mask 編碼
      $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected')));  
      
      // 傳給所有 client
      send_message($response);
      
      // 記住此新連線
      $found_socket = array_search($socket, $changed);
      unset($changed[$found_socket]);
    }

          //loop through all connected sockets
      foreach ($changed as $changed_socket) {

             //check for any incomming data
             while(socket_recv($changed_socket, $buf, 1024, 0) >= 1){
                   $received_text = unmask($buf); //unmask data
                   $tst_msg = json_decode($received_text); //json decode
                   $response_text = mask(json_encode(array($tst_msg)));
                   send_message($response_text);
                   break 2; //exist this loop
             }
             $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
             if ($buf === false) { // check disconnected client
                   // remove client for $clients array
                   $found_socket = array_search($changed_socket, $clients);
                   socket_getpeername($changed_socket, $ip);
                   unset($clients[$found_socket]);
                   //notify all users about disconnected connection
                   $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
                   //send_message($response);
             }
      }

  }
  
  // 關閉 socket ... 基本上不需要關閉了
  socket_close($sock);
  
  // 傳送訊息給所有 client
  function send_message($msg) {
    global $clients;
    // foreach ($clients as $changed_socket) {
    //   @socket_write($changed_socket,$msg,strlen($msg));
    // }
    @socket_write($client_socket,$msg,strlen($msg));
    return true;
}
  
  // 將 ws 傳送過來的訊息解碼
  function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
      $masks = substr($text, 4, 4);
      $data = substr($text, 8);
    }
    elseif($length == 127) {
      $masks = substr($text, 10, 4);
      $data = substr($text, 14);
    }
    else {
      $masks = substr($text, 2, 4);
      $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
      $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
  }
  
  // 將訊息編碼
  function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);
    
    if($length <= 125) {
      $header = pack('CC', $b1, $length);
    } elseif ($length > 125 && $length < 65536) {
      $header = pack('CCn', $b1, 126, $length);
    } elseif ($length >= 65536) {
      $header = pack('CCNN', $b1, 127, $length);
    }
    return $header.$text;
  }
  
  // ws 連線 protocol 並傳送給新建立連線 client
  function perform_handshaking($receved_header,$client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach ($lines as $line) {
      $line = chop($line);
      if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
        $headers[$matches[1]] = $matches[2];
      }
    }
  
    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    //hand shaking header
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
    "Upgrade: websocket\r\n" .
    "Connection: Upgrade\r\n" .
    "WebSocket-Origin: $host\r\n" .
    "WebSocket-Location: ws://$host:$port/\r\n".
    "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
  }
  
?>