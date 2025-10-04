<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);
$whr1 = '';
if($_SESSION['whr1']!=''){
$whr1 = $_SESSION['whr1'];
}
if($_SESSION['whr2']!=''){
$whr2 = $_SESSION['whr2'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 $whr1 group by b.stu_id",$debug=-1);

$line=$obj->numRows($sql);
$totalData=$line;
$totalFiltered = $totalData; 

$sql="select a.* from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 $whr1";
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.id LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
}
$sql .= " group by b.stu_id";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo $sql;die;
$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      $visa='';
      $visaArr = explode(',',$line->visa_type_p);
      foreach ($visaArr as $key => $val) {
        $visa .= $val;
        $visa .="<br>";
      }

    
    $slip_data1 = '';
    $color = '';
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    $nestedData[] = "<span ".$color.">".$line->id."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_contact_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
    $nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&welcome'><i class='fa fa-eye' style='margin-right: 6px;font-size: 16px;'></i> </a> ";
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