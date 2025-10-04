<?php 
include('include/config.php');
include("include/functions.php");
validate_user();

if($_REQUEST['userDetails']=='yes'){
    
    $sql='';
    $stu_name=$obj->escapestring($_POST['stu_name']);
    if($stu_name!=''){
        $sql .= "stu_name='$stu_name'";
    }
    $type=$obj->escapestring($_POST['type']);
    if($type!=''){
        $sql .= " ,type='$type'";
    }
    $student_status=$obj->escapestring($_POST['student_status']);
    if($student_status!=''){
        $sql .= " ,student_status='$student_status'";
    }
    $dob=$obj->escapestring($_POST['dob']);
    if($dob!=''){
        $sql .= ",dob='$dob'";
    }
    $passport_no=$obj->escapestring($_POST['passport_no']);
    if($passport_no!=''){
        $sql .= ",passport_no='$passport_no'";
    }
    $country_id=$obj->escapestring($_POST['country_id']);
    if($country_id!=''){
        $sql .= ",country_id='$country_id'";
    }
    $pre_state_id=$obj->escapestring($_POST['pre_state_id']);
    if($pre_state_id!=''){
        $sql .= ",pre_state_id='$pre_state_id'";
    }

    $address=$obj->escapestring($_POST['address']);
    if($address!=''){
        $sql .= ",address='$address'";
    }
    $mcity_id=$obj->escapestring($_POST['mcity_id']);
    if($mcity_id!='1000' && $mcity_id!=''){
        $sql .= ",city_id='$mcity_id'";
    }
    $mstate_id=$obj->escapestring($_POST['mstate_id']);
    if($mstate_id!=''){
        $sql .= ",state_id='$mstate_id'";
    }
    $postalcode=$obj->escapestring($_POST['postalcode']);
    if($postalcode!=''){
        $sql .= ",postalcode='$postalcode'"; 
    }

    $visa_id=$obj->escapestring($_POST['visa_id']);
    if($visa_id!=''){ 
        $sql .= ",visa_id='$visa_id'";
    }
    $c_id=$obj->escapestring($_POST['c_id']);
    if($c_id!=''){
        $sql .= ",c_id='$c_id'";
        $enrollment_counselor_date = date('Y-m-d H:i:s');
        if($_POST['type'] == 'Registration'){
            $types = 'Registered';
        }else{
            $types = $_POST['type'];
        }
        $obj->query("update $tbl_visit set visit_status='$types',enrollment_counselor='$c_id', enrollment_counselor_date='$enrollment_counselor_date' where id='".base64_decode(base64_decode(base64_decode($_GET['vid'])))."'",-1); //die;
    }
    $student_type=$obj->escapestring($_POST['student_type']);
    if($student_type!=''){
        $sql .= ",student_type='$student_type'";
        if($student_type == 24 || $student_type == 25){
            $sql .= ",university_transfer='1'";
        }
    }
    
    
    $student_contact_no=$obj->escapestring($_POST['student_contact_no']);
    if($student_contact_no!=''){
        $sql .= ",student_contact_no='$student_contact_no'";
    }
    
    $branch_id=$obj->escapestring($_POST['branch_id']);
    if($branch_id!=''){
        $sql .= ",branch_id='$branch_id'";
    }
    $alternate_contact=$obj->escapestring($_POST['alternate_contact']);
    if($alternate_contact!=''){
        $sql .= ",alternate_contact='$alternate_contact'";
    }

    $cdate=$obj->escapestring($_POST['cdate']);
    if($cdate!=''){
        $sql .= ",cdate='$cdate'";
    }
    $crm_executive_id=$obj->escapestring($_POST['crm_executive_id']);
    if($crm_executive_id!=''){
        $sql .= ",crm_executive_id='$crm_executive_id'";
    }
    
    //echo $sql; die;
    // $branch_id = getField('branch_id','tbl_admin',$c_id);
    // if($branch_id!=''){
    //     $sql .= ",branch_id='$branch_id'";
    // }
    if($mcity_id==1000){
        $city_name=$obj->escapestring($_POST['city_name']);
        $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$mstate_id'",-1); //die;
        $city_id = $obj->lastInsertedId();
        $sql .= ",city_id='$city_id'";
    }
    $sqll=$obj->query("select * from $tbl_student where 1=1 and reapply_status='0' order by id desc",-1); //die();
    $result=$obj->fetchNextObject($sqll);
    $parts = explode("IBT", $result->student_no);
    $student_no=codeGenerate($parts[1]);

    if($student_no!=''){
        $sql .= ",student_no='$student_no'";
    }

    $am_id=$obj->escapestring($_POST['am_id']);

    if($am_id==''){
        $sql .= ",am_id='0'";
    }else{
        if($_SESSION['level_id']==3){
            $am_id=$_SESSION['sess_admin_id'];
            $sql .= ",am_id='$am_id'";
        }else{
            $sql .= ",am_id='$am_id'";
        }
    }
    

    $ten_start_year=$obj->escapestring($_POST['ten_start_year']); 
    if ($ten_start_year!='') {
        $sql .= ",ten_start_year='$ten_start_year'";
    }

     $uk_premium_fee=$obj->escapestring($_POST['uk_premium_fee']); 
    if ($uk_premium_fee!='') {
        $sql .= ",uk_premium_fee='$uk_premium_fee'";
    }
    $embassy_prority_fee=$obj->escapestring($_POST['embassy_prority_fee']); 
    if ($embassy_prority_fee!='') {
        $sql .= ",embassy_prority_fee='$embassy_prority_fee'";
    }
    $includes_priority_fess=$obj->escapestring($_POST['includes_priority_fess']); 
    if ($includes_priority_fess!='') {
        $sql .= ",includes_priority_fess='$includes_priority_fess'";
    }
    $screening_interview_by=$obj->escapestring($_POST['screening_interview_by']); 
    if ($screening_interview_by!='') {
        $sql .= ",screening_interview_by='$screening_interview_by'";
    }
    $screening_interview_score=$obj->escapestring($_POST['screening_interview_score']); 
    if ($screening_interview_score!='') {
        $sql .= ",screening_interview_score='$screening_interview_score'";
    }
    $student_qualify_cas=$obj->escapestring($_POST['student_qualify_cas']); 
    if ($student_qualify_cas!='') {
        $sql .= ",student_qualify_cas='$student_qualify_cas'";
    }

    $uk_premium_fee_type=$_POST['uk_premium_fee_type']; 
    if (is_array($uk_premium_fee_type) && count($uk_premium_fee_type) > 0 && $uk_premium_fee_type!='') {
        $uk_premium_fee_type = implode(',',$uk_premium_fee_type);
        $sql .= ",uk_premium_fee_type='$uk_premium_fee_type'";
    }
	$cash_deposit=$obj->escapestring($_POST['cash_deposit']);
	if($cash_deposit!=''){
		$sql .= ",cash_deposit='$cash_deposit'";
	}
    $ten_end_year=$obj->escapestring($_POST['ten_end_year']); 
    if ($ten_end_year!='') {
        $sql .= ",ten_end_year='$ten_end_year'";
    }

    $ten_stream=$obj->escapestring($_POST['ten_stream']); 
    if ($ten_stream!='') {
        $sql .= ",ten_stream='$ten_stream'";
    }

    $ten_percent=$obj->escapestring($_POST['ten_percent']); 
    if ($ten_percent!='') {
        $sql .= ",ten_percent='$ten_percent'";
    }

    $twl_start_year=$obj->escapestring($_POST['twl_start_year']); 
    if ($twl_start_year!='') {
        $sql .= ",twl_start_year='$twl_start_year'";
    }
    $twl_end_year=$obj->escapestring($_POST['twl_end_year']); 
    if ($twl_end_year!='') {
        $sql .= ",twl_end_year='$twl_end_year'";
    }

    $twl_stream=$obj->escapestring($_POST['twl_stream']); 
    if ($twl_stream!='') {
        $sql .= ",twl_stream='$twl_stream'";
    }

    $twl_percent=$obj->escapestring($_POST['twl_percent']); 
    if ($twl_percent!='') {
        $sql .= ",twl_percent='$twl_percent'";
    }

    $dip_start_year=$obj->escapestring($_POST['dip_start_year']); 
    if ($dip_start_year!='') {
        $sql .= ",dip_start_year='$dip_start_year'";
    }
    $dip_end_year=$obj->escapestring($_POST['dip_end_year']); 
    if ($dip_end_year!='') {
        $sql .= ",dip_end_year='$dip_end_year'";
    }

    $dip_stream=$obj->escapestring($_POST['dip_stream']); 
    if ($dip_stream!='') {
        $sql .= ",dip_stream='$dip_stream'";
    }


    $matri_board=$obj->escapestring($_POST['matri_board']);
	if($matri_board!=''){
		$sql .= ",matri_board='$matri_board'";
	}
	$secondary_board=$obj->escapestring($_POST['secondary_board']);
	if($secondary_board!=''){
		$sql .= ",secondary_board='$secondary_board'";
	}
	$diploma_board=$obj->escapestring($_POST['diploma_board']);
	if($diploma_board!=''){
		$sql .= ",diploma_board='$diploma_board'";
	}
	$diploma_board2=$obj->escapestring($_POST['diploma_board2']);
	if($diploma_board2!=''){
		$sql .= ",diploma_board2='$diploma_board2'";
	}
	$bachelor_board=$obj->escapestring($_POST['bachelor_board']);
	if($bachelor_board!=''){
		$sql .= ",bachelor_board='$bachelor_board'";
	}
	$bachelor_board2=$obj->escapestring($_POST['bachelor_board2']);
	if($bachelor_board2!=''){
		$sql .= ",bachelor_board2='$bachelor_board2'";
	}
	$master_board=$obj->escapestring($_POST['master_board']);
	if($master_board!=''){
		$sql .= ",master_board='$master_board'";
	}
	$master_board2=$obj->escapestring($_POST['master_board2']);
	if($master_board2!=''){
		$sql .= ",master_board2='$master_board2'";
	}

$passport_f_name=$obj->escapestring($_POST['passport_f_name']); 
    if ($passport_f_name!='') {
        $sql .= ",passport_f_name='$passport_f_name'";
    }
    $passport_l_name=$obj->escapestring($_POST['passport_l_name']); 
    if ($passport_l_name!='') {
        $sql .= ",passport_l_name='$passport_l_name'";
    }
    $passport_issue_date=$obj->escapestring($_POST['passport_issue_date']); 
    if ($passport_issue_date!='') {
        $sql .= ",passport_issue_date='$passport_issue_date'";
    }
    $passport_expiry_date=$obj->escapestring($_POST['passport_expiry_date']); 
    if ($passport_expiry_date!='') {
        $sql .= ",passport_expiry_date='$passport_expiry_date'";
    }
    $passport_place_of_birth=$obj->escapestring($_POST['passport_place_of_birth']); 
    if ($passport_place_of_birth!='') {
        $sql .= ",passport_place_of_birth='$passport_place_of_birth'";
    }   

    

    $dip_percent=$obj->escapestring($_POST['dip_percent']); 
    if ($dip_percent!='') {
        $sql .= ",dip_percent='$dip_percent'";
    }


    $dip1_start_year=$obj->escapestring($_POST['dip1_start_year']); 
    if ($dip1_start_year!='') {
        $sql .= ",dip1_start_year='$dip1_start_year'";
    }
    $dip1_end_year=$obj->escapestring($_POST['dip1_end_year']); 
    if ($dip1_end_year!='') {
        $sql .= ",dip1_end_year='$dip1_end_year'";
    }

    $dip1_stream=$obj->escapestring($_POST['dip1_stream']); 
    if ($dip1_stream!='') {
        $sql .= ",dip1_stream='$dip1_stream'";
    }

    $dip1_percent=$obj->escapestring($_POST['dip1_percent']); 
    if ($dip_percent!='') {
        $sql .= ",dip1_percent='$dip1_percent'";
    }


    $grd_start_year=$obj->escapestring($_POST['grd_start_year']); 
    if ($grd_start_year!='') {
        $sql .= ",grd_start_year='$grd_start_year'";
    }
    $grd_end_year=$obj->escapestring($_POST['grd_end_year']); 
    if ($grd_end_year!='') {
        $sql .= ",grd_end_year='$grd_end_year'";
    }

    $grd_stream=$obj->escapestring($_POST['grd_stream']); 
    if ($grd_stream!='') {
        $sql .= ",grd_stream='$grd_stream'";
    }

    $grd_percent=$obj->escapestring($_POST['grd_percent']); 
    if ($grd_percent!='') {
        $sql .= ",grd_percent='$grd_percent'";
    }


    $grd1_start_year=$obj->escapestring($_POST['grd1_start_year']); 
    if ($grd1_start_year!='') {
        $sql .= ",grd1_start_year='$grd1_start_year'";
    }
    $grd1_end_year=$obj->escapestring($_POST['grd1_end_year']); 
    if ($grd1_end_year!='') {
        $sql .= ",grd1_end_year='$grd1_end_year'";
    }

    $grd1_stream=$obj->escapestring($_POST['grd1_stream']); 
    if ($grd1_stream!='') {
        $sql .= ",grd1_stream='$grd1_stream'";
    }

    $grd1_percent=$obj->escapestring($_POST['grd1_percent']); 
    if ($grd1_percent!='') {
        $sql .= ",grd1_percent='$grd1_percent'";
    }

    $pgrd_start_year=$obj->escapestring($_POST['pgrd_start_year']); 
    if ($pgrd_start_year!='') {
        $sql .= ",pgrd_start_year='$pgrd_start_year'";
    }
    $pgrd_end_year=$obj->escapestring($_POST['pgrd_end_year']); 
    if ($pgrd_end_year!='') {
        $sql .= ",pgrd_end_year='$pgrd_end_year'";
    }

    $pgrd_stream=$obj->escapestring($_POST['pgrd_stream']); 
    if ($pgrd_stream!='') {
        $sql .= ",pgrd_stream='$pgrd_stream'";
    }

    $pgrd_percent=$obj->escapestring($_POST['pgrd_percent']); 
    if ($pgrd_percent!='') {
        $sql .= ",pgrd_percent='$pgrd_percent'";
    }

    $pgdrd_start_year=$obj->escapestring($_POST['pgdrd_start_year']); 
    if ($pgdrd_start_year!='') {
        $sql .= ",pgdrd_start_year='$pgdrd_start_year'";
    }
    $pgdrd_end_year=$obj->escapestring($_POST['pgdrd_end_year']); 
    if ($pgdrd_end_year!='') {
        $sql .= ",pgdrd_end_year='$pgdrd_end_year'";
    }

    $pgdrd_stream=$obj->escapestring($_POST['pgdrd_stream']); 
    if ($pgdrd_stream!='') {
        $sql .= ",pgdrd_stream='$pgdrd_stream'";
    }

    $pgdrd_percent=$obj->escapestring($_POST['pgdrd_percent']); 
    if ($pgdrd_percent!='') {
        $sql .= ",pgdrd_percent='$pgdrd_percent'";
    }

    $course_recomandateion_one=$obj->escapestring($_POST['course_recomandateion_one']); 
    if ($course_recomandateion_one!='') {
        $sql .= ",course_recomandateion_one='$course_recomandateion_one'";
    }

    $course_recomandateion_two=$obj->escapestring($_POST['course_recomandateion_two']); 
    if ($course_recomandateion_two!='') {
        $sql .= ",course_recomandateion_two='$course_recomandateion_two'";
    }
    $special_remarks=$obj->escapestring($_POST['special_remarks']); 
    if ($special_remarks!='') {
        $sql .= ",special_remarks='$special_remarks'";
    }
    $intake=$obj->escapestring($_POST['intake']); 
    if ($intake!='') {
        $sql .= ",intake='$intake'";
    }
    $intake_year=$obj->escapestring($_POST['intake_year']); 
    if ($intake_year!='') {
        $sql .= ",intake_year='$intake_year'";
    }
    $application_b1_b2=$obj->escapestring($_POST['application_b1_b2']); 
    if ($application_b1_b2!='') {
        $sql .= ",application_b1_b2='$application_b1_b2'";
    }

if($_REQUEST['id']=='' ){
    $obj->query("insert into $tbl_student set $sql",-1); //die;
    $last_id = $obj->lastInsertedId();
    
    $insert =  $obj->query("update $tbl_lead set status='0' where applicant_contact_no='$student_contact_no' or applicant_alternate_no='$student_contact_no' or applicant_contact_no = '$alternate_contact' or applicant_alternate_no = '$alternate_contact'",-1);
    $insert =  $obj->query("update $tbl_visit set status='0' where applicant_contact_no='$student_contact_no' or applicant_alternate_no='$student_contact_no' or applicant_contact_no = '$alternate_contact' or applicant_alternate_no = '$alternate_contact'",-1);


    $dataResult = $_POST['uniRecommended'];
    $data = $_POST['data'];
    $data2 = $_POST['data2'];
    $data3 = $_POST['data3'];
    $epresult = $_POST['epresult'];
    $weresult = $_POST['weresult'];
    $relation = $_POST['relation'];
    $courseRecommended = $_POST['courseRecommended'];

    if ($courseRecommended!='') {
        if(count($courseRecommended)>0){
            $sql="delete from $tbl_student_course where stu_id='".$last_id."'"; 
            $obj->query($sql);
            foreach($courseRecommended as $val){
                if($val['course_name'] != ''){
                $obj->query("insert into $tbl_student_course set stu_id='$last_id', course_name='".$val['course_name']."'",-1);//die;
                }
            }
        }
    }

    if(count($relation)>0){        
        foreach($relation as $val){
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $relation = $val['relation'];
            if($relation!=''){
                $sql .= ",relation='$relation'";
            }
            $name = $val['name'];
            if($name!=''){
                $sql .= ",name='$name'";
            }
            $contact_no = $val['contact_no'];
            if($contact_no!=''){
                $sql .= ",contact_no='$contact_no'";
            }
            $email = $val['email'];
            if($email!=''){
                $sql .= ",email='$email'";
            }
            $sponser = $val['sponser'];
            if($sponser!=''){
                $sql .= ",sponser='$sponser'";
            }
            $dob = $val['dob'];
            if($dob!=''){
                $sql .= ",dob='$dob'";
            }
            
            if(!empty($relation)){
                $obj->query("insert into $tbl_student_relation set $sql",-1);//die;
            }
        }
    }

    if(count($dataResult)>0){        
        foreach($dataResult as $val){
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $state_id = $val['state_id'];
            if($state_id!=''){
                $sql .= ",state_id='$state_id'";
            }
            $univercity_id = $val['university_id'];
            if($univercity_id!=''){
                $sql .= ",univercity_id='$univercity_id'";
            }
            $course_id = $val['course_id'];
            if($course_id!=''){
                $sql .= ",course_id='$course_id'";
            }
            $month = $val['intake'];
            if($month!=''){
                $sql .= ",month='$month'";
            }
            $year = $val['year'];
            if($year!=''){
                $sql .= ",year='$year'";
            }
            if(!empty($val['course_id'])){
            	$obj->query("insert into $tbl_student_univercity_course set $sql",-1);//die;
        	}
        }
    }


    if(isset($data) && count($data)>0){
       
        foreach($data as $i => $dataVal){            
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $diploma_id = $dataVal['diploma_id'];
            if($diploma_id!=''){
                $sql .= ",diploma_id='$diploma_id'";
            }
                      
            $start_date = $dataVal['start_date'];
            if($start_date!=''){
                $sql .= ",start_date='$start_date'";
            }
            $end_date = $dataVal['end_date'];
            if($end_date!=''){
                $sql .= ",end_date='$end_date'";
            }
            $time_duration = $dataVal['time_duration'];
            if($time_duration!=''){
                $sql .= ",time_duration='$time_duration'";
            }
            $status = $dataVal['status'];
            if($status!=''){
                $sql .= ",status='$status'";
            }

            $slip_number = $dataVal['slip_number'];
            if($slip_number!=''){
                $sql .= ",slip_number='$slip_number'";
            }

            $mother_name = $dataVal['mother_name'];
            if($mother_name!=''){
                $sql .= ",mother_name='$mother_name'";
            }

            $stu_contact_number = $dataVal['stu_contact_number'];
            if($stu_contact_number!=''){
                $sql .= ",stu_contact_number='$stu_contact_number'";
            }

            $imp_remarks = $dataVal['imp_remarks'];
            if($imp_remarks!=''){
                $sql .= ",imp_remarks='$imp_remarks'";
            }
            $registration_no = 1;

            //=====================================================================================================
            if($status=='send_request'){
                $sdsql=$obj->query("select * from $tbl_student_diploma where 1=1 order by id desc",-1); //die();
                $sdresult=$obj->fetchNextObject($sdsql);
                $partss = explode("IBT", $sdresult->registration_no);
                $registration_no=codeGenerate($partss[1]);

                if($registration_no!=''){
                    $sql .= ",registration_no='$registration_no'";
                }


                $rno1 = explode("IBT", $sdresult->registration_no);
                $rollno1=codeGenerate($rno1[1]);
                $rollno2=codeGenerate($rno1[1]);
                $sdyear = CalculateRollTime($start_date,$end_date);
               
                if($sdyear >= 1){
                    $sql .= ",roll_no_1='$rollno1'";
                }
                if($sdyear >= 2){
                    $sql .= ",roll_no_2='$rollno2'";
                }
            }
            //===================================================================================================
            if(isset($_FILES['data']['name'][$i]))
            {
                $filename = explode('.',$_FILES['data']['name'][$i]['photo']);
                $photoName = generateSlug($filename[0]);                
                $fileNameNew = $photoName . ".$filename[1]";
                
                if($fileNameNew!=''){
                    $sql .= ",photo='$fileNameNew'";
                }

                $sfilename = explode('.',$_FILES['data']['name'][$i]['dr_slip_photo']);
                $slipphotoName = generateSlug($sfilename[0]);               
                $slipfileNameNew = $slipphotoName . ".$sfilename[1]";
                
                if($slipfileNameNew!=''){
                    $sql .= ",slip_photo='$slipfileNameNew'";
                }

                move_uploaded_file($_FILES['data']['tmp_name'][$i]['photo'], 'uploads/' . $fileNameNew);
                move_uploaded_file($_FILES['data']['tmp_name'][$i]['dr_slip_photo'], 'uploads/' . $slipfileNameNew);
            }
            if(!empty($dataVal['diploma_id'])){
            	$obj->query("insert into $tbl_student_diploma set $sql",-1);//die;
            }
    		
    	}
    }
   
    if(isset($data2) && count($data2)>0){
        foreach($data2 as $i => $dataVal){
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            
            $designation_id = $dataVal['designation_id'];
            if($designation_id!=''){
                $sql .= ",designation_id='$designation_id'";
            }            
            $start_date = $dataVal['start_date'];
            if($start_date!=''){
                $sql .= ",start_date='$start_date'";
            }
            $end_date = $dataVal['end_date'];
            if($end_date!=''){
                $sql .= ",end_date='$end_date'";
            }
            $time_duration = $dataVal['time_duration'];
            if($time_duration!=''){
                $sql .= ",time_duration='$time_duration'";
            }
            $status = $dataVal['status'];
            if($status!=''){
                $sql .= ",status='$status'";
            }
            $slip_number = $dataVal['slip_number'];
            if($slip_number!=''){
                $sql .= ",slip_number='$slip_number'";
            }
            $stu_contact_number = $dataVal['stu_contact_number'];
            if($stu_contact_number!=''){
                $sql .= ",stu_contact_number='$stu_contact_number'";
            }
            $salary = $dataVal['salary'];
            if($salary!=''){
                $sql .= ",salary='$salary'";
            }
            $issue_date = $dataVal['issue_date'];
            if($issue_date!=''){
                $sql .= ",issue_date='$issue_date'";
            }
            $imp_remarks = $dataVal['imp_remarks'];
            if($imp_remarks!=''){
                $sql .= ",imp_remarks='$imp_remarks'";
            }

            // echo "<pre>";
            // print_r($_FILES['data2']); die;
            if(isset($_FILES['data2']['name'][$i]))
            {

                $sfilename = explode('.',$_FILES['data2']['name'][$i]['er_slip_photo']);
                $slipphotoName = generateSlug($sfilename[0]);               
                $slipfileNameNew = $slipphotoName . ".$sfilename[1]";
                
                if($slipfileNameNew!=''){
                    $sql .= ",slip_photo='$slipfileNameNew'";
                }

                move_uploaded_file($_FILES['data2']['tmp_name'][$i]['er_slip_photo'], 'uploads/' . $slipfileNameNew);
            }
            //echo $sql; die;

            if(!empty($dataVal['designation_id'])){
            	$obj->query("insert into $tbl_student_experience set $sql",-1); //die;
            }
            
        }
    }

    if(isset($data3) && count($data3)>0){
        foreach($data3 as $dataVal){+
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $amount = $dataVal['amount'];
            if($amount!=''){
                $sql .= ",amount='$amount'";
            }
            $notes = $dataVal['notes'];
            if($notes!=''){
                $sql .= ",notes='$notes'";
            }
            $stu_status = $dataVal['status'];
            if($stu_status!=''){
                $sql .= ",stu_status='$stu_status'";
            }
            if(!empty($dataVal['amount'])){
            	$obj->query("insert into $tbl_student_found set $sql",-1); //die;
        	}
        }
    }

    $an = 1;
    if(count($epresult)>0){        
        foreach($epresult as $epval){
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $course = $epval['course'];
            if($course!=''){
                $sql .= ",course='$course'";
            }
            $wirting = $epval['wirting'];
            if($wirting!=''){
                $sql .= ",wirting='$wirting'";
            }
            $reading = $epval['reading'];
            if($reading!=''){
                $sql .= ",reading='$reading'";
            }
            $listening = $epval['listening'];
            if($listening!=''){
                $sql .= ",listening='$listening'";
            }
            $speaking = $epval['speaking'];
            if($speaking!=''){
                $sql .= ",speaking='$speaking'";
            }
            $overall_bands = $epval['overall_bands'];
            if($overall_bands!=''){
                $sql .= ",overall_bands='$overall_bands'";
            }
            $exam_date = $epval['exam_date'];
            if($exam_date!=''){
                $sql .= ",exam_date='$exam_date'";
            }
            $login_id = $epval['login_id'];
            if($login_id!=''){
                $sql .= ",login_id='$login_id'";
            }
            $password = $epval['password'];
            if($password!=''){
                $sql .= ",password='$password'";
            }
            
            if(!empty($epval['course'])){
            	$obj->query("insert into $tbl_student_english_proficiency set $sql",-1);//die;
            }            
            echo $an++;
        }
    }


    $an = 1;
    if(count($weresult)>0){        
        foreach($weresult as $weval){
            $sql='';
            $sutdent_id = $last_id;
            if($sutdent_id!=''){
                $sql .= "sutdent_id='$sutdent_id'";
            }
            $company_name = $weval['company_name'];
            if($company_name!=''){
                $sql .= ",company_name='$company_name'";
            }
            $designation = $weval['designation'];
            if($designation!=''){
                $sql .= ",designation='$designation'";
            }
            $start_date = $weval['start_date'];
            if($start_date!=''){
                $sql .= ",start_date='$start_date'";
            }
           
            $end_date = $weval['end_date'];
            if($end_date!=''){
                $sql .= ",end_date='$end_date'";
            }
            
            if(!empty($weval['company_name'])){
                $obj->query("insert into $tbl_student_work_experience set $sql",-1);//die;
            }     
            $sql='';       
            echo $an++;
        }
    }

   
    $_SESSION['sess_msg']='Student added sucessfully';

}else{ 
    $obj->query("update $tbl_student set stu_name='$stu_name',father_name='$father_name',dob='$dob',passport_no='$passport_no',country_id='$country_id',visa_id='$visa_id' where id=".$_REQUEST['id']);
    $_SESSION['sess_msg']='Student updated sucessfully';   
}

header("location:student-list.php");
exit();
}      

if($_REQUEST['id']!=''){
    $sql=$obj->query("select * from $tbl_student where id=".$_REQUEST['id']);
    $result=$obj->fetchNextObject($sql);
}

if($_REQUEST['vid']!=''){
    $vid = base64_decode(base64_decode(base64_decode($_REQUEST['vid'])));
    $vSql = $obj->query("select * from $tbl_visit where id='$vid'");
    $vResult = $obj->fetchNextObject($vSql);

    $vSql_f = $obj->query("select * from $tbl_visit_fee where visit_id='$vid'");
    $vResult_f = $obj->fetchNextObject($vSql_f);
}else{
    $vReslt='';
    $vResult_f = ''; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .form-margin .form-group {
        margin-right: 15px;
    }

    .removeuniclss {
        position: absolute;
        top: 3px;
        right: -12px;
        font-size: 20px;
    }

    .label-required1,
    .label-required2,
    .label-required3 {
        position: relative;
    }

    .label-required1 label.error {
        position: absolute !important;
        bottom: -1px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 146px !important;
    }

    .label-required2 label.error {
        position: absolute !important;
        bottom: -1px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 180px !important;
    }

    .label-required3 label.error {
        position: absolute !important;
        bottom: -1px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 223px !important;
    }
    </style>

    <?php include('head.php'); ?>
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
                    <h4 class="my-3">Add Student</h4>
                    <form method="post" action="" name="studentfrm" id="studentfrm" enctype="multipart/form-data">
                        <input type="hidden" name="type" id="type" value="<?=$_GET['type']?>">
                        <input type="hidden" name="student_status" id="student_status"
                            value="<?=base64_decode($_GET['status'])?>">
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="vid" id="vid" value="<?php echo stripslashes($vResult->id); ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Name</div>
                                        <input type="text" class="required form-control" placeholder="Student Name"
                                            name="stu_name" id="stu_name"
                                            value="<?php echo stripslashes($vResult->applicant_name); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Contact No&nbsp;&nbsp;&nbsp;</div>
                                        <input type="text" class="form-control" placeholder="Student Contact No"
                                            name="student_contact_no" id="student_contact_no"
                                            value="<?php echo stripslashes($vResult->applicant_contact_no); ?>"
                                            maxlength="10" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Alternate Number</div>
                                        <input type="text" class="required form-control" placeholder="Alternate Number"
                                            name="alternate_contact" id="alternate_contact"
                                            value="<?php echo stripslashes($vResult->applicant_alternate_no); ?>"
                                            maxlength="10">
                                    </div>
                                    <span id="err_alternate_contact" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">D.O.B</div>
                                        <input type="date" class="required form-control" placeholder="Date Of Birth"
                                            name="dob" id="dob" value="<?php echo stripslashes($vResult->dob); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Passport No.&nbsp;&nbsp;</div>
                                        <input type="text" class="required form-control" placeholder="Passport No."
                                            name="passport_no" id="passport_no" value="" maxlength="8" size="8">
                                    </div>
                                </div>
                                <p id="showSearchResult" style="color:red;"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="change_country"><?=$vResult->pre_country_id == 7 ? 'Area' : 'Country'?></div>
                                        <select class="required form-control" name="country_id" id="country_id"
                                            onchange="change_type();change_country(this.value)">
                                            <option value="">Select <?=$vResult->pre_country_id == 7 ? 'Area' : 'Country'?></option>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($vResult->pre_country_id==$line->id){?>selected<?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="change_state">Preferred
                                            <?=$vResult->pre_country_id == 7 ? 'Country' : 'State'?>
                                            (Optional)
                                        </div>

                                        <select class="form-control" name="pre_state_id" id="pre_state_id">
                                            <option value="">Select
                                                <?=$vResult->pre_country_id == 7 ? 'Country' : 'State'?></option>
                                            <?php
                                            if($vResult->pre_country_id!=''){
                                                $stateSql=$obj->query("select * from $tbl_state where 1=1 and status=1 and country_id='".$vResult->pre_country_id."' group by state",-1);
                                                while($stateResult=$obj->fetchNextObject($stateSql)){?>
                                            <option value="<?php echo $stateResult->id ?>"
                                                <?php if($vResult->pre_state_id==$stateResult->id){?> selected
                                                <?php } ?>><?php echo $stateResult->state; ?></option>
                                            <?php } 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Visa Type</div>
                                        <select class="required form-control" name="visa_id" id="visa_id"
                                            onchange="change_type()">
                                            <option value="">Select Visa Type</option>
                                            <option value="1" <?php if($vResult->visa_type=='Study'){?> selected
                                                <?php } ?>>Study Visa</option>
                                            <option value="2" <?php if($vResult->visa_type=='Visitior/tourist'){?>
                                                selected <?php } ?>>Tourist Visa</option>
                                            <option value="3" <?php if($vResult->visa_type=='Visitior/tourist'){?>
                                                selected <?php } ?>>Visitor Visa</option>
                                            <!-- <option value="4" <?php if($vResult->visa_type=='Work'){?> selected
                                                <?php } ?>>Work Visa</option> -->
                                            <option value="5" <?php if($vResult->visa_type=='Spouse'){?> selected
                                                <?php } ?>>Spouse Visa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Branch
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                        <?php
                                        $branchArr = explode(',',getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']));
                                        ?>
                                        <select class="form-control" name="branch_id" id="branch_id">
                                            <option value="">Select IBT Branch</option>
                                            <?php

                                            $csql=$obj->query("select * from $tbl_branch where 1=1 and status=1 group by name",-1);
                                            while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($vResult->branch_id == $cresult->id){?>selected<?php } ?>>
                                                <?php echo $cresult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Enrolment Date</div>
                                        <input type="date" class="required form-control" id="cdate" name="cdate"
                                            placeholder=""
                                            value="<?php if($result->enrolment_date!=''){ echo date('Y-m-d',strtotime($result->enrolment_date)); }else{ echo date('Y-m-d'); }; ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">CRM Executive</div>
                                        <select name="crm_executive_id" id="crm_executive_id" class="form-control"
                                            <?php if($vResult->telecaller_id!=''){?> disabled <?php }?>>
                                            <option value="">CRM Executive</option>
                                            <?php                         
                                              $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                              while($clResult = $obj->fetchNextObject($clSql)){?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?php if($vResult->telecaller_id==$clResult->id){?> selected <?php } ?>>
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4" id="change_type">
                                <?php
                                if($vResult->visa_type=='Study' || $vResult->visa_type=='Work'){
                                    $pre_country_id = $vResult->pre_country_id;
                                      $visa_type = $vResult->visa_type;
                                  ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Visa Sub Type</div>
                                        <select class="required form-control" name="student_type" id="student_type"
                                            onchange="change_uk_premium(this.value)">
                                            <option value="">Select Visa Sub Type</option>
                                            <?php
                                  $clSql = $obj->query("select * from $tbl_visa_sub_type where country_id='$pre_country_id' and visa_type = '$visa_type' and status=1");
                                  while($clResult = $obj->fetchNextObject($clSql)){
                                      ?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?=$clResult->id == $vResult->visa_sub_type ? 'selected' : ''?>>
                                                <?php echo $clResult->visa_sub_type;?>
                                            </option>
                                            <?php
                                  }
                                  ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Student Type</div>
                                        <select class="required form-control" name="student_type" id="student_type">
                                            <option value="">Select Student Type</option>
                                            <option value="1"
                                                <?php if($vResult_f->visa_sub_type==3 || $vResult_f->visa_sub_type==44){?>
                                                selected <?php } ?>>New</option>
                                            <option value="3">Refused</option> 
                                            <option value="2" <?php if($vResult_f->visa_sub_type==48){?> selected
                                                <?php } ?>>Defer</option>
                                            <option value="4"
                                                <?php if($vResult_f->visa_sub_type==20 || $vResult_f->visa_sub_type==47){?>
                                                selected <?php } ?>>Re-apply (Same Intake)</option>
                                            <option value="6"
                                                <?php if($vResult_f->visa_sub_type==48 || $vResult_f->visa_sub_type==50){?>
                                                selected <?php } ?>>Re-apply(Defer)</option>
                                            <option value="5" <?php if($vResult_f->visa_sub_type==42){?> selected
                                                <?php } ?>>Re-Apply(New Applications)</option>
                                            <option value="7" <?php if($vResult_f->visa_sub_type==43){?> selected
                                                <?php } ?>>New(Outsider Refused)</option>
                                            <option value="8" <?php if($vResult_f->visa_sub_type==6){?> selected
                                                <?php } ?>>New (Filing Only)</option>
                                            <option value="9"
                                                <?php if($vResult_f->visa_sub_type==24 || $vResult_f->visa_sub_type==25){?>
                                                selected <?php } ?>>University Transfer</option>
                                        </select>
                                    </div>
                                </div> -->

                                <?php
                                }else{
                                  $pre_country_id = $vResult->pre_country_id;
                                      $visa_type = $vResult->visa_type;
                                  ?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Case Type</div>
                                        <select class="required form-control" name="student_type" id="student_type">
                                            <option value="">Select Case Type</option>
                                            <?php
                                  $clSql = $obj->query("select * from $tbl_visa_sub_type where country_id='$pre_country_id' and visa_type = '$visa_type'");
                                  while($clResult = $obj->fetchNextObject($clSql)){
                                      ?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?=$clResult->id == $vResult_f->visa_sub_type ? 'selected' : ''?>>
                                                <?php echo $clResult->visa_sub_type;?>
                                            </option>
                                            <?php
                                  }
                                  ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="show_uk_premium"
                                style=" <?=$vResult_f->visa_sub_type == 51 ? '' : 'display:none'?>">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Uk Premium Fee</div>
                                            <input type="text"
                                                class="form-control <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                                id="uk_premium_fee" name="uk_premium_fee" placeholder="Uk Premium Fee"
                                                value="<?php $result->uk_premium_fee ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Committed Cash Deposit</div>
                                            <input type="text"
                                                class="form-control <?=$vResult_f->student_type == 51 ? 'required' : ''?>"
                                                id="cash_deposit" name="cash_deposit"
                                                placeholder="Committed Cash Deposit"
                                                value="<?php echo $result->cash_deposit ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Embassy Priority Fees</div>
                                            <select name="embassy_prority_fee" id="embassy_prority_fee"
                                                class="form-control <?=$vResult_f->student_type == 51 ? 'required' : ''?>">
                                                <option value="">Select Embassy Priority Fees</option>
                                                <option value="Student"
                                                    <?=$result->embassy_prority_fee == 'Student' ? 'selected' : ''?>>
                                                    Student</option>
                                                <option value="IBT"
                                                    <?=$result->embassy_prority_fee == 'IBT' ? 'selected' : ''?>>IBT
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-required1">
                                        <div class="input-group">
                                            <div class="input-group-addon" style="height:34px">Includes Priority Fess
                                            </div>
                                            <input type="radio" name="includes_priority_fess"
                                                class="includes_priority_fess <?=$vResult_f->student_type == 51 ? 'required' : ''?>"
                                                value="Yes"
                                                <?=$result->includes_priority_fess == 'Yes' ? 'checked' : ''?>>
                                            Yes
                                            <input type="radio" name="includes_priority_fess"
                                                class="includes_priority_fess <?=$result->student_type == 51 ? 'required' : ''?>"
                                                value="No"
                                                <?=$result->includes_priority_fess == 'No' ? 'checked' : ''?>>
                                            No
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 label-required2" style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <?php
                                $uk_premium_fee_type = [];
                                ?>
                                    <div>
                                        <input
                                            class="form-check-input <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                            type="checkbox" name="uk_premium_fee_type[]" value="T"
                                            <?php if(in_array('T',$uk_premium_fee_type)){?> checked <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            T
                                        </label>
                                    </div>
                                    <div>
                                        <input
                                            class="form-check-input <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                            type="checkbox" name="uk_premium_fee_type[]" value="I"
                                            <?php if(in_array('I',$uk_premium_fee_type)){?> checked <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            I
                                        </label>
                                    </div>
                                    <div>
                                        <input
                                            class="form-check-input <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                            type="checkbox" name="uk_premium_fee_type[]" value="F"
                                            <?php if(in_array('F',$uk_premium_fee_type)){?> checked <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            F
                                        </label>
                                    </div>
                                    <div>
                                        <input
                                            class="form-check-input <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                            type="checkbox" name="uk_premium_fee_type[]" value="M"
                                            <?php if(in_array('M',$uk_premium_fee_type)){?> checked <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            M
                                        </label>
                                    </div>
                                    <div>
                                        <input
                                            class="form-check-input <?=$vResult_f->visa_sub_type == 51 ? 'required' : ''?>"
                                            type="checkbox" name="uk_premium_fee_type[]" value="E"
                                            <?php if(in_array('E',$uk_premium_fee_type)){?> checked <?php } ?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            E
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Screening Interview by</div>
                                            <input type="text"
                                                class="form-control <?=$vResult_f->student_type == 51 ? 'required' : ''?>"
                                                id="screening_interview_by" name="screening_interview_by"
                                                placeholder="Screening Interview by"
                                                value="<?php echo $result->screening_interview_by ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Screening Interview Score (1 - 10)</div>
                                            <input type="number" max="10" min="1"
                                                class="form-control <?=$vResult_f->student_type == 51 ? 'required' : ''?>"
                                                id="screening_interview_score" name="screening_interview_score"
                                                placeholder="Screening Interview Score"
                                                value="<?php echo $result->screening_interview_score ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-required3">
                                        <div class="input-group">
                                            <div class="input-group-addon" style="height:34px">Can student qualify CAS
                                                Interview</div>
                                            <input type="radio" name="student_qualify_cas"
                                                class="student_qualify_cas <?=$vResult_f->student_type == 51 ? 'required' : ''?>"
                                                value="Yes" <?=$result->student_qualify_cas == 'Yes' ? 'checked' : ''?>>
                                            Yes
                                            <input type="radio" name="student_qualify_cas"
                                                class="student_qualify_cas <?=$result->student_type == 51 ? 'required' : ''?>"
                                                value="No" <?=$result->student_qualify_cas == 'No' ? 'checked' : ''?>>
                                            No
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Counseller</div>
                                        <select class="form-control required" name="c_id" id="c_id">
                                            <option value="">Select Counseller</option>
                                            <?php
                                            if($_SESSION['level_id']==4){
                                                $csql=$obj->query("select * from $tbl_admin where id='".$_SESSION['sess_admin_id']."'",-1);
                                                while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id; ?>" selected>
                                                <?php echo $cresult->name." (".$cresult->email.")"; ?></option>';
                                            <?php } 
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3) {?>

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Account Manager</div>
                                        <select class="form-control" name="am_id" id="am_id" disabled="">
                                            <option value="">Select Account Manager</option>
                                            <?php
                                                if($_SESSION['level_id']==1 || $_SESSION['level_id']==2){
                                                    $whr='';
                                                    $brand_id=getField('branch_id','tbl_admin',$_SESSION['sess_admin_id']);
                                                    $brachArr = explode(',', $brand_id);
                                                    $m=1;
                                                    foreach($brachArr as $val){
                                                        if($m==1){
                                                            $whr .=" AND ( FIND_IN_SET ($val,branch_id)";
                                                        }else{
                                                            $whr .=" OR FIND_IN_SET ($val,branch_id)";
                                                        }
                                                        if($m==count($brachArr)){
                                                            $whr .=")";
                                                        } 
                                                        $m++;
                                                    }
                                                    $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id in (2,3) $whr",-1);
                                                }else{
                                                    $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and id='".$_SESSION['sess_admin_id']."'",-1);
                                                }
                                                while($cresult=$obj->fetchNextObject($csql)){
                                                	if($_SESSION['level_id']==3){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($cresult->id==$_SESSION['sess_admin_id']){?>selected<?php } ?>>
                                                <?php echo $cresult->name .'  ('.$cresult->email.')'; ?></option>
                                            <?php }else{?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($cresult->id==$_SESSION['level_id']){?>selected<?php } ?>>
                                                <?php echo $cresult->name .'  ('.$cresult->email.')'; ?></option>
                                            <?php }?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <span style="color: red;"><?php echo "Please add one application atleast" ?></span>
                                </div>
                            </div> -->
                            <?php } ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Address</div>
                                        <input type="text" class="form-control" placeholder="Address" name="address"
                                            id="address" value="<?php echo stripslashes($vResult->address); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">State</div>
                                        <select class="form-control" name="mstate_id" id="mstate_id">
                                            <option value="">Select State</option>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_location_states where 1=1 order by name",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($vResult->state_id==$line->id){?> selected <?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">City</div>
                                        <select class="form-control" name="mcity_id" id="mcity_id">
                                            <option value="">Select City</option>
                                            <?php 
                                            if($vResult->state_id!=''){
                                                $csql=$obj->query("select * from $tbl_location_cities where 1=1 and state_id='".$vResult->state_id."' order by name",$debug=-1);
                                            while($cline=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cline->id ?>"
                                                <?php if($vResult->city_id==$cline->id){?> selected <?php } ?>>
                                                <?php echo $cline->name ?></option>
                                            <?php } ?>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <input type="text" name="city_name" id="city_name" value="" class="form-control"
                                        placeholder="Add Your City Here" style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Postal Code</div>
                                        <input type="text" class="form-control" placeholder="Postal Code"
                                            name="postalcode" id="postalcode"
                                            value="<?php echo stripslashes($result->postalcode); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Intake Month</div>
                                        <select class="form-control required" id="intake" name="intake">
                                            <option value="">Select Intake Month</option>
                                            <option value="1" <?php if($result->intake==1){?> selected <?php }?>>January
                                            </option>
                                            <option value="2" <?php if($result->intake==2){?> selected <?php }?>>
                                                February</option>
                                            <option value="3" <?php if($result->intake==3){?> selected <?php }?>>March
                                            </option>
                                            <option value="4" <?php if($result->intake==4){?> selected <?php }?>>April
                                            </option>
                                            <option value="5" <?php if($result->intake==5){?> selected <?php }?>>May
                                            </option>
                                            <option value="6" <?php if($result->intake==6){?> selected <?php }?>>June
                                            </option>
                                            <option value="7" <?php if($result->intake==7){?> selected <?php }?>>July
                                            </option>
                                            <option value="8" <?php if($result->intake==8){?> selected <?php }?>>August
                                            </option>
                                            <option value="9" <?php if($result->intake==9){?> selected <?php }?>>
                                                September</option>
                                            <option value="10" <?php if($result->intake==10){?> selected <?php }?>>
                                                October</option>
                                            <option value="11" <?php if($result->intake==11){?> selected <?php }?>>
                                                November </option>
                                            <option value="12" <?php if($result->intake==12){?> selected <?php }?>>
                                                December</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Intake Year</div>
                                        <select class="form-control required" id="intake_year" name="intake_year">
                                            <option value="">Select Intake Year</option>
                                            <?php
                                            for($i = date("Y"); $i < date("Y")+10; $i++){
                                                ?>
                                            <option value="<?=$i?>" <?=$result->intake_year == $i ? 'selected' : ''?>>
                                                <?=$i?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="background:#3e4095">Does applicant already
                                            have USA B1/B2 visa?</div>
                                        <div
                                            style="width: 100%; background: #edf1f5; border: 1px solid #ccc; padding: 5px;">
                                            <label for="application_b1_b2"
                                                style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
                                                <input type="checkbox" id="application_b1_b2" name="application_b1_b2"
                                                    value="Yes"
                                                    style="width: 20px; height: 20px; accent-color: #007bff; border: 2px solid #007bff; cursor: pointer;">
                                                <span style="font-weight: bold;">Yes</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="titles university_recommend1">
                                        <div class="col-md-3">
                                            <h5>Passport Details</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">First Name</div>
                                            <input type="text" class="form-control required" placeholder="First Name"
                                                name="passport_f_name" value="<?php echo $result->passport_f_name ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Last Name</div>
                                            <input type="text" class="form-control required" placeholder="Last Name"
                                                name="passport_l_name" value="<?php echo $result->passport_l_name ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Passport Issue Date</div>
                                            <input type="date" class="form-control required"
                                                placeholder="Passport Issue Date" name="passport_issue_date"
                                                value="<?php echo $result->passport_issue_date ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Passport Expiry Date</div>
                                            <input type="date" class="form-control required"
                                                placeholder="Passport Expiry Date" name="passport_expiry_date"
                                                value="<?php echo $result->passport_expiry_date ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Place of Birth</div>
                                            <input type="text" class="form-control required"
                                                placeholder="Place of Birth" name="passport_place_of_birth"
                                                value="<?php echo $result->passport_place_of_birth ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="titles university_recommend1">
                                    <div class="col-md-3">
                                        <h5>Parent Details</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="width:100%;" id="add_relation">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Relation.</div>
                                            <select class="form-control required" name="relation[0][relation]">
                                                <option value="">Select Relation</option>
                                                <option value="1" <?php if($vResult->father_name!=''){?> selected
                                                    <?php } ?>>Father</option>
                                                <option value="2">Mother</option>
                                                <option value="3">Husband</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Name</div>
                                            <input type="text" class="form-control required" placeholder="Name"
                                                name="relation[0][name]" value="<?php echo $vResult->father_name; ?>"
                                                maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Date of Birth</div>
                                            <input type="date" class="form-control required" name="relation[0][dob]"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Contact No.</div>
                                            <input type="text" class="form-control required" placeholder="Contact No"
                                                name="relation[0][contact_no]" value="" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Email ID.</div>
                                            <input type="text" class="form-control required" placeholder="Email ID"
                                                name="relation[0][email]" value="" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Sponser</div>
                                            <select name="relation[0][sponser]" id="sponser"
                                                class="form-control required">
                                                <option value="">Select</option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="add-section-relation">
                                <a class="add_field_relation button" style="cursor: pointer;"><i class="fa fa-plus"
                                        aria-hidden="true" style="color:white;margin-top: 10px;"></i></a>
                            </div>
                        </div>


                        <div class="add_student_section my-5">
                            <div class="conatiner">
                                <div class="university_recommend1">
                                    <div class="titles row">
                                        <div class="col-md-2">
                                            <h5 style="font-size: 12px;">Academic Qualifications</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>Board</h5>
                                        </div>
                                        <div class="col-md-2" style="text-align:center">
                                            <h5>Start Year</h5>
                                        </div>
                                        <div class="col-md-2" style="text-align:center">
                                            <h5>End Year</h5>
                                        </div>
                                        <div class="col-md-3" style="text-align:center">
                                            <h5 style="margin-left:10px">Stream</h5>
                                        </div>
                                        <div class="col-md-1" style="text-align:center">
                                            <h5 style="">Per.</h5>
                                        </div>
                                        <div class="col-md-1" style="text-align:center">
                                            <h5 style="">GPA</h5>
                                        </div>
                                    </div>
                                    <div class="" style="width:100%">
                                        <div class="course_add1" style="position: relative;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">10th</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" id="matri_board_refresh">
                                                        <div class="input-group" style="width:100%;">
                                                            <select name="matri_board" id="matri_board"
                                                                class="form-control"
                                                                onchange="change_matric_board(this.value,'matri_board')">
                                                                <option value="">Select Board</option>
                                                                <?php
                                                                    $catSql = $obj->query("select * from tbl_board order by name asc");
                                                                    while($res = $obj->fetchNextObject($catSql)){
                                                                        ?>
                                                                <option value="<?=$res->name?>"
                                                                    <?php if($vResult->matri_board==$res->name){?>
                                                                    selected <?php }?>>
                                                                    <?=$res->name?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control" id="ten_start_year"
                                                                name="ten_start_year" value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="ten_end_year" name="ten_end_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="required form-control"
                                                                placeholder="Stream" name="ten_stream" id="ten_stream"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="required form-control"
                                                                placeholder="Percentage(%)" name="ten_percent"
                                                                id="ten_percent"
                                                                value="<?php echo $vResult->matri_percentage; ?>"
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="ten_grade" id="ten_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">12th</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" id="secondary_board_refresh">
                                                        <div class="input-group" style="width:100%;">
                                                            <select name="secondary_board" id="secondary_board"
                                                                class="form-control"
                                                                onchange="change_matric_board(this.value,'secondary_board')">
                                                                <option value="">Select Board</option>
                                                                <?php
                                        $catSql = $obj->query("select * from tbl_board order by  name asc");
                                        while($res = $obj->fetchNextObject($catSql)){
                                            ?>
                                                                <option value="<?=$res->name?>"
                                                                    <?php if($vResult->secondary_board==$res->name){?>
                                                                    selected <?php }?>><?=$res->name?></option>
                                                                <?php } ?>
                                                                <!-- <option value="other">Other</option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="twl_start_year" name="twl_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="twl_end_year" name="twl_end_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="required form-control"
                                                                placeholder="Stream" name="twl_stream" id="twl_stream"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="twl_percent"
                                                                id="twl_percent"
                                                                value="<?php echo $vResult->secondary_percentage; ?>"
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="twl_grade" id="twl_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Diploma</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University" name="diploma_board"
                                                                id="diploma_board"
                                                                value="<?php echo $vResult->diploma_board; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="dip_start_year" name="dip_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="dip_end_year" name="dip_end_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="required form-control"
                                                                placeholder="Stream" name="dip_stream" id="dip_stream"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="dip_percent"
                                                                id="dip_percent"
                                                                value="<?php echo $vResult->diploma_percentage; ?>"
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="dip_grade" id="dip_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Diploma II</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University" name="diploma_board2"
                                                                id="diploma_board2"
                                                                value="<?php echo $result->diploma_board2; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control"
                                                                id="dip1_start_year" name="dip1_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control" id="dip1_end_year"
                                                                name="dip1_end_year" value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="form-control" placeholder="Stream"
                                                                name="dip1_stream" id="dip1_stream" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="dip1_percent"
                                                                id="dip1_percent" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="dip1_grade" id="dip1_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Graduation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University" name="bachelor_board"
                                                                id="bachelor_board"
                                                                value="<?php echo $vResult->bachelor_board; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="grd_start_year" name="grd_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="required form-control"
                                                                id="grd_end_year" name="grd_end_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="required form-control"
                                                                placeholder="Stream" name="grd_stream" id="grd_stream"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="grd_percent"
                                                                id="grd_percent"
                                                                value="<?php echo $vResult->bachelor_percentage; ?>"
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="grd_grade" id="grd_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Graduation II</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University"
                                                                name="bachelor_board2" id="bachelor_board2"
                                                                value="<?php echo $result->bachelor_board2; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control"
                                                                id="grd1_start_year" name="grd1_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control" id="grd1_end_year"
                                                                name="grd1_end_year" value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="form-control" placeholder="Stream"
                                                                name="grd1_stream" id="grd1_stream" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="grd1_percent"
                                                                id="grd1_percent" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="grd1_grade" id="grd1_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Post Graduation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University" name="master_board"
                                                                id="master_board"
                                                                value="<?php echo $result->master_board; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control"
                                                                id="pgrd_start_year" name="pgrd_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control" id="pgrd_end_year"
                                                                name="pgrd_end_year" value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Stream</div> -->
                                                            <input type="text" class="form-control" placeholder="Stream"
                                                                name="pgrd_stream" id="pgrd_stream" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <!-- <div class="input-group-addon">Percentage(%)</div> -->
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="pgrd_percent"
                                                                id="pgrd_percent"
                                                                value="<?php echo $vResult->master_percentage; ?>"
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="pgrd_grade" id="pgrd_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">PG Diploma</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group" style="width:100%;">
                                                            <input type="text" class="form-control"
                                                                placeholder="Institute/University" name="master_board2"
                                                                id="master_board2"
                                                                value="<?php echo $result->master_board2; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control"
                                                                id="pgdrd_start_year" name="pgdrd_start_year"
                                                                value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="month" class="form-control" id="pgdrd_end_year"
                                                                name="pgdrd_end_year" value="<?php echo date('Y-m') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Stream"
                                                                name="pgdrd_stream" id="pgdrd_stream" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Percentage(%)" name="pgdrd_percent"
                                                                id="pgdrd_percent" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="Grade"
                                                                name="pgdrd_grade" id="pgdrd_grade" value=""
                                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                $ursqls = $obj->query("select * from $tbl_visit_course where visit_id='$vid'",-1); //die;
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
                                        <div class="input-group-addon">Special Remarks </div>
                                        <input name="special_remarks" id="special_remarks" class="form-control"
                                            value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add_student_section my-5">
                            <div class="conatiner">
                                <div class="university_recommend1">
                                    <div class="titles row">
                                        <div class="col-md-3" style="padding: 0px !important">
                                            <h5>WORK EXPERIENCE</h5>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Company Name</h5>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <h5>Designation</h5>

                                        </div>
                                        <div class="col-md-2 text-center">
                                            <h5>Start Year</h5>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <h5>End Year</h5>
                                        </div>
                                    </div>
                                    <div class="" style="width:100%" id="add5">
                                        <div class="course_add1 ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-addon"
                                                                style="height: 35px;color: #fff;">Company 1</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Company Name"
                                                                name="weresult[0][company_name]" id="company_name"
                                                                value="" style="width: 250px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="Designation"
                                                                name="weresult[0][designation]" id="designation"
                                                                value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control"
                                                                placeholder="Start Date" name="weresult[0][start_date]"
                                                                id="start_date" value="" style="width: 140px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control"
                                                                placeholder="End Date" name="weresult[0][end_date]"
                                                                id="end_date" value="" style="width: 140px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height: 35px;color: #fff;">Company 2</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Company Name" name="weresult[1][company_name]" id="company_name" value="" style="width: 250px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Designation" name="weresult[1][designation]" id="designation" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="Start Date" name="weresult[1][start_date]" id="start_date" value="" style="width: 140px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="date" class="form-control" placeholder="End Date" name="weresult[1][end_date]" id="end_date" value="" style="width: 140px;">
                                </div>
                            </div>
                        </div>
                    </div> -->

                                            <div class="add-section">
                                                <a class="add_field_button5 button"><i class="fa fa-plus"
                                                        aria-hidden="true" style="color:white;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="add_student_section my-5">
                            <div class="conatiner">
                                <div class="university_recommend1">
                                    <div class="titles row">
                                        <div class="col-md-3" style="padding: 0px !important">
                                            <h5>English Proficiency</h5>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Writing</h5>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Reading</h5>

                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Listening</h5>

                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Speaking</h5>

                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h5>Overall Bands</h5>

                                        </div>

                                        <div class="col-md-3">
                                            <h5> Date Of Expiry</h5>
                                        </div>
                                    </div>

                                    <div class="" style="width:100%" id="add_english_proficiency_form">
                                        <div class="course_add1 " style="position: relative;">
                                            <div class="course_form add_mrgin">
                                                <div class="form-group">
                                                    <select class="form-control course" name="epresult[0][course]"
                                                        id="course">
                                                        <option value="">Select Course</option>
                                                        <option value="IELTS">IELTS</option>
                                                        <option value="PTE">PTE</option>
                                                        <option value="TOEFL">TOEFL</option>
                                                        <option value="Duolingo">Duolingo</option>
                                                        <option value="MOI">MOI</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control wirting"
                                                        placeholder="Writing" name="epresult[0][wirting]" id="wirting"
                                                        value="" style="width: 140px;">
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Reading "
                                                        name="epresult[0][reading]" id="reading" value=""
                                                        style="width: 140px;">
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Listening "
                                                        name="epresult[0][listening]" id="listening" value=""
                                                        style="width: 140px;">
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Speaking "
                                                        name="epresult[0][speaking]" id="speaking" value=""
                                                        style="width: 140px;">
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Overall Bands"
                                                        name="epresult[0][overall_bands]" id="overall_bands" value=""
                                                        style="width: 140px;">
                                                </div>
                                                <div class="form-group">
                                                    <input type="date" class="form-control" placeholder="Date of Exam"
                                                        name="epresult[0][exam_date]" id="exam_date" value=""
                                                        style="width: 140px;">
                                                </div>
                                            </div>
                                            <div class="row form-margin" style="display:flex;padding: 0 15px">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Login id"
                                                        name="epresult[0][login_id]" id="login_id" value=""
                                                        style="width: 140px;">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Password"
                                                        name="epresult[0][password]" id="password" value=""
                                                        style="width: 140px;">
                                                </div>
                                            </div>
                                            <div class="add-section">
                                                <a class="add_english_proficiency button"><i class="fa fa-plus"
                                                        aria-hidden="true" style="color:#fff"></i></a>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                $ursql = $obj->query("select * from $tbl_visit_university_recommended where visit_id='$vid'",-1); //die;
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
                                                    <?php if($urReslut->state_id==$line->state){?> selected <?php }?>>
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
                                                    <?php if($urReslut->university_id==$line->univercity){?> selected
                                                    <?php }?>>
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
                                                <option value="1" <?php if($urReslut->intake==1){?> selected <?php }?>>
                                                    January</option>
                                                <option value="2" <?php if($urReslut->intake==2){?> selected <?php }?>>
                                                    February</option>
                                                <option value="3" <?php if($urReslut->intake==3){?> selected <?php }?>>
                                                    March</option>
                                                <option value="4" <?php if($urReslut->intake==4){?> selected <?php }?>>
                                                    April</option>
                                                <option value="5" <?php if($urReslut->intake==5){?> selected <?php }?>>
                                                    May</option>
                                                <option value="6" <?php if($urReslut->intake==6){?> selected <?php }?>>
                                                    June</option>
                                                <option value="7" <?php if($urReslut->intake==7){?> selected <?php }?>>
                                                    July</option>
                                                <option value="8" <?php if($urReslut->intake==8){?> selected <?php }?>>
                                                    August</option>
                                                <option value="9" <?php if($urReslut->intake==9){?> selected <?php }?>>
                                                    September</option>
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
                                            <select name="uniRecommended[<?php echo $ur; ?>][state_id]" id="state_ids"
                                                class="form-control">
                                                <option value="">State</option>
                                                <?php
                                            $sql = $obj->query("select state from $tbl_programmes where 1=1 and state!='' group by state order by state asc",-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                                <option value="<?php echo $line->state ?>"
                                                    <?php if($urReslut->state_id==$line->state){?> selected <?php }?>>
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
                                            <select name="uniRecommended[0][intake]" id="intake" class="form-control">
                                                <option value="">Intake</option>
                                                <option value="1" <?php if($result->intake==1){?> selected <?php }?>>
                                                    January</option>
                                                <option value="2" <?php if($result->intake==2){?> selected <?php }?>>
                                                    February</option>
                                                <option value="3" <?php if($result->intake==3){?> selected <?php }?>>
                                                    March</option>
                                                <option value="4" <?php if($result->intake==4){?> selected <?php }?>>
                                                    April</option>
                                                <option value="5" <?php if($result->intake==5){?> selected <?php }?>>May
                                                </option>
                                                <option value="6" <?php if($result->intake==6){?> selected <?php }?>>
                                                    June</option>
                                                <option value="7" <?php if($result->intake==7){?> selected <?php }?>>
                                                    July</option>
                                                <option value="8" <?php if($result->intake==8){?> selected <?php }?>>
                                                    August</option>
                                                <option value="9" <?php if($result->intake==9){?> selected <?php }?>>
                                                    September</option>
                                                <option value="10" <?php if($result->intake==10){?> selected <?php }?>>
                                                    October</option>
                                                <option value="11" <?php if($result->intake==11){?> selected <?php }?>>
                                                    November </option>
                                                <option value="12" <?php if($result->intake==12){?> selected <?php }?>>
                                                    December</option>
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
                                                    <?php if($eduReslut->master_finish_year==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                        </div>



                        <!-- <div class="add_student_section my-5">
    <div class="conatiner">
        <div class="university_recommend">
            <h5>DIPLOMA RECOMMENDATION</h5>
            <div class="" style="width:100%" id="add2">
                <div class="course_add1" style="position: relative;">
                    <div class="course_form add_mrgin" style="display: flex; justify-content:space-between;">
                        <div class="form-group">
                            <select class="form-control" name="data[0][diploma_id]" id="diploma_id">
                                <option value="">Select your Diploma</option>
                                <?php
                                $i=1;
                                $sql=$obj->query("select * from $tbl_diploma where status=1 group by name",$debug=-1);
                                while($line=$obj->fetchNextObject($sql)){
                                if($line->name!=''){?>
                                    <option value="<?php echo $line->id ?>"><?php echo $line->name ?></option>
                                <?php } 
                            }   ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg start_date0" type="text" placeholder="DD-MM-YY"  name="data[0][start_date]" id="dr_start_date0">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg start_date0" type="text" placeholder="DD-MM-YY"  name="data[0][end_date]" id="dr_end_date0">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" id="time_duration0" name="data[0][time_duration]" placeholder="0 Year,0 Months">
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="data[0][status]" id="dr_status" style="margin: 0 !important; position: relative;">
                                <option value="status">Status</option>
                                <option value="self">Self </option>
                                <option value="pending_confirmation">Pending confirmation</option>
                                <option value="send_request">Send Request</option>
                            </select>
                        </div>
                    </div>
                    <span class="extra_field" style="display: flex; justify-content:space-between;">
                        <div class="row course_form" style="margin-left:0px;">
                         <div class="form-group">
                           <input class="form-control" type="text" id="dr_slip_number" name="data[0][slip_number]" placeholder="Request Slip Number">
                       </div>
                       <div class="form-group">
                           <input  type='file' name='data[0][dr_slip_photo]' multiple="multiple" class="manage_upload_button2" placeholder="Passport Size Photo" id="fileupload">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="text" id="dr_mother_name" name="data[0][mother_name]" placeholder="Mother Name">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="text" id="phonevalidate" name="data[0][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="text" id="dr_imp_remarks" name="data[0][imp_remarks]" placeholder="Important Remarks">
                        </div>
                        <div class="form-group">
                           <input  type='file' name='data[0][photo]' multiple="multiple" class="manage_upload_button1" placeholder="Passport Size Photo" id="fileupload">
                        </div>
                    </div>
                    </span>
                    <div class="add-section ">
                        <a class="add_field_button2 button"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="add_student_section my-5">
    <div class="conatiner">
        <div class="university_recommend">
            <h5>EXPERIENCE RECOMMENDATION</h5>
            <div class="" style="width:100%" id="add3">
                <div class="course_add1 " style="position:relative">
                    <div class="course_form add_mrgin" style="display: flex; justify-content: space-between;">
                        
                        <div class="form-group">
                            <select class="form-control" name="data2[0][designation_id]" id="designation_id">
                                <option value="">Select your Designation</option>
                                <?php
                                $i=1;
                                $sqlc=$obj->query("select * from $tbl_designation where status=1 group by name",$debug=-1);
                                while($linec=$obj->fetchNextObject($sqlc)){
                                    if($linec->name!=''){
                                    ?>
                                    <option value="<?php echo $linec->id ?>"><?php echo $linec->name ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[0][start_date]" id="er_start_date0">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[0][end_date]" id="er_end_date0">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" placeholder="0 Year,0 Months"  name="data2[0][time_duration]" id="er_time_duration0">
                        </div>
                        <div class="form-group" >
                            <select class="form-control" name="data2[0][status]" id="er_status" style="margin: 0 !important;">
                                <option value="status">Status</option>
                                <option value="self">Self </option>
                                <option value="pending_confirmation">Pending confirmation</option>
                                <option value="send_request">Send Request</option>
                            </select>
                        </div>

                    </div>


                    <span id="er_extra_field" style="display: flex; justify-content:space-between;">
                        <div class="row course_form" style="margin-left:0px;">
                         <div class="form-group">
                           <input class="form-control" type="text" id="er_slip_number" name="data2[0][slip_number]" placeholder="Request Slip Number">
                        </div> 
                        <div class="form-group">
                           <input  type='file' name='data2[0][er_slip_photo]' multiple="multiple" class="manage_upload_button2">
                        </div>                        
                        <div class="form-group">
                           <input class="form-control" type="text" id="phonevalidateman" name="data2[0][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="text" id="er_salary" name="data2[0][salary]" placeholder="Salary">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="date" id="er_issue_date" name="data2[0][issue_date]" placeholder="Issue Date">
                        </div>
                        <div class="form-group">
                           <input class="form-control" type="text" id="er_imp_remarks" name="data2[0][imp_remarks]" placeholder="Important Remarks">
                        </div>
                    </div>
                    </span>

                    <div class="add-section " >
                        <a class="add_field_button3 button"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="add_student_section my-5">
    <div class="conatiner">
        <div class="university_recommend">
            <h5>FUND RECOMMENDATION</h5>
            <div class="" style="width:100%" id="add4">
                <div class="course_add1 " style="position:relative">
                    <div class="course_form add_mrgin" style="display: flex; justify-content: start;">

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" placeholder="Amount(INR)" name="data3[0][amount]" id="amount" value="<?php echo $vResult->available_funds; ?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" placeholder="Notes"  name="data3[0][notes]" id="notes">
                        </div>
                        <div class="form-group">
                            <select class="form-control  " name="data3[0][status]" style="margin: 0 !important;">
                                <option value="status">Status</option>
                                <option value="outside">Outside</option>
                                <option value="self">Self </option>
                                <option value="partial">Partial </option>
                                <option value="hold">Hold </option>
                                <option value="pending_confirmation">Pending confirmation</option>
                            </select>
                        </div>
                    </div>
                    <div class="add-section " >
                        <a class="add_field_button4 button " id="getdropsatate"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->



                        <div class="add_stdnt_btn">
                            <button type="submit" id="submitbtn" class="btn mr-10">Submit</button>
                        </div>
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
            <?php include("footer.php"); ?>
            <script type="text/javascript" src="js/jquery.validate.min.js"></script>

            <link rel="stylesheet" href="calender/css/jquery-ui.css">
            <script src="calender/js/jquery-ui.js"></script>
            <script type="text/javascript" src="js/select2.min.js"></script>
            <script>
            $(function() {
                $(".extra_field").hide();
                $("#er_extra_field").hide();
                $("#er_start_date0").datepicker({
                    dateFormat: 'dd-mm-yy',
                    numberOfMonths: 1,
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(selected) {
                        $("#er_end_date0").datepicker("option", "minDate", selected);
                    }

                });

                $("#er_end_date0").datepicker({
                    dateFormat: 'dd-mm-yy',
                    numberOfMonths: 1,
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(selected) {
                        $("#er_start_date0").datepicker("option", "maxDate", selected);
                        var start = $('#er_start_date0').val();
                        var end = $('#er_end_date0').val();
                        var action = 'getdays';
                        $.ajax({
                            type: "post",
                            url: "ajax/getModalData.php",
                            data: {
                                'start_date': start,
                                'end_date': end,
                                'action': action
                            },
                            success: function(res) {
                                $("#er_time_duration0").val(res);

                            }
                        });

                    }

                });


                $("#dr_start_date0").datepicker({
                    dateFormat: 'dd-mm-yy',
                    numberOfMonths: 1,
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(selected) {
                        $("#dr_end_date0").datepicker("option", "minDate", selected);
                    }
                });

                $("#dr_end_date0").datepicker({
                    dateFormat: 'dd-mm-yy',
                    numberOfMonths: 1,
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(selected) {
                        $("#dr_start_date0").datepicker("option", "maxDate", selected);
                        var start = $('#dr_start_date0').val();
                        var end = $('#dr_end_date0').val();
                        var action = 'getdays';
                        $.ajax({
                            type: "post",
                            url: "ajax/getModalData.php",
                            data: {
                                'start_date': start,
                                'end_date': end,
                                'action': action
                            },
                            success: function(res) {
                                $("#time_duration0").val(res);
                            }
                        });

                    }
                });
            });


            $("#country_id").change(function() {
                var id = this.value;
                $.ajax({
                    type: "GET",
                    url: 'ajax/getModalData.php',
                    data: {
                        id: id,
                        type: 'getUCRState'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $(".state_id").html(response);
                    }
                });


                $.ajax({
                    type: "GET",
                    url: 'ajax/getModalData.php',
                    data: {
                        id: id,
                        type: 'getStudentCourse'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $("#course_recomandateion_one").html(response);
                        $("#course_recomandateion_two").html(response);
                    }
                });

            });


            $("#mstate_id").change(function() {
                var id = this.value;
                $.ajax({
                    type: "GET",
                    url: 'ajax/getModalData.php',
                    data: {
                        id: id,
                        type: 'getMCity'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $("#mcity_id").html(response);
                    }
                });

            });


            $("#mcity_id").change(function() {
                var id = this.value;
                if (id == 1000) {
                    $("#city_name").show();
                    $("#city_name").addClass("required");
                } else {
                    $("#city_name").hide();
                    $("#city_name").removeClass("required")
                }
            });

            $('#state_id0').change(function() {
                var id = $('#state_id0').val();
                var action = 'get_UCR_state_id'
                $.ajax({
                    type: "post",
                    url: "ajax/getModalData.php",
                    data: {
                        'key': id,
                        'action': action
                    },
                    success: function(res) {

                        $('#univercity_id0').html(res);

                    }
                });
            });

            $('#univercity_id0').change(function() {
                var id = $('#univercity_id0').val();
                var action = 'get_UCR_course_id'
                $.ajax({
                    type: "post",
                    url: "ajax/getModalData.php",
                    data: {
                        'key': id,
                        'action': action
                    },
                    success: function(res) {

                        $('#course_id0').html(res);

                    }
                });
            });


            $("#branch_id").change(function() {
                var id = this.value;
                $.ajax({
                    type: "GET",
                    url: 'ajax/getModalData.php',
                    data: {
                        id: id,
                        type: 'getCounseller'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $("#c_id").html(response);
                    }
                });
            });

            $("#alternate_contact").change(function() {
                acontactNo = $(this).val();
                $("#err_alternate_contact").show();
                contactNo = $("#student_contact_no").val();
                if (acontactNo == contactNo) {
                    $("#err_alternate_contact").html("Can not be same as phone number.");
                    $(this).val('');
                } else {
                    $("#err_alternate_contact").hide();
                }
            })
            </script>

            <script type="text/javascript">
            $(document).ready(function() {
                $("#studentfrm").validate();
                $("#course_recomandateion_one").select2();
                $("#course_recomandateion_two").select2();

                var maxField = 10; //Input fields increment limitation 

                //============================================================relation===================================================
                var addrelationButton = $('.add_field_relation');
                var wrapperrelation = $('#add_relation');
                var relex = 1;
                $(addrelationButton).click(function() {
                    if (relex < maxField) {
                        if (relex == 1) {
                            $toplength = "top: 81%;";
                        } else {
                            $toplength = "top: 10%;";
                        }
                        relex++;
                        $(wrapperrelation).append(
                            '<div class="course_add1" style="position:relative"><div class="row" style="margin-left:0px;"><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Relation.</div><select class="form-control" name="relation[' +
                            relex +
                            '][relation]"><option value="">Select Relation</option><option value="1">Father</option><option value="2">Mother</option><option value="3">Husband</option></select></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Name</div><input type="text" class="form-control" placeholder="Name" name="relation[' +
                            relex +
                            '][name]" value=""  maxlength="50"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Date of Birth</div><input type="date" class="form-control required" name="relation[' +
                            relex +
                            '][dob]" value=""></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Contact No.</div><input type="text" class="form-control" placeholder="Contact No" name="relation[' +
                            relex +
                            '][contact_no]" value=""  maxlength="10"></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Email ID.</div><input type="text" class="form-control" placeholder="Email ID" name="relation[' +
                            relex +
                            '][email]" value="" maxlength="50"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Sponser</div><select name="relation[' +
                            relex +
                            '][sponser]" id="sponser" class="form-control required"><option value="">Select</option><option value="1">Yes</option><option value="2">No</option></select></div></div></div></div><a href="#" class="remove_relation_field delete_btn" style="position: absolute;' +
                            $toplength + ' right: 74px;">X</a></div>');
                    }
                });

                $(wrapperrelation).on('click', '.remove_relation_field', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    relex--;
                });
                //============================================================relation===================================================


                var addButton = $('.add_field_button'); //Add button selector

                var wrapper = $('#add'); //Input field wrapper
                <?php
    if($_REQUEST['id']!=''){?>
                var x = <?php echo $i-1; ?>; //Initial field counter is 1
                var y = <?php echo $i; ?>
                <?php }else{?>
                var x = 0; //Initial field counter is 1
                var y = 0;
                <?php }?>
                //Once add button is clicked
                $(addButton).click(function() {
                    //Check maximum number of input fields
                    if (x < maxField) {
                        x++; //Increment field counter
                        y++; //Increment field counter
                        $(wrapper).append(
                            '<div class="course_add1 "><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;" ><div class="form-group"  ><select class="form-control state_id" name="result[' +
                            x + '][state_id]" id="state_id' + x +
                            '" style="width:240px;"><option value="">Select State</option></select></div><div class="form-group"><select class="form-control" name="result[' +
                            x + '][univercity_id]" id="univercity_id' + x +
                            '" style="width:260px;"><option>Select your University</option></select></div><select class="form-control" name="result[' +
                            x + '][course_id]" id="course_id' + x +
                            '" style="width: 240px;"><option value="">Select your Course</option></select><div class="form-group"><select class="form-control" id="month" name="result[' +
                            x +
                            '][month]"><option value="">intake </option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November </option><option value="12">December</option></select></div><div class="form-group"> <select class="form-control" id="year" name="result[' +
                            x +
                            '][year]"><?php $firstYear = (int)date('Y');$lastYear = $firstYear + 10;for($i=$firstYear;$i<=$lastYear;$i++){echo '<option value='.$i.'>'.$i.'</option>';}?></select></div><a href="#" class="remove_field uni-recom delete_btn">X</a></div></div><script>$("#state_id' +
                            x +
                            '").change(function() {  var id=$(this).val(); var action="get_UCR_state_id" ; $.ajax({ url:"ajax/getModalData.php" ,data:{key:id,action:action},success:function(result){ $("#univercity_id' +
                            x + '").html(result);}});});$("#univercity_id' + x +
                            '").change(function() {  var id=$(this).val(); var action="get_UCR_course_id" ; $.ajax({ url:"ajax/getModalData.php" ,data:{key:id,action:action},success:function(result){ $("#course_id' +
                            x + '").html(result);}});});<' + '/' + 'script>');
                    }
                });
                $("#stateButton").click(function() {
                    var id = $('#country_id').val();
                    if (id != "") {
                        $.ajax({
                            type: "GET",
                            url: 'ajax/getModalData.php',
                            data: {
                                id: id,
                                type: 'getUCRState'
                            },
                            beforeSend: function() {},
                            success: function(response) {
                                console.log(response);
                                $("#state_id" + x).html(response);
                            }
                        });
                    }
                });



                //Once remove button is clicked
                $(wrapper).on('click', '.remove_field', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    x--; //Decrement field counter
                });

                // <script>$("#stateButton").click(function() {var id = $('#country_id').val();$.ajax({type: "GET", url: 'ajax/getModalData.php',data: {id:id,type:'getState'},success:function(result){ $("#state_id'+x+'").val(result);}});});<' + '/' + 'script>



                $('#phonevalidate').on('input', function() {
                    const phoneNumber = $(this).val();
                    const numericOnly = phoneNumber.replace(/\D/g, '');
                    const limitedNumber = numericOnly.slice(0, 14);
                    const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber :
                        "+91" + limitedNumber;
                    $(this).val(formattedNumber);
                });

                $('#phonevalidateman').on('input', function() {
                    const phoneNumber = $(this).val();
                    const numericOnly = phoneNumber.replace(/\D/g, '');
                    const limitedNumber = numericOnly.slice(0, 14);
                    const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber :
                        "+91" + limitedNumber;
                    $(this).val(formattedNumber);
                });

                var addButton = $('.add_field_button2'); //Add button selector

                var wrapper2 = $('#add2'); //Input field wrapper
                <?php
if($_REQUEST['id']!=''){?>
                var x = <?php echo $i-1; ?>; //Initial field counter is 1
                var y = <?php echo $i; ?>
                <?php }else{?>
                var a = 0; //Initial field counter is 1
                var b = 0;
                <?php }?>
                //Once add button is clicked
                $(addButton).click(function() {
                    //Check maximum number of input fields
                    if (a < maxField) {
                        a++; //Increment field counter
                        b++; //Increment field counter

                        $("#extra_field" + a).hide();
                        $(wrapper2).append(
                            '<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group"><select class="form-control" name="data[' +
                            a +
                            '][diploma_id]" id="diploma_id"><option value="">Select your Diploma</option><?php $sql=$obj->query("select * from $tbl_diploma where status=1 group by name",$debug=-1);while($line=$obj->fetchNextObject($sql)){ if($line->name!=''){?><option value="<?php echo $line->id ?>"><?php echo $line->name ?></option><?php } } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data[' +
                            a + '][start_date]" id="dr_start_date' + a +
                            '"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data[' +
                            a + '][end_date]" id="dr_end_date' + a +
                            '"></div><div class="form-group"><input class="form-control form-control-lg" id="time_duration' +
                            a + '" type="text" placeholder="0 Year,0 Months" name="data[' + a +
                            '][time_duration]"></div><div class="form-group"><select class="form-control" name="data[' +
                            a + '][status]" id="dr_status' + a +
                            '"><option value="status">Status</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option><option value="send_request">Send Request</option></select></div></div><div class="extra_field" id="extra_field' +
                            a +
                            '" style="display: flex; justify-content:space-between;"><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_slip_number' +
                            a + '" name="data[' + a +
                            '][slip_number]" placeholder="Request Slip Number"></div><div class="form-group"><input  type="file" name="data[' +
                            a +
                            '][dr_slip_photo]" multiple="multiple" class="manage_upload_button2" placeholder="Passport Size Photo" id="fileupload"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_mother_name' +
                            a + '" name="data[' + a +
                            '][mother_name]" placeholder="Mother Name"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="phonevalidate' +
                            a + '" name="data[' + a +
                            '][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_imp_remarks' +
                            a + '" name="data[' + a +
                            '][imp_remarks]" placeholder="Important Remarks"></div><div class="form-group"><input  type="file" name="data[' +
                            a +
                            '][photo]" class="manage_upload_button1" placeholder="Passport Size Photo" id="fileupload' +
                            a +
                            '"></div><a href="#" class="remove_field2 diploma-recom delete_btn">X</a></div>'
                        );

                        $("#extra_field" + a).hide();


                        $("#dr_status" + a).change(function() {
                            dr_status = $(this).val();
                            if (dr_status == 'send_request') {
                                $("#extra_field" + a).show();
                                $("#dr_slip_number" + a).addClass('required');
                                $("#dr_mother_name" + a).addClass('required');
                                $("#phonevalidate" + a).addClass('required');
                                $("#fileupload" + a).addClass('required');
                            } else {
                                $("#extra_field" + a).hide();
                                $("#dr_slip_number" + a).removeClass('required');
                                $("#dr_mother_name" + a).removeClass('required');
                                $("#phonevalidate" + a).removeClass('required');
                                $("#fileupload" + a).removeClass('required');
                            }
                        })

                        $('#phonevalidate' + a).on('input', function() {
                            const phoneNumber = $(this).val();
                            const numericOnly = phoneNumber.replace(/\D/g, '');
                            const limitedNumber = numericOnly.slice(0, 14);
                            const formattedNumber = limitedNumber.startsWith('91') ? "+" +
                                limitedNumber : "+91" + limitedNumber;
                            $(this).val(formattedNumber);
                        });

                        $("#dr_start_date" + a).datepicker({
                            dateFormat: 'dd-mm-yy',
                            numberOfMonths: 1,
                            changeMonth: true,
                            changeYear: true,
                            onSelect: function(selected) {
                                $("#dr_end_date" + a).datepicker("option", "minDate",
                                    selected);
                            }
                        });

                        $("#dr_end_date" + a).datepicker({
                            dateFormat: 'dd-mm-yy',
                            numberOfMonths: 1,
                            changeMonth: true,
                            changeYear: true,
                            onSelect: function(selected) {
                                $("#dr_start_date" + a).datepicker("option", "maxDate",
                                    selected);
                                var start = $("#dr_start_date" + a).val();
                                var end = $("#dr_end_date" + a).val();
                                var action = 'getdays';
                                $.ajax({
                                    type: "post",
                                    url: "ajax/getModalData.php",
                                    data: {
                                        'start_date': start,
                                        'end_date': end,
                                        'action': action
                                    },
                                    success: function(res) {
                                        // $(".start_date").val(start);
                                        $("#time_duration" + a).val(res);

                                    }
                                });


                            }
                        });
                    }
                });





                //Once remove button is clicked
                $(wrapper2).on('click', '.remove_field2', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    a--; //Decrement field counter
                });


                var addButton = $('.add_field_button3'); //Add button selector

                var wrapper3 = $('#add3'); //Input field wrapper
                <?php
if($_REQUEST['id']!=''){?>
                var x = <?php echo $i-1; ?>; //Initial field counter is 1
                var y = <?php echo $i; ?>
                <?php }else{?>
                var c = 0; //Initial field counter is 1
                var d = 0;
                <?php }?>
                //Once add button is clicked
                $(addButton).click(function() {





                    //Check maximum number of input fields
                    if (c < maxField) {
                        c++; //Increment field counter
                        d++; //Increment field counter
                        $(wrapper3).append(
                            '<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group"><select class="form-control" name="data2[' +
                            c +
                            '][designation_id]" id="designation_id"><option value="">Select your Designation</option><?php $sqlc=$obj->query("select * from $tbl_designation where status=1 group by name",$debug=-1);while($linec=$obj->fetchNextObject($sqlc)){ if($linec->name!=''){?><option value="<?php echo $linec->id ?>"><?php echo $linec->name ?></option><?php } } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[' +
                            c + '][start_date]" id="er_start_date' + c +
                            '"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[' +
                            c + '][end_date]" id="er_end_date' + c +
                            '"></div><div class="form-group"><input class="form-control form-control-lg" id="er_time_duration' +
                            c + '" type="text" placeholder="0 Year,6 Months" name="data2[' + c +
                            '][time_duration]"></div><div class="form-group"><select class="form-control" name="data2[' +
                            c + '][status]" id="er_status' + c +
                            '"><option value="status">Status</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option><option value="send_request">Send Request</option></select></div></div></div><div id="er_extra_field' +
                            c +
                            '" style="display: flex; justify-content:space-between;"><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_slip_number' +
                            c + '" name="data2[' + c +
                            '][slip_number]" placeholder="Request Slip Number"></div><div class="form-group"><input  type="file" name="data2[' +
                            c +
                            '][er_slip_photo]" multiple="multiple" class="manage_upload_button2"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="phonevalidatee' +
                            c + '" name="data2[' + c +
                            '][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_salary' +
                            c + '" name="data2[' + c +
                            '][salary]" placeholder="Salary"></div><div class="form-group"><input class="form-control form-control-lg" type="date" id="er_issue_date' +
                            c + '" name="data2[' + c +
                            '][issue_date]" placeholder="Issue Date"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_imp_remarks' +
                            c + '" name="data2[' + c +
                            '][imp_remarks]" placeholder="Important Remarks"><a href="#" class="remove_field3 exp-recom delete_btn">X</a></div></div>'
                        );

                        $("#er_extra_field" + c).hide();

                        $("#er_status" + c).change(function() {
                            er_status = $(this).val();
                            if (er_status == 'send_request') {
                                $("#er_extra_field" + c).attr('style', 'flex');
                                $("#er_extra_field" + c).show();
                                $("#er_slip_number" + c).addClass('required');
                                $("#phonevalidateman" + c).addClass('required');
                                $("#er_salary" + c).addClass('required');
                                $("#er_issue_date" + c).addClass('required');
                                $("#er_imp_remarks" + c).addClass('required');
                            } else {
                                $("#er_extra_field" + c).hide();
                                $("#er_slip_number" + c).removeClass('required');
                                $("#phonevalidateman" + c).removeClass('required');
                                $("#er_salary" + c).removeClass('required');
                                $("#er_issue_date" + c).removeClass('required');
                                $("#er_imp_remarks" + c).removeClass('required');
                            }
                        })



                        $('#phonevalidatee' + c).on('input', function() {
                            const phoneNumber = $(this).val();
                            const numericOnly = phoneNumber.replace(/\D/g, '');
                            const limitedNumber = numericOnly.slice(0, 14);
                            const formattedNumber = limitedNumber.startsWith('91') ? "+" +
                                limitedNumber : "+91" + limitedNumber;
                            $(this).val(formattedNumber);
                        });

                        $("#er_start_date" + c).datepicker({
                            dateFormat: 'dd-mm-yy',
                            numberOfMonths: 1,
                            changeMonth: true,
                            changeYear: true,
                            onSelect: function(selected) {
                                $("#er_end_date" + c).datepicker("option", "minDate",
                                    selected);
                            }
                        });

                        $("#er_end_date" + c).datepicker({
                            dateFormat: 'dd-mm-yy',
                            numberOfMonths: 1,
                            changeMonth: true,
                            changeYear: true,
                            onSelect: function(selected) {

                                $("#er_start_date" + c).datepicker("option", "maxDate",
                                    selected);
                                var start = $("#er_start_date" + c).val();
                                var end = $("#er_end_date" + c).val();


                                var action = 'getdays';

                                $.ajax({
                                    type: "post",
                                    url: "ajax/getModalData.php",
                                    data: {
                                        'start_date': start,
                                        'end_date': end,
                                        'action': action
                                    },
                                    success: function(res) {
                                        // $(".start_date").val(start);
                                        $("#er_time_duration" + c).val(res);

                                    }
                                });


                            }
                        });

                    }
                });

                //Once remove button is clicked
                $(wrapper3).on('click', '.remove_field3', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    c--; //Decrement field counter
                });




                var addButton = $('.add_field_button4'); //Add button selector

                var wrapper4 = $('#add4'); //Input field wrapper
                <?php
if($_REQUEST['id']!=''){?>
                var x = <?php echo $i-1; ?>; //Initial field counter is 1
                var y = <?php echo $i; ?>
                <?php }else{?>
                var e = 0; //Initial field counter is 1
                var f = 0;
                <?php }?>
                //Once add button is clicked
                $(addButton).click(function() {
                    //Check maximum number of input fields
                    if (e < maxField) {
                        e++; //Increment field counter
                        f++; //Increment field counter
                        $(wrapper4).append(
                            '<div class="course_add1 " style="position:relative"><div class="course_form add_mrgin" style="display:flex; justify-content: start;"><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="Amount(INR)" name="data3[' +
                            e +
                            '][amount]" id="amount"></div><div class="form-group" ><input class="form-control form-control-lg" type="text" placeholder="Notes"  name="data3[' +
                            e +
                            '][notes]" id="notes"></div><div class="form-group"><select class="form-control" name="data3[' +
                            e +
                            '][status]"><option value="status">Status</option><option value="outside">Outside</option><option value="self">Self </option><option value="partial">Partial </option><option value="hold">Hold </option><option value="pending_confirmation">Pending confirmation</option></select></div><a href="#" class="remove_field4 fund-recom delete_btn">X</a></div></div></div></div>'
                        );
                    }
                });

                //Once remove button is clicked
                $(wrapper4).on('click', '.remove_field4', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    e--; //Decrement field counter
                });



                var addButton = $('.add_field_button5');
                var wrapper5 = $('#add5');
                var s = 0;
                $(addButton).click(function() {
                    if (s < maxField) {
                        s++;
                        t = s + 1;

                        $(wrapper5).append(
                            '<div class="course_add1 " style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon" style="height: 35px;color: #fff;">Company ' +
                            t +
                            '</div></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><input type="text" class="required form-control" placeholder="Company Name" name="weresult[' +
                            s +
                            '][company_name]" id="company_name" value="" style="width: 250px;"></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="text" class="required form-control" placeholder="Designation" name="weresult[' +
                            s +
                            '][designation]" id="designation" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="date" class="form-control" placeholder="Start Date" name="weresult[' +
                            s +
                            '][start_date]" id="start_date" value="" style="width: 140px;"></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="date" class="form-control" placeholder="End Date" name="weresult[' +
                            s +
                            '][end_date]" id="end_date" value="" style="width: 140px;"></div></div></div><a href="#" class="remove_field5 fund-recom delete_btn">X</a></div></div>'
                        );
                    }
                });


                $(wrapper5).on('click', '.remove_field5', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove();
                    s--;
                });






                $("#course").change(function() {
                    var cname = $(this).val();
                    $('#login_id').attr("placeholder", cname + " Login Id");
                    $('#password').attr("placeholder", cname + " Password");
                    if (cname == 'MOI') {
                        $('#wirting').attr("disabled", "disabled");
                        $('#reading').attr("disabled", "disabled");
                        $('#listening').attr("disabled", "disabled");
                        $('#speaking').attr("disabled", "disabled");
                        $('#overall_bands').attr("disabled", "disabled");
                        $('#exam_date').attr("disabled", "disabled");
                    } else {
                        $('#wirting').attr("disabled", false);
                        $('#reading').attr("disabled", false);
                        $('#listening').attr("disabled", false);
                        $('#speaking').attr("disabled", false);
                        $('#overall_bands').attr("disabled", false);
                        $('#exam_date').attr("disabled", false);
                    }

                })
                //English Proficiency

                var addButtonmm = $('.add_english_proficiency'); //Add button selector
                var wrappermm = $('#add_english_proficiency_form'); //Input field wrapper
                <?php
if($_REQUEST['id']!=''){?>
                var mm = <?php echo $i-1; ?>; //Initial field counter is 1
                <?php }else{?>
                var mm = 0; //Initial field counter is 1
                <?php }?>
                //Once add button is clicked
                $(addButtonmm).click(function() {
                    //Check maximum number of input fields
                    if (mm < maxField) {
                        mm++; //Increment field counter
                        $(wrappermm).append(
                            '<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group" ><select class="form-control course" name="epresult[' +
                            mm + '][course]" id="course' + mm +
                            '"><option value="">Select Course</option><option value="IELTS">IELTS</option><option value="PTE">PTE</option><option value="TOEFL">TOEFL</option><option value="Duolingo">Duolingo</option><option value="MOI">MOI</option></select></div><div class="form-group"><input type="text" class="form-control wirting" placeholder="Writing" name="epresult[' +
                            mm + '][wirting]" id="wirting' + mm +
                            '" value="" style="width: 140px;"></div><div class="form-group"> <input type="text" class="form-control" placeholder="Reading " name="epresult[' +
                            mm + '][reading]" id="reading' + mm +
                            '" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Listening " name="epresult[' +
                            mm + '][listening]" id="listening' + mm +
                            '" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Speaking " name="epresult[' +
                            mm + '][speaking]" id="speaking' + mm +
                            '" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Overall Bands" name="epresult[' +
                            mm + '][overall_bands]" id="overall_bands' + mm +
                            '" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Date of Exam" name="epresult[' +
                            mm + '][exam_date]" id="exam_date' + mm +
                            '" value="" style="width: 140px;"></div></div><div class="row form-margin" style="display:flex;padding: 0 15px"><div class="form-group"><input type="text" class="form-control"  name="epresult[' +
                            mm + '][login_id]" id="login_id' + mm +
                            '" value="" placeholder="Login Id" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Password" ="epresult[' +
                            mm + '][password]" id="password' + mm +
                            '" value="" style="width: 140px;"></div></div><a href="#" class="remove_english_proficiency diploma-recom delete_btn">X</a></div></div>'
                        );

                    }


                    $("#course" + mm).change(function() {
                        var cnamee = $(this).val();

                        $('#login_id' + mm).attr("placeholder", cnamee + " Login Id");
                        $('#password' + mm).attr("placeholder", cnamee + " Password");
                        if (cnamee == 'MOI') {
                            $('#wirting' + mm).attr("disabled", "disabled");
                            $('#reading' + mm).attr("disabled", "disabled");
                            $('#listening' + mm).attr("disabled", "disabled");
                            $('#speaking' + mm).attr("disabled", "disabled");
                            $('#overall_bands' + mm).attr("disabled", "disabled");
                            $('#exam_date' + mm).attr("disabled", "disabled");
                        } else {
                            $('#wirting' + mm).attr("disabled", false);
                            $('#reading' + mm).attr("disabled", false);
                            $('#listening' + mm).attr("disabled", false);
                            $('#speaking' + mm).attr("disabled", false);
                            $('#overall_bands' + mm).attr("disabled", false);
                            $('#exam_date' + mm).attr("disabled", false);
                        }

                    })



                });




                //Once remove button is clicked
                $(wrappermm).on('click', '.remove_english_proficiency', function(e) {
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    mm--; //Decrement field counter
                });


                // $("#passport_no").keyup(function(){

                //     var value = $('#passport_no').val();

                //     var action='getpasport'
                //     $.ajax({
                //         type:"post",
                //         url:"ajax/getModalData.php",
                //         data :{
                //             'key' : value,'action': action              
                //         },          
                //         success:function(res){
                //             if (res==0) {
                //                 $("#submitbtn").removeAttr("disabled","disabled");
                //             }else{
                //                 $('#showSearchResult').show().html('This passprot number already add'); 
                //                 $("#submitbtn").attr("disabled","disabled");
                //             }

                //         }
                //     });

                // });



                $("#dr_status").change(function() {
                    dr_status = $(this).val();
                    if (dr_status == 'send_request') {
                        $(".extra_field").attr('style', 'flex');
                        $(".extra_field").show();
                        $("#dr_slip_number").addClass('required');
                        $("#dr_mother_name").addClass('required');
                        $("#phonevalidate").addClass('required');
                        $("#fileupload").addClass('required');
                    } else {
                        $(".extra_field").hide();
                        $("#dr_slip_number").removeClass('required');
                        $("#dr_mother_name").removeClass('required');
                        $("#phonevalidate").removeClass('required');
                        $("#fileupload").removeClass('required');
                    }
                })

                $("#er_status").change(function() {
                    dr_status = $(this).val();
                    if (dr_status == 'send_request') {
                        $("#er_extra_field").attr('style', 'flex');
                        $("#er_extra_field").show();
                        $("#er_slip_number").addClass('required');
                        $("#phonevalidateman").addClass('required');
                        $("#er_salary").addClass('required');
                        $("#er_issue_date").addClass('required');
                        $("#er_imp_remarks").addClass('required');
                    } else {
                        $("#er_extra_field").hide();
                        $("#er_slip_number").removeClass('required');
                        $("#phonevalidateman").removeClass('required');
                        $("#er_salary").removeClass('required');
                        $("#er_issue_date").removeClass('required');
                        $("#er_imp_remarks").removeClass('required');
                    }
                })



                $(".course").change(function() {
                    val = $(this).val();
                    //alert(val);
                    // if(val=='MOI'){
                    //     $(".wirting").attr("readonly", "readonly");
                    //     $("#reading").attr("readonly", "readonly");
                    //     $("#listening").attr("readonly", "readonly");
                    //     $("#speaking").attr("readonly", "readonly");
                    //     $("#overall_bands").attr("readonly", "readonly");
                    // }else{
                    //     $("#wirting").removeAttr("readonly", "readonly");
                    //     $("#reading").removeAttr("readonly", "readonly");
                    //     $("#listening").removeAttr("readonly", "readonly");
                    //     $("#speaking").removeAttr("readonly", "readonly");
                    //     $("#overall_bands").removeAttr("readonly", "readonly");
                    // }

                })

                $("#ten_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#ten_grade").val(pval);
                })
                $("#ten_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#ten_percent").val(pval);
                })
                $("#twl_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#twl_grade").val(pval);
                })
                $("#twl_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#twl_percent").val(pval);
                })
                $("#dip_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#dip_grade").val(pval);
                })
                $("#dip_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#dip_percent").val(pval);
                })
                $("#dip1_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#dip1_grade").val(pval);
                })
                $("#dip1_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#dip1_percent").val(pval);
                })
                $("#grd_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#grd_grade").val(pval);
                })
                $("#grd_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#grd_percent").val(pval);
                })
                $("#grd1_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#grd1_grade").val(pval);
                })
                $("#grd1_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#grd1_percent").val(pval);
                })
                $("#pgrd_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#pgrd_grade").val(pval);
                })
                $("#pgrd_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#pgrd_percent").val(pval);
                })
                $("#pgdrd_percent").change(function() {
                    pval = $(this).val() / 25;
                    $("#pgdrd_grade").val(pval);
                })
                $("#pgdrd_grade").change(function() {
                    pval = $(this).val() * 25;
                    $("#pgdrd_percent").val(pval);
                })



            });



            // function isNumberKey(evt) {
            //   var charCode = (evt.which) ? evt.which : evt.keyCode
            //   if (charCode > 31 && (charCode < 48 || charCode > 57))
            //     return false;
            //   return true;
            // }

            function isNumberKey(s) {
                var rgx = /^[0-9]*\.?[0-9]*$/;
                return s.match(rgx);
            }

            $("#passport_no").keypress(function() {
                $("#showSearchResult").hide();
            })
            </script>
            <script>
            $(function() {

                var dateToday = new Date();

                var dateFormat = "yy-mm-dd",
                    from = $(".start_date")

                    .datepicker({
                        changeMonth: true,
                        numberOfMonths: 1,
                        dateFormat: "yy-mm-dd",
                        // minDate: dateToday ,
                        // This was done to ensure that if user want he can change date to back date. It was temporarily.

                    })
                    .on("change", function() {
                        to.datepicker("option", "minDate", getDate(this));
                        //enableAllTheseDays();
                    }),
                    to = $(".end_date").datepicker({
                        changeMonth: true,
                        numberOfMonths: 1,
                        dateFormat: "yy-mm-dd",
                    })
                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                        //enableAllTheseDays();
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }
            });




            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [day, month, year].join('-');
            }

            function enableAllTheseDays(date) {

                var start = $("#start_date").val();
                var end = $("#end_date").val();
                var startDate = new Date(start); //YYYY-MM-DD
                var endDate = new Date(end); //YYYY-MM-DD

                var getDateArray = function(start, end) {
                    var arr = new Array();
                    var dt = new Date(start);
                    while (dt <= end) {
                        arr.push(formatDate(new Date(dt)));
                        dt.setDate(dt.getDate() + 1);
                    }
                    return arr;
                }

                var dateArr = getDateArray(startDate, endDate);
                enableDays = (dateArr);

                var sdate = $.datepicker.formatDate('dd-mm-yy', date)
                if ($.inArray(sdate, enableDays) != -1) {
                    return [true];
                }
                return [false];
            }
            </script>
            <script>
            var addButtonss = $('.add_uni_field_button');
            var wrapperunis = $('#universityRecommended_add');
            var xs = <?php echo $ur; ?>;
            maxField = 10;
            $(addButtonss).click(function() {
                if (xs < maxField) {
                    xs++;

                    $(wrapperunis).append(
                        '<div class="add" style="position:relative"><div class="row"><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">State</div><select name="uniRecommended[' +
                        xs + '][state_id]" id="state_id' + xs +
                        '" class="form-control"><option value="">State</option> <?php $sql = $obj->query("select state from $tbl_programmes where 1=1 and state!='' group by state order by state asc",-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->state ?>" ><?php echo getField('state',$tbl_state,$line->state) ?></option><?php } ?></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">University</div><select name="uniRecommended[' +
                        xs + '][university_id]" id="university_id' + xs +
                        '" class="form-control"><option value="">University</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Course</div><select name="uniRecommended[' +
                        xs + '][course_id]" id="course_id' + xs +
                        '" class="form-control"><option value="">Course</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Intake</div><select name="uniRecommended[' +
                        xs +
                        '][intake]" id="intake" class="form-control"><option value="">Intake</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November </option><option value="12">December</option></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Year</div><select name="uniRecommended[' +
                        xs +
                        '][year]" id="year" class="form-control"><option value="">Year</option><?php for($i=date('Y')-30; $i <=date('Y')+6; $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div></div><a href="#" class="remove_uni_field removeuniclss delete_btn">X</a></div>'
                    );
                }

                $('#state_id' + xs).change(function() {
                    var id = $('#state_id' + xs).val();
                    var action = 'get_UCR_state_id'
                    $.ajax({
                        type: "post",
                        url: "ajax/getModalData.php",
                        data: {
                            'key': id,
                            'action': action
                        },
                        success: function(res) {
                            $('#university_id' + xs).html(res);
                        }
                    });
                });

                $('#university_id' + xs).change(function() {
                    var id = $('#university_id' + xs).val();
                    var action = 'get_UCR_course_id'
                    $.ajax({
                        type: "post",
                        url: "ajax/getModalData.php",
                        data: {
                            'key': id,
                            'action': action
                        },
                        success: function(res) {
                            $('#course_id' + xs).html(res);
                        }
                    });
                });


            });


            $(wrapperuni).on('click', '.remove_uni_field', function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                xs--;
            });
            </script>
            <script>
            $('#state_ids').change(function() {
                var id = $('#state_ids').val();
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
            </script>
            <script>
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
            </script>
            <script>
            function change_type() {
                country_id = $("#country_id").val();
                val = $("#visa_id").val();
                if (val == 1 || val == 4) {
                    $.ajax({
                        method: "POST",
                        url: "controller.php",
                        data: {
                            change_type: val,
                            country_id: country_id
                        },
                        success: function(data) {
                            $("#change_type").html(data);
                        }
                    })
                    // $("#change_type").html(`
                    //  <div class="form-group">
                    //                 <div class="input-group">
                    //                     <div class="input-group-addon">Student Type</div>
                    //                     <select class="required form-control" name="student_type" id="student_type">
                    //                         <option value="">Select Student Type</option>
                    //                         <option value="1"
                    //                             <?php if($vResult_f->visa_sub_type==3 || $vResult_f->visa_sub_type==44){?>
                    //                             selected <?php } ?>>New</option>
                    //                         <!-- <option value="3">Refused</option> -->
                    //                         <option value="2" <?php if($vResult_f->visa_sub_type==48){?> selected
                    //                             <?php } ?>>Defer (Pending Interview)</option>
                    //                         <option value="4"
                    //                             <?php if($vResult_f->visa_sub_type==20 || $vResult_f->visa_sub_type==47){?>
                    //                             selected <?php } ?>>Re-apply (Same Intake)</option>
                    //                         <option value="6"
                    //                             <?php if($vResult_f->visa_sub_type==48 || $vResult_f->visa_sub_type==50){?>
                    //                             selected <?php } ?>>Re-apply(Defer)</option>
                    //                         <option value="5" <?php if($vResult_f->visa_sub_type==42){?> selected
                    //                             <?php } ?>>Re-Apply(New Applications)</option>
                    //                         <option value="7" <?php if($vResult_f->visa_sub_type==43){?> selected
                    //                             <?php } ?>>New(Outsider Refused)</option>
                    //                         <option value="8" <?php if($vResult_f->visa_sub_type==6){?> selected
                    //                             <?php } ?>>New (Filing Only)</option>
                    //                         <option value="9"
                    //                             <?php if($vResult_f->visa_sub_type==24 || $vResult_f->visa_sub_type==25){?>
                    //                             selected <?php } ?>>University Transfer</option>
                    //                     </select>
                    //                 </div>
                    //             </div>
                    // `);
                } else {
                    $.ajax({
                        method: "POST",
                        url: "controller.php",
                        data: {
                            change_type: val,
                            country_id: country_id
                        },
                        success: function(data) {
                            $("#change_type").html(data);
                        }
                    })
                }
            }
            </script>
            <script>
            function change_uk_premium(val) {
                if (val == 51) {
                    $(".show_uk_premium").show();
                    $(".show_uk_premium input").addClass('required');
                } else {
                    $(".show_uk_premium").hide();
                    $(".show_uk_premium input").val('');
                    $(".show_uk_premium input").removeClass('required');
                    $(".show_uk_premium input[type='checkbox']").prop("checked", false);
                }
            }
            </script>
            <script>
            function change_country(val) {
                if (val == 7) {
                    $("#change_country").html("Area");
                    $("#change_state").html("Preferred Country (Optional)");
                    $("#country_id option:first").text("Select Area");
                    $("#pre_state_id option:first").text("Preferred Country");
                } else {
                    $("#change_country").html("Country");
                    $("#change_state").html("Preferred State (Optional)");
                    $("#country_id option:first").text("Select Country");
                    $("#pre_state_id option:first").text("Preferred State");
                }
            }
            </script>
            <script>
            $("#country_id").change(function() {
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
            </script>
</body>

</html>