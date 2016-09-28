<?php
	if(is_file("init.php")){
		include("init.php");
	}else{
		echo "<script type='text/javascript'>alert('找不到初始化設定檔案');</script>";
		header("location:stop.php");
	}
	header("location:login.php");
?>