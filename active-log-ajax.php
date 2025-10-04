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
$whr = '';
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}

$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_login_logs as a inner join $tbl_admin as b on a.user_id=b.id where 1=1 $whr ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 







  $sql="select b.*, a.id as log_id, a.address as log_address, a.ip_address as ip_address, a.city as log_city, a.state as log_state, a.cdate as log_cdate,a.device as device from $tbl_login_logs as a inner join $tbl_admin as b on a.user_id=b.id where 1=1 $whr ";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( b.name LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR b.phone LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR b.email LIKE '".$requestData['search']['value']."%' )";
}
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
    $color = '';
    $nestedData[] = "<span ".$color.">".date("d M y h:i:s A",strtotime($line->log_cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->phone."</span>";
    $nestedData[] = "<span ".$color.">".$line->ip_address."</span>";
    $nestedData[] = "<span style='filter: blur(4px);cursor: not-allowed;user-select: none;-webkit-user-select: none;-ms-user-select: none; '>".$line->log_address."</span>";
    // $nestedData[] = "<span ".$color.">".$line->device."</span>";

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