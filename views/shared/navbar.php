<?php session_start();?>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">BiddingKing</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="./index.php">首頁</a></li>
        <?php 
          if(isset($_SESSION['username'])){
            echo '<li><a href="./history.php">下標紀錄</a></li>';
            echo '<li><a href="#">個人資料編輯</a></li>';
          }
        ?>
        <li><a href="#">儲值</a></li>
        <?php 
          if(isset($_SESSION['type'])  && ($_SESSION['type'] === 'admin')){
            echo '<li><a href="./upload.php">產品上傳</a></li>';
          }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(isset($_SESSION['username'])){
            echo "<li><a><span><strong>歡迎登入 : " . $_SESSION['username'] . "</strong></span></a></li>";
            echo '<li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>';
          }else{
            echo '<li><a href="./register.php"><span class="glyphicon glyphicon-user"></span> 註冊</a></li>';
            echo '<li><a href="./login.php"><span class="glyphicon glyphicon-log-in"></span> 登入</a></li>';
          }
        ?>
      </ul>
    </div>
  </div>
</nav>
