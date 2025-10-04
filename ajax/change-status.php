<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
  

$id=$_POST['id'];
$tableName=$_POST['tableName'];  
$status=$_POST['status'];  

 if ($_POST['id']) {
	if ($tableName=='tbl_qualification') {
	   $sql=" update tbl_gap set status='$status' where qualification='$id'";
	   $obj->query($sql);
	}
	 $sql=" update $tableName set status='$status'";
	 $sql.=" where id='".$id."'";
	 $obj->query($sql);

	 if($tableName=='tbl_univercity'){
	 	$sql=" update tbl_programmes set status='$status' where univercity='$id'";
	   	$obj->query($sql);
	 }
 }


?>