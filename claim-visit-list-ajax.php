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
if($_SESSION['whr']!=''){
$whr = $_SESSION['whr'];
}


$sql=$obj->query("select count(b.id) as num_rows from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where 1=1 $whr1 $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


// echo $sql; die;

$sql="select a.*,b.user_id,b.status as claim_status,b.id as claim_id,b.updated_by  from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where 1=1 $whr1 $whr";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
}

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY b.id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      if($_SESSION['level_id'] != 9){
        if($line->claim_status==0){
        $claim = '<a href="javascript:void(0);" class="btn btn-primary" onclick="claim('.$line->id.','.$line->user_id.','.$line->claim_id.')">Claim Pending</a>';
        }elseif($line->claim_status==1){
            $claim = '<a href="javascript:void(0);" class="btn btn-success">Approved</a>';
        }else{
            $claim = '<a href="javascript:void(0);" class="btn btn-danger">Disapproved</a>';
        }
        }else{
            if($line->claim_status==0){
                $claim = '<a href="javascript:void(0);" class="btn btn-primary">Claim Pending</a>';
            }elseif($line->claim_status==1){
                $claim = '<a href="javascript:void(0);" class="btn btn-success">Approved</a>';
            }else{
                $claim = '<a href="javascript:void(0);" class="btn btn-danger">Disapproved</a>';
            }
        }

    $nestedData[] = $line->id;
    $nestedData[] = getField('name',$tbl_admin,$line->user_id);
    $nestedData[] = getField('name',$tbl_admin,$line->updated_by);
    $nestedData[] = $line->cdate;
    $nestedData[] = $line->applicant_name;
    $nestedData[] = $line->dob;
    $nestedData[] = $line->father_name;
    $nestedData[] = getField('name',$tbl_country,$line->pre_country_id);
    $nestedData[] = $line->applicant_contact_no;
    $nestedData[] = getField('name',$tbl_branch,$line->branch_id);
        $nestedData[] = $claim;
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