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

$sql=$obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$sql="select * from $tbl_lead where 1=1 $whr";

// echo $sql; die;
if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( applicant_name LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR applicant_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR applicant_alternate_no LIKE '".$requestData['search']['value']."%' )";
}

// echo $sql;die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";



$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
    $nestedData=array();     

        
    $remarks='';
    $status='';

    

    if($line->inital_status!=0 && $line->followup1_status==0 && $line->followup2_status==0 && $line->followup3_status==0 && $line->last_followup_status==0){
      $status = getField('name',$tbl_lead_status,$line->inital_status);
    }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status==0 && $line->followup3_status==0 && $line->last_followup_status==0){
      $status = getField('name',$tbl_lead_status,$line->followup1_status);
    }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status==0 && $line->last_followup_status==0){
      $status = getField('name',$tbl_lead_status,$line->followup2_status);
    }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status!=0 && $line->last_followup_status==0){
      $status = getField('name',$tbl_lead_status,$line->followup3_status);
    }else if($line->inital_status!=0 && $line->followup1_status!=0 && $line->followup2_status!=0 && $line->followup3_status!=0 && $line->last_followup_status!=0){
      $status = getField('name',$tbl_lead_status,$line->last_followup_status);
    }
    


    if($line->inital_remarks!=0 && $line->followup1_remarks==0 && $line->followup2_remarks==0 && $line->followup3_remarks==0 && $line->last_followup_remarks==0){
      $remarks = getField('remarks',$tbl_lead_remarks_status,$line->inital_remarks);
    }else if($line->inital_remarks!=0 && $line->followup1_remarks!=0 && $line->followup2_remarks==0 && $line->followup3_remarks==0 && $line->last_followup_remarks==0){
      $remarks = getField('remarks',$tbl_lead_remarks_status,$line->followup1_remarks);
    }else if($line->inital_remarks!=0 && $line->followup1_remarks!=0 && $line->followup2_remarks!=0 && $line->followup3_remarks==0 && $line->last_followup_remarks==0){
      $remarks = getField('remarks',$tbl_lead_remarks_status,$line->followup2_remarks);
    }else if($line->inital_remarks!=0 && $line->followup1_remarks!=0 && $line->followup2_remarks!=0 && $line->followup3_remarks!=0 && $line->last_followup_remarks==0){
      $remarks = getField('remarks',$tbl_lead_remarks_status,$line->followup3_remarks);
    }else if($line->inital_remarks!=0 && $line->followup1_remarks!=0 && $line->followup2_remarks!=0 && $line->followup3_remarks!=0 && $line->last_followup_remarks!=0){
      $remarks = getField('remarks',$tbl_lead_remarks_status,$line->last_followup_remarks);
    }

      $nestedData[] = $line->id;
      $nestedData[] = $line->cdate;
      $nestedData[] = $line->applicant_name;
      $nestedData[] = $line->applicant_contact_no."<br>".$line->applicant_alternate_no;
      $nestedData[] = getField('name',$tbl_location_states,$line->state_id);
      $nestedData[] = getField('name',$tbl_location_cities,$line->city_id); 
      $nestedData[] = $line->visa_type;
      $nestedData[] = getField('name',$tbl_country,$line->pre_country_id);
      $nestedData[] = getField('name',$tbl_branch,$line->branch_id);
      $nestedData[] = getField('name',$tbl_admin,$line->crm_executive_id);
      $nestedData[] = $line->source;
      $nestedData[] = $status;
      $nestedData[] = $remarks;
        $nestedData[] = "<a href='lead-addf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
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