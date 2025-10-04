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

$whr = isset($_SESSION['whr']) ? $_SESSION['whr'] : '';
$whr1 = isset($_SESSION['whr1']) ? $_SESSION['whr1'] : '';
$join = isset($_SESSION['join']) ? $_SESSION['join'] : '';
$group = isset($_SESSION['group']) ? $_SESSION['group'] : '';


$sql1 = "SELECT a.id FROM $tbl_student AS a
    INNER JOIN $tbl_student_status AS b on a.id = b.stu_id $join
    WHERE 1=1 and b.cstatus = 'Visa Approved' $whr $whr1 $group";
$totalData = $obj->numRows($obj->query($sql1));
$totalFiltered = $totalData; 

$sql = "SELECT a.*,b.cdate as visa_date FROM $tbl_student AS a
    INNER JOIN $tbl_student_status AS b on a.id = b.stu_id $join
    WHERE 1=1 and b.cstatus = 'Visa Approved' $whr $whr1";

if (!empty($requestData['search']['value'])) {
    $searchValue = $requestData['search']['value'];
    $sql .= " AND (
            a.student_no LIKE '%$searchValue%' 
            OR a.cdate LIKE '%$searchValue%'
            OR a.stu_name LIKE '%$searchValue%'
            OR a.passport_no LIKE '%$searchValue%'
            OR a.student_contact_no LIKE '%$searchValue%'
            OR a.alternate_contact LIKE '%$searchValue%'
        )
    ";
}

$sql .=  " $group";
// echo $sql;
$totalFiltered = $obj->numRows($obj->query($sql));

$sql .= " ORDER BY a.id DESC LIMIT ".$requestData['start'].", ".$requestData['length'];

$query = $obj->query($sql);

$data = array();
$i = 1;
if(isset($_SESSION['stage_status']) && $_SESSION['stage_status']!=''){
    $vcstatus = "cstatus='".$_SESSION['stage_status']."'";
  }else{
    $vcstatus = "cstatus in ('Visa Approved', 'Visa Refused', 'Back-Out')";
  }
while ($line = $obj->fetchNextObject($query)) {
    $nestedData = array();

    
    $rSql = $obj->query("SELECT name FROM $tbl_student_relation WHERE sutdent_id = '".$line->id."' AND relation = 1");
    $rResult = $obj->fetchNextObject($rSql);

    $student_types = array(
        1 => 'New', 2 => 'Defer', 3 => 'Refused', 4 => 'Re-apply (Same Intake)', 
        5 => 'Re-Apply (New Applications)', 6 => 'Re-apply (Defer)', 
        7 => 'New (Outsider Refused)', 8 => 'New (Filing Only)', 9 => 'University Transfer'
    );
    $student_type = isset($student_types[$line->student_type]) ? $student_types[$line->student_type] : '';

    $google = $obj->query("SELECT * FROM $tbl_student_passport_noc WHERE stu_id = '".$line->id."' and value='google' ORDER BY id DESC");
    $res_google = $obj->fetchNextObject($google);
    if($obj->numRows($google) > 0){
      $r_google = "<span ".$color.">Issued By : ".getField('name',$tbl_admin,$res_google->user_id)."<br> At: $res_google->cdate</span>";
    }else{
      $r_google = '';
    }
    $video = $obj->query("SELECT * FROM $tbl_student_passport_noc WHERE stu_id = '".$line->id."' and value='video' ORDER BY id DESC");
    $res_video = $obj->fetchNextObject($video);
    if($obj->numRows($video) > 0){
      $r_video = "<span ".$color.">Issued By : ".getField('name',$tbl_admin,$res_video->user_id)."<br> At: $res_video->cdate</span>";
    }else{
      $r_video = '';
    }
    $statusSql = $obj->query("SELECT cstatus FROM $tbl_student_status WHERE stu_id = '".$line->id."' and cstatus='Visa Approved' ORDER BY cdate DESC LIMIT 1");
    $timeResult = $obj->fetchNextObject($statusSql);
    $status_v = isset($timeResult->cstatus) ? $timeResult->cstatus : '';

   
    $nestedData[] = "<span $color>".$line->student_no."</span>";
    $nestedData[] = "<span $color>".date("d M y", strtotime($line->visa_date))."</span>";
    $nestedData[] = "<span $color>".$line->stu_name."</span>";
    $nestedData[] = "<span $color>".$rResult->name."</span>";
    $nestedData[] = "<span $color>".$line->passport_no."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_country, $line->country_id)."</span>"; 
    $nestedData[] = "<span $color>".getField('name', $tbl_admin, $line->c_id)."</span>";
    $nestedData[] = "<span $color>".getField('name', $tbl_branch, $line->branch_id)."</span>";
    $nestedData[] = $r_google;
    $nestedData[] = $r_video;
    $nestedData[] = $status_v;
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'>
                        <i class='fa fa-edit' style='margin-right: 6px; font-size: 16px;'></i>
                    </a>";

    $data[] = $nestedData;
    $i++;
}

$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);

echo json_encode($json_data);
?>
