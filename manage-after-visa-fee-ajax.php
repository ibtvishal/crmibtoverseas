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
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type='After Visa'  and b.status='1' $whr1",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


// echo $sql; die;

$sql="select a.*, b.visa_type, b.payment_date as visa_type_p, b.payment_date, b.after_visa_fee_commitment from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type='After Visa' and b.status='1' $whr1";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.id LIKE '{$searchValue}%' ";
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
      $visa='';
      $visaArr = explode(',',$line->visa_type_p);
      foreach ($visaArr as $key => $val) {
        $visa .= $val;
        $visa .="<br>";
      }



      if ($line->councellor_id !== '' && $line->councellor_id !== null) {
        $conselor = explode(',', $line->councellor_id);
        $cons = [];
        foreach ($conselor as $counselor_id) {
            $cons[] = getField('name', $tbl_admin, $counselor_id);
        }
        $conss = implode(', ', $cons);
    } else {
        $conss = '';
    }
    $color = '';
    $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
    $student = $obj->fetchNextObject($get_student);

    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type='Registration'");
    $result_fee_count = $obj->numRows($sql2);
    if($result_fee_count > 0){
    $slip_data = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Registration' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
    }else{
      $slip_data = '';
    }
    $sql3 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type='After Visa'");
    $result_fee_count1 = $obj->numRows($sql3);
    if($result_fee_count1 > 0){
    $slip_data1 = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=After Visa' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
    }else{
      $slip_data1 = '';
    }
    $nestedData[] = "<span ".$color.">".$line->id."</span>";
    $nestedData[] = "<span ".$color.">".$line->payment_date."</span>";
    $nestedData[] = "<span ".$color.">".$student->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$visa."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = $slip_data;
    $nestedData[] = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Enrollment' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
    $nestedData[] = $slip_data1;
    $nestedData[] = "<a href='#invoiceModel'  data-toggle='modal' onclick='get_modal_data(\"".$line->id."\",\"".$line->payment_type."\")'  data-target='#invoiceModel'><i class='fa-solid fa-receipt' style='margin-right: 6px;font-size: 16px;'></i> </a>";
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