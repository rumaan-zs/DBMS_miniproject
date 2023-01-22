<?php
require_once('Administrator/PHP/connect.php');

	$id = $_POST['id'];	
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();	
	$timeout = 60*60*24;  //1 day or 24 hours;
	$out = $time - $timeout;
	$check = mysqli_query($link,"SELECT * FROM tblip WHERE ip='$ip' AND time > '$out' ") or die (mysql_error());
	if(mysqli_num_rows($check) > 0 ){
		header("Location:index.php?error=1");
	}else{
		$insertip = mysqli_query($link,"INSERT INTO tblip(ip,time) VALUES ('$ip','$time')")or die(mysql_error());
		$updatevote = mysqli_query($link,"UPDATE tblvotes SET vpoints = vpoints + 1 WHERE vid = '$id'") or die(mysql_error());
		header("Location:index.php?success=1");
	}
?>