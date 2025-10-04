<?php 
session_start();
include('include/config.php');
include("include/functions.php");
$date = date("Y-m-d");
$get = $obj->query("SELECT * FROM $tbl_appointment where biometric_date < '$date' and final_biometric_status is null");
while($res = $obj->fetchNextObject($get)){
    $obj->query("update $tbl_appointment set final_biometric_status='Appeared' where id='{$res->id}'");
}
$get = $obj->query("SELECT * FROM $tbl_appointment where interview_date < '$date' and final_interview_status is null");
while($res = $obj->fetchNextObject($get)){
  $obj->query("update $tbl_appointment set final_interview_status='Appeared' where id='{$res->id}'");
}

$obj->query("insert $tbl_btn_click set user_id='{$_SESSION['sess_admin_id']}'");
header('location:welcome.php');
?>