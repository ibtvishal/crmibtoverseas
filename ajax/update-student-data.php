<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
  

$id=$_POST['id'];
$fval=$_POST['fval'];  
$type=$_POST['type'];  
$stype=$_POST['stype'];  

 if (!empty($id) && $stype==1) {
	if($type == 'institute_forms_status' && $fval==0){
		$sql=" update $tbl_student_diploma set institute_forms_status='0',exam_status='0',student_approval_status='0'";
	}else{
		$sql=" update $tbl_student_diploma set $type='$fval'";
	}
	$sql.=" where id='".$id."'";
	//echo $sql; die;
	$obj->query($sql);
 }else if(!empty($id) && $stype==2){
 	if($type == 'resume' && $fval==0){
 		$sql=" update $tbl_student_experience set resume='0',address_proof='0',counsellor_status='0'";
 	}else{
 		$sql=" update $tbl_student_experience set $type='$fval'";
 	}
 	
    $sql.=" where id='".$id."'";
    $obj->query($sql);
 }


?>