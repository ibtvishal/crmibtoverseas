<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);
$whr1 = '';
if($_SESSION['whr1']!=''){
$whr1 = $_SESSION['whr1'];
}
if($_SESSION['whr2']!=''){
$whr2 = $_SESSION['whr2'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);

$sql=$obj->query("SELECT COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1 $whr1 $whr2 group by a.id",$debug=-1);

$line=$obj->numRows($sql);
$totalData=$line;
$totalFiltered = $totalData; 

$sql="SELECT a.id,a.applicant_name,a.father_name,a.pre_country_id,a.visa_sub_type,a.applicant_contact_no,a.branch_id,a.councellor_id,c.student_no,c.id as stu_id, c.cdate as admission_date from $tbl_visit as a inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1  $whr1 $whr2";

if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.id LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' ";
  $sql .= " OR c.student_no LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
}
$sql.=" group by a.id";
// echo $sql;die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      $visa='';
      $visaArr = explode(',',$line->visa_type_p);
      foreach ($visaArr as $key => $val) {
        $visa .= $val;
        $visa .="<br>";
      }

    $color = '';
    $seven_days_ago = date("Y-m-d", strtotime("-52 days"));
    $get_welcome_call_count = $obj->numRows($obj->query("SELECT * FROM $tbl_welcome where stu_id='{$line->stu_id}' and welcome_call_no=2"));
    if($line->admission_date < $seven_days_ago && $get_welcome_call_count == 0){
        $color = " style='color:red'";
    }
    $slip_data1 = '';
    $nestedData[] = "<span ".$color.">".$line->id."</span>";
    // $nestedData[] = "<span ".$color.">".$line->payment_date."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
    // $nestedData[] = "<span ".$color.">".$visa."</span>";
    $nestedData[] = "<span ".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->councellor_id)."</span>";
    // $nestedData[] = "<span ".$color.">".$line->after_visa_fee_commitment."</span>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&welcome'><i class='fa fa-eye' style='margin-right: 6px;font-size: 16px;'></i> </a> ";
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