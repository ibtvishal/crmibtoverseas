<?php 
include('include/config.php');
include("include/functions.php");
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
if(isset($_GET['meet'])){
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $obj->query("update $tbl_visit set management_member_status = 1 where id='$id'");
}
if($_REQUEST['userDetails']=='yes'){
    $sql='';
    // echo '<pre>';
    // print_r($_POST);die;
    $applicant_name=$obj->escapestring($_POST['applicant_name']);
    if($applicant_name!=''){
        $sql .= "applicant_name='$applicant_name'";
    }
    
    if(isset($_POST['branch_id'])){
    $branch_id=$obj->escapestring($_POST['branch_id']);
    if($branch_id!=''){
        $sql .= ",branch_id='$branch_id'";
        $obj->query("UPDATE $tbl_lead set branch_id='$branch_id' where (applicant_contact_no in ('{$_REQUEST['applicant_contact_no']}', '{$_REQUEST['applicant_alternate_no']}') or applicant_alternate_no in ('{$_REQUEST['applicant_contact_no']}', '{$_REQUEST['applicant_alternate_no']}'))");
    }
    }
    $telecaller_id=$obj->escapestring($_POST['telecaller_id']);
    if($telecaller_id!=''){
        $sql .= ",telecaller_id='$telecaller_id'";
    }
    $councellor_id=$_POST['councellor_id'];
    if($councellor_id!=''){
        $councellor = implode(',',$councellor_id);
        $sql .= ",councellor_id='$councellor'";
    }
    $father_name=$obj->escapestring($_POST['father_name']);
    if($father_name!=''){
        $sql .= ",father_name='$father_name'";
    }
    $dob=$obj->escapestring($_POST['dob']);
    if($dob!=''){
        $dob = date('Y-m-d',strtotime($dob));
        $sql .= ",dob='$dob'";
    }
    $marital_status=$obj->escapestring($_POST['marital_status']);
    if($marital_status!=''){
        $sql .= ",marital_status='$marital_status'";
    }
    $enquiry_type=$obj->escapestring($_POST['enquiry_type']);
    if($enquiry_type!=''){
         if($enquiry_type == 'Re-apply'){
                $sql .= ",reapply_status=1";
            }
        $sql .= ",enquiry_type='$enquiry_type'";
    }
    $applicant_contact_no=$obj->escapestring($_POST['applicant_contact_no']);
    if($applicant_contact_no!='' && $applicant_contact_no!=1000){
        $sql .= ",applicant_contact_no='$applicant_contact_no'";
    }

    
    $applicant_alternate_no=$obj->escapestring($_POST['applicant_alternate_no']);
    if($applicant_alternate_no!=''){
        $sql .= ",applicant_alternate_no='$applicant_alternate_no'";
    }
    
    $state_id=$obj->escapestring($_POST['state_id']);
    if($state_id!=''){
        $sql .= ",state_id='$state_id'";
    }
    $city_id=$obj->escapestring($_POST['city_id']);
    if($city_id!=1000){
        $sql .= ",city_id='$city_id'";
    }

    if(isset($_POST['visa_type']) && count($_POST['visa_type'])>0){
        $visa_type=implode(',',$_POST['visa_type']);
        if($visa_type!=''){
            $sql .= ",visa_type='$visa_type'";
        }
    }
    if(isset($_POST['refuesed_visa_type']) && count($_POST['refuesed_visa_type'])> 0){
        $refuesed_visa_type=implode(',',$_POST['refuesed_visa_type']);
        if($refuesed_visa_type!=''){
            $sql .= ",refuesed_visa_type='$refuesed_visa_type'";
        }
    }
    
    $refuesed_date=$obj->escapestring($_POST['refuesed_date']);
    if($refuesed_date!=''){
        $sql .= ",refuesed_date='$refuesed_date'";
    }
    
    $embassy=$obj->escapestring($_POST['embassy']);
    if($embassy!=''){
        $sql .= ",embassy='$embassy'";
    }
    $visa_outcome=$obj->escapestring($_POST['visa_outcome']);
    if($visa_outcome!=''){
        $sql .= ",visa_outcome='$visa_outcome'";
    }
    $address=$obj->escapestring($_POST['address']);
    if($address!=''){
        $sql .= ",address='$address'";
    }
    $visa_earlier=$obj->escapestring($_POST['visa_earlier']);
    if($visa_earlier!=''){
        $sql .= ",visa_earlier='$visa_earlier'";
    }
    $country_id=$obj->escapestring($_POST['country_id']);
    if($country_id!=''){
        $sql .= ",country_id='$country_id'";
    }
    $earlier_country_id=$obj->escapestring($_POST['earlier_country_id']);
    if($earlier_country_id!=''){
        $sql .= ",earlier_country_id='$earlier_country_id'";
    }

    $pre_country_id=$obj->escapestring($_POST['pre_country_id']);
    if($pre_country_id!=''){
        $sql .= ",pre_country_id='$pre_country_id'";
    }

    $pre_state_id=$obj->escapestring($_POST['pre_state_id']);
    if($pre_state_id!=''){
        $sql .= ",pre_state_id='$pre_state_id'";
    }
    $matri_board=$obj->escapestring($_POST['matri_board']);
    if($matri_board!=''){
        $sql .= ",matri_board='$matri_board'";
    }
    $matri_start_year=$obj->escapestring($_POST['matri_start_year']);
    if($matri_start_year!=''){
        $sql .= ",matri_start_year='$matri_start_year'";
    }
    $matri_finish_year=$obj->escapestring($_POST['matri_finish_year']);
    if($matri_finish_year!=''){
        $sql .= ",matri_finish_year='$matri_finish_year'";
    }
    $matri_percentage=$obj->escapestring($_POST['matri_percentage']);
    if($matri_percentage!=''){
        $sql .= ",matri_percentage='$matri_percentage'";
    }
    $matri_backlog=$obj->escapestring($_POST['matri_backlog']);
    if($matri_backlog!=''){
        $sql .= ",matri_backlog='$matri_backlog'";
    }

    $secondary_board=$obj->escapestring($_POST['secondary_board']);
    if($secondary_board!=''){
        $sql .= ",secondary_board='$secondary_board'";
    }
    $secondary_stream=$obj->escapestring($_POST['secondary_stream']);
    if($secondary_stream!=''){
        $sql .= ",secondary_stream='$secondary_stream'";
    }
    $secondary_start_year=$obj->escapestring($_POST['secondary_start_year']);
    if($secondary_start_year!=''){
        $sql .= ",secondary_start_year='$secondary_start_year'";
    }

    $secondary_finish_year=$obj->escapestring($_POST['secondary_finish_year']);
    if($secondary_finish_year!=''){
        $sql .= ",secondary_finish_year='$secondary_finish_year'";
    }
    $secondary_percentage=$obj->escapestring($_POST['secondary_percentage']);
    if($secondary_percentage!=''){
        $sql .= ",secondary_percentage='$secondary_percentage'";
    }
    $secondary_backlog=$obj->escapestring($_POST['secondary_backlog']);
    if($secondary_backlog!=''){
        $sql .= ",secondary_backlog='$secondary_backlog'";
    }
    $diploma_board=$obj->escapestring($_POST['diploma_board']);
    if($diploma_board!=''){
        $sql .= ",diploma_board='$diploma_board'";
    }
    $diploma_stream=$obj->escapestring($_POST['diploma_stream']);
    if($diploma_stream!=''){
        $sql .= ",diploma_stream='$diploma_stream'";
    }
    $diploma_start_year=$obj->escapestring($_POST['diploma_start_year']);
    if($diploma_start_year!=''){
        $sql .= ",diploma_start_year='$diploma_start_year'";
    }
    $diploma_finish_year=$obj->escapestring($_POST['diploma_finish_year']);
    if($diploma_finish_year!=''){
        $sql .= ",diploma_finish_year='$diploma_finish_year'";
    }
    $diploma_percentage=$obj->escapestring($_POST['diploma_percentage']);
    if($diploma_percentage!=''){
        $sql .= ",diploma_percentage='$diploma_percentage'";
    }

    $diploma_backlog=$obj->escapestring($_POST['diploma_backlog']);
    if($diploma_backlog!=''){
        $sql .= ",diploma_backlog='$diploma_backlog'";
    }
    $bachelor_board=$obj->escapestring($_POST['bachelor_board']);
    if($bachelor_board!=''){
        $sql .= ",bachelor_board='$bachelor_board'";
    }
    $bachelor_stream=$obj->escapestring($_POST['bachelor_stream']);
    if($bachelor_stream!=''){
        $sql .= ",bachelor_stream='$bachelor_stream'";
    }
    $bachelor_start_year=$obj->escapestring($_POST['bachelor_start_year']);
    if($bachelor_start_year!=''){
        $sql .= ",bachelor_start_year='$bachelor_start_year'";
    }
    $bachelor_finish_year=$obj->escapestring($_POST['bachelor_finish_year']);
    if($bachelor_finish_year!=''){
        $sql .= ",bachelor_finish_year='$bachelor_finish_year'";
    }
    $bachelor_percentage=$obj->escapestring($_POST['bachelor_percentage']);
    if($bachelor_percentage!=''){
        $sql .= ",bachelor_percentage='$bachelor_percentage'";
    }
    $bachelor_backlog=$obj->escapestring($_POST['bachelor_backlog']);
    if($bachelor_backlog!=''){
        $sql .= ",bachelor_backlog='$bachelor_backlog'";
    }

    $master_board=$obj->escapestring($_POST['master_board']);
    if($master_board!=''){
        $sql .= ",master_board='$master_board'";
    }
    $master_stream=$obj->escapestring($_POST['master_stream']);
    if($master_stream!=''){
        $sql .= ",master_stream='$master_stream'";
    }
    $master_start_year=$obj->escapestring($_POST['master_start_year']);
    if($master_start_year!=''){
        $sql .= ",master_start_year='$master_start_year'";
    }
    $master_finish_year=$obj->escapestring($_POST['master_finish_year']);
    if($master_finish_year!=''){
        $sql .= ",master_finish_year='$master_finish_year'";
    }
    $master_percentage=$obj->escapestring($_POST['master_percentage']);
    if($master_percentage!=''){
        $sql .= ",master_percentage='$master_percentage'";
    }
    $master_backlog=$obj->escapestring($_POST['master_backlog']);
    if($master_backlog!=''){
        $sql .= ",master_backlog='$master_backlog'";
    }
   
    $available_funds=$obj->escapestring($_POST['available_funds']);
    if($available_funds!=''){
        $sql .= ",available_funds='$available_funds'";
    }
    $source=$obj->escapestring($_POST['source']);
    if($source!=''){
        $sql .= ",source='$source'";
    }


    $inital_start_date=$obj->escapestring($_POST['inital_start_date']);
    if($inital_start_date!=''){
        $inital_start_date = date('Y-m-d',strtotime($inital_start_date));
        $sql .= ",inital_start_date='$inital_start_date'";
    }
    $inital_status=$obj->escapestring($_POST['inital_status']);
    if($inital_status!=''){
        $sql .= ",inital_status='$inital_status'";
    }else{
        // $sql .= ",inital_status=0";
    }
    $inital_remarks=$obj->escapestring($_POST['inital_remarks']);
    if($inital_remarks!=''){
        $sql .= ",inital_remarks='$inital_remarks'";
    }else{
        // $sql .= ",inital_remarks=0";
    }
    $inital_next_followup_date= $obj->escapestring($_POST['inital_next_followup_date']);
    if($inital_next_followup_date!=''){
        $inital_next_followup_date = date('Y-m-d',strtotime($inital_next_followup_date));
        $sql .= ",inital_next_followup_date='$inital_next_followup_date'";
    }
    
    $inital_additional_remarks=$obj->escapestring($_POST['inital_additional_remarks']);
    if($inital_additional_remarks!=''){
        $sql .= ",inital_additional_remarks='$inital_additional_remarks'";
    }
    
    $followup1_start_date=$obj->escapestring($_POST['followup1_start_date']);
    if($followup1_start_date!=''){
        $followup1_start_date = date('Y-m-d',strtotime($followup1_start_date));
        $sql .= ",followup1_start_date='$followup1_start_date'";
    }
    $followup1_status=$obj->escapestring($_POST['followup1_status']);
    if($followup1_status!=''){
        $sql .= ",followup1_status='$followup1_status'";
    }
    $followup1_remarks=$obj->escapestring($_POST['followup1_remarks']);
    if($followup1_remarks!=''){
        $sql .= ",followup1_remarks='$followup1_remarks'";
    }
    $followup1_next_followup_date=$obj->escapestring($_POST['followup1_next_followup_date']);
    if($followup1_next_followup_date!=''){
        $followup1_next_followup_date = date('Y-m-d',strtotime($followup1_next_followup_date));
        $sql .= ",followup1_next_followup_date='$followup1_next_followup_date'";
    }

    $followup1_additional_remarks=$obj->escapestring($_POST['followup1_additional_remarks']);
    if($followup1_additional_remarks!=''){
        $sql .= ",followup1_additional_remarks='$followup1_additional_remarks'";
    }
    
    $followup2_start_date=$obj->escapestring($_POST['followup2_start_date']);
    if($followup2_start_date!=''){
        $followup2_start_date = date('Y-m-d',strtotime($followup2_start_date));
        $sql .= ",followup2_start_date='$followup2_start_date'";
    }
    
    $followup2_status=$obj->escapestring($_POST['followup2_status']);
    if($followup2_status!=''){
        $sql .= ",followup2_status='$followup2_status'";
    }
    $followup2_remarks=$obj->escapestring($_POST['followup2_remarks']);
    if($followup2_remarks!=''){
        $sql .= ",followup2_remarks='$followup2_remarks'";
    }
    $followup2_next_followup_date=$obj->escapestring($_POST['followup2_next_followup_date']);
    if($followup2_next_followup_date!=''){
        $followup2_next_followup_date = date('Y-m-d',strtotime($followup2_next_followup_date));
        $sql .= ",followup2_next_followup_date='$followup2_next_followup_date'";
    }
    $followup2_additional_remarks=$obj->escapestring($_POST['followup2_additional_remarks']);
    if($followup2_additional_remarks!=''){
        $sql .= ",followup2_additional_remarks='$followup2_additional_remarks'";
    }
    $followup3_start_date=$obj->escapestring($_POST['followup3_start_date']);
    if($followup3_start_date!=''){
        $followup3_start_date = date('Y-m-d',strtotime($followup3_start_date));
        $sql .= ",followup3_start_date='$followup3_start_date'";
    }
    $followup3_status=$obj->escapestring($_POST['followup3_status']);
    if($followup3_status!=''){
        $sql .= ",followup3_status='$followup3_status'";
    }
    $followup3_remarks=$obj->escapestring($_POST['followup3_remarks']);
    if($followup3_remarks!=''){
        
        $sql .= ",followup3_remarks='$followup3_remarks'";
    }
    $followup3_next_followup_date=$obj->escapestring($_POST['followup3_next_followup_date']);
    if($followup3_next_followup_date!=''){
        $followup3_next_followup_date = date('Y-m-d',strtotime($followup3_next_followup_date));
        $sql .= ",followup3_next_followup_date='$followup3_next_followup_date'";
    }
    $followup3_additional_remarks=$obj->escapestring($_POST['followup3_additional_remarks']);
    if($followup3_additional_remarks!=''){
        $sql .= ",followup3_additional_remarks='$followup3_additional_remarks'";
    }
    $last_followup_start_date=$obj->escapestring($_POST['last_followup_start_date']);
    if($last_followup_start_date!=''){
        $last_followup_start_date = date('Y-m-d',strtotime($last_followup_start_date));
        $sql .= ",last_followup_start_date='$last_followup_start_date'";
    }
    
    $last_followup_status=$obj->escapestring($_POST['last_followup_status']);
    if($last_followup_status!=''){
        $sql .= ",last_followup_status='$last_followup_status'";
    }
    $last_followup_remarks=$obj->escapestring($_POST['last_followup_remarks']);
    if($last_followup_remarks!=''){
        $sql .= ",last_followup_remarks='$last_followup_remarks'";
    }
    $last_followup_next_followup_date=$obj->escapestring($_POST['last_followup_next_followup_date']);
    if($last_followup_next_followup_date!=''){
        $last_followup_next_followup_date = date('Y-m-d',strtotime($last_followup_next_followup_date));
        $sql .= ",last_followup_next_followup_date='$last_followup_next_followup_date'";
    }
    $last_followup_additional_remarks=$obj->escapestring($_POST['last_followup_additional_remarks']);
    if($last_followup_additional_remarks!=''){
        $sql .= ",last_followup_additional_remarks='$last_followup_additional_remarks'";
    }
    $expected_enrollment_date=$obj->escapestring($_POST['expected_enrollment_date']);
    if($expected_enrollment_date!=''){
        $sql .= ",expected_enrollment_date='$expected_enrollment_date'";
    }


    $support_inital_start_date=$obj->escapestring($_POST['support_inital_start_date']);
    $support_inital_additional_remarks=$obj->escapestring($_POST['support_inital_additional_remarks']);
    $support_followup1_additional_remarks=$obj->escapestring($_POST['support_followup1_additional_remarks']);
    $support_followup2_additional_remarks=$obj->escapestring($_POST['support_followup2_additional_remarks']);
    $support_followup3_additional_remarks=$obj->escapestring($_POST['support_followup3_additional_remarks']);
    $support_last_followup_additional_remarks=$obj->escapestring($_POST['support_last_followup_additional_remarks']);
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_inital_additional_remarks!=''){
        $sql .= ",support_inital_start_date='$support_inital_start_date'";
    }
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_inital_additional_remarks!=''){
        $sql .= ",support_inital_additional_remarks='$support_inital_additional_remarks'";
    }
    $support_followup1_start_date=$obj->escapestring($_POST['support_followup1_start_date']);
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_followup1_additional_remarks!=''){
        $sql .= ",support_followup1_start_date='$support_followup1_start_date'";
    }
    $support_followup2_start_date=$obj->escapestring($_POST['support_followup2_start_date']);
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_followup2_additional_remarks!=''){
        $sql .= ",support_followup2_start_date='$support_followup2_start_date'";
    }
    $support_followup3_start_date=$obj->escapestring($_POST['support_followup3_start_date']);
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || in_array(4, $addtional_role)) && $support_followup3_additional_remarks!=''){
        $sql .= ",support_followup3_start_date='$support_followup3_start_date'";
    }
    $support_last_followup_start_date=$obj->escapestring($_POST['support_last_followup_start_date']);
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_last_followup_additional_remarks!=''){
        $sql .= ",support_last_followup_start_date='$support_last_followup_start_date'";
    }
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_followup1_additional_remarks!=''){
        $sql .= ",support_followup1_additional_remarks='$support_followup1_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_followup2_additional_remarks!=''){
        $sql .= ",support_followup2_additional_remarks='$support_followup2_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_followup3_additional_remarks!=''){
        $sql .= ",support_followup3_additional_remarks='$support_followup3_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role)) && $support_last_followup_additional_remarks!=''){
        $sql .= ",support_last_followup_additional_remarks='$support_last_followup_additional_remarks'";
    }
    $management_member=$obj->escapestring($_POST['management_member']);
    if($management_member!=''){
        $sql .= ",management_member='$management_member'";
        $sql .= ",management_member_status='0'";
        $sql .= ",management_member_date='".date('Y-m-d')."'";
    }
    
    $enquiry_date=$obj->escapestring($_POST['enquiry_date']);
    if($enquiry_date!=''){
        $sql .= ",cdate='$enquiry_date'";
    }
    $university_name=$obj->escapestring($_POST['university_name']);
    if($university_name!=''){
        $sql .= ",university_name='$university_name'";
    }
    $course_name=$obj->escapestring($_POST['course_name']);
    if($course_name!=''){
        $sql .= ",course_name='$course_name'";
    }
    $family_fund=$obj->escapestring($_POST['family_fund']);
    if($family_fund!=''){
        $sql .= ",family_fund='$family_fund'";
    }
    $schedule_date_time=$obj->escapestring($_POST['schedule_date_time']);
    if($schedule_date_time!=''){
        $sql .= ",schedule_date_time='$schedule_date_time'";
    }
    $special_remarks=$obj->escapestring($_POST['special_remarks']);
    if($special_remarks!=''){
        $sql .= ",special_remarks='$special_remarks'";
    }else{
        $sql .= ",special_remarks=null";
    }
    if($city_id==1000){
        $city_name=$obj->escapestring($_POST['city_name']);
        $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'",-1); //die;
        $city_id = $obj->lastInsertedId();
        $sql .= ",city_id='$city_id'";
    }
    $obj->query("update $tbl_visit set $sql where id='".$_REQUEST['id']."'",-1); //die;   
    $insert =  $obj->query("update $tbl_lead set status='0' where applicant_contact_no='$applicant_contact_no' or applicant_alternate_no='$applicant_contact_no' or applicant_contact_no = '$applicant_alternate_no' or applicant_alternate_no = '$applicant_alternate_no'",-1);

    $vid = $_REQUEST['id'];
    $educationResult = $_POST['education'];
    $empDetailsResult = $_POST['empDetails'];
    $uniRecommendedResult = $_POST['uniRecommended'];
    $courseRecommended = $_POST['courseRecommended'];
    $langDetailsResult = $_POST['langDetails'];
    $examSectionResult = $_POST['exam_section'];
    if ($educationResult!='') {
        if(count($educationResult)>0){
            $sql="delete from $tbl_visit_education where visit_id='".$vid."'"; 
            $obj->query($sql);
            foreach($educationResult as $val){
                $obj->query("insert into $tbl_visit_education set visit_id='$vid', master_board='".$val['master_board']."',master_stream='".$val['master_stream']."',master_start_year='".$val['master_start_year']."',master_finish_year='".$val['master_finish_year']."',master_percentage='".$val['master_percentage']."',master_backlog='".$val['master_backlog']."'",-1);//die;
            }
        }
    }

    if ($empDetailsResult!='') {
        if(count($empDetailsResult)>0){
            $sql="delete from $tbl_visit_employee_details where visit_id='".$vid."'"; 
            $obj->query($sql);
            foreach($empDetailsResult as $val){
                $obj->query("insert into `tbl_visit_employee_details` SET `visit_id`='$vid',`company_name`='".$val['company_name']."',`designation`='".$val['designation']."',`start_date`='".$val['start_date']."',`end_date`='".$val['end_date']."',`last_salary`='".$val['last_salary']."'",-1);//die;
            }
        }
    }

    if ($uniRecommendedResult!='') {
        if(count($uniRecommendedResult)>0){
            $sql="delete from $tbl_visit_university_recommended where visit_id='".$vid."'"; 
            $obj->query($sql);
            foreach($uniRecommendedResult as $val){
                if($val['state_id'] !='' || $val['university_id'] != ''){
                $obj->query("insert into $tbl_visit_university_recommended set visit_id='$vid', state_id='".$val['state_id']."',university_id='".$val['university_id']."',course_id='".$val['course_id']."',intake='".$val['intake']."',year='".$val['year']."'",-1);//die;
                }
            }
        }
    }
    if ($courseRecommended!='') {
        if(count($courseRecommended)>0){
            $sqls="delete from $tbl_visit_course where visit_id='".$vid."'"; 
            $obj->query($sqls);
            foreach($courseRecommended as $val){
                if($val['course_name'] != ''){
                $obj->query("insert into $tbl_visit_course set visit_id='$vid', course_name='".$val['course_name']."'",-1);//die;
                }
            }
        }else{
            $sqls="delete from $tbl_visit_course where visit_id='".$vid."'"; 
            $obj->query($sqls);
        }
    }else{
        $sqls="delete from $tbl_visit_course where visit_id='".$vid."'"; 
        $obj->query($sqls);
    }

    if ($langDetailsResult!='') {
                if(count($langDetailsResult)>0){
                    $sql="delete from $tbl_visit_language_details where visit_id='".$vid."'"; 
                    $obj->query($sql);
                    foreach($langDetailsResult as $val){
                        $obj->query("insert into $tbl_visit_language_details set visit_id='$vid', exam_name='".$val['exam_name']."',lang_listening='".$val['lang_listening']."',lang_reading='".$val['lang_reading']."',lang_writing='".$val['lang_writing']."',lang_speaking='".$val['lang_speaking']."',scrore='".$val['scrore']."',exam_date='".$val['exam_date']."'",-1); //die;
                    }
                }
            }
            if ($examSectionResult!='') {
                if(count($examSectionResult)>0){
                    $sql="delete from $tbl_visit_exam_section where visit_id='".$vid."'"; 
                    $obj->query($sql);
                    foreach($examSectionResult as $val){
                        $esql='';
                        if($val['exam_name']!=''){
                            $esql .= ",exam_name='".$val['exam_name']."'";
                        }
                        if($val['value1']!=''){
                            $esql .= ",value1='".$val['value1']."'";
                        }
                        if($val['value2']!=''){
                            $esql .= ",value2='".$val['value2']."'";
                        }
                        if($val['value3']!=''){
                            $esql .= ",value3='".$val['value3']."'";
                        }
                        if($val['value4']!=''){
                            $esql .= ",value4='".$val['value4']."'";
                        }
                        if($val['scrore']!=''){
                            $esql .= ",scrore='".$val['scrore']."'";
                        }
                        $obj->query("insert into $tbl_visit_exam_section set visit_id='$vid' $esql",-1); //die;
                    }
                }
            }
    $_SESSION['sess_msg']='Thanks for allocating this enquiry to the counsellor';
    @header("location:visit-list.php");
}


if($_REQUEST['id']!=''){
    $telecaller_id=0;
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $sql = $obj->query("select * from $tbl_visit where id='$id'");
    $result = $obj->fetchNextObject($sql);
    $enq_id = 1000+$id;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style type="text/css">
    .support_manager_div {
        background: red !important;
        background: #edf1f5 !important;
        color: black !important;
        border: none !important;
    }

    .line-dotted {
        border-top: 1.5px solid #4b4b4d;
        margin-bottom: 20px;
    }

    .removecls {
        position: absolute;
        top: 3px;
        right: 0px;
        font-size: 20px;
    }


    .removeuniclss {
        position: absolute;
        top: 3px;
        right: -12px;
        font-size: 20px;
    }

    .removemastercls {
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 20px;
    }

    .removeeducatoncls {
        position: absolute;
        top: 52px;
        right: 15px;
        font-size: 20px;
    }

    .counsller_visit {
        background: green;
        padding: 9px 12px;
        border-radius: 3px;
        color: white;
        text-transform: uppercase;
        text-align: center !important;
    }

    .removelangcls {
        position: absolute;
        top: 50px;
        right: 248px;
        font-size: 20px;
    }

    .add-section-removeeducaton {
        position: absolute;
        top: -241px;
        right: 13px;
    }

    @media (max-width: 992px) {
        .text-center-in-mobile-tab {
            text-align: center;
        }
    }

    @media (min-width: 541px) {
        .display-flex {
            display: flex;
        }

        .display-flex .boxing {
            width: 50%;
        }

        .display-flex .boxing1 {
            width: 50%;
            margin-left: 10px;
        }
    }

    @media (max-width: 541px) {
        .display-flex .boxing {
            width: 100%;
        }
    }

    .label-required label.error {
        position: absolute !important;
        bottom: -56px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 480px !important;
    }

    @media (max-width: 992px) {
        .label-required label.error {
            position: absolute !important;
            bottom: -280px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 0 !important;
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    </style>
</head>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container">
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">
                        <?php
                    if($_REQUEST['id']!=''){?>
                        Edit Visit
                        <?php }else{?>
                        Add Visit
                        <?php }?>

                    </h4>
                    <form method="post" action="" name="visitfrm" id="visitfrm" enctype=multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <?php
                        if($_SESSION['level_id'] == 1 || in_array(1,$addtional_role)){
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Branch</span></div>
                                        <select name="branch_id" id="branch_id" onchange="change_counsellor(this.value)"
                                            class="required form-control">
                                            <option value="">Select Branch</option>
                                            <?php
                                            $csql=$obj->query("select * from $tbl_branch where 1=1 and status=1 group by name",-1);
                                            while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?=$cresult->id == $result->branch_id ? 'selected' : ''?>>
                                                <?php echo $cresult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Management
                                                Member</span></div>
                                        <select name="management_member" id="management_member" class="form-control">
                                            <option value="">Select Management Member</option>
                                            <?php
                                            $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id in (1,19) and id not in (1,182,218,113) and branch_id and FIND_IN_SET(".$result->branch_id.", branch_id) and management_member = 1",-1);
                                            while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?=$cresult->id == $result->management_member ? 'selected' : ''?>>
                                                <?php echo $cresult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Enquiry ID
                                                &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Enquiry ID"
                                            name="enquiry_id" id="enquiry_id" value="<?php echo $result->enquiry_id; ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if($result->cdate!=''){ 
                                    $cdate = date('Y-m-d H:i:s',strtotime($result->cdate));
                             }else{
                                $cdate = date('Y-m-d H:i:s');
                              }
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Enquiry
                                                Date&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="text" class="required form-control" id="datetime_enquiry"
                                            name="enquiry_date" id="enquiry_date" value="<?php echo $cdate ?>">



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp;
                                            <span>CRM Executive&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;
                                                &nbsp;</span>
                                        </div>

                                        <?php
                                        $get_tel = $obj->query("select * from $tbl_lead where applicant_contact_no in ('".$result->applicant_contact_no."','".$result->applicant_alternate_no."') or applicant_alternate_no in ('".$result->applicant_contact_no."','".$result->applicant_alternate_no."')");
                                            $res_get_tel = $obj->fetchNextObject($get_tel);
                                        ?>
                                        <select name="telecaller_id" id="telecaller_id" class="form-control"
                                            <?php if($res_get_tel->crm_executive_id!='' || $_SESSION['level_id']==4) {?>
                                            readonly <?php } ?>>
                                            <option value="">Select Telecaller</option>
                                            <?php
                                            
                                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?php if($result->telecaller_id==$clResult->id || $res_get_tel->crm_executive_id==$clResult->id){?>
                                                selected <?php } ?>>
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Councellor
                                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select name="councellor_id[]" id="councellor_id"
                                            class="required form-control select2" multiple
                                            <?php if($_SESSION['level_id']==4) {?> disabled <?php } ?>>
                                            <?php
                                            $coun = explode(',',$result->councellor_id);
                                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 and FIND_IN_SET($result->branch_id, branch_id) order by name");
                                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?php if(in_array($clResult->id,$coun)){?> selected <?php } ?>>
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Applicant Name
                                                &nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Applicant Name"
                                            name="applicant_name" id="applicant_name"
                                            value="<?php echo $result->applicant_name; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Father
                                                Name&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Father Name"
                                            name="father_name" id="father_name"
                                            value="<?php echo $result->father_name; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-calendar"
                                                    style="font-size:15px;"></i></span><span>&nbsp; &nbsp; Date Of Birth
                                                (mm/dd/yyyy)
                                                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="text" class="required form-control change-date"
                                            placeholder="Date Of Birth" name="dob" id="dob"
                                            value="<?php echo date('d/m/Y',strtotime($result->dob)); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"> <span><i class="fa-solid fa-people-group"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Marital Status
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="marital_status" id="marital_status">
                                            <option value="">Select Marital Status</option>
                                            <option value="1" <?php if($result->marital_status==1){?> selected
                                                <?php } ?>>Married</option>
                                            <option value="2" <?php if($result->marital_status==2){?> selected
                                                <?php } ?>>Unmarried</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-phone-volume"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Phone Number</span>
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Phone Number"
                                            name="applicant_contact_no" id="applicant_contact_no"
                                            value="<?php echo $result->applicant_contact_no; ?>" maxlength="10"
                                            <?=$_SESSION['level_id'] != 1 ? 'readonly' : ''?>>
                                        <span class="text-danger" id="err_applicant_contact_no"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-tty"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Alternate
                                                Number</span></div>
                                        <input type="text" class="form-control" placeholder="Alternate Number"
                                            name="applicant_alternate_no" id="applicant_alternate_no"
                                            value="<?php echo $result->applicant_alternate_no; ?>" maxlength="10"
                                            <?=$_SESSION['level_id'] != 1 ? 'readonly' : ''?>>
                                        <span class="text-danger" id="err_applicant_alternate_no"></span>
                                        <input type="checkbox" id="same_as_primary_number">
                                        <label for="same_as_primary_number" class="text-primary">Same as Primary
                                            Number</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-<?=$result->enquiry_type == 'Online' ? '3' : '6'?>"
                                id="enquiry_type_div">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-question-circle"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Enquiry Type</span>
                                        </div>
                                        <select name="enquiry_type" class="form-control form-select"
                                            onchange="change_schedule(this.value)">
                                            <option value="">Select Type</option>
                                            <option value="Online"
                                                <?php echo $result->enquiry_type == 'Online' ? 'selected' : ''  ?>>
                                                Online</option>
                                            <option value="Walkin"
                                                <?php echo $result->enquiry_type == 'Walkin' ? 'selected' : ''  ?>>
                                                Walkin</option>
                                            <option value="Old Walkin"
                                                <?php echo $result->enquiry_type == 'Old Walkin' ? 'selected' : ''  ?>>
                                                Old Walkin</option>
                                            <option value="Re-apply"
                                                <?php echo $result->enquiry_type == 'Re-apply' ? 'selected' : ''  ?>>
                                                Re-apply (Existing IBT Student)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3" id="schedule_date_time_div"
                                <?php if($result->enquiry_type != 'Online'){ echo 'style="display:none"'; }?>>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa fa-calendar"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Schedule</span>
                                        </div>
                                        <input type="datetime-local" style="width:83%;padding:4px"
                                            class="form-control <?php if($result->enquiry_type == 'Online' && $result->councellor_id == null){ echo 'required'; }?>"
                                            name="schedule_date_time" id="schedule_date_time"
                                            value="<?php echo $result->schedule_date_time; ?>"
                                            <?=$result->schedule_date_time != null ? 'disabled' : ''?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Address</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Address" name="address"
                                            id="address" value="<?php echo $result->address; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row " style="margin-bottom:10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon text-uppercase "><span><i
                                                    class="fa-solid fa-location-dot" style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon space-state"> Country</div>
                                        <select class="required form-control" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            <option value="1" <?=$result->country_id == '1' ? 'selected' : ''?>>India
                                            </option>
                                            <option value="2" <?=$result->country_id == '2' ? 'selected' : ''?>>UK
                                            </option>
                                            <option value="3" <?=$result->country_id == '3' ? 'selected' : ''?>>Canada
                                            </option>
                                            <option value="4" <?=$result->country_id == '4' ? 'selected' : ''?>>UAE
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-location-dot"
                                                    style="font-size:15px;"></i></span>
                                            &nbsp; <span>State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="state_id" id="mstate_id">
                                            <option value="">Select State</option>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_location_states where 1=1 and country_id='".$result->country_id."' and status=1 order by name",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($result->state_id==$line->id){?> selected <?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "> <span><i class="fa-solid fa-city"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>District</span>
                                        </div>
                                        <select class="required form-control" name="city_id" id="city_id">
                                            <option value="">Select District</option>
                                            <?php
                                            $i=1;
                                            $citysql=$obj->query("select * from $tbl_location_cities where 1=1 and status=1 and state_id='".$result->state_id."' order by name",$debug=-1);
                                            while($cityline=$obj->fetchNextObject($citysql)){?>
                                            <option value="<?php echo $cityline->id ?>"
                                                <?php if($result->city_id==$cityline->id){?> selected <?php } ?>>
                                                <?php echo $cityline->name ?></option>
                                            <?php } ?>
                                            <!-- <option value="1000">Other</option> -->
                                        </select>
                                    </div>
                                    <input type="text" name="city_name" id="city_name" value="" class="form-control"
                                        placeholder="Add Your District Here" style="display:none;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <div class="form-group">
                                    <div style="text-align: center; padding: 10px;">
                                        <a href="javascript:void(0);" class="counsller_visit" id="toggle"
                                            style="color:white">View Details </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="third" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "> <span><i class="fa-solid fa-globe"
                                                    style="font-size:15px;"></i></span>
                                            <span id="change_country">Preferred <?=$result->pre_country_id == 7 ? 'Area' : 'Country'?></span>
                                        </div>

                                        <select class="required form-control" name="pre_country_id" id="pre_country_id" onchange="change_country(this.value)">
                                            <option value="">Select Preferred <?=$result->pre_country_id == 7 ? 'Area' : 'Country'?></option>
                                            <?php
                                            $psql=$obj->query("select * from $tbl_country where 1=1 and status=1 group by name order by displayorder",-1);
                                            while($pResult=$obj->fetchNextObject($psql)){?>
                                            <option value="<?php echo $pResult->id ?>"
                                                <?php if($result->pre_country_id==$pResult->id){?> selected <?php } ?>>
                                                <?php echo $pResult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><i class="fa-solid fa-location-crosshairs"
                                                style="font-size:15px;"></i>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate" id="change_state">Preferred
                                            <?=$result->pre_country_id == 7 ? 'Country' : 'State'?></div>

                                        <select class="form-control" name="pre_state_id" id="pre_state_id">
                                            <option value="">Select  <?=$result->pre_country_id == 7 ? 'Country' : 'State'?></option>
                                            <?php
                                            if($result->pre_country_id!=''){
                                                $stateSql=$obj->query("select * from $tbl_state where 1=1 and status=1 and country_id='".$result->pre_country_id."' group by state",-1);
                                                while($stateResult=$obj->fetchNextObject($stateSql)){?>
                                            <option value="<?php echo $stateResult->id ?>"
                                                <?php if($result->pre_state_id==$stateResult->id){?> selected
                                                <?php } ?>><?php echo $stateResult->state; ?></option>
                                            <?php } 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <div class=""
                                        style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                        <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span>
                                        <Span> Visa type&nbsp;</Span>
                                    </div>

                                    <?php
                                $visaArr = array();
                                $visaArr = explode(',',$result->visa_type);
                                ?>

                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]" value="Study"
                                            id="flexCheckChecked" <?php if(in_array('Study',$visaArr)){?> checked
                                            <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Study
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]"
                                            value="Visitior/tourist" id="flexCheckCheckeds"
                                            <?php if(in_array('Visitior/tourist',$visaArr)){?> checked <?php } ?>
                                            onchange="change_matriculation(this.value)">
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Visitor/tourist
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]"
                                            value="Spouse" id="flexCheckChecked"
                                            <?php if(in_array('Spouse',$visaArr)){?> checked <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Spouse
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]" value="Work"
                                            id="flexCheckChecked" <?php if(in_array('Work',$visaArr)){?> checked
                                            <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Work
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]"
                                            value="Interview Preparation" id="visa_type_Interview"
                                            <?php if(in_array('Interview Preparation',$visaArr)){?> checked <?php } ?>
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>> &nbsp;
                                        <label for="visa_type_Interview" class="form-check-label"
                                            style="margin-top:8px;">
                                            Interview Preparation
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="visa_type[]"
                                            value="Filing Only" id="visa_type_filing"
                                            <?php if(in_array('Filing Only',$visaArr)){?> checked <?php } ?>
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>> &nbsp;
                                        <label for="visa_type_filing" class="form-check-label" style="margin-top:8px;">
                                            Filing Only
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group" style="display:flex;gap:1px;">
                                    <div class=""
                                        style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                        <span><i class="fa-solid fa-message" style="font-size:15px;"></i></span> <Span
                                            style="font-size:11px;"> Whether tried for Visa earlier</Span>
                                    </div>
                                    <input name="visa_earlier" class="form-check-input" type="radio" value="1"
                                        id="visa_earlier1" <?php if($result->visa_earlier==1){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        Yes
                                    </label>

                                    <input name="visa_earlier" class="form-check-input" type="radio" value="2"
                                        id="visa_earlier2" <?php if($result->visa_earlier==2){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        No
                                    </label>
                                </div>
                                <div class="col-md-2 earliercountry" <?php if($result->visa_earlier==1){?>
                                    style="display:block;" <?php }else{?> style="display:none;" <?php }?>>
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="earlier_country_id"
                                                id="earlier_country_id" style="width: 140px;"
                                                onchange="change_earlier_country_id(this.value)">
                                                <option value="">Select Country</option>
                                                <?php
                                            $ctsql=$obj->query("select * from $tbl_country where 1=1 and status=1 group by name order by displayorder",-1);
                                            while($ctresult=$obj->fetchNextObject($ctsql)){?>
                                                <option value="<?php echo $ctresult->id ?>"
                                                    <?php if($ctresult->id==$result->earlier_country_id){?>selected<?php } ?>>
                                                    <?php echo $ctresult->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row earliercountry" <?php if($result->visa_earlier==1){?> style="display:block;"
                                <?php }else{?> style="display:none;" <?php }?>>
                                <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <div class=""
                                        style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                        <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span>
                                        <Span> Previous Visa Type&nbsp;</Span>
                                    </div>

                                    <?php
                                $refuesed_visa_type = array();
                                if( $result->refuesed_visa_type!=''){
                                    $refuesed_visa_type = explode(',',$result->refuesed_visa_type);
                                }
                                
                                ?>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="refuesed_visa_type[]"
                                            value="Study" id="flexCheckChecked1"
                                            <?php if(in_array('Study',$refuesed_visa_type)) {?> checked <?php }?>
                                            onchange="change_university(this)">
                                        <label class="form-check-label" style="margin-top:8px;">
                                            Study
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="refuesed_visa_type[]"
                                            value="Visitior/tourist" id="flexCheckChecked"
                                            <?php if(in_array('Visitior/tourist',$refuesed_visa_type)) {?> checked
                                            <?php }?>> &nbsp;
                                        <label class="form-check-label" style="margin-top:8px;">
                                            Visitor/tourist
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="refuesed_visa_type[]"
                                            value="Spouse" id="flexCheckChecked2"
                                            <?php if(in_array('Spouse',$refuesed_visa_type)) {?> checked <?php }?>
                                            onchange="change_university1(this)">
                                        &nbsp;
                                        <label class="form-check-label" style="margin-top:8px;">
                                            Spouse
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="checkbox" name="refuesed_visa_type[]"
                                            value="Work" id="flexCheckChecked"
                                            <?php if(in_array('Work',$refuesed_visa_type)) {?> checked <?php }?>>
                                        &nbsp;
                                        <label class="form-check-label" style="margin-top:8px;">
                                            Work
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Previous Visa Outcome</div>
                                            <select class="form-control" name="visa_outcome" id="visa_outcome"
                                                onchange="change_refused(this.value)">
                                                <option value="">Select Previous Visa Outcome</option>
                                                <option value="Approved"
                                                    <?=$result->visa_outcome == 'Approved' ? 'selected' : ''?>>Approved
                                                </option>
                                                <option value="Refused"
                                                    <?=$result->visa_outcome == 'Refused' ? 'selected' : ''?>>Refused
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="refused_date_change">
                                                <?=isset($result->visa_outcome)  && $result->visa_outcome !='' ? $result->visa_outcome : 'Refused' ?>
                                                Date</div>
                                            <input type="month" class="form-control" id="refuesed_date"
                                                placeholder="Refused Date" name="refuesed_date"
                                                value="<?=$result->refuesed_date?>" style="width:65%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="embassy_show"
                                    <?=$result->earlier_country_id == 3 ? '' : ' style="display:none"'?>>
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Embassy/Consulate</div>
                                            <select class="form-control" name="embassy" id="embassy">
                                                <option value="">Select Embassy/Consulate</option>
                                                <option value="Delhi"
                                                    <?=$result->embassy == 'Delhi' ? 'selected' : ''?>>Delhi</option>
                                                <option value="Mumbai"
                                                    <?=$result->embassy == 'Mumbai' ? 'selected' : ''?>>Mumbai</option>
                                                <option value="Kolkata"
                                                    <?=$result->embassy == 'Kolkata' ? 'selected' : ''?>>Kolkata
                                                </option>
                                                <option value="Hyderabad"
                                                    <?=$result->embassy == 'Hyderabad' ? 'selected' : ''?>>Hyderabad
                                                </option>
                                                <option value="Chennai"
                                                    <?=$result->embassy == 'Chennai' ? 'selected' : ''?>>Chennai
                                                </option>
                                                <option value="Ahmedabad"
                                                    <?=$result->embassy == 'Ahmedabad' ? 'selected' : ''?>>Ahmedabad
                                                </option>
                                                <option value="Bengaluru"
                                                    <?=$result->embassy == 'Bengaluru' ? 'selected' : ''?>>Bengaluru
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="earlieruniversity"
                                    <?php if(in_array('Spouse',$refuesed_visa_type) && $result->earlier_country_id!=3){?>
                                    style="display:none;"
                                    <?php }elseif($result->visa_earlier==1 && (in_array('Study',$refuesed_visa_type) || in_array('Spouse',$refuesed_visa_type))){ ?>
                                    style="display:block;" <?php } else{?> style="display:none;" <?php }?>>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon" id="refused_date_change">
                                                    University/Collage</div>
                                                <input type="text" class="form-control" id="university_name"
                                                    placeholder="University Name" name="university_name"
                                                    value="<?=$result->university_name?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    Course Name</div>
                                                <input type="text" class="form-control" id="course_name"
                                                    placeholder="Course Name" name="course_name"
                                                    value="<?=$result->course_name?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row " style="margin-top:10px;">


                            </div>
                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 class="text-center-in-mobile-tab"
                                        style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Educational Details <a class="add_master_field_button button"
                                            style="cursor: pointer;color:white;float:right"> Add
                                            More</a></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <P
                                            style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Matriculation </P>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" id="matri_board_refresh">
                                        <div class="input-group" style="width:100%;">
                                            <select name="matri_board" id="matri_board"
                                                class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role) || in_array('Visitior/tourist',$visaArr)? '' : 'required'?> form-control"
                                                onchange="change_matric_board(this.value,'matri_board')">
                                                <option value="">Select Board</option>
                                                <?php
                                        $catSql = $obj->query("select * from tbl_board order by name asc");
                                        while($res = $obj->fetchNextObject($catSql)){
                                            ?>
                                                <option value="<?=$res->name?>"
                                                    <?php if($result->matri_board==$res->name){?> selected <?php }?>>
                                                    <?=$res->name?></option>
                                                <?php } ?>
                                                <!-- <option value="other" <?php if($result->matri_board=='other'){?>
                                                    selected <?php }?>>Other</option> -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control addpercentage" placeholder="Stream"
                                                name="stream" id="stream" value="General" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select
                                                class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role) || in_array('Visitior/tourist',$visaArr)? '' : 'required'?>  form-control"
                                                name="matri_start_year" id="matri_start_year"
                                                onchange="change_last_year(this.value, 'matri_finish_year')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->matri_start_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select
                                                class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role) || in_array('Visitior/tourist',$visaArr)? '' : 'required'?>  form-control"
                                                name="matri_finish_year" id="matri_finish_year">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->matri_finish_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text"
                                                class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role) || in_array('Visitior/tourist',$visaArr)? '' : 'required'?>  form-control addpercentage"
                                                placeholder="Percentage" name="matri_percentage" id="matri_percentage"
                                                value="<?php echo $result->matri_percentage; ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="matri_backlog" id="matri_backlog"
                                                value="<?php echo $result->matri_backlog; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p
                                            style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Sr. Secondary (If Passed)</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" id="secondary_board_refresh">
                                        <div class="input-group" style="width:100%;">
                                            <select name="secondary_board" id="secondary_board" class="form-control"
                                                onchange="change_matric_board(this.value,'secondary_board')">
                                                <option value="">Select Board</option>
                                                <?php
                                        $catSql = $obj->query("select * from tbl_board order by  name asc");
                                        while($res = $obj->fetchNextObject($catSql)){
                                            ?>
                                                <option value="<?=$res->name?>"
                                                    <?php if($result->secondary_board==$res->name){?> selected
                                                    <?php }?>><?=$res->name?></option>
                                                <?php } ?>
                                                <!-- <option value="other">Other</option> -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Steam"
                                                name="secondary_stream" id="secondary_stream"
                                                value="<?php echo $result->secondary_stream; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="secondary_start_year"
                                                id="secondary_start_year"
                                                onchange="change_last_year(this.value, 'secondary_finish_year')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->secondary_start_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="secondary_finish_year"
                                                id="secondary_finish_year">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->secondary_finish_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control addpercentage"
                                                placeholder="PERCENTAGE" name="secondary_percentage"
                                                id="secondary_percentage"
                                                value="<?php echo $result->secondary_percentage; ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="secondary_backlog" id="secondary_backlog"
                                                value="<?php echo $result->secondary_backlog; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p
                                            style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Any Diploma (If Passed)</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Institute/University"
                                                name="diploma_board" id="diploma_board"
                                                value="<?php echo $result->diploma_board; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Steam"
                                                name="diploma_stream" id="diploma_stream"
                                                value="<?php echo $result->diploma_stream; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="diploma_start_year"
                                                id="diploma_start_year"
                                                onchange="change_last_year(this.value, 'diploma_finish_year')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->diploma_start_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="diploma_finish_year"
                                                id="diploma_finish_year">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->diploma_finish_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control addpercentage"
                                                placeholder="PERCENTAGE" name="diploma_percentage"
                                                id="diploma_percentage"
                                                value="<?php echo $result->diploma_percentage; ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="diploma_backlog" id="diploma_backlog"
                                                value="<?php echo $result->diploma_backlog; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p
                                            style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Bachelor (If Passed)</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Institute/University"
                                                name="bachelor_board" id="bachelor_board"
                                                value="<?php echo $result->bachelor_board; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Steam"
                                                name="bachelor_stream" id="bachelor_stream"
                                                value="<?php echo $result->bachelor_stream; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="bachelor_start_year"
                                                id="bachelor_start_year"
                                                onchange="change_last_year(this.value, 'bachelor_finish_year')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->bachelor_start_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="bachelor_finish_year"
                                                id="bachelor_finish_year">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($result->bachelor_finish_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="PERCENTAGE"
                                                name="bachelor_percentage" id="bachelor_percentage"
                                                value="<?php echo $result->bachelor_percentage; ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="bachelor_backlog" id="bachelor_backlog"
                                                value="<?php echo $result->bachelor_backlog; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="masterDetails_add" style="position:relative">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <p
                                                style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                                Master (If Passed)</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control"
                                                    placeholder="Institute/University" name="master_board"
                                                    id="master_board" value="<?php echo $result->master_board; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control" placeholder="Steam"
                                                    name="master_stream" id="master_stream"
                                                    value="<?php echo $result->master_stream; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control" name="master_start_year"
                                                    id="master_start_year"
                                                    onchange="change_last_year(this.value, 'master_finish_year')">
                                                    <option value="">Start Year</option>
                                                    <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                    <option value="<?php echo $i; ?>"
                                                        <?php if($result->master_start_year==$i){?> selected <?php } ?>>
                                                        <?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control" name="master_finish_year"
                                                    id="master_finish_year">
                                                    <option value="">Finish Year</option>
                                                    <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                    <option value="<?php echo $i; ?>"
                                                        <?php if($result->master_finish_year==$i){?> selected
                                                        <?php } ?>><?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control addpercentage"
                                                    placeholder="PERCENTAGE" name="master_percentage"
                                                    id="master_percentage"
                                                    value="<?php echo $result->master_percentage; ?>"
                                                    onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control" placeholder="Any Backlog"
                                                    name="master_backlog" id="master_backlog"
                                                    value="<?php echo $result->master_backlog; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                        $edudet=0;
                        $edusql = $obj->query("select * from $tbl_visit_education where visit_id='$id'",-1); //die;
                        $edNum = $obj->numRows($edsql);
                        while($eduReslut = $obj->fetchNextObject($edsql)){?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <p
                                                style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                                Other</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control"
                                                    placeholder="Institute/University"
                                                    name="education[<?php echo $edudet; ?>][master_board]"
                                                    id="master_board" value="<?php echo $eduReslut->master_board; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control" placeholder="Steam"
                                                    name="education[<?php echo $edudet; ?>][master_stream]"
                                                    id="master_stream" value="<?php echo $eduReslut->master_stream; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control"
                                                    name="education[<?php echo $edudet; ?>][master_start_year]"
                                                    id="master_start_year"
                                                    onchange="change_last_year(this.value, 'master_finish_year_other')">
                                                    <option value="">Start Year</option>
                                                    <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                    <option value="<?php echo $i; ?>"
                                                        <?php if($eduReslut->master_start_year==$i){?> selected
                                                        <?php } ?>><?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control"
                                                    name="education[<?php echo $edudet; ?>][master_finish_year]"
                                                    id="master_finish_year_other">
                                                    <option value="">Finish Year</option>
                                                    <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                    <option value="<?php echo $i; ?>"
                                                        <?php if($eduReslut->master_finish_year==$i){?> selected
                                                        <?php } ?>><?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control addpercentage"
                                                    placeholder="PERCENTAGE"
                                                    name="education[<?php echo $edudet; ?>][master_percentage]"
                                                    id="master_percentage"
                                                    value="<?php echo $eduReslut->master_percentage; ?>"
                                                    onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-1">
                                        <div class="form-group" style="display:flex; gap:15px;">
                                            <div class="input-group" style="width:100%;">
                                                <input type="text" class="form-control" placeholder="Any Backlog"
                                                    name="master_backlog" id="master_backlog"
                                                    value="<?php echo $result->master_backlog; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="remove_field removeeducatoncls delete_btn">X</a>
                                </div>
                                <?php $edudet++; }?>

                            </div>


                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Language
                                        Proficiency Details</h6>
                                </div>
                            </div>
                            <div id="langDetails_add" style="position:relative">

                                <?php
                        $ld=0;
                        $ldsql = $obj->query("select * from $tbl_visit_language_details where visit_id='$id'",-1); //die;
                        $ldNum = $obj->numRows($ldsql);
                        while($ldResult = $obj->fetchNextObject($ldsql)){?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Exam Name</div>
                                                <select name="langDetails[<?php echo $ld; ?>][exam_name]"
                                                    id="exam_name<?php echo $ld; ?>" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="IELTS" <?php if($ldResult->exam_name=='IELTS'){?>
                                                        selected <?php } ?>>IELTS</option>
                                                    <option value="PTE" <?php if($ldResult->exam_name=='PTE'){?>
                                                        selected <?php } ?>>PTE</option>
                                                    <option value="TOEFL" <?php if($ldResult->exam_name=='TOEFL'){?>
                                                        selected <?php } ?>>TOEFL</option>
                                                    <option value="DUOLINGO"
                                                        <?php if($ldResult->exam_name=='DUOLINGO'){?> selected
                                                        <?php } ?>>DUOLINGO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Listening</div>
                                                <input type="text" class="form-control" placeholder="Listening"
                                                    name="langDetails[<?php echo $ld; ?>][lang_listening]"
                                                    id="lang_listening<?php echo $ld; ?>"
                                                    value="<?php echo $ldResult->lang_listening; ?>"
                                                    <?=$ldResult->exam_name=='DUOLINGO' ? 'readonly' : ''?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Reading</div>
                                                <input type="text" class="form-control" placeholder="Reading"
                                                    name="langDetails[<?php echo $ld; ?>][lang_reading]"
                                                    id="lang_reading<?php echo $ld; ?>"
                                                    value="<?php echo $ldResult->lang_reading; ?>"
                                                    <?=$ldResult->exam_name=='DUOLINGO' ? 'readonly' : ''?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Writing</div>
                                                <input type="text" class="form-control" placeholder="Writing"
                                                    name="langDetails[<?php echo $ld; ?>][lang_writing]"
                                                    id="lang_writing<?php echo $ld; ?>"
                                                    value="<?php echo $ldResult->lang_writing; ?>"
                                                    <?=$ldResult->exam_name=='DUOLINGO' ? 'readonly' : ''?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Speaking</div>
                                                <input type="text" class="form-control" placeholder="Speaking"
                                                    name="langDetails[<?php echo $ld; ?>][lang_speaking]"
                                                    id="lang_speaking<?php echo $ld; ?>"
                                                    value="<?php echo $ldResult->lang_speaking; ?>"
                                                    <?=$ldResult->exam_name=='DUOLINGO' ? 'readonly' : ''?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon" id="scorelabel<?php echo $ld; ?>">Overall
                                                    Bands</div>
                                                <input type="text" class="form-control" placeholder="Overall Bands"
                                                    id="score<?php echo $ld; ?>"
                                                    name="langDetails[<?php echo $ld; ?>][scrore]"
                                                    value="<?php echo $ldResult->scrore; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Exam Date</div>
                                                <input type="date" id="exam_date<?php echo $ld; ?>"
                                                    class="form-control change-date" placeholder="Reading"
                                                    name="langDetails[<?php echo $ld; ?>][exam_date]"
                                                    value="<?php echo $ldResult->exam_date; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                $("#exam_name<?php echo $ld; ?>").change(function() {
                                    examval = $(this).val();
                                    if (examval != '') {
                                        $("#exam_date<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                        $("#score<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                        $("#splang_speakingeakings<?php echo $ld; ?>").removeAttr("readonly",
                                            'readonly');
                                        $("#lang_writing<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                        $("#lang_reading<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                        $("#lang_listening<?php echo $ld; ?>").removeAttr("readonly",
                                            'readonly');
                                    } else {
                                        $("#exam_date<?php echo $ld; ?>").attr("readonly", 'readonly');
                                        $("#score<?php echo $ld; ?>").attr("readonly", 'readonly');
                                        $("#lang_speaking<?php echo $ld; ?>").attr("readonly", 'readonly');
                                        $("#lang_writing<?php echo $ld; ?>").attr("readonly", 'readonly');
                                        $("#lang_reading<?php echo $ld; ?>").attr("readonly", 'readonly');
                                        $("#lang_listening<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    }
                                    if (examval == 'IELTS') {
                                        $("#score<?php echo $ld; ?>").attr("placeholder", "Overall Bands");
                                        $("#scorelabel").html("Overall Bands");
                                    } else {
                                        $("#score<?php echo $ld; ?>").attr("placeholder", "Overall Score");
                                        $("#scorelabel<?php echo $ld; ?>").html("Overall Score");
                                    }
                                })
                                </script>
                                <?php $ld++; }?>
                                <div class="add-section">
                                    <a class="add_lang_field_button button" style="cursor: pointer;color:white"> Add
                                        More</a>
                                </div>
                            </div>




                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Other
                                        Exam (if appeared)
                                    </h6>
                                </div>
                            </div>
                            <div id="exam_section_add" style="position:relative">
                                <?php
                        $lds=0;
                        $ldsql = $obj->query("select * from $tbl_visit_exam_section where visit_id='$id'",-1); //die;
                        $ldNum = $obj->numRows($ldsql);
                        while($ldsResult = $obj->fetchNextObject($ldsql)){ ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Exam Name</div>
                                                <select name="exam_section[<?php echo $lds; ?>][exam_name]"
                                                    id="exam_section_exam_name<?php echo $lds; ?>" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="GRE" <?php if($ldsResult->exam_name=='GRE'){?>
                                                        selected <?php } ?>>GRE</option>
                                                    <option value="GMAT" <?php if($ldsResult->exam_name=='GMAT'){?>
                                                        selected <?php } ?>>GMAT</option>
                                                    <option value="SAT" <?php if($ldsResult->exam_name=='SAT'){?>
                                                        selected <?php } ?>>SAT</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon" id="value1_label<?php echo $lds; ?>">
                                                    <?=$ldsResult->exam_name == 'GRE' || $ldsResult->exam_name == 'GMAT' ? 'Analytical Reasoning' : 'Writing' ?>
                                                </div>
                                                <input type="number" class="form-control"
                                                    placeholder="<?=$ldsResult->exam_name == 'GRE' || $ldsResult->exam_name == 'GMAT' ? 'Analytical Reasoning' : 'Writing' ?>"
                                                    id="value1<?php echo $lds; ?>"
                                                    name="exam_section[<?php echo $lds; ?>][value1]"
                                                    value="<?=$ldsResult->value1?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon" id="value2_label<?php echo $lds; ?>">
                                                    <?php if($ldsResult->exam_name == 'GRE'){ echo 'Quantitative Reasoning'; }elseif($ldsResult->exam_name == 'GMAT'){ echo 'Integrated Reasoning'; }else{echo 'Critical Reading';} ?>
                                                </div>
                                                <input type="number" class="form-control"
                                                    placeholder="<?php if($ldsResult->exam_name == 'GRE'){ echo 'Quantitative Reasoning'; }elseif($ldsResult->exam_name == 'GMAT'){ echo 'Integrated Reasoning'; }else{echo 'Critical Reading';} ?>"
                                                    id="value2<?php echo $lds; ?>"
                                                    name="exam_section[<?php echo $lds; ?>][value2]"
                                                    value="<?=$ldsResult->value2?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon" id="value3_label<?php echo $lds; ?>">
                                                    <?php if($ldsResult->exam_name == 'GRE'){ echo 'Verbal Reasoning'; }elseif($ldsResult->exam_name == 'GMAT'){ echo 'Quantitative'; }else{ echo 'Mathematics ';} ?>
                                                </div>
                                                <input type="number" class="form-control"
                                                    placeholder="<?php if($ldsResult->exam_name == 'GRE'){ echo 'Verbal Reasoning'; }elseif($ldsResult->exam_name == 'GMAT'){ echo 'Quantitative'; }else{ echo 'Mathematics ';} ?>"
                                                    id="value3<?php echo $lds; ?>"
                                                    name="exam_section[<?php echo $lds; ?>][value3]"
                                                    value="<?=$ldsResult->value3?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon" id="value4_label<?php echo $lds; ?>">
                                                    Verbal
                                                </div>
                                                <input type="number" class="form-control" placeholder="Verbal"
                                                    id="value4<?php echo $lds; ?>"
                                                    name="exam_section[<?php echo $lds; ?>][value4]"
                                                    value="<?=$ldsResult->value4?>"
                                                    <?=$ldsResult->exam_name != 'GMAT' ? 'readonly' : ''?>>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon"
                                                    id="exam_section_score_label<?php echo $lds; ?>">Overall Score
                                                </div>
                                                <input type="number" class="form-control" placeholder="Overall Score"
                                                    id="exam_section_score<?php echo $lds; ?>"
                                                    name="exam_section[<?php echo $lds; ?>][scrore]"
                                                    value="<?=$ldsResult->scrore?>">
                                            </div>
                                        </div>
                                    </div>
                                    <a class="remove_field">x</a>
                                </div>
                                <script>
                                $("#exam_section_exam_name<?=$lds?>").change(function() {
                                    examval = $(this).val();
                                    if (examval != '') {
                                        $("#exam_section_score<?=$lds?>").removeAttr('readonly', 'readonly');
                                        $("#value1<?=$lds?>").removeAttr('readonly', 'readonly');
                                        $("#value2<?=$lds?>").removeAttr('readonly', 'readonly');
                                        $("#value3<?=$lds?>").removeAttr('readonly', 'readonly');
                                        $("#value4<?=$lds?>").removeAttr('readonly', 'readonly');

                                        $("#exam_section_score<?=$lds?>").addClass('required');
                                        if (examval == 'GRE') {
                                            $("#value1<?=$lds?>").addClass('required');
                                            $("#value2<?=$lds?>").addClass('required');
                                            $("#value3<?=$lds?>").addClass('required');

                                            $("#value1_label<?=$lds?>").html('Analytical Reasoning');
                                            $("#value2_label<?=$lds?>").html('Quantitative Reasoning');
                                            $("#value3_label<?=$lds?>").html('Verbal Reasoning');

                                            $("#value4<?=$lds?>").removeClass('required');
                                            $("#value4<?=$lds?>").attr('readonly', 'readonly');

                                            $("#value1<?=$lds?>").attr('placeholder', 'Analytical Reasoning');
                                            $("#value2<?=$lds?>").attr('placeholder', 'Quantitative Reasoning');
                                            $("#value3<?=$lds?>").attr('placeholder', 'Verbal Reasoning');

                                        } else if (examval == 'GMAT') {
                                            $("#value1<?=$lds?>").addClass('required');
                                            $("#value2<?=$lds?>").addClass('required');
                                            $("#value3<?=$lds?>").addClass('required');
                                            $("#value4<?=$lds?>").addClass('required');

                                            $("#value1_label<?=$lds?>").html('Analytical Reasoning');
                                            $("#value2_label<?=$lds?>").html('Integrated Reasoning');
                                            $("#value3_label<?=$lds?>").html('Quantitative');
                                            $("#value4_label<?=$lds?>").html('Verbal');

                                            $("#value1<?=$lds?>").attr('placeholder', 'Analytical Reasoning');
                                            $("#value2<?=$lds?>").attr('placeholder', 'Integrated Reasoning');
                                            $("#value3<?=$lds?>").attr('placeholder', 'Quantitative');

                                            $("#value4<?=$lds?>").addClass('required');

                                            $("#value4<?=$lds?>").removeAttr('readonly');
                                        } else if (examval == 'SAT') {
                                            $("#value1<?=$lds?>").addClass('required');
                                            $("#value2<?=$lds?>").addClass('required');
                                            $("#value3<?=$lds?>").addClass('required');

                                            $("#value1_label<?=$lds?>").html('Writing');
                                            $("#value2_label<?=$lds?>").html('Critical Reading');
                                            $("#value3_label<?=$lds?>").html('Mathematics ');

                                            $("#value4<?=$lds?>").removeClass('required');
                                            $("#value4<?=$lds?>").attr('readonly', 'readonly');

                                            $("#value1<?=$lds?>").attr('placeholder', 'Writing');
                                            $("#value2<?=$lds?>").attr('placeholder', 'Critical Reading');
                                            $("#value3<?=$lds?>").attr('placeholder', 'Mathematics');
                                        }
                                    } else {
                                        $("#exam_section_score<?=$lds?>").removeClass('required');
                                        $("#value1<?=$lds?>").removeClass('required');
                                        $("#value2<?=$lds?>").removeClass('required');
                                        $("#value3<?=$lds?>").removeClass('required');
                                        $("#value4<?=$lds?>").removeClass('required');
                                        $("#exam_section_score<?=$lds?>").attr('readonly', 'readonly');
                                        $("#value1<?=$lds?>").attr('readonly', 'readonly');
                                        $("#value2<?=$lds?>").attr('readonly', 'readonly');
                                        $("#value3<?=$lds?>").attr('readonly', 'readonly');
                                        $("#value4<?=$lds?>").attr('readonly', 'readonly');
                                    }

                                })
                                var wrapperrs = $('#exam_section_add');
                                $(wrapperrs).on('click', '.remove_field', function(e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                    x--;
                                });
                                </script>
                                <?php $lds++; }
                            ?>
                                <div class="add-section">
                                    <a class="add_exam_section_button button" style="cursor: pointer;color:white">Add
                                        More</a>
                                </div>
                            </div>



                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Employment Details (If employed anywhere)</h6>
                                </div>
                            </div>
                            <div id="empDetails_add" style="position:relative">

                                <?php
                        $ed=0;
                        $edsql = $obj->query("select * from $tbl_visit_employee_details where visit_id='$id'",-1); //die;
                        $edNum = $obj->numRows($edsql);
                        while($edReslut = $obj->fetchNextObject($edsql)){?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Company Name</div>
                                                <input type="text" class="form-control" placeholder="Company Name"
                                                    name="empDetails[<?php echo $ed; ?>][company_name]"
                                                    id="company_name" value="<?php echo $edReslut->company_name; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Designation</div>
                                                <input type="text" class="form-control" placeholder="Designation"
                                                    name="empDetails[<?php echo $ed; ?>][designation]" id="designation"
                                                    value="<?php echo $edReslut->designation; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 display-flex">
                                        <div class="boxing">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Start Date</div>
                                                    <input type="date" class="form-control" placeholder="Start Date"
                                                        name="empDetails[<?php echo $ed; ?>][start_date]"
                                                        value="<?php echo $edReslut->start_date; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxing boxing1">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">End Date</div>
                                                    <input type="date" class="form-control" placeholder="End Date"
                                                        name="empDetails[<?php echo $ed; ?>][end_date]"
                                                        value="<?php echo $edReslut->end_date; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">Last Salary</div>
                                                <input type="number" class="form-control" placeholder="Last Salary"
                                                    name="empDetails[<?php echo $ed; ?>][last_salary]"
                                                    value="<?php echo $edReslut->last_salary; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $ed++; }?>
                                <div class="add-section">
                                    <a class="add_field_button button" style="cursor: pointer;color:white"> Add More</a>
                                </div>
                            </div>



                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Available Funds </h6>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="input-group" style="width:100%;">
                                        <div class="input-group-addon">Do you have any previous fund?</div>
                                        <div class="col-md-1 label-required1">
                                            <div class="input-group" style="display: flex; align-items: center;">
                                                <input class="required form-check-input"
                                                    onchange="get_family_fund(this.value)" name="family_fund"
                                                    type="radio" value="Yes" <?php if($result->family_fund=='Yes'){?>
                                                    checked <?php } ?>>
                                                &nbsp;
                                                <label class="form-check-label" style="margin-top:4px;">
                                                    Yes
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-1 label-required1">
                                            <div class="input-group" style="display: flex; align-items: center;">
                                                <input class="required form-check-input"
                                                    onchange="get_family_fund(this.value)" name="family_fund"
                                                    type="radio" value="No" <?php if($result->family_fund=='No'){?>
                                                    checked <?php } ?>>
                                                &nbsp;
                                                <label class="form-check-label" style="margin-top:4px;">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" id="family_fund_show"
                                <?=$result->family_fund == 'Yes' ? '' : 'style="display:none"'?>>
                                <div class="col-md-12">
                                    <div class="input-group" style="width:100%;">
                                        <div class="input-group-addon">Total Funds</div>
                                        <input type="text" class="form-control"
                                            placeholder="Total Funds Available in all accounts" name="available_funds"
                                            id="available_funds" value="<?php echo $result->available_funds; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">How did
                                        you find us?</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label-required">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Youtube" <?php if($result->source=='Youtube'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Youtube
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Facebook" <?php if($result->source=='Facebook'){?> checked
                                            <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Facebook
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Instagram" <?php if($result->source=='Instagram'){?> checked
                                            <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Instagram
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Google" <?php if($result->source=='Google'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Google
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Website" <?php if($result->source=='Website'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Website
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Hoarding/Banner" <?php if($result->source=='Hoarding/Banner'){?>
                                            checked <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Hoarding/Banner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Friends" <?php if($result->source=='Friends'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Friends
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Paper Ad" <?php if($result->source=='Paper Ad'){?> checked
                                            <?php } ?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Newspaper Advertisement
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Seminar" <?php if($result->source=='Seminar'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Seminar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Relatives" <?php if($result->source=='Relatives'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Relatives
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Seminar/Education Fair"
                                            <?php if($result->source=='Seminar/Education Fair'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Seminar/Education Fair
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Direct Visit" <?php if($result->source=='Direct Visit'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Direct Visit
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Recommend by other Consultant"
                                            <?php if($result->source=='Recommend by other Consultant'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Recommend by other Consultant
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Telecalling" <?php if($result->source=='Telecalling'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Telecalling
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Other" <?php if($result->source=='Other'){?> checked <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:20px; margin-bottom: 20px;">
                                <h5 style="text-align:center;"><strong>--------------For Office Use
                                        Only--------------</strong></h5>
                            </div>
                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Universities Recommendation</h6>
                                </div>
                            </div>
                            <div id="universityRecommended_add" style="position:relative">

                                <div class="add-section">
                                    <a class="add_uni_field_button button" style="cursor: pointer;color:white"> Add
                                        More</a>
                                </div>
                                <?php
                                $ur=0;
                                $urdel = 3;
                                $ursql = $obj->query("select * from $tbl_visit_university_recommended where visit_id='$id'",-1); //die;
                                $edNum = $obj->numRows($ursql);
                                if($edNum>0){
                                while($urReslut = $obj->fetchNextObject($ursql)){?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">State </div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][state_id]"
                                                    id="state_id<?php echo $ur; ?>" class="form-control">
                                                    <option value="">State</option>
                                                    <?php
                                                    $sql = $obj->query("select state from $tbl_programmes where 1=1 and state!='' group by state order by state asc",-1);
                                                    while($line=$obj->fetchNextObject($sql)){?>
                                                    <option value="<?php echo $line->state ?>"
                                                        <?php if($urReslut->state_id==$line->state){?> selected
                                                        <?php }?>>
                                                        <?php echo getField('state',$tbl_state,$line->state) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">University</div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][university_id]"
                                                    id="university_id<?php echo $ur; ?>" class="form-control">
                                                    <option value="">University</option>
                                                    <?php
                                                if($urReslut->state_id!=''){
                                                $sql = $obj->query("select univercity from $tbl_programmes where state='".$urReslut->state_id."' and univercity!='' group by univercity order by univercity asc",-1);
                                                while($line=$obj->fetchNextObject($sql)){?>
                                                    <option value="<?php echo $line->univercity ?>"
                                                        <?php if($urReslut->university_id==$line->univercity){?>
                                                        selected <?php }?>>
                                                        <?php echo getField('name',$tbl_univercity,$line->univercity) ?>
                                                    </option>
                                                    <?php }
                                            }?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Course</div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][course_id]"
                                                    id="course_id<?php echo $ur; ?>" class="form-control">
                                                    <option value="">Course</option>
                                                    <?php
                                                    if($urReslut->university_id!=''){
                                                        $sql = $obj->query("select course_name from $tbl_programmes where univercity=".$urReslut->university_id." group by course_name order by course_name asc",-1);
                                                while($line=$obj->fetchNextObject($sql)){?>
                                                    <option value="<?php echo $line->course_name ?>"
                                                        <?php if($urReslut->course_id==$line->course_name){?> selected
                                                        <?php }?>><?php echo $line->course_name ?></option>
                                                    <?php } 
                                            }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Intake</div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][intake]" id="intake"
                                                    class="form-control">
                                                    <option value="">Intake</option>
                                                    <option value="1" <?php if($urReslut->intake==1){?> selected
                                                        <?php }?>>January</option>
                                                    <option value="2" <?php if($urReslut->intake==2){?> selected
                                                        <?php }?>>February</option>
                                                    <option value="3" <?php if($urReslut->intake==3){?> selected
                                                        <?php }?>>March</option>
                                                    <option value="4" <?php if($urReslut->intake==4){?> selected
                                                        <?php }?>>April</option>
                                                    <option value="5" <?php if($urReslut->intake==5){?> selected
                                                        <?php }?>>May</option>
                                                    <option value="6" <?php if($urReslut->intake==6){?> selected
                                                        <?php }?>>June</option>
                                                    <option value="7" <?php if($urReslut->intake==7){?> selected
                                                        <?php }?>>July</option>
                                                    <option value="8" <?php if($urReslut->intake==8){?> selected
                                                        <?php }?>>August</option>
                                                    <option value="9" <?php if($urReslut->intake==9){?> selected
                                                        <?php }?>>September</option>
                                                    <option value="10" <?php if($urReslut->intake==10){?> selected
                                                        <?php }?>>October</option>
                                                    <option value="11" <?php if($urReslut->intake==11){?> selected
                                                        <?php }?>>November </option>
                                                    <option value="12" <?php if($urReslut->intake==12){?> selected
                                                        <?php }?>>December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Year</div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][year]" id="year"
                                                    class="form-control">
                                                    <option value="">Year</option>
                                                    <?php
                                            for($i=date('Y')-30; $i <=date('Y')+6; $i++){?>
                                                    <option value="<?php echo $i; ?>" <?php if($urReslut->year==$i){?>
                                                        selected <?php } ?>><?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="remove_uni_field delete_btn"
                                        style="position: absolute; top: <?php echo $urdel; ?>px; right: -12px;font-size: 20px;">X</a>
                                </div>

                                <script type="text/javascript">
                                $('#state_id<?php echo $ur; ?>').change(function() {
                                    var id = $('#state_id<?php echo $ur; ?>').val();
                                    var action = 'get_UCR_state_id'
                                    $.ajax({
                                        type: "post",
                                        url: "ajax/getModalData.php",
                                        data: {
                                            'key': id,
                                            'action': action
                                        },
                                        success: function(res) {
                                            $('#university_id<?php echo $ur; ?>').html(res);
                                        }
                                    });
                                });

                                $('#university_id<?php echo $ur; ?>').change(function() {
                                    var id = $('#university_id<?php echo $ur; ?>').val();
                                    var action = 'get_UCR_course_id'
                                    $.ajax({
                                        type: "post",
                                        url: "ajax/getModalData.php",
                                        data: {
                                            'key': id,
                                            'action': action
                                        },
                                        success: function(res) {
                                            $('#course_id<?php echo $ur; ?>').html(res);
                                        }
                                    });
                                });
                                </script>
                                <?php $ur++; $urdel = $urdel+50; } }else{?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">State </div>
                                                <select name="uniRecommended[<?php echo $ur; ?>][state_id]"
                                                    id="state_id" class="form-control">
                                                    <option value="">State</option>
                                                    <?php
                                            $sql = $obj->query("select state from $tbl_programmes where 1=1 and state!='' group by state order by state asc",-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                                    <option value="<?php echo $line->state ?>"
                                                        <?php if($urReslut->state_id==$line->state){?> selected
                                                        <?php }?>>
                                                        <?php echo getField('state',$tbl_state,$line->state) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">University</div>
                                                <select name="uniRecommended[0][university_id]" id="university_id"
                                                    class="form-control">
                                                    <option value="">University</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Course</div>
                                                <select name="uniRecommended[0][course_id]" id="course_id"
                                                    class="form-control">
                                                    <option value="">Course</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Intake</div>
                                                <select name="uniRecommended[0][intake]" id="intake"
                                                    class="form-control">
                                                    <option value="">Intake</option>
                                                    <option value="1" <?php if($result->intake==1){?> selected
                                                        <?php }?>>January</option>
                                                    <option value="2" <?php if($result->intake==2){?> selected
                                                        <?php }?>>February</option>
                                                    <option value="3" <?php if($result->intake==3){?> selected
                                                        <?php }?>>March</option>
                                                    <option value="4" <?php if($result->intake==4){?> selected
                                                        <?php }?>>April</option>
                                                    <option value="5" <?php if($result->intake==5){?> selected
                                                        <?php }?>>May</option>
                                                    <option value="6" <?php if($result->intake==6){?> selected
                                                        <?php }?>>June</option>
                                                    <option value="7" <?php if($result->intake==7){?> selected
                                                        <?php }?>>July</option>
                                                    <option value="8" <?php if($result->intake==8){?> selected
                                                        <?php }?>>August</option>
                                                    <option value="9" <?php if($result->intake==9){?> selected
                                                        <?php }?>>September</option>
                                                    <option value="10" <?php if($result->intake==10){?> selected
                                                        <?php }?>>October</option>
                                                    <option value="11" <?php if($result->intake==11){?> selected
                                                        <?php }?>>November </option>
                                                    <option value="12" <?php if($result->intake==12){?> selected
                                                        <?php }?>>December</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Year</div>
                                                <select name="uniRecommended[0][year]" id="year" class="form-control">
                                                    <option value="">Year</option>
                                                    <?php
                                                    for($i=date('Y')-30; $i <=date('Y')+6; $i++){?>
                                                    <option value="<?php echo $i; ?>"
                                                        <?php if($eduReslut->master_finish_year==$i){?> selected
                                                        <?php } ?>><?php echo $i; ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>


                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Course Recommendation</h6>
                                </div>
                            </div>
                            <div id="courseRecommended_add" style="position:relative">

                                <div class="add-section">
                                    <a class="add_uni_field_button_course button" style="cursor: pointer;color:white">
                                        Add
                                        More</a>
                                </div>
                                <?php
                                $urs=0;
                                $urdel = 3;
                                $ursqls = $obj->query("select * from $tbl_visit_course where visit_id='$id'",-1); //die;
                                $edNum = $obj->numRows($ursqls);
                                if($edNum>0){
                                while($urReslut = $obj->fetchNextObject($ursqls)){?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Course Name </div>
                                                <input name="courseRecommended[<?php echo $urs; ?>][course_name]"
                                                    id="course_name<?php echo $urs; ?>" class="form-control"
                                                    value="<?=$urReslut->course_name?>">
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="remove_course_field delete_btn"
                                        style="position: absolute; top: <?php echo $urdel; ?>px; right: -12px;font-size: 20px;">X</a>
                                </div>
                                <?php $urs++; $urdel = $urdel+50; } }else{?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Course Name </div>
                                                <input name="courseRecommended[0][course_name]" id="course_name0"
                                                    class="form-control" value="<?=$urReslut->course_name?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                            </div>
                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Special Remarks </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Special Remarks</div>
                                            <input name="special_remarks" id="special_remarks" class="form-control"
                                                value="<?=$result->special_remarks?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="padding: 0 15px">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">
                                        Expected Enrollment Date </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Expected Enrollment Date </div>
                                            <input type="datetime-local" name="expected_enrollment_date"
                                                id="expected_enrollment_date" class="form-control"
                                                value="<?=$result->expected_enrollment_date?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php
                        if(!in_array(1,$addtional_role) && $_SESSION['level_id'] != 11){?>
                        <div class="row form-group" style="padding:0 15px;">
                            <div>
                                <h6 class="text-center-in-mobile-tab"
                                    style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Counsellor
                                    and Support Manager Remark</h6>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                        $readonly = '';
                        $disabled = '';
                        $readonly1 = 'readonly';
                        $disabled1 = 'disabled';
                        $readonly2 = 'readonly';
                        $disabled2 = 'disabled';
                        $readonly3 = 'readonly';
                        $disabled3 = 'disabled';
                        $readonly4 = 'readonly';
                        $disabled4 = 'disabled';
                        $todate = strtotime(date('Y-m-d'));
                        
                        if($result->inital_remarks!=0){
                            $readonly = 'readonly';
                            $disabled = 'disabled';
                            $readonly1 = '';
                            $disabled1 = '';
                        }

                        if($result->followup1_remarks!=0){
                            $readonly = 'readonly';
                            $disabled = 'disabled';
                            $readonly1 = 'readonly';
                            $disabled1 = 'disabled';
                            $readonly2 = '';
                            $disabled2 = '';
                        }

                        if($result->followup2_remarks!=0){
                            $readonly = 'readonly';
                            $disabled = 'disabled';
                            $readonly1 = 'readonly';
                            $disabled1 = 'disabled';
                            $readonly2 = 'readonly';
                            $disabled2 = 'disabled';
                            $readonly3 = '';
                            $disabled3 = '';
                        }

                        if($result->followup3_remarks!=0){
                            $readonly = 'readonly';
                            $disabled = 'disabled';
                            $readonly1 = 'readonly';
                            $disabled1 = 'disabled';
                            $readonly2 = 'readonly';
                            $disabled2 = 'disabled';
                            $readonly3 = 'readonly';
                            $disabled3 = 'disabled';
                            $readonly4 = '';
                            $disabled4 = '';
                        }


                        // $readonlys = '';
                        // $disableds = '';
                        // $readonly1s = 'readonly';
                        // $disabled1s = 'disabled';
                        // $readonly2s = 'readonly';
                        // $disabled2s = 'disabled';
                        // $readonly3s = 'readonly';
                        // $disabled3s = 'disabled';
                        // $readonly4s = 'readonly';
                        // $disabled4s = 'disabled';
                        // $todate = strtotime(date('Y-m-d'));
                        
                        // if($result->support_inital_start_date!=0){
                        //     $readonlys = 'readonly';
                        //     $disableds = 'disabled';
                        //     $readonly1s = '';
                        //     $disabled1s = '';
                        // }

                        // if($result->support_followup1_start_date!=0){
                        //     $readonlys = 'readonly';
                        //     $disableds = 'disabled';
                        //     $readonly1s = 'readonly';
                        //     $disabled1s = 'disabled';
                        //     $readonly2s = '';
                        //     $disabled2s = '';
                        // }

                        // if($result->support_followup2_start_date!=0){
                        //     $readonlys = 'readonly';
                        //     $disableds = 'disabled';
                        //     $readonly1s = 'readonly';
                        //     $disabled1s = 'disabled';
                        //     $readonly2s = 'readonly';
                        //     $disabled2s = 'disabled';
                        //     $readonly3s = '';
                        //     $disabled3s = '';
                        // }

                        // if($result->support_followup3_start_date!=0){
                        //     $readonlys = 'readonly';
                        //     $disableds = 'disabled';
                        //     $readonly1s = 'readonly';
                        //     $disabled1s = 'disabled';
                        //     $readonly2s = 'readonly';
                        //     $disabled2s = 'disabled';
                        //     $readonly3s = 'readonly';
                        //     $disabled3s = 'disabled';
                        //     $readonly4s = '';
                        //     $disabled4s = '';
                        // }


                        // if($result->inital_status==4){
                        //     $readonly = '';
                        //     $disabled = '';
                        //     $readonly1 = 'readonly';
                        //     $disabled1 = 'disabled';
                        //     $readonly2 = 'readonly';
                        //     $disabled2 = 'disabled';
                        //     $readonly3 = 'readonly';
                        //     $disabled3 = 'disabled';
                        //     $readonly4 = 'readonly';
                        //     $disabled4 = 'disabled';
                        // }else if($result->followup1_status==4){
                        //     $readonly = 'readonly';
                        //     $disabled = 'disabled';
                        //     $readonly1 = '';
                        //     $disabled1 = '';
                        //     $readonly2 = 'readonly';
                        //     $disabled2 = 'disabled';
                        //     $readonly3 = 'readonly';
                        //     $disabled3 = 'disabled';
                        //     $readonly4 = 'readonly';
                        //     $disabled4 = 'disabled';
                        // }else if($result->followup2_status==4){
                        // }else if($result->followup3_status==4){
                        // }else if($result->last_followup_status==4){

                        // }
                        ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon  text-upparcase" style="height: 35px; color: #fff;">
                                        Inital remark of Councellor</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="inital_start_date" <?php if($readonly == ''){ ?>
                                            id="inital_start_date" <?php }?>
                                            value="<?php if($result->inital_start_date != ''){ echo $result->inital_start_date; }else{ echo date('Y-m-d'); }  ?>"
                                            placeholder="Date"
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="inital_status" id="inital_status" <?php echo $disabled; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_visit_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->inital_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">

                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="inital_remarks" id="inital_remarks" <?php echo $disabled; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->inital_status!=0){
                                                $sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='".$result->inital_status."'",-1); //die();
                                                $cstatusArr = array();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->inital_remarks){?> selected <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="inital_next_followup_date" <?php if($readonly==''){?>
                                            id="inital_next_followup_date" <?php }?> placeholder="Next Follow up Date"
                                            class="form-control"
                                            value="<?php if($result->inital_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->inital_next_followup_date)); }else{ if($readonly==''){ echo date('Y-m-d', strtotime(' + 2 days'));} } ?>"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text"
                                            class="form-control <?php if($_SESSION['level_id']!= 1){ if($readonlys == ''){ echo 'required' ;} } ?>"
                                            placeholder="Enter Remark" name="inital_additional_remarks"
                                            id="inital_additional_remarks"
                                            value="<?php echo stripslashes($result->inital_additional_remarks); ?>"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Support Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_inital_start_date"
                                            <?php if($result->support_inital_additional_remarks == ''){ ?>
                                            id="support_inital_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_inital_additional_remarks!=''){ echo date('Y-m-d',strtotime($result->support_inital_start_date)); }else{ if($readonlys == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_inital_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_inital_additional_remarks"
                                            id="support_inital_additional_remarks"
                                            value="<?php echo stripslashes($result->support_inital_additional_remarks); ?>"
                                            <?php echo $result->support_inital_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line-dotted"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 1 of Councellor</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup1_start_date)){
                                        if(!empty($result->inital_start_date)){
                                            $followup1_start_date =  date('Y-m-d'); 
                                        }                                                     
                                    }else{
                                        $followup1_start_date =  $result->followup1_start_date; 
                                    }
                                    ?>

                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup1_start_date" <?php if($readonly1==''){?>
                                            id="followup1_start_date" <?php }?>
                                            value="<?php echo $followup1_start_date ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly1; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup1_status" id="followup1_status" <?php echo $disabled1; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_visit_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup1_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup1_remarks" id="followup1_remarks" <?php echo $disabled1; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup1_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='".$result->followup1_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup1_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup1_next_followup_date"
                                            <?php if($readonly1==''){?> id="followup1_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup1_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup1_next_followup_date)); }else{ if($readonly1==''){ echo date('Y-m-d', strtotime(' + 4 days'));} }  ?>"
                                            <?php echo $readonly1; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 4 days'))?>','followup1_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup1_additional_remarks" id="followup1_additional_remarks"
                                            value="<?php echo stripslashes($result->followup1_additional_remarks); ?>"
                                            <?php echo $readonly1; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Support Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup1_start_date"
                                            <?php if($result->support_followup1_additional_remarks == ''){ ?>
                                            id="support_followup1_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup1_start_date!=''){ echo date('Y-m-d',strtotime($result->support_followup1_start_date)); }else{ if($result->support_followup1_additional_remarks == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup1_additional_remarks !='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup1_additional_remarks"
                                            id="support_followup1_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup1_additional_remarks); ?>"
                                            <?php echo $result->support_followup1_additional_remarks !='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line-dotted"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 2 of Councellor</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <?php  
                                    if(empty($result->followup2_start_date)){
                                        if(!empty($result->followup1_start_date)){
                                            $followup2_start_date =  date('Y-m-d'); 
                                        }             
                                    }else{
                                        $followup2_start_date =  $result->followup2_start_date; 
           
                                    }
                                    ?>
                                        <input type="text" name="followup2_start_date" <?php if($readonly2==''){?>
                                            id="followup2_start_date" <?php }?>
                                            value="<?php echo $followup2_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly2; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup2_status" id="followup2_status" <?php echo $disabled2; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_visit_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup2_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                        if($_REQUEST['id']!='' && $result->followup2_status!=0 && $disabled2!=''){?>
                                        <input type="hidden" name="followup2_status"
                                            value="<?php echo $result->followup2_status ?>">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup2_remarks" id="followup2_remarks" <?php echo $disabled2; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup2_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='".$result->followup2_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup2_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup2_next_followup_date"
                                            <?php if($readonly2==''){?> id="followup2_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup2_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup2_next_followup_date)); }else{ if($readonly2==''){ echo date('Y-m-d', strtotime(' + 5 days'));} }  ?>"
                                            <?php echo $readonly2; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 5 days'))?>','followup2_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup2_additional_remarks" id="followup2_additional_remarks"
                                            value="<?php echo stripslashes($result->followup2_additional_remarks); ?>"
                                            <?php echo $readonly2; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Support Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup2_start_date"
                                            <?php if($result->support_followup2_additional_remarks == ''){ ?>
                                            id="support_followup2_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup2_start_date!=''){ echo date('Y-m-d',strtotime($result->support_followup2_start_date)); }else{ if($result->support_followup2_additional_remarks == ''){ echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup2_additional_remarks != '' ? 'readonly' : '' ; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup2_additional_remarks"
                                            id="support_followup2_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup2_additional_remarks); ?>"
                                            <?php echo $result->support_followup2_additional_remarks != '' ? 'readonly' : '' ; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line-dotted"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 3 of Councellor</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup3_start_date)){
                                        if(!empty($result->followup2_start_date)){
                                            $followup3_start_date =  date('Y-m-d');
                                        }              
                                    }else{
                                        $followup3_start_date =  $result->followup3_start_date; 
           
                                    }
                                    ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup3_start_date" <?php if($readonly3==''){?>
                                            id="followup3_start_date" <?php }?>
                                            value="<?php echo $followup3_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly3; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup3_status" id="followup3_status" <?php echo $disabled3; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_visit_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup3_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || $_SESSION['level_id'] == '25' || in_array(1,$addtional_role)  || in_array(4,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup3_remarks" id="followup3_remarks" <?php echo $disabled3; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup3_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='".$result->followup3_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup3_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup3_next_followup_date"
                                            <?php if($readonly3==''){?> id="followup3_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup3_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup3_next_followup_date)); }else{ if($readonly3==''){ echo date('Y-m-d', strtotime(' + 6 days'));} }  ?>"
                                            <?php echo $readonly3; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 6 days'))?>','followup3_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup3_additional_remarks" id="followup3_additional_remarks"
                                            value="<?php echo stripslashes($result->followup3_additional_remarks); ?>"
                                            <?php echo $readonly3; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Support Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup3_start_date"
                                            <?php if($result->support_followup3_additional_remarks == ''){ ?>
                                            id="support_followup3_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup3_additional_remarks!=''){ echo date('Y-m-d',strtotime($result->support_followup3_start_date)); }else{ if($result->support_followup3_additional_remarks == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup3_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup3_additional_remarks"
                                            id="support_followup3_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup3_additional_remarks); ?>"
                                            <?php echo $result->support_followup3_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="line-dotted"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Last Follow up of Councellor</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                        if(empty($result->last_followup_start_date)){
                                            if(!empty($result->followup3_start_date)){
                                                $last_followup_start_date =  date('Y-m-d');              
                                            }
                                        }else{
                                            $last_followup_start_date =  $result->last_followup_start_date; 
               
                                        }
                                        ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="last_followup_start_date" id="last_followup_start_date"
                                            value="<?php echo $last_followup_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control select2" name="last_followup_status"
                                            id="last_followup_status" <?php echo $disabled4; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_visit_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->last_followup_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control select2" name="last_followup_remarks"
                                            id="last_followup_remarks" <?php echo $disabled4; ?>>
                                            <option value="">Remarks </option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->last_followup_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_visit_remarks_status where status=1 and stage_id='".$result->last_followup_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->last_followup_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="last_followup_next_followup_date"
                                            id="last_followup_next_followup_date" placeholder="Last Follow up Date"
                                            class="form-control"
                                            value="<?php if($result->last_followup_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->last_followup_next_followup_date)); } ?>"
                                            <?php echo $readonly4; ?>>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="last_followup_additional_remarks"
                                            id="last_followup_additional_remarks"
                                            value="<?php echo stripslashes($result->last_followup_additional_remarks); ?>"
                                            <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Support Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_last_followup_start_date"
                                            <?php if($result->support_last_followup_additional_remarks == ''){ ?>
                                            id="support_last_followup_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_last_followup_start_date!=''){ echo date('Y-m-d',strtotime($result->support_last_followup_start_date)); }else{ if($result->support_last_followup_additional_remarks == ''){ echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_last_followup_additional_remarks!='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_last_followup_additional_remarks"
                                            id="support_last_followup_additional_remarks"
                                            value="<?php echo stripslashes($result->support_last_followup_additional_remarks); ?>"
                                            <?php echo $result->support_last_followup_additional_remarks!='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25|| in_array(4, $addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php }?>

                </div>
            </div>
            <?php
              if($_SESSION['level_id'] != 9){
            ?>
            <div class="row">
                <div class="add_stdnt_btn">
                    <button type="submit" id="submitbtn" class="btn mr-10"><?php
                        if(!in_array(1,$addtional_role) && $_SESSION['level_id'] != 11){?> Submit
                        <?php }else{ if($result->councellor_id == ''){ ?>Assign Enquiry to consellor
                        <?php }else{ echo "Reassign Enquiry to consellor"; } }?></button>
                </div>
            </div>
            <?php } ?>
            </form>
            <footer class="footer container-fluid pl-30 pr-30">
                <div class="row">
                    <div class="col-sm-12">
                        <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Board</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="submit_board" method="post">

                    <div class="modal-body student_filter" style="margin: 0;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group" style="width:100%;">
                                    <div class="input-group-addon">Board Name</div>
                                    <input type="text" class="form-control required" placeholder="Board Name"
                                        name="name" id="board_name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    $(".select2").select2();
    $("#councellor_id").select2({
        placeholder: "Select Counsellor",
        allowClear: true
    });

    function change_matriculation(val) {
        // alert();
        var check = document.getElementById('flexCheckCheckeds');
        if (check.checked == true) {
            $("#matri_board").removeClass('required');
            $("#matri_board").removeClass('error');
            $("#matri_start_year").removeClass('required');
            $("#matri_start_year").removeClass('error');
            $("#matri_finish_year").removeClass('required');
            $("#matri_finish_year").removeClass('error');
            $("#matri_percentage").removeClass('required');
            $("#matri_percentage").removeClass('error');
        } else {
            $("#matri_board").addClass('required');
            $("#matri_start_year").addClass('required');
            $("#matri_finish_year").addClass('required');
            $("#matri_percentage").addClass('required');
        }
    }

    const targetDiv = document.getElementById("third");
    const btn = document.getElementById("toggle");
    btn.onclick = function() {
        if (targetDiv.style.display !== "none") {
            targetDiv.style.display = "none";
            btn.innerHTML = 'View Details';
        } else {
            btn.innerHTML = 'Hide Details';
            targetDiv.style.display = "block";
        }
    };

    $(".datepicker").datepicker({
        format: 'dd/MM/yyyy',
        minDate: new Date('<?php echo date('Y-m-d') ?>'),
        maxDate: new Date('<?php echo date('Y-m-d', strtotime('+10 year')) ?>'),
    });

    $("#dob").datepicker({
        format: 'dd/mm/yy',
        minDate: new Date('<?php echo date('Y-m-d', strtotime('-80 year')) ?>'),
        maxDate: new Date('<?php echo date('Y-m-d', strtotime('-10 year')) ?>'),
    });
    flatpickr("#datetime_enquiry", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    </script>
    <script>
    $(document).ready(function() {
        $("#visitfrm").validate();

        $("#inital_start_date").datepicker({
            minDate: 0,
            onSelect: function(selected) {
                console.log(selected);
                var date = $(this).datepicker('getDate');
                var tempStartDate = new Date(date);
                var default_end = new Date(tempStartDate.getFullYear(), tempStartDate.getMonth(),
                    tempStartDate.getDate() + 1
                ); //this parses date to overcome new year date weirdness
                $("#inital_next_followup_date").datepicker("option", "minDate", default_end);
                $('#inital_next_followup_date').datepicker('setDate',
                    default_end); // Set as default
            }
        });

        $("#inital_next_followup_date").datepicker({
            minDate: 1,
        });





        $("#followup1_start_date").datepicker({
            minDate: 0,
            onSelect: function(selected) {
                console.log(selected);
                var date = $(this).datepicker('getDate');
                var tempStartDate = new Date(date);
                var default_end = new Date(tempStartDate.getFullYear(), tempStartDate.getMonth(),
                    tempStartDate.getDate() + 1
                ); //this parses date to overcome new year date weirdness
                $("#followup1_next_followup_date").datepicker("option", "minDate", default_end);
                $('#followup1_next_followup_date').datepicker('setDate',
                    default_end); // Set as default
            }
        });

        $("#followup1_next_followup_date").datepicker({
            minDate: '<?=date('m/d/Y', strtotime($result->inital_next_followup_date . ' +1 day'))?>',
        });


        $("#followup2_start_date").datepicker({
            minDate: 0,
            onSelect: function(selected) {
                console.log(selected);
                var date = $(this).datepicker('getDate');
                var tempStartDate = new Date(date);
                var default_end = new Date(tempStartDate.getFullYear(), tempStartDate.getMonth(),
                    tempStartDate.getDate() + 1
                ); //this parses date to overcome new year date weirdness
                $("#followup2_next_followup_date").datepicker("option", "minDate", default_end);
                $('#followup2_next_followup_date').datepicker('setDate',
                    default_end); // Set as default
            }
        });

        $("#followup2_next_followup_date").datepicker({
            minDate: '<?=date('m/d/Y', strtotime($result->followup1_next_followup_date . ' +1 day'))?>',
        });


        $("#followup3_start_date").datepicker({
            minDate: 0,
            onSelect: function(selected) {
                console.log(selected);
                var date = $(this).datepicker('getDate');
                var tempStartDate = new Date(date);
                var default_end = new Date(tempStartDate.getFullYear(), tempStartDate.getMonth(),
                    tempStartDate.getDate() + 1
                ); //this parses date to overcome new year date weirdness
                $("#followup3_next_followup_date").datepicker("option", "minDate", default_end);
                $('#followup3_next_followup_date').datepicker('setDate',
                    default_end); // Set as default
            }
        });

        $("#followup3_next_followup_date").datepicker({
            minDate: '<?=date('m/d/Y', strtotime($result->followup2_next_followup_date . ' +1 day'))?>'
        });


        $("#last_followup_start_date").datepicker({
            minDate: 0,
            onSelect: function(selected) {
                console.log(selected);
                var date = $(this).datepicker('getDate');
                var tempStartDate = new Date(date);
                var default_end = new Date(tempStartDate.getFullYear(), tempStartDate.getMonth(),
                    tempStartDate.getDate() + 1
                ); //this parses date to overcome new year date weirdness
                $("#last_followup_next_followup_date").datepicker("option", "minDate", default_end);
                $('#last_followup_next_followup_date').datepicker('setDate',
                    default_end); // Set as default
            }
        });

        $("#last_followup_next_followup_date").datepicker({
            minDate: '<?=date('m/d/Y', strtotime($result->followup3_next_followup_date . ' +1 day'))?>'
        });

        $("#country_id").change(function() {
            var id = this.value;
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getLeadState'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#mstate_id").html(response);
                }
            });
        });
        $("#city_id").change(function() {
            var id = this.value;
            if (id == 1000) {
                $("#city_name").show();
                $("#city_name").addClass("required");
            } else {
                $("#city_name").hide();
                $("#city_name").removeClass("required")
            }
        });

        $("#pre_country_id").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getState'
                },
                beforeSend: function() {},
                success: function(response) {
                    //console.log(response);
                    $("#pre_state_id").html(response);
                }
            });
        });

        $("#visa_earlier1, #visa_earlier2").change(function() {

            if ($("#visa_earlier1").is(":checked") == true) {
                $('.earliercountry').show();
                $("#earlier_country_id").addClass("required");
                $("#visa_outcome").addClass("required");
                $("#refuesed_date").addClass("required");
            }

            if ($("#visa_earlier2").is(":checked") == true) {
                $('.earliercountry').hide();
                $("#visa_outcome").removeClass("required");
                $("#refuesed_date").removeClass("required");
                $("#earlier_country_id").removeClass("required");
            }
        });

        $("#matri_percentage").change(function() {
            v1 = $(this).val();
            v2 = "%";
            $(this).val(v1.concat(v2));
        })

        $("#secondary_percentage").change(function() {
            v1 = $(this).val();
            v2 = "%";
            $(this).val(v1.concat(v2));
        })

        $("#diploma_percentage").change(function() {
            v1 = $(this).val();
            v2 = "%";
            $(this).val(v1.concat(v2));
        })

        $(".addpercentage").change(function() {
            v1 = parseFloat($(this).val());
            v2 = "%";
            if (v1 < 101) {
                v2 = "%";
                $(this).val(v1.concat(v2));
            } else {
                $(this).val('100%');
            }
        })

        $("#mstate_id").change(function() {
            var id = this.value;
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getLeadCity'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#city_id").html(response);
                }
            });
        });


        var addButton = $('.add_field_button');
        var wrapper = $('#empDetails_add');
        var x = 0;
        maxField = 10;
        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                $(wrapper).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Company Name</div><input type="text" class="form-control" placeholder="Company Name" name="empDetails[' +
                    x +
                    '][company_name]" id="company_name" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Designation</div><input type="text" class="form-control" placeholder="Designation" name="empDetails[' +
                    x +
                    '][designation]" id="designation" value=""></div></div></div><div class="col-md-6 display-flex"><div class="boxing"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Start Date</div><input type="date" class="form-control" placeholder="Start Date" name="empDetails[' +
                    x +
                    '][start_date]" value=""></div></div></div><div class="boxing boxing1"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">End Date</div><input type="date" class="form-control" placeholder="End Date" name="empDetails[' +
                    x +
                    '][end_date]" value=""></div></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Last Salary</div><input type="number" class="form-control" placeholder="Last Salary" name="empDetails[' +
                    x +
                    '][last_salary]" value=""></div></div></div></div><a href="#" class="remove_field removecls delete_btn">X</a>'
                );
            }
        });


        $(wrapper).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });



        var addButtonns = $('.add_lang_field_button');
        var wrapperrs = $('#langDetails_add');
        var p = <?php echo $ld-1; ?>;
        maxField = 10;
        $(addButtonns).click(function() {
            if (p < maxField) {
                p++;
                $(wrapperrs).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Exam Name</div><select name="langDetails[' +
                    p + '][exam_name]" id="exam_name' + p +
                    '" class="form-control"><option value="">Select</option><option value="IELTS">IELTS</option><option value="PTE">PTE</option><option value="TOEFL">TOEFL</option><option value="DUOLINGO">DUOLINGO</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Listening</div><input type="text" class="form-control" placeholder="Listening" name="langDetails[' +
                    p + '][lang_listening]" readonly id="lang_listening' + p +
                    '" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Reading</div><input type="text" class="form-control" placeholder="Reading" name="langDetails[' +
                    p + '][lang_reading]" value="" readonly id="lang_reading' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Writing</div><input type="text" class="form-control" placeholder="Writing" name="langDetails[' +
                    p + '][lang_writing]" value="" readonly id="lang_writing' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Speaking</div><input type="text" class="form-control" placeholder="Speaking" name="langDetails[' +
                    p + '][lang_speaking]" value="" readonly id="lang_speaking' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="scorelabel' +
                    p +
                    '">Overall Bands</div><input type="text" class="form-control" placeholder="Overall Bands" id="score' +
                    p + '" name="langDetails[' + p +
                    '][scrore]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Exam Date</div><input type="date" class="form-control change-date" placeholder="READING" id="exam_date' +
                    p +
                    '" name="langDetails[' +
                    p +
                    '][exam_date]" value="" readonly></div></div></div></div><a href="#" class="remove_field removelangcls delete_btn">X</a></div>'
                );
                $(".change-date").change(function() {
                    var val = $(this).val();
                    if (val != '') {
                        $(this).removeClass('required');
                        $(this).next('.error').hide();
                        $(this).css("color", "black");
                    } else {
                        $(this).addClass('required');
                        $(this).next('.error').show();
                        $(this).css("color", "red");
                    }
                });
                $("#exam_name" + p).change(function() {
                    examval = $(this).val();
                    if (examval != '') {
                        $("#exam_date" + p).removeAttr("readonly", 'readonly');
                        $("#score" + p).removeAttr("readonly", 'readonly');
                        $("#lang_speaking" + p).removeAttr("readonly", 'readonly');
                        $("#lang_writing" + p).removeAttr("readonly", 'readonly');
                        $("#lang_reading" + p).removeAttr("readonly", 'readonly');
                        $("#lang_listening" + p).removeAttr("readonly", 'readonly');
                        if (examval == 'IELTS') {
                            $("#score" + p).attr("placeholder", "Overall Bands");
                            $("#scorelabel" + p).html("Overall Bands");
                        } else {
                            $("#score" + p).attr("placeholder", "OVERALL SCORE");
                            $("#scorelabel" + p).html("OVERALL SCORE");
                        }

                        if (examval == 'DUOLINGO') {
                            $("#lang_listening" + p).attr('readonly', 'readonly');
                            $("#lang_reading" + p).attr('readonly', 'readonly');
                            $("#lang_writing" + p).attr('readonly', 'readonly');
                            $("#lang_speaking" + p).attr('readonly', 'readonly');

                            $("#lang_listening" + p).removeClass('required');
                            $("#lang_reading" + p).removeClass('required');
                            $("#lang_writing" + p).removeClass('required');
                            $("#lang_speaking" + p).removeClass('required');
                            $("#exam_date" + p).addClass('required');

                            $("#lang_listening" + p).val('');
                            $("#lang_reading" + p).val('');
                            $("#lang_writing" + p).val('');
                            $("#lang_speaking" + p).val('');
                            $("#exam_date" + p).val('');
                        } else {
                            $("#lang_listening" + p).removeAttr('readonly');
                            $("#lang_reading" + p).removeAttr('readonly');
                            $("#lang_writing" + p).removeAttr('readonly');
                            $("#lang_speaking" + p).removeAttr('readonly');

                            $("#score" + p).addClass('required');
                            $("#lang_listening" + p).addClass('required');
                            $("#lang_reading" + p).addClass('required');
                            $("#lang_writing" + p).addClass('required');
                            $("#lang_speaking" + p).addClass('required');
                            $("#exam_date" + p).addClass('required');
                        }
                    } else {
                        $("#lang_listening" + p).removeClass('required');
                        $("#lang_reading" + p).removeClass('required');
                        $("#lang_writing" + p).removeClass('required');
                        $("#lang_speaking" + p).removeClass('required');
                        $("#score" + p).removeClass('required');
                        $("#exam_date" + p).removeClass('required');
                        $("#exam_date" + p).attr("readonly", 'readonly');
                        $("#score" + p).attr("readonly", 'readonly');
                        $("#lang_speaking" + p).attr("readonly", 'readonly');
                        $("#lang_writing" + p).attr("readonly", 'readonly');
                        $("#lang_reading" + p).attr("readonly", 'readonly');
                        $("#lang_listening" + p).attr("readonly", 'readonly');
                    }
                })
            }
        });
        $("#exam_name" + p).change(function() {
            examval = $(this).val();
            if (examval != '') {
                if (examval == 'IELTS') {
                    $("#score" + p).attr("placeholder", "Overall Bands");
                    $("#scorelabel" + p).html("Overall Bands");
                } else {
                    $("#score" + p).attr("placeholder", "OVERALL SCORE");
                    $("#scorelabel" + p).html("OVERALL SCORE");
                }

                if (examval == 'DUOLINGO') {
                    $("#lang_listening" + p).attr('readonly', 'readonly');
                    $("#lang_reading" + p).attr('readonly', 'readonly');
                    $("#lang_writing" + p).attr('readonly', 'readonly');
                    $("#lang_speaking" + p).attr('readonly', 'readonly');

                    $("#lang_listening" + p).removeClass('required');
                    $("#lang_reading" + p).removeClass('required');
                    $("#lang_writing" + p).removeClass('required');
                    $("#lang_speaking" + p).removeClass('required');

                    $("#lang_listening" + p).val('');
                    $("#lang_reading" + p).val('');
                    $("#lang_writing" + p).val('');
                    $("#lang_speaking" + p).val('');
                    $("#exam_date" + p).val('');
                } else {
                    $("#lang_listening" + p).removeAttr('readonly');
                    $("#lang_reading" + p).removeAttr('readonly');
                    $("#lang_writing" + p).removeAttr('readonly');
                    $("#lang_speaking" + p).removeAttr('readonly');

                    $("#score" + p).addClass('required');
                    $("#lang_listening" + p).addClass('required');
                    $("#lang_reading" + p).addClass('required');
                    $("#lang_writing" + p).addClass('required');
                    $("#lang_speaking" + p).addClass('required');
                }
            } else {
                $("#lang_listening" + p).removeClass('required');
                $("#lang_reading" + p).removeClass('required');
                $("#lang_writing" + p).removeClass('required');
                $("#lang_speaking" + p).removeClass('required');
                $("#score" + p).removeClass('required');
            }
        })


        $(wrapperrs).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        $("#exam_name").change(function() {
            var examid = $(this).val();
            if (examid != '') {
                $("#exam_date").removeAttr("readonly", 'readonly');
                $("#score").removeAttr("readonly", 'readonly');
                $("#lang_speaking").removeAttr("readonly", 'readonly');
                $("#lang_writing").removeAttr("readonly", 'readonly');
                $("#lang_reading").removeAttr("readonly", 'readonly');
                $("#lang_listening").removeAttr("readonly", 'readonly');
                if (examid == 'DUOLINGO') {
                    $("#lang_listening").attr('readonly', 'readonly');
                    $("#lang_reading").attr('readonly', 'readonly');
                    $("#lang_writing").attr('readonly', 'readonly');
                    $("#lang_speaking").attr('readonly', 'readonly');
                } else {
                    $("#lang_listening").removeAttr('readonly');
                    $("#lang_reading").removeAttr('readonly');
                    $("#lang_writing").removeAttr('readonly');
                    $("#lang_speaking").removeAttr('readonly');
                }
            } else {
                $("#exam_date").attr("readonly", 'readonly');
                $("#score").attr("readonly", 'readonly');
                $("#lang_speaking").attr("readonly", 'readonly');
                $("#lang_writing").attr("readonly", 'readonly');
                $("#lang_reading").attr("readonly", 'readonly');
                $("#lang_listening").attr("readonly", 'readonly');
            }
        })



        var addButtons = $('.add_uni_field_button');
        var wrapperunia = $('#universityRecommended_add');
        var x = <?php echo $ur-1; ?>;
        maxField = 10;
        $(addButtons).click(function() {
            if (x < maxField) {
                x++;
                $(wrapperunia).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">State</div><select name="uniRecommended[' +
                    x + '][state_id]" id="state_id' + x +
                    '" class="form-control"><option value="">State</option> <?php $sql = $obj->query("select state from $tbl_programmes where 1=1 and state!='' group by state order by state asc",-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->state ?>" ><?php echo getField('state',$tbl_state,$line->state) ?></option><?php } ?></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">University</div><select name="uniRecommended[' +
                    x + '][university_id]" id="university_id' + x +
                    '" class="form-control"><option value="">University</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Course</div><select name="uniRecommended[' +
                    x + '][course_id]" id="course_id' + x +
                    '" class="form-control"><option value="">Course</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Intake</div><select name="uniRecommended[' +
                    x +
                    '][intake]" id="intake" class="form-control"><option value="">Intake</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November </option><option value="12">December</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Year</div><select name="uniRecommended[' +
                    x +
                    '][year]" id="year" class="form-control"><option value="">Year</option><?php for($i=date('Y')-30; $i <=date('Y')+6; $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div></div><a href="#" class="remove_uni_field removeuniclss delete_btn">X</a></div>'
                );
            }

            $('#state_id' + x).change(function() {
                var id = $('#state_id' + x).val();
                var action = 'get_UCR_state_id'
                $.ajax({
                    type: "post",
                    url: "ajax/getModalData.php",
                    data: {
                        'key': id,
                        'action': action
                    },
                    success: function(res) {
                        $('#university_id' + x).html(res);
                    }
                });
            });

            $('#university_id' + x).change(function() {
                var id = $('#university_id' + x).val();
                var action = 'get_UCR_course_id'
                $.ajax({
                    type: "post",
                    url: "ajax/getModalData.php",
                    data: {
                        'key': id,
                        'action': action
                    },
                    success: function(res) {
                        $('#course_id' + x).html(res);
                    }
                });
            });


        });


        $(wrapperuni).on('click', '.remove_uni_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });


        var addButtons = $('.add_uni_field_button_course');
        var wrapperuni = $('#courseRecommended_add');
        var x = <?php echo $urs; ?>;
        maxField = 10;
        $(addButtons).click(function() {
            if (x < maxField) {
                x++;
                $(wrapperuni).append(
                    `<div class="add" style="position:relative"><div class="row"><div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon">Course Name </div>
                                                <input name="courseRecommended[` + x + `][course_name]"
                                                id="course_name` + x +
                    `" class="form-control">
                                            </div>
                                        </div>
                                    </div></div><a href="#" class="remove_course_field removeuniclss delete_btn">X</a></div>`
                );
            }
        });


        $(wrapperuni).on('click', '.remove_course_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });





        var addButtonn = $('.add_master_field_button');
        var wrapperr = $('#masterDetails_add');
        var y = 0;
        <?php 
                if($id!=''){?>
        var m = <?php echo $edudet; ?>;
        <?php }else{?>
        var m = 0;
        <?php }?>
        maxField = 10;
        $(addButtonn).click(function() {
            if (y < maxField) {
                y++;
                $(wrapperr).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-2"><div class="form-group"><p style="text-align: left; background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">Others</p></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control" placeholder="Institute/University" name="education[' +
                    m +
                    '][master_board]" id="master_board" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control" placeholder="Degree" name="education[' +
                    m +
                    '][master_stream]" id="master_stream" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><select class="form-control" name="education[' +
                    m +
                    '][master_start_year]" id="master_start_year" onchange="change_last_year(this.value, ' +
                    "'" + 'master_finish_year' + m + "'" +
                    ')"><option value="">Start Year</option><?php for($i=date('Y')-30; $i <=date('Y'); $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><select class="form-control" name="education[' +
                    m +
                    '][master_finish_year]" id="master_finish_year' + m +
                    '"><option value="">Finish Year</option><?php for($i=date('Y')-30; $i <=date('Y'); $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div><div class="col-md-1"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control addpercentage" placeholder="PERCENTAGE" name="education[' +
                    m +
                    '][master_percentage]" id="master_percentage" value="" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)"></div></div></div><div class="col-md-1"><div class="form-group" style="display:flex; gap:15px;"><div class="input-group" style="width:80%;"><input type="text" class="form-control" placeholder="Any Backlog" name="education[' +
                    m +
                    '][master_backlog]" id="master_backlog" value="" ></div></div></div></div><a href="#" class="remove_field removemastercls delete_btn">X</a></div>'
                );
                m++;
            }

            $(".addpercentage").change(function() {
                v1 = $(this).val();
                v2 = "%";
                $(this).val(v1.concat(v2));
            })
        });


        $(wrapperr).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });



        $("#inital_status").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getVisitRemarks'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#inital_remarks").html(response);
                }
            });
        })
        $("#followup1_status").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getVisitRemarks'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#followup1_remarks").html(response);
                }
            });
        })
        $("#followup2_status").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getVisitRemarks'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#followup2_remarks").html(response);
                }
            });
        })
        $("#followup3_status").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getVisitRemarks'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#followup3_remarks").html(response);
                }
            });
        })
        $("#last_followup_status").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getVisitRemarks'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#last_followup_remarks").html(response);
                }
            });
        })


        $('#state_id').change(function() {
            var id = $('#state_id').val();
            var action = 'get_UCR_state_id'
            $.ajax({
                type: "post",
                url: "ajax/getModalData.php",
                data: {
                    'key': id,
                    'action': action
                },
                success: function(res) {
                    $('#university_id').html(res);
                }
            });
        });

        $('#university_id').change(function() {
            var id = $('#university_id').val();
            var action = 'get_UCR_course_id'
            $.ajax({
                type: "post",
                url: "ajax/getModalData.php",
                data: {
                    'key': id,
                    'action': action
                },
                success: function(res) {
                    $('#course_id').html(res);
                }
            });
        });

    })
    </script>

    <script>
    function change_matric_board(val, id) {
        if (val == 'other') {
            $("#board_name").val('');
            $("#" + id).val('');

            $("#" + id + "_refresh").html(
                '<form id="submit_board" method="post"><div class="input-group" style="width:100%;display: flex;"><input type="text" onblur="submit_form()" class="form-control" placeholder="Board Name"name="name" id="board_name"><p style="cursor: pointer;margin: auto;padding-left: 5px;" onclick="refresh_div(' +
                "'" + id + "'" + ')">x</p></div></div></form>');
        }
    }

    function refresh_div(id) {
        if (id == 'matri_board') {
            $("#matri_board_refresh").load(location.href +
                " #matri_board_refresh");
        } else {
            $("#secondary_board_refresh").load(location.href +
                " #secondary_board_refresh");
        }
    }

    function submit_form() {
        $("#submit_board").submit();
    }

    $(document).ready(function() {
        $("#submit_board").submit(function(e) {
            e.preventDefault();
            let name = $("#board_name").val();
            if (name == '') {
                toastr.options.timeOut = 10000;
                toastr.error("Please enter board name");
            } else {
                $.ajax({
                    method: "POST",
                    url: 'ajax/ajax.php',
                    data: {
                        name: name,
                        submit_board_name: '1'
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.trim() === '2') {
                            toastr.options.timeOut = 10000;
                            toastr.error("This board is already exist");
                        } else {
                            $("#exampleModal").modal('hide');
                            $("#board_name").val('');
                            $("#matri_board_refresh").load(location.href +
                                " #matri_board_refresh");
                            $("#secondary_board_refresh").load(location.href +
                                " #secondary_board_refresh");
                            toastr.options.timeOut = 10000;
                            toastr.success("Board Added Successfully");
                        }
                    }
                })
            }
        })
    })
    </script>
    <script>
    function change_last_year(val, id) {
        if (val != '') {
            data = '';
            data += '<option value="">Finish Year</option>';
            for (i = val; i <= <?=date('Y')?>; i++) {
                data += '<option value="' + i + '">' + i + '</option>'
            }
            $("#" + id).html(data);
        } else {
            data = '';
            data += '<option value="">Finish Year</option>';
            for (i = <?=date('Y')-30?>; i <= <?=date('Y')?>; i++) {
                data += '<option value="' + i + '">' + i + '</option>'
            }
            $("#" + id).html(data);
        }
    }
    </script>
    <script>
    function change_refused(val) {
        $("#refused_date_change").html(val + " Date");
    }
    </script>


    <script>
    $("#exam_section_exam_name").change(function() {
        examval = $(this).val();
        if (examval != '') {
            $("#exam_section_score").removeAttr('readonly', 'readonly');
            $("#value1").removeAttr('readonly', 'readonly');
            $("#value2").removeAttr('readonly', 'readonly');
            $("#value3").removeAttr('readonly', 'readonly');
            $("#value4").removeAttr('readonly', 'readonly');
            $("#exam_section_score").addClass('required');
            if (examval == 'GRE') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');

                $("#value1_label").html('Analytical Reasoning');
                $("#value2_label").html('Quantitative Reasoning');
                $("#value3_label").html('Verbal Reasoning');

                $("#value4").removeClass('required');
                $("#value4").attr('readonly', 'readonly');

                $("#value1").attr('placeholder', 'Analytical Reasoning');
                $("#value2").attr('placeholder', 'Quantitative Reasoning');
                $("#value3").attr('placeholder', 'Verbal Reasoning');

            } else if (examval == 'GMAT') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');
                $("#value4").addClass('required');

                $("#value1_label").html('Analytical Reasoning');
                $("#value2_label").html('Integrated Reasoning');
                $("#value3_label").html('Quantitative');
                $("#value4_label").html('Verbal');

                $("#value1").attr('placeholder', 'Analytical Reasoning');
                $("#value2").attr('placeholder', 'Integrated Reasoning');
                $("#value3").attr('placeholder', 'Quantitative');

                $("#value4").addClass('required');

                $("#value4").removeAttr('readonly');
            } else if (examval == 'SAT') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');

                $("#value1_label").html('Writing');
                $("#value2_label").html('Critical Reading');
                $("#value3_label").html('Mathematics ');

                $("#value4").removeClass('required');
                $("#value4").attr('readonly', 'readonly');

                $("#value1").attr('placeholder', 'Writing');
                $("#value2").attr('placeholder', 'Critical Reading');
                $("#value3").attr('placeholder', 'Mathematics');
            }
        } else {
            $("#exam_section_score").removeClass('required');
            $("#value1").removeClass('required');
            $("#value2").removeClass('required');
            $("#value3").removeClass('required');
            $("#value4").removeClass('required');

            $("#exam_section_score").attr('readonly', 'readonly');
            $("#value1").attr('readonly', 'readonly');
            $("#value2").attr('readonly', 'readonly');
            $("#value3").attr('readonly', 'readonly');
            $("#value4").attr('readonly', 'readonly');
        }

    })

    var addButtonns = $('.add_exam_section_button');
    var wrapperrs = $('#exam_section_add');
    <?php
                if(isset($_POST['exam_section'])){ ?>
    var p = <?php echo $lds-1; ?>;
    <?php }else{?>
    var p = 0;
    <?php }?>
    maxField = 10;
    $(addButtonns).click(function() {
        if (p < maxField) {
            p++;
            $(wrapperrs).append(
                '<div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Exam Name</div><select name="exam_section[' +
                p + '][exam_name]" id="exam_section_exam_name' + p +
                '" class="form-control"><option value="">Select</option><option value="GRE">GRE</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value1_label' +
                p +
                '">Analytical Reasoning</div><input type="number" class="form-control" placeholder="Analytical Reasoning" id="value1' +
                p + '" name="exam_section[' + p +
                '][value1]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value2_label' +
                p +
                '">Integrated Reasoning</div><input type="number" class="form-control" placeholder="Integrated Reasoning" id="value2' +
                p + '" name="exam_section[' + p +
                '][value2]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value3_label' +
                p +
                '">Quantitative</div><input type="number" class="form-control" placeholder="Quantitative" id="value3' +
                p + '" name="exam_section[' + p +
                '][value3]" value=""readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value4_label' +
                p +
                '">Verbal</div><input type="number" class="form-control" placeholder="Verbal" id="value4' +
                p + '" name="exam_section[' + p +
                '][value4]" value=""readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="exam_section_score_label' +
                p +
                '">Overall Score</div><input type="number" class="form-control" placeholder="Overall Score" id="exam_section_score' +
                p +
                '" name="exam_section[' +
                p + '][scrore]" value=""readonly></div></div></div><a class="remove_field">x</a></div>');



            $("#exam_section_exam_name" + p).change(function() {
                examval = $(this).val();
                if (examval != '') {
                    $("#exam_section_score" + p).removeAttr('readonly', 'readonly');
                    $("#value1" + p).removeAttr('readonly', 'readonly');
                    $("#value2" + p).removeAttr('readonly', 'readonly');
                    $("#value3" + p).removeAttr('readonly', 'readonly');
                    $("#value4" + p).removeAttr('readonly', 'readonly');
                    $("#exam_section_score").addClass('required');
                    if (examval == 'GRE') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');

                        $("#value1_label" + p).html('Analytical Reasoning');
                        $("#value2_label" + p).html('Quantitative Reasoning');
                        $("#value3_label" + p).html('Verbal Reasoning');

                        $("#value4" + p).removeClass('required');
                        $("#value4" + p).attr('readonly', 'readonly');

                        $("#value1" + p).attr('placeholder', 'Analytical Reasoning');
                        $("#value2" + p).attr('placeholder', 'Quantitative Reasoning');
                        $("#value3" + p).attr('placeholder', 'Verbal Reasoning');

                    } else if (examval == 'GMAT') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');
                        $("#value4" + p).addClass('required');

                        $("#value1_label" + p).html('Analytical Reasoning');
                        $("#value2_label" + p).html('Integrated Reasoning');
                        $("#value3_label" + p).html('Quantitative');
                        $("#value4_label" + p).html('Verbal');

                        $("#value1" + p).attr('placeholder', 'Analytical Reasoning');
                        $("#value2" + p).attr('placeholder', 'Integrated Reasoning');
                        $("#value3" + p).attr('placeholder', 'Quantitative');

                        $("#value4" + p).addClass('required');

                        $("#value4" + p).removeAttr('readonly');
                    } else if (examval == 'SAT') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');

                        $("#value1_label" + p).html('Writing');
                        $("#value2_label" + p).html('Critical Reading');
                        $("#value3_label" + p).html('Mathematics ');

                        $("#value4" + p).removeClass('required');
                        $("#value4" + p).attr('readonly', 'readonly');

                        $("#value1" + p).attr('placeholder', 'Writing');
                        $("#value2" + p).attr('placeholder', 'Critical Reading');
                        $("#value3" + p).attr('placeholder', 'Mathematics');
                    }
                } else {
                    $("#exam_section_score" + p).removeClass('required');
                    $("#value1" + p).removeClass('required');
                    $("#value2" + p).removeClass('required');
                    $("#value3" + p).removeClass('required');
                    $("#value4" + p).removeClass('required');

                    $("#exam_section_score" + p).attr('readonly', 'readonly');
                    $("#value1" + p).attr('readonly', 'readonly');
                    $("#value2" + p).attr('readonly', 'readonly');
                    $("#value3" + p).attr('readonly', 'readonly');
                    $("#value4" + p).attr('readonly', 'readonly');
                }

            });
        }
    });

    $(wrapperrs).on('click', '.remove_field', function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
    </script>

    <script>
    $(document).ready(function() {
        $(".change-date").change(function() {
            var val = $(this).val();
            if (val != '') {
                $(this).removeClass('required');
                $(this).next('.error').hide();
                $(this).css("color", "black");
            } else {
                $(this).addClass('required');
                $(this).next('.error').show();
                $(this).css("color", "red");
            }
        });
    });
    </script>
    <script>
    function change_counsellor(id) {
        $.ajax({
            type: "post",
            url: "controller.php",
            data: {
                'change_counsellor_id': id
            },
            success: function(data) {
                $("#councellor_id").html(data);
            }
        });
        $.ajax({
            type: "post",
            url: "controller.php",
            data: {
                'change_management_member': id
            },
            success: function(data) {
                $("#management_member").html(data);
            }
        });
    }
    </script>
    <script>
    $("#applicant_contact_no").change(function() {
        appcontactNo = $(this).val();
        $("#err_applicant_contact_no").show();
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                mobile: appcontactNo,
                id: '<?=base64_decode(base64_decode(base64_decode($_REQUEST['id'])))?>',
                type: 'checkContactNumbers'
            },
            beforeSend: function() {},
            success: function(response) {
                if (response == 1) {
                    $("#err_applicant_contact_no").html(
                        "Your contact number is already added.");
                    $("#applicant_contact_no").focus();
                    $("#submitbtn").attr('disabled', 'disabled');
                } else {
                    $("#err_applicant_contact_no").hide();
                    $("#submitbtn").removeAttr('disabled', 'disabled');
                }
            }
        });
    })
    $("#applicant_alternate_no").change(function() {
        appcontactNo = $(this).val();
        $("#err_applicant_alternate_no").show();
        contactNo = $("#applicant_contact_no").val();
        // if (appcontactNo == contactNo) {
        //     $("#err_applicant_alternate_no").html("Can not be same as phone number.");
        //     $("#applicant_contact_no").focus();
        //     $("#submitbtn").attr('disabled', 'disabled');
        // } else {

        $("#err_applicant_alternate_no").hide();
        $("#submitbtn").removeAttr('disabled', 'disabled');

        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                mobile: appcontactNo,
                id: '<?=base64_decode(base64_decode(base64_decode($_REQUEST['id'])))?>',
                type: 'checkContactNumbers'
            },
            beforeSend: function() {},
            success: function(response) {
                if (response == 1) {
                    $("#err_applicant_alternate_no").show();
                    $("#err_applicant_alternate_no").html(
                        "Your contact number is already added.");
                    $("#applicant_alternate_no").focus();
                    $("#submitbtn").attr('disabled', 'disabled');
                } else {
                    $("#err_applicant_alternate_no").hide();
                    $("#submitbtn").removeAttr('disabled', 'disabled');
                }
            }
        });
        // }

    })
    </script>
    <script>
    function change_validation_remark(val, date, id) {
        if (val == date) {
            $("#" + id).removeClass('required');
        } else {
            $("#" + id).addClass('required');
        }
    }
    </script>
    <script>
    function same_primary() {
        if ($("#same_as_primary_number").prop('checked')) {
            $("#applicant_alternate_no").val($("#applicant_contact_no").val());
        } else {
            $("#applicant_alternate_no").val('');
        }
    }

    $("#same_as_primary_number").on("change", same_primary);
    </script>
    <script>
    function change_university(val) {
        get = document.getElementById("visa_earlier1").checked;
        if (val.checked == 1 && get == 1) {
            $(".earlieruniversity").show();
            $(".earlieruniversity input").addClass('required');
        } else {
            $(".earlieruniversity").hide();
            $(".earlieruniversity input").removeClass('required');
            $("#university_name").val('');
            $("#course_name").val('');
        }
    }

    function change_university1(val) {
        get = document.getElementById("visa_earlier1").checked;
        earlier_country_id = $("#earlier_country_id").val();
        if (val.checked == 1 && get == 1 && earlier_country_id == 3) {
            $(".earlieruniversity").show();
            $(".earlieruniversity").show();
            $(".earlieruniversity input").addClass('required');
        } else {
            $(".earlieruniversity").hide();
            $(".earlieruniversity input").removeClass('required');
            $("#university_name").val('');
            $("#course_name").val('');
        }
    }
    </script>

    <script>
    function change_schedule(val) {
        if (val == 'Online') {
            $("#schedule_date_time_div").show();

            $("#enquiry_type_div").removeClass('col-md-6');
            $("#enquiry_type_div").addClass('col-md-3');
            $("#schedule_date_time").addClass('required');
        } else {
            $("#schedule_date_time").val('');
            $("#schedule_date_time_div").hide();
            $("#enquiry_type_div").removeClass('col-md-3');
            $("#enquiry_type_div").addClass('col-md-6');
            $("#schedule_date_time").removeClass('required');
        }
    }
    </script>
    <script>
    function get_family_fund(val) {
        if (val == 'Yes') {
            $("#family_fund_show").show();
            $("#available_funds").addClass('required');
        } else {
            $("#family_fund_show").hide();
            $("#available_funds").val('');
            $("#available_funds").removeClass('required');
        }
    }
    </script>
    <script>
    function change_earlier_country_id(val) {
        $(".earlieruniversity").hide();
        $(".earlieruniversity input").removeClass('required');
        $(".earlieruniversity input").val('');
        flexCheckChecked1 = document.getElementById('flexCheckChecked1').checked;
        flexCheckChecked2 = document.getElementById('flexCheckChecked2').checked;
        if (val == 3) {
            $("#embassy_show").show();
            $("#embassy").addClass('required');
            if (flexCheckChecked1 == true || flexCheckChecked2 == true) {
                $(".earlieruniversity").show();
                $(".earlieruniversity input").addClass('required');
            }
        } else {
            if (flexCheckChecked1 == true) {
                $(".earlieruniversity").show();
                $(".earlieruniversity input").addClass('required');
            }
            $("#embassy_show").hide();
            $("#embassy").val('');
            $("#embassy").removeClass('required');
        }

    }
    </script>
    <script>
    function change_country(val) {
        if (val == 7) {
            $("#change_country").html("Preferred Area");
            $("#change_state").html("Preferred Country");
            $("#pre_country_id option:first").text("Preferred Area");
            $("#pre_state_id option:first").text("Preferred Country");
        } else {
            $("#change_country").html("Preferred Country");
            $("#change_state").html("Preferred State");
            $("#pre_country_id option:first").text("Preferred Country");
            $("#pre_state_id option:first").text("Preferred State");
        }
    }
    </script>
</body>

</html>