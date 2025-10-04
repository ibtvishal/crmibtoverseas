<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");

// $get = $obj->query("SELECT * FROM $tbl_appointment where interview_date is not null");
// while($res = $obj->fetchNextObject($get)){
//     $get1 = $obj->query("SELECT * FROM $tbl_student_status where cstatus='Start Classes' and stu_id='{$res->student_id}'");
//     if($obj->numRows($get1) > 0){
//         $res1 = $obj->fetchNextObject($get1);
//         if($res1->to_date < $res->interview_date){
//             $obj->query("UPDATE $tbl_student_status SET cstatus='Classes Completed' where id='{$res1->id}'");
//         }
//     }
// }
$date = date('Y-m-d');
$get = $obj->query("SELECT b.id,b.stu_id FROM $tbl_student AS a INNER JOIN $tbl_student_interview_preparation AS b on b.stu_id = a.id where 1=1 and b.class_end_date < '$date' and b.status='1' GROUP BY a.id");
while($res = $obj->fetchNextObject($get)){
    $get1 = $obj->fetchNextObject($obj->query("SELECT b.id FROM $tbl_student_status AS b where 1=1 and b.stu_id = '{$res->stu_id}' and b.cstatus='Start Classes'"));
    $obj->query("UPDATE $tbl_student_status SET cstatus='Classes Completed' where id='{$get1->id}'");
    $obj->query("UPDATE $tbl_student SET interview_status='0' where id='{$res->stu_id}'");
    $obj->query("UPDATE $tbl_student_interview_preparation SET status='0' where id='{$res->id}'");
}
echo 'hi';