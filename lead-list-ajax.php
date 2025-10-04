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
  }
  else if($_SESSION['status']==3){
    $stauscontent='Not Intersted';
    $whr .= " $whr2 and ((inital_status=4 and followup1_status=0 ) 
    OR (followup1_status=4 and followup2_status =0 ) 
    OR (followup2_status=4 and  followup3_status =0 ) 
    OR (followup3_status=4 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==17){
    $stauscontent='Unable To Connect';
    $whr .= " $whr2 and ((inital_status=12 and followup1_status=0 ) 
    OR (followup1_status=12 and followup2_status =0 ) 
    OR (followup2_status=12 and  followup3_status =0 ) 
    OR (followup3_status=12 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==4){
    $stauscontent='Visited';
  }else if($_SESSION['status']==5){
    $stauscontent='Not Visited';
  }else if($_SESSION['status']==6){
    $stauscontent='Enrolled';
  }else if($_SESSION['status']==7){
    $stauscontent='Pending Daily Follow Ups';
    $whr .= " $whr2 and ((date(inital_next_followup_date) = '$todate' and followup1_remarks =0  and inital_remarks !=0  and inital_status not in (4,10,11) ) 
OR (date(followup1_next_followup_date) = '$todate' and followup2_remarks =0  and followup1_remarks !=0 and followup1_status not in (4,10,11) ) 
OR (date(followup2_next_followup_date) = '$todate' and  followup3_remarks =0  and followup2_remarks !=0   and followup2_status not in (4,10,11) ) 
OR (date(followup3_next_followup_date) = '$todate' and  last_followup_remarks=0  and followup3_remarks !=0   and followup3_status not in (4,10,11) ))";
  }else if($_SESSION['status']==8){
    $stauscontent='Pending 1st Follow Up';
    $whr .= " $whr2 and date(inital_next_followup_date) < '$mtodate' and inital_remarks !=0  and followup1_status=0 and inital_status not in (4,10,11)";
  }else if($_SESSION['status']==9){
    $stauscontent='Pending 2nd Follow Up';
    $whr .= "  $whr2 and date(followup1_next_followup_date) < '$mtodate'  and followup1_remarks !=0 and followup2_status=0 and followup1_status not in (4,10,11)";
  }else if($_SESSION['status']==10){
    $stauscontent='Pending 3rd Follow Up';
    $whr .= " $whr2 and date(followup2_next_followup_date) < '$mtodate'  and followup2_remarks !=0 and followup3_status=0 and followup2_status not in (4,10,11)";
  }else if($_SESSION['status']==11){
    $stauscontent='Pending Last Follow Up';
    $whr .= " $whr2 and date(followup3_next_followup_date) < '$mtodate'  and followup3_remarks !=0 and last_followup_status=0 and followup3_status not in (4,10,11)";
  }else if($_SESSION['status']==12){
    $stauscontent='Highly Interested';
    $whr .= " $whr2 and ((inital_status=8 and followup1_status=0 ) 
    OR (followup1_status=8 and followup2_status =0 ) 
    OR (followup2_status=8 and  followup3_status =0 )  
    OR (followup3_status=8 and  last_followup_status =0 ))";

  }
  else if($_SESSION['status']==13){
    $stauscontent='Partial Interested';
    $whr .= " $whr2 and ((inital_status=9 and followup1_status =0 ) 
    OR (followup1_status=9 and followup2_status =0 ) 
    OR (followup2_status=9 and  followup3_status =0 ) 
    OR (followup3_status=9 and  last_followup_status =0 ))";
  }
  else if($_SESSION['status']==16){
    $stauscontent='Today Outbound Calls';
    $whr .= " and (date(followup1_start_date) = '$todate' or date(followup2_start_date) = '$todate' or date(followup3_start_date) = '$todate' or date(last_followup_start_date) = '$todate')";
  }
  else if($_SESSION['status']==15){
    $stauscontent='Total Visited';
  }else{
    $_SESSION['status']=1;
    $stauscontent='';
  }

if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25 || in_array(4,$addtional_role)){
  if($_SESSION['status']==1){
    $sql=$obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr",$debug=-1);
    }else if($_SESSION['status']==4){
      $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no where 1=1 $whr1",$debug=-1);
      }else if($_SESSION['status']==5){
        $obj->query("SELECT COUNT(a.applicant_contact_no) as num_rows FROM $tbl_lead as a WHERE NOT EXISTS ( SELECT b.applicant_contact_no FROM $tbl_visit as b WHERE a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no ) $whr1 ",$debug=-1);
        }
        else if($_SESSION['status']==6){
          $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a $tbl_visa_sub_type_join join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1 $condition_of_visa_sub_type ",$debug=-1);
          }
        else if($_SESSION['status']==15){
          $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1",$debug=-1);
          }
          else{
            $sql=$obj->query("select COUNT($tbl_lead.id) as num_rows from $tbl_lead where 1=1 $whr2 $whr ",$debug=-1);
  }
}else{
  if($_SESSION['status']==1){
    $sql=$obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 and crm_executive_id='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
    }else if($_SESSION['status']==4){
      $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $whr1",$debug=-1);
      }else if($_SESSION['status']==5){
        $obj->query("SELECT COUNT(a.applicant_contact_no) as num_rows FROM $tbl_lead as a WHERE  NOT EXISTS ( SELECT b.applicant_contact_no FROM $tbl_visit as b WHERE a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no ) and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $whr1 ",$debug=-1);
        }
        else if($_SESSION['status']==6){
          $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a $tbl_visa_sub_type_join join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $condition_of_visa_sub_type",$debug=-1);
          }
        else if($_SESSION['status']==15){
          $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."'",$debug=-1);
          }
          else{
    $sql=$obj->query("select COUNT($tbl_lead.id) as num_rows from $tbl_lead where 1=1 $whr2 and crm_executive_id='".$_SESSION['sess_admin_id']."' $whr ",$debug=-1);
  }
}


$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25 || in_array(4,$addtional_role)){
    if($_SESSION['status']==1){
    $sql="select * from $tbl_lead where 1=1 $whr";
    }else if($_SESSION['status']==4){
      $sql="select a.* from $tbl_lead as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no where 1=1 $whr1";
      }else if($_SESSION['status']==5){
        $sql ="select a.* from $tbl_lead as a where NOT EXISTS (select b.applicant_contact_no from $tbl_visit as b WHERE a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no ) $whr1";
        }else if($_SESSION['status']==6){
          $sql="select a.* from $tbl_lead as a $tbl_visa_sub_type_join join  $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1 $condition_of_visa_sub_type $whr1 ";
          } else if($_SESSION['status']==15){
            $sql="select a.* from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 $whr3";
            }else{
    $sql="select $tbl_lead.* from $tbl_lead where 1=1 $whr2 $whr";
  }
}else{
  if($_SESSION['status']==1){
    $sql="select * from $tbl_lead where 1=1 and crm_executive_id='".$_SESSION['sess_admin_id']."' $whr";
    }else if($_SESSION['status']==4){
      $sql="select a.* from $tbl_lead as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $whr1";
      }else if($_SESSION['status']==5){
        $sql ="select a.* from $tbl_lead as a where NOT EXISTS (select b.applicant_contact_no from  $tbl_visit as b WHERE a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no) and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $whr1";
        }else if($_SESSION['status']==6){
          $sql="select a.* from $tbl_lead as a $tbl_visa_sub_type_join join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $condition_of_visa_sub_type $whr1";
          } else if($_SESSION['status']==15){
            $sql="select a.* from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $whr3" ;
            }else{
    $sql="select $tbl_lead.* from $tbl_lead where 1=1 $whr2 and crm_executive_id='".$_SESSION['sess_admin_id']."' $whr";
  }
}

 
if( !empty($requestData['search']['value']) ) {
  if($_SESSION['status']==1){
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
      
    $get = $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2 and id='".$line->id."' and
    ((date(inital_next_followup_date) <= '$todate' and followup1_remarks =0  and  inital_remarks !=0  and inital_status not in (4,10,11) ) 
    OR (date(followup1_next_followup_date) <= '$todate' and followup2_remarks =0  and followup1_remarks !=0 and followup1_status not in (4,10,11) ) 
    OR (date(followup2_next_followup_date) <= '$todate' and  followup3_remarks =0  and followup2_remarks !=0 and followup2_status not in (4,10,11) ) 
    OR (date(followup3_next_followup_date) <= '$todate' and  last_followup_remarks=0  and  followup3_remarks !=0 and followup3_status not in (4,10,11) ))");
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
      if($line->inital_status!=0 && $line->followup1_status==0 && $line->followup2_status==0 && $line->followup3_status==0 && $line->last_followup_status==0){
        $status = getField('name',$tbl_lead_status,$line->inital_status);
      }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status==0 && $line->followup3_status==0 && $line->last_followup_status==0){
        $status = getField('name',$tbl_lead_status,$line->followup1_status);
      }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status==0 && $line->last_followup_status==0){
        $status = getField('name',$tbl_lead_status,$line->followup2_status);
      }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status!=0 && $line->last_followup_status==0){
        $status = getField('name',$tbl_lead_status,$line->followup3_status);
      }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status!=0 && $line->last_followup_status!=0){
        $status = getField('name',$tbl_lead_status,$line->last_followup_status);
      }
      

  
      $sql1 = $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1  and a.id='".$line->id."' $whr1 ",$debug=-1);
      $line8=$obj->fetchNextObject($sql1);
     

      $sqlss = $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_contact_no or a.applicant_contact_no = b.applicant_alternate_no or a.applicant_alternate_no = b.applicant_alternate_no  where 1=1 and a.id='".$line->id."'",$debug=-1);
      $line6=$obj->fetchNextObject($sqlss);
      if($line8->num_rows > 0){
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
        $delete = "<a href='javascript:void' onclick=\"warning('Do you want to delete it?','controller.php?lead_delete_id=".base64_encode(base64_encode(base64_encode($line->id)))."')\" ><i class='fa fa-trash' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      }
      if( $_SESSION['transfer_lead'] == 1){
        $nestedData[] = '<th><input type="checkbox" name="leadIdarr[]" value="'.$line->id.'"></th>';
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
      $nestedData[] = "<span ".$color.">".$line->lead_no."</span>";
      $nestedData[] = "<span ".$color.">".$line->cdate."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."<br>".$line->applicant_alternate_no."</span>";
      // $nestedData[] = "<span ".$color.">".getField('name',$tbl_location_states,$line->state_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_location_cities,$line->city_id)."</span>";
      // $nestedData[] = "<span ".$color.">".$line->visa_type."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->crm_executive_id)."</span>";
      // $nestedData[] = "<span ".$color.">".$line->source."</span>";
      $nestedData[] = "<span ".$color.">".$status."</span>";
      $nestedData[] = $system_status;
      $nestedData[] = "<span ".$color.">".$all_remarks."</span>";
      $nestedData[] = "<a target='_blank' href='lead-addf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a> $delete";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9){
      $nestedData[] = $appointment;
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