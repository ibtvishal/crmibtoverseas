<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");


$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {	
	$update_field='';
	if(isset($input['student_no'])) {
		$update_field.= "student_no='".$input['student_no']."'";
	} else if(isset($input['stu_name'])) {
		$update_field.= "stu_name='".$input['stu_name']."'";
	} else if(isset($input['father_name'])) {
		$update_field.= "father_name='".$input['father_name']."'";
	} else if(isset($input['dob'])) {
		$update_field.= "dob='".$input['dob']."'";
	} else if(isset($input['passport_no'])) {
		$update_field.= "passport_no='".$input['passport_no']."'";
	}	
	if($update_field && $input['id']) {
		$obj->query("update $tbl_student set $update_field WHERE id='" . $input['id'] . "'",-1); //die; 	
	}
}
?>