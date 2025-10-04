<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_admin();

$requestData= $_REQUEST;

$columns = array(
	0 =>'id', 
	1 =>'program_level', 
	2=>'stream',
	3 => 'course_name',
	4 =>'intake',
	5=>'program_duration'
);

$whr = "";
if($_SESSION['whr']){
	$whr = $_SESSION['whr'];
}

$sql=$obj->query("select COUNT(*) as num_rows from $tbl_programmes where 1=1 $whr",$debug=-1);


$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$msql ="select a.* from $tbl_programmes as a left join $tbl_univercity as b on a.univercity=b.id where 1=1 $whr ";

if( !empty($requestData['search']['value']) ) {
	$msql.=" AND ( a.id LIKE '".$requestData['search']['value']."%' "; 
	$msql.=" OR b.name LIKE '".$requestData['search']['value']."%' ";   
	$msql.=" OR a.program_level LIKE '".$requestData['search']['value']."%' ";   
	$msql.=" OR a.stream LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.course_name LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.intake LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.program_duration LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.student_bachelors LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.percentage LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.ielts LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.pte LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.duolingo LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.tofel LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.moi LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR a.fees LIKE '".$requestData['search']['value']."%' )";	
}
$query = $obj->query($msql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$msql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($msql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 
	
	//--------Check Status Start-----------------------------------------------------------------
		$chk='';
    $chk = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatus" value="'.$tbl_programmes.'"';
    if($line->status=="1"){
      $chk .= 'checked ';
    }
    $chk .= 'onclick="return changeStatusRecord('.$line->id.',this.checked,this.value);"/><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div>';
    //-------------------------------------------------------------------------------------------


	$nestedData=array(); 
	$nestedData[] = $line->id;
	$nestedData[] = getField('name',$tbl_country,$line->country);
	$nestedData[] = getField('state',$tbl_state,$line->state);
	$nestedData[] = getField('name',$tbl_univercity,$line->univercity);
	$nestedData[] = $line->program_level;
	$nestedData[] = $line->stream;
	$nestedData[] = $line->course_name;
	$nestedData[] = $line->intake;
	$nestedData[] = $line->program_duration;
	$nestedData[] = $line->tuition_fee;
	$nestedData[] = $line->student_bachelors;
	$nestedData[] = $line->percentage;
	$nestedData[] = $line->ielts;
	$nestedData[] = $line->pte;
	$nestedData[] = $line->duolingo;
	$nestedData[] = $line->tofel;
	$nestedData[] = $line->moi;
	$nestedData[] = $line->fees;
	$nestedData[] = $line->scholarship;
	$nestedData[] = $line->scholarship_percentage;
	$nestedData[] = $line->special_requirement;
	$nestedData[] = $line->course_type;
	$nestedData[] = $chk;
	$nestedData[] = '<a href="javascript:void(0);" onclick="getModalData('.$line->id.')"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i></a> ';
	// $nestedData[] = '<a href="javascript:void(0);" onclick="getModalData('.$line->id.')"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i></a> 
	// <a href="programmes-del.php?id='.$line->id.'" value="Delete" type="submit" class="delete_button" onclick="return confirm("Are you sure you want to delete record(s)")" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;"></i></a>';
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