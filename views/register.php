<?php session_start();?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../public/css/register.css">
        <title>競標王</title>
    </head>
    <body>
        <div class="container">
			<div class="row main">
				<div class="main-login main-center">
				<h2 class="text-center">註冊</h2>
					<form method="post" action="../Authenticate/Register.php">	
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">名字</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="請輸入收貨者姓名" value="<?php echo $_SESSION['name'];?>"/>
								</div>
							</div>
						</div>
                        <div class="form-group">
							<label for="address" class="cols-sm-2 control-label">地址</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-road" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="address" id="address"  placeholder="請輸入地址" value="<?php echo $_SESSION['address']?>"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">電子郵件</label>
                            <span style="color:#bf0e0e"><strong><?php echo $_SESSION['email_error'];?></strong></span>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="email"  placeholder="請輸入電子郵件" value="<?php echo $_SESSION['email'];?>"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">使用者名稱</label>
                            <span style="color:#bf0e0e"><strong><?php echo $_SESSION['user_error'];?></strong></span>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="請輸入使用者名稱" value="<?php echo $_SESSION['username'];?>"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">密碼</label>
                            <span style="color:#bf0e0e"><strong><?php echo $_SESSION['password_error'];?></strong></span>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="請輸入密碼" value="<?php echo $_SESSION['password'];?>"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">密碼確認</label>
                            <span style="color:#bf0e0e"><strong><?php echo $_SESSION['password_error'];?></strong></span>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirm" id="confirm"  placeholder="請再一次輸入密碼" value="<?php echo $_SESSION['confirm'];?>"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button id="button" type="submit" class="btn btn-primary btn-lg btn-block login-button">註冊</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </body>
</html>