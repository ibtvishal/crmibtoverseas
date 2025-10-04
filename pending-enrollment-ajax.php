<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$whr = '';
$first_date = '2024-01-01';
if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }
$columns = array(
  0 =>'id'
);
$sql=$obj->query("select COUNT(*) AS num_rows from $tbl_profile_status as a inner join $tbl_visit as b on b.id = a.visit_id where 1=1 $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$sql="select b.*,a.visa_sub_type as profile_visa_sub_type, a.type as profile_type, a.percentage as profile_percentage,a.remark as profile_remark,a.disapproved_remark,a.id as profile_id, a.status as profile_status, a.cdate as profile_cdate from $tbl_profile_status as a inner join $tbl_visit as b on b.id = a.visit_id where 1=1 $whr";
// echo $sql; die;
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (b.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR b.id LIKE '{$searchValue}%' ";
  $sql .= " OR b.applicant_contact_no LIKE '{$searchValue}%' "; 
  $sql .= " OR b.applicant_alternate_no LIKE '{$searchValue}%')";
}

// $sql.=" GROUP BY b.visit_id ";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
// echo $sql;die;
$query = $obj->query($sql);

$data = array();
$c=1;
while($line=$obj->fetchNextObject($query)){
    $nestedData=array(); 
    $btn = '';
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 13 || in_array(7,$addtional_role)){
        $disabled = '';
      }else{
        $disabled = 'disabled';
      }

      $color = '';

      if($line->profile_status == 0){
            $btn = '<a href="javascript:void;" class="btn btn-primary" onclick="change_status('.$line->profile_id.', \''.$line->profile_type.'\')">Pending</a>';
        }elseif($line->profile_status == 2){
          $btn = '<a href="javascript:void;" class="btn btn-danger" onclick="change_status('.$line->profile_id.', \''.$line->profile_type.'\')">Disapproved</a>';
          $color = ' style="color:red"';
        }else{
            $btn = '<a href="javascript:void" class="btn btn-success">Approved</a>';
            $color = ' style="color:green"';
      }
    $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
    $student = $obj->fetchNextObject($get_student);
    $get_profile_count = $obj->numRows($obj->query("select id from $tbl_profile_status where visit_id='".$line->id."'"));

      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->id."<br>".$get_profile_count."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->profile_cdate."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$student->student_no."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->profile_visa_sub_type)."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->profile_type."</span>";
      $nestedData[] = "<span class='change_color".$line->profile_id."'".$color.">".$line->profile_percentage."</span>";
      $nestedData[] = "<textarea $disabled >$line->profile_remark</textarea></span>";
      $nestedData[] = "<textarea $disabled onchange='change_remakrs(this.value,$line->profile_id)'>$line->disapproved_remark</textarea><span class='text-success' id='success$line->profile_id'></span>";
      $nestedData[] = $btn;
      if($_SESSION['sess_admin_id'] == 1 || $_SESSION['sess_admin_id'] == 290){
       $nestedData[] = '<a href="javascript:void" onclick="warning(\'Do you want to delete it?\', \'controller.php?delete_enrollment=' . base64_encode($line->profile_id) . '\')"><i class="fa fa-trash"></i></a>';
      }
      $data[] = $nestedData;
}
  
  

$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);

 
echo json_encode($json_data);
?>