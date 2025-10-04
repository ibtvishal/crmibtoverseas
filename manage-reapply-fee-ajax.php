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
$addtional_role = explode(',',$_SESSION['additional_role']);
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type like '%Reapply%'  $whr1",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


// echo $sql; die;

$sql="select a.*, b.payment_type, b.visa_type as visa_type_p, b.payment_date,b.after_visa_fee_commitment from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type like '%Reapply%'  $whr1 ";
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
$sql.=" ORDER BY b.id desc   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo $sql;die;
$query = $obj->query($sql);


$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
      $nestedData=array();     
      $visa='';
      $reapply='';
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
    $tsql = $obj->query("select id from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
    $tnumR = $obj->numRows($tsql);
    
    if($tnumR>0){
      $color = "style='color:green'";
      $pay_now =  "<a style='padding: 5px 10px;' class='btn btn-success' href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=After Visa'>Pay Now</a>";
    
    }else{
      $color = '';
      $pay_now = '';
    }
    $count = $obj->numRows($obj->query($sql="select a.id from  $tbl_visit_fee as a where  1=1 and a.visit_id='{$line->id  }' and a.payment_type like '%Reapply%' "));
    $reapply =  "<a style='padding: 5px 10px;' class='btn btn-success' href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Reapply".++$count."'>Pay Now</a>";
    
    $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
    $student = $obj->fetchNextObject($get_student);
    $nestedData[] = "<span ".$color.">".$line->id."</span>";
    $nestedData[] = "<span ".$color.">".$line->payment_date."</span>";
    $nestedData[] = "<span ".$color.">".$student->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->applicant_name."</span>";
      $nestedData[] = "<span ".$color.">".$line->father_name."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->pre_country_id)."</span>";
      $nestedData[] = "<span ".$color.">".$visa."</span>";
      $nestedData[] = "<span ".$color.">".getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)."</span>";
      $nestedData[] = "<span ".$color.">".$line->applicant_contact_no."</span>";
      $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
      $nestedData[] = "<span ".$color.">".$line->after_visa_fee_commitment."</span>";
      
      $nestedData[] = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=".$line->payment_type."' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
        $nestedData[] = $pay_now;
      }
      $nestedData[] = "<a href='#invoiceModel'  data-toggle='modal' onclick='get_modal_data(\"".$line->id."\",\"".$line->payment_type."\")'  data-target='#invoiceModel'><i class='fa-solid fa-receipt' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
        $nestedData[] = $reapply;
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