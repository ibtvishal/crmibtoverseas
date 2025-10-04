<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);
$tbl_visa_sub_type_join = " join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) inner join $tbl_visa_sub_type as d on a.visa_sub_type=d.id";
$condition_of_visa_sub_type = " and d.enrollment_count=1";
$whr = '';
$whr1 = '';
$whr2 = '';
$whr3 = '';
$todate = date('Y-m-d');
$mtodate = date('Y-m-d',strtotime('-1 Days'));
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}
if($_SESSION['whr2']!=''){
  $whr2 = $_SESSION['whr2'];
}
if($_SESSION['whr3']!=''){
  $whr3 = $_SESSION['whr3'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);


  if($_SESSION['status']==1){
    $stauscontent='Total Leads';
  }else if($_SESSION['status']==2){
    $stauscontent='Intersted';
    $whr .= " $whr2 and ((inital_status=3 and followup1_status=0 ) 
    OR (followup1_status=3 and followup2_status =0 ) 
    OR (followup2_status=3 and  followup3_status =0 ) 
    OR (followup3_status=3 and  last_followup_status =0 ))";  
  }else if($_SESSION['status']==3){
    $stauscontent='Not Intersted';
    $whr .= " $whr2 and ((inital_status=4 and followup1_status=0 ) 
    OR (followup1_status=4 and followup2_status =0 ) 
    OR (followup2_status=4 and  followup3_status =0 ) 
    OR (followup3_status=4 and  last_followup_status =0 ))";
  }else if($_SESSION['status']==4){
    $stauscontent='Visited';
  }else if($_SESSION['status']==5){
    $stauscontent='Not Visited';
    $whr .= " and inital_status!=11 AND followup1_status!=11 AND followup2_status!=11 AND followup3_status!=11 AND last_followup_status!=11";
  }else if($_SESSION['status']==6){
    $stauscontent='Admitted';
    // $whr .= "  and (inital_status=10 OR followup1_status=10 OR followup2_status=10 OR followup3_status=10 OR last_followup_status=10)";
  }else if($_SESSION['status']==7){
    $stauscontent='Pending Daily Follow Ups';
    $whr .= " $whr2 and ((date(inital_next_followup_date) = '$todate' and followup1_remarks =0  and inital_status not in (4,10,11) ) 
OR (date(followup1_next_followup_date) = '$todate' and followup2_remarks =0  and followup1_status not in (4,10,11) ) 
OR (date(followup2_next_followup_date) = '$todate' and  followup3_remarks =0  and followup2_status not in (4,10,11) ) 
OR (date(followup3_next_followup_date) = '$todate' and  followup4_remarks =0  and followup3_status not in (4,10,11) ) 
OR (date(followup4_next_followup_date) = '$todate' and  followup5_remarks =0  and followup4_status not in (4,10,11) ) 
OR (date(followup5_next_followup_date) = '$todate' and  followup6_remarks =0  and followup5_status not in (4,10,11) ) 
OR (date(followup6_next_followup_date) = '$todate' and  last_followup_remarks=0  and followup6_status not in (4,10,11) ))";
  }else if($_SESSION['status']==8){
    $stauscontent='Pending 1st Follow Up';
    $whr .= " $whr2 and date(inital_next_followup_date) <= '$todate'  and followup1_status=0 and inital_status not in (4,10,11)";
  }else if($_SESSION['status']==9){
    $stauscontent='Pending 2nd Follow Up';
    $whr .= "  $whr2 and date(followup1_next_followup_date) <= '$todate'  and followup2_status=0 and followup1_status not in (4,10,11)";
  }else if($_SESSION['status']==10){
    $stauscontent='Pending 3rd Follow Up';
    $whr .= " $whr2 and date(followup2_next_followup_date) <= '$todate'  and followup3_status=0 and followup2_status not in (4,10,11)";
  }else if($_SESSION['status']==11){
    $stauscontent='Pending Last Follow Up';
    $whr .= " $whr2 and date(followup6_next_followup_date) <= '$todate'  and last_followup_status=0 and followup6_status not in (4,10,11)";
  }else if($_SESSION['status']==12){
    $stauscontent='Highly Interested';
    $whr .= " $whr2 and ((inital_status=8 and followup1_status=0 ) 
    OR (followup1_status=8 and followup2_status =0 ) 
    OR (followup2_status=8 and  followup3_status =0 )  
    OR (followup3_status=8 and  followup4_status =0 )  
    OR (followup4_status=8 and  followup5_status =0 )  
    OR (followup5_status=8 and  followup6_status =0 )  
    OR (followup6_status=8 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==13){
    $stauscontent='Partial Interested';
    $whr .= " $whr2 and ((inital_status=9 and followup1_status =0 ) 
    OR (followup1_status=9 and followup2_status =0 ) 
    OR (followup2_status=9 and  followup3_status =0 ) 
    OR (followup3_status=9 and  followup4_status =0 ) 
    OR (followup4_status=9 and  followup5_status =0 ) 
    OR (followup5_status=9 and  followup6_status =0 ) 
    OR (followup6_status=9 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==20){
    $stauscontent='Unable To Connect';
    $whr .= " $whr2 and ((inital_status=12 and followup1_status =0 )
    OR (followup1_status=12 and followup2_status =0 ) 
    OR (followup2_status=12 and  followup3_status =0 ) 
    OR (followup3_status=12 and  followup4_status =0 ) 
    OR (followup4_status=12 and  followup5_status =0 ) 
    OR (followup5_status=12 and  followup6_status =0 ) 
    OR (followup6_status=12 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==15){
    $stauscontent='Total Visited';
    $whr .= " and (inital_status=11 OR followup1_status=11 OR followup2_status=11 OR followup3_status=11 OR last_followup_status=11) ";
  }
  else if($_SESSION['status']==16){
    $stauscontent='Today Outbound Calls';
    $whr .= " and (date(followup1_start_date) = '$todate' or date(followup2_start_date) = '$todate' or date(followup3_start_date) = '$todate' or date(last_followup_start_date) = '$todate')";
  }
  else if($_SESSION['status']==17){
    $stauscontent='Pending 4th Follow Up';
    $whr .= " $whr2 and date(followup3_next_followup_date) <= '$todate'  and followup4_status=0 and followup3_status not in (4,10,11)";
  }
  else if($_SESSION['status']==18){
    $stauscontent='Pending 5th Follow Up';
    $whr .= " $whr2 and date(followup4_next_followup_date) <='$todate'  and followup5_status=0 and followup4_status not in (4,10,11)";
  }
  else if($_SESSION['status']==19){
    $stauscontent='Pending 6th Follow Up';
    $whr .= " $whr2 and date(followup5_next_followup_date) <= '$todate'  and followup6_status=0 and followup5_status not in (4,10,11)";
  }
  else{
    $_SESSION['status']=1;
    $stauscontent='';
  }

    $sql=$obj->query("select COUNT(id) as num_rows from tbl_lead_enquiry where 1=1 $whr ",$debug=-1);
  
$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


if($_SESSION['status']==15){
  $sql="select a.* from tbl_lead_enquiry as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and b.enquiry_type!='Re-apply' $whr3 ";
}
elseif($_SESSION['status']==5){
  $sql="SELECT a.* FROM tbl_lead_enquiry as a LEFT JOIN $tbl_visit AS b 
  ON a.applicant_contact_no = b.applicant_contact_no
  OR a.applicant_alternate_no = b.applicant_alternate_no
  OR a.applicant_contact_no = b.applicant_alternate_no
  OR a.applicant_alternate_no = b.applicant_contact_no
  WHERE b.applicant_contact_no IS NULL $whr1 ";
}elseif($_SESSION['status']==6){
  $sql="select a.* from tbl_lead_enquiry as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no  where 1=1 and (b.inital_status=8 OR b.followup1_status=8 OR b.followup2_status=8  OR b.followup3_status=8 OR b.followup4_status=8 OR b.followup5_status=8 OR b.followup6_status=8 OR b.last_followup_status=8) $whr1";
}
else{
  $sql="select tbl_lead_enquiry.* from tbl_lead_enquiry where 1=1 $whr";
}
  

 
if( !empty($requestData['search']['value']) ) {
  if($_SESSION['status']!=15 && $_SESSION['status']!=5 && $_SESSION['status']!=6){
    $sql.=" AND ( applicant_name LIKE '".$requestData['search']['value']."%' ";    
    $sql.=" OR lead_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR applicant_contact_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR applicant_alternate_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR visa_type LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR source LIKE '".$requestData['search']['value']."%' )";
  }else{
    $sql.=" AND ( a.applicant_name LIKE '".$requestData['search']['value']."%' ";    
    $sql.=" OR a.lead_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR a.applicant_contact_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR a.applicant_alternate_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR a.visa_type LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR a.source LIKE '".$requestData['search']['value']."%' )";
  }
}

$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
// echo $sql;die;

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
    $nestedData=array();
    $get = $obj->query("select COUNT(id) as num_rows from tbl_lead_enquiry where 1=1 $whr2 and id='".$line->id."' and
    ((date(inital_next_followup_date) <= '$todate' and followup1_status =0  and inital_status not in (4,10,11) ) 
    OR (date(followup1_next_followup_date) <= '$todate' and followup2_status =0  and followup1_status not in (4,10,11) ) 
    OR (date(followup2_next_followup_date) <= '$todate' and  followup3_status =0  and followup2_status not in (4,10,11) ) 
    OR (date(followup3_next_followup_date) <= '$todate' and  followup4_status =0  and followup3_status not in (4,10,11) ) 
    OR (date(followup4_next_followup_date) <= '$todate' and  followup5_status =0  and followup4_status not in (4,10,11) ) 
    OR (date(followup5_next_followup_date) <= '$todate' and  followup6_status =0  and followup5_status not in (4,10,11) ) 
    OR (date(followup6_next_followup_date) <= '$todate' and  last_followup_status=0  and followup6_status not in (4,10,11) ))");
    $lines=$obj->fetchNextObject($get);
    $remarks='';
    $status='';
    $appointment = "<a href='javascript:void' onclick='managent_meet({$line->id})'><i class='fa fa-address-card' style='margin-right: 6px;font-size: 16px;'></i> </a>";
    if($line->inital_status==4 || $line->followup1_status==4 || $line->followup2_status==4 || $line->followup3_status==4 || $line->last_followup_status==4){
        $appointment = '';
    }
    $color = '';
    $system_status = '';
    if($lines->num_rows != 0){
        $color = 'style="color:red"'; 
    }
    
    if($line->inital_status == 0){
        $color = 'style="color:red"'; 
    }
    
    $statuses = [
        'inital_status', 'followup1_status', 'followup2_status', 'followup3_status', 'last_followup_status'
    ];
    
    foreach ($statuses as $status_field) {
        if ($line->$status_field != 0) {
            $status = getField('name', 'tbl_enquiry_status', $line->$status_field);
        } else {
            break;
        }
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
    
    
    
    
      $sqlss = $obj->query("select COUNT(a.id) as num_rows from tbl_lead_enquiry as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no  where 1=1 and a.id='".$line->id."'",$debug=-1);
      $line6=$obj->fetchNextObject($sqlss);
      $sqlss1 = $obj->query("select COUNT(a.id) as num_rows from tbl_lead_enquiry as a join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1  and a.id='".$line->id."'",$debug=-1);
      $line61=$obj->fetchNextObject($sqlss1);
      if($line61->num_rows > 0){
          $color = ''; 
          $color = 'style="color:white"'; 
          $system_status = 'Enrolled';
          $appointment = '';
      }elseif($line6->num_rows > 0){
        $color = 'style="color:green"'; 
        $system_status = 'Visited';
        $appointment = '';
    }
      if( $_SESSION['level_id'] == 1){
          $delete = "<a href='javascript:void' onclick=\"warning('Do you want to delete it?','controller.php?enquiry_delete_id=".base64_encode(base64_encode(base64_encode($line->id)))."')\" ><i class='fa fa-trash' style='margin-right: 6px;font-size: 16px;'></i> </a>";
        }
        if( $_SESSION['transfer_lead'] == 1){
            $nestedData[] = '<th><input type="checkbox" name="leadIdarr[]" value="'.$line->id.'"></th>';
        }
        $change_alternate = '';
        if($line->change_alternate == 0){
            $change_alternate = "<a href='javascript:void' onclick='change_alternate({$line->id})'><i class='fa fa-exchange' style='margin-right: 6px;font-size: 16px;'></i> </a>";
        }
      $nestedData[] = "<span ".$color.">".$line->lead_no."</span>";
      $nestedData[] = "<span ".$color.">".$line->cdate."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->crm_executive_id)."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".$line->visa_type."</span>";
      $nestedData[] = "<span ".$color.">".$line->url."</span>";
      $nestedData[] = $status;
      $nestedData[] = $system_status;
      $nestedData[] = "<span ".$color.">".$all_remarks."</span>";
      $nestedData[] = "<a href='add-new-enquiry.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."' target='_blank'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a> $delete";
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