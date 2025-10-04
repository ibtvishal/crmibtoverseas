<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();

$requestData= $_REQUEST;

$columns = array(
  0 =>'a.app_id'
);


$whr = '';
$whr1 = '';

$sql=$obj->query("select COUNT(id) as num_rows from $tbl_student_application where 1=1 ",$debug=-1);

$line=$obj->fetchNextObject($sql); 
$totalData=$line->num_rows;
$totalFiltered = $totalData; 
$whr = $_SESSION['whr'];
$whr1 = $_SESSION['whr1'];

if($_SESSION['filling_executive_id']){
  $sql="select a.*,b.id as sid,b.student_no,b.stu_name,b.branch_id,b.c_id,b.am_id,b.fm_id,c.fe_id from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and c.fe_id='".$_SESSION['filling_executive_id']."' $whr $whr1";
}else{
  $sql="select a.*,b.id as sid,b.student_no,b.stu_name,b.branch_id,b.c_id,b.am_id,b.fm_id from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id where 1=1 $whr $whr1";
}

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.app_id LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR b.student_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR b.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.course LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.month LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.year LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.status LIKE '".$requestData['search']['value']."%') ";
}


$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

//echo $sql; die;
$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
    $nestedData=array(); 

    $filingManger='';
    if($line->fm_id){
      $filingManger = getField('name',$tbl_admin,$line->fm_id);
    }else{
      if($_SESSION['filling_executive_id']){
        $filingManger = getField('name',$tbl_admin,getFieldWhere('fe_id',$tbl_filing_credentials,'student_id',$line->sid));
      }else{
        $filingManger = getField('name',$tbl_admin,$line->fe_id);
      }
      
    }

    $uemail='';
    $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->sid."'");
    while($urResult = $obj->fetchNextObject($urSql)){
      if($urResult->offical_email!=''){
        $uemail .= $urResult->offical_email;
        $uemail .="</br>";
      }
    }

    $nestedData[] = $line->app_id;
    $nestedData[] = $line->student_no;
    $nestedData[] = $line->stu_name;
    $nestedData[] = $uemail;
    $nestedData[] = getField('name','tbl_univercity',$line->college_name);
    $nestedData[] = getField('state','tbl_state',$line->location);
    $nestedData[] = $line->course;
    $nestedData[] = $line->month;
    $nestedData[] = $line->portal_status;
    $nestedData[] = $line->year;
    $nestedData[] = getField('name',$tbl_branch,$line->branch_id);
    $nestedData[] = getField('name',$tbl_admin,$line->c_id);
    $nestedData[] = getField('name',$tbl_admin,$line->am_id);
    $nestedData[] = $filingManger;
    $nestedData[] = $line->status;
    $nestedData[] = $line->remarks;
    if($_SESSION['level_id']!=7 && $_SESSION['level_id']!=8){
      $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->sid)))."&app_id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
    }
    $data[] = $nestedData;
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