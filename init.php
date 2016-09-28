<?php
	/*
	 * 程式初始化
	 * Code By Yu-Hsien Chou 
	 *
	 */
	if(!is_file("config.php")){
		echo "<script type='text/javascript'>alert('發生嚴重錯誤，請檢查設定檔案是否在網站根目錄下');</script>";
		header("location:stop.php");
	}else{
		include "config.php"; //設定檔案
		if(is_null($config['username']) && is_null($config['password'])){
			echo "<script type='text/javascript'>alert('警告!帳號密碼尚未設定，請檢查設定檔案是否設定正確');</script>";
			header("location:stop.php?config");
		}
		if(is_null($config['default_weight']) && is_null($config['default_height'])){
			echo "<script type='text/javascript'>alert('注意:偵測到圖片預設長寬無資料，請到設定檔案進行設定');</script>";
			header("location:stop.php?config");
			if(!is_numeric($config['default_weight']) && !is_numeric($config['default_height'])){
				echo "<script type='text/javascript'>alert('圖片預設壓縮格式設定錯誤，請確認是否為數值');</script>";
				header("location:stop.php?config");
			}
		}
	}
?>