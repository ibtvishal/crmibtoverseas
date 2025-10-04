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


  $sql="SELECT a.* FROM $tbl_student AS a
          WHERE a.university_transfer = '1' $b_id  $whr1 $half";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.=" GROUP BY a.student_no";
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
  $last_student = $obj->fetchNextObject($obj->query("select * from $tbl_student where student_no='".$line->student_no."' order by id desc"));
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';
  
    $uemail='';
    $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->id."'");
    while($urResult = $obj->fetchNextObject($urSql)){
      if($urResult->offical_email!=''){
        $uemail = $urResult->offical_email;
      }
    }
 
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    $stu_status = $obj->fetchNextObject($obj->query("select cstatus from $tbl_student_status where stu_id='".$line->id."' and parent_id=0 order by id desc"));
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$uemail."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id))."</span>";
    $nestedData[] = "<span ".$color.">".$stu_status->cstatus."</span>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($last_student->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

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