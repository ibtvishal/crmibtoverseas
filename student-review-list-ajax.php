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
  
  $sql="SELECT a.*,b.user_id as review_user_id, b.cdate as review_cdate from $tbl_student AS a INNER JOIN $tbl_student_updated_time AS b on b.stu_id = a.id WHERE b.level_id = '22' $whr1";
if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.=" GROUP BY b.stu_id";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';

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
    }else{
        $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
      }
  

    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".date('d-M-Y h:i:s A',strtotime($line->review_cdate))."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->review_user_id)."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&sub_admin'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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