<?php session_start(); ?>
<?php
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
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if($_POST['resize'] == 1){
			$dir = "upload/";
			unlink($dir."webimg.jpg"); //刪除檔案
			//改檔案名
			$file = explode(".", basename($_FILES['imgfile']['name']));
			$Name = "tmp";
			$file[0] = $Name.".".$file[1];
			$tmp_Path = $dir.basename($file[0]);
			//進行檔案上傳
			$result = move_uploaded_file($_FILES['imgfile']['tmp_name'], $tmp_Path);
			//改檔案名
			if($result){
				$src = imagecreatefromjpeg($tmp_Path);
				//取圖片長寬
				$src_weight = imagesx($src);
				$src_height = imagesy($src);
				//套用自定義大小
				$usr_weight = (!is_null($_POST['weight']))?intval($_POST['weight']):$config['default_weight'];
				$usr_heiget = (!is_null($_POST['height']))?intval($_POST['height']):$config['default_height'];
				$dst_image = imagecreatetruecolor($usr_weight, $usr_heiget);
				imagecopyresized($dst_image, $src, 0, 0, 0, 0, $usr_weight, $usr_heiget, $src_weight, $src_height);
				$result = imagejpeg($dst_image,$dir."webimg.jpg");
				if($result){
					unlink($tmp_Path);
					header("location:imgupload.php?success");
				}else{
					unlink($tmp_Path);
					header("location:imgupload.php?failed");
				}
			}
		}else{
			echo "HELLO";
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
						<li>使用縮圖功能，若長寬數值為空，將使用系統設定檔內的預設值進行縮圖動作(預設值為長:<?php echo $config['default_height']; ?>像素&nbsp;寬:<?php echo $config['default_weight']; ?>像素)</li>
						<li>使用縮圖功能只需要輸入數值資料即可，不需輸入單位</li>
					</ol>
					如需修改程式碼，請點選一下按鈕觀看專案原始碼
					<p><a class="btn btn-primary btn-lg" href="https://github.com/slps970093/hwaiacgimgupload" role="button">查看專案原始碼</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="logout.php" role="button">登出</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="<?php echo $config['blog']; ?>" role="button">連結部落格</a></p>
				</div>
				<div class="alert alert-info" role="alert" style="display:none" id="Lockwarning">注意：你已經啟用縮圖功能，如需修改數值請點<button type="button" class="btn btn-danger" id="disabledLock">解除封鎖</button>如需還原請點<button type="button" class="btn btn-default" id="reset">還原預設設定</button></div>
				<form method="POST" action="imgupload.php" enctype="multipart/form-data">
					上傳圖片檔案:<br>
					<input type="file" name="imgfile"><br>
					是否調整圖片大小:<br>
					<select name="resize" id="Resize" class="form-control">
						<option value="1">是</option>
						<option value="0" selected="selected">否</option>
					</select>
					<script type="text/javascript">
						$("#Resize").change(function(){
							if($("#Resize").val()==="1"){
								alert("你已經啟用縮圖功能，如需修改數值請點選解除封鎖");
								$("#ResizeMenu").fadeIn();
								$("#Lockwarning").fadeIn();
							}else{
								$("#ResizeMenu").fadeOut();
								$("#Lockwarning").fadeOut();
								$('#weight').val("<?php echo $config['default_weight']; ?>");
								$('#height').val("<?php echo $config['default_height']; ?>");
								$('#weight').attr("readonly","readonly");
								$('#height').attr("readonly","readonly");
							}
						});
						$("#disabledLock").click(function(){
							$('#weight').removeAttr("readonly")
							$('#height').removeAttr("readonly")
						});
						$("#reset").click(function(){
							$('#weight').val("<?php echo $config['default_weight']; ?>")
							$('#height').val("<?php echo $config['default_height']; ?>")
							$('#weight').attr("readonly","readonly")
							$('#height').attr("readonly","readonly")
						});
					</script>
					<div id="ResizeMenu" style="display:none">
						<hr>
						縮圖設定：<br>
						寬度（單位像素）：<input type="text" class="form-control" value="<?php echo $config['default_weight']; ?>" name="weight" id="weight" readonly="readonly"><br>
						高度（單位像素）：<input type="text" class="form-control" value="<?php echo $config['default_height']; ?>" name="height" id="height" readonly="readonly"><br>
					</div>
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