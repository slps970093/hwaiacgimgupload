<?php session_start(); ?>
<?php
<<<<<<< HEAD
	/*
	 *
	 * 網宣上傳系統 (Ver 2.0)
	 * Code by Yu-Hsien,Chou
	 * 新增 圖片自動調整大小功能(PHP需支援GD函式庫)
	 *
	 */

	if(is_null($_SESSION['username'])){
		header("location:login.php");
	}
	if(is_file("init.php")){
		include("init.php");
	}else{
		echo "<script type='text/javascript'>alert('找不到初始化設定檔案');</script>";
		header("location:stop.php");
	}
=======
	if(!is_file("config.php")){
		echo "<script type='text/javascript'>alert('發生嚴重錯誤，請檢查設定檔案是否在網站根目錄下');</script>";
	}else{
		include "config.php"; //設定檔案
		if(is_null($config['username']) && is_null($config['password'])){
			echo "<script type='text/javascript'>alert('警告!帳號密碼尚未設定，請檢查設定檔案是否設定正確');</script>";
		}
	}
	if(is_null($_SESSION['username'])){
		header("location:login.php");
	}
>>>>>>> parent of afc4b6a... V2.0
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$dir = "upload/";
		unlink($dir."webimg.jpg"); //刪除檔案
		//改檔案名
		$file = explode(".", basename($_FILES['imgfile']['name']));
		$Name = "webimg";
		$file[0] = $Name.".".$file[1];
		$target_Path = $dir.basename($file[0]);
		//進行檔案上傳
		$result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $target_Path);
		if($result){
			header("location:imgupload.php?success");
		}else{
			header("location:imgupload.php?failed");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $config['title']; ?>─網宣檔案上傳介面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script  src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			background-color: #FFFFFF;
			color: 	#000000;
		}
		.upload-view{
			border-radius: 5px;
			background-color: #FFBB00;
		}
		#readme{
			border-radius: 10px;
		}
	</style>
</head>
<body>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="upload-view">
				<?php if(isset($_GET['success'])){ ?>
					<div class="alert alert-success" role="alert">檔案上傳成功!<a href="<?php echo $config['blog']; ?>">點我可連結到部落格進行觀看</a></div>
				<?php } ?>
				<?php if(isset($_GET['failed'])){ ?>
					<div class="alert alert-warning" role="alert">檔案上傳失敗</div>
				<?php } ?>
				<h1>歡迎使用本系統</h1>
				<hr size="2">
				<div class="jumbotron" id="readme">
					使用本系統注意事項如下:<br>
					<ol type="1">
						<li>檔案副檔名一律使用JPEG</li>
						<li>本系統不會自動壓縮圖片大小，請自行變更</li>
						<li>請注意檔案命名，請勿使用"."來取檔案名稱，以免發生錯誤(EX:web.ini.jpg)</li>
<<<<<<< HEAD
						<li>使用縮圖功能，若長寬數值為空，將使用系統設定檔內的預設值進行縮圖動作(預設值為長:<?php echo $config['default_height']; ?>像素&nbsp;寬:<?php echo $config['default_weight']; ?>像素)</li>
						<li>使用縮圖功能只需要輸入數值資料即可，不需輸入單位</li>
=======
>>>>>>> parent of afc4b6a... V2.0
					</ol>
					如需修改程式碼，請點選一下按鈕觀看專案原始碼
					<p><a class="btn btn-primary btn-lg" href="https://github.com/slps970093/hwaiacgimgupload" role="button">查看專案原始碼</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="logout.php" role="button">登出</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="<?php echo $config['blog']; ?>" role="button">連結部落格</a></p>
				</div>
				<form method="post" action="imgupload.php" enctype="multipart/form-data">
					上傳圖片檔案<br>
					<input type="file" name="imgfile"><br>
					<button class="btn btn-default">上傳檔案</button>
				</form><br>
				瀏覽目前圖片:<br>
				<img src="upload/webimg.jpg" class="img-responsive"><br>
				外部連結網址:<?php echo $config['siteurl']; ?>upload/webimg.jpg
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>