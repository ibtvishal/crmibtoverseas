<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();

$requestData = $_REQUEST;
$columns = array(
  0 =>'student_no', 
  1 =>'cdate', 
  2 =>'stu_name',
  3 => 'passport_no',
  4 => 'country_id',
  5 => 'c_id',
);

// Apply session filters if present
$whr = isset($_SESSION['whr']) ? $_SESSION['whr'] : '';

// Fetch the total number of records
$sql1 = "SELECT COUNT(id) as num_rows FROM $tbl_student";
$line = $obj->fetchNextObject($obj->query($sql1));
$totalData = $line->num_rows;
$totalFiltered = $totalData; 

// Main query for retrieving filtered data
$sql = "SELECT b.id,a.visa_sub_type, b.student_no, b.cdate, b.stu_name, b.passport_no, b.student_contact_no, 
           b.alternate_contact, b.student_type, b.am_id, b.c_id, b.branch_id,b.country_id,b.student_status
    FROM $tbl_visit AS a
    INNER JOIN $tbl_student AS b
        ON (
            a.applicant_contact_no = b.student_contact_no OR 
            a.applicant_alternate_no = b.student_contact_no OR 
            a.applicant_alternate_no = b.alternate_contact OR 
            a.applicant_contact_no = b.alternate_contact
        )
    WHERE 1=1 and b.visa_id in (2,3,5) $whr";

// Apply search filters
if (!empty($requestData['search']['value'])) {
    $searchValue = $requestData['search']['value'];
    $sql .= "
        AND (
            b.student_no LIKE '%$searchValue%' 
            OR b.cdate LIKE '%$searchValue%'
            OR b.stu_name LIKE '%$searchValue%'
            OR b.passport_no LIKE '%$searchValue%'
            OR b.student_contact_no LIKE '%$searchValue%'
            OR b.alternate_contact LIKE '%$searchValue%'
        )
    ";
}
$totalFiltered = $obj->numRows($obj->query($sql));

$sql .= " group  by b.student_no ORDER BY CASE WHEN b.am_id = 0 THEN 0 ELSE 1 END ASC, b.id DESC LIMIT ".$requestData['start'].", ".$requestData['length'];
// echo $sql;die;
$query = $obj->query($sql);

$data = array();
$i = 1;
if(isset($_SESSION['stage_status']) && $_SESSION['stage_status']!=''){
    $vcstatus = "cstatus='".$_SESSION['stage_status']."'";
  }else{
    $vcstatus = "cstatus in ('Visa Approved', 'Visa Refused', 'Back-out')";
  }
while ($line = $obj->fetchNextObject($query)) {
    $nestedData = array();
 
    $color='';
    $uemail='';
    $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->id."'");
    while($urResult = $obj->fetchNextObject($urSql)){
      if($urResult->offical_email!=''){
        $uemail = $urResult->offical_email;
      }
    }
    // Fetch the application status for the student
    $stageSql = $obj->query("SELECT * FROM $tbl_student_application WHERE stu_id = '".$line->id."' AND status = 'I-20 Received'");
    $color = ($obj->numRows($stageSql) > 1) ? "style='color:green'" : '';
    
    // Fetch student's relation name (Father's name)
    $rSql = $obj->query("SELECT name FROM $tbl_student_relation WHERE sutdent_id = '".$line->id."' AND relation = 1");
    $rResult = $obj->fetchNextObject($rSql);

    // Get student type description
    // $student_types = array(
    //     1 => 'New', 2 => 'Defer', 3 => 'Refused', 4 => 'Re-apply (Same Intake)', 
    //     5 => 'Re-Apply (New Applications)', 6 => 'Re-apply (Defer)', 
    //     7 => 'New (Outsider Refused)', 8 => 'New (Filing Only)', 9 => 'University Transfer'
    // );
    // $student_type = isset($student_types[$line->student_type]) ? $student_types[$line->student_type] : '';

    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);

    // Fetch student stage and visa status
    $statusSql = $obj->query("SELECT cstatus FROM $tbl_student_status WHERE stu_id = '".$line->id."' ORDER BY cdate DESC LIMIT 1");
    $timeResult = $obj->fetchNextObject($statusSql);
    $status_v = isset($timeResult->cstatus) ? $timeResult->cstatus : '';

    $stageSql2 = $obj->query("select * from $tbl_student_status where stu_id='".$line->id."' order by cdate desc");
    $timeResult2=$obj->fetchNextObject($stageSql2);
    $stageSql1 = $obj->query("select * from $tbl_student_status where stu_id='".$line->id."' and $vcstatus order by cdate desc");
    $timeResult1=$obj->fetchNextObject($stageSql1);
    if($timeResult1->cstatus=='Visa Approved' || $timeResult1->cstatus=='Visa Refused' || $timeResult1->cstatus=='Back-out'){
        $color = 'style="color:white"';
        $status_v = $timeResult1->cstatus;
    }else{
        $status_v = $timeResult2->cstatus;
    }
    if($line->am_id==0){
        $color = "style='color:red'"; 
      }
      $edit = '';
      if($line->student_status == 1){
        $edit = "<a target='_blank' href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'>
                        <i class='fa fa-edit' style='margin-right: 6px; font-size: 16px;'></i>
                    </a>";
      }elseif($line->student_status == 0){
        $edit = "<span style='color:red'>Audit Pending</span>";
      }else{
        $edit = "<span style='color:red'>Audit Disapproved</span>";
      }
    $nestedData[] = "<span $color>".$line->student_no."</span>";
    $nestedData[] = "<span $color>".date("d M y", strtotime($line->cdate))."</span>";
    $nestedData[] = "<span $color>".$line->stu_name."</span>";
    $nestedData[] = "<span $color>".$rResult->name."</span>";
    $nestedData[] = "<span $color>".$line->passport_no."</span>";
    // $nestedData[] = "<span $color>".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_country, $line->country_id)."</span>"; 
    $nestedData[] = "<span $color>".$line->intake."</span>";
    $nestedData[] = "<span $color>".$student_type."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_admin, $line->c_id)."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_admin, $line->am_id)."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_branch, $line->branch_id)."</span>";
    $nestedData[] = $status_v;
    $nestedData[] = $edit;

    $data[] = $nestedData;
    $i++;
}

// Final JSON response
$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);

echo json_encode($json_data);
?>
