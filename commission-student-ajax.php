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


$sql=$obj->query("select COUNT(id) as num_rows from $tbl_student where 1=1 ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$b_id = '';
$half = '';
$join = '';

$whr1 = '';
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}
if($_SESSION['join']!=''){
  $join = $_SESSION['join'];
}
if($_SESSION['join1']!=''){
  $join1 = $_SESSION['join1'];
}

  $sql="SELECT a.*,b.cdate as visa_approved_date,c.university_name,c.enrollment_status,c.total_fee_paid,c.classes_start_date FROM $tbl_student AS a
          INNER JOIN $tbl_student_status AS b on b.stu_id = a.id
          LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id
          $join $join1
          WHERE b.cstatus = 'Visa Approved' $whr1";
if(!empty($requestData['search']['value'])) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
$sql.=" GROUP BY a.id";
// echo $sql; die;
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  b.cdate desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";

$query = $obj->query($sql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
$nestedData=array(); 
 
  $showval = 1;

  if($showval == 1){
    $color='';
 
    $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);

    $sql4 = $obj->query("select * from tbl_student_commision where stu_id='".$line->id."' order by id desc",-1);
    $res = $obj->fetchNextObject($sql4);

    $sql_uni = $obj->query("select * from $tbl_univercity where name='".$line->university_name."'",-1);
    $res_uni_count = $obj->numRows($sql_uni);
    if($res_uni_count > 0){
      $res_uni = $obj->fetchNextObject($sql_uni);
      $uni_name = $res_uni->id;
    }else{
      $uni_name = $line->university_name;
    }
    $sql_app = $obj->query("select * from $tbl_student_application where stu_id='".$line->id."' and college_name='$uni_name' and parent_id=0 order by id desc",-1);
    $res1 = $obj->fetchNextObject($sql_app);
    $sql_com = $obj->query("select sum(tution_fee_paid) as total_tution_fee_paid, sum(commission_received_amount) as total_commission_received_amount from tbl_student_commision_details where stu_id='".$line->id."'",-1);
  
  if($obj->numRows($sql4)==0){
    $edit = "<a href='javascript:void' onclick='get_comission({$line->id})'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
  }else{
    $edit = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&commission'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a>";
  }
  if($res->student_status == 'Not Enrolled' || $res->student_status1 == 'No'){
    $color = ' style="color:red"';
  }
  if($res1->portal_status != 'Direct(Student)'){
    $res_com = $obj->fetchNextObject($sql_com);
    $nestedData[] = "<span ".$color.">".$i."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
    $nestedData[] = "<span ".$color.">".$line->dob."</span>";
    $nestedData[] = "<span ".$color.">".$res1->portal_status."</span>";
    $nestedData[] = "<span ".$color.">".$res->stu_portal_id."</span>";
    $nestedData[] = "<span ".$color.">".$res->app_portal_id."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
    $nestedData[] = "<span ".$color.">".$line->classes_start_date."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = "<span ".$color.">".$line->university_name."</span>";
    $nestedData[] = "<span ".$color.">".$res1->course."</span>";
    $nestedData[] = "<span ".$color.">".$line->total_fee_paid."</span>";
    $nestedData[] = "<span ".$color.">".$line->enrollment_status."</span>";
    $nestedData[] = "<span ".$color.">".$res_com->total_commission_received_amount."</span>";
    $nestedData[] = $edit;
    $data[] = $nestedData;
  }
}
  
  $i++;
}

$json_data = array(
  "draw"            => intval( $requestData['draw']),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>