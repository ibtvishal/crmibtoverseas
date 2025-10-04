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
$whr1 = '';
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}

$sql=$obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 $whr1 GROUP BY a.id",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

  $sql="SELECT a.*,b.cdate as created_at,b.no_of_days,b.class_mode,b.class_start_date,b.class_end_date FROM $tbl_visit AS a INNER JOIN (
    SELECT * 
    FROM $tbl_duolingo_classe 
    ORDER BY id DESC
) AS b ON b.visit_id = a.id  where 1=1 $whr1";

if( !empty($requestData['search']['value']) ) {
  $sql.=" AND ( a.applicant_name LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.father_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.applicant_alternate_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.applicant_contact_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.=" GROUP BY a.id";
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';

    $onclick = '';
    
    if($line->dulingo_date_status == 0){
      $status = "<a class='btn btn-danger' href='javascript:void' onclick='change_pending_status({$line->id})'>Inactive</a>";
      $card = '';
    //   $onclick = "onclick='change_pending_status({$line->id})'";
    }else{
    //   $status = "Active";
      $status = "<a class='btn btn-success'>Active</a>";
      $card = "<a href='interview-slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&duolingo' target='_blank' class='text-primary'><i class='fa fa-eye'></i></a>";
    }
    $view_duolingo_dezire_score = '';
      $get_duolingo_dezire_score = $obj->numRows($obj->query("SELECT * FROM tbl_duolingo_dezire_score where visit_id='{$line->id}'"));
    if($get_duolingo_dezire_score > 0){
      $view_duolingo_dezire_score = "<a class='text-primary' onclick='get_duolingo_dezire_score({$line->id})'><i class='fa fa-eye'></i></a>";
    }
    if($line->dulingo_status == 0){
      $btn = "<a class='btn btn-danger' href='javascript:void' onclick='change_pending_status1({$line->id})'>Pending</a> $view_duolingo_dezire_score";
    }else{
      $btn = "<a class='btn btn-success' $onclick>Accepted</a> $view_duolingo_dezire_score";
    }
    $view = '';
    $get_all = $obj->numRows($obj->query("SELECT * FROM $tbl_duolingo_exam where visit_id='{$line->id}'"));
    if($get_all > 0){
      $view = "<a class='text-primary' onclick='get_all_record({$line->id})'><i class='fa fa-eye'></i></a>";
    }
  
    $get = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_duolingo_exam where visit_id='{$line->id}' order by id desc"));
    if($get->status == 0 || $get->status == 3){
      if($_SESSION['level_id'] == 33){
        $exam_status = "<a class='btn btn-danger' href='javascript:void' onclick='move_to_exam({$line->id})'>Move to Exam $view</a>";
      }
    }else{
      $get = $obj->numRows($obj->query("SELECT * FROM $tbl_duolingo_exam where visit_id='{$line->id}' and status in (2)"));
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
      if($get > 0){
        $exam_status = "<a class='btn btn-success' href='javascript:void'>Approved $view</a>";
      }else{
        $exam_status = "<a class='btn btn-danger' href='javascript:void' onclick='move_to_exam1({$line->id})'>Pending Approval $view</a>";
      }
    }else{
        if($get > 0){
        $exam_status = "<a class='btn btn-success' href='javascript:void'>Approved $view</a>";
      }else{
        $exam_status = "<a class='btn btn-danger' href='javascript:void'>Pending Approval $view</a>";
      }
    }
    }
    
    $get_final1 = $obj->query("SELECT * FROM $tbl_duolingo_final_exam where visit_id='{$line->id}' order by id desc");
    $get_final_count = $obj->numRows($get_final1);
    $get_final = $obj->fetchNextObject($get_final1);
    $final_record = "";

    if($get_final_count > 0){
      $final_record = "<a class='text-primary' onclick='final_record({$line->id})'><i class='fa fa-eye'></i></a>";
    }
 
      $exam_final_status = '<select class="form-control" id="" style="width: 175px;" onchange="change_final_status(' . $line->id . ', this.value)" ' . (($get_final->status == 1 || $get_final->status == 4) ? 'disabled' : '') . '>
        <option value="">Select Final Status</option>
        <option value="1" ' . ($get_final->status == '1' ? 'selected' : '') . '>Successful</option>
        <option value="2">Invalid</option>
        <option value="3" ' . ($get_final->status == '3' ? 'selected' : '') . '>Invalid and Re-appear</option>
        <option value="4">Banned</option>
    </select>'.$final_record;

     $btn_view = '';
    $rSql_count = $obj->numRows($obj->query("select id from tbl_duolingo_branch where visit_id='".$line->id."'"));
    if($rSql_count > 0){
      $btn_view = "<a class='text-primary' onclick='get_branch_log({$line->id})'><i class='fa fa-eye'></i></a>";
    }
    $update_branch = "<a href='javascript:void;' onclick='update_branch({$line->id})' class='btn btn-primary'>Update Branch</a> $btn_view";

    
        $tsql = $obj->query("select student_no,passport_no,c_id from $tbl_student where  (student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."') order by id desc");
      $tnumR_data = $obj->fetchNextObject($tsql);
    $logs = "<a href='javascript:void;' onclick='get_log({$line->id})' class='text-primary'><i class='fa fa-eye'></i></a>";
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type);
    $nestedData[] = "<span ".$color.">".$tnumR_data->student_no."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->created_at))."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
    $nestedData[] = "<span ".$color.">".$tnumR_data->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$tnumR_data->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->duolingo_branch)."</span>";
    $nestedData[] = "<span ".$color.">".$line->class_mode."</span>";
    $nestedData[] = "<span ".$color.">".$line->no_of_days."</span>";
    $nestedData[] = "<span ".$color.">".$line->duolingo_dezire_score."</span>";
    $nestedData[] = "<span ".$color.">".$line->class_start_date."</span>";
    $nestedData[] = "<span ".$color.">".$line->class_end_date."</span>";
    $nestedData[] = $btn;
    $nestedData[] = $exam_status;
    $nestedData[] = $exam_final_status;
    $nestedData[] = $status . $logs;
    $nestedData[] = $card; 
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
    $nestedData[] = $update_branch;
     }
    // $nestedData[] = $btn;
    // $nestedData[] = "<a href='visit-editf.php?id=".base64_ encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";

    $data[] = $nestedData;
  }
  
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
