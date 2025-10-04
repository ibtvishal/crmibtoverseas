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

if($_REQUEST['action']=='addGoogleSheet'){
$sql = $obj->query("select * from tbl_google_sheet where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
$sql1 = $obj->query("select * from tbl_google_sheet",-1);//die();
$total_c=$obj->numRows($sql1);
$total=$obj->fetchNextObject($sql);
if($total_c > 5){
	$_SESSION['sess_msg_error']='You can add maximum 6 Google Sheet';   
	echo 1; die;
}
if ($total->name == '') {
	$obj->query("insert into tbl_google_sheet set name='".$obj->escapestring($_REQUEST['name'])."', url='".$obj->escapestring($_REQUEST['url'])."'");
	$_SESSION['sess_msg']='Google Sheet added sucessfully';   
	echo 1; die;
}
$_SESSION['sess_msg_error']='This Google Sheet already added please try another.';   
echo 1; die;
}

if($_REQUEST['action']=='updateIncentivePlan'){
$obj->query("update tbl_incentive set body='".$obj->escapestring($_REQUEST['body'])."', branch_id='".$obj->escapestring($_REQUEST['branch_id'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Incentive Plan updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='updateGoogleSheet'){
$obj->query("update tbl_google_sheet set name='".$obj->escapestring($_REQUEST['name'])."', url='".$obj->escapestring($_REQUEST['url'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Google Sheet updated sucessfully';   
echo 1; die;
}

if($_REQUEST['action']=='updateCountry'){
$obj->query("update $tbl_country set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Country updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addIncentivePlan'){
	$sql = $obj->query("select * from tbl_incentive where branch_id='".$obj->escapestring($_REQUEST['branch_id'])."'",-1);//die();
	$total=$obj->numRows($sql);
	if ($total == 0) {
		$obj->query("insert into tbl_incentive set body='".$obj->escapestring($_REQUEST['body'])."', branch_id='".$obj->escapestring($_REQUEST['branch_id'])."'");
		$_SESSION['sess_msg']='Incentive Plan added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Incentive plan added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='addCategory'){
	$sql = $obj->query("select * from $tbl_category where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_category set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Category added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Category already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='addCategory1'){
	$sql = $obj->query("select * from $tbl_policy_category where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_policy_category set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Category added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Category already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateCategory1'){
	$obj->query("update $tbl_policy_category set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Category updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='updateCategory'){
	$obj->query("update $tbl_category set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Category updated sucessfully';   
	echo 1; die;
}
if($_REQUEST['action']=='addSubCategory'){
	$sql = $obj->query("select * from tbl_subcategory where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into tbl_subcategory set category_id='".$obj->escapestring($_REQUEST['cid'])."', name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Subcategory added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Subcategory already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='addSubCategory1'){
	$sql = $obj->query("select * from $tbl_policy_subcategory where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_policy_subcategory set category_id='".$obj->escapestring($_REQUEST['cid'])."', name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Subcategory added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Subcategory already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateSubCategory'){
	$obj->query("update tbl_subcategory set name='".$obj->escapestring($_REQUEST['name'])."', category_id='".$obj->escapestring($_REQUEST['cid'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Category updated sucessfully';   
	echo 1; die;
}


if($_REQUEST['action']=='updateSubCategory1'){
	$obj->query("update $tbl_policy_subcategory set name='".$obj->escapestring($_REQUEST['name'])."', category_id='".$obj->escapestring($_REQUEST['cid'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Category updated sucessfully';   
	echo 1; die;
}




if($_REQUEST['action']=='addLeadStatus'){
	$sql = $obj->query("select * from $tbl_lead_status where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_lead_status set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Status added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Status already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateLeadStatus'){
	$obj->query("update $tbl_lead_status set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Status updated sucessfully';   
	echo 1; die;
}



if($_REQUEST['action']=='addVisitStatus'){
	$sql = $obj->query("select * from $tbl_visit_status where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_visit_status set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Status added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Status already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateVisitStatus'){
	$obj->query("update $tbl_visit_status set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Status updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='addQuestion'){
	$subcat = $obj->escapestring($_REQUEST['subcat_id']);
	if($subcat==''){
		$subcat=0;
	}
	$obj->query("insert into $tbl_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."'",-1); //die;
	$_SESSION['sess_msg_error']='Question added sucessfully.';   
	echo 1; die;
}

if($_REQUEST['action']=='addQuestion1'){
	$subcat = $obj->escapestring($_REQUEST['subcat_id']);
	if($subcat==''){
		$subcat=0;
	}
	$obj->query("insert into $tbl_policy_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."'",-1); //die;
	$_SESSION['sess_msg_error']='Question added sucessfully.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateQuestion'){
	$subcat = $obj->escapestring($_REQUEST['subcat_id']);
	if($subcat==''){
		$subcat=0;
	}
	$obj->query("update $tbl_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Question updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='updateQuestion1'){
	$subcat = $obj->escapestring($_REQUEST['subcat_id']);
	if($subcat==''){
		$subcat=0;
	}
	$obj->query("update $tbl_policy_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Question updated sucessfully';   
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
$obj->query("insert into $tbl_branch set name='".$obj->escapestring($_REQUEST['name'])."',email='".$obj->escapestring($_REQUEST['email'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',address='".$obj->escapestring($_REQUEST['address'])."',gst='".$obj->escapestring($_REQUEST['gst'])."' ,billing_name='".$obj->escapestring($_REQUEST['billing_name'])."' ,branch_code='".$obj->escapestring($_REQUEST['branch_code'])."' ,approval_members='".$obj->escapestring($_REQUEST['approval_members'])."' ,state_code='".$obj->escapestring($_REQUEST['state_code'])."' ,state='".$obj->escapestring($_REQUEST['state'])."' ");
$_SESSION['sess_msg']='Branch added sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='updateBranch'){
$obj->query("update $tbl_branch set name='".$obj->escapestring($_REQUEST['name'])."',email='".$obj->escapestring($_REQUEST['email'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',address='".$obj->escapestring($_REQUEST['address'])."',gst='".$obj->escapestring($_REQUEST['gst'])."' ,billing_name='".$obj->escapestring($_REQUEST['billing_name'])."' ,branch_code='".$obj->escapestring($_REQUEST['branch_code'])."' ,approval_members='".$obj->escapestring($_REQUEST['approval_members'])."' ,state_code='".$obj->escapestring($_REQUEST['state_code'])."' ,state='".$obj->escapestring($_REQUEST['state'])."',user_roles='".$obj->escapestring($_REQUEST['user_roles'])."',users='".$obj->escapestring($_REQUEST['users'])."'  where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Branch updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addStage'){
	$user_roles = implode(',',$_REQUEST['user_roles']);
	$obj->query("insert into $tbl_stage set country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_id='".$obj->escapestring($_REQUEST['visa_id'])."',stage='".$obj->escapestring($_REQUEST['stage'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."',user_roles='$user_roles'",-1); //die;
	$_SESSION['sess_msg']='Stage added sucessfully';   
	echo 1; die;
}


if($_REQUEST['action']=='updateStage'){
	$user_roles = implode(',',$_REQUEST['user_roles']);
$obj->query("update $tbl_stage set country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_id='".$obj->escapestring($_REQUEST['visa_id'])."',stage='".$obj->escapestring($_REQUEST['stage'])."',cstatus='".$obj->escapestring($_REQUEST['cstatus'])."',user_roles='$user_roles' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Stage updated sucessfully';   
echo 1; die;
}



if($_REQUEST['action']=='addUser'){
	$passcode = rand(9999,1000);
	$sql = $obj->query("select * from $tbl_admin where phone='".$obj->escapestring($_REQUEST['phone'])."' and level_id='".$obj->escapestring($_REQUEST['level_id'])."'",-1);//die();
	$result = $obj->numRows($sql);
	if ($sql->num_rows == 0) {
		$branch_id = implode(',',$_REQUEST['branch_id']);
		if($_REQUEST['additional_role']){
			$additional_role = implode(',',$_REQUEST['additional_role']);
		}else{
			$additional_role='';
		}
		if($_REQUEST['account_manager']){
			$account_manager = implode(',',$_REQUEST['account_manager']);
		}else{
			$account_manager='';
		}
		$obj->query("insert into $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."',passcode='$passcode',additional_role='$additional_role',account_manager='$account_manager',reapply_counsellor='".$obj->escapestring($_REQUEST['reapply_counsellor'])."',director='".$obj->escapestring($_REQUEST['director'])."'",-1); //die;

		$obj->query("insert into $tbl_support_user set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."'",-1); //die;
		$_SESSION['sess_msg']='User added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg']='User added already';   
	echo 1;die;
}

if($_REQUEST['action']=='addSupportUser'){
	$result = $obj->numRows($sql);
	if ($sql->num_rows == 0) {
		$branch_id = implode(',',$_REQUEST['branch_id']);
		
		$obj->query("insert into $tbl_support_user set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',designation='".$obj->escapestring($_REQUEST['designation'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."'",-1); //die;
		$_SESSION['sess_msg']='Support User added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg']='User added already';   
	echo 1;die;
}


if($_REQUEST['action']=='updateSupportUser'){
	$branch_id = implode(',',$_REQUEST['branch_id']);
	
	$obj->query("update $tbl_support_user set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',designation='".$obj->escapestring($_REQUEST['designation'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."' where id=".$_REQUEST['id'],-1); //die; 
	$_SESSION['sess_msg']='Support User updated sucessfully';   
	echo 1; die;
}


if($_REQUEST['action']=='updateUser'){
	$branch_id = implode(',',$_REQUEST['branch_id']);
	if($_REQUEST['additional_role']){
		$additional_role = implode(',',$_REQUEST['additional_role']);
	}else{
		$additional_role='';
	}

	if($_REQUEST['account_manager']){
		$account_manager = implode(',',$_REQUEST['account_manager']);
	}else{
		$account_manager='';
	}
	if($_POST['review_manager_status'] == 1){
		$sql = $obj->query("select * from $tbl_admin where phone='".$obj->escapestring($_REQUEST['phone'])."' and level_id='22'",-1);
	$result = $obj->numRows($sql);
	if ($sql->num_rows > 0) {
		$obj->query("update $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='22',additional_role='2',account_manager='$account_manager',reapply_counsellor='".$obj->escapestring($_REQUEST['reapply_counsellor'])."',director='".$obj->escapestring($_REQUEST['director'])."',status=1 where phone='".$obj->escapestring($_REQUEST['phone'])."' and level_id='22'",-1); 
	}else{
		$obj->query("insert $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='22',additional_role='2',account_manager='$account_manager',reapply_counsellor='".$obj->escapestring($_REQUEST['reapply_counsellor'])."',director='".$obj->escapestring($_REQUEST['director'])."'",-1); 
	}
	}else{
		$obj->query("update $tbl_admin set status=0 where phone='".$obj->escapestring($_REQUEST['phone'])."' and level_id='22'",-1); 
	}
	$obj->query("update $tbl_admin set branch_id='$branch_id',name='".$obj->escapestring($_REQUEST['name'])."',phone='".$obj->escapestring($_REQUEST['phone'])."',email='".$obj->escapestring($_REQUEST['email'])."',level_id='".$obj->escapestring($_REQUEST['level_id'])."',additional_role='$additional_role',account_manager='$account_manager',reapply_counsellor='".$obj->escapestring($_REQUEST['reapply_counsellor'])."',director='".$obj->escapestring($_REQUEST['director'])."' where id=".$_REQUEST['id'],-1); //die; 
	$_SESSION['sess_msg']='User updated sucessfully';   
	echo 1; die;
}


if($_REQUEST['action']=='addApplication'){

// $country_id = getField('country_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
// $ssql = $obj->query("select cstatus from $tbl_country_status where status=1 and country_id='$country_id'",-1);
// while($sResult = $obj->fetchNextObject($ssql)){
// 	$intakeArr = explode(",",$sResult->cstatus);
// }

// if(count($intakeArr)>0){
// 	$status = $intakeArr[0];
// }else{
// 	$status = '';	
// }

$appsql = $obj->query("select id from $tbl_student_application where parent_id=0",-1); //die;
$appNum = $obj->numRows($appsql);
if($appNum>0){
	$app_id = $appNum+1;
}else{
	$app_id = 1;
}


$obj->query("insert into $tbl_student_application set parent_id='0',app_id='$app_id',stu_id='".$obj->escapestring($_REQUEST['student_id'])."',college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='".$obj->escapestring($_REQUEST['app_status'])."',portal_status='".$obj->escapestring($_REQUEST['portal_status'])."',application_fee='".$obj->escapestring($_REQUEST['application_fee'])."',portal_id='".$obj->escapestring($_REQUEST['portal_id'])."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 
$last_app_id = $obj->lastInsertedId();

$accept_applicaton = getField('accept_student',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
if($accept_applicaton==1 && $_SESSION['level_id']!=3){
	$obj->query("update $tbl_student set application_check=1,application_id='$last_app_id' where id='".$obj->escapestring($_REQUEST['student_id'])."'");
}

if(!empty(trim($obj->escapestring($_REQUEST['remarks'])))){
	$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die;

	$branch_id = getField('branch_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));

	if($obj->escapestring($_REQUEST['app_notification'])==1){
		$obj->query("insert into $tbl_notification set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',branch_id='$branch_id',university_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',type=1,remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
	}
	
}

echo 1; die;
}

if($_REQUEST['action']=='updateApplication'){
	$sql = $obj->query("select * from $tbl_student_application where id='".$obj->escapestring($_REQUEST['id'])."'",-1); //die();
	$totald=$obj->fetchNextObject($sql);
	$cdate = date('Y-m-d H:i:s');
	if ($totald->parent_id=='0') {
		
		$obj->query("insert into $tbl_student_application set stu_id='".$totald->stu_id."',college_name='".$totald->college_name."',location='".$totald->location."',course='".$totald->course."',month='".$totald->month."',year='".$totald->year."',status='".$totald->status."',portal_status='".$totald->portal_status."',remarks='".$obj->escapestring($totald->remarks)."',user_id='".$totald->user_id."',parent_id='$totald->id',cdate='$totald->cdate',application_fee='".$totald->application_fee."',portal_id='$totald->portal_id'", -1); //die; 
		
		$obj->query("update $tbl_student_application set college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='".$obj->escapestring($_REQUEST['app_status'])."',portal_status='".trim($obj->escapestring($_REQUEST['portal_status']))."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',application_fee='".$obj->escapestring($_REQUEST['application_fee'])."',portal_id='".$obj->escapestring($_REQUEST['portal_id'])."',user_id='".$_SESSION['sess_admin_id']."',cdate='$cdate' where id ='".$_REQUEST['id']."'",-1); //die;

		
		$obj->query("update $tbl_student set application_check=0,application_id='".$_REQUEST['id']."' where id='".$obj->escapestring($_REQUEST['student_id'])."'");
		
		if(!empty(trim($obj->escapestring($_REQUEST['remarks'])))){			
			$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die;

			$branch_id = getField('branch_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));

			if($obj->escapestring($_REQUEST['app_notification'])==1){
				$obj->query("insert into $tbl_notification set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',branch_id='$branch_id',university_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',type=2,remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
			}
		}
	}else{
		$sqll1 = $obj->query("select * from $tbl_student_application where id='".$totald->parent_id."'",-1); //die();
		$totald1=$obj->fetchNextObject($sqll1);

		$obj->query("insert into $tbl_student_application set stu_id='".$totald1->stu_id."',college_name='".$totald1->college_name."',location='".$totald1->location."',course='".$totald1->course."',month='".$totald1->month."',year='".$totald1->year."',status='".$totald1->status."',portal_status='".$totald1->portal_status."',remarks='".$obj->escapestring($totald1->remarks)."',user_id='".$totald1->user_id."',parent_id='$totald->parent_id',application_fee='".$totald->application_fee."',portal_id='$totald->portal_id',cdate='".$totald1->cdate."'",-1);// die; 

		$obj->query("update $tbl_student_application set college_name='".$obj->escapestring($_REQUEST['univercity_id_application'])."',location='".$obj->escapestring($_REQUEST['state_id_application'])."',course='".$obj->escapestring($_REQUEST['course'])."',month='".$obj->escapestring($_REQUEST['month'])."',year='".$obj->escapestring($_REQUEST['year'])."',status='".$obj->escapestring($_REQUEST['app_status'])."',application_fee='".$obj->escapestring($_REQUEST['application_fee'])."',portal_id='".$obj->escapestring($_REQUEST['portal_id'])."',cdate='".$cdate."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."' where id ='".$totald->parent_id."'",-1); //die;

		$obj->query("update $tbl_student set application_check=0,application_id='".$totald->parent_id."' where id='".$obj->escapestring($_REQUEST['student_id'])."'",-1); //die;

		if(!empty(trim($obj->escapestring($_REQUEST['remarks'])))){
			$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',portal_status='".$obj->escapestring($_REQUEST['app_status'])."',remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die;

			$branch_id = getField('branch_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
			if($obj->escapestring($_REQUEST['app_notification'])==1){
				$obj->query("insert into $tbl_notification set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',branch_id='$branch_id',university_id='".$obj->escapestring($_REQUEST['univercity_id_application'])."',type=2,remarks='".trim($obj->escapestring($_REQUEST['remarks']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
			}
		}
	}
	$accept_applicaton = getField('accept_student',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
	if($accept_applicaton==1 && $_SESSION['level_id']!=3){
		$obj->query("update $tbl_student set application_check=1,application_id='$last_app_id' where id='".$obj->escapestring($_REQUEST['student_id'])."'");
	}
		echo 1; die;

}


if($_REQUEST['action']=='updateApplicationPass'){
$obj->query("update $tbl_student_application set university_id='".$obj->escapestring($_REQUEST['university_id'])."',university_pass='".$obj->escapestring($_REQUEST['university_pass'])."' where id=".$_REQUEST['id'],-1); //die; 
echo 1; die;
}



if($_REQUEST['action']=='addStatus'){
	if($_REQUEST['status_status'] == 'Visa Refused'){
		$obj->query("update $tbl_student set student_login=0 where id ='".$_REQUEST['student_id']."'",-1); //die;
	}
	$sql = $obj->query("select * from $tbl_student_status where cstatus='".$obj->escapestring($_REQUEST['status_status'])."' and stu_id='".$obj->escapestring($_REQUEST['student_id'])."' and stage_id='".$obj->escapestring($_REQUEST['status_stage'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->cstatus == '') {
		$obj->query("insert into $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',parent_id='0',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',university='".$obj->escapestring($_REQUEST['university'])."',user_id='".$_SESSION['sess_admin_id']."',status_branch='".$obj->escapestring($_REQUEST['status_branch'])."',from_date='".$obj->escapestring($_REQUEST['from_date'])."',to_date='".$obj->escapestring($_REQUEST['to_date'])."',commission_status='".$obj->escapestring($_REQUEST['commission_status'])."'",-1); //die; 

		if($_REQUEST['status_status'] == 'Visa Refused' || $_REQUEST['status_status'] == 'Defer But Not Refused' || $_REQUEST['status_status'] == 'Visa Approved'){
			$student_contact_no = getField("student_contact_no",$tbl_student, $_REQUEST['student_id']);
			$alternate_contact = getField("alternate_contact",$tbl_student, $_REQUEST['student_id']);
			$whr = " ";
			if($_REQUEST['status_status'] == 'Visa Refused' || $_REQUEST['status_status'] == 'Defer But Not Refused'){
				$whr .= " reapply_status='1'";
			}elseif($_REQUEST['status_status'] == 'Visa Approved'){
				$whr .= " `university_change_status`='1', student_id='".$obj->escapestring($_REQUEST['student_id'])."'";
			}
			$obj->query("UPDATE $tbl_visit SET $whr where applicant_contact_no in ('$student_contact_no','$alternate_contact') or applicant_alternate_no in ('$student_contact_no','$alternate_contact')");
		}
		
		echo 1; die;
	}
	echo 1; die;
}

if($_REQUEST['action']=='updateStatus'){
	if($_REQUEST['status_status'] == 'Deferred'){
		$obj->query("UPDATE $tbl_student SET approve_review=0 where id='".$_REQUEST['student_id']."'");
	}

	if($_REQUEST['status_status'] == 'Visa Refused' || $_REQUEST['status_status'] == 'Defer But Not Refused' || $_REQUEST['status_status'] == 'Visa Approved'){
		if($_REQUEST['status_status'] == 'Visa Refused'){
			$obj->query("update $tbl_student set student_login=0 where id ='".$_REQUEST['student_id']."'",-1); //die;
		}
		$student_contact_no = getField("student_contact_no",$tbl_student, $_REQUEST['student_id']);
		$alternate_contact = getField("alternate_contact",$tbl_student, $_REQUEST['student_id']);
		$whr = " ";
		if($_REQUEST['status_status'] == 'Visa Refused' || $_REQUEST['status_status'] == 'Defer But Not Refused'){
			$whr .= " `reapply_status`='1'";
		}elseif($_REQUEST['status_status'] == 'Visa Approved'){
			$whr .= " `university_change_status`='1'";
		}
		$obj->query("UPDATE $tbl_visit SET $whr where applicant_contact_no in ('$student_contact_no','$alternate_contact') or applicant_alternate_no in ('$student_contact_no','$alternate_contact')");
	}
	
	if($_REQUEST['status_stage'] == 13 || $_REQUEST['status_stage'] ==  36 || $_REQUEST['status_stage'] == 37 || $_REQUEST['status_stage'] == 70 || $_REQUEST['status_stage'] == 29 || $_REQUEST['status_stage'] == 67 || $_REQUEST['status_stage'] == 68){
		$cdate = date('Y-m-d H:i:s');
		$obj->query("update $tbl_student_status set cstatus='".$obj->escapestring($_REQUEST['status_status'])."',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',university='".$obj->escapestring($_REQUEST['university'])."',cdate='".$cdate."',user_id='".$_SESSION['sess_admin_id']."',status_branch='".$obj->escapestring($_REQUEST['status_branch'])."',from_date='".$obj->escapestring($_REQUEST['from_date'])."',to_date='".$obj->escapestring($_REQUEST['to_date'])."',commission_status='".$obj->escapestring($_REQUEST['commission_status'])."' where id ='".$_REQUEST['id']."'",-1); //die;
		echo 1; die;
	}
	
	$sql = $obj->query("select * from $tbl_student_status where cstatus='".$obj->escapestring($_REQUEST['status_status'])."' and stu_id='".$obj->escapestring($_REQUEST['student_id'])."' and stage_id='".$obj->escapestring($_REQUEST['status_stage'])."' and remarks='".$obj->escapestring($_REQUEST['status_remarks'])."' ",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->cstatus == '' && $total->stage_id == '' && $total->remarks == '') {
		$sqll = $obj->query("select * from $tbl_student_status where id='".$_REQUEST['id']."'",-1); //die();
		$totald=$obj->fetchNextObject($sqll);
		$cdate = date('Y-m-d H:i:s');
		if ($totald->parent_id=='0') {
			$obj->query("insert into $tbl_student_status set stu_id='".$totald->stu_id."',parent_id='".$totald->id."',stage_id='".$totald->stage_id."',cstatus='".$totald->cstatus."',cdate='".$totald->cdate."',remarks='".$obj->escapestring($totald->remarks)."',user_id='".$totald->user_id."',university='".$totald1->university."',commission_status='".$totald1->commission_status."'",-1);// die; 
			$obj->query("update $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',parent_id='$totald->parent_id',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',university='".$obj->escapestring($_REQUEST['university'])."',commission_status='".$obj->escapestring($_REQUEST['commission_status'])."',cdate='".$cdate."',user_id='".$_SESSION['sess_admin_id']."' where id ='".$_REQUEST['id']."'",-1); //die;
		}else{
			$sqll1 = $obj->query("select * from $tbl_student_status where id='".$totald->parent_id."'",-1); //die();
			$totald1=$obj->fetchNextObject($sqll1);

			$obj->query("insert into $tbl_student_status set stu_id='".$totald1->stu_id."',parent_id='".$totald->parent_id."',stage_id='".$totald1->stage_id."',cstatus='".$totald1->cstatus."',cdate='".$totald1->cdate."',remarks='".$obj->escapestring($totald1->remarks)."',user_id='".$totald1->user_id."',university='".$totald1->university."',commission_status='".$totald1->commission_status."',commission_status='".$totald1->commission_status."'",-1);// die; 

			
			$obj->query("update $tbl_student_status set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',parent_id='$totald1->parent_id',stage_id='".$obj->escapestring($_REQUEST['status_stage'])."',cstatus='".$obj->escapestring($_REQUEST['status_status'])."',remarks='".$obj->escapestring($_REQUEST['status_remarks'])."',university='".$obj->escapestring($_REQUEST['university'])."',cdate='".$cdate."',user_id='".$_SESSION['sess_admin_id']."',commission_status='".$obj->escapestring($_REQUEST['commission_status'])."' where id ='".$totald->parent_id."'",-1); //die;
		}
		echo 1; die;
	}else{
		if($_REQUEST['university']!='' && $obj->escapestring($_REQUEST['status_status']=='Visa Approved')){
			$obj->query("update $tbl_student_status set university='".$obj->escapestring($_REQUEST['university'])."',commission_status='".$obj->escapestring($_REQUEST['commission_status'])."',cdate='".$cdate."' where id ='".$_REQUEST['id']."'",-1); //die;
		}
	}
	echo 1; die;
}

if($_REQUEST['action']=='addNotes'){
	$obj->query("insert into $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['notes_stage'])."',remarks='".$obj->escapestring($_REQUEST['notes_remarks'])."',portal_status='".$obj->escapestring($_REQUEST['note_portal_status'])."',user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 

	$branch_id = getField('branch_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
	if($obj->escapestring($_REQUEST['note_notification'])==1){
		$obj->query("insert into $tbl_notification set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',branch_id='$branch_id',university_id='".$obj->escapestring($_REQUEST['notes_stage'])."',type=1,remarks='".trim($obj->escapestring($_REQUEST['notes_remarks']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
	}
	echo 1; die;
}

if($_REQUEST['action']=='updateNotes'){
	$obj->query("update $tbl_student_notes set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',univercity_id='".$obj->escapestring($_REQUEST['notes_stage'])."',remarks='".$obj->escapestring($_REQUEST['notes_remarks'])."',portal_status='".$obj->escapestring($_REQUEST['note_portal_status'])."' where id=".$_REQUEST['id'],-1); //die; 

	$branch_id = getField('branch_id',$tbl_student,$obj->escapestring($_REQUEST['student_id']));
	if($obj->escapestring($_REQUEST['note_notification'])==1){
		$obj->query("update $tbl_notification set stu_id='".$obj->escapestring($_REQUEST['student_id'])."',branch_id='$branch_id',university_id='".$obj->escapestring($_REQUEST['notes_stage'])."',type=2,remarks='".trim($obj->escapestring($_REQUEST['notes_remarks']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
	}
	echo 1; die;
}

if($_REQUEST['action']=='getDocumentDel'){
	$obj->query("update $tbl_student_document set status=0,deleted_by='".$_SESSION['sess_admin_id']."',deleted_at='".date('Y-m-d H:i:s')."' where id=".$_REQUEST['id'],-1); //die; 
	echo 1; die;
	}




if($_REQUEST['action']=='getDocumentUndo'){
	$obj->query("update $tbl_student_document set status=1,deleted_by=0 where id=".$_REQUEST['id'],-1); //die;  
	echo 1; die;
}
if($_REQUEST['action']=='addUnivercity'){

	$sql = $obj->query("select * from $tbl_univercity where name='".$obj->escapestring($_REQUEST['name'])."'",-1); //die();
	$total=$obj->numRows($sql);

	if ($total>0) {
		$_SESSION['sess_msg_error']='This University Already Added Please Try Another';   
		echo 1; die;
	}else{		
		$obj->query("insert into $tbl_univercity set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',name='".$obj->escapestring($_REQUEST['name'])."',video_url='".$obj->escapestring($_REQUEST['video_url'])."',video_title='".$obj->escapestring($_REQUEST['video_title'])."',fee='".$obj->escapestring($_REQUEST['fee'])."'",-1); //die; 
		$_SESSION['sess_msg']='University added sucessfully';   
		echo 1; die;
	}
	
}

if($_REQUEST['action']=='addUnivercityvideo'){
	$sql = $obj->query("select * from $tbl_univercity_application_video where university_id='".$obj->escapestring($_REQUEST['university_id'])."'",-1); //die();
	$total=$obj->numRows($sql);
	if ($total>0) {
		$_SESSION['sess_msg_error']='This University Already Added Please Try Another';   
		echo 1; die;
	}else{		
		$obj->query("insert into $tbl_univercity_application_video set university_id='".$obj->escapestring($_REQUEST['university_id'])."',video_url='".$obj->escapestring($_REQUEST['video_url'])."',video_title='".$obj->escapestring($_REQUEST['video_title'])."'",-1); //die; 
		$_SESSION['sess_msg']='University Application Video added sucessfully';   
		echo 1; die;
	}
	
}


if($_REQUEST['action']=='updateUnivercity'){
$obj->query("update $tbl_univercity set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."',name='".$obj->escapestring($_REQUEST['name'])."',video_url='".$obj->escapestring($_REQUEST['video_url'])."',video_title='".$obj->escapestring($_REQUEST['video_title'])."',fee='".$obj->escapestring($_REQUEST['fee'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='University updated sucessfully';

echo 1; die;
}

if($_REQUEST['action']=='updateUnivercityvideo'){
$obj->query("update $tbl_univercity_application_video set university_id='".$obj->escapestring($_REQUEST['university_id'])."',video_url='".$obj->escapestring($_REQUEST['video_url'])."',video_title='".$obj->escapestring($_REQUEST['video_title'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='University Application Video updated sucessfully';

echo 1; die;
}

if($_REQUEST['action']=='addcomment'){

	$obj->query("insert into $tbl_student_notes_comment set note_id='".$obj->escapestring($_REQUEST['note_id'])."',sender_id='".$_SESSION['sess_admin_id']."',comments='".$obj->escapestring($_REQUEST['comments'])."'",-1); //die; 

	$stu_id = getField('stu_id',$tbl_student_notes,$obj->escapestring($_REQUEST['note_id']));
	$univercity_id = getField('univercity_id',$tbl_student_notes,$obj->escapestring($_REQUEST['note_id']));
	$branch_id = getField('branch_id',$tbl_student,$stu_id);
	$portal_status = getField('portal_status',$tbl_student_notes,$obj->escapestring($_REQUEST['note_id']));
	
	// echo $obj->escapestring($_REQUEST['comment_notification']);
	if($obj->escapestring($_REQUEST['comment_notification'])==1){
		$obj->query("insert into $tbl_notification set stu_id='$stu_id',branch_id='$branch_id',university_id='$univercity_id',type=3,remarks='".trim($obj->escapestring($_REQUEST['comments']))."',sender_id='".$_SESSION['sess_admin_id']."'",-1); //die;
	}

	$obj->query("insert into $tbl_student_notes set stu_id='$stu_id',univercity_id='$univercity_id',portal_status='$portal_status',user_id='".$_SESSION['sess_admin_id']."',remarks='".$obj->escapestring($_REQUEST['comments'])."'",-1); //die; 

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
		$course_name = $obj->escapestring($_REQUEST['course_name']);
		if($course_name=='other'){
			$course_name = $obj->escapestring($_REQUEST['add_course_name_field']);
		}

		$obj->query("insert into $tbl_programmes set country='".$obj->escapestring($_REQUEST['country'])."',program_level='".$obj->escapestring($_REQUEST['program_level'])."',state='".$obj->escapestring($_REQUEST['state'])."',univercity='".$obj->escapestring($_REQUEST['univercity'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',course_name='$course_name',intake='".$intake."',program_duration='".$obj->escapestring($_REQUEST['program_duration'])."',tuition_fee='".$obj->escapestring($_REQUEST['tuition_fee'])."',student_bachelors='".$obj->escapestring($_REQUEST['student_bachelors'])."',percentage='".$obj->escapestring($_REQUEST['percentage'])."',ielts='".$ielts."',pte='".$pte."',duolingo='".$duolingo."',tofel='".$tofel."',moi='".$obj->escapestring($_REQUEST['moi'])."',fees='".$obj->escapestring($_REQUEST['fees'])."',scholarship='".$obj->escapestring($_REQUEST['scholarship'])."',scholarship_percentage='".$obj->escapestring($_REQUEST['scholarship_percentage'])."',special_requirement='".$obj->escapestring($_REQUEST['special_requirement'])."',course_type='".$obj->escapestring($_REQUEST['course_type'])."'",-1); //die; 
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
$obj->query("update $tbl_programmes set country='".$obj->escapestring($_REQUEST['country'])."',program_level='".$obj->escapestring($_REQUEST['program_level'])."',state='".$obj->escapestring($_REQUEST['state'])."',univercity='".$obj->escapestring($_REQUEST['univercity'])."',stream='".$obj->escapestring($_REQUEST['stream'])."',course_name='".$obj->escapestring($_REQUEST['course_name'])."',intake='".$intake."',program_duration='".$obj->escapestring($_REQUEST['program_duration'])."',tuition_fee='".$obj->escapestring($_REQUEST['tuition_fee'])."',student_bachelors='".$obj->escapestring($_REQUEST['student_bachelors'])."',percentage='".$obj->escapestring($_REQUEST['percentage'])."',ielts='".$ielts."',pte='".$pte."',duolingo='".$duolingo."',tofel='".$tofel."',moi='".$obj->escapestring($_REQUEST['moi'])."',fees='".$obj->escapestring($_REQUEST['fees'])."',scholarship='".$obj->escapestring($_REQUEST['scholarship'])."',scholarship_percentage='".$obj->escapestring($_REQUEST['scholarship_percentage'])."',special_requirement='".$obj->escapestring($_REQUEST['special_requirement'])."',course_type='".$obj->escapestring($_REQUEST['course_type'])."' where id=".$_REQUEST['id'],-1);// die; 
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
if($_REQUEST['action']=='addlocationstate'){
	$sql = $obj->query("select * from $tbl_location_states where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
	$obj->query("insert into $tbl_location_states set country_id='".$obj->escapestring($_REQUEST['country_id'])."', name='".$obj->escapestring($_REQUEST['name'])."'",-1); //die;
	$_SESSION['sess_msg']='State added sucessfully';   
	echo 1; die;
	}
	$_SESSION['sess_msg_error']='This State Already Added Please Try Another';   
	echo 1; die;
}
if($_REQUEST['action']=='addcity'){
	$sql = $obj->query("select * from $tbl_location_cities where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
	$obj->query("insert into $tbl_location_cities set name='".$obj->escapestring($_REQUEST['name'])."',state_id='".$obj->escapestring($_REQUEST['state_id'])."'",-1); //die;
	$_SESSION['sess_msg']='City added sucessfully';   
	echo 1; die;
	}
	$_SESSION['sess_msg_error']='This City Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='updatecity'){
$obj->query("update $tbl_location_cities set state_id='".$obj->escapestring($_REQUEST['state_id'])."',name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='City updated sucessfully';   
echo 1; die;
}
if($_REQUEST['action']=='updatestate'){
$obj->query("update $tbl_state set country_id='".$obj->escapestring($_REQUEST['country_id'])."',state='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='State updated sucessfully';   
echo 1; die;
}
if($_REQUEST['action']=='updatelocationstate'){
$obj->query("update $tbl_location_states set country_id='".$obj->escapestring($_REQUEST['country_id'])."', name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='State updated sucessfully';   
echo 1; die;
}



if($_REQUEST['action']=='addStatusRemarks'){
	$sql = $obj->query("select * from $tbl_lead_remarks_status where stage_id='".$obj->escapestring($_REQUEST['stage_id'])."' and remarks='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->remarks == '') {
		$obj->query("insert into $tbl_lead_remarks_status set stage_id='".$obj->escapestring($_REQUEST['stage_id'])."',remarks='".$obj->escapestring($_REQUEST['name'])."'",-1); //die;
		$_SESSION['sess_msg']='Remarks added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Remarks Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='updateStatusRemarks'){
	$obj->query("update $tbl_lead_remarks_status set stage_id='".$obj->escapestring($_REQUEST['stage_id'])."',remarks='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Remarks updated sucessfully';   
	echo 1; die;
}



if($_REQUEST['action']=='addVisitStatusRemarks'){
	$sql = $obj->query("select * from $tbl_visit_remarks_status where stage_id='".$obj->escapestring($_REQUEST['stage_id'])."' and remarks='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->remarks == '') {
		$obj->query("insert into $tbl_visit_remarks_status set stage_id='".$obj->escapestring($_REQUEST['stage_id'])."',remarks='".$obj->escapestring($_REQUEST['name'])."'",-1); //die;
		$_SESSION['sess_msg']='Remarks added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Remarks Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='updateVisitStatusRemarks'){
	$obj->query("update $tbl_visit_remarks_status set stage_id='".$obj->escapestring($_REQUEST['stage_id'])."',remarks='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Remarks updated sucessfully';   
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
		$obj->query("insert into $tbl_institute set name='".$obj->escapestring($_REQUEST['name'])."',roll_no_1='".$obj->escapestring($_REQUEST['roll_no_1'])."',roll_no_2='".$obj->escapestring($_REQUEST['roll_no_2'])."'");
		$_SESSION['sess_msg']='Institute added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Institute already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateInstitute'){
	$obj->query("update $tbl_institute set name='".$obj->escapestring($_REQUEST['name'])."',roll_no_1='".$obj->escapestring($_REQUEST['roll_no_1'])."',roll_no_2='".$obj->escapestring($_REQUEST['roll_no_2'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
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
			$document .='<img src="'.SITE_URL.'uploads/'.$result ->name.'" alt="3" style="width: 100%;">';
			$document .='<p>'.$result ->name.' <a download  href="'.SITE_URL.'uploads/'.$result ->name.'"><i class="fa fa-download"></i></a></p>';
		}else if($result->desiredExt=='docx' || $result->desiredExt=='doc'){
			$document .='<iframe src="https://docs.google.com/gview?url='.SITE_URL.'uploads/'.$result ->name.'&embedded=true">';
			$document .='</iframe>';
			$document .='<p>'.$result ->name.' <a  download href="https://docs.google.com/gview?url='.SITE_URL.'uploads/'.$result ->name.'"><i class="fa fa-download"></i></a></p>';
		}else if($result->desiredExt=='xlsx' || $result->desiredExt=='xls'){
			$document .='<iframe src="https://docs.google.com/gview?url='.SITE_URL.'uploads/'.$result ->name.'&embedded=true">';
			$document .='</iframe>';
			$document .='<p>'.$result ->name.' <a  download href="'.SITE_URL.'uploads/https://docs.google.com/gview?url='.SITE_URL.'uploads/'.$result ->name.'"><i class="fa fa-download"></i></a></p>';
		}else{
			$document .='<iframe src="'.SITE_URL.'uploads/'.$result ->name.'">';
			$document .='</iframe>';
			$document .='<p>'.$result ->name.' <a download  href="'.SITE_URL.'uploads/'.$result ->name.'"><i class="fa fa-download"></i></a></p>';
		}
	 }else if($type==2){
	 	$sql = $obj->query("select pimg from $tbl_student_diploma where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document .='<img src="'.SITE_URL.'uploads/'.$result ->pimg.'" alt="1" style="width: 100%;">';
		$document .='<p>'.$result ->pimg.'</p>';
	 }else if($type==3){
	 	$sql = $obj->query("select pimg from $tbl_student_experience where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document .='<img src="'.SITE_URL.'uploads/'.$result ->pimg.'" alt="2" style="width: 100%;">';
		$document .='<p>'.$result ->pimg.'</p>';
	 }	

	 echo $document;
}



if($_REQUEST['action']=='getDocumentEditView'){
	$type = $_REQUEST['type'];
	$document = "";
	if($type==1){
		$sql = $obj->query("select name,desiredExt from $tbl_student_document where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
		$dname = explode('.',$result->name);		
		$document = $dname[0];	
	 }else if($type==2){
	 	$sql = $obj->query("select pimg from $tbl_student_diploma where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document = $result->pimg;
	 }else if($type==3){
	 	$sql = $obj->query("select pimg from $tbl_student_experience where id=".$_REQUEST['id'],-1); //die; 
		$result = $obj->fetchNextObject($sql);
	 	$document = $result->pimg;
	 }	

	 echo $_REQUEST['id']."##".$type."##".$document;
}


if($_REQUEST['action']=='updatedocumentname'){
	$document_id = $_REQUEST['document_id'];
	$document_type = $_REQUEST['document_type'];
	$document_name = $_REQUEST['document_name'];
	
	if($document_type==1){
		$dext = getField('desiredExt',$tbl_student_document,$document_id);
		$dname = getField('name',$tbl_student_document,$document_id);
		$studentid = getField('student_no',$tbl_student,getField('stu_id',$tbl_student_document,$document_id));
		$document_name = $document_name."_".$studentid.".".$dext;
		rename('../uploads/'.$dname, '../uploads/'.$document_name);
		$obj->query("update $tbl_student_document set name='$document_name' where id='$document_id'",-1); //die; 
	}else if($document_type==2){
		$dext = getField('pimg',$tbl_student_diploma,$document_id);
		$ext = explode('.',$dext);
		$studentid = getField('student_no',$tbl_student,getField('sutdent_id',$tbl_student_diploma,$document_id));
		$document_name = $document_name."_".$studentid.".".$ext[1];
		rename('../uploads/'.$dext, '../uploads/'.$document_name);
		$obj->query("update $tbl_student_diploma set pimg='$document_name' where id='$document_id'",-1); //die; 
	}else if($document_type==3){
		$dext = getField('pimg',$tbl_student_experience,$document_id);
		$ext = explode('.',$dext);
		$studentid = getField('student_no',$tbl_student,getField('sutdent_id',$tbl_student_experience,$document_id));
		$document_name = $document_name."_".$studentid.".".$ext[1];
		rename('../uploads/'.$dext, '../uploads/'.$document_name);
		$obj->query("update $tbl_student_experience set pimg='$document_name' where id='$document_id'",-1); //die; 
	}
	
	echo 1; die;
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

if($_REQUEST['action']=='delDiploma'){
	$obj->query("delete from $tbl_student_diploma where id='".$obj->escapestring($_REQUEST['id'])."'"); 
	echo 1; die;
}

if($_REQUEST['action']=='delExperience'){
	$obj->query("delete from $tbl_student_experience where id='".$obj->escapestring($_REQUEST['id'])."'"); 
	echo 1; die;
}


if($_REQUEST['action']=='updatetimestamp'){
	$stu_id = $obj->escapestring($_REQUEST['id']);
	$tsql = $obj->query("select id from $tbl_student_updated_time where stu_id='".$obj->escapestring($_REQUEST['id'])."' and user_id='".$_SESSION['sess_admin_id']."'",-1); //die;
	$timestamp = date("Y-m-d H:i:s");
	if($obj->numRows($tsql)>0){
		$obj->query("update $tbl_student_updated_time set cdate='$timestamp' where stu_id='".$obj->escapestring($_REQUEST['id'])."' and user_id='".$_SESSION['sess_admin_id']."'",-1); //die; 
	}else{
		$obj->query("insert into $tbl_student_updated_time set user_id='".$_SESSION['sess_admin_id']."',stu_id='".$obj->escapestring($_REQUEST['id'])."',level_id='".$_SESSION['level_id']."'"); 
	}
	$val = "Last Update on: ".date('d-M-Y',strtotime($timestamp))." ".date('h:i A',strtotime($timestamp));

	echo $val; die;
	

}



if($_REQUEST['action']=='addDownloadCategory'){
	$sql = $obj->query("select * from $tbl_download_category where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_download_category set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Category added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Category already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateDownlaodCategory'){
	$obj->query("update $tbl_download_category set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Category updated sucessfully';   
	echo 1; die;
}
if($_REQUEST['action']=='addDownloadSubCategory'){
	$sql = $obj->query("select * from $tbl_download_subcategory where name='".$obj->escapestring($_REQUEST['name'])."' and category_id='".$obj->escapestring($_REQUEST['cid'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_download_subcategory set category_id='".$obj->escapestring($_REQUEST['cid'])."', name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Subcategory added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Subcategory already added please try another.';   
	echo 1; die;
}

if($_REQUEST['action']=='updateDownlaodSubCategory'){
	$obj->query("update $tbl_download_subcategory set name='".$obj->escapestring($_REQUEST['name'])."', category_id='".$obj->escapestring($_REQUEST['cid'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='SubCategory updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='addslotagent'){
	$sql = $obj->query("select * from $tbl_slot_agent where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_slot_agent set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Slot Agent added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Slot Agent already added please try another.';   
	echo 1; die;
}
if($_REQUEST['action']=='adddepartment'){
	$sql = $obj->query("select * from $tbl_department where name='".$obj->escapestring($_REQUEST['name'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->name == '') {
		$obj->query("insert into $tbl_department set name='".$obj->escapestring($_REQUEST['name'])."'");
		$_SESSION['sess_msg']='Department added sucessfully';   
		echo 1; die;
	}
	$_SESSION['sess_msg_error']='This Department already added please try another.';   
	echo 1; die;
}
if($_REQUEST['action']=='updatedepartment'){
	$obj->query("update $tbl_department set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Department updated sucessfully';   
	echo 1; die;
}
if($_REQUEST['action']=='updateslotagent'){
	$obj->query("update $tbl_slot_agent set name='".$obj->escapestring($_REQUEST['name'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Slot Agent updated sucessfully';   
	echo 1; die;
}

if($_REQUEST['action']=='add_visa_sub_type'){
	$sql = $obj->query("select * from $tbl_visa_sub_type where visa_sub_type='".$obj->escapestring($_REQUEST['visa_sub_type'])."'",-1);//die();
	$total=$obj->fetchNextObject($sql);
	if ($total->state == '') {
	$obj->query("insert into $tbl_visa_sub_type set country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_type='".$obj->escapestring($_REQUEST['visa_type'])."',visa_sub_type='".$obj->escapestring($_REQUEST['visa_sub_type'])."',student_show='".$_REQUEST['student_show']."',enrollment_count='".$_REQUEST['enrollment_count']."',type='".$_REQUEST['type']."',registration_percentage='".$_REQUEST['registration_percentage']."'",-1); //die;
	$_SESSION['sess_msg']='Visa Sub Type added sucessfully';   
	echo 1; die;
	}
	$_SESSION['sess_msg_error']='This State Already Added Please Try Another';   
	echo 1; die;
}


if($_REQUEST['action']=='update_visa_sub_type'){
$obj->query("update $tbl_visa_sub_type set  country_id='".$obj->escapestring($_REQUEST['country_id'])."',visa_type='".$obj->escapestring($_REQUEST['visa_type'])."',visa_sub_type='".$obj->escapestring($_REQUEST['visa_sub_type'])."',student_show='".$_REQUEST['student_show']."',enrollment_count='".$_REQUEST['enrollment_count']."',type='".$_REQUEST['type']."',registration_percentage='".$_REQUEST['registration_percentage']."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Visa Sub Type updated sucessfully';   
echo 1; die;
}


if($_REQUEST['action']=='addvideo'){
	   if($_FILES['img']['tmp_name'])
  {
      $path[0] = $_FILES['img']['tmp_name'];
      $file = pathinfo($_FILES['img']['name']);
      $fileType = $file["extension"];
      $desiredExt='jpg';
      $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
      move_uploaded_file($_FILES['img']['tmp_name'],"../uploads/".$fileNameNew);
    }else{
    	$fileNameNew=$obj->escapestring($_REQUEST['old_image']);
    } 

	$obj->query("insert into $tbl_videos set img='$fileNameNew', video='".$obj->escapestring($_REQUEST['video'])."'",-1); //die;
	$_SESSION['sess_msg']='Video added sucessfully'; 
	echo 1; die;
}

if($_REQUEST['action']=='updatevideo'){



	   if($_FILES['img']['tmp_name'])
  {
      $path[0] = $_FILES['img']['tmp_name'];
      $file = pathinfo($_FILES['img']['name']);
      $fileType = $file["extension"];
      $desiredExt='jpg';
      $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
      move_uploaded_file($_FILES['img']['tmp_name'],"../uploads/".$fileNameNew);
    }else{
    	$fileNameNew=$obj->escapestring($_REQUEST['old_image']);
    } 

	$obj->query("update $tbl_videos set img='$fileNameNew', video='".$obj->escapestring($_REQUEST['video'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
	$_SESSION['sess_msg']='Videotate updated sucessfully';   
	echo 1; die;
}


if ($_REQUEST['action'] == 'addEvent') {
    	$obj->query("insert into $tbl_event set title='".$obj->escapestring($_REQUEST['title'])."',description='".$obj->escapestring($_REQUEST['description'])."',event_date='".$obj->escapestring($_REQUEST['event_date'])."',event_time='".$obj->escapestring($_REQUEST['event_time'])."',link='".$obj->escapestring($_REQUEST['link'])."',link_label='".$obj->escapestring($_REQUEST['link_label'])."'");
	$_SESSION['sess_msg']='Event added sucessfully';   
	echo 1; die;
}


if($_REQUEST['action']=='updateEvent'){


//    if($_FILES['img']['tmp_name'])
//   {
//       $path[0] = $_FILES['img']['tmp_name'];
//       $file = pathinfo($_FILES['img']['name']);
//       $fileType = $file["extension"];
//       $desiredExt='jpg';
//       $fileNameNew = rand(333, 999) . time() . ".$desiredExt";
//       move_uploaded_file($_FILES['img']['tmp_name'],"../uploads/event/".$fileNameNew);
//     }else{
//     	$fileNameNew=$obj->escapestring($_REQUEST['old_image']);
//     } 


$obj->query("update $tbl_event set title='".$obj->escapestring($_REQUEST['title'])."',description='".$obj->escapestring($_REQUEST['description'])."',event_date='".$obj->escapestring($_REQUEST['event_date'])."',event_time='".$obj->escapestring($_REQUEST['event_time'])."',link='".$obj->escapestring($_REQUEST['link'])."',link_label='".$obj->escapestring($_REQUEST['link_label'])."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
$_SESSION['sess_msg']='Event updated sucessfully';   
echo 1; die;
}

if($_REQUEST['action']=='addUpdateNotification'){
$obj->query("insert into tbl_update_notification set date='".$obj->escapestring($_REQUEST['date'])."',country_id='".$obj->escapestring($_REQUEST['country_id'])."',subject='".$obj->escapestring($_REQUEST['subject'])."',user_id='".$_SESSION['sess_admin_id']."',body='".$obj->escapestring($_REQUEST['body'])."'",-1); //die;
$_SESSION['sess_msg']='Updates & Notification added sucessfully';   
echo 1; die;
}
if($_REQUEST['action']=='updateUpdateNotification'){
$obj->query("UPDATE tbl_update_notification set date='".$obj->escapestring($_REQUEST['date'])."',country_id='".$obj->escapestring($_REQUEST['country_id'])."',subject='".$obj->escapestring($_REQUEST['subject'])."',user_id='".$_SESSION['sess_admin_id']."',body='".$obj->escapestring($_REQUEST['body'])."' WHERE id='{$_REQUEST['id']}'",-1); //die;
$_SESSION['sess_msg']='Updates & Notification updated sucessfully';   
echo 1; die;
}

?>