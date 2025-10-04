<?php
include("../include/config.php");
include("../include/functions.php"); 
 
session_start();
$name = $_REQUEST['name'];
$action = $_REQUEST['action'];

//Mobile Number verify====================
if($name!='' && $action=='mobilevalidate'){
	$sql =$obj->query("select * from $tbl_admin where phone='$name'",$debug=-1); //die;
	$row=$obj->numRows($sql);
	if($row>0){
		$data["success"] = 1;
		// if($name=='+919818670052' || $name=='+917814961955'){
		// 	$otp = 7788;
		// }elseif($name == '+919595858575'){
		// 	$otp = 3939;
		// }else if($name=='+917814938629'){
		// 	$otp = 5294;
		// }else{
		// 	$otp = rand(1000,9999);
		// }
		$otp = rand(1000,9999);
		$str = ltrim($name, '+9');
		$str1 = ltrim($str, '1');
		otpsms($str1,$otp);
		$_SESSION['otp'] = $otp; 
		$data["message"] = "Otp is successfully sent on given mobile number.";
		echo json_encode($data);
	}else{
		$data["success"] = 2;
		$data["message"] = "This mobile number is not valid";
		echo json_encode($data);
	}
}

//Otp is verify=======================
if($name!='' && $action=='otpvalidate'){
	$mobile = $_REQUEST['mobile'];
	$sql =$obj->query("select * from $tbl_admin where phone='$mobile'",$debug=-1); //die;
	$row=$obj->numRows($sql);
	$line=$obj->fetchNextObject($sql);

	if($_SESSION['otp'] == $name || $line->passcode==$name){
		$_SESSION['sess_admin_id']=$line->id;
		$_SESSION['sess_admin_username']=$line->username;
		$_SESSION['level_id']=$line->level_id;
		$_SESSION['additional_role']=$line->additional_role;
		$sql='';
		if($line->passcode==$name){
			$addtional_role = explode(',',$line->additional_role);
			// if($mobile=='+919818670052' || $mobile=='+917814961955'){
			// 	$passcode = 7788;
			// }elseif($mobile == '+919595858575'){
			// 	$passcode = 3939;
			// }else if($mobile=='+917814938629'){
			// 	$passcode = 5294;
			// }else{
			// 	$passcode = rand(1000,9999);
			// }
			$passcode = rand(1000,9999);
			// $udate = date('Y-m-d');	
			// $branchArr = explode(',',$line->branch_id);
			// foreach ($branchArr as $value) {
			// 	if(getField('office_otp',$tbl_branch,$value)=='' && in_array(1,$addtional_role)){
			// 		$office_otp = rand(1000,9999);							
			// 		$obj->query("update $tbl_branch set office_otp='$office_otp',update_otp_date='".date('Y-m-d')."' where id ='$value'",-1); //die;
			// 	}else if(getField('office_otp',$tbl_branch,$value)!='' && in_array(1,$addtional_role)){
			// 		$office_otp = rand(1000,9999);
			// 		if($udate==getField('update_otp_date',$tbl_branch,$value)){
			// 			$office_otp = getField('office_otp',$tbl_branch,$value);
			// 		}	
			// 		$obj->query("update $tbl_branch set office_otp='$office_otp',update_otp_date='".date('Y-m-d')."' where id ='$value'");
			// 	}
			// }


			$obj->query("update $tbl_admin set passcode='$passcode' where phone='$mobile'",$debug=-1); //die;
		}

		setcookie('mobile', $mobile, time() + (86400 * 30), "/"); // 30 day

		$data["success"] = 1;
		$data["message"] = "Otp is verifed.";
		echo json_encode($data);
	}else{
		$data["success"] = 2;
		$data["message"] = "This otp is not valid";
		echo json_encode($data);
	}
}


//Resend OTP====================
if($name!='' && $action=='resendotp'){
	$sql =$obj->query("select * from $tbl_admin where phone='$name'",$debug=-1); //die;
	$row=$obj->numRows($sql);
	if($row>0){
		$data["success"] = 1;
		$otp = rand(1000,9999);
		$str = ltrim($name, '+9');
		$str1 = ltrim($str, '1');
		otpsms($str1,$otp);
		$_SESSION['otp'] = $otp; 
		$data["message"] = "Otp is successfully sent on given mobile number.";
		echo json_encode($data);
	}else{
		$data["success"] = 2;
		$data["message"] = "This mobile number is not valid";
		echo json_encode($data);
	}
}

?>