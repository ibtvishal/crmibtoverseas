<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
  

$id=$_POST['id'];
$fval=$_POST['fval'];  
$type=$_POST['type'];  

 if (!empty($id) && $type=='diploma') {
 	$sql ='';
 	$totSql = $obj->query("select * from $tbl_institute where id='$fval'",-1); //die;
 	$totResult = $obj->fetchNextObject($totSql);

 	$mSql = $obj->query("select * from $tbl_student_diploma where id='".$id."'");
 	$mResult = $obj->fetchNextObject($mSql);
 	$start_date = $mResult->start_date;
 	$end_date = $mResult->end_date;
 	$time = CalculateRollTime($start_date,$end_date);
 	if($time >= 1){
 		$roll_no_1 = $totResult->roll_no_1 + 1;	
 		$sql = ",roll_no_1='$roll_no_1'";
 		$sql1 = "roll_no_1='$roll_no_1'";
 	}
 	if($time >= 2){
 		$roll_no_2 = $totResult->roll_no_2 + 1;
 		$sql .= ",roll_no_2='$roll_no_2'";
 		$sql1 .= ",roll_no_2='$roll_no_2'";
 	}
 	//echo $sql; die;
	$obj->query("update $tbl_student_diploma set institute_id='$fval' $sql where id='".$id."'",-1);
	$obj->query("update $tbl_institute set $sql1 where id='".$fval."'",-1);
 }

 if (!empty($id) && $type=='company') {
 	
	$obj->query("update $tbl_student_experience set company_id='$fval' where id='".$id."'");
 }


?>