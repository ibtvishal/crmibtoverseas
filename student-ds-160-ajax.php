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

$sql=$obj->query("SELECT COUNT(id) as num_rows FROM $tbl_student  where 1=1 $whr1",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


  $sql="SELECT * FROM $tbl_student  where 1=1 $whr1";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR passport_no LIKE '".$requestData['search']['value']."%') ";
}
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  id desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$query = $obj->query($sql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';

    if($line->ds_head_office_status == 2){
      if(($_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8) && $_SESSION['sess_admin_id'] != 73){
        $btn = "<a class='btn btn-danger' href='javascript:void'>Pending</a>";
      }else{
        $btn = "<a class='btn btn-danger' href='javascript:void' onclick='change_ds_pending({$line->id})'>Pending</a>";
      }
    }else{
        $btn = "<a class='btn btn-success'>Approved</a><br><span></span>";
    }
    if($line->branch_ds_160_status == 0){
        $btn1 = "<a class='btn btn-danger' href='javascript:void'>Pending</a>";
    }else{
        $btn1 = "<a class='btn btn-success'>Approved</a></span>";
    }
    $disabled = '';
    if($_SESSION['level_id'] != 7 && $_SESSION['level_id'] != 8){
      $disabled = 'disabled';
    }
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->ds_head_office_added_at))."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$uemail."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = $btn;
    $nestedData[] = "<textarea class='form-control' style='width:300px' disabled>{$line->ho_remark}</textarea>";
    $nestedData[] = $btn1;
    $nestedData[] = "<textarea class='form-control' style='width:300px' $disabled onkeyup='change_remark(this.value,{$line->id})'>{$line->branch_remark}</textarea>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=ds-160'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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