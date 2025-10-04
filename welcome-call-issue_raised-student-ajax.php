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
if($_SESSION['whr2']!=''){
$whr2 = $_SESSION['whr2'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);
$sql=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 $whr1 group by b.stu_id",$debug=-1);

$line=$obj->numRows($sql);
$totalData=$line;
$totalFiltered = $totalData; 

$sql="select a.*,b.message,b.rating from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 $whr1";
if (!empty($requestData['search']['value'])) {
  $searchValue = $requestData['search']['value'];
  $sql .= " AND (a.applicant_name LIKE '{$searchValue}%' ";    
  $sql .= " OR a.id LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_contact_no LIKE '{$searchValue}%' ";
  $sql .= " OR a.applicant_alternate_no LIKE '{$searchValue}%')";
}
$sql .= " group by b.stu_id";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);
$requestData['order'][0]['dir']='desc';
$sql.=" ORDER BY a.id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

// echo $sql;die;
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

    
    $slip_data1 = '';
    $color = '';
     $btn1 = '';
      $message = json_decode($line->message, true);
      foreach ($message as $key => $value) {
        $cleaned_key = trim($key, "'");
        $cleaned_value = is_string($value) ? trim($value, "'") : $value; 
        if($cleaned_value == 'Not Ok'){
          $btn1 .= $cleaned_key.', ';
        }
      }
      
      
      $btn = "<a href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($line->id)))."&welcome'><i class='fa fa-eye' style='margin-right: 6px;font-size: 16px;'></i> </a> ";

    $rating = '<div class="rating" style="width: 208px;">
    <input type="radio" id="star5'.$line->id.'" name="rating'.$line->id.'" value="5" '.($line->rating == 5 ? 'checked' : '').'/>
    <label class="star" for="star5'.$line->id.'" title="Awesome" aria-hidden="true"></label>
    
    <input type="radio" id="star4'.$line->id.'" name="rating'.$line->id.'" value="4" '.($line->rating == 4 ? 'checked' : '').'/>
    <label class="star" for="star4'.$line->id.'" title="Great" aria-hidden="true"></label>
    
    <input type="radio" id="star3'.$line->id.'" name="rating'.$line->id.'" value="3" '.($line->rating == 3 ? 'checked' : '').'/>
    <label class="star" for="star3'.$line->id.'" title="Very good" aria-hidden="true"></label>
    
    <input type="radio" id="star2'.$line->id.'" name="rating'.$line->id.'" value="2" '.($line->rating == 2 ? 'checked' : '').'/>
    <label class="star" for="star2'.$line->id.'" title="Good" aria-hidden="true"></label>
    
    <input type="radio" id="star1'.$line->id.'" name="rating'.$line->id.'" value="1" '.($line->rating == 1 ? 'checked' : '').'/>
    <label class="star" for="star1'.$line->id.'" title="Bad" aria-hidden="true"></label>
</div>';


$nestedData[] = "<span ".$color.">".$line->id."</span>";
$nestedData[] = "<span ".$color.">".date("d M y",strtotime($line->cdate))."</span>";
$nestedData[] = "<span ".$color.">".$line->student_no."</span>";
$nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
$nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>";
$nestedData[] = "<span ".$color.">".$line->student_contact_no."</span>";
$nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
$nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$line->c_id)."</span>";
$nestedData[] = $rating;
$nestedData[] = $btn1;
if($_SESSION['level_id'] != 4){
$nestedData[] = $btn;
}
$data[] = $nestedData;
$i++;
}



$json_data = array(
"draw" => intval( $requestData['draw'] ),
"recordsTotal" => intval( $totalData ),
"recordsFiltered" => intval( $totalFiltered ),
"data" => $data
);


echo json_encode($json_data);
?>