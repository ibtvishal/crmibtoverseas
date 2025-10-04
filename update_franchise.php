<?php 
session_start();
include('include/config.php');
include("include/functions.php");
$get = $obj->query("select * from $tbl_visit_fee where visa_sub_type is not null");
while($res = $obj->fetchNextObject($get)){
    $gets = $obj->query("select * from $tbl_enrolled_fee where visa_sub_type = '{$res->visa_sub_type}'");
    $ress = $obj->fetchNextObject($gets);
    $obj->query("update $tbl_visit_fee set franchise_percentage='{$ress->share_percentage}' ,av_franchise_percentage='{$ress->av_share_percentage}' where visa_sub_type = '{$res->visa_sub_type}' ");
}
?>