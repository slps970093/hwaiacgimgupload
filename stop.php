<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>發生錯誤!</title>
</head>
<body>
	<?php if(isset($_GET['config'])){ ?>
	<h1>Oops!程式發生錯誤</h1>
	<hr>
	請先檢查設定檔之後，將錯誤排除即可正常執行<br>
	<pre>
	$config['default_weight'] -> 數值 (必要) 預設壓縮 長
	$config['default_height'] -> 數值 (必要) 預設壓縮 寬
	$config['blog'] -> 請填寫網站網址(非必要 如果為空則不會有連結部落格按鈕)
	$config['username'] -> 字串 (必要) 管理者帳號
	$config['password'] -> 字串 (必要) 管理者密碼
	$config['siteurl']	-> 字串 (非必要) 站台網址
	//設定網站標題
	$config['title'] -> 字串 (非必要) 網站標題
	<pre>
	<?php }else{ ?>
	<h1>Oops!程式發生錯誤</h1>
	<hr>
	請先排除程式錯誤之後，才可以正常執行!<br>
	<?php } ?>
</body>
</html>