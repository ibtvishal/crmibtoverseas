<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");
$get = $obj->query("SELECT * FROM $tbl_student_status where cstatus='Visa Refused'");
while($res = $obj->fetchNextObject($get)){
    $obj->query("UPDATE $tbl_student set work_status=0 where id='{$res->stu_id}'");
}
echo 'hi';