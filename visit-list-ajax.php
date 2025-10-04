<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);
$whr = '';
$whr1 = '';
$whr2 = '';
$con = '';
$con1 = '';
$whr_new = '';
$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
$todate = date('Y-m-d');
$mtodate = date('Y-m-d' , strtotime(' -1 Days'));
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}
if($_SESSION['whr2']!=''){
  $whr2 = $_SESSION['whr2'];
}
if($_SESSION['con']!=''){
  $con = $_SESSION['con'];
}
if($_SESSION['con1']!=''){
  $con1 = $_SESSION['con1'];
}
if($_SESSION['whr_new']!=''){
  $whr_new = $_SESSION['whr_new'];
}
if($_SESSION['whr_new1']!=''){
  $whr_new1 = $_SESSION['whr_new1'];
}
if($_SESSION['status']==1){
  $stauscontent='Total Visits';
}else if($_SESSION['status']==2){
  $stauscontent='Intersted';
  $whr .= " $whr2 and (($tbl_visit.inital_status=3 and $tbl_visit.followup1_status=0) 
  OR ($tbl_visit.followup1_status=3 and $tbl_visit.followup2_status =0 ) 
  OR ($tbl_visit.followup2_status=3 and  $tbl_visit.followup3_status =0 ) 
  OR ($tbl_visit.followup3_status=3 and  $tbl_visit.last_followup_status =0 ))";
}
else if($_SESSION['status']==3){
  $stauscontent='Not Intersted';
  $whr .= " $whr2 and (($tbl_visit.inital_status=4 and $tbl_visit.followup1_status=0 ) 
  OR ($tbl_visit.followup1_status=4 and $tbl_visit.followup2_status =0 ) 
  OR ($tbl_visit.followup2_status=4 and  $tbl_visit.followup3_status =0 ) 
  OR ($tbl_visit.followup3_status=4 and  $tbl_visit.last_followup_status =0 ))";
}
else if($_SESSION['status']==13){
  $stauscontent='Unable To Connect';
  $whr .= " $whr2 and (($tbl_visit.inital_status=8 and $tbl_visit.followup1_status=0 ) 
  OR ($tbl_visit.followup1_status=8 and $tbl_visit.followup2_status =0 ) 
  OR ($tbl_visit.followup2_status=8 and  $tbl_visit.followup3_status =0 ) 
  OR ($tbl_visit.followup3_status=8 and  $tbl_visit.last_followup_status =0 ))";
}
else if($_SESSION['status']==4){
  $stauscontent='Enrolled';
  $whr .= " and $tbl_visit.visit_status='Enrolled'";
}else if($_SESSION['status']==5){
  $stauscontent='Not Enrolled'; 
  $whr .= " and ($tbl_visit.visit_status is null or $tbl_visit.visit_status!='Enrolled')";
}else if($_SESSION['status']==6){
  $stauscontent='Pending Daily Follow Up';
  $whr .= " $whr2 and ((date($tbl_visit.inital_next_followup_date) = '$todate' and $tbl_visit.followup1_remarks =0  and $tbl_visit.inital_status!='4')
  OR (date($tbl_visit.followup1_next_followup_date) = '$todate' and $tbl_visit.followup2_remarks =0  and $tbl_visit.followup1_status!='4')
  OR (date($tbl_visit.followup2_next_followup_date) = '$todate' and  $tbl_visit.followup3_remarks =0  and $tbl_visit.followup2_status!='4')
  OR (date($tbl_visit.followup3_next_followup_date) = '$todate' and  $tbl_visit.last_followup_remarks=0  and $tbl_visit.followup3_status!='4'))";
}else if($_SESSION['status']==7){
  $stauscontent='Pending 1st Follow Up';
  $whr .= " $whr2 and date($tbl_visit.inital_start_date) < '$mtodate'  and $tbl_visit.followup1_status=0 and $tbl_visit.inital_status!='4'";
}else if($_SESSION['status']==8){
  $stauscontent='Pending 2nd Follow Up';
  $whr .= " $whr2 and date($tbl_visit.followup1_start_date) < '$mtodate'  and $tbl_visit.followup2_status=0 and $tbl_visit.followup1_status!='4'";
}else if($_SESSION['status']==9){
  $stauscontent='Pending 3rd Follow Up';
  $whr .= " $whr2 and date($tbl_visit.followup2_start_date) < '$mtodate'  and $tbl_visit.followup3_status=0 and $tbl_visit.followup2_status!='4'";
}else if($_SESSION['status']==10){
  $stauscontent='Pending Last Follow Up';
  $whr .= " $whr2 and date($tbl_visit.last_followup_start_date) < '$mtodate'  and $tbl_visit.last_followup_status=0 and $tbl_visit.followup3_status!='4'";
}else if($_SESSION['status']==11){
  $stauscontent='Partially Interested';
  $whr .= " $whr2 and (($tbl_visit.inital_status=6 and $tbl_visit.followup1_status=0 ) 
  OR ($tbl_visit.followup1_status=6 and $tbl_visit.followup2_status =0 ) 
  OR ($tbl_visit.followup2_status=6 and  $tbl_visit.followup3_status =0 ) 
  OR ($tbl_visit.followup3_status=6 and  $tbl_visit.last_followup_status =0 ))";
}else if($_SESSION['status']==12){
  $stauscontent='Highly Interested';
  $whr .= " $whr2 and (($tbl_visit.inital_status=7 and $tbl_visit.followup1_status=0 ) 
  OR ($tbl_visit.followup1_status=7 and $tbl_visit.followup2_status =0 ) 
  OR ($tbl_visit.followup2_status=7 and  $tbl_visit.followup3_status =0 ) 
  OR ($tbl_visit.followup3_status=7 and  $tbl_visit.last_followup_status =0 ))";
}else{
  $stauscontent='';
}
if($_SESSION['status']==1){
  $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 $whr $whr_new1",$debug=-1);
  }
  else if($_SESSION['status']==4){ 
    $obj->query("select COUNT(DISTINCT id) as num_rows from $tbl_visit $con where 1=1 $whr $whr_new1",$debug=-1);
    }else if($_SESSION['status']==5){
      $obj->query("select COUNT(id) as num_rows from $tbl_visit $con where 1=1 $whr $whr_new1",$debug=-1);
      }
      else{
  $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 $whr $whr_new1",$debug=-1);
}


$sql=$obj->query("select COUNT(*) as num_rows from $tbl_visit $con where 1=1 $whr $whr_new1",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


if($_SESSION['status']==1){
  $sql="select $tbl_visit.* from $tbl_visit $con where 1=1 $whr $whr_new1";
}
else if($_SESSION['status']==4){
 $sql="select DISTINCT * from $tbl_visit $con where 1=1 $whr $whr_new1 ";
}else if($_SESSION['status']==5){
  $sql="select * from $tbl_visit $con where 1=1 $whr $whr_new1";
}
else{
  $sql="select $tbl_visit.* from $tbl_visit $con  where 1=1 $whr $whr_new1";
}
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  // if($_SESSION['status']!=4 && $_SESSION['status']!=5){
    $sql .= " AND ($tbl_visit.applicant_name LIKE '{$searchValue}%' ";    
    $sql .= " OR $tbl_visit.applicant_contact_no LIKE '{$searchValue}%' ";
    $sql .= " OR $tbl_visit.id LIKE '{$searchValue}%' ";
    $sql .= " OR $tbl_visit.applicant_alternate_no LIKE '{$searchValue}%')";
  // }else{ 
  // $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  // $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' ";
  // $sql .= " OR a.id LIKE '{$searchValue}%' ";
  // $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
  // }
}
// echo $sql;die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
// if($_SESSION['status']==4){
//   $sql.=" ORDER BY a.id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//  }else if($_SESSION['status']==5){
//    $sql.=" ORDER BY a.id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//  }else{
   $sql.=" ORDER BY $tbl_visit.id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
//  }


$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      $visa='';
      $auditor_status='';
      $visaArr = explode(',',$line->visa_type);
      foreach ($visaArr as $key => $val) {
        $visa .= $val;
        $visa .="<br>";
      }
      $expected_enrollment = "<a href='javascript:void' onclick='expected_enrollment({$line->id})'><i class='fa fa-address-card' style='margin-right: 6px;font-size: 16px;'></i> </a>";

      $color = "";
      $slip_data11 = '';
      
      if($line->inital_status==4 || $line->followup1_status==4 || $line->followup2_status==4 || $line->followup3_status==4 || $line->last_followup_status==4){
        $expected_enrollment = '';
      }


      // $sql4 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' order by id desc",-1);
 


      if($_SESSION['level_id']==4){
        if($line->inital_status==0){
          $color = "style='color:red'";
        }else{
          $color = "";
        }        
      }
      if ($line->councellor_id !== '' && $line->councellor_id !== null) {
        $conselor = explode(',', $line->councellor_id);
        $cons = [];
        foreach ($conselor as $counselor_id) {
            $cons[] = getField('name', $tbl_admin, $counselor_id);
        }
        $conss = implode(', ', $cons);
    } else {
        $conss = '';
    }
    
    $sql31 = $obj->query("select * from $tbl_visa_sub_type where id='".$line->visa_sub_type."'");
    $result_fee_121 = $obj->fetchNextObject($sql31);

    $sql4 = $obj->query("select sum(percentage) as percentage,status from $tbl_profile_status where visit_id='".$line->id."' order by id desc",-1);
    $result_fee_count11 = $obj->numRows($sql4);
    $result_fee_11 = $obj->fetchNextObject($sql4);
    $sql3 = $obj->query("select sum(percentage) as percentage from $tbl_profile_status where visit_id='".$line->id."'");
    $result_fee_count1 = $obj->numRows($sql3);
    $result_fee_12 = $obj->fetchNextObject($sql3);
    if($result_fee_12->percentage > 0 && $result_fee_12->percentage >= $result_fee_121->registration_percentage){
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
          if($result_fee_12->percentage < 100){
            $color = ' style="color:blue"';
              $type_per = 'Registration';
            }else{
            $type_per = 'Enrolled';
          }
          $slip_data1 = "<a href='student-addf.php?vid=".base64_encode(base64_encode(base64_encode($line->id)))."&type=".$type_per."&status=".base64_encode($result_fee_11->status)."'><i class='fa-solid fa-school' style='margin-right: 6px;font-size: 16px;'></i></a>";
        }else{
          $slip_data1 = '';
        }      }else{
        $slip_data1 = '';
      }
    }else{
      $slip_data1 = '';
    } 
    
      $tsql = $obj->query("select id,type,student_no from $tbl_student where reapply_status=0 and (student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."') order by id desc");
      $tnumR = $obj->numRows($tsql);
      $tnumR_data = $obj->fetchNextObject($tsql);

      // if($tnumR>0){
      if($tnumR > 0){
        if($tnumR_data->type == 'Enrolled'){
          $color = "style='color:green'"; 
        }else{
        }
        $expected_enrollment = '';
        $slip_data1 = '<img src="img/green-circle.svg" style="height:20px">';
      }else{
        if($line->councellor_id==0){
          $color = "style='color:red'";
          $slip_data1 = $slip_data1;
        }else{
          if($line->inital_remarks == 0 || $line->inital_remarks == null){
            $color = "style='color:red'";
            $slip_data1 = $slip_data1;
          }
        }
      } 

      if($result_fee_12->percentage > 0 && $result_fee_12->percentage < $result_fee_121->registration_percentage){
        $color = " style='color:orange'"; 
      }
      $get_tel = $obj->query("select * from $tbl_lead where applicant_contact_no in ('".$line->applicant_contact_no."','".$line->applicant_alternate_no."') or applicant_alternate_no in ('".$line->applicant_contact_no."','".$line->applicant_alternate_no."')");
      $res_get_tel = $obj->fetchNextObject($get_tel);
      if($line->telecaller_id != ''){
        $tel_caller = $line->telecaller_id;
      }else{
        $tel_caller = $res_get_tel->crm_executive_id;
      }
      if($line->claim_staus == 0){
        $claim = "<a href='javascript:void(0);' onclick='warning({$line->id})' class='btn btn-danger'>Claim</a>";
      }elseif($line->claim_staus == 1){
        $claim = "<a href='javascript:void(0);' class='btn btn-primary'>Claim Pending</a>";
      }else{
        $claim = "<a href='javascript:void(0);' class='btn btn-success'>Claimed</a>";
      }
      
      $get_au = $obj->numRows($obj->query("select * from $tbl_profile_status where visit_id='{$line->id}'"));
      if($get_au > 0){
        $auditor_status = "<a href='javascript:void(0);' onclick='get_auditor_status({$line->id})' class='btn btn-success'>Status</a>";
      }


     
      if($result_fee_11->percentage < 100){
        if($line->councellor_id!=0){
          if($result_fee_11->percentage != 0){
            $btn_click = 'Upgrade';
          }else{
            $btn_click = 'Update';
          }
      // $slip_data11 = "<a style='padding: 5px 10px;' class='btn btn-success' onclick='get_modal(\"".base64_encode(base64_encode(base64_encode($line->id)))."\")'>Pay Now</a>";
      $slip_data11 = "<a href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Fresh' style='padding: 5px 10px;' class='btn btn-success'>$btn_click Profile</a>";
    }
  }else{
    $slip_data11 = 'Updated';
      }
      if($line->reapply_status == 1){
        $encoded_id = base64_encode(base64_encode(base64_encode($line->id)));
        $slip_data11 = "<a href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Reapply' style='padding: 5px 10px;' class='btn btn-success'>Reupgrade Profile</a>";
        $color = "style='color:red; font-weight:bold'"; 
        
      }
      elseif($line->university_change_status == 1){
        $encoded_id = base64_encode(base64_encode(base64_encode($line->id)));
        $slip_data11 = "<a href='javascript:void(0);' onclick='get_popup(\"$encoded_id\")' style='padding: 5px 10px;' class='btn btn-success'>Reupgrade Profile</a>";
        $color = "style='color:green; font-weight:bold'"; 
        
      }
      // elseif($line->university_change_status == 1){
      //       $slip_data11 = "<a href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Fresh' style='padding: 5px 10px;' class='btn btn-success'>Update Profile</a>";
      //     }
      else{
            // $slip_data11 = 'Updated';
          }

          $remarks = [
            'Initial Followup' => 'inital_additional_remarks', 
            'Followup 1' => 'followup1_additional_remarks', 
            'Followup 2' => 'followup2_additional_remarks',
            'Followup 3' => 'followup3_additional_remarks',
            'Last Followup' => 'last_followup_additional_remarks'
        ];
        
        $date_f = [
            'Initial Followup' => 'inital_start_date', 
            'Followup 1' => 'followup1_start_date', 
            'Followup 2' => 'followup2_start_date',
            'Followup 3' => 'followup3_start_date',
            'Last Followup' => 'last_followup_start_date'
        ];
        
        $all_remarks = '';
        
        foreach ($remarks as $key => $status_field) {
            if (!empty($line->$status_field)) {
                $date_field = $date_f[$key];
                $date_value = !empty($line->$date_field) ? ' (' . $line->$date_field . ')' : '';
                $all_remarks = '<div><span style="font-weight:bold">' . $key .$date_value. ' :- </span>' . $line->$status_field . '</div>';
            } else {
                break;
            }
        }
      $nestedData[] = "<span ".$color.">".$line->id."</span>";
      // $nestedData[] = "<span ".$color.">".$tnumR_data->student_no."</span>";
      $nestedData[] = "<span ".$color.">".$line->cdate."</span>";
      // $nestedData[] = "<span ".$color.">".$line->visit_status_date."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      // $nestedData[] = "<span ".$color.">".$line->enquiry_type."</span>";
      // $nestedData[] = "<span ".$color.">".$line->dob."</span>";
      $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
      // $nestedData[] = "<span ".$color.">".$line->schedule_date_time."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".$visa."</span>";
      // $nestedData[] = "<span ".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
      // $nestedData[] = "<span ".$color.">".$line->source."</span>";
      // $nestedData[] = "<span ".$color.">".$line->address."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_location_cities,$line->city_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span ".$color.">".$conss."</span>";
      $nestedData[] = "<span ".$color.">".$all_remarks."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$tel_caller)."</span>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
      $nestedData[] = $expected_enrollment;
      }
      $nestedData[] = "<a target='_blank' href='visit-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      if($_SESSION['level_id'] == 9){
        $nestedData[] = $claim;
      }
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
      $nestedData[] = $slip_data11;
      $nestedData[] = $auditor_status;
      }if($_SESSION['level_id'] != 14 || !in_array(6,$addtional_role) || $_SESSION['level_id'] != 11 || !in_array(1,$addtional_role)){
      $nestedData[] = $slip_data1;
      }
    $data[] = $nestedData;
    $i++;
  }
  
  

$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>