<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");

$date = date('Y-m-d');
$get = $obj->query("SELECT b.id,b.visit_id FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 and b.class_end_date < '$date' and b.status='1' GROUP BY a.id");
while($res = $obj->fetchNextObject($get)){
    $obj->query("UPDATE $tbl_visit SET dulingo_date_status='0' where id='{$res->visit_id}'");
    $obj->query("UPDATE $tbl_duolingo_classe SET status='0' where id='{$res->id}'");
}
echo 'hi';