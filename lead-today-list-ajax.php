<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);

$whr='';
if($_SESSION['whr']){
  $whr = $_SESSION['whr'];
}
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a where 1=1 and status=1 and management_datetime is not null $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


$sql="select a.* from $tbl_lead as a  where 1=1 and status=1 and management_datetime is not null $whr";


//echo $sql; die;
if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.applicant_name LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR a.applicant_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.applicant_alternate_no LIKE '".$requestData['search']['value']."%' )";
}


$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" GROUP BY a.id ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";



$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
    $nestedData=array();

      $color = '';
      if($line->seen_status == 0){
        $color = 'style="color:red"';
      }
      $sql1 = $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1  and a.id='".$line->id."' $whr1 ",$debug=-1);
      $line8=$obj->fetchNextObject($sql1);

      $nestedData[] = "<span ".$color.">".$line->lead_no."</span>";
      $nestedData[] = "<span ".$color.">".$line->management_datetime."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."<br>".$line->applicant_alternate_no."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_location_states,$line->state_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_location_cities,$line->city_id)."</span>";
      $nestedData[] = "<span ".$color.">".$line->visa_type."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->crm_executive_id)."</span>";
      $nestedData[] = "<span ".$color.">".$line->source."</span>";
      $nestedData[] = "<a href='lead-addf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&lead_appointment'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9){
      $nestedData[] = "<a href='javascript:void' onclick='managent_meet({$line->id})'><i class='fa fa-address-card' style='margin-right: 6px;font-size: 16px;'></i> </a>";
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