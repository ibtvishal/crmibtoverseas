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

$b_id = '';
$half = '';
if($_SESSION['level_id']==1){
}
elseif($_SESSION['level_id']==15 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $b_id =  " and a.branch_id in ($branch_id)";
}
elseif($_SESSION['level_id']==16){
    $b_id =  " and c.en_id = '".$_SESSION['sess_admin_id']."'";
}
$whr1 = '';
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}
if($_SESSION['half']!=''){
  $half = $_SESSION['half'];
}

$sql="SELECT a.student_no, 
a.id AS student_id, 
a.cdate AS student_cdate, 
a.stu_name AS stu_name, 
c.*, CASE 
    WHEN c.visa_issue_date != '' THEN c.visa_issue_date 
    ELSE b.cdate 
END AS visa_approved_date FROM $tbl_student AS a
INNER JOIN $tbl_student_status AS b on b.stu_id = a.id   LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id
WHERE b.cstatus = 'Visa Approved' $b_id $whr1 $half";

if( !empty($requestData['search']['value']) ) {
$sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
$sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.=" GROUP BY a.id";
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  visa_approved_date desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
    if($line->student_type==1){
      $student_type='New'; 
    }else if($line->student_type==6){
      $student_type='Re-apply(Defer)';
    }
    else if($line->student_type==3){
      $student_type='Refused';
    }
    else if($line->student_type==4){
      $student_type='Re-apply (Same Intake)';
    }
    else if($line->student_type==5){
      $student_type='Re-Apply(New Applications)';
    }
    else if($line->student_type==2){
      $student_type='Defer';
    }
    else if($line->student_type==7){
      $student_type='New(Outsider Refused)';
    }
    else if($line->student_type==8){
      $student_type='New (Filing Only)';
    }
    else if($line->student_type==9){
      $student_type='University Transfer';
    }
    if($line->defer_next_intake == 1){
      $color = 'style="color:#ff7600"';
    }
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->student_id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    $rSqla = $obj->query("select * from $tbl_student_enrollment_remark where stu_id='".$line->student_id."' and type=1 order by id desc");
    $rResults = $obj->fetchNextObject($rSqla);

    if($line->refund_status == 'Denied'){
      $color = 'style="color:red"';
    }
    if($line->refund_status == 'Approved'){
      $color = 'style="color:#10baff"';
    }
    if($line->refund_payment_status == 'Received'){
      $color = 'style="color:green"'; 
    }
    $date = '';
    if($obj->numRows($rSqla) > 0){
      $date = "<br><br><p><b style='text-decoration:underline'>Date: </b>".date('d-M-Y',strtotime($rResults->cdate))."</p>";
      }
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->student_id)))."&type=enrollment'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->portal_id."</span>";
    $nestedData[] = "<span ".$color.">".date('d-M-Y',strtotime($line->visa_approved_date))."</span>";
    $nestedData[] = "<span ".$color."'>".$line->university_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_applied_by."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_affidavit."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_reason."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_applied_date."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_commission_committed."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_status."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_payment_status."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_received_amount."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_comission_status."</span>";
    $nestedData[] = "<span ".$color.">".$line->refund_comission_received."</span>";
    $nestedData[] = "<span ".$color.">".$line->mode."</span>";
    $nestedData[] = "<span ".$color.">".$rResults->remark."</span>".$date;

    $data[] = $nestedData;
  }
  
  $i++;

$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>