<?php 
session_start();
include("include/config.php");
include("include/functions.php"); 
validate_admin();
$arr =$_POST['id'];


	if(isset($_GET['id']))
	{	
	   
	    $sql="delete from $tbl_category where id='".$_GET['id']."'"; 

		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
		header("location: category-list.php");
		exit();
    }
	if(isset($_GET['download_id']))
	{	
	   
	    $sql="delete from $tbl_download_category where id='".$_GET['download_id']."'"; 

		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
		header("location: manage-download-category.php");
		exit();
    }

	
?>
