<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();

$requestData= $_REQUEST;

$columns = array(
  0 =>'student_no', 
  1 =>'cdate', 
  2=>'stu_name',
  3 => 'passport_no',
  4 =>'country_id',
  5=>'c_id',
);

$whr = '';
if($_SESSION['whr']){
    $whr = $_SESSION['whr'];
}
// $sql=$obj->query("select a.id from $tbl_student as a INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id WHERE f.value IN ('With_Affidavit', 'Registration_Dues') AND NOT EXISTS ( SELECT 1 FROM $tbl_student_filing_noc f2 WHERE f2.stu_id = a.id AND f2.value = 'Financials') $whr GROUP BY a.id HAVING COUNT(DISTINCT f.value) = 2",$debug=-1);
$sql=$obj->query("select a.id from $tbl_student as a INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id WHERE f.value = 'Financials' and f.status=2 $whr GROUP BY a.id",$debug=-1);
$line=$obj->numRows($sql);
$totalData=$line;
$totalFiltered = $totalData; 

// $sql = "SELECT a.*
// FROM tbl_student a
// INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id
// WHERE f.value IN ('With_Affidavit', 'Registration_Dues')  AND NOT EXISTS ( SELECT 1 FROM $tbl_student_filing_noc f2 WHERE f2.stu_id = a.id AND f2.value = 'Financials')
//  $whr";
$sql = "select a.*,f.user_id as user_id_f,f.cdate as cdate_f from $tbl_student as a INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id WHERE f.value = 'Financials' and f.status=2 
 $whr";

if( !empty($requestData['search']['value'])) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.student_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.alternate_contact LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.= " GROUP BY a.id  ";
// echo $sql; die;

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$query = $obj->query($sql);


$data = array();
$i=1;
if(isset($_SESSION['stage_status']) && $_SESSION['stage_status']!=''){
  $vcstatus = "cstatus='".$_SESSION['stage_status']."'";
}else{
  $vcstatus = "cstatus in ('Visa Approved', 'Visa Refused', 'Back-Out')";
}
while($line=$obj->fetchNextObject($query)) { 
  $nestedData=array(); 
  
    $color='';
    $chk = "";
    //--------------------------------Father Name Start-------------------------------------------
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    //--------------------------------Father Name End-------------------------------------------
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
    }


    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>"; 
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->am_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">Issued By : ".getField('name',$tbl_admin,$line->user_id_f)."<br> At: $line->cdate_f</span>";
      $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
    $data[] = $nestedData;
  }
  
  $i++;

$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>