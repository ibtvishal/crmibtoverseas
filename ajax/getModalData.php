<?php 
include('../include/config.php');
include("../include/functions.php");


if($_REQUEST['type']=='getCountry'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_country where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='getCategory'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_category where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='getCategory1'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_policy_category where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='getSubCategory'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from tbl_subcategory where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->category_id."##".$result->name;
}

if($_REQUEST['type']=='getSubCategory1'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_policy_subcategory where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->category_id."##".$result->name;
}

if($_REQUEST['type']=='getLeadStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_lead_status where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}


if($_REQUEST['type']=='getVisitStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_visit_status where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}


if($_REQUEST['type']=='getQuestion'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_question where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->cat_id."##".$result->question."##".$result->answer."##".$result->subcat_id;
}

if($_REQUEST['type']=='getQuestion1'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_policy_question where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->cat_id."##".$result->question."##".$result->answer."##".$result->subcat_id;
}



if($_REQUEST['type']=='getQualification'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_qualification where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}
if($_REQUEST['type']=='getManageGap'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_manage_gap where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}
 
if($_REQUEST['type']=='getBranch'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_branch where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name."##".$result->address."##".$result->phone."##".$result->email."##".$result->gst."##".$result->branch_code."##".$result->billing_name."##".$result->approval_members."##".$result->state."##".$result->state_code."##".$result->user_roles."##".$result->users;
}


if($_REQUEST['type']=='getStage'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_stage where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->stage."##".$result->cstatus."##".$result->visa_id."##".$result->user_roles;
}

if($_REQUEST['type']=='getCountryStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_country_status where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->cstatus;
}

if($_REQUEST['type']=='getPortalStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_portal_status where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->cstatus;
}

if($_REQUEST['type']=='getUser'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_admin where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->branch_id."##".$result->level_id."##".$result->name."##".$result->username."##".$result->email."##".$result->phone."##".$result->password."##".$result->additional_role."##".$result->account_manager."##".$result->reapply_counsellor."##".$result->director;
}
if($_REQUEST['type']=='getSupportUser'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_support_user where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->branch_id."##".$result->level_id."##".$result->name."##".$result->email."##".$result->phone."##".$result->designation;
}


if($_REQUEST['type']=='getApplication'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_student_application where id='$id'");
	$result = $obj->fetchNextObject($sql);
	$uniData=""; $courseData="";

	$uniData = "<option value='$result->college_name'>" . (getField('name', 'tbl_univercity', $result->college_name) != '' 
	? getField('name', 'tbl_univercity', $result->college_name) 
	: $result->college_name) . "</option>";
	$uniData .= '<option value="">Select University</option>';
	$unisql = $obj->query("select univercity from $tbl_programmes where state='".$result->location."' group by univercity order by univercity asc",-1);
	while($uniline=$obj->fetchNextObject($unisql)){
		$uniData .='<option value="'.$uniline->univercity.'"'; 
		if($result->college_name==$uniline->univercity){
			$uniData .='selected'; 
		}
		$uniData .='>'.getField('name',$tbl_univercity,$uniline->univercity);
		$uniData .='</option>';
	}

	$courseData='<option value="'.$result->course.'">'.$result->course.'</option>';
	$courseData.='<option value="">Select Course</option>';
	$coursesql = $obj->query("select course_name from $tbl_programmes where univercity='".$result->college_name."' group by course_name order by course_name asc",-1);
	while($courseLine=$obj->fetchNextObject($coursesql)){
		$courseData .='<option value="'.$courseLine->course_name.'"';
		if($result->course==$courseLine->course_name){
			$courseData .='selected'; 
		}
		$courseData .='>'.$courseLine->course_name;
		$courseData .='</option>';
	}
	$locationData = '';
	$locationData = '<option value="'.$result->location.'" selected>'.(getField('state','tbl_state',$result->location) ?: $result->location).'</option>
                  <option value="">Select Location</option>';
	$coursesql = $obj->query("select state from $tbl_programmes where country='".$_REQUEST['country']."' group by state order by state asc",-1);
	while($courseLine=$obj->fetchNextObject($coursesql)){
		$locationData .='<option value="'.$courseLine->state.'"';
		$locationData .='>'.getField('state',$tbl_state,$courseLine->state);
		$locationData .='</option>';
	}
	$locationData .= ' <option value="other">Other</option>';
	// $location = getField('state','tbl_state',$result->location)  != '' ? getField('state','tbl_state',$result->location) : $result->location;
	echo $result->id."##".$uniData."##".$locationData."##".$courseData."##".$result->month."##".$result->year."##".$result->status."##".trim($result->portal_status)."##".$result->remarks."##".$result->portal_id."##".$result->application_fee;
}


if($_REQUEST['type']=='getApplicationOldStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select status,remarks from $tbl_student_application where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->status."##".$result->remarks;
}

if($_REQUEST['type']=='getApplicationPass'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_student_application where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->university_id."##".$result->university_pass;
}


if($_REQUEST['type']=='getStatus'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_student_status where id='$id'");
	$result = $obj->fetchNextObject($sql);

	$sql1 = $obj->query("select cstatus from $tbl_stage where id='".$result->stage_id."'");
	$result1 = $obj->fetchNextObject($sql1);
	$states=explode(",", $result1->cstatus);
	$cstatus='';
	foreach($states as $item){ 
		$cstatus .='<option value="'.trim($item).'"';
		if($result->cstatus==trim($item)){
			$cstatus .='selected';
		}
		$cstatus .=' >'.trim($item).'</option>';
	}


	echo $result->id."##".$result->stage_id."##".$cstatus."##".$result->remarks."##".$result->cstatus."##".$result->university."##".$result->status_branch."##".$result->from_date."##".$result->to_date."##".$result->commission_status;
}

if($_REQUEST['type']=='getNotes'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_student_notes where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->stage_id."##".$result->subject."##".$result->remarks;
}
if($_REQUEST['type']=='updateProgrammes'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_programmes where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country."##".$result->state."##".$result->univercity."##".$result->program_level."##".$result->stream."##".$result->course_name."##".$result->intake."##".$result->program_duration."##".$result->tuition_fee."##".$result->student_bachelors."##".$result->percentage."##".$result->ielts."##".$result->pte."##".$result->duolingo."##".$result->tofel."##".$result->moi."##".$result->fees."##".$result->scholarship."##".$result->scholarship_percentage."##".$result->special_requirement."##".$result->course_type;
}

if($_REQUEST['type']=='getStageStatus'){
	$value = '<option value="">Select Status</option>';
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_stage where id='$id'");
	$result = $obj->fetchNextObject($sql);
	 $states=explode(",", $result->cstatus);
	foreach($states as $item){ $value .='<option value="'.trim($item).'">'.trim($item).'</option>';}
	echo $value;
}

if($_REQUEST['type']=='getstate'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_state where id='$id' and status =1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->state;
}
if($_REQUEST['type']=='getcity'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_location_cities where id='$id' and status =1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->state_id."##".$result->name;
}
if($_REQUEST['type']=='getlocationstate'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_location_states where id='$id' and status =1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name."##".$result->country_id;
}

if($_REQUEST['type']=='getStatusRemarks'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_lead_remarks_status where id='$id' and status=1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->stage_id."##".$result->remarks;
}

if($_REQUEST['type']=='getVisitStatusRemarks'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_visit_remarks_status where id='$id' and status =1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->stage_id."##".$result->remarks;
}


if($_REQUEST['action']=='getpasport'){
	$key = $_REQUEST['key'];
	$sql = $obj->query("select * from $tbl_student where passport_no='$key'");
	$result = $obj->numRows($sql);
	echo $result;
}

if($_REQUEST['action']=='get_portal_status'){
	$c_id = $_REQUEST['c_id'];
	$mdata = '<option value="">Portal Status</option>';
	$ssql = $obj->query("select * from $tbl_country_status where status=1 and country_id='".$c_id."'",-1);//die();
	while($sResult = $obj->fetchNextObject($ssql)){
	$intakeArr = explode(",",$sResult->cstatus);
		foreach($intakeArr as $vint){
			$mdata .= '<option value="'.trim($vint).'">'.trim($vint).'</option>';
		}  
	}
	echo $mdata;
}

if($_REQUEST['action']=='get_portal_remarks'){
	$portal_status = $_REQUEST['portal_status'];
	$stu_id = $_REQUEST['stu_id'];
	$university_id = $_REQUEST['university_id'];
	$sql = $obj->query("select * from $tbl_student_notes where stu_id='$stu_id' and univercity_id='$university_id' and portal_status='$portal_status'",-1); //die;
	$result = $obj->numRows($sql);
	echo $result;
}

if($_REQUEST['action']=='get_status_stage'){
	$key = $_REQUEST['key'];
	$stu_id = $_REQUEST['stu_id'];
	$sql = $obj->query("select * from $tbl_student_status where stage_id='$key' and stu_id='$stu_id'");
	$result = $obj->numRows($sql);
	echo $result;
}

if($_REQUEST['action']=='get_status_note'){
	$key = $_REQUEST['key'];
	$stu_id = $_REQUEST['stu_id'];
	$sql = $obj->query("select * from $tbl_student_notes where univercity_id='$key' and stu_id='$stu_id'");
	$result = $obj->numRows($sql);
	echo $result;
}

if($_REQUEST['type']=='getUnivercity'){
	$key = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_univercity where id='$key'",-1);
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->name."##".$result->state_id."##".$result->video_url."##".$result->video_title."##".$result->fee;
}

if($_REQUEST['type']=='getUnivercityvideo'){
	$key = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_univercity_application_video where id='$key'",-1);
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->university_id."##".$result->video_url."##".$result->video_title;
}

if($_REQUEST['type']=='getCourse'){
	$key = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_course where id='$key'",-1);
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->state_id."##".$result->university_id."##".$result->name;
}


if($_REQUEST['type']=='getStudentCourse'){
	$key = $_REQUEST['id'];
	$data='';
	$sql = $obj->query("select preferred_course from $tbl_gap where status=1 group by name",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.trim($result->preferred_course).'" >'.$result->preferred_course.'</option>';
	}
	echo $data;
}


if($_REQUEST['type']=='getstateforuniversity'){
	$id = $_REQUEST['country_id'];
	$data='';
	$sql = $obj->query("select state,id from $tbl_state where country_id='$id' and status=1 group by state",-1);
	$data.=' <option value="" >Select State</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->state.'</option>';
	};
	
	echo $data;
	 
}

if($_REQUEST['type']=='getstatedrop'){
	$id = $_REQUEST['country_id'];
	$data='';
	$sql = $obj->query("select state from $tbl_programmes where country='$id' group by state",-1);
	$data.=' <option value="" >Select State</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->state.'" >'.getField('state',$tbl_state,$result->state).'</option>';
	};
	
	echo $data;
	 
}

if($_REQUEST['type']=='getUniversitydrop'){
	$key = $_REQUEST['state_id'];
	$data='';
	$sql = $obj->query("select univercity from $tbl_programmes where state='$key' group by univercity",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->univercity.'" >'.getField('name',$tbl_univercity,$result->univercity).'</option>';
	};
	
	echo $data;
}

if($_REQUEST['type']=='getUniversity'){
	$state_id=$_REQUEST['state_id'];
	$sql=$obj->query("select * from $tbl_univercity where state_id='$state_id' and status=1 order by name asc",$debug=-1);
	$data="";
	$data.='<option value="">--Select University--</option>';
	while($row1=$obj->fetchNextObject($sql)){
		$data.='<option value="'.$row1->id.'">'.$row1->name.'</option>';
	} 
	echo $data ;  
}


if($_REQUEST['type']=='getSearchstatedrop'){
	$country_id=$_REQUEST['country_id'];
	$whr='';
	$whr1='';
	if($country_id!=''){
		$whr = "and country_id='$country_id'";
		$whr1 = "and country='$country_id'";
	}
	$sql=$obj->query("select * from $tbl_state where status=1 $whr",$debug=-1);
	$data="";
	$data1="";
	$data2="";
	$data3="";

	
	$data.='<option value="">--Select State--</option>';
	while($row=$obj->fetchNextObject($sql)){
		$data.='<option value="'.$row->id.'">'.$row->state.'</option>';
	}

	$sql1=$obj->query("select percentage from $tbl_programmes where status=1 $whr1 GROUP BY percentage",$debug=-1);
	$data1.='<option value="">Percentage</option>';
	// while($row1=$obj->fetchNextObject($sql1)){
	// 	$data1.='<option value="'.$row1->percentage.'">'.$row1->percentage.'</option>';
	// }
	$data1.='<option value="41-50">41-50</option>';
	$data1.='<option value="51-60">51-60</option>';
	$data1.='<option value="61-70">61-70</option>';
	$data1.='<option value="70-100">70-100</option>';

	$sql2=$obj->query("select intake from $tbl_programmes where status=1 $whr1 GROUP BY intake",$debug=-1);
	$data2.='<option value="">Intake</option>';
	while($row2=$obj->fetchNextObject($sql2)){
		$intakeArr = explode(",",$row2->intake);		
		foreach($intakeArr as $aval){
			$intarr[] = trim($obj->escapestring($aval));
		}
	}


	$intarr = array_unique($intarr);
	if(count($intarr)>1){
		foreach($intarr as $vint){
			$data2.='<option value="'.trim($vint).'">'.trim($vint).'</option>';
		}
	}


		

	$sql3=$obj->query("select student_bachelors from $tbl_programmes where status=1 $whr1 GROUP BY student_bachelors",$debug=-1);
	$data3.='<option value="">Bachelor’s Duration</option>';
	while($row3=$obj->fetchNextObject($sql3)){
		$data3.='<option value="'.trim($row3->student_bachelors).'">'.$row3->student_bachelors.'</option>';
	}


	$sql4=$obj->query("select * from $tbl_univercity where status=1 $whr",$debug=-1);
	$data4.='<option value="">--Select University--</option>';
	while($row4=$obj->fetchNextObject($sql4)){
		$data4.='<option value="'.$row4->id.'">'.$row4->name.'</option>';
	}

	echo $data."##".$data1."##".$data2."##".$data3."##".$data4;  
}




if($_REQUEST['type']=='getcourseprogramme'){
	$key = $_REQUEST['univercity'];
	$data='';
	$sql = $obj->query("select name from $tbl_course where university_id='$key' group by name order by name",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.trim($result->name).'" >'.$result->name.'</option>';
	};
	echo $data; 
}


if($_REQUEST['type']=='getunivercitydrop'){
	$key = $_REQUEST['state_id'];
	$data='';
	$sql = $obj->query("select $tbl_programmes.univercity as univercity from $tbl_programmes inner join $tbl_univercity on $tbl_univercity.id = $tbl_programmes.univercity where $tbl_programmes.state='$key' and $tbl_univercity.status=1 group by $tbl_programmes.univercity order by $tbl_programmes.univercity",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.trim($result->univercity).'" >'.getField('name',$tbl_univercity,$result->univercity).'</option>';
	};
	
	echo $data; 
}

if($_REQUEST['type']=='getcoursedrop'){
	$key = $_REQUEST['univercity'];
	$data='';
	$sql = $obj->query("select course_name from $tbl_programmes where univercity='$key' group by course_name order by course_name",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->course_name.'" >'.$result->course_name.'</option>';
	}

		$data.=' <option value="other" >Other</option>';
	echo $data; 
}

if($_REQUEST['type']=='getunivercitydropprogram'){
	$state_id=$_REQUEST['state_id'];
	$country_id=$_REQUEST['country_id'];
	$data='';
	$sql = $obj->query("select univercity from $tbl_programmes where country='$country_id' and state='$state_id' group by univercity order by univercity",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->univercity.'" >'.getField('name',$tbl_univercity,$result->univercity).'</option>';
	};

	echo $data; 
}


if($_REQUEST['type']=='getunivercityprogramme'){
	$key = $_REQUEST['state_id'];
	$data='';
	$sql = $obj->query("select id,name from $tbl_univercity where state_id='$key' and status=1 group by name order by name",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	
	echo $data; 
}


if($_REQUEST['type']=='getcoursedropprogram'){
	$key = $_REQUEST['univercity'];
	$data='';
	$sql = $obj->query("select course_name from $tbl_programmes where univercity='$key' group by course_name order by course_name",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->course_name.'" >'.$result->course_name.'</option>';
	};
	echo $data;  
}

if($_REQUEST['type']=='updategap'){
	$key = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_gap where id='$key'",-1);
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->qualification."##".$result->stream."##".$result->gap."##".$result->preferred_course."##".$result->diploma."##".$result->duration."##".$result->exp_duration."##".$result->designation;
}

if($_REQUEST['action']=='getdays'){
	$start_date = $_REQUEST['start_date'];
	$end_date = $_REQUEST['end_date'];

	print_r(CalculateOrderTime ($start_date, $end_date));
}


if($_REQUEST['action']=='get_state_id'){
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select * from $tbl_univercity where state_id='$key' order by name asc",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	
	echo $data;
}

if($_REQUEST['type']=='getUCRState'){
	$id = $_REQUEST['id'];
	$data='';
	$sql = $obj->query("select state from $tbl_programmes where country='$id' group by state order by state asc",-1);
	$data.=' <option value="" >Select State</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->state.'" >'.getField('state',$tbl_state,$result->state).'</option>';
	};
	
	echo $data;
}

if($_REQUEST['action']=='get_UCR_state_id'){
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select univercity from $tbl_programmes where state='$key' group by univercity order by univercity",-1);
	$data.=' <option value="" >Select University</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->univercity.'" >'.getField('name',$tbl_univercity,$result->univercity).'</option>';
	};
	
	$data.=' <option value="other">Other</option>';
	echo $data;
}


if($_REQUEST['action']=='get_UCR_course_id'){
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select course_name from $tbl_programmes where univercity='$key' group by course_name order by course_name",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->course_name.'" >'.$result->course_name.'</option>';
	};
	$data.=' <option value="other">Other</option>';
	echo $data;
}

if($_REQUEST['action']=='get_course_id'){
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select * from $tbl_course where university_id='$key' order by name asc",-1);
	$data.=' <option value="" >Select Course</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	echo $data;
}

if($_REQUEST['type']=='getState'){
	$id = $_REQUEST['id'];
	$data='';
	if($id == 7){
		$state = 'Country';
	}else{
		$state = 'State';
	}
	$sql = $obj->query("select * from $tbl_state where country_id='$id' group by state order by state asc",-1);
	$data.=' <option value="" >Select '.$state.'</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->state.'</option>';
	};
	
	echo $data;
}

if($_REQUEST['type']=='getMCity'){
	$id = $_REQUEST['id'];
	$data='';
	$sql = $obj->query("select * from $tbl_location_cities where state_id='$id' and status=1 order by name asc",-1);
	$data.=' <option value="" >Select District</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	$data.=' <option value="1000" >Other</option>';
	echo $data;
}

if($_REQUEST['type']=='getLeadState'){
	$id = $_REQUEST['id'];
	$data='';
	$sql = $obj->query("select * from $tbl_location_states where country_id='$id' and status=1 group by name order by name asc",-1);
	$data.=' <option value="" >Select State</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	// $data.=' <option value="1000" >Other</option>';
	echo $data;
}
if($_REQUEST['type']=='getLeadCity'){
	$id = $_REQUEST['id'];
	$data='';
	$sql = $obj->query("select * from $tbl_location_cities where state_id='$id' and status=1 group by name order by name asc",-1);
	$data.=' <option value="" >Select District</option>';
	while ($result = $obj->fetchNextObject($sql)) {
		$data.=' <option value="'.$result->id.'" >'.$result->name.'</option>';
	};
	// $data.=' <option value="1000" >Other</option>';
	echo $data;
}



if($_REQUEST['action']=='get_stage_id'){
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select * from $tbl_stage where country_id='$key' and status=1",-1);
	$data.=' <option value="" >Select Stage</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->stage.'</option>';
	};
	
	echo $data;
}

if($_REQUEST['action']=='get_cstage_id'){
	$country_id = $_REQUEST['country_id'];
	$key = $_REQUEST['key'];
	$data='';
	$sql = $obj->query("select * from $tbl_stage where country_id='$country_id' and visa_id='$key' and status=1",-1);
	$data.=' <option value="" >Select Stage</option>';
	while ($result = $obj->fetchNextObject($sql)) {
	$data.=' <option value="'.$result->id.'" >'.$result->stage.'</option>';
	};
	
	echo $data;
}


if($_REQUEST['type']=='addDiploma'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_diploma where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='addCompany'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_company where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='addDesignation'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_designation where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}

if($_REQUEST['type']=='addInstitute'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_institute where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name."##".$result->roll_no_1."##".$result->roll_no_2;
}


if($_REQUEST['action']=='getAcffManagerList'){
	$whr='';
	$idArr = $_REQUEST['id'];
	$i=1;
	foreach($idArr as $val){
		if($i==1){
			$whr .=" and FIND_IN_SET($val, branch_id)";
		}else{
			$whr .=" or FIND_IN_SET($val, branch_id)";
		}
		$i++;
	}
	$amdata = '<option value="">Account Manager</option>';
	$cldata = '<option value="">Counsellor</option>';
	$fmdata = '<option value="">Filling Manager</option>';
	$fedata = '<option value="">Filling Executive</option>';
	$ssql = $obj->query("select * from $tbl_admin where status=1 and level_id=3 $whr",-1); //die();
	while($sResult = $obj->fetchNextObject($ssql)){
			$amdata .= '<option value="'.$sResult->id.'">'.$sResult->name.'</option>';
	}

	$csql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whr",-1); //die();
	while($cResult = $obj->fetchNextObject($csql)){
			$cldata .= '<option value="'.$cResult->id.'">'.$cResult->name.'</option>';
	}

	$ssql = $obj->query("select * from $tbl_admin where status=1 and level_id=7 $whr",-1); //die();
	while($sResult = $obj->fetchNextObject($ssql)){
			$fmdata .= '<option value="'.$sResult->id.'">'.$sResult->name.'</option>';
	}

	$ssql = $obj->query("select * from $tbl_admin where status=1 and level_id=8 $whr",-1); //die();
	while($sResult = $obj->fetchNextObject($ssql)){
			$fedata .= '<option value="'.$sResult->id.'">'.$sResult->name.'</option>';
	}
	echo $amdata."##".$cldata."##".$fmdata."##".$fedata;
}


if($_REQUEST['action']=='getTransferUserList'){
	$whr='';
	$id = $_REQUEST['id'];
	$user_type = $_REQUEST['user_type'];
	$amdata = '<option value="">Shift From</option>';
	$mdata = '<option value="">Shift To</option>';
	$ssql = $obj->query("select * from $tbl_admin where status=1 and level_id='$user_type' and FIND_IN_SET($id, branch_id)",-1); //die();
	while($sResult = $obj->fetchNextObject($ssql)){
			$amdata .= '<option value="'.$sResult->id.'">'.$sResult->name.'</option>';
	}
	$msql = $obj->query("select * from $tbl_admin where status=1 and level_id='$user_type' $whr",-1); //die();
	while($mResult = $obj->fetchNextObject($msql)){
			$mdata .= '<option value="'.$mResult->id.'">'.$mResult->name.'</option>';
	}

	echo $amdata."##".$mdata;
}

if($_REQUEST['type']=='changeDisplayOrder'){
	$obj->query("update $tbl_country set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}


if($_REQUEST['type']=='changeLeadStausDisplay'){
	$obj->query("update $tbl_lead_status set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}



if($_REQUEST['type']=='getLeadRemarks'){
	$whr='';
	$id = $_REQUEST['id'];
	$mdata = '<option value="">Remarks</option>';
	$sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='$id'",-1); //die();

	while($sResult = $obj->fetchNextObject($sSql)){
			$mdata .= '<option value="'.$sResult->id.'">'.$sResult->remarks.'</option>';
	}	
	echo $mdata;
}

if($_REQUEST['type']=='getVisitRemarks'){
	$whr='';
	$id = $_REQUEST['id'];
	$mdata = '<option value="">Remarks</option>';
	$sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='$id'",-1); //die();

	while($sResult = $obj->fetchNextObject($sSql)){
			$mdata .= '<option value="'.$sResult->id.'">'.$sResult->remarks.'</option>';
	}	
	echo $mdata;
}

if($_REQUEST['type']=='changeVisitStausDisplay'){
	$obj->query("update $tbl_visit_status set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}


if($_REQUEST['type']=='getCounseller'){
	$whr='';
	$brand_id = $_REQUEST['id'];

	$mdata = '<option value="">Select Counseller</option>';
	$csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id=4 AND  FIND_IN_SET ($brand_id,branch_id)",-1);
	while($cresult=$obj->fetchNextObject($csql)){
		$mdata .= '<option value="'.$cresult->id.'">'.$cresult->name." (".$cresult->email.")".'</option>';
 	} 
	
	echo $mdata;
}

if($_REQUEST['type']=='checkLeadContactNumber'){
	$mobile = $_REQUEST['mobile'];
	if(isset($_REQUEST['id'])){
		$sql = $obj->query("select id from $tbl_lead where id!='".$_REQUEST['id']."' and applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	}else{
		$sql = $obj->query("select id from $tbl_lead where applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	}

	$sql2 = $obj->query("select id from $tbl_visit where applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	$resultNum2 = $obj->numRows($sql2);
	$sql1 = $obj->query("select id from $tbl_student where student_contact_no='$mobile' or alternate_contact='$mobile'",-1);
	$resultNum1 = $obj->numRows($sql1);
	$resultNum = $obj->numRows($sql);
	if($resultNum>0){
		echo 1; die;
	}
	elseif($resultNum1>0){
		echo 1; die;
	}
	elseif($resultNum2>0){
		echo 1; die;
	}else{
		echo 2; die;
	}
}

if($_REQUEST['type']=='checkEnquiryContactNumber'){
	$mobile = $_REQUEST['mobile'];
	if(isset($_REQUEST['id'])){
		$sql = $obj->query("select id from tbl_lead_enquiry where id!='".$_REQUEST['id']."' and applicant_contact_no='$mobile'",-1);
	}else{
		$sql = $obj->query("select id from tbl_lead_enquiry where applicant_contact_no='$mobile'",-1);
	}

	$sql3 = $obj->query("select id from $tbl_lead where applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	$resultNum3 = $obj->numRows($sql3);
	$sql2 = $obj->query("select id from $tbl_visit where applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	$resultNum2 = $obj->numRows($sql2);
	$sql1 = $obj->query("select id from $tbl_student where student_contact_no='$mobile' or alternate_contact='$mobile'",-1);
	$resultNum1 = $obj->numRows($sql1);
	$resultNum = $obj->numRows($sql);
	if($resultNum>0){
		echo 1; die;
	}
	elseif($resultNum1>0){
		echo 1; die;
	}
	elseif($resultNum3>0){
		echo 1; die;
	}
	elseif($resultNum2>0){
		echo 1; die;
	}else{
		echo 2; die;
	}
}

if($_REQUEST['type']=='checkContactNumber'){
	$mobile = $_REQUEST['mobile'];
	$sql = $obj->query("select id from $tbl_visit where applicant_contact_no='$mobile' OR applicant_alternate_no='$mobile'",-1);
	$resultNum = $obj->numRows($sql);
	$sql1 = $obj->query("select id from $tbl_student where student_contact_no='$mobile' or alternate_contact='$mobile'",-1);
	$resultNum1 = $obj->numRows($sql1);
	if($resultNum>0){
		echo 1; die;
	}
	elseif($resultNum1>0){
		echo 1; die;
	}
	else{
		echo 2; die;
	}
}

if($_REQUEST['type']=='checkContactNumbers'){
	$mobile = $_REQUEST['mobile'];
	$sql = $obj->query("select id from $tbl_visit as a where a.id!='".$_REQUEST['id']."' and (a.applicant_contact_no='$mobile' OR a.applicant_alternate_no='$mobile')",-1);
	$resultNum = $obj->numRows($sql);
	$sql1 = $obj->query("select id from $tbl_student where student_contact_no='$mobile' or alternate_contact='$mobile'",-1);
	$resultNum1 = $obj->numRows($sql1);
	if($resultNum>0){
		echo 1; die;
	}
	elseif($resultNum1>0){
		echo 1; die;
	}
	else{
		echo 2; die;
	}
}

if($_REQUEST['type']=='changecatDisplayOrder'){
	$obj->query("update tbl_category set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}

if($_REQUEST['type']=='changecatDisplayOrder1'){
	$obj->query("update $tbl_policy_category set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}

if($_REQUEST['type']=='changesubDisplayOrder'){
	$obj->query("update tbl_subcategory set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}

if($_REQUEST['type']=='changesubDisplayOrder1'){
	$obj->query("update $tbl_policy_subcategory set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}

if($_REQUEST['type']=='changequestionDisplayOrder'){
	$obj->query("update tbl_question set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}
if($_REQUEST['type']=='changequestionDisplayOrder1'){
	$obj->query("update $tbl_policy_question set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}

if($_REQUEST['type']=='getdownloadCategory'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_download_category where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}
if($_REQUEST['type']=='getDownloadSubCategory'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_download_subcategory where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->category_id."##".$result->name;
}
if($_REQUEST['type']=='getIncentivePlan'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from tbl_incentive where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->body;
}
if($_REQUEST['type']=='getslotagent'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_slot_agent where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}
if($_REQUEST['type']=='getGoogleSheet'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from tbl_google_sheet where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name."##".$result->url;
}
if($_REQUEST['type']=='getUpdateNotifications'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from tbl_update_notification where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->date."##".$result->subject."##".$result->body."##".$result->country_id;
}
if($_REQUEST['type']=='getdepartment'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_department where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->name;
}
if($_REQUEST['type']=='get_visa_sub_type'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_visa_sub_type where id='$id'");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->country_id."##".$result->visa_type."##".$result->visa_sub_type."##".$result->student_show."##".$result->enrollment_count."##".$result->type."##".$result->registration_percentage;
}
if($_REQUEST['type']=='changefeeDisplayOrder'){
	$obj->query("update tbl_enrolled_fee set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['id']."'",-1);
	echo 1; die;
}


if($_REQUEST['type']=='getVideo'){
	$id = $_REQUEST['id'];
	$sql = $obj->query("select * from $tbl_videos where id='$id' and status =1");
	$result = $obj->fetchNextObject($sql);
	echo $result->id."##".$result->video."##".$result->img;
}
if ($_REQUEST['type'] == 'Events1') {
    $id = $_REQUEST['id'];
    $sql = $obj->query("SELECT * FROM $tbl_event WHERE id='$id'");
    $result = $obj->fetchNextObject($sql);

    echo $result->id . "##" . $result->title . "##" . $result->image . "##" . $result->description. "##" . $result->event_date. "##" . $result->event_time. "##" . $result->link. "##" . $result->link_label;
}

if($_REQUEST['type']=='getEnquiryRemarks'){
	$whr='';
	$id = $_REQUEST['id'];
	$mdata = '<option value="">Remarks</option>';
	$sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='$id'",-1); //die();

	while($sResult = $obj->fetchNextObject($sSql)){
			$mdata .= '<option value="'.$sResult->id.'">'.$sResult->remarks.'</option>';
	}	
	echo $mdata;
}
?>