<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
$requestData= $_REQUEST;
$whr = '';
$whr1 = '';
$pending = '';
if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }
if($_SESSION['whr1']!=''){
    $whr1 = $_SESSION['whr1'];
  }
if($_SESSION['pending']!=''){
    $pending = $_SESSION['pending'];
  }
$columns = array( 
  0 =>'id'
);
if($pending != ''){
  $sql=$obj->query("select a.id as num_rows from $tbl_student as a INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id  where 1=1 and f.value = 'Financials' and f.status=2 AND (
    SELECT COUNT(*) 
    FROM $tbl_student_filing_noc f1 
    WHERE f1.stu_id = a.id AND f1.status = 1
) = 0 
AND (
    SELECT COUNT(*) 
    FROM $tbl_student_filing_noc f2 
    WHERE f2.stu_id = a.id AND f2.status = 2
) > 0   $whr $whr1 group by a.id",$debug=-1);
  // $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id  where 1=1 and b.dtype in (3) and f.value = 'With_Affidavit' AND NOT EXISTS ( SELECT 1 FROM $tbl_student_filing_noc f2 WHERE f2.stu_id = a.id AND f2.value = 'Financials' ) $whr $whr1 group by a.id",$debug=-1);
  $line=$obj->numRows($sql);
  $totalData=$line;
  $totalFiltered = $totalData; 
  
  
  $sql="select a.*,f.user_id as user_id_f,f.cdate as cdate_f from $tbl_student as a INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id  where 1=1 and f.value = 'Financials' and f.status=2 AND (
    SELECT COUNT(*) 
    FROM $tbl_student_filing_noc f1 
    WHERE f1.stu_id = a.id AND f1.status = 1
) = 0 
AND (
    SELECT COUNT(*) 
    FROM $tbl_student_filing_noc f2 
    WHERE f2.stu_id = a.id AND f2.status = 2
) > 0  $whr $whr1";
  // $sql="select a.*,b.financial_verify,b.user_id,b.with_financial_verify  from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id INNER JOIN $tbl_student_filing_noc f ON a.id = f.stu_id  where 1=1 and b.dtype in (3) and f.value = 'With_Affidavit' AND NOT EXISTS ( SELECT 1 FROM $tbl_student_filing_noc f2 WHERE f2.stu_id = a.id AND f2.value = 'Financials' ) $whr $whr1";
}else{
  if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }else{
    $whr = ' and b.dtype in (3)';
  }
  $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 $whr $whr1 group by a.id",$debug=-1);
  $line=$obj->numRows($sql);
  $totalData=$line;
  $totalFiltered = $totalData; 
  
  
  $sql="select a.*,b.financial_verify,b.user_id,b.with_financial_verify  from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1  $whr $whr1";
}
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.student_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.alternate_contact LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}

$sql.="  group by a.id";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
// echo $sql;die;
$query = $obj->query($sql);


$data = [];
$c=1;
while ($line = $obj->fetchNextObject($query)) {
    $nestedData = array();


    $doc1 = [];
    $fsql23 = $obj->query("select * from $tbl_student_document where stu_id='{$line->id}' and dtype=3 and status=1 order by id desc");
    while($fResult23 = $obj->fetchNextObject($fsql23)){
        $doc1[] = '<a href="javascript:void(0);"class="documnet-view" onclick="documentview(1,'.$fResult23->id.')"><i class="fa fa-eye"></i></a>';
    }
    $docs1 = implode(', ',$doc1);


    $btn1 = '';
    

    if(count($doc1) > 0){
    if($line->financial_verify == 1){
      $btn1 = '<a id="change_hide_status1'.$line->id.'" class="btn btn-success">Verfied</a>' ;
    }elseif($line->financial_verify == 2){
      $btn1 = '<a id="change_hide_status1'.$line->id.'" class="btn btn-danger" onclick="change_hide_status1('.$line->id.')">Disapproved</a>' ;
    }else{
      $btn1 = '<a id="change_hide_status1'.$line->id.'" onclick="change_hide_status1('.$line->id.')" class="btn btn-primary">Verification Pending</a>';
    }
  }
    $textarea1 = '';
   
    if(count($doc1) > 0){
    $textarea1 = "<textarea onchange='change_remakrs1(this.value,$line->id)'>$line->with_financial_affidavit_remark</textarea><span class='text-success' id='success1$line->id'></span>";
    }
    $nestedData[] = "<span>{$line->student_no} ({$line->id})</span>";
    $nestedData[] = "<span>" . date("d M y", strtotime($line->cdate)) . "</span>";
    $nestedData[] = "<span>{$line->stu_name}</span>";
    $nestedData[] = "<span>{$line->student_contact_no}</span>";
    $nestedData[] = "<span>{$line->alternate_contact}</span>";
    $nestedData[] = "<span>{$line->passport_no}</span>";
    $nestedData[] = "<span>" . getField('name', $tbl_country, $line->country_id) . "</span>";
    $nestedData[] = "<span>" . getField('name', $tbl_admin, $line->c_id) . "</span>";
    $nestedData[] = "<span>" . get_visa_type($line->visa_id) . "</span>";
    if($pending == ''){
    $nestedData[] = "<span>" . getField('name', $tbl_admin, $line->user_id) . "</span>";
  }else{
    $nestedData[] = "<span ".$color.">Issued By : ".getField('name',$tbl_admin,$line->user_id_f)."<br> At: $line->cdate_f</span>";
    }
    $nestedData[] = "<span>" . getField('name', $tbl_branch, getField('branch_id', $tbl_admin, $line->c_id)) . "</span>";
    if($pending == ''){
    $nestedData[] = $docs1;
    $nestedData[] = $btn1;
    $nestedData[] = $textarea1;
  }
    $nestedData[] = "<a href='student-editf.php?id=" . base64_encode(base64_encode(base64_encode($line->id))) . "&noc'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i></a>";

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