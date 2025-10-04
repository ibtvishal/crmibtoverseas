<?php
include('include/config.php');
include("include/functions.php");

$query = $obj->query("SELECT * FROM `tbl_branch` WHERE status='1'");
while($res=$obj->fetchNextObject($query)) {
$rand = rand('1000','9999');
 $obj->query("UPDATE `tbl_branch` SET `student_otp`='$rand' where id='".$res->id."'");
}
?>