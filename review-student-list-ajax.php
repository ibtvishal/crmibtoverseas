<?php
session_start();
include("include/config.php");
include("include/functions.php");

validate_user();

$requestData = $_REQUEST;

$columns = array(
    0 => 'student_no',
    1 => 'cdate',
    2 => 'stu_name',
    3 => 'passport_no',
    4 => 'country_id',
    5 => 'c_id'
);

$totalData = 0;
$totalFiltered = 0;
$sql=$obj->query("select COUNT(id) as num_rows from $tbl_student where 1=1 ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 
$whr1 = '';
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}

$account_manager = getField('account_manager', $tbl_admin, $_SESSION['sess_admin_id']);
if($account_manager != ''){
$account_managers = explode(',', $account_manager);

$data = array();
$sql = "SELECT a.* FROM $tbl_student AS a";
if (!empty($account_managers)) {
  $sql .= " WHERE (";
  foreach ($account_managers as $key => $manager) {
      $manager = intval($manager); // Assuming $manager should be an integer
      if ($key === 0) {
          $sql .= "a.am_id = $manager";
      } else {
          $sql .= " OR a.am_id = $manager";
      }
  }
  $sql .= ")";
}
$sql .= " $whr1   AND a.id NOT IN (
                                    SELECT ss.stu_id
                                    FROM tbl_student_status AS ss
                                    WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold', 'Back-Out')
                                    )";
    if (!empty($requestData['search']['value'])) {
        $searchValue = $requestData['search']['value'];
        $sql .= " AND (a.student_no LIKE '%$searchValue%' OR a.cdate LIKE '%$searchValue%' OR a.stu_name LIKE '%$searchValue%' OR a.passport_no LIKE '%$searchValue%')";
    }

    $query = $obj->query($sql);

    $totalFiltered = $obj->numRows($query);

    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . "," . $requestData['length'];
// echo $sql;die;
    $query = $obj->query($sql);
  

    while ($line = $obj->fetchNextObject($query)) {
        $nestedData = array();
        // if($line->student_type==1){
        //     $student_type='New'; 
        //   }else if($line->student_type==6){
        //     $student_type='Re-Apply(Next Intake)';
        //   }
        //   else if($line->student_type==3){
        //     $student_type='Refused';
        //   }
        //   else if($line->student_type==4){
        //     $student_type='Re-apply (Same Intake)';
        //   }
        //   else if($line->student_type==5){
        //     $student_type='Re-Apply(New Applications)';
        //   }
        //   else if($line->student_type==2){
        //     $student_type='Defer';
        //   }
        //   else if($line->student_type==7){
        //     $student_type='New(Outsider Refused)';
        //   }
        $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
          $color = '';
          $today = time(); 
          $get_time = $obj->query("select cdate from $tbl_student_updated_time where stu_id='".$line->id."'  and user_id='".$_SESSION['sess_admin_id']."'",-1);//die();
          $timeResult=$obj->fetchNextObject($get_time);
          if($obj->numRows($get_time)>0){
            $cdate = strtotime($timeResult->cdate);
            $datetime1 = new DateTime(date("Y-m-d", $cdate));
            $datetime2 = new DateTime(date("Y-m-d", $today));
            $interval = $datetime1->diff($datetime2);
            $difference = $interval->format('%a'); 
            if($difference > 7){
              $color = "style='color:red'";
            }
          } 
          if($line->am_assign_date_time != ''){
            $day = date('D', strtotime($line->am_assign_date_time));
            if($day == 'Sat'){
              $dif = 3;
            }else{
              $dif = 2;
            }
            $get_a1 = $obj->query("select id from $tbl_student_application where stu_id='".$line->id."' and parent_id='0'",-1);//die();
            $r_a1=$obj->numRows($get_a1);
            $get_a = $obj->query("select id from $tbl_student_application where stu_id='".$line->id."' and status='Application Submitted'",-1);//die();
            $r_a=$obj->numRows($get_a);
            $cdate = strtotime($line->am_assign_date_time);
            $datetime1 = new DateTime(date("Y-m-d", $cdate));
            $datetime2 = new DateTime(date("Y-m-d", $today));
            $interval = $datetime1->diff($datetime2);
            $difference = $interval->format('%a'); 
            if($r_a < $r_a1 && $difference > $dif){
              $color = "style='color:#fd00f5'";
            }
          }
          $approve = '';
          $get = $obj->query("SELECT id FROM $tbl_student_application AS ss WHERE ss.status IN ('I-20 Received') and ss.stu_id='".$line->id."' and parent_id=0");
          $get1 = $obj->query("SELECT id FROM $tbl_student_status AS ss WHERE ss.cstatus IN ('Maximum I-20 Received') and ss.stu_id='".$line->id."'");
          if($obj->numRows($get) > 2 || $obj->numRows($get1) > 0){
            if($line->approve_review == 0){
              $approve = "<a class='btn btn-danger' id='change_review".$line->id."' onclick='change_review(".$line->id.")'>Pending</a>";
            }else{
              $approve = "<a class='btn btn-success'>Approved</a>";
            } 
          }
          
        $nestedData[] = "<span ".$color.">".$line->student_no."</span>";
        $nestedData[] = "<span ".$color.">".date("d M y", strtotime($line->cdate))."</span>";
        $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
        $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
        $nestedData[] = "<span ".$color.">".getField('name', $tbl_country, $line->country_id)."</span>";
        $nestedData[] = "<span ".$color.">".$student_type."</span>"; 
        $nestedData[] = "<span ".$color.">".getField('name', $tbl_admin, $line->c_id)."</span>";
        $nestedData[] = "<span ".$color.">".getField('name', $tbl_admin, $line->am_id)."</span>";
        $nestedData[] = "<span ".$color.">".getField('name', $tbl_branch, getField('branch_id', $tbl_admin, $line->c_id))."</span>";
        $nestedData[] = "<span ".$color.">"."<a href='student-editf.php?id=" . base64_encode(base64_encode(base64_encode($line->id))) . "'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i></a>"."</span>";
        $nestedData[] = $approve;

        $data[] = $nestedData;
    }
  }
$json_data = array(
    "draw" => intval($requestData['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);


echo json_encode($json_data);
?>
