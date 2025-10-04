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

$sql=$obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_spoken_classe AS b on b.visit_id = a.id where 1=1 $whr1 GROUP BY a.id",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

  $sql="SELECT a.* FROM $tbl_visit AS a INNER JOIN $tbl_spoken_classe AS b on b.visit_id = a.id where 1=1 $whr1";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.applicant_name LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.father_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.applicant_alternate_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.applicant_contact_no LIKE '".$requestData['search']['value']."%') ";
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
    
    if($line->spoken_date_status == 0){
      $status = "Inactive";
      $card = '';
      $onclick = "onclick='change_pending_status({$line->id})'";
    }else{
      $status = "Active";
      $card = "<a href='interview-slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&spoken' target='_blank' class='text-primary'><i class='fa fa-eye'></i></a>";
    }
    if($line->spoken_status == 0){
      $btn = "<a class='btn btn-danger' href='javascript:void' onclick='change_pending_status1({$line->id})'>Pending</a>";
    }else{
      $btn = "<a class='btn btn-success' $onclick>$status</a>";
    }
       $btn_view = '';
    $rSql_count = $obj->numRows($obj->query("select id from tbl_spoken_branch where visit_id='".$line->id."'"));
    if($rSql_count > 0){
      $btn_view = "<a class='text-primary' onclick='get_branch_log({$line->id})'><i class='fa fa-eye'></i></a>";
    }
    $update_branch = "<a href='javascript:void;' onclick='update_branch({$line->id})' class='btn btn-primary'>Update Branch</a> $btn_view";
    $logs = "<a href='javascript:void;' onclick='get_log({$line->id})' class='text-primary'><i class='fa fa-eye'></i></a>";
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
    $nestedData[] = "<span ".$color.">".$line->id."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->councellor_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = $card;
    $nestedData[] = $btn;
    // $nestedData[] = $status;
    $nestedData[] = $logs;
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
    $nestedData[] = $update_branch;
     }
    // $nestedData[] = "<a href='visit-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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