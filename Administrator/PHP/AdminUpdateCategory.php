<?php
session_start();
if(isset($_SESSION['user_id'])==0){
header("location:../../loginpage.php");	
}else{
require_once('connect.php');
$id = $_POST['id'];
$txtcat = $_POST['txtcat'];
$txtdesc = $_POST['txtdesc'];
$path = $_FILES['txtimage']['name'];

if($path == ""){
	$update = mysqli_query($link,"UPDATE tblcategory 
						  SET catname='".$txtcat."',
						  catdesc='".$txtdesc."' 
						  WHERE id = '".$id."'") or die ('An error occured ' . mysqli_error($link));	
}else{
	$getImage = mysqli_query($link,"SELECT catimage FROM tblcategory WHERE id = '".$id."'");
	while($rowImage = mysqli_fetch_array($getImage)){	
		$image = $rowImage['catimage'];
	}
	unlink("upload_images/category/".$image);
	
	if(($_FILES['txtimage']['type'] == "image/jpeg")
		||($_FILES['txtimage']['type'] == "image/pjpeg")
		||($_FILES['txtimage']['type'] == "image/png")
		||($_FILES['txtimage']['type'] == "image/gif"))
	{
			//Check errors first
			if($_FILES['txtimage']['error'] > 0){
				echo 'Error occured while processing the form';	
			}
			else{
			
				$txtimage = basename(mysqli_real_escape_string($link, $_FILES['txtimage']['name']));
				if(move_uploaded_file($_FILES['txtimage']['tmp_name'], 
						"upload_images/category/".$_FILES['txtimage']['name'])){
					$sqlalbum = mysqli_query("UPDATE tblcategory SET 
											catname='".$txtcat."',
											catdesc='".$txtdesc."',
											catimage='".$txtimage."'
											WHERE id = '".$id."'") or die ('An error occured while processing the form ' . mysqli_error($link));	
					$status = 'Success';
				}else{
					$status = 'Failed: Something went wrong';	
				}
				echo returnStatus($status);	
			}
	}else{
		echo 'Invalid image format';	
	}
	function returnStatus($status)
				{
					return "<html><body>
					<script type='text/javascript'>
						function init(){if(top.uploadComplete) top.uploadComplete('".$status."');}
						window.onload=init;
					</script></body></html>";
				}
	
}}
?>