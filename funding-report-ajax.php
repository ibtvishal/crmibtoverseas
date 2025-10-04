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
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}


  $sql="SELECT a.*,b.value FROM $tbl_student AS a INNER JOIN tbl_student_function AS b on b.stu_id = a.id WHERE 1=1 $whr1";
if(!empty($requestData['search']['value'])) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  b.cdate desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$query = $obj->query($sql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';
 
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);

    $edit = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

  if($res1->portal_status != 'Direct(Student)'){
    $res_com = $obj->fetchNextObject($sql_com);
    $nestedData[] = "<span ".$color.">".$i."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->dob."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".$line->value."</span>";
    $nestedData[] = $edit;
    $data[] = $nestedData;
  }
}
  
  $i++;
}

$json_data = array(
  "draw"            => intval( $requestData['draw']),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>