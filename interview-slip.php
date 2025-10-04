<?php
session_start();
include('include/config.php');
include("include/functions.php");
if(isset($_GET['interview'])){
$id = base64_decode(base64_decode(base64_decode($_GET['id'])));
$res=$obj->fetchNextObject($obj->query("SELECT * FROM $tbl_student_interview_preparation where 1=1 and stu_id='$id' and status=1",$debug=-1));
$res1=$obj->fetchNextObject($obj->query("SELECT status_branch as branch_id FROM $tbl_student_status where status_branch is not null and cstatus='Start Classes' and stu_id='{$res->stu_id}'",$debug=-1));
$code = getField('student_no',$tbl_student, $res->stu_id);
$name = getField('stu_name',$tbl_student, $res->stu_id);
}
elseif(isset($_GET['duolingo'])){
  $id = base64_decode(base64_decode(base64_decode($_GET['id'])));
  $res=$obj->fetchNextObject($obj->query("SELECT * FROM $tbl_duolingo_classe where 1=1 and visit_id='$id' and status=1",$debug=-1));
  $res1=$obj->fetchNextObject($obj->query("SELECT branch_id,applicant_alternate_no,applicant_contact_no FROM $tbl_visit where id='$id'",$debug=-1));
    $tsql = $obj->query("select stu_name,student_no from $tbl_student where  (student_contact_no='".$res1->applicant_contact_no."' or alternate_contact='".$res1->applicant_contact_no."' or student_contact_no='".$res1->applicant_alternate_no."' or alternate_contact='".$res1->applicant_alternate_no."') order by id desc");
      $tnumR_data = $obj->fetchNextObject($tsql);
  $code = $tnumR_data->student_no;
  $name = $tnumR_data->stu_name;
}
elseif(isset($_GET['spoken'])){
  $id = base64_decode(base64_decode(base64_decode($_GET['id'])));
  $res=$obj->fetchNextObject($obj->query("SELECT * FROM $tbl_spoken_classe where 1=1 and visit_id='$id' and status=1",$debug=-1));
  $res1=$obj->fetchNextObject($obj->query("SELECT branch_id,applicant_alternate_no,applicant_contact_no FROM $tbl_visit where id='$id'",$debug=-1));
    $tsql = $obj->query("select stu_name,student_no from $tbl_student where  (student_contact_no='".$res1->applicant_contact_no."' or alternate_contact='".$res1->applicant_contact_no."' or student_contact_no='".$res1->applicant_alternate_no."' or alternate_contact='".$res1->applicant_alternate_no."') order by id desc");
      $tnumR_data = $obj->fetchNextObject($tsql);
  $code = $tnumR_data->student_no;
  $name = $tnumR_data->stu_name;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IBT Duolingo Class Entry Card</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fff;
      margin: 0;
      padding: 0;
    }

    .entry-card {
      max-width: 600px;
      margin: 30px auto;
      border: 1px solid #ccc;
    }

    .card-header {
      background-color: #0056a4;
      color: #fff;
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo {
      height: 60px;
    }

    .title-text {
      text-align: right;
      flex-grow: 1;
      margin-left: 20px;
    }

    .title-text h1 {
      font-size: 24px;
      margin: 0;
      font-weight: bold;
    }

    .title-text .sub-title {
      background-color: white;
      color: #000;
      padding: 4px 10px;
      display: inline-block;
      font-weight: bold;
      border-radius: 4px;
      margin-top: 5px;
    }

    .card-body {
      padding: 20px;
    }

    .form-row {
      display: flex;
      margin-bottom: 15px;
    }

    .form-row label {
      width: 120px;
      font-weight: bold;
    }

    .form-row span {
      flex: 1;
      border-bottom: 1px dotted #000;
      padding-left: 10px;
    }
  </style>
</head>
<body onload="window.print()">
  <div class="entry-card">
    <div class="card-header">
      <img src="img/footer-logo.png" alt="IBT Logo" class="logo">
      <div class="title-text">
        <h1><?php if(isset($_GET['interview'])){ echo 'INTERVIEW CLASSES'; }elseif(isset($_GET['duolingo'])){ echo 'DUOLINGO CLASS';}elseif(isset($_GET['spoken'])){ echo 'SPOKEN CLASSES'; }?></h1>
        <div class="sub-title">ENTRY CARD</div>
      </div>
    </div>
    <div class="card-body">
      <div class="form-row"><label>Code :</label><span><?=$code?></span></div>
      <div class="form-row"><label>Name :</label><span><?=$name?></span></div>
      <div class="form-row"><label>Branch :</label><span><?=$res->class_mode == 'Online' ? 'N/A' : getField('name',$tbl_branch,$res1->branch_id)?></span></div>
     <?php if(!isset($_GET['spoken'])){ ?> <div class="form-row"><label>Mode :</label><span><?=$res->class_mode?></span></div><?php } ?>
      <div class="form-row"><label>Days :</label><span><?=$res->no_of_days?></span></div>
      <div class="form-row"><label>Start Date :</label><span><?=$res->class_start_date?></span></div>
      <div class="form-row"><label>End Date :</label><span><?=$res->class_end_date?></span></div>
    </div>
  </div>
</body>
</html>
