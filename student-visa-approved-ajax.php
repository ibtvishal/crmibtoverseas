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
$join = '';
if($_SESSION['level_id']==1){
}
elseif($_SESSION['level_id']==15 || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==25){
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
if($_SESSION['join']!=''){
  $join = $_SESSION['join'];
}

  // $sql="SELECT a.*,c.sattlement_amount_status,c.fee_payment,c.tt_receipt_no,c.advisor_meeting,c.after_visa_fee FROM $tbl_student AS a
  //         INNER JOIN $tbl_student_status AS b on b.stu_id = a.id 
  //           LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id
  //         WHERE b.cstatus = 'Visa Approved' $b_id  $whr1 $half and a.id NOT IN (
  //                   SELECT sub.stu_id 
  //                   FROM (
  //                       SELECT stu_id, cstatus
  //                       FROM $tbl_student_status
  //                       WHERE (stu_id, id) IN (
  //                           SELECT stu_id, MAX(id)
  //                           FROM $tbl_student_status
  //                           GROUP BY stu_id
  //                       )
  //                   ) AS sub
  //                   WHERE sub.cstatus IN ('Visa Refused', 'Back-Out'))";
  $sql="SELECT a.*,b.cstatus,c.sattlement_amount_status,c.fee_payment,c.tt_receipt_no,c.advisor_meeting,c.after_visa_fee,c.en_id,c.defer_next_intake, CASE 
           WHEN c.visa_issue_date != '' THEN c.visa_issue_date 
           ELSE b.cdate 
       END AS visa_approved_date FROM $tbl_student AS a
          INNER JOIN $tbl_student_status AS b on b.stu_id = a.id  $join
            LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id
          WHERE b.cstatus = 'Visa Approved' $b_id  $whr1 $half";

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
 
  $showval = 1;

  if($showval == 1){
    $color='';
    
    // if(($line->fee_payment == 'Settlement' && $line->sattlement_amount_status == 'Pending') || ($line->fee_payment == 'Paying Fee' && $line->tt_receipt_no == '')){
    //   $color = 'style="color:blue"';
    // }
    // if(($line->fee_payment == 'Settlement' && $line->sattlement_amount_status == 'Received') || ($line->fee_payment == 'Paying Fee' && $line->tt_receipt_no != '')){
    //   $color = 'style="color:green;font-weight:bold"';
    // }
    
      if((($line->fee_payment == 'Settlement' && $line->sattlement_amount_status == 'Received') || ($line->fee_payment == 'Paying Fee' && $line->tt_receipt_no != '') || $line->fee_payment == 'Fee Payment at University') || ($line->advisor_meeting == 'Not Required' || $line->advisor_meeting == 'Required - Done') || $line->after_visa_fee == 'Paid'){
      $color = 'style="color:blue"';
    }
    if((($line->fee_payment == 'Settlement' && $line->sattlement_amount_status == 'Received') || ($line->fee_payment == 'Paying Fee' && $line->tt_receipt_no != '') || $line->fee_payment == 'Fee Payment at University') && ($line->advisor_meeting == 'Not Required' || $line->advisor_meeting == 'Required - Done') && $line->after_visa_fee == 'Paid'){
      $color = 'style="color:green;font-weight:bold"';
    }
    $uemail='';
    $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->id."'");
    while($urResult = $obj->fetchNextObject($urSql)){
      if($urResult->offical_email!=''){
        $uemail = $urResult->offical_email;
      }
    }
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
    if($line->defer_next_intake == 1){
      $color = 'style="color:#ff7600"';
    }
    if($line->defer_next_intake == 2){
      $color = 'style="color:"';
    }
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->visa_approved_date))."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$uemail."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->en_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id))."</span>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=enrollment'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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