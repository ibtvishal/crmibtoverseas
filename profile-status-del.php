<?php session_start();
include("include/config.php");
include("include/functions.php"); 

$id =$_REQUEST['id'];

$stu_id = $_REQUEST['stu_id'];

	if($_REQUEST['id']!='')
	{	
	   
	    $sql="delete from $tbl_student_status where id='".$_REQUEST['id']."'"; 

		$obj->query($sql);
		$sess_msg='Selected record(s) deleted successfully';
		$_SESSION['sess_msg']=$sess_msg;
    }

	header("location: student-editf.php?id=".base64_encode(base64_encode(base64_encode($stu_id))));
	exit();
	
?>
