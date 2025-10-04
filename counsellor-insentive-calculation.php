<?php 
session_start();
include('include/config.php');
include("include/functions.php");
// echo "<pre>";
$get = $obj->query("SELECT * FROM $tbl_admin where level_id=4 and status=1",-1); //die;
while($res = $obj->fetchNextObject($get)){
    $gets = $obj->query("select YEAR(a.enrollment_counselor_date) AS year,MONTH(a.enrollment_counselor_date) AS month,count(DISTINCT a.id) as count,a.councellor_id from $tbl_visit  as a inner join $tbl_visa_sub_type as d on a.visa_sub_type=d.id join $tbl_student as b on  a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no = b.alternate_contact where 1=1 and FIND_IN_SET('{$res->id}', a.councellor_id) > 0 and b.insentive_status=0 and  YEAR(a.enrollment_counselor_date) is not null and d.enrollment_count=1 and MONTH(a.enrollment_counselor_date) is not null group by  YEAR(a.enrollment_counselor_date), MONTH(a.enrollment_counselor_date)",$debug=-1); //die;
    while($ress = $obj->fetchNextObject($gets)){
        if($ress->month != ''){
        // print_r($ress);
        // echo "******************************************";
        $branch_id = getField('branch_id',$tbl_admin,$res->id);
        $get_i = $obj->query("SELECT * FROM $tbl_branch_incentive where branch_id='$branch_id' and type='Counsellor' and '{$ress->month}' between month_from and month_to and '{$ress->count}' between enrollment_from and enrollment_to",$debug=-1); //die;
        $res_i = $obj->fetchNextObject($get_i);
        if($obj->numRows($get_i) > 0){ 
            $get_b = $obj->query("SELECT * FROM $tbl_branch_incentive where branch_id='$branch_id' and type='Counsellor' and '{$ress->month}' between month_from and month_to and eligible_for_bonus <= '$ress->count'");
            if($obj->numRows($get_b) > 0){
                $res_b = $obj->fetchNextObject($get_b);
                $bonus = $res_b->bonus;
            }else{
                $bonus = 0;
            }
            // print_r($res_b);
            $amount = $ress->count * $res_i->amount + $bonus;
            $obj->query("INSERT $insentive_calculated SET `user_id`='{$ress->councellor_id}',`amount`='$amount',`month`='{$ress->month}',`year`='{$ress->year}',`type`='Counsellor'",-1); //die;
            $obj->query("UPDATE $tbl_student SET `insentive_status`='1' where c_id='{$ress->councellor_id}' and month(cdate)= '{$ress->month}' and year(cdate)= '{$ress->year}' ",$debug=-1); //die;
        }
        
        }
    }
    // echo '///////////////////////////////////////////////////////////////////////////<br><br>';
}


echo "Record Updated Successfully";
?>