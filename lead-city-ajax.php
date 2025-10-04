<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
$requestData= $_REQUEST;
$columns = array(
  0 =>'id'
);

$sql=$obj->query("select COUNT(*) as num_rows from $tbl_location_cities as a inner join $tbl_location_states as b on a.state_id=b.id",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


  $sql="select a.*, b.name as state_name from $tbl_location_cities as a inner join $tbl_location_states as b on a.state_id=b.id";
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
    $sql .= " AND (a.name LIKE '{$searchValue}%' ";    
    $sql .= " OR b.name LIKE '{$searchValue}%')";
 
}
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
   $sql.=" ORDER BY a.name asc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();  
      $ch = '';   
    if($line->status=="1"){
        $ch = 'checked';
    }
    $total_leads = 0;
    $total_visits = 0;
    $total_students = 0;
    $leads = $obj->query("select count(*) as total from $tbl_lead where city_id='{$line->id}'");
    $total_lead = $obj->fetchNextObject($leads);
    $total_leads = $total_lead->total;
    $visits = $obj->query("select count(*) as total from $tbl_visit where city_id='{$line->id}'");
    $total_visit = $obj->fetchNextObject($visits);
    $total_visits = $total_visit->total;
    $students = $obj->query("select count(*) as total from $tbl_student where city_id='{$line->id}'");
    $total_student = $obj->fetchNextObject($students);
    $total_students = $total_student->total;

    $total_data = "<p>Total Leads => $total_leads</p> <p>Total Visits => $total_visits</p> <p>Total Students => $total_students</p>";
    $nestedData[] = "<input type='checkbox' value='{$line->id}' name='city_id[]'>";
    $nestedData[] = $line->id;
      $nestedData[] = $line->state_name;
      $nestedData[] = $line->name;
      $nestedData[] = $total_data;
      $nestedData[] = ' <div class="material-switch">
							<input id="someSwitchOptionPrimary'. $i.'"  type="checkbox" onchange="change_status(this,'. $line->id.')" value="'. $line->id.'" '.$ch.' data-one="'.$tbl_location_cities.'"/>
							<label for="someSwitchOptionPrimary'. $i.'" class="label-primary"></label>
						<div>';
      $nestedData[] = '<a href="javascript:void(0);"  onclick="getModalData('.$line->id .')"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> ';
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