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
if($_SESSION['tbl_visa_sub_type_join']!=''){
$tbl_visa_sub_type_join = $_SESSION['tbl_visa_sub_type_join'];
}
if($_SESSION['condition_of_visa_sub_type']!=''){
$condition_of_visa_sub_type = $_SESSION['condition_of_visa_sub_type'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a $tbl_visa_sub_type_join inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type in ('Enrollment','Direct Enrollment')  and b.status='1' $whr1 $condition_of_visa_sub_type group by b.visit_id ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


// echo $sql; die;

$sql="select a.*, b.payment_type, b.visa_type as visa_type_p, b.payment_date,b.after_visa_fee_commitment from $tbl_visit as a $tbl_visa_sub_type_join  inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.payment_type in ('Enrollment','Direct Enrollment') and b.status='1'  $whr1 $condition_of_visa_sub_type ";
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
$sql.=" group by b.visit_id ORDER BY b.id desc   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

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
      $update_p = "";
      $pay_now =  "<a style='padding: 5px 10px;' class='btn btn-success' href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=After Visa'>Pay Now</a>";
    
    }else{
      $color = '';
      $update_p = "<a href='student-addf.php?vid=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa-solid fa-school' style='margin-right: 6px;font-size: 16px;'></i></a>";
      $pay_now = '';
      $reapply = '';
    }
    
 

    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type='Registration'");
    $result_fee_count = $obj->numRows($sql2);
    if($result_fee_count > 0){
    $slip_data = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Registration' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
    }else{
      $slip_data = '';
    }
    $sql3 = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type in ('Enrollment','Direct Enrollment')");
    $result_fee_count1 = $obj->numRows($sql3);
    if($result_fee_count1 > 0){
      // if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || in_array(1,$addtional_role)){
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
          $slip_data1 = "<a href='student-addf.php?vid=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa-solid fa-school' style='margin-right: 6px;font-size: 16px;'></i></a>";
        }else{
          $slip_data1 = '';
        }
        // }else{
      //   $slip_data1 = '';
      // }
    }else{
      $slip_data1 = '';
    }
    $tsql = $obj->query("select id from $tbl_student where student_contact_no='".$line->applicant_contact_no."' or alternate_contact='".$line->applicant_contact_no."' or student_contact_no='".$line->applicant_alternate_no."' or alternate_contact='".$line->applicant_alternate_no."'");
    $tnumR = $obj->numRows($tsql);
    
    if($tnumR>0){
      $color = "style='color:green'";
      $slip_data1 = '<img src="img/green-circle.svg" style="height:20px">';
    }else{
      if($line->councellor_id==0){
        $color = "style='color:red'";
        $slip_data1 = $slip_data1;
      }  
    } 
    $tsql1 = $obj->query("select a.id from $tbl_student as a inner join $tbl_student_status as b on a.id=b.stu_id where b.cstatus in ('Visa Refused','Defer But Not Refused') and (a.student_contact_no='".$line->applicant_contact_no."' or a.alternate_contact='".$line->applicant_contact_no."' or a.student_contact_no='".$line->applicant_alternate_no."' or a.alternate_contact='".$line->applicant_alternate_no."')");
    $tnumR1 = $obj->numRows($tsql1);
    if($tnumR1>0){
      $sql2_r = $obj->query("select * from $tbl_visit_fee where visit_id='".$line->id."' and payment_type='Reapply'");
      if($obj->numRows($sql2_r) == 0){
        $color = ' style="color:red"';
      $reapply =  "<a style='padding: 5px 10px;' class='btn btn-success' href='add-fee.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=Reapply'>Pay Now</a>";
      }else{
        $reapply = 'Reapplied';
      }
    }else{
    }

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
      
      $nestedData[] = $slip_data;
      $nestedData[] = "<a href='slip.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&type=".$line->payment_type."' target='_blank'><i class='fa-solid fa-file' style='margin-right: 6px;font-size: 16px;'></i></a>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
      $nestedData[] = $pay_now;
      }
      $nestedData[] = "<a href='#invoiceModel'  data-toggle='modal' onclick='get_modal_data(\"".$line->id."\",\"".$line->payment_type."\")'  data-target='#invoiceModel'><i class='fa-solid fa-receipt' style='margin-right: 6px;font-size: 16px;'></i> </a>";
      if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){
        $nestedData[] = $slip_data1;
      }
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