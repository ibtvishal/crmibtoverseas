<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();

$requestData= $_REQUEST;

$columns = array(
	0 =>'a.cdate',
	1 =>'b.student_no', 
	2 =>'a.name', 
	3 =>'a.university_id',
	4 => 'a.sender_id	',
	5 =>'a.remarks'
);

$whr='';
if(!empty($_SESSION['whr'])){
	$whr = $_SESSION['whr'];
}

if($_SESSION['level_id']==1 || $_SESSION['level_id']==25){
	$sql=$obj->query("select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
}else if($_SESSION['level_id']==2 || $_SESSION['level_id']==23 || $_SESSION['level_id']==19){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	if($_SESSION['level_id']==23){
		$whr_t = " and b.visa_id in (2,3,5)";
	}else{
		$whr_t = '';
	}
	$sql=$obj->query("select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) $whr $whr_t",$debug=-1);
}else if($_SESSION['level_id']==3 || $_SESSION['level_id']==24){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$sql=$obj->query("select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.am_id='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
}else if($_SESSION['level_id']==4){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$sql=$obj->query("select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.c_id='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
}else if($_SESSION['level_id']==7){
  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_student_status AS c ON b.id=c.stu_id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.country_id in (1,2,3,6) and c.stage_id in (3,30,8,24,16) and c.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','Proceed on Dummy I-20','CAS Received','GIC Paid') $whr ";

}else if($_SESSION['level_id']==8){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select COUNT(*) as num_rows from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON b.id=c.student_id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and c.fe_id='".$_SESSION['sess_admin_id']."' $whr ";
}



$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 
if($_SESSION['level_id']==1 || $_SESSION['level_id']==25){
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' $whr ";
}else if($_SESSION['level_id']==2 || $_SESSION['level_id']==23 || $_SESSION['level_id']==19){
	if($_SESSION['level_id']==23){
		$whr_t = " and b.visa_id in (2,3,5)";
	}else{
		$whr_t = '';
	}
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) $whr $whr_t";
}else if($_SESSION['level_id']==3 || $_SESSION['level_id']==24){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.am_id='".$_SESSION['sess_admin_id']."' $whr ";
}else if($_SESSION['level_id']==4){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.c_id='".$_SESSION['sess_admin_id']."' $whr ";
}else if($_SESSION['level_id']==7){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_student_status AS c ON b.id=c.stu_id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and b.country_id in (1,2,3,6) and c.stage_id in (3,30,8,24,16) and c.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','Proceed on Dummy I-20','CAS Received','GIC Paid') $whr ";
}else if($_SESSION['level_id']==8){
	$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$msql ="select a.*,b.student_no,b.stu_name from $tbl_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON b.id=c.student_id where 1=1 and a.sender_id!='".$_SESSION['sess_admin_id']."' and b.branch_id in ($branch_id) and c.fe_id='".$_SESSION['sess_admin_id']."' $whr ";
}

if( !empty($requestData['search']['value']) ) {
	$msql.=" AND ( b.student_no LIKE '".$requestData['search']['value']."%' "; 
	$msql.=" OR b.stu_name LIKE '".$requestData['search']['value']."%' ";   
	$msql.=" OR a.university_id LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.remarks LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR sender_id LIKE '".$requestData['search']['value']."%' )";	
}

$query = $obj->query($msql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$msql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

//echo $msql; die;
$query = $obj->query($msql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 

	
	//--------Check Status Start-----------------------------------------------------------------
		$chk='';
    $chk = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatus" value="'.$tbl_notification.'"';
    if($line->status=="1"){
      $chk .= 'checked ';
    }
    $chk .= 'onclick="return changeNotiStatusRecord('.$line->id.',this.checked,this.value);"/><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div>';
    //-------------------------------------------------------------------------------------------
   if($line->university_id=='' || $line->university_id==0){
  		$university = 'General Discussion';
   }else{
   		$university = getField('name',$tbl_univercity,$line->university_id);
   }

  $color = "";
  if($line->status==1){
  	$color = "style=color:red";
  }

   

	$nestedData=array();
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".$line->cdate."</span></a>"; 
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".$line->student_no."</span></a>";
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".$line->stu_name."</span></a>";
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".$university."</span></a>";
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".getField('name',$tbl_admin,$line->sender_id)."</span></a>";
	$nestedData[] = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&ntype=".base64_encode(base64_encode(base64_encode($line->type)))."&nid=".base64_encode(base64_encode(base64_encode($line->id)))."'><span ".$color.">".$line->remarks."</span></a>";
	
	$nestedData[] = $chk;
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