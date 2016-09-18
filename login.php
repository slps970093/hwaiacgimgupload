<?php session_start(); ?>
<?php
	if(!is_file("config.php")){
		echo "<script type='text/javascript'>alert('發生嚴重錯誤，請檢查設定檔案是否在網站根目錄下');</script>";
	}else{
		include "config.php"; //設定檔案
		if(is_null($config['username']) && is_null($config['password'])){
			echo "<script type='text/javascript'>alert('警告!帳號密碼尚未設定，請檢查設定檔案是否設定正確');</script>";
		}
	}
	if(isset($_SESSION['username'])){
		header("location:imgupload.php");
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if($_POST['username'] == $config['username'] && $_POST['password'] == $config['password']){
			$_SESSION['username'] = $_POST['username'];
			header("location:imgupload.php");
		}else{
			header("location:login.php?failed");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $config['title']; ?>─網宣上傳登入介面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script  src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			background-color: #FFFFFF;
			color: 	#000000;
		}
		.web-login{
			background-color: #33FFFF;
			border-radius: 5px;
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
				<div class="web-login">
				<h1><?php echo $config['title']; ?>─網宣上傳登入介面</h1>
				<hr size="2">
					<?php if(isset($_GET['failed'])){ ?>
						<div class="alert alert-warning" role="alert">帳號或密碼錯誤</div>
					<?php } ?>
					<?php if(isset($_GET['logout'])){ ?>
						<div class="alert alert-warning" role="alert">你已成功登出</div>
					<?php } ?>	
				<form method="post" action="login.php">
					帳號:<br>
					<input type="text" name="username" class="form-control"><br>
					密碼:<br>
					<input type="password" name="password" class="form-control"><br>
					<button class="btn btn-default">登入</button>
				</form>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>