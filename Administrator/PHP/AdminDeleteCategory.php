<?php
session_start();
if(isset($_SESSION['user_id'])==0){
header("location:../../loginpage.php");	
}else{
	require_once('connect.php');
	$id = $_REQUEST['id'];
	$getimage = mysqli_query($link,"SELECT catimage FROM tblcategory WHERE id = '".$id."'");
	while($rowImage = mysqli_fetch_array($getimage)){
		  $image = $rowImage['catimage'];	
	}
	unlink("upload_images/category/".$image);
	$delete = mysqli_query($link,"DELETE FROM tblcategory WHERE id = '".$id."'") or die ('An error occured '.mysql_error());
	$delete = mysqli_query($link,"DELETE FROM tblalbum WHERE albumcat = '".$id."'")or die ('An error occured '.mysql_error());
	header("Location:AdminViewCategory.php");
}
?>