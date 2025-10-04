<?php 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

if ($_SESSION['reload']=="0") {
 $_SESSION['reload']="2";
}else{
  $_SESSION['reload']="1";
}
// print_r('======================================');
// print_r($_SESSION['reload']);
if($_REQUEST['userDetails']=='yes'){
  $sql='';
  $id=$obj->escapestring($_POST['id']);
  $stu_name=$obj->escapestring($_POST['stu_name']);
  if($stu_name!=''){
    $sql .= "stu_name='$stu_name'";
  }
  $father_name=$obj->escapestring($_POST['father_name']);
  if($stu_name!=''){
    $sql .= ",father_name='$father_name'";
  }
  $dob=$obj->escapestring($_POST['dob']);
  if($dob!=''){
     $sql .= ",dob='$dob'";
  }
  $passport_no=$obj->escapestring($_POST['passport_no']);
  if($passport_no!=''){
     $sql .= ",passport_no='$passport_no'";
  }
  $country_id=$obj->escapestring($_POST['country_id']);
  if($country_id!=''){
     $sql .= ",country_id='$country_id'";
  }
  $visa_id=$obj->escapestring($_POST['visa_id']);
  if($visa_id!=''){
     $sql .= ",visa_id='$visa_id'";
  }
  $am_id=$obj->escapestring($_POST['am_id']);
  if($am_id!=''){
     $sql .= ",am_id='$am_id'";
  }
  $c_id=$obj->escapestring($_POST['c_id']);
  if($c_id!=''){
     $sql .= ",c_id='$c_id'";
  }

  $accpet_student=$obj->escapestring($_POST['accpet_student']);
  if($accpet_student!=''){

     $sql .= ",accept_student='$accpet_student'";
  }

  $dataResult = $_POST['result'];
  $data = $_POST['data'];
  $data2 = $_POST['data2'];
  $data3 = $_POST['data3'];
if($id!='' ){
  $obj->query("update $tbl_student set $sql where id=".$id,-1);// die;
  if ($dataResult!='') {
  if(count($dataResult)>0){
    $sql="delete from $tbl_student_univercity_course where sutdent_id='".$id."'"; 
    $obj->query($sql);
    foreach($dataResult as $val){

      $obj->query("insert into $tbl_student_univercity_course set sutdent_id='$id', state_id='".$val['state_id']."',univercity_id='".$val['univercity_id']."',course_id='".$val['course_id']."',month='".$val['month']."',year='".$val['year']."'",-1);//die;
    }
  }
}
if ($data!='') {
  if(count($data)>0){
    $sql="delete from $tbl_student_diploma where sutdent_id='".$id."'"; 
    $obj->query($sql);
    foreach($data as $dataVal){
      $obj->query("insert into $tbl_student_diploma set sutdent_id='$id', diploma_id='".$dataVal['diploma_id']."',start_date='".$dataVal['start_date']."',end_date='".$dataVal['end_date']."',time_duration='".$dataVal['time_duration']."',status='".$dataVal['status']."'",-1);//die;
    }
  }
}
if ($data2!='') {
  if(count($data2)>0){
    $sql="delete from $tbl_student_experience where sutdent_id='".$id."'"; 
    $obj->query($sql);
    foreach($data2 as $dataVal){
      $obj->query("insert into $tbl_student_experience set sutdent_id='$id', experience_id='".$dataVal['experience_id']."',start_date='".$dataVal['start_date']."',end_date='".$dataVal['end_date']."',time_duration='".$dataVal['time_duration']."',status='".$dataVal['status']."'",-1);//die;
    }
  }
}
if ($data3!='') {

  if(count($data3)>0){
    $sql="delete from $tbl_student_found where sutdent_id='".$id."'"; 
    $obj->query($sql);
    foreach($data3 as $dataVal){
      $obj->query("insert into $tbl_student_found set sutdent_id='$id', amount='".$dataVal['amount']."',notes='".$dataVal['notes']."',stu_status='".$dataVal['status']."'",-1);//die;
    }
  }
}
   $_SESSION['sess_msg']='Student updated sucessfully';   

$_SESSION['reload']="0";
 header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($obj->escapestring($_REQUEST['id']))))); 
// header("location:student-list.php");
// exit();
}

}


if ($_REQUEST['userRecovery']=='yes') {
  $emailId=$obj->escapestring($_REQUEST['offical_email']);
  $recovery_email=$obj->escapestring($_REQUEST['recovery_email']);

   $id=$obj->escapestring($_REQUEST['uid']);

if ($id=='') {

  if ($emailId!=$recovery_email) {
    $obj->query("insert into $tbl_user_recovery set user_id='".$obj->escapestring($_REQUEST['user_id'])."',student_id='".$obj->escapestring($_REQUEST['sutdent_id'])."',offical_email='".$obj->escapestring($_REQUEST['offical_email'])."',password='".$obj->escapestring($_REQUEST['password'])."',recovery_email='".$obj->escapestring($_REQUEST['recovery_email'])."',recovery_number='".$obj->escapestring($_REQUEST['recovery_number'])."'",-1); //die; 
    $_SESSION['sess_msg']='Student updated sucessfully';   

$_SESSION['reload']="0";
  }else{
   $_SESSION['sess_msg_error']='Official Email can not be same as Recovery Email.';  
  }
}else{
  if ($emailId!=$recovery_email) {
    $obj->query("UPDATE $tbl_user_recovery set user_id='".$obj->escapestring($_REQUEST['user_id'])."',student_id='".$obj->escapestring($_REQUEST['sutdent_id'])."',offical_email='".$obj->escapestring($_REQUEST['offical_email'])."',password='".$obj->escapestring($_REQUEST['password'])."',recovery_email='".$obj->escapestring($_REQUEST['recovery_email'])."',recovery_number='".$obj->escapestring($_REQUEST['recovery_number'])."' where id='$id'",-1);// die; 
    $_SESSION['sess_msg']='Student updated sucessfully';   

$_SESSION['reload']="0";
  }else{
    $_SESSION['reload']="0";
   $_SESSION['sess_msg_error']='Official Email can not be same as Recovery Email.';  
  }

}
}    



if ($_REQUEST['userFilingCredentoals']=='yes') {


$sql='';

 $user_id = $obj->escapestring($_REQUEST['user_id']);
  if($user_id!=''){
  $sql .= "user_id='$user_id'";
  }
  $student_id = $obj->escapestring($_REQUEST['sutdent_id']);
  if($student_id!=''){
  $sql .= ",student_id='$student_id'";
  }
   $cgi_user_id =$obj->escapestring($_REQUEST['cgi_user_id']);
  if($cgi_user_id!=''){
  $sql .= ",cgi_user_id='$cgi_user_id'";
  }
   $cgi_password = $obj->escapestring($_REQUEST['cgi_password']);
  if($cgi_password!=''){
  $sql .= ",cgi_password='$cgi_password'";
  }

  $cgi_email = $obj->escapestring($_REQUEST['cgi_email']);
  if($cgi_email!=''){
  $sql .= ",cgi_email='$cgi_email'";
  }
   $email_password = $obj->escapestring($_REQUEST['email_password']);
  if($email_password!=''){
  $sql .= ",email_password='$email_password'";
  }
    $recovery_email = $obj->escapestring($_REQUEST['cgi_recovery_email']);
  if($recovery_email!=''){
  $sql .= ",recovery_email='$recovery_email'";
  }
     $recovery_number = $obj->escapestring($_REQUEST['cgi_recovery_number']);
  if($recovery_number!=''){
  $sql .= ",recovery_number='$recovery_number'";
  }
     $security_answer = $obj->escapestring($_REQUEST['security_answer']);
  if($security_answer!=''){
  $sql .= ",security_answer='$security_answer'";
  }
     $ds_application_id = $obj->escapestring($_REQUEST['ds_application_id']);
  if($ds_application_id!=''){
  $sql .= ",ds_application_id='$ds_application_id'";
  }

  
if ($_REQUEST['Cid']=='') {
    $obj->query("insert into $tbl_filing_credentials set $sql",-1);// die; 
$_SESSION['reload']="0";
}else{
    $obj->query("UPDATE $tbl_filing_credentials set $sql where id='".$_REQUEST['Cid']."'",-1);//die; 
$_SESSION['reload']="0";
}
}

if($_REQUEST['id']!=''){
  $stu_id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
  $sql=$obj->query("select * from $tbl_student where id=".base64_decode(base64_decode(base64_decode($_REQUEST['id']))),-1); //die;
  $result=$obj->fetchNextObject($sql);
}

$usql=$obj->query("select * from $tbl_user_recovery where student_id='$result->id'",-1);//die();
$uresult=$obj->fetchNextObject($usql);

$usql=$obj->query("select * from $tbl_filing_credentials where student_id='$result->id'",-1);//die();
$filingresult=$obj->fetchNextObject($usql);

?>
<?php 
$rr=1; 



// $json_string = json_encode($_REQUEST);
// $log_file='log'.date('Ymd').'.txt';
// $file_handle = fopen($log_file, 'a');
// fwrite($file_handle, "\n\n------------------------------------------".date('d M Y H:i:s')."----------------------------------------\n\n");
// fwrite($file_handle, $json_string);
// fclose($file_handle);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('head.php'); ?>
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
  <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
</head>
<style>

  .document-new-class{
    margin-top: 10px;   
  }

  .document-new-class img{
    height: 150px !important;
    width: 150px !important;
    padding: 5px;
  }

  .upload-files-container {

    width: 175px;
    height: 230px;
    border: 1px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin-top: 10px;
  }
  .drag-file-area {

    border-radius: 40px;
    margin: 10px 0 15px;

    width: 100%;
    text-align: center;
  }
  .drag-file-area .upload-icon {
    font-size: 50px;
  }
  .drag-file-area h3 {
    font-size: 13px;
    margin: 15px 0;
  }
  .drag-file-area label {
    font-size: 14px;
  }
  .drag-file-area label .browse-files-text {
    color: #363e91;
    font-weight: bolder;
    cursor: pointer;
  }
  .browse-files span {
    position: relative;
    top: -25px;
  }
  .default-file-input {
    opacity: 0;
  }
  .cannot-upload-message {
    background-color: #ffc6c4;
    font-size: 17px;
    display: flex;
    align-items: center;
    margin: 5px 0;
    padding: 5px 10px 5px 30px;
    border-radius: 5px;
    color: #BB0000;
    display: none;
  }
  @keyframes fadeIn {
    0% {opacity: 0;}
    100% {opacity: 1;}
  }
  .cannot-upload-message span, .upload-button-icon {
    padding-right: 10px;
  }
  .cannot-upload-message span:last-child {
    padding-left: 20px;
    cursor: pointer;
  }
  .file-block {
    color: #f7fff7;
    background-color: #7b2cbf;
    transition: all 1s;
    width: ;
    position: relative;
    display: none;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin: 10px 0 15px;
    padding: 10px 20px;
    border-radius: 25px;
    cursor: pointer;
  }
  .file-info {
    display: flex;
    align-items: center;
    font-size: 15px;
  }
  .file-icon {
    margin-right: 10px;
  }
  .file-name, .file-size {
    padding: 0 3px;
  }
  .remove-file-icon {
    cursor: pointer;
  }
  .progress-bar {
    display: flex;
    position: absolute;
    bottom: 0;
    left: 4.5%;
    width: 0;
    height: 5px;
    border-radius: 25px;
    background-color: #4BB543;
  }
  .upload-button {
    font-family: 'Montserrat';
    background-color: #7b2cbf;
    color: #f7fff7;
    display: flex;
    align-items: center;
    font-size: 18px;
    border: none;
    border-radius: 20px;
    margin: 10px;
    padding: 7.5px 50px;
    cursor: pointer;
  }
  .upload-button1 {
    position: relative;

    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .4s;
    position: absolute;
    top: 40%;
    left: 43%;

    color: #000;
  }
  .drag-file-area .label img {
    height: 30px;
    position: absolute;
    right: 45%;
    top: 45%;
  }
  .documnt {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    position: relative;
  }

  .documnt1 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
  }
  #appdatable_1_length{display: none;}
  #statusdatable_1_length{display: none;}



  h3 {
    line-height: 30px;
    text-align: center;
  }

  #drop_file_area1 {
    height: 150px;
    width: 150px;
    border: 2px dashed #ccc;
    line-height: 143px;
    text-align: center;
    font-size: 11px;
    background: #f9f9f9;
    margin-bottom: 15px;
  }

  #drop_file_area2 {
    height: 150px;
    width: 150px;
    border: 2px dashed #ccc;
    line-height: 143px;
    text-align: center;
    font-size: 11px;
    background: #f9f9f9;
    margin-bottom: 15px;
  }

  #drop_file_area3 {
    height: 150px;
    width: 150px;
    border: 2px dashed #ccc;
    line-height: 143px;
    text-align: center;
    font-size: 11px;
    background: #f9f9f9;
    margin-bottom: 15px;
  }

  #drop_file_area4 {
    height: 150px;
    width: 150px;
    border: 2px dashed #ccc;
    line-height: 143px;
    text-align: center;
    font-size: 11px;
    background: #f9f9f9;
    margin-bottom: 15px;
  }

  .drag_over {
    color: #000;
    border-color: #000;
  }

  .thumbnail {
    width: 140px;
    height: 150px !important;
    padding: 2px;
    margin: 2px;
    border: 2px solid lightgray;
    border-radius: 3px;
    float: left;
  }

  #upload_file {
    display: none;
  }
   table.fold-table > tbody > tr.view td, table.fold-table > tbody > tr.view th {
  cursor: pointer;
}
table.fold-table > tbody > tr.view td:first-child, table.fold-table > tbody > tr.view th:first-child {
  position: relative;
  padding-left: 20px;
}
table.fold-table > tbody > tr.view td:first-child:before, table.fold-table > tbody > tr.view th:first-child:before {
  position: absolute;
  top: 50%;
  left: 5px;
  width: 9px;
  height: 16px;
  margin-top: -8px;
  font: 16px fontawesome;
  color: #999;
  content: "\f0d7";
  transition: all 0.3s ease;
}
table.fold-table > tbody > tr.view:nth-child(4n-1) {
  background: #eee;
}
table.fold-table > tbody > tr.view:hover {
  background: #2ecd99 !important;
}
table.fold-table > tbody > tr.view.open {
  background: #2ecd99;
  color: white;
}
table.fold-table > tbody > tr.view.open td:first-child:before, table.fold-table > tbody > tr.view.open th:first-child:before {
  transform: rotate(-180deg);
  color: #333;
}
table.fold-table > tbody > tr.fold {
  display: none;
}
table.fold-table > tbody > tr.fold.open {
  display: table-row;
}
.fold-content {
  padding: 0.5em;
}
.fold-content h3 {
  margin-top: 0;
}
.fold-content > table {
  border: 2px solid #ccc;
}
.fold-content > table > tbody tr:nth-child(even) {
  background: #eee;
}



</style>
<?php
if($_SESSION['level_id']==1 || $_SESSION['level_id']==2){
  $readonly = "";
  $udisabled = '';
  $cwhr='';
}else{
  $readonly = "readonly";
  $udisabled = 'disabled';
}
?>
<body>
  <div class="preloader-it">
    <div class="la-anim-1"></div>
  </div>
  <div class="wrapper theme-1-active pimary-color-green">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <div class="page-wrapper">
      <div class="container">

      <h5 style="color:#2a911d; text-align: center;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
      <h5 style="color:red; text-align: center;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
        <div class="student_filter">
          <h4 class="my-3">Edit Student</h4>
          <form method="post" action="" >
            <input type="hidden" name="userDetails" id="userDetails" value="yes">
            <input type="hidden" name="id" id="id" value="<?php echo $stu_id; ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Student ID</div>
                    <input type="text"  class="form-control" id="student_no" name="student_no" placeholder="" value="<?php echo $result->student_no ?>" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Name</div>
                    <input type="text" class="form-control" id="stu_name" name="stu_name" placeholder="" value="<?php echo $result->stu_name ?>" <?php echo $readonly ?>>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Father's Name</div>
                    <input type="text" class="form-control" name="father_name" id="father_name" placeholder="" value="<?php echo $result->father_name ?>" <?php echo $readonly ?>>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">D.O.B</div>
                    <input type="date" class="form-control " name="dob" id="dob" placeholder="" value="<?php echo $result->dob ?>" <?php echo $readonly ?> max="9999-12-31">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Passport No.</div>
                    <input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="" value="<?php echo $result->passport_no ?>" <?php echo $readonly ?>>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Country</div>
                    <select class="form-control" name="country_id" id="country_id" <?php echo $udisabled; ?>>
                      <option value="">Select Country</option>
                      <?php
                      $i=1;
                      $sql=$obj->query("select * from $tbl_country where status=1",$debug=-1);
                      while($line=$obj->fetchNextObject($sql)){?>
                        <option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
                      <?php } ?>
                    </select>

                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Visa Type</div>
                    <select class="form-control" name="visa_id" id="visa_id" <?php echo $udisabled; ?>>
                      <option value="">Select Visa Type</option>
                      <option value="1" <?php if($result->visa_id==1){?> selected <?php } ?>>Study Visa</option>
                      <option value="2" <?php if($result->visa_id==2){?> selected <?php } ?>>Tourist Visa</option>
                      <option value="3" <?php if($result->visa_id==3){?> selected <?php } ?>>Visitor Visa</option>
                      <option value="4" <?php if($result->visa_id==4){?> selected <?php } ?>>Work Visa</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Counsellor Name</div>
                    <select class="form-control" name="c_id" id="c_id" <?php echo $udisabled; ?>>
                      <option value="">Select Counsellor</option>
                      <?php
                      if($_SESSION['level_id']==4){
                        $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and id='".$_SESSION['sess_admin_id']."'",-1); //die;
                     }else{
                        $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and branch_id in($result->branch_id) and level_id=4 $cwhr",-1);
                      }
                      while($cresult=$obj->fetchNextObject($csql)){?>
                        <option value="<?php echo $cresult->id ?>"<?php if($cresult->id==$result->c_id){?>selected<?php } ?>><?php echo $cresult->name .'  ('.$cresult->email.')'; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">Account Manager</div>                  
                    <select class="form-control" name="am_id" id="am_id"  <?php echo $udisabled; ?>>
                      <option value="">Select Account Manager</option>
                      <?php
                      if($_SESSION['level_id']==3){
                        $sql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and branch_id in($result->branch_id) and level_id=3 and id='".$_SESSION['sess_admin_id']."'",-1);
                      }else{
                        $sql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and  FIND_IN_SET($result->branch_id,branch_id) and level_id in (2,3)",-1);
                      }
                      
                      while($resultt=$obj->fetchNextObject($sql)){?>
                        <option value="<?php echo $resultt->id ?>"<?php if($resultt->id==$result->am_id){?>selected<?php } ?>><?php echo $resultt->name .'  ('.$resultt->email.')'; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
                <div class="col-md-2">
                  <button type="submit"  class="btn" style="width: 100% !important;">Submit</button>
                </div>
         <div class="col-md-3">
          <?php if ($_SESSION['level_id']==3) {?>
        
                <div class="counsller_recommend mt-3">
                    <input type="checkbox" id="accpet_student" name="accpet_student" value="1" <?php if($result->accept_student==1){?> checked onclick="return false"  <?php } ?>  >
  <label for="accpet_student" style="margin:auto;"> I accpet this student application.</label>
                </div><?php } ?>
              </div>
              <div class="col-md-9">
                <div class="counsller_recommend mt-3">
                  <a href="javascript:void(0);"  id="toggle">Counsellor Recommendations</a>
                </div>
              </div>

            </div>





          <div class="show_student_detail my-5" id="third" style="display:none;">
            <!-- add university recoomedation start -->
            <div class="add_student_section my-5">
              <div class="conatiner">
                <div class="university_recommend">
                  <h5>UNIVERSITY/COURSE RECOMMENDATION</h5>
                  <div class="universitycls" style="width:100%;position: relative;" id="add">
                    <div class="add-section">
                      <a class="add_field_button button"><i class="fa fa-plus" aria-hidden="true" style="color:#fff"></i></a> 
                    </div>
                    <?php
                    $ucr=0;
                    $usql = $obj->query("select * from $tbl_student_univercity_course where sutdent_id='$stu_id'",-1); //die;
                    while($uReslut = $obj->fetchNextObject($usql)){?>
                      <div class="course_add1">
                        <div class="course_form add_mrgin">
                          <div class="form-group" >
                            <select class="form-control state_id" name="result[<?php echo $ucr; ?>][state_id]" id="state_id">
                              <option>--Select your State--</option>
                              <?php
                              $i=1;
                              $sql=$obj->query("select * from $tbl_state where status=1 and country_id='".$result->country_id."'",$debug=-1);
                              while($line=$obj->fetchNextObject($sql)){?>
                                <option value="<?php echo $line->id ?>" <?php if($uReslut->state_id==$line->id){?> selected <?php }?>><?php echo $line->state ?></option>
                              <?php } ?>
                            </select>
                          </div>

      <div class="form-group">
        <select class="form-control" name="result[<?php echo $ucr; ?>][univercity_id]" id="univercity_id">
          <option value="">Select Your University</option>
          <?php
          $i=1;
          $sql=$obj->query("select * from $tbl_univercity where status=1",$debug=-1);
          while($line=$obj->fetchNextObject($sql)){?>
            <option value="<?php echo $line->id ?>" <?php if($uReslut->univercity_id==$line->id){?> selected <?php }?>><?php echo $line->name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" name="result[<?php echo $ucr; ?>][course_id]" id="course_id">
          <option value="">Select your Course</option>
          <?php
          $i=1;
          $sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY course_name",$debug=-1);
          while($line=$obj->fetchNextObject($sql)){?>
            <option value="<?php echo $line->id ?>" <?php if($uReslut->course_id==$line->id){?> selected <?php }?>><?php echo $line->course_name    ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" id="month" name="result[<?php echo $ucr; ?>][month]">
           <option value="0" >intake </option>
          <option value="1" <?php if($uReslut->month==1){?> selected <?php }?>>January</option>
          <option value="2" <?php if($uReslut->month==2){?> selected <?php }?>>February</option>
          <option value="3" <?php if($uReslut->month==3){?> selected <?php }?>>March</option>
          <option value="4" <?php if($uReslut->month==4){?> selected <?php }?>>April</option>
          <option value="5" <?php if($uReslut->month==5){?> selected <?php }?>>May</option>
          <option value="6" <?php if($uReslut->month==6){?> selected <?php }?>>June</option>
          <option value="7" <?php if($uReslut->month==7){?> selected <?php }?>>July</option>
          <option value="8" <?php if($uReslut->month==8){?> selected <?php }?>>August</option>
          <option value="9" <?php if($uReslut->month==9){?> selected <?php }?>>September</option>
          <option value="10" <?php if($uReslut->month==10){?> selected <?php }?>>October</option>
          <option value="11" <?php if($uReslut->month==11){?> selected <?php }?>>November </option>
          <option value="12" <?php if($uReslut->month==12){?> selected <?php }?>>December</option>
        </select>
      </div>

      <div class="form-group">
        <select class="form-control" id="year" name="result[<?php echo $ucr; ?>][year]">
          <?php
          $firstYear = (int)date('Y');
          $lastYear = $firstYear + 10;
          for($i=$firstYear;$i<=$lastYear;$i++)
            {?>
              <option value="<?php echo $i; ?>" <?php if($uReslut->year==$i){?> selected <?php }?>><?php echo $i; ?></option>';
            <?php }
            ?>
          </select>
        </div>
        <a href="#" class="remove_field delete_btn">X</a>
      </div>
    </div>
    <?php $ucr++; }?>
  </div>
</div>
</div>
</div>
<!-- add diploma recoomedation start -->

<div class="add_student_section my-5">
  <div class="conatiner">
    <div class="university_recommend">
      <h5>DIPLOMA RECOMMENDATION</h5>
      <div class="" style="width:100%; position: relative;" id="add2">
        <div class="add-section ">
          <a class="add_field_button2 button"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a> 
        </div>


        <?php
        $dr=0; 
$dsql = $obj->query("select * from $tbl_student_diploma where sutdent_id='$stu_id'",-1); //die;
while($dReslut = $obj->fetchNextObject($dsql)){?>
  <div class="course_add1">
    <div class="course_form add_mrgin" style="display: flex; justify-content:space-between;">
      <div class="form-group">
        <select class="form-control" name="data[<?php echo $dr; ?>][diploma_id]" id="diploma_id">
          <option value="">Select Your Diploma</option>
          <?php
          $i=1;
          $sql=$obj->query("select * from $tbl_gap where status=1",$debug=-1);
          while($line=$obj->fetchNextObject($sql)){?>
            <option value="<?php echo $line->id ?>" <?php if($dReslut->diploma_id==$line->id){?> selected <?php }?>><?php echo $line->diploma ?></option>
          <?php } ?>
        </select>
      </div>

<div class="form-group">
<input class="form-control form-control-lg start_date0" type="text" placeholder="DD-MM-YY"  name="data[<?php echo $dr; ?>][start_date]" id="dr_start_date<?php echo $dr; ?>" value="<?php echo $dReslut->start_date ?>">
</div>

<div class="form-group">
<input class="form-control form-control-lg start_date0" type="text" placeholder="DD-MM-YY"   name="data[<?php echo $dr; ?>][end_date]" id="dr_end_date<?php echo $dr; ?>" value="<?php echo $dReslut->end_date ?>">
</div>

<div class="form-group">
<input class="form-control form-control-lg" type="text" id="time_duration<?php echo $dr; ?>"  name="data[<?php echo $dr; ?>][time_duration]" placeholder="0 Year,6 Months" value="<?php echo $dReslut->time_duration ?>" >
</div>
      <script type="text/javascript">
      $(function() {
      var tid="<?php echo $dr; ?>";
      $("#dr_start_date"+tid).datepicker({
      dateFormat: 'dd-mm-yy',
      numberOfMonths: 1,
      changeMonth:true,
      changeYear:true,
      onSelect: function (selected) {
      $("#dr_end_date"+tid).datepicker("option", "minDate", selected);
      }
      });
     $("#dr_end_date"+tid).datepicker({
      dateFormat: 'dd-mm-yy',
     numberOfMonths: 1,
      changeMonth:true,
      changeYear:true,
      onSelect: function (selected) {
    $("#dr_start_date"+tid).datepicker("option", "maxDate", selected);
      var start = $('#dr_start_date'+tid).val();
      var end = $('#dr_end_date'+tid).val();
      var action='getdays';
      $.ajax({
      type:"post",
      url:"ajax/getModalData.php",
      data :{'start_date' : start,'end_date' : end,'action': action },          
      success:function(res){
      // $(".start_date").val(start);
      $("#time_duration"+tid).val(res);
      }
      });
      }
      });
      });
      </script>

      <div class="form-group">
        <select class="form-control" name="data[<?php echo $dr; ?>][status]" style="margin: 0 !important; position: relative;">
          <option value="status" <?php if($dReslut->status=='status'){?> selected <?php }?>>Status</option>
          <option value="outside" <?php if($dReslut->status=='outside'){?> selected <?php }?>>Outside</option>
          <option value="self" <?php if($dReslut->status=='self'){?> selected <?php }?>>Self </option>
          <option value="pending_confirmation" <?php if($dReslut->status=='pending_confirmation'){?> selected <?php }?>>Pending confirmation</option>

        </select>
      </div>
      <a href="#" class="remove_field2 delete_btn">X</a>
    </div>
  </div>
  <?php $dr++; }?>
</div>
</div>
</div>
</div>

<!-- add Experience recoomedation start -->

<div class="add_student_section my-5">
  <div class="conatiner">
    <div class="university_recommend">
      <h5>EXPERIENCE RECOMMENDATION</h5>
      <div class="" style="width:100%; position:relative" id="add3">
        <div class="add-section " >
          <a class="add_field_button3 button"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a> 
        </div>
        <?php
        $er=0; 
        $uesql = $obj->query("select * from $tbl_student_experience where sutdent_id='$stu_id'");
        while($ueReslut = $obj->fetchNextObject($uesql)){?>
          <div class="course_add1">
            <div class="course_form add_mrgin" style="display: flex; justify-content: space-between;">
              <div class="form-group">
                <select class="form-control" name="data2[<?php echo $er; ?>][experience_id]" id="experience_id">
                  <option value="">Select Your Experience</option>
                  <?php
                  $i=1;
                  $sql=$obj->query("select * from $tbl_gap where status=1",$debug=-1);
                  while($line=$obj->fetchNextObject($sql)){?>
                    <option value="<?php echo $line->id ?>" <?php if($ueReslut->diploma_id==$line->id){?> selected <?php }?>><?php echo $line->experience ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
              <input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[<?php echo $er; ?>][start_date]" id="er_start_date<?php echo $er; ?>" value="<?php echo $ueReslut->start_date ?>">
              </div>

              <div class="form-group">
              <input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2[<?php echo $er; ?>][end_date]" id="er_end_date<?php echo $er; ?>" value="<?php echo $ueReslut->end_date; ?>">
              </div>

              <div class="form-group">
              <input class="form-control form-control-lg" type="text" placeholder="0 Year,6 Months"  name="data2[<?php echo $er; ?>][time_duration]" id="er_time_duration<?php echo $er; ?>" value="<?php echo $ueReslut->time_duration; ?>">
              </div>
                <script type="text/javascript">
                $(function() {
                var tid="<?php echo $er; ?>";
                $("#er_start_date"+tid).datepicker({
                dateFormat: 'dd-mm-yy',
                numberOfMonths: 1,
                changeMonth:true,
                changeYear:true,
                onSelect: function (selected) {
                $("#er_end_date"+tid).datepicker("option", "minDate", selected);
                }
                });
                $("#er_end_date"+tid).datepicker({
                dateFormat: 'dd-mm-yy',
                numberOfMonths: 1,
                changeMonth:true,
                changeYear:true,
                onSelect: function (selected) {
                $("#er_start_date"+tid).datepicker("option", "maxDate", selected);
                var start = $('#er_start_date'+tid).val();
                var end = $('#er_end_date'+tid).val();
                var action='getdays';
                $.ajax({
                type:"post",
                url:"ajax/getModalData.php",
                data :{'start_date' : start,'end_date' : end,'action': action },          
                success:function(res){
                // $(".start_date").val(start);
                $("#er_time_duration"+tid).val(res);
                }
                });
                }
                });
                });
                </script>
              <div class="form-group" >
                <select class="form-control" name="data2[<?php echo $er; ?>][status]" style="margin: 0 !important;">
                  <option value="status" <?php if($ueReslut->status=='status'){?> selected <?php }?>>Status</option>
                  <option value="outside" <?php if($ueReslut->status=='outside'){?> selected <?php }?>>Outside</option>
                  <option value="self" <?php if($ueReslut->status=='self'){?> selected <?php }?>>Self </option>
                  <option value="pending_confirmation" <?php if($ueReslut->status=='pending_confirmation'){?> selected <?php }?>>Pending confirmation</option>

                </select>
              </div>
              <a href="#" class="remove_field3 delete_btn">X</a>
            </div>                        
          </div>
          <?php $er++; }?>
        </div>
      </div>
    </div>
  </div>

  <!-- add Experience recoomedation start -->

  <!-- add Experience recoomedation start -->

  <div class="add_student_section my-5">
    <div class="conatiner">
      <div class="university_recommend">
        <h5>FUND RECOMMENDATION</h5>
        <div class="" style="width:100%; position:relative" id="add4">
          <div class="add-section " >
            <a class="add_field_button4 button"><i class="fa fa-plus" aria-hidden="true" style="color:white;"></i></a> 
          </div>
          <?php
          $er=0; 
          $uesql = $obj->query("select * from $tbl_student_found where sutdent_id='$stu_id'");
          while($ueReslut = $obj->fetchNextObject($uesql)){?>
            <div class="course_add1">
              <div class="course_form add_mrgin" style="display: flex; justify-content: start;">

                <div class="form-group">
                  <input class="form-control form-control-lg " type="text" placeholder="15,00,000"  name="data3[<?php echo $er; ?>][amount]" id="amount" value="<?php echo $ueReslut->amount; ?>">
                </div>

                <div class="form-group">
                  <input class="form-control form-control-lg " type="text" placeholder="Notes" name="data3[<?php echo $er; ?>][notes]" id="notes" value="<?php echo $ueReslut->notes; ?>">
                </div>
                <div class="form-group" >
                <select class="form-control" name="data3[<?php echo $er; ?>][status]" style="margin: 0 !important;">
                  <option value="status" <?php if($ueReslut->stu_status=='status'){?> selected <?php }?>>Status</option>
                  <option value="outside" <?php if($ueReslut->stu_status=='outside'){?> selected <?php }?>>Outside</option>
                  <option value="self" <?php if($ueReslut->stu_status=='self'){?> selected <?php }?>>Self </option>
                  <option value="pending_confirmation" <?php if($ueReslut->stu_status=='pending_confirmation'){?> selected <?php }?>>Pending confirmation</option>

                </select>
              </div>
                <a href="#" class="remove_field4 test123 delete_btn">X</a>
              </div>                        
            </div>
            <?php $er++; }?>
          </div>
        </div>
      </div>
    </div>

    <!-- add Experience recoomedation start -->


  </form>
</div>

</div>

<div class="">
  <div class="panel panel-default card-view" style="background:transparent;">
    <div class="panel-wrapper collapse in">
      <div class="panel-body">
        <div class="tab-struct custom-tab-1 mt-40">
          <ul role="tablist" class="nav nav-tabs" id="myTabs_7">
            <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab"
              role="tab" id="home_tab_7" href="#home_7">Documents</a></li>
              <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7"
                role="tab" href="#profile_7" aria-expanded="false">Application</a></li>
                <li class="" role="presentation"><a aria-expanded="true" data-toggle="tab"
                  role="tab" id="status_tab_7" href="#status_7">Status</a></li>

                  <li role="presentation" class=""><a data-toggle="tab" id="notes_tab_7"
                    role="tab" href="#notes_7" aria-expanded="false">Notes</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" id="notes_tab_7"
                    role="tab" href="#credentials_7" aria-expanded="false">Filing Credentials</a></li>
                  </ul>
                  <div class="tab-content" id="myTabContent_7">
                    <div id="home_7" class="tab-pane fade active in" role="tabpanel">
                      <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                          <div class="panel-body">
                            <div class="pills-struct vertical-pills">
                              <ul role="tablist" class="nav nav-pills ver-nav-pills"
                              id="myTabs_10">
                              <li class="active" role="presentation"><a
                                aria-expanded="true" data-toggle="tab"
                                role="tab" id="home_tab_10"
                                href="#home_10">Academics</a></li>
                                <li role="presentation" class=""><a data-toggle="tab"
                                  id="profile_tab_10" role="tab"
                                  href="#profile_10"
                                  aria-expanded="false">Language Proficiency</a>
                                </li>
                                <li role="presentation" class=""><a data-toggle="tab"
                                  id="profile_tab_11" role="tab"
                                  href="#profile_11"
                                  aria-expanded="false">Financial</a></li>
                                  <li role="presentation" class=""><a data-toggle="tab"
                                    id="profile_tab_12" role="tab"
                                    href="#profile_12" aria-expanded="false">CA
                                  Report</a></li>
                                  <li role="presentation" class=""><a data-toggle="tab"
                                    id="profile_tab_13" role="tab"
                                    href="#profile_13" aria-expanded="false">Trash Documents </a></li>
                                  </ul>
                                  <div class="tab-content" id="myTabContent_10">
                                    <div id="home_10" class="tab-pane fade active in"
                                    role="tabpanel">
                                    <div class="acedmics-certificate">
                                      <form method="post" action="">
                                        <input type="hidden" name="dtype" id="dtype1" value="1">
                                        <input type="hidden" name="stu_id" id="stu_id1" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
                                        <div class="row">
                                          <div class="col-md-2 col-12 documnt">            
                                            <div id="drop_file_area1">
                                              <label class="upload-area">
                                                <input type="file" multiple id="gallery-photo-add1" style="    height: 150;
                                                width: 145px;
                                                overflow: hidden;
                                                position: relative;
                                                cursor: pointer;
                                                background-color: #DDF;
                                                opacity: 0;">
                                                <span class="upload-button1">
                                                  <i class="fas fa-upload" style="font-size:24px;"></i>
                                                </span>
                                              </label>
                                            </div>
                                          </div>
                                          <div id="uploaded_file1"></div>
                                          <?php
                                          $fsql = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=1 and status=1");
                                          while($fResult = $obj->fetchNextObject($fsql)){
                                            if ($fResult->desiredExt=='jpg') {?>
                                              <div class="col-md-2 col-12 documnt">
                                                <img src="uploads/<?php echo $fResult ->name; ?>" alt="" style="width: 140px;
                                                height: 150px;
                                                border: 1px solid #7777;
                                                padding: 3px;
                                                margin: 0px 10px;
                                                ">
                                                <p><?php echo $fResult ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult ->id ?>)"></a>
                                              </div>
                                            <?php }else{ ?>
                                              <div class="col-md-2 col-12 documnt">
                                                <a href="uploads/<?php echo $fResult ->name ?>" download >
                                                  <img src="uploads/download.png" alt="" style="width: 140px;
                                                  height: 150px;
                                                  border: 1px solid #7777;
                                                  padding: 3px;
                                                  margin: 0px 10px;
                                                  ">
                                                </a>
                                                <p><?php echo $fResult ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult ->id ?>)"></a>
                                              </div>
                                            <?php } }?>
                                          </div> 
                                        </form>
                                      </div>
                                    </div>
                                    <div id="profile_10" class="tab-pane fade"
                                    role="tabpanel">
                                    <div class="acedmics-certificate">
                                      <form method="post" action="">
                                        <input type="hidden" name="dtype" id="dtype2" value="2">
                                        <input type="hidden" name="stu_id" id="stu_id2" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
                                        <div class="row">
                                          <div class="col-md-2 col-12 documnt">            
                                            <div id="drop_file_area2">
                                              <label class="upload-area">
                                                <input type="file" multiple id="gallery-photo-add" style="    height: 150;
                                                width: 145px;
                                                overflow: hidden;
                                                position: relative;
                                                cursor: pointer;
                                                background-color: #DDF;
                                                opacity: 0;">
                                                <span class="upload-button1">
                                                  <i class="fas fa-upload" style="font-size:24px;"></i>
                                                </span>
                                              </label>
                                            </div>
                                          </div>
                                          <div id="uploaded_file2"></div>
                                          <?php
                                          $fsql2 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=2 and status=1");
                                          while($fResult2 = $obj->fetchNextObject($fsql2)){
                                            if ($fResult2->desiredExt=='jpg') {?>
                                              <div class="col-md-2 col-12 documnt">
                                                <img src="uploads/<?php echo $fResult2->name; ?>" alt="" style="width: 140px;
                                                height: 150px;
                                                border: 1px solid #7777;
                                                padding: 3px;
                                                margin: 0px 10px;
                                                ">
                                                 <p><?php echo $fResult2 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult2->id ?>)"></a>
                                              </div>
                                            <?php }else{ ?>
                                              <div class="col-md-2 col-12 documnt">
                                                <a href="uploads/<?php echo $fResult2->name ?>" download >
                                                  <img src="uploads/download.png" alt="" style="width: 140px;
                                                  height: 150px;
                                                  border: 1px solid #7777;
                                                  padding: 3px;
                                                  margin: 0px 10px;
                                                  ">
                                                </a>
                                                 <p><?php echo $fResult2 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult2->id ?>)"></a>
                                              </div>
                                            <?php } }?>
                                          </div> 
                                        </form>
                                      </div>
                                    </div>
                                    <div id="profile_11" class="tab-pane fade "
                                    role="tabpanel">
                                    <div class="acedmics-certificate">
                                      <form method="post" action="">
                                        <input type="hidden" name="dtype" id="dtype3" value="3">
                                        <input type="hidden" name="stu_id" id="stu_id3" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
                                        <div class="row">
                                          <div class="col-md-2 col-12 documnt">            
                                            <div id="drop_file_area3">
                                              <label class="upload-area">
                                                <input type="file" multiple id="gallery-photo-add3" style="    height: 150;
                                                width: 145px;
                                                overflow: hidden;
                                                position: relative;
                                                cursor: pointer;
                                                background-color: #DDF;
                                                opacity: 0;">
                                                <span class="upload-button1">
                                                  <i class="fas fa-upload" style="font-size:24px;"></i>
                                                </span>
                                              </label>
                                            </div>
                                          </div>
                                          <div id="uploaded_file3"></div>
                                          <?php
                                          $fsql3 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=3 and status=1");
                                          while($fResult3 = $obj->fetchNextObject($fsql3)){
                                            if ($fResult3->desiredExt=='jpg') {?>
                                              <div class="col-md-2 col-12 documnt">
                                                <img src="uploads/<?php echo $fResult3->name; ?>" alt="" style="width: 140px;
                                                height: 150px;
                                                border: 1px solid #7777;
                                                padding: 3px;
                                                margin: 0px 10px;
                                                ">
                                                 <p><?php echo $fResult3 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult3->id ?>)"></a>
                                              </div>
                                            <?php }else{ ?>
                                              <div class="col-md-2 col-12 documnt">
                                                <a href="uploads/<?php echo $fResult3->name ?>" download >
                                                  <img src="uploads/download.png" alt="" style="width: 140px;
                                                  height: 150px;
                                                  border: 1px solid #7777;
                                                  padding: 3px;
                                                  margin: 0px 10px;
                                                  ">
                                                </a>
                                                 <p><?php echo $fResult3 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult3->id ?>)"></a>
                                              </div>
                                            <?php } }?>
                                          </div> 
                                        </form>
                                      </div>
                                    </div>
                                    <div id="profile_12" class="tab-pane fade"
                                    role="tabpanel">
                                    <div class="acedmics-certificate">
                                      <form method="post" action="">
                                        <input type="hidden" name="dtype" id="dtype4" value="4">
                                        <input type="hidden" name="stu_id" id="stu_id4" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
                                        <div class="row">
                                          <div class="col-md-2 col-12 documnt">            
                                            <div id="drop_file_area4">
                                              <label class="upload-area">
                                                <input type="file" multiple id="gallery-photo-add4" style="    height: 150;
                                                width: 145px;
                                                overflow: hidden;
                                                position: relative;
                                                cursor: pointer;
                                                background-color: #DDF;
                                                opacity: 0;">
                                                <span class="upload-button1">
                                                  <i class="fas fa-upload" style="font-size:24px;"></i>
                                                </span>
                                              </label>
                                            </div>
                                          </div>
                                          <div id="uploaded_file4"></div>
                                          <?php
                                          $fsql4 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=4 and status=1");
                                          while($fResult4 = $obj->fetchNextObject($fsql4)){
                                            if ($fResult4->desiredExt=='jpg') {?>
                                              <div class="col-md-2 col-12 documnt">
                                                <img src="uploads/<?php echo $fResult4->name; ?>" alt="" style="width: 140px;
                                                height: 150px;
                                                border: 1px solid #7777;
                                                padding: 3px;
                                                margin: 0px 10px;
                                                ">
                                                 <p><?php echo $fResult4 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult4->id ?>)"></a>
                                              </div>
                                            <?php }else{ ?>
                                              <div class="col-md-2 col-12 documnt">
                                                <a href="uploads/<?php echo $fResult4->name ?>" download >
                                                  <img src="uploads/download.png" alt="" style="width: 140px;
                                                  height: 150px;
                                                  border: 1px solid #7777;
                                                  padding: 3px;
                                                  margin: 0px 10px;
                                                  ">
                                                </a>
                                                 <p><?php echo $fResult4 ->name ?></p>
                                                <a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult4->id ?>)"></a>
                                              </div>
                                            <?php } }?>
                                          </div> 
                                        </form> 
                                      </div>
                                    </div>
                                    <div id="profile_13" class="tab-pane fade"
                                    role="tabpanel">
                                    <div class="acedmics-certificate">
                                      <div class="row">
                                        <?php
                                        $fsql4 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and status=0");
                                        while($fResult4 = $obj->fetchNextObject($fsql4)){

                                          if ($fResult4->desiredExt=='pdf') {?>
                                            <div class="col-md-2 col-12 documnt">
                                              <img src="uploads/download.png" alt="" style="width: 140px; height: 150px;">
                                              <p><?php echo $fResult4 ->name ?></p>
                                              <a href="javascript:void(0);" class="documnet-undo" onclick="documentundo(this,<?php echo $fResult4->id ?>)"></a>
                                            </div>
                                          <?php }else{?>
                                            <div class="col-md-2 col-12 documnt">
                                              <img src="uploads/<?php echo $fResult4->name; ?>" alt="" style="width: 140px; height: 150px;">
                                              <p><?php echo $fResult4 ->name ?></p>
                                              <a href="javascript:void(0);" class="documnet-undo" onclick="documentundo(this,<?php echo $fResult4->id ?>)"></a>
                                            </div>
                                            <?php
                                          }

                                        }?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="profile_7" class="tab-pane fade" role="tabpanel">
                        <div class="table-wrap">
                          <div class="table-responsive">
                             <?php if ($result->am_id!=0 && ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3)) {?> 
                            <div class="student_filter application_filter">
                              <form method="post" action="" >
                                <input type="hidden" name="uid" id="uid" value="<?php echo $uresult->id ?>">
                                <input type="hidden" name="userRecovery" id="userRecovery" value="yes">
                                <input type="hidden" name="user_id" id="user_id" value="<?php print_r($_SESSION['sess_admin_id']); ?>">
                                <input type="hidden" name="sutdent_id" id="sutdent_id" value="<?php echo $result->id; ?>">
                                <div class="row">
                                  <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">Official Email</div>
                                        <input type="email"  class="form-control" id="offical_email" name="offical_email" placeholder="" value="<?php echo $uresult->offical_email ?>" required >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2" style="padding-right:5px; padding-left:5px">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">Password</div>
                                        <input type="text" class="form-control" id="password" name="password" placeholder="" value="<?php echo $uresult->password ?>" required >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">Recovery Email</div>
                                        <input type="email" class="form-control" name="recovery_email" id="recovery_email" placeholder="" value="<?php echo $uresult->recovery_email ?>" required >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">Recovery Number</div>
                                        <input type="text" class="form-control" name="recovery_number" id="recovery_number" placeholder="" value="<?php echo $uresult->recovery_number ?>" required maxlength="13" minlength="13" >
                                      </div>
                                    </div>
                                  </div>
                                    <?php if($uresult=='' && $_SESSION['level_id']==3){?>
                                    <div class="col-md-1" style="padding-right:5px; padding-left:5px">
                                      <button type="submit"  class="btn btn-sm mr-10">Submit</button>
                                    </div>
                                  <?php }elseif ($_SESSION['level_id']==2 || $_SESSION['level_id']==1) {?>
                                    <div class="col-md-1" style="padding-right:5px; padding-left:5px">
                                      <button type="submit"  class="btn btn-sm mr-10">Submit</button>
                                    </div>
                                  <?php }?>

                                </div>
                              </form>
                            </div>
                            <?php }; if ($uresult->id !='') {?>
                              <table id="appdatable_1" class="table table-hover display  pb-30" >
                                <thead>
                                  <tr>
                                    <th>Id</th>
                                    <th>Institution Name</th>
                                    <th>Location</th>
                                    <th>Course</th>
                                    <th>Stream</th>
                                    <th>Intake</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                  <?php if ($result->am_id!=0 && ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3)) {?>
                                  <?php
                                  if ($uresult->id !='' || $_SESSION['level_id']!=4) {?>
                                  <th>Edit</th>
                                  <?php }?>
                                  <?php } ?>
                                   
                                  </tr>
                                </thead>

                                <tbody>
                                  <?php
                                  $i=1;
                                  $sql=$obj->query("select * from $tbl_student_application where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."'",$debug=-1);
                                  while($line=$obj->fetchNextObject($sql)){?>
                                    <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo getField('name','tbl_univercity',$line->college_name)  ?></td>
                                      <td><?php echo  getField('state','tbl_state',$line->location)  ?></td>
                                      <td><?php echo getField('course_name','tbl_programmes',$line->course)  ?></td>
                                       <td><?php echo getField('stream','tbl_programmes',$line->stream_id)  ?></td>
                                      <td><?php echo $line->month ?></td>
                                      <td><?php echo $line->year ?></td>
                                      <td> <?php 
                                   echo $line->status
                                      ?>
                                    </td>
                                    <td>
                                       <?php  if ($_SESSION['level_id']!=4) {?>
                                      <a href="javascript:void(0);" onclick="getAppModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
                                    <?php } ?>
                                      <!-- <a href="student-aaplication-del.php?aid=<?php echo $line->id ?>&stu_id=<?php echo  $_REQUEST['id'] ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a>  -->
                                    </tr>
                                    <?php ++$i;} ?>
                                  </tbody>
                                </table>
                              <?php   }?>
                            </div>
                          </div>
                           <?php if ($result->am_id!=0 && ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3)) {?>
                          <?php
                          if ($_SESSION['level_id']!=4) {
                            if ($uresult!='') {?>
                            <button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowAppModal()" class="add-application">Add
                            Application</a></button>
                          <?php }; }?>
                        <?php } ?>

                        </div>

                        <div id="status_7" class="tab-pane fade " role="tabpanel">
                          <?php
                          if($result->am_id!=0){?>
                            <div class="table-wrap">
                              <div class="table-responsive">

                                <table id="statusdatable_1" class="table table-hover display fold-table  pb-30">
                                  <thead>
                                    <tr>
                                      <th>DATE</th>
                                      <th>TIME</th>
                                      <th>STAGE</th>
                                      <th>STATUS</th>
                                      <th>REMARKS</th>
                                      <th>ADDED BY</th>
                                      <?php if ($result->am_id!=0 && ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3)) {?>
                                  <?php
                                  if ($uresult->id !='' || $_SESSION['level_id']!=4) {?>
                                  <th>Edit</th>
                                  <?php }?>
                                  <?php } ?>
                                    </tr>
                                  </thead>

                          
                                  <tbody>
                                    <?php
                                    $i=1;
                                    $sql=$obj->query("select * from $tbl_student_status where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and parent_id=0",$debug=-1);
                                    while($line=$obj->fetchNextObject($sql)){?>
                                         <tr class="view opnetab<?php echo  $line->id ?>" >
                                        <td onclick="myFunction(<?php echo $line->id ?>)"><?php echo date('d-M-Y',strtotime($line->cdate)); ?></td>
                                        <td><?php echo date('h:i a',strtotime($line->cdate)); ?></td>
                                        <td><?php echo getField('stage',$tbl_stage,$line->stage_id); ?></td>
                                        <td> <?php echo $line->cstatus?>
                                      </td>
                                      <td><?php echo $line->remarks ?></td>
                                      <td><?php echo getField('name',$tbl_admin,$line->user_id) ?></td>
                                      <td>
                                          <?php  if ($_SESSION['level_id']!=4) {?>
                                        <a href="javascript:void(0);" onclick="getStatusModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> <?php } ?>
                                      </td></tr>
                                      <?php
                                      $sqll=$obj->query("select * from $tbl_student_status where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and parent_id='$line->id'",$debug=-1);
                                    while($linee=$obj->fetchNextObject($sqll)){?>
                                        <tr class="fold myDIV<?php echo  $line->id ?>">
                                        <td><?php echo date('d-M-Y',strtotime($linee->cdate)); ?></td>
                                        <td><?php echo date('h:i a',strtotime($linee->cdate)); ?></td>
                                        <td><?php echo getField('stage',$tbl_stage,$linee->stage_id); ?></td>
                                        <td> <?php echo $linee->cstatus?>
                                      </td>
                                      <td><?php echo $linee->remarks ?></td>
                                      <td><?php echo getField('name',$tbl_admin,$linee->user_id) ?></td>
                                      <td>
                                          <?php  if ($_SESSION['level_id']!=4) {?>
                                        <a href="javascript:void(0);" onclick="getStatusModalData(<?php echo $linee->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> <?php } ?>
                                      </td></tr>
                                    <?php } ?>
                      
                                      <?php ++$i;} ?>
                                     
                                    </tbody>

                                  </table>
                                </div>
                              </div>
                              <?php if ($_SESSION['level_id']!=4) { ?>
                                <button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowStatusModal()" class="add-application">Add Status</a></button>

                              <?php } }?>
                            </div>
                            <div id="notes_7" class="tab-pane fade" role="tabpanel">
                              <div class="panel panel-default card-view">
                                <div class="panel-wrapper collapse in">
                                  <div class="panel-body">
                                    <div class="panel-group accordion-struct" id="accordion_1"
                                    role="tablist" aria-multiselectable="true">

                                    <?php 
                                    $note=0;
                                    $noteSql = $obj->query("select * from $tbl_student_notes where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' order by id desc");
                                    while($noteResult = $obj->fetchNextObject($noteSql)){ $note++; ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading tabnewclass <?php if($note==1){?> collapse-in  <?php }?>" role="tab" id="heading_<?php echo $note; ?>">
                                          <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_<?php echo $note; ?>"  aria-expanded="false" class="<?php if($note==1){?>  <?php }else{ ?>   collapsed <?php } ?>  collapse-in ">
                                            <?php echo getField('name',$tbl_admin,$noteResult->user_id); ?>
                                            - 
                                            <?php echo $noteResult->subject; ?>        

                                          </a>
                                          <div class="comment_icon">

                                            <a href="javascript:void(0);" class="comment-box" onclick="showCommentBox(<?php echo $noteResult->id; ?>)"><span class="comment-box"><?php echo getField('stage',$tbl_stage,$noteResult->stage_id); ?> Stage</span></a>
                                            </div> 
                                          </div>
                                          <div id="collapse_<?php echo $note; ?>" class="panel-collapse collapse <?php if($note==1){?> in <?php }?>" role="tabpanel" aria-expanded="false"
                                            style="height: auto;">
                                            <div class="panel-body pa-15">
                                              <p> <?php echo $noteResult->remarks; ?></p>

                                              <?php
                                              $repSql = $obj->query("select * from $tbl_student_notes_comment where note_id='".$noteResult->id."'");
                                              while($repResult = $obj->fetchNextObject($repSql)){?>
                                                <div class="comments ml-30 ">
                                                  <div class="comment-header">
                                                    <p class="comment-author">
                                                      <i class="fa fa-user user-icon"></i><span class="comment-author-name" itemprop="name"><a href="" class="comment-author-link"><?php echo  getField('name','tbl_admin',$repResult->sender_id); ?></a></span></p>

                                                      <p class="comment-meta"><?php echo $repResult->cdate; ?></p>
                                                    </div>
                                                    <div class="comment-content" ><p><?php echo $repResult->comments; ?></p>
                                                    </div>
                                                  </div>
                                                  <div class="replies my-3"></div>
                                                <?php }?>

                                              </div>
                                            </div>
                                          </div>
                                        <?php }?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              
                                  <button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowNotesModal()" class="add-application">Add Notes</a></button>
                          
                              </div>

                              <div id="credentials_7" class="tab-pane fade" role="tabpanel">
                                <div class="table-wrap">
                                  <div class="table-responsive">

                                    <div class="student_filter application_filter">
                                      <form method="post" action="">

                                      <input type="hidden" name="userFilingCredentoals" id="userFilingCredentoals" value="yes">
                                      <input type="hidden" name="Cid" id="Cid" value="<?php echo $filingresult->id ?>">

                                      <input type="hidden" name="user_id" id="user_id" value="<?php print_r($_SESSION['sess_admin_id']); ?>">
                                      <input type="hidden" name="sutdent_id" id="sutdent_id" value="<?php echo $result->id; ?>">
                                        <div class="row">
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">CGI User ID</div>
                                                <input type="text" class="form-control" id="cgi_user_id" name="cgi_user_id" placeholder="" value="<?php echo $filingresult->cgi_user_id ?>"   <?php if($_SESSION['level_id']==4 || $_SESSION['level_id']==3 && $filingresult->cgi_user_id!=''){ ?> readonly <?php }?>>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">CGI Password</div>
                                                <input type="text" class="form-control" id="cgi_password" name="cgi_password" placeholder="" value="<?php echo $filingresult->cgi_password ?>" <?php if( $_SESSION['level_id']==4 || $_SESSION['level_id']==3 && $filingresult->cgi_password!=''){ ?> readonly <?php }?>>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">CGI Email ID</div>
                                                <input type="email" class="form-control" name="cgi_email" id="cgi_email" placeholder="" value="<?php echo $filingresult->cgi_email ?>" <?php if($_SESSION['level_id']==4 ||  $_SESSION['level_id']==3 && $filingresult->cgi_email!=''){ ?> readonly <?php }?>>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">Email Password</div>
                                                <input type="text" class="form-control" name="email_password" id="email_password" placeholder="" <?php if($_SESSION['level_id']==4 ||  $_SESSION['level_id']==3 && $filingresult->email_password!=''){ ?> readonly <?php }?>  value="<?php echo $filingresult->email_password ?>">
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">Recovery email id</div>
                                                <input type="email" class="form-control" name="cgi_recovery_email" id="cgi_recovery_email" placeholder="" value="<?php echo $filingresult->recovery_email ?>" <?php if($_SESSION['level_id']==4 || $_SESSION['level_id']==3 && $filingresult->recovery_email!=''){ ?> readonly <?php }?> >
                                              </div>
                                            </div>
                                          </div>
                                        
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">Recovery Phone no.</div>
                                                <input type="number" class="form-control" name="cgi_recovery_number" id="cgi_recovery_number" placeholder=""   maxlength="13" minlength="13" value="<?php echo $filingresult->recovery_number ?>" <?php if($_SESSION['level_id']==4 || $_SESSION['level_id']==3 && $filingresult->recovery_number!=''){ ?> readonly <?php }?>>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">Security Answer</div>
                                                <input type="text" class="form-control" name="security_answer" id="security_answer" placeholder="" value="<?php echo $filingresult->security_answer ?>" <?php if($_SESSION['level_id']==4 || $_SESSION['level_id']==3 && $filingresult->security_answer!=''){ ?> readonly <?php }?> >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-3" style="padding-right:5px; padding-left:5px">
                                            <div class="form-group">
                                              <div class="input-group">
                                                <div class="input-group-addon">DS APPLICATION ID</div>
                                                <input type="text" class="form-control" name="ds_application_id" id="ds_application_id" placeholder="" value="<?php echo $filingresult->ds_application_id ?>" <?php if($_SESSION['level_id']==4 ){ ?> readonly <?php }?> >
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-md-1" style="padding-right:5px; padding-left:5px">

                                          <?php if ($result->am_id!=0 && ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3)) {?>
                                          <button type="submit" class="btn btn-sm mr-10">Submit</button>
                                          <?php }; ?>
                                        
                                         
                                          </div>

                                        </div>
                                      </form>
                                    </div>

                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <footer class="footer container-fluid pl-30 pr-30">
                  <div class="row">
                    <div class="col-sm-12">
                      <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                    </div>
                  </div>
                </footer>

                </div>


               

               
                <div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                        <h5 class="modal-title" id="statusModalLabeladd">Add Status</h5>
                      </div>
                      <form  method="post" id="addStatus" name="addStatus">
                        <input type="hidden" name="statusid" id="statusid">
                        <input type="hidden" name="statusstudent_id" id="status_student_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
                        <div class="modal-body">                
                          <div class="form-group">
                            <select class="form-control" name="status_stage" id="status_stage" required="">
                              <option value="">Select Stage</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_stage where status=1 and country_id='".$result->country_id."'");
                              while($sResult = $obj->fetchNextObject($ssql)){?>
                                <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->stage; ?></option>
                              <?php  }?>
                            </select>
                            <span id="err_status_stage" style="color:red;"></span>
                             <span id="showSearchResult" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                            <select class="form-control" name="status_status" id="status_status" required="">
                              <option value="">Select Status</option>

                            </select>
                            <span id="err_status_status" style="color:red;"></span>
                          </div>

                          <div class="form-group">
                            <textarea name="status_remarks" id="status_remarks" class="form-control"></textarea>
                            <span id="err_status_remarks" style="color:red;"></span>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" id="btnSubmitStatus" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                     <div class="modal fade" id="add_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                        <h5 class="modal-title" id="NotesModalLabeladd">Add Notes</h5>
                      </div>
                      <div class="modal-body">
                        <form method="post"  id="addnotes" name="addnotes">
                          <input type="hidden" name="notesid" id="notesid" value="">
                          <input type="hidden" name="notes_student_id" id="notes_student_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
                          <div class="form-group">
                            <select class="form-control notes_stage_id" name="notes_stage_id" id="notes_stage_id" required="">
                              <option value="">Stage</option>
                              <?php
                              $sql=$obj->query("select * from $tbl_stage where 1=1 and country_id='$result->country_id'",-1);
                              while($resultt=$obj->fetchNextObject($sql)){?>
                                <option value="<?php echo $resultt->id ?>"><?php echo $resultt->stage ?></option>
                              <?php } ?>
                            </select>
                            <span id="err_notes_stage_id" style="color:red;"></span>
                            <span id="showSearchResulttt" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control" name="notes_subject" id="notes_subject" placeholder="Subject">
                            <span id="err_notes_subject" style="color:red;"></span>

                          </div>
                          <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Remarks" id="notes_remarks" name="notes_remarks"></textarea>
                            <span id="err_notes_remarks" style="color:red;"></span>
                          </div>
                            <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" id="btnSubmitNotes" class="btn btn-primary">Submit</button>
                        </div>
                      
                        </form>
                        </div>

                        

                    </div>
                  </div>
                </div>
               

                <div class="modal fade" id="add_application" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                        <h5 class="modal-title" id="applicationModalLabeladd">Add Application</h5>
                      </div>
                       <form  method="post" id="addApplication" name="addApplication">
                        <input type="hidden" name="appid" id="appid">
                        <input type="hidden" name="student_id" id="appstudent_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
                        <div class="modal-body">                
                          <div class="form-group">
                           <select class="form-control" name="state_id" id="state_id_application" required="">
                              <option value="">Select State</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_state where status=1 and country_id='".$result->country_id."'");
                              while($sResult = $obj->fetchNextObject($ssql)){?>
                                <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->state; ?></option>
                              <?php  }?>
                            </select>
                              <span id="err_applocation" style="color:red;"></span>
                          </div>
                            <div class="form-group">
                            <select class="form-control" name="univercity_id" id="univercity_id_application"  required="">
                              <option value="">Select University</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_univercity where status=1 and country_id='".$result->country_id."'");
                              while($sResult = $obj->fetchNextObject($ssql)){?>
                                <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->name; ?></option>
                              <?php  }?>
                            </select>
                            <span id="err_appcollegename" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                               <select class="form-control" name="status_stage" id="course_id_application" required="">
                              <option value="">Select Course</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_programmes where status=1 and country='".$result->country_id."' GROUP BY course_name",-1);//die();
                              while($sResult = $obj->fetchNextObject($ssql)){?>
                                <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->course_name; ?></option>
                              <?php  }?>
                            </select>
                           <span id="err_appcourse" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                                <select class="form-control" name="status_stage" id="stage_id_stream" required="">
                              <option value="">Select Stream</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_programmes where status=1 and country='".$result->country_id."' GROUP BY stream",-1);//die();
                              while($sResult = $obj->fetchNextObject($ssql)){?>
                                <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->stream; ?></option>
                              <?php  }?>
                            </select>
                            <span id="err_appystream" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                            <select class="form-control" name="month" id="appmonth" required="">
                              <option value="">Select Intake</option>
                              <option value="January">January</option>
                              <option value="February">February</option>
                              <option value="March">March</option>
                              <option value="April">April</option>
                              <option value="May">May</option>
                              <option value="June">June</option>
                              <option value="July">July</option>
                              <option value="August">August</option>
                              <option value="September">September</option>
                              <option value="October">October</option>
                              <option value="November">November</option>
                              <option value="December">December</option>
                            </select>
                            <span id="err_appmonth" style="color:red;"></span>
                          </div>
                          <div class="form-group">
                            <select class="form-control" name="year" id="appyear" required="">
                              <option value="">Select Year</option>
                              <?php
                              $date = date('Y');
                              $newDate = date('Y', strtotime($date. ' + 5 years'));
                              for($i=2023; $i < $newDate; $i++){?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                              <?php }?>
                            </select>
                            <span id="err_appyear" style="color:red;"></span>
                          </div>

                          <div class="form-group app_status">
                            <select class="form-control" name="app_status" id="app_status" required="">
                                 <option value="" selected="">Status</option>
                              <?php 
                              $ssql = $obj->query("select * from $tbl_country_status where status=1 and country_id='".$result->country_id."'",-1);//die();

                              while($sResult = $obj->fetchNextObject($ssql)){
                                $intakeArr = explode(",",$sResult->cstatus);
                               foreach($intakeArr as $vint){
                                ?>
                                <option value="<?php echo $vint; ?>"><?php echo $vint; ?></option>
                              <?php  }  }?>
                            </select>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" id="btnSubmitApplication" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    
                    </div>
                  </div>
                </div>
                 <div class="modal" id="student_comment" tabindex="-1" role="dialog">
                  <form method="post"  id="addcomment" name="addcomment">
                    <input type="text" name="note_id" id="note_id" value="">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Comment</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group">
                            <textarea name="comments" id="comments" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea> 
                            <span id="err_comment" style="color: red;"></span>  
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="btnSubmitComment">Submit</button>
                        </div>
                      </div>
                    </div>
                    </form>
                  </div>


                    </div>
                  </div>
                </div>
              
              </div>

            </div>
          

          <?php include("footer.php"); ?>
        </body>
    
       <script type="text/javascript">



          // $(document).on('.collapse.in', '.panel-collapse', function (e) {
          //   $(this).siblings('.panel-heading').removeClass('collapse-in');
          // });
          $(document).on('hide.bs.collapse', '.panel-collapse', function (e) {
            $(this).siblings('.panel-heading').removeClass('collapse-in');
          });
          // $(".panel-heading").on("click", function () {
          //   $(".panel-heading").removeClass("collapse-in");
          // });

          $('.panel-heading').click(function(e) {
  e.preventDefault();
  var currentIsActive = $(this).hasClass('collapse-in');
  $(this).parent('.panel-heading').find('> *').removeClass('collapsed');

});
      
          function documentdel(pthis,id){
            $(pthis).parent('.documnt').remove();
            $.ajax({
              type: "GET", 
              url: 'ajax/submitData.php',
              data: {id:id,action:'getDocumentDel'},
              beforeSend: function () {
              },
              success: function (data) {
                location.reload();
//
}
});
          }


          function documentundo(pthis,id){
            $(pthis).parent('.documnt').remove();
            $.ajax({
              type: "GET", 
              url: 'ajax/submitData.php',
              data: {id:id,action:'getDocumentUndo'},
              beforeSend: function () {
              },
              success: function (data) {
                location.reload();
              }
            });
          }


       
         function ShowStatusModal(){
            $("#err_status_stage").hide();
            $("#err_status_status").hide();
            $("#err_status_remarks").hide();
            $("#statusModalLabeladd").html("Add Status");
            $("#statusid").val("");
            $("#status_stage").val("");
            $("#status_status").val("");
            $("#status_remarks").val("");
            $("#add_status").modal('show');
          }

          function getStatusModalData(id) 
          {   

            $("#applicationModalLabeladd").html("Update Status");
            $.ajax({
              type: "GET", 
              url: 'ajax/getModalData.php',
              data: {id:id,type:'getStatus'},
              beforeSend: function () {
              },
              success: function (response) {
                response = response.split('##');
                console.log(response[2]);
                $("#statusid").val(response[0]);
                $("#status_stage").val(response[1]);
                $("#status_status").html(response[2]);
                $("#status_remarks").val(response[3]);
           
                $("#add_status").modal('show');
              }
            });
          }

          $("#btnSubmitStatus").on("click", function() {    
            id = $("#statusid").val();
            student_id = $("#status_student_id").val();
            status_stage = $("#status_stage").val();
            if(status_stage==''){
              $("#err_status_stage").show().html("This field is required.");
              return;
            }
            status_status = $("#status_status").val();
            if(status_status==''){
              $("#err_status_status").show().html("This field is required.");
              return;
            }
            status_remarks = $("#status_remarks").val();
            if(status_remarks==''){
              $("#err_status_remarks").show().html("This field is required.");
              return;
            }

            if(id==''){
              action='addStatus';
            }else{
              action='updateStatus';      
            }
            $.ajax({
              type: "POST", 
              url: 'ajax/submitData.php', 
              data: {'id':id,'student_id':student_id,'status_stage':status_stage,'status_status':status_status,'status_remarks':status_remarks,'action':action}, 
              success: function (response) {
                if(response==1){
                  $("#add_status").modal('hide');
                  location.reload(true);
                }
              },
            });
          });

$('#recovery_number').on('input', function() {
    const phoneNumber = $(this).val();

    // Remove all non-numeric characters from the input value
    const numericOnly = phoneNumber.replace(/\D/g, '');

    // Ensure the number is limited to 10 digits
    const limitedNumber = numericOnly.slice(0, 14);

    // Add "+91" as a prefix if the number doesn't already start with "+91"
    const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;

    $(this).val(formattedNumber);
});
 $("#status_stage").change(function() {
            var id = this.value;
            $.ajax({
              type: "GET", 
              url: 'ajax/getModalData.php',
              data: {id:id,type:'getStageStatus'},
              beforeSend: function () {
              },
              success: function (response) {
                console.log(response);
                $("#status_status").html(response);
              }
            });
          });


             function ShowNotesModal(){
            $("#err_notes_stage_id").hide();
            $("#err_notes_subject").hide();
            $("#err_notes_remarks").hide();
            $("#NotesModalLabeladd").html("Add Notes");
            $("#notesid").val("");
            $("#notes_stage_id").val("");
            $("#notes_subject").val("");
            $("#notes_remarks").val("");
            $("#add_notes").modal('show');
          }

          function getNotesModalData(id) 
          {   

            $("#NotesModalLabeladd").html("Update Notes");
            $.ajax({
              type: "GET", 
              url: 'ajax/getModalData.php',
              data: {id:id,type:'getNotes'},
              beforeSend: function () {
              },
              success: function (response) {
                response = response.split('##');
                $("#notesid").val(response[0]);
                $("#notes_stage_id").val(response[1]);
                $("#notes_subject").val(response[2]);
                $("#notes_remarks").val(response[3]);
                $("#add_notes").modal('show');
              }
            });
          }

          $('#state_id_application').change(function() {
            var id = $('#state_id_application').val();
          

            var action='get_state_id'
            $.ajax({
              type:"post",
              url:"ajax/getModalData.php",
              data :{
                'key' : id,'action': action              
              },          
              success:function(res){
               
                  $('#univercity_id_application').html(res); 

              }
            });
          });
          $('#notes_stage_id').change(function() {
            var value = $('#notes_stage_id').val();
            var stu_id = $('#notes_student_id').val();

            var action='get_notes_stage_id'
            $.ajax({
              type:"post",
              url:"ajax/getModalData.php",
              data :{
                'key' : value,'action': action,'stu_id':stu_id              
              },          
              success:function(res){
                if (res==0) {
                   $('#showSearchResulttt').hide();
                  document.getElementById("btnSubmitNotes").disabled = false;

                }else{
                  $('#showSearchResulttt').show().html('This Stage already add'); 
                       document.getElementById("btnSubmitNotes").disabled = true;
                }

              }
            });
          });

          $("#notes_stage_id").change(function(){
            $("#showSearchResulttt").hide();
             $("#err_status_stage").hide();
          })

          $('#status_stage').change(function() {
            var value = $('#status_stage').val();
            var stu_id = $('#status_student_id').val();

            var action='get_status_stage'
            $.ajax({
              type:"post",
              url:"ajax/getModalData.php",
              data :{
                'key' : value,'action': action,'stu_id':stu_id              
              },          
              success:function(res){
                if (res==0) {
                  $('#showSearchResult').hide();
                   document.getElementById("btnSubmitStatus").disabled = false;
                }else{
                  $("#err_status_stage").hide();
                  $('#showSearchResult').show().html('This Stage already add'); 
                  document.getElementById("btnSubmitStatus").disabled = true;
                }

              }
            });
          });

          $("#notes_stage_id").change(function(){
            $("#showSearchResult").hide();
              $("#err_notes_stage_id").hide();
          })



          $("#btnSubmitNotes").on("click", function() {    
            id = $("#notesid").val();
            student_id = $("#notes_student_id").val();
            notes_stage = $("#notes_stage_id").val();
            if(notes_stage==''){
              $("#err_notes_stage_id").show().html("This field is required.");
              return;
            }
            notes_subject = $("#notes_subject").val();
            if(notes_subject==''){
              $("#err_notes_subject").show().html("This field is required.");
              return;
            }
            notes_remarks = $("#notes_remarks").val();
            if(notes_remarks==''){
              $("#err_notes_remarks").show().html("This field is required.");
              return;
            }
            if(id==''){
              action='addNotes';
            }else{
              action='updateNotes';      
            }
            $.ajax({
              type: "POST", 
              url: 'ajax/submitData.php', 
              data: {'id':id,'student_id':student_id,'notes_stage':notes_stage,'notes_subject':notes_subject,'notes_remarks':notes_remarks,'action':action}, 
              success: function (response) {
                if(response==1){
                  $("#add_notes").modal('hide');
                  location.reload(true);
                }
              },
            });
          });
  
  function showCommentBox(id){
            $("#err_comment").hide();
            $("#note_id").val(id);
            $("#student_comment").modal('show');
          }


          $("#btnSubmitComment").on("click", function() {    
            comments = $("#comments").val();
            if(comments==''){
              $("#err_comment").show().html("This field is required.");
              return; 
            }
            note_id = $("#note_id").val();
            $.ajax({
              type: "POST", 
              url: 'ajax/submitData.php', 
              data: {'note_id':note_id,'comments':comments,'action':'addcomment'}, 
              success: function (response) {
                if(response==1){
                  $("#student_comment").modal('hide');
                  location.reload(true);
                }
              },
            });
          });


          function ShowAppModal(){
            $("#err_appcollegename").hide();
            $("#err_applocation").hide();
            $("#err_appcourse").hide();
            $("#err_appmonth").hide();
            $("#err_appystream").hide();
            $("#err_appyear").hide();
            $("#applicationModalLabeladd").html("Add Application");
            $("#appid").val("");
            $("#univercity_id_application").val("");
            $("#state_id_application").val("");
            $("#course_id_application").val("");
            $(".app_status").hide();
            $("#app_status").val("");    
             $("#stage_id_stream").val("");   
            $("#appmonth").val("");
            $("#appyear").val("");
            $("#add_application").modal('show');
          }

          function getAppModalData(id) 
          {   

            $("#applicationModalLabeladd").html("Update Application");
            $.ajax({
              type: "GET", 
              url: 'ajax/getModalData.php',
              data: {id:id,type:'getApplication'},
              beforeSend: function () {
              },
              success: function (response) {
                response = response.split('##');
                $("#appid").val(response[0]);
                $("#univercity_id_application").val(response[1]);
                $("#state_id_application").val(response[2]);
                $("#course_id_application").val(response[3]);
                $(".app_status").show();
                $("#app_status").val(response[6]);
                $("#stage_id_stream").val(response[7]);
                $("#appmonth").val(response[4]);
                $("#appyear").val(response[5]);
                $("#add_application").modal('show');
              }
            });
          }

          $("#btnSubmitApplication").on("click", function() {    
            id = $("#appid").val();
            student_id = $("#appstudent_id").val();
            state_id_application = $("#state_id_application").val();
            if(state_id_application==''){
              $("#err_applocation").show().html("This field is required.");
              return;
            }
            univercity_id_application = $("#univercity_id_application").val();
            if(univercity_id_application==''){
              $("#err_appcollegename").show().html("This field is required.");
              return;
            }
            course = $("#course_id_application").val();
            if(course==''){
              $("#err_appcourse").show().html("This field is required.");
              return;
            }

             stage_id_stream = $("#stage_id_stream").val();
            if(course==''){
              $("#err_appystream").show().html("This field is required.");
              return;
            }
            app_status = $("#app_status").val();
            month = $("#appmonth").val();
            if(month==''){
              $("#err_appmonth").show().html("This field is required.");
              return;
            }
            year = $("#appyear").val();
            if(year==''){
              $("#err_appyear").show().html("This field is required.");
              return;
            }
            if(id==''){
              action='addApplication';
            }else{
              action='updateApplication';      
            }
            $.ajax({
              type: "POST", 
              url: 'ajax/submitData.php', 
              data: {'id':id,'student_id':student_id,'state_id_application':state_id_application,'univercity_id_application':univercity_id_application,'course':course,'stage_id_stream':stage_id_stream,'app_status':app_status,'month':month,'year':year,'action':action}, 
              success: function (response) {
                if(response==1){
                  $("#add_application").modal('hide');
                  location.reload(true);
                }
              },
            });
          });
          
          $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
              dtype = $("#dtype2").val();
              stu_id = $("#stu_id2").val();
              $(this).removeClass('drag_over');
              if (input.files) {
                var filesAmount = input.files.length;
                var formData = new FormData();
                for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.readAsDataURL(input.files[i]);
                  formData.append('file[]', input.files[i]);
                  formData.append('dtype', dtype);
                  formData.append('stu_id', stu_id);
                }
                uploadFormData(formData,2);
              }
            };
            $('#gallery-photo-add').on('change', function() {
              imagesPreview(this, 'div.gallery');
            });
            function uploadFormData(form_data,val) {
              $.ajax({
                url: "file_upload.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  $('#uploaded_file'+val).append(data);
                }
              });
            }
          });
          $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
              dtype = $("#dtype1").val();
              stu_id = $("#stu_id1").val();
              $(this).removeClass('drag_over');
              if (input.files) {
                var filesAmount = input.files.length;
                var formData = new FormData();
                for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.readAsDataURL(input.files[i]);
                  formData.append('file[]', input.files[i]);
                  formData.append('dtype', dtype);
                  formData.append('stu_id', stu_id);
                }
                uploadFormData(formData,1);
              }
            };
            $('#gallery-photo-add1').on('change', function() {
              imagesPreview(this, 'div.gallery');
            });
            function uploadFormData(form_data,val) {
              $.ajax({
                url: "file_upload.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  $('#uploaded_file'+val).append(data);
                }
              });
            }
          });
          $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
              dtype = $("#dtype3").val();
              stu_id = $("#stu_id3").val();
              $(this).removeClass('drag_over');
              if (input.files) {
                var filesAmount = input.files.length;
                var formData = new FormData();
                for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.readAsDataURL(input.files[i]);
                  formData.append('file[]', input.files[i]);
                  formData.append('dtype', dtype);
                  formData.append('stu_id', stu_id);
                }
                uploadFormData(formData,3);
              }
            };
            $('#gallery-photo-add3').on('change', function() {
              imagesPreview(this, 'div.gallery');
            });
            function uploadFormData(form_data,val) {
              $.ajax({
                url: "file_upload.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  $('#uploaded_file'+val).append(data);
                }
              });
            }
          });
          $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
              dtype = $("#dtype4").val();
              stu_id = $("#stu_id4").val();
              $(this).removeClass('drag_over');
              if (input.files) {
                var filesAmount = input.files.length;
                var formData = new FormData();
                for (i = 0; i < filesAmount; i++) {
                  var reader = new FileReader();
                  reader.readAsDataURL(input.files[i]);
                  formData.append('file[]', input.files[i]);
                  formData.append('dtype', dtype);
                  formData.append('stu_id', stu_id);
                }
                uploadFormData(formData,4);
              }
            };
            $('#gallery-photo-add4').on('change', function() {
              imagesPreview(this, 'div.gallery');
            });
            function uploadFormData(form_data,val) {
              $.ajax({
                url: "file_upload.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                  $('#uploaded_file'+val).append(data);
                }
              });
            }
          });


      $(document).ready(function(){

var maxField = 10; //Input fields increment limitation
var addButton = $('.add_field_button'); //Add button selector

var wrapper = $('#add'); //Input field wrapper

var m = <?php echo $ucr-1; ?>; //Initial field counter is 1
var y = <?php echo $ucr; ?>

//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(m < maxField){ 
m++; //Increment field counter
y++; //Increment field counter
$(wrapper).append('<div class="course_add1 "><div class="course_form add_mrgin"><div class="form-group"  ><select class="form-control" name="result['+m+'][state_id]" id="state_id"><option value="">--Select Your State--</option><?php $sql=$obj->query("select * from $tbl_state where status=1 and country_id='".$result->country_id."'",$debug=-1);while($line = $obj->fetchNextObject($pSql)){?><option value="<?php echo $line->id ?>"><?php echo $line->state ?></option><?php } ?></select></div><div class="form-group"><select class="form-control" name="result['+m+'][univercity_id]" id="univercity_id"><option value="">Select Your University</option><?php $sql=$obj->query("select * from $tbl_univercity where status=1",$debug=-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->id ?>"><?php echo $line->name ?></option> <?php } ?></select></div><select class="form-control" style="width: auto;" name="result['+m+'][course_id]" id="course_id"><option value="">Select your Course</option><?php $sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY course_name",$debug=-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->id ?>"><?php echo $line->course_name    ?></option><?php } ?></select><div class="form-group"><select class="form-control" id="month" name="result['+m+'][month]"><option value="0">intake </option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November </option><option value="12">December</option></select></div><div class="form-group"> <select class="form-control" id="year" name="result['+m+'][year]"><?php $firstYear = (int)date('Y');$lastYear = $firstYear + 10;for($i=$firstYear;$i<=$lastYear;$i++){echo '<option value='.$i.'>'.$i.'</option>';}?></select></div><a href="#" class="remove_field delete_btn">X</a></div></div>');
}
});

//Once remove button is clicked
$(wrapper).on('click', '.remove_field', function(e){
  e.preventDefault();
$(this).parent('div').remove(); //Remove field html
x--; //Decrement field counter
});


var addButton = $('.add_field_button2'); //Add button selector

var wrapper2 = $('#add2'); //Input field wrapper

var a = <?php echo $dr-1; ?>; //Initial field counter is 1
var b = <?php echo $dr; ?>

//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(a < maxField){ 
a++; //Increment field counter
b++; //Increment field counter
$(wrapper2).append('<div class="course_add1"><div class="course_form add_mrgin"><div class="form-group"><select class="form-control" name="data['+a+'][diploma_id]" id="diploma_id"><option value="">Select Your Diploma</option><?php $sql=$obj->query("select * from $tbl_gap where status=1",$debug=-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->id ?>"><?php echo $line->diploma ?></option><?php } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data['+a+'][start_date]" id="dr_start_date'+a+'"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data['+a+'][end_date]" id="dr_end_date'+a+'"></div><div class="form-group"><input class="form-control form-control-lg" id="time_duration'+a+'" type="text" placeholder="0 Year,6 Months" name="data['+a+'][time_duration]"></div><div class="form-group"><select class="form-control" name="data['+a+'][status]"><option value="status">Status</option><option value="outside">Outside</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option></select></div><a href="#" class="remove_field2 delete_btn">X</a></div></div>');

  $("#dr_start_date"+a).datepicker({
        dateFormat: 'dd-mm-yy',
        numberOfMonths: 1,
        changeMonth:true,
        changeYear:true,
        onSelect: function (selected) {
            $("#dr_end_date"+a).datepicker("option", "minDate", selected);
        }
    });

    $("#dr_end_date"+a).datepicker({
        dateFormat: 'dd-mm-yy',
        numberOfMonths: 1,
        changeMonth:true,
        changeYear:true,
        onSelect: function (selected) {
        $("#dr_start_date"+a).datepicker("option", "maxDate", selected);
        var start = $("#dr_start_date"+a).val();
        var end = $("#dr_end_date"+a).val();
        var action='getdays';
        $.ajax({
        type:"post",
        url:"ajax/getModalData.php",
        data :{'start_date' : start,'end_date' : end,'action': action },          
        success:function(res){
        // $(".start_date").val(start);
        $("#time_duration"+a).val(res);

        }
        });
       
            
        }
    });
}
});

//Once remove button is clicked
$(wrapper2).on('click', '.remove_field2', function(e){
  e.preventDefault();
$(this).parent('div').remove(); //Remove field html
a--; //Decrement field counter
});


var addButton = $('.add_field_button3'); //Add button selector

var wrapper3 = $('#add3'); //Input field wrapper
var c = <?php echo $er-1; ?>; //Initial field counter is 1
var d = <?php echo $er; ?>
//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(c < maxField){ 
c++; //Increment field counter
d++; //Increment field counter
$(wrapper3).append('<div class="course_add1"><div class="course_form add_mrgin"><div class="form-group"><select class="form-control" name="data2['+c+'][experience_id]" id="experience_id"><option value="">Select Your Experience</option><?php $sql=$obj->query("select * from $tbl_gap where status=1",$debug=-1);while($line=$obj->fetchNextObject($sql)){?><option value="<?php echo $line->id ?>"><?php echo $line->experience ?></option><?php } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2['+c+'][start_date]" id="er_start_date'+c+'"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2['+c+'][end_date]" id="er_end_date'+c+'"></div><div class="form-group"><input class="form-control form-control-lg" id="er_time_duration'+c+'" type="text" placeholder="0 Year,6 Months" name="data2['+c+'][time_duration]"></div><div class="form-group"><select class="form-control" name="data2['+c+'][status]"><option value="outside">Outside</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option></select></div><a href="#" class="remove_field3 delete_btn">X</a></div></div>');
    $("#er_start_date"+c).datepicker({
        dateFormat: 'dd-mm-yy',
        numberOfMonths: 1,
        changeMonth:true,
        changeYear:true,
        onSelect: function (selected) {
            $("#er_end_date"+c).datepicker("option", "minDate", selected);         
        }
    });

    $("#er_end_date"+c).datepicker({
        dateFormat: 'dd-mm-yy',
        numberOfMonths: 1,
        changeMonth:true,
        changeYear:true,
        onSelect: function (selected) {
        
            $("#er_start_date"+c).datepicker("option", "maxDate", selected);
            var start = $("#er_start_date"+c).val();
            var end = $("#er_end_date"+c).val();


            var action='getdays';

            $.ajax({
            type:"post",
            url:"ajax/getModalData.php",
            data :{'start_date' : start,'end_date' : end,'action': action },          
            success:function(res){
            // $(".start_date").val(start);
            $("#er_time_duration"+c).val(res);

            }
            });
        
            
        }
    });

}
});

//Once remove button is clicked
$(wrapper3).on('click', '.remove_field3', function(e){
  e.preventDefault();
$(this).parent('div').remove(); //Remove field html
c--; //Decrement field counter
});



var addButton = $('.add_field_button4'); //Add button selector

var wrapper4 = $('#add4'); //Input field wrapper
var c = <?php echo $er-1; ?>; //Initial field counter is 1
var d = <?php echo $er; ?>
//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(c < maxField){ 
c++; //Increment field counter
d++; //Increment field counter
$(wrapper4).append('<div class="course_add1"><div class="course_form add_mrgin" style="display:flex; justify-content: start;"><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="15,00,000" name="data3['+c+'][amount]" id="amount"></div><div class="form-group" ><input class="form-control form-control-lg" type="text" placeholder="Notes"  name="data3['+c+'][notes]" id="notes"></div><div class="form-group"><select class="form-control" name="data3['+c+'][status]"><option value="status">Status</option><option value="outside">Outside</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option></select></div><a href="#" class="remove_field4 test123 delete_btn">X</a></div>');
}
});

//Once remove button is clicked
$(wrapper4).on('click', '.remove_field4', function(e){
  e.preventDefault();
$(this).parent('div').remove(); //Remove field html
c--; //Decrement field counter
});

})
</script>

<script>
  const targetDiv = document.getElementById("third");
  const btn = document.getElementById("toggle");
  btn.onclick = function () {
    if (targetDiv.style.display !== "none") {
      targetDiv.style.display = "none";
    } else {
      targetDiv.style.display = "block";
    }
  };
</script>
  <script>
  function myFunction(id) {
  var element = document.getElementById("fold");
  if ($(".myDIV"+id).hasClass('open')) {
  $(".opnetab"+id).removeClass("open");
  $(".myDIV"+id).removeClass("open");
  }else{
  $(".opnetab"+id).addClass("open");
  $(".myDIV"+id).addClass("open");
  }
  }
  </script>

</html>
