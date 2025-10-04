<?php
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
error_reporting(E_ALL);
validate_admin();

if(isset($_POST['submit'])){
    $ids = explode(',',$_POST['id']);
    foreach($ids as $id){
        $result = $obj->query("SELECT name FROM $tbl_student_document WHERE stu_id='$id'", -1);
        while ($row = $obj->fetchNextObject($result)) {
            $filePath = 'uploads/'.$row->name;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
       $obj->query("delete from $tbl_student where id='$id'",-1); 
       $obj->query("delete from $tbl_appointment where student_id='$id'",-1); 
       $obj->query("delete from $tbl_student_application where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_appointment_remark where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_course where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_diploma where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_document where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_english_proficiency where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_enrollment where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_enrollment_remark where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_experience where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_filing_noc where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_found where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_noc where stu_id='$id'",-1); 


       $obj->query("delete from $tbl_student_notes where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_passport_noc where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_relation where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_status where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_tourist_appointment where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_univercity_course where sutdent_id='$id'",-1); 
       $obj->query("delete from $tbl_student_updated_time where stu_id='$id'",-1); 
       $obj->query("delete from $tbl_student_work_experience where sutdent_id='$id'",-1);
    }

    echo 'deleted successfully.....';
}
?>

<form action="" method="post">
    <input type="text" name="id">
    <button type="submit" name="submit">Submit</button>
</form>