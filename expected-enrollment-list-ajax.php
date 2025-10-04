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
$todate = date('Y-m-d');
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}
 $sql = $obj->query("select COUNT(*) as num_rows from $tbl_visit  where 1=1 and expected_enrollment_date is not null $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


  $sql="select * from $tbl_visit  where 1=1 and expected_enrollment_date is not null $whr";

if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  if($_SESSION['status']!=4 && $_SESSION['status']!=5){
    $sql .= " AND (applicant_name LIKE '{$searchValue}%' ";    
    $sql .= " OR applicant_contact_no LIKE '{$searchValue}%' ";
    $sql .= " OR id LIKE '{$searchValue}%' ";
    $sql .= " OR applicant_alternate_no LIKE '{$searchValue}%')";
  }else{ 
  $sql .= " AND (applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR applicant_contact_no LIKE '{$searchValue}%' ";
  $sql .= " OR id LIKE '{$searchValue}%' ";
  $sql .= " OR applicant_alternate_no LIKE '{$searchValue}%')";
  }
}
// echo $sql;die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
   $sql.=" ORDER BY id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      $visa='';
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
    
    $sql3 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type in ('Enrollment','Direct Enrollment')");
    $result_fee_count1 = $obj->numRows($sql3);
    $result_fee_12 = $obj->fetchNextObject($sql3);
    if($result_fee_count1 > 0){
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
          $slip_data1 = "<a href='student-addf.php?vid=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa-solid fa-school' style='margin-right: 6px;font-size: 16px;'></i></a>";
        }else{
          $slip_data1 = '';
        }
      }else{
        $slip_data1 = '';
      }
    }else{
      $slip_data1 = '';
    } 
    
    $tsql = $obj->query("select id from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
      $tnumR = $obj->numRows($tsql);

      if($tnumR>0){
        $expected_enrollment = '';
        $color = "style='color:green'"; 
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
      $get_tel = $obj->query("select * from $tbl_lead where applicant_contact_no in ('".$line->applicant_contact_no."','".$line->applicant_alternate_no."') or applicant_alternate_no in ('".$line->applicant_contact_no."','".$line->applicant_alternate_no."')");
      $res_get_tel = $obj->fetchNextObject($get_tel);
      if($line->telecaller_id != ''){
        $tel_caller = $line->telecaller_id;
      }else{
        $tel_caller = $res_get_tel->crm_executive_id;
      }
      if($line->claim_staus == 0){
        $claim = "<a href='javascript:void(0);' onclick='warning(\"controller.php?claim_id=".base64_encode(base64_encode(base64_encode($line->id)))."\")' class='btn btn-danger'>Claim</a>";
      }elseif($line->claim_staus == 1){
        $claim = "<a href='javascript:void(0);' class='btn btn-primary'>Claim Pending</a>";
      }else{
        $claim = "<a href='javascript:void(0);' class='btn btn-success'>Claimed</a>";
      }
      $nestedData[] = "<span ".$color.">".$line->id."</span>";
      $nestedData[] = "<span ".$color.">".$line->cdate."</span>";
      $nestedData[] = "<span ".$color.">".$result_fee_12->payment_date."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->dob."</span>";
      $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".$visa."</span>";
      $nestedData[] = "<span ".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
      $nestedData[] = "<span ".$color.">".$line->source."</span>";
      $nestedData[] = "<span ".$color.">".$line->address."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span ".$color.">".$conss."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$tel_caller)."</span>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
      $nestedData[] = $expected_enrollment;
      }
      $nestedData[] = "<a href='visit-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      if($_SESSION['level_id'] != 14 || !in_array(6,$addtional_role) || $_SESSION['level_id'] != 11 || !in_array(1,$addtional_role)){
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