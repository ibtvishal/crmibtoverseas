<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_admin();

$requestData= $_REQUEST;

$columns = array(
	0 =>'id', 
	1 =>'qualification', 
	2=>'stream',
	3 => 'gap',
	4 =>'preferred_course',
	5=>'diploma'
);


$sql=$obj->query("select COUNT(*) as num_rows from $tbl_gap where 1=1",$debug=-1);


$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 

$msql ="select * from $tbl_gap where 1=1 $whr ";

if( !empty($requestData['search']['value']) ) {
	$msql.=" AND ( id LIKE '".$requestData['search']['value']."%' "; 
	$msql.=" OR stream LIKE '".$requestData['search']['value']."%' ";   
	$msql.=" OR gap LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR preferred_course LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR diploma LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR duration LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR designation LIKE '".$requestData['search']['value']."%' ";
	$msql.=" OR exp_duration LIKE '".$requestData['search']['value']."%' )";	
}

$query = $obj->query($msql);
$totalFiltered=$obj->numRows($query);

$requestData['order'][0]['dir']='desc';
$msql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$query = $obj->query($msql);

$data = array();
$i=1;
while($line=$obj->fetchNextObject($query)) { 

	$gname = getField('name','tbl_manage_gap',$line->gap);
	$gname = number_format($gname/12,2); 
	$gArr = explode('.', $gname);
	$gyear = $gArr[0];
	$gMonth = round($gArr[1]*12/100);

	
	//--------Check Status Start-----------------------------------------------------------------
	$chk='';
    $chk = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatus" value="'.$tbl_gap.'"';
    if($line->status=="1"){
      $chk .= 'checked ';
    }
    $chk .= 'onclick="return changeStatusRecord('.$line->id.',this.checked,this.value);"/><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div>';
    //-------------------------------------------------------------------------------------------


	$nestedData=array(); 
	$nestedData[] = $line->id;
	$nestedData[] = getField('name','tbl_qualification',$line->qualification);
	$nestedData[] = $line->stream;
	$nestedData[] = $gyear." "."Year,"." ".$gMonth." Months";
	$nestedData[] = $line->preferred_course;
	$nestedData[] = $line->diploma;
	$nestedData[] = $line->duration;
	$nestedData[] = $line->designation;
	$nestedData[] = $line->exp_duration;
	$nestedData[] = $chk;
	$nestedData[] = '<a href="javascript:void(0);" onclick="getModalData('.$line->id.')"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i></a> 
	<a href="gap-del.php?id='.$line->id.'" value="Delete" type="submit" class="delete_button" onclick="return confirm("Are you sure you want to delete record(s)")" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;"></i></a>';
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