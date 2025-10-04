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
$sql=$obj->query("select COUNT(id) as num_rows from $tbl_enquiry where 1=1 $whr1 GROUP BY number",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$obj->numRows($sql);
$totalFiltered = $totalData; 


// echo $sql; die;

$sql="select * from $tbl_enquiry where 1=1 $whr1";
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (name LIKE '{$searchValue}%' ";    
  $sql .= " OR number LIKE '{$searchValue}%' ";
  $sql .= " OR country LIKE '{$searchValue}%' ";
  $sql .= " OR visa_type LIKE '{$searchValue}%')";
 }
$sql.=" GROUP BY number";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY id desc   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo $sql;die;
$query = $obj->query($sql);


$i=1;
$data = array();
while($line=$obj->fetchNextObject($query)) { 
     $color = '';
     if($line->status==0 && $line->status1==0 && $line->status2==0){
      $color = ' style="color:red"';
     }
     $dis = 'disabled';
     $dis2 = 'disabled';
     $dis3 = 'disabled';
     $a = [2,4,5];
     if($line->status == '0'){
       $dis = '';
       $dis2 = 'disabled';
       $dis3 = 'disabled';
      }
      elseif($line->status1 == ''){
        if($line->status == 1 || $line->status == 3){
        $dis = 'disabled';
        $dis2 = '';
        $dis3 = 'disabled';
        }
     }
      elseif($line->status2 == ''){
        if($line->status1 == 1 || $line->status1 == 3){
        $dis = 'disabled';
        $dis2 = 'disabled';
        $dis3 = '';
        }
     }
     if(in_array($line->status,$a) || in_array($line->status1,$a) || in_array($line->status2,$a)){
     }
      $nestedData = [];
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->id."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->cdate."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->name."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->number."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->country."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->visa_type."</span>";
      $nestedData[] = "<span class='manage_enquiry_".$line->id."' ".$color.">".$line->url."</span>";
      $nestedData[] = "<span>
      <select class='form-control manage_enquiry1_".$line->id." manage_enquiry_select1_".$line->id."' onchange='change_manage_enquiry(this.value, " . $line->id . ",\"status\",1)' ".$color." $dis>
          <option value=''>Select Remark</option>
          <option value='1' " . ($line->status == 1 ? 'selected' : '') . ">Interested</option>
          <option value='2' " . ($line->status == 2 ? 'selected' : '') . ">Not Interested</option>
          <option value='3' " . ($line->status == 3 ? 'selected' : '') . ">Unable to Connect</option>
          <option value='5' " . ($line->status == 5 ? 'selected' : '') . ">Close Enquiry</option>
          <option value='6' " . ($line->status == 6 ? 'selected' : '') . ">Added To New Enquiry</option>
      </select>
  </span>
  <br>
  ".$line->remark1;
      $nestedData[] = "<span>
      <select class='form-control manage_enquiry_".$line->id." manage_enquiry_select2_".$line->id."' onchange='change_manage_enquiry(this.value, " . $line->id . ",\"status1\",2)' ".$color." $dis2>
          <option value=''>Select Remark 2</option>
          <option value='1' " . ($line->status1 == 1 ? 'selected' : '') . ">Interested</option>
          <option value='2' " . ($line->status1 == 2 ? 'selected' : '') . ">Not Interested</option>
          <option value='3' " . ($line->status1 == 3 ? 'selected' : '') . ">Unable to Connect</option>
          <option value='5' " . ($line->status1 == 5 ? 'selected' : '') . ">Close Enquiry</option>
          <option value='6' " . ($line->status1 == 6 ? 'selected' : '') . ">Added To New Enquiry</option>
      </select>
  </span>
  <br>
  ".$line->remark2;
      $nestedData[] = "<span>
      <select class='form-control manage_enquiry_".$line->id." manage_enquiry_select3_".$line->id."' onchange='change_manage_enquiry(this.value, " . $line->id . ",\"status2\",3)' ".$color." $dis3>
          <option value=''>Select Remark 3</option> 
          <option value='1' " . ($line->status2 == 1 ? 'selected' : '') . ">Interested</option>
          <option value='2' " . ($line->status2 == 2 ? 'selected' : '') . ">Not Interested</option>
          <option value='3' " . ($line->status2 == 3 ? 'selected' : '') . ">Unable to Connect</option>
          <option value='5' " . ($line->status2 == 5 ? 'selected' : '') . ">Close Enquiry</option>
          <option value='6' " . ($line->status1 == 6 ? 'selected' : '') . ">Added To New Enquiry</option>
      </select>
  </span>
  <br>
  ".$line->remark3;
  

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