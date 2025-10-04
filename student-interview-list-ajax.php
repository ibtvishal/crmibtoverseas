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
$whr1 = '';
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}

$sql=$obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 $whr1 GROUP BY a.id",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

  $sql="SELECT a.*,b.cstatus,b.status_branch,b.cdate as interview_date FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 $whr1";

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
$sql.=" ORDER BY  a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';

    $onclick = '';
    $logs = '';
    
    if($line->interview_status == 0){
      $status = "Inactive";
      $card = '';
      $clr = "warning";
      $onclick = "onclick='change_pending_status({$line->id},{$line->status_branch})'";
    }else{
      $status = "Active";
      $clr = "success";
      $card = "<a href='interview-slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&interview' target='_blank' class='text-primary'><i class='fa fa-eye'></i></a>";
    }
    if($line->immigration_trainning_status == 0){
      $btn = "<a class='btn btn-danger' href='javascript:void' onclick='change_pending_status({$line->id},{$line->status_branch})'>Pending</a>";
    }else{
      $btn = "<a class='btn btn-$clr' $onclick>$status</a>";
      $logs = "<a href='javascript:void;' onclick='get_log({$line->id})' class='text-primary'><i class='fa fa-eye'></i></a>";
    }
    $btn_view = '';
    $rSql_count = $obj->numRows($obj->query("select id from tbl_student_interview_branch where stu_id='".$line->id."'"));
    if($rSql_count > 0){
      $btn_view = "<a class='text-primary' onclick='get_branch_log({$line->id})'><i class='fa fa-eye'></i></a>";
    }
    $update_branch = "<a href='javascript:void;' onclick='update_branch({$line->id})' class='btn btn-primary'>Update Branch</a> $btn_view";
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);

    $get = $obj->fetchNextObject($obj->query("SELECT * FROM tbl_student_interview_preparation where stu_id='{$line->id}' and status=1 order by id desc"));
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->interview_date))."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->status_branch)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$get->user_id)."</span>";
    $nestedData[] = "<span ".$color.">".$get->class_start_date."</span>";
    $nestedData[] = "<span ".$color.">".$get->class_end_date."</span>";
    $nestedData[] = $status;
    $nestedData[] = $card;
    $nestedData[] = $btn;
     if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
    $nestedData[] = $update_branch;
     }
    $nestedData[] = $logs;
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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