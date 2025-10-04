<?php session_start();
include("include/config.php");
include("include/functions.php"); 
validate_user();

	if($_REQUEST['aid']!='')
	{	
	   
	    $sql="delete from $tbl_student_application where id='".$_REQUEST['aid']."'"; 
		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
		header("location: student-editf.php?id=".$_REQUEST['stu_id']);
		exit();
    }

	if($_REQUEST['sid']!='')
	{	
	   
	    $sql="delete from $tbl_student_status where id='".$_REQUEST['sid']."'"; 
		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
		header("location: student-editf.php?id=".$_REQUEST['stu_id']);
		exit();
    }
	
?>
