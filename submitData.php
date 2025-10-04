<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");


if($_REQUEST['action']=='addCountry'){

$sql = $obj->query("select * from $tbl_country where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();

$total=$obj->fetchNextObject($sql);

if ($total->name == '') {

	$obj->query("insert into $tbl_country set name='".$obj->escapestring($_REQUEST['name'])."'");
	$_SESSION['sess_msg']='Country added sucessfully';   
	echo 1; die;

}
$_SESSION['sess_msg_error']='This country already added please try another.';   
echo 1; die;
}

if($_REQUEST['action']=='updateCountry'){
$obj->query("update $tbl_country set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Country updated sucessfully';   
echo 1; die;
}



if($_REQUEST['action']=='addQualification'){

$sql = $obj->query("select * from $tbl_qualification where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();

$total=$obj->fetchNextObject($sql);

if ($total->name == '') {

$obj->query("insert into $tbl_qualification set name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
$_SESSION['sess_msg']='Qualification added sucessfully';   
echo 1; die;

}
$_SESSION['sess_msg']='Qualification added already';   
echo 1; die;
}
if($_REQUEST['action']=='updateQualification'){
$obj->query("update $tbl_qualification set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Qualification updated sucessfully';   
echo 1; die;
}

if($_REQUEST['action']=='addManageGap'){

$sql = $obj->query("select * from $tbl_manage_gap where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();

$total=$obj->fetchNextObject($sql);

if ($total->name == '') {

$obj->query("insert into $tbl_manage_gap set name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
$_SESSION['sess_msg']='Gap added sucessfully';   
echo 1; die;

}
$_SESSION['sess_msg']='Gap added already';   
echo 1; die;
}
if($_REQUEST['action']=='updateManageGap'){
$obj->query("update $tbl_manage_gap set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Gap updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addBranch'){

$sql = $obj->query("select * from $tbl_branch where name='".$obj->escapestring($_REQUEST['name'])."' or email='".$obj->escapestring($_REQUEST['email'])."' or phone='".$obj->escapestring($_REQUEST['phone'])."'",-1);//die();
$numRows=$obj->numRows($sql);
if ($numRows>0) {
	$_SESSION['sess_msg_error']='Branch Name, Email, Phone Number Or Address can not be same';   
	echo 1; die;
}
$obj->query("insert into $tbl_branch set name='".$obj->escapestring($_REQUEST['name'])."',email='".$obj->escapestring($_REQUEST['email'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',address='".$obj->escapestring($_REQUEST['address'])."'");
$_SESSION['sess_msg']='Branch added sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='updateBranch'){
$obj->query("update $tbl_branch set name='".$obj->escapestring($_REQUEST['name'])."',email='".$obj->escapestring($_REQUEST['email'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',address='".$obj->escapestring($_REQUEST['address'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Branch updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addStage'){
$obj->query("insert into $tbl_stage set country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_id='".$obj->escapestring($_REQUEST['visa_id'])."',stage='".$obj->escapestring($_REQUEST['stage'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."'",-1); //die;
$_SESSION['sess_msg']='Stage added sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='updateStage'){
$obj->query("update $tbl_stage set country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_id='".$obj->escapestring($_REQUEST['visa_id'])."',stage='".$obj->escapestring($_REQUEST['stage'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Stage updated sucessfully';   
echo 1; die;
}



if($_REQUEST['action']=='addUser'){
	$passcode = rand(999999,100000);
$sql = $obj->query("select * from $tbl_admin where phone='".$obj->escapestring($_REQUEST['phone'])."'",-1);//die();
$result = $obj->numRows($sql);

if ($sql->num_rows == 0) {
// code...
// echo $branch_id = $obj->escapestring($_REQUEST['branch_id']);
	$branch_id = implode(',',$_REQUEST['branch_id']);

$obj->query("insert into $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."',passcode='$passcode'",-1); //die;
$_SESSION['sess_msg']='User added sucessfully';   
echo 1; die;
}
$_SESSION['sess_msg']='User added already';   
echo 1;die;
}


if($_REQUEST['action']=='updateUser'){
	$branch_id = implode(',',$_REQUEST['branch_id']);
$obj->query("update $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."' where id=".$_REQUEST['id'],-1); //die; 
$_SESSION['sess_msg']='User updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addApplication'){

$country_id = getField('country_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
$ssql = $obj->query("select cstatus from $tbl_country_status where status=1 and country_id='$country_id'",-1);
while($sResult = $obj->fetchNextObject($ssql)){
	$intakeArr = explode(",",$sResult->cstatus);
}

if(count($intakeArr)>0){
	$status = $intakeArr[0];
}else{
	$status = '';	
}



$obj->query("insert into $tbl_student_application set parent_id='0',stu_id='".$obj->escapestring($_REQUEST['student_id'])."',college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='$status',portal_status='".$obj->escapestring($_REQUEST['portal_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 
$last_app_id = $obj->lastInsertedId();

$accept_applicaton = getField('accept_student',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
if($accept_applicaton==1){
	$obj->query("update $tbl_student set application_check=1,application_id='$last_app_id' where id='".$obj->escapestring($_REQUEST['student_id'])."'");
}

if(!empty($obj->escapestring($_REQUEST['remarks']))){
	$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$status."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',user_id='".$_SESSION['sess_admin_id']."'",-1);
}

echo 1; die;
}

if($_REQUEST['action']=='updateApplication'){
	$sql = $obj->query("select * from $tbl_student_application where id='".$obj->escapestring($_REQUEST['id'])."'",-1); //die();
	$totald=$obj->fetchNextObject($sql);

	if ($totald->status!='' && $totald->remarks!='' && $totald->status != $obj->escapestring($_REQUEST['app_status']) && $totald->remarks != $obj->escapestring($_REQUEST['remarks'])) {
		 $cdate = date('Y-m-d H:i:s');
		if ($totald->parent_id=='0') {
			$obj->query("insert into $tbl_student_application set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='".$totald->status."',portal_status='".$obj->escapestring($_REQUEST['portal_status'])."',remarks='".$totald->remarks."',user_id='".$_SESSION['sess_admin_id']."',parent_id='$totald->id'", -1); //die; 
			
			$obj->query("update $tbl_student_application set status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',cdate='".$cdate."' where id ='".$_REQUEST['id']."'",-1); //die;


			$obj->query("update $tbl_student set application_check=0,application_id='".$_REQUEST['id']."' where id='".$obj->escapestring($_REQUEST['student_id'])."'");

			$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',user_id='".$_SESSION['sess_admin_id']."'",-1);
		}else{
			$sqll1 = $obj->query("select * from $tbl_student_application where id='".$totald->parent_id."'",-1); //die();
			$totald1=$obj->fetchNextObject($sqll1);

			$obj->query("insert into $tbl_student_application set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='".$totald1->status."',portal_status='".$obj->escapestring($_REQUEST['portal_status'])."',remarks='".$totald1->remarks."',user_id='".$_SESSION['sess_admin_id']."',parent_id='$totald->parent_id'",-1);// die; 
			
			$obj->query("update $tbl_student_application set status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',cdate='".$cdate."' where id ='".$totald->parent_id."'",-1); //die;

			$obj->query("update $tbl_student set application_check=0,application_id='".$totald->parent_id."' where id='".$obj->escapestring($_REQUEST['student_id'])."'");


			$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',user_id='".$_SESSION['sess_admin_id']."'",-1);
		}


		

		echo 1; die;
	}else{
		if($obj->escapestring($_REQUEST['app_status'])!='' && $obj->escapestring($_REQUEST['remarks'])!=''){
			$obj->query("update $tbl_student_application set status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".$obj->escapestring($_REQUEST['remarks'])."',user_id='".$_SESSION['sess_admin_id']."',cdate='".$cdate."' where id='".$obj->escapestring($_REQUEST['id'])."'",-1); //die;
		}
	}
	echo 1; die;

}


if($_REQUEST['action']=='updateApplicationPass'){
$obj->query("update $tbl_student_application set university_id='".$obj->escapestring($_REQUEST['university_id'])."',university_pass='".$obj->escapestring($_REQUEST['university_pass'])."' where id=".$_REQUEST['id'],-1); //die; 
echo 1; die;
}



if($_REQUEST['action']=='addStatus'){
	$sql = $obj->query("select * from $tbl_student_status where cstatus='".$obj->escapestring($_REQUEST['status_status'])."' and stu_id='".$obj->escapestring($_REQUEST['student_id'])."' and stage_id='".$obj->escapestring($_REQUEST['status_stage'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
if ($total->cstatus == '') {
	$obj->query("insert into $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',parent_id='0',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 
	echo 1; die;
}
echo 1; die;
}

if($_REQUEST['action']=='updateStatus'){
	$sql = $obj->query("select * from $tbl_student_status where cstatus='".$obj->escapestring($_REQUEST['status_status'])."' and stu_id='".$obj->escapestring($_REQUEST['student_id'])."' and stage_id='".$obj->escapestring($_REQUEST['status_stage'])."' and remarks='".$obj->escapestring($_REQUEST['status_remarks'])."' ",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->cstatus == '' && $total->stage_id == '' && $total->remarks == '') {
		$sqll = $obj->query("select * from $tbl_student_status where id='".$_REQUEST['id']."'",-1); //die();
		$totald=$obj->fetchNextObject($sqll);
		$cdate = date('Y-m-d H:i:s');
		if ($totald->parent_id=='0') {
			$obj->query("insert into $tbl_student_status set stu_id='".$totald->stu_id."',parent_id='".$totald->id."',stage_id='".$totald->stage_id."',cstatus='".$totald->cstatus."',remarks='".$totald->remarks."',user_id='".$_SESSION['sess_admin_id']."'",-1);// die; 
			$obj->query("update $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',parent_id='$totald->parent_id',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',cdate='".$cdate."',user_id='".$_SESSION['sess_admin_id']."' where id ='".$_REQUEST['id']."'",-1); //die;
		}else{
			$sqll1 = $obj->query("select * from $tbl_student_status where id='".$totald->parent_id."'",-1); //die();
			$totald1=$obj->fetchNextObject($sqll1);

			$obj->query("insert into $tbl_student_status set stu_id='".$totald1->stu_id."',parent_id='".$totald->parent_id."',stage_id='".$totald1->stage_id."',cstatus='".$totald1->cstatus."',remarks='".$totald1->remarks."',user_id='".$_SESSION['sess_admin_id']."'",-1);// die; 
			$obj->query("update $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',parent_id='$totald1->parent_id',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',cdate='".$cdate."',user_id='".$_SESSION['sess_admin_id']."' where id ='".$totald->parent_id."'",-1); //die;
		}
		echo 1; die;
	}
	echo 1; die;
}

if($_REQUEST['action']=='addNotes'){
$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['notes_stage'])."',remarks='".$obj->escapestring($_REQUEST['notes_remarks'])."',portal_status='".$obj->escapestring($_REQUEST['note_portal_status'])."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 

$_SESSION['reload']="0";  
echo 1; die;
}

if($_REQUEST['action']=='updateNotes'){
$obj->query("update $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['notes_stage'])."',remarks='".$obj->escapestring($_REQUEST['notes_remarks'])."',portal_status='".$obj->escapestring($_REQUEST['note_portal_status'])."' where id=".$_REQUEST['id'],-1); //die; 

$_SESSION['reload']="0"; 
echo 1; die;
}

if($_REQUEST['action']=='getDocumentDel'){
$obj->query("update $tbl_student_document set status=0 where id=".$_REQUEST['id'],-1); //die; 
$_SESSION['reload']="0"; 
echo 1; die;
}


if($_REQUEST['action']=='getDocumentUndo'){
$obj->query("update $tbl_student_document set status=1 where id=".$_REQUEST['id'],-1); //die; 
$_SESSION['reload']="0"; 
echo 1; die;
}
if($_REQUEST['action']=='addUnivercity'){

$sql = $obj->query("select * from $tbl_univercity where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();

$total=$obj->fetchNextObject($sql);



if ($total->name == '') {

$obj->query("insert into $tbl_univercity set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
$_SESSION['sess_msg']='University added sucessfully';   
echo 1; die;

}
$_SESSION['sess_msg_error']='This University Already Added Please Try Another';   
echo 1; die;
}


if($_REQUEST['action']=='updateUnivercity'){
$obj->query("update $tbl_univercity set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='University updated sucessfully';

echo 1; die;
}

if($_REQUEST['action']=='addcomment'){
$obj->query("insert into $tbl_student_notes_comment set note_id='".$obj->escapestring($_REQUEST['note_id'])."',sender_id='".$_SESSION['sess_admin_id']."',comments='".$obj->escapestring($_REQUEST['comments'])."'",-1); //die; 
$_SESSION['sess_msg']='Comments updated sucessfully';  
$_SESSION['reload']="0";  
echo 1; die;
}

if($_REQUEST['action']=='SendOtp'){
// $obj->query("insert into $tbl_student_notes_comment set note_id='".$obj->escapestring($_REQUEST['note_id'])."',sender_id='".$_SESSION['sess_admin_id']."',comments='".$obj->escapestring($_REQUEST['comments'])."'",-1); //die; 
// $_SESSION['sess_msg']='Comments updated sucessfully';

	$phone= $_REQUEST['phone'];
	$otp=rand(9999,1000);
	$_SESSION['UserOtp']=$otp;
// otpsms($phone,$otp);
	$inputotp='<div class="form-group">
	<label class="control-label mb-10 text-left">OTP :</label>
	<input type="text" class="form-control otp" placeholder="OTP" name="otp" id="otp"  required>
	<input type="hidden" class="form-control" placeholder="OTP" name="verification_otp" id="verification_otp"  value="'.$otp.'" >
	</div>
	<span id="err_user_otp" style="color:red;"></span>';

	echo $inputotp; die;
}

if($_REQUEST['action']=='getStudnetData'){



	if($_REQUEST['id']==1){
		$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
		$sql=$obj->query("select * from $tbl_student where 1=1 and branch_id='$branch_id'",$debug=-1);
	}else{
		$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
		$sql=$obj->query("select * from $tbl_student where branch_id='$branch_id' and am_id IS NULL",$debug=-1);
	}
	$i=1;
	$inputotp='';
	while($line=$obj->fetchNextObject($sql)){
		$inputotp.='<tr><td>'.$line->student_no.'</td>
		<td>'. $line->stu_name .'</td>
		<td>'. $line->father_name .'</td>
		<td>'. $line->passport_no .'</td>
		<td>'. getField('name',$tbl_country,$line->country_id) .'</td>
		<td>'. getField('name',$tbl_admin,$line->c_id) .'</td>
		<td>'. getField('name',$tbl_admin,$line->am_id) .'</td>
		<td>'. getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id)) .'</td>
		<td>'. date("d M y",strtotime($line->cdate)) .'</td>
		<td>  <div class="material-switch">
		<input id="someSwitchOptionPrimary'.$i .'"  type="checkbox" class="chkstatus" value="'.$line->id.'" data-one="'.$tbl_student.'"/>
		<label for="someSwitchOptionPrimary'.$i .'" class="label-primary"></label>
		</div> </td>
		</tr>';
		if($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3 || $_SESSION['level_id']==4){
			$inputotp.='<a href="student-editf.php?id='. base64_encode(base64_encode(base64_encode($line->id))).'"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> ';
		}
		if($_SESSION['level_id']==1 || $_SESSION['level_id']==4){
			$inputotp.='<a href="student-del.php?id='. $line->id .'" value="Delete" type="submit" class="delete_button" style=" background: transparent;
			border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> ';
		}
		++$i;}
		echo $inputotp; die;
	}

	if($_REQUEST['action']=='addProgrammes'){

		$intake=$obj->escapestring($_REQUEST['intake']);
		if ($intake=='') {
			$intake=0;
		}
		$ielts=$obj->escapestring($_REQUEST['ielts']);
		if ($ielts=='') {
			$ielts=0;
		}
		$pte=$obj->escapestring($_REQUEST['pte']);
		if ($pte=='') {
			$pte=0;
		}
		$duolingo=$obj->escapestring($_REQUEST['duolingo']);
		if ($duolingo=='') {
			$duolingo=0;
		}
		$tofel=$obj->escapestring($_REQUEST['tofel']);
		if ($tofel=='') {
			$tofel=0;
		}

		$obj->query("insert into $tbl_programmes set country='".$obj->escapestring($_REQUEST['country'])."',program_level='".$obj->escapestring($_REQUEST['program_level'])."',state='".$obj->escapestring($_REQUEST['state'])."',univercity='".$obj->escapestring($_REQUEST['univercity'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',course_name='".$obj->escapestring($_REQUEST['course_name'])."',intake='".$intake."',program_duration='".$obj->escapestring($_REQUEST['program_duration'])."',tuition_fee='".$obj->escapestring($_REQUEST['tuition_fee'])."',student_bachelors='".$obj->escapestring($_REQUEST['student_bachelors'])."',percentage='".$obj->escapestring($_REQUEST['percentage'])."',ielts='".$ielts."',pte='".$pte."',duolingo='".$duolingo."',tofel='".$tofel."',moi='".$obj->escapestring($_REQUEST['moi'])."',fees='".$obj->escapestring($_REQUEST['fees'])."'",-1); //die; 
		$_SESSION['sess_msg']='Programmes Add sucessfully';   
		echo 1; die;
}


if($_REQUEST['action']=='updateProgrammes'){


	$intake=$obj->escapestring($_REQUEST['intake']);
	if ($intake=='') {
		$intake=0;
	}
	$ielts=$obj->escapestring($_REQUEST['ielts']);
	if ($ielts=='') {
		$ielts=0;
	}
	$pte=$obj->escapestring($_REQUEST['pte']);
	if ($pte=='') {
		$pte=0;
	}
	$duolingo=$obj->escapestring($_REQUEST['duolingo']);
	if ($duolingo=='') {
		$duolingo=0;
	}

	$tofel=$obj->escapestring($_REQUEST['tofel']);
	if ($tofel=='') {
		$tofel=0;
	}
$obj->query("update $tbl_programmes set country='".$obj->escapestring($_REQUEST['country'])."',program_level='".$obj->escapestring($_REQUEST['program_level'])."',state='".$obj->escapestring($_REQUEST['state'])."',univercity='".$obj->escapestring($_REQUEST['univercity'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',course_name='".$obj->escapestring($_REQUEST['course_name'])."',intake='".$intake."',program_duration='".$obj->escapestring($_REQUEST['program_duration'])."',tuition_fee='".$obj->escapestring($_REQUEST['tuition_fee'])."',student_bachelors='".$obj->escapestring($_REQUEST['student_bachelors'])."',percentage='".$obj->escapestring($_REQUEST['percentage'])."',ielts='".$ielts."',pte='".$pte."',duolingo='".$duolingo."',tofel='".$tofel."',moi='".$obj->escapestring($_REQUEST['moi'])."',fees='".$obj->escapestring($_REQUEST['fees'])."' where id=".$_REQUEST['id'],-1);// die; 
$_SESSION['sess_msg']='Programmes updated sucessfully';   
echo 1; die;
}
if($_REQUEST['action']=='addstate'){
$sql = $obj->query("select * from $tbl_state where state='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
$total=$obj->fetchNextObject($sql);
if ($total->state == '') {
$obj->query("insert into $tbl_state set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state='".$obj->escapestring($_REQUEST['name'])."'",-1); //die;
$_SESSION['sess_msg']='State added sucessfully';   
echo 1; die;
}
$_SESSION['sess_msg_error']='This State Already Added Please Try Another';   
echo 1; die;
}


if($_REQUEST['action']=='updatestate'){
$obj->query("update $tbl_state set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='State updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addGap'){
$obj->query("insert into $tbl_gap set qualification='".$obj->escapestring($_REQUEST['qualification'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',gap='".$obj->escapestring($_REQUEST['gap'])."',preferred_course='".$obj->escapestring($_REQUEST['preferred_course'])."',diploma='".$obj->escapestring($_REQUEST['diploma'])."',duration='".$obj->escapestring($_REQUEST['duration'])."',exp_duration='".$obj->escapestring($_REQUEST['exp_duration'])."',designation='".$obj->escapestring($_REQUEST['designation'])."'",-1); //die;
$_SESSION['sess_msg']='gap added sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='updateGap'){
$obj->query("update $tbl_gap set qualification='".$obj->escapestring($_REQUEST['qualification'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',gap='".$obj->escapestring($_REQUEST['gap'])."',preferred_course='".$obj->escapestring($_REQUEST['preferred_course'])."',diploma='".$obj->escapestring($_REQUEST['diploma'])."',duration='".$obj->escapestring($_REQUEST['duration'])."',exp_duration='".$obj->escapestring($_REQUEST['exp_duration'])."',designation='".$obj->escapestring($_REQUEST['designation'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Stage updated sucessfully';   
echo 1; die;
}

if($_REQUEST['action']=='addCountryStatus'){
	$sql = $obj->query("select * from $tbl_country_status where country_id='".$obj->escapestring($_REQUEST['country_id'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->id == '') {
	$obj->query("insert into $tbl_country_status set country_id='".$obj->escapestring($_REQUEST['country_id'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."'",-1);//die();
	$_SESSION['sess_msg']='Country status added sucessfully';   
	echo 1; die;

	}
	$_SESSION['sess_msg_error']='This Country Status Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='updateCountryStatus'){
	$obj->query("update $tbl_country_status set country_id='".$obj->escapestring($_REQUEST['country_id'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Country Status updated sucessfully';

	echo 1; die;
}



if($_REQUEST['action']=='addPortalStatus'){
	$sql = $obj->query("select * from $tbl_portal_status where country_id='".$obj->escapestring($_REQUEST['country_id'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->id == '') {
		$obj->query("insert into $tbl_portal_status set country_id='".$obj->escapestring($_REQUEST['country_id'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."'",-1);//die();
		$_SESSION['sess_msg']='Portal added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Portal Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='updatePortalStatus'){
	$obj->query("update $tbl_portal_status set country_id='".$obj->escapestring($_REQUEST['country_id'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Portal updated sucessfully';

	echo 1; die;
}



if($_REQUEST['action']=='addDiploma'){
	$sql = $obj->query("select * from $tbl_diploma where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_diploma set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Diploma added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Diploma already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateDiploma'){
	$obj->query("update $tbl_diploma set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Diploma updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='addCompany'){
	$sql = $obj->query("select * from $tbl_company where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_company set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Company added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Company already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateCompany'){
	$obj->query("update $tbl_company set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Company updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='addDesignation'){
	$sql = $obj->query("select * from $tbl_designation where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_designation set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Designation added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Designation already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateDesignation'){
	$obj->query("update $tbl_designation set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Designation updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='addInstitute'){
	$sql = $obj->query("select * from $tbl_institute where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_institute set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Institute added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Institute already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateInstitute'){
	$obj->query("update $tbl_institute set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Institute updated sucessfully';   
	echo 1; die;
}



if($_REQUEST['action']=='getDocumentView'){

	

	$type = $_REQUEST['type'];
	$document = "";
	if($type==1){
		$sql = $obj->query("select name,desiredExt from $tbl_student_document where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);		
		if ($result->desiredExt=='jpg'){
			$document .='<img src="uploads/'.$result ->name.'" alt="" style="width: 100%;">';
			$document .='<p>'.$result ->name.'</p>';
		}else{
			$document .='<iframe src="uploads/'.$result ->name.'">';
			$document .='</iframe>';
			$document .='<p>'.$result ->name.'</p>';		

		 }
	 }else if($type==2){
	 	$sql = $obj->query("select pimg from $tbl_student_diploma where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document .='<img src="uploads/'.$result ->pimg.'" alt="" style="width: 100%;">';
		$document .='<p>'.$result ->pimg.'</p>';
	 }else if($type==3){
	 	$sql = $obj->query("select pimg from $tbl_student_experience where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document .='<img src="uploads/'.$result ->pimg.'" alt="" style="width: 100%;">';
		$document .='<p>'.$result ->pimg.'</p>';
	 }


	

	 echo $document;
}



if($_REQUEST['action']=='addCourse'){
	$obj->query("insert into $tbl_course set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',university_id='".$obj->escapestring($_REQUEST['university_id'])."',name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
		$_SESSION['sess_msg']='Course added sucessfully';   
		echo 1; die;
}

if($_REQUEST['action']=='updateCourse'){
	$obj->query("update $tbl_course set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',university_id='".$obj->escapestring($_REQUEST['university_id'])."',name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Course updated sucessfully';
	echo 1; die;
}

?>