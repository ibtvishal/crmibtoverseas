<?php session_start();
include("include/config.php");
include("include/functions.php"); 
validate_admin();
$arr =$_POST['id'];

if($_REQUEST['id']!='')
{	
    $sql="delete from $tbl_diploma where id='".$_REQUEST['id']."'"; 
	$obj->query($sql);
	$sess_msg='Selected record(s) deleted successfully';
	$_SESSION['sess_msg']=$sess_msg;
}

header("location: diploma-list.php");
exit();
	
?>
