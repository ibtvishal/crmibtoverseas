<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$whr = '';
if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }
$columns = array(
  0 =>'id'
);
$sql=$obj->query("select COUNT(*) AS num_rows from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where 1=1 $whr",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


$sql="select a.*,b.payment_date,b.pdf_path,b.id as list_id,b.payment_type,b.audit_status,b.total_amount,b.cash,b.bank ,b.upi ,b.cheque ,b.swipe,b.remark,b.accountant_remark from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where 1=1 $whr";
// echo $sql; die;
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.id LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' "; 
  $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
}

// $sql.=" GROUP BY b.visit_id ";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY b.audit_status asc, b.id desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
// echo $sql;die;
$query = $obj->query($sql);


$data = array();
$c=1;
while($line=$obj->fetchNextObject($query)) {
  $nestedData=array(); 
  $slip_data = '';
  $slip_data1 = '';
  $slip_data2 = '';
  
  // if ($line->payment_type == 'Registration') {
  //   $slip_data = "<a href='invoice.php?id=".$line->id."&type=Registration' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
  // }
  
  // $sql3 = $obj->query("SELECT * FROM $tbl_visit_fee WHERE visit_id='".$line->id."' AND payment_type='After Visa'");
  
  // if ($line->payment_type == 'After Visa') {
  //   $slip_data1 = "<a href='invoice.php?id=".$line->id."&type=After Visa' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
  // }
  
  // if ($line->payment_type == 'Enrollment' || $line->payment_type == 'Direct Enrollment') {
    $slip_data2 = "<a href='invoice.php?id=".$line->id."&type=".$line->payment_type."' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
  // }
  $addtional_role = explode(',', $_SESSION['additional_role']);
  if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 13 || in_array(7,$addtional_role)){
    $disabled = '';
  }else{
    $disabled = 'disabled';
  }
  if(($line->payment_type == 'Direct Enrollment') && $line->upi == null && $line->cheque == null && $line->swipe == null && $line->bank == null  && $line->payment_date > $first_date && ($line->visa_sub_type == 3 || $line->visa_sub_type == 43 || $line->visa_sub_type == 44 )){
    $total_p = $line->total_amount*10/100;
  }else{
    $total_p = $line->total_amount;
  }
  $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
  $student = $obj->fetchNextObject($get_student);
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$line->id."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$line->payment_date."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$student->student_no."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$line->payment_type."</span>";
      $nestedData[] = "<span class='change_color".$line->list_id."'".$color.">".$total_p."</span>";
      $nestedData[] = $slip_data2;
      // $nestedData[] = $slip_data2; 
      // $nestedData[] = $slip_data1;
      // $nestedData[] = "<a href='#invoiceModel' onclick='get_modal_data(\"".$line->id."\")'  data-toggle='modal' data-target='#invoiceModel'><i class='fa-solid fa-receipt' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      
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