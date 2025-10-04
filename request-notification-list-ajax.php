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

$whr_require='';
if(!empty($_SESSION['whr_require'])){
	$whr_require = $_SESSION['whr_require'];
}
if(!empty($_SESSION['whr_require1'])){
	$whr_require1 = $_SESSION['whr_require1'];
}
	$sql=$obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 $whr_require $whr_require1",$debug=-1);




$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 
	$msql ="select a.*,b.student_no,b.stu_name,b.c_id from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1  $whr_require $whr_require1";


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
    $chk='';
    $chk = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatuss"';
    $get = $obj->query("select * from $tbl_requirement_notification_seen where notification_id='{$line->id}' and user_id='{$_SESSION['sess_admin_id']}' and status=1");
    if($obj->numRows($get) > 0){
      $chk .= 'checked ';
    }
    $chk .= 'onclick="changeNotiStatusRecord('.$line->id.',this);"/><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div>';
    $color = "";
  if($line->status==0){
    //   if($_SESSION['level_id'] == 4){
    //       $color = "style=color:green";
    //     }else{
			if($obj->numRows($get) == 0){
				$color = "style=color:green";
			}
		// }
    }elseif($line->status==0 && $_SESSION['level_id'] == 4){
		$color = "style=color:green";
	}else{
        $color = "style=color:red";
  }

  $url = '';
  $url1 = '</a>';
   if($line->response_by == ''){
	if($_SESSION['level_id'] == 4){
	$response = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&requirement_id=".base64_encode(base64_encode(base64_encode($line->requirement_id)))."&request&requirement_notify=".base64_encode(base64_encode(base64_encode($line->id)))."' class='btn btn-success'>Add Reponse</a>";
	$url = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&requirement_id=".base64_encode(base64_encode(base64_encode($line->requirement_id)))."&request&requirement_notify=".base64_encode(base64_encode(base64_encode($line->id)))."'";
	}else{
		$response = "<a class='btn btn-danger'>Reponse Pending</a>";
		$url = '';
	}
}else{
	$url = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->stu_id)))."&request&requirement_notify=".base64_encode(base64_encode(base64_encode($line->id)))."'";
	if($line->response_by_type == 'Student'){
		$response = $url."<span ".$color.">".'Reponse By Student </span>'.$url1;
	}else{
		$response = $url."<span ".$color.">".'Reponse By '.getField("name",$tbl_admin, $line->response_by) .' (Counsellor) </span>'.$url1;
	}
   }
   $remark = getField('request_remark',$tbl_student_request,$line->requirement_id);

	$nestedData=array();
	$nestedData[] = $url."<span ".$color.">".$line->cdate."</span> $url1"; 
	$nestedData[] = $url."<span ".$color.">".$line->student_no."</span>$url1";
	$nestedData[] = $url."<span ".$color.">".$line->stu_name."</span> $url1";
	$nestedData[] = $url."<span ".$color.">".$line->message."</span> $url1";
	$nestedData[] = $url."<span ".$color.">".$remark."</span> $url1";
	$nestedData[] = $url."<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span> $url1";
	$nestedData[] = $url."<span ".$color.">".getField('name',$tbl_admin,$line->send_by)."</span> $url1";
	$nestedData[] = $response;
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 22){
        $nestedData[] = $chk;
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