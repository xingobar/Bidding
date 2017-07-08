<?php session_start();?>
<?php
if(isset($_SESSION['username'])){
    header('location:index.php');
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>競標王</title>
        <link rel="stylesheet" href="../public/css/login.css">
    </head>
    <body>
        <div class="container">
            <div class="card card-container">
                <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <form class="form-signin" method="post" action="../Authenticate/ClientConnect.php">
                    <span id="reauth-email" class="reauth-email"></span>
                    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus value="<?php echo $_SESSION['login_email_error'];?>">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required value="<?php echo $_SESSION['login_password_error'];?>">
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <span style="color:#bf0e0e"><strong><?php echo $_SESSION['error_msg'];?></strong></span>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                </form>
                <a href="#" class="forgot-password">
                    忘記密碼?
                </a>
            </div>
        </div>
    </body>
</html>