<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();

$requestData= $_REQUEST;

$columns = array(
  0 =>'student_no', 
  1 =>'cdate', 
  2=>'stu_name',
  3 => 'passport_no',
  4 =>'country_id',
  5=>'c_id'
);


$sql=$obj->query("select COUNT(id) as num_rows from $tbl_student where 1=1 ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$whr1 = '';
$whr3 = '';
$join = '';
$group = '';
$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);

$whr1 = " and b.cstatus = 'Move to Visa Appointment'";
$whr2 = " and b.cstatus = 'Move to Visa Appointment'";
$whr3 = "";
$status = "1";
$group = "  GROUP BY b.stu_id";
if($_SESSION['whr1']!=''){
  $whr1 .= $_SESSION['whr1'];
}
if($_SESSION['whr3']!=''){
  $whr3 .= $_SESSION['whr3'];
}
if($_SESSION['join']!=''){
  $join = $_SESSION['join'];
}
if($_SESSION['group']!=''){
  $group = $_SESSION['group'];
}
if($_SESSION['status1']!=''){
  $status1 = $_SESSION['status1'];
}

if($status1 == 2){
  $whr1 .= " and c.biometric_date = '".date("Y-m-d")."'";
  $whr3 .= " and c.biometric_date = '".date("Y-m-d")."'";
}
if($status1 == 3){
  $whr1 .= " and c.interview_date = '".date("Y-m-d")."'";
  $whr3 .= " and c.interview_date = '".date("Y-m-d")."'";
}
if($status1 == 4){
  $whr1 .= " and c.biometric_date > '".date("Y-m-d")."'";
  $whr3 .= " and c.biometric_date > '".date("Y-m-d")."'";
}
if($status1 == 5){
  $whr1 .= " and c.interview_date > '".date("Y-m-d")."'";
  $whr3 .= " and c.interview_date > '".date("Y-m-d")."'";
}
if($status1 == 6){
  $whr1 .= " and interview_date!='' and biometric_date!='' and biometric_location!='' and interview_location!=''";
  $whr3 .= " and interview_date!='' and biometric_date!='' and biometric_location!='' and interview_location!=''";
}
if($status1 == 7){
  $whr1 .= " and (c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL)";
  $whr3 .= " and (c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL)";
}
if($status1 == 8){
  $whr1 .= " and priority='High'  and ( c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL)";
  $whr3 .= " and priority='High'  and ( c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL)";
}
if($status1 == 9){
  // $join = " inner join $tbl_student_status as b on a.id=b.stu_id";
  $status = 2;
  $group = " GROUP BY a.id HAVING COUNT(DISTINCT b.cstatus) = 2";
  $whr3 .= " and b.cstatus IN ('Visa Approved', 'Move to Visa Appointment')";
}
if($status1 == 10){
  // $join = " inner join $tbl_student_status as b on a.id=b.stu_id";
  $status = 2;
  $group = " GROUP BY a.id HAVING COUNT(DISTINCT b.cstatus) = 2";
  $whr3 .= " and b.cstatus IN ('Visa Refused', 'Move to Visa Appointment')";
}
if($status1 == 11){
  $whr1 = " and final_biometric_status='Not Appeared'";
  $whr3 .= " and final_biometric_status='Not Appeared'";
}
if($status1 == 12){
  $whr1 = " and final_interview_status='Not Appeared'";
  $whr3 .= " and final_interview_status='Not Appeared'";
}
if($status1 == 13){
  $whr1 = " and final_biometric_status='Appeared'";
  $whr3 .= " and final_biometric_status='Appeared'";
}
if($status1 == 14){
  $whr1 = " and final_interview_status='Appeared'";
  $whr3 .= " and final_interview_status='Appeared'";
}
if($status == 2){
  $condition = $whr3;
}else{
  $condition = $whr1;
}
$get_status = $_SESSION['get_status'];
$sql="select a.student_no, a.cdate as stu_cdate, a.stu_name, a.id as stu_id, a.passport_no, a.country_id, a.c_id, a.am_id, a.student_type,c.* from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1  $get_status $condition $group ";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";

}

$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
// echo $sql; die;

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
  $last_student = $obj->fetchNextObject($obj->query("select * from $tbl_student where student_no='".$line->student_no."' order by id desc"));
$nestedData=array(); 

  $showval = 1;

  if($showval == 1){
    $color='';
    
    $sqlf = $obj->query("select slot_type from $tbl_appointment where student_id='".$last_student->id."'",-1);
    $SlotResult = $obj->fetchNextObject($sqlf);
    if($SlotResult->slot_type!=''){
      $color = "";
    }else{
      $color = "style='color:red'";
    }


    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$last_student->student_type);
    if($line->slot_status == 'Booked'){
      $color = "style='color:green'";
    }
    if($line->interview_date == date('Y-m-d')){
      $color = "style='color:blue'";
    }
    if($line->priority == 'High'){
      $color = "style='color:orange'";
    }
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$last_student->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);

    $rSql_remark = $obj->query("select * from $tbl_student_appointment_remark where stu_id='".$last_student->id."' order by id desc");
    $rResult_remark = $obj->fetchNextObject($rSql_remark);
    $date = '';
  if($obj->numRows($rSql_remark) > 0){
  $date = "<br><br><p><b style='text-decoration:underline'>Date: </b>".date('d-M-Y',strtotime($rResult_remark->cdate))."</p>";
  }
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->stu_cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id))."</span>";
    $nestedData[] = "<span ".$color.">".$line->slot_type1."</span>";
    $nestedData[] = "<span ".$color.">".$line->priority."</span>";
    $nestedData[] = "<span ".$color.">".$line->preference."</span>";
    $nestedData[] = "<span ".$color.">".$line->biometric_date."</span>";
    $nestedData[] = "<span ".$color.">".$line->biometric_location."</span>";
    $nestedData[] = "<span ".$color.">".$line->interview_date."</span>";
    $nestedData[] = "<span ".$color.">".$line->interview_location."</span>";
    $nestedData[] = "<span ".$color.">".$line->pdf_status."</span>";
    $nestedData[] = "<span ".$color.">".$line->id_owner."</span>";
    $nestedData[] = "<span ".$color.">".$line->slot_status."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->slot_executive_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".$rResult_remark->remark."</span>".$date;
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($last_student->id)))."&type=slot'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
    
    $data[] = $nestedData;
  }
  
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