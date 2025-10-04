<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);

$todate = date('Y-m-d');
$whr = ''; 
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}


$sql=$obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 
$whr ",$debug=-1);


$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 



$sql="select * from $tbl_visit where 1=1 
$whr ";

// echo $sql; die;
if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( applicant_name LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR applicant_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR applicant_alternate_no LIKE '".$requestData['search']['value']."%' )";
}


$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";



$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
    $nestedData=array();     
      $nestedData[] = $line->id;
      $nestedData[] = $line->cdate;
      $nestedData[] = $line->applicant_name;
      $nestedData[] = $line->dob;
      $nestedData[] = $line->father_name;
      $nestedData[] = getField('name',$tbl_country,$line->pre_country_id);
      $nestedData[] = $line->visa_type;
      $nestedData[] = $line->applicant_contact_no;
      $nestedData[] = $line->address;
      $nestedData[] = getField('name',$tbl_branch,$line->branch_id);
      $nestedData[] = getField('name',$tbl_admin,$line->councellor_id);
      $nestedData[] = getField('name',$tbl_admin,$line->telecaller_id);
        $nestedData[] = "<a href='visit-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
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