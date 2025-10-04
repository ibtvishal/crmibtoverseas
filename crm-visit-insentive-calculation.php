<?php 
session_start();
include('include/config.php');
include("include/functions.php");
// echo "<pre>";
$get = $obj->query("SELECT * FROM $tbl_admin where level_id=9 and status=1");
while($res = $obj->fetchNextObject($get)){
    $gets = $obj->query("select YEAR(c.cdate) AS year,MONTH(c.cdate) AS month,count(DISTINCT a.id) as count,a.crm_executive_id from $tbl_lead as a join $tbl_visit as c on (a.applicant_contact_no=c.applicant_contact_no or a.applicant_alternate_no=c.applicant_contact_no or a.applicant_alternate_no=c.applicant_alternate_no or a.applicant_contact_no = c.applicant_alternate_no) where 1=1 and c.enquiry_type!='Re-apply' and FIND_IN_SET('".$res->id."', a.crm_executive_id) > 0 and a.crm_visit_insentive_status=0 group by  YEAR(c.cdate), MONTH(c.cdate)",$debug=-1);
    while($ress = $obj->fetchNextObject($gets)){
        if($ress->month != ''){
        // print_r($ress);
        // echo "******************************************";
        // $branch_id = getField('branch_id',$tbl_admin,$res->id);
        $get_i = $obj->query("SELECT * FROM $tbl_branch_incentive where branch_id='3' and type='CRM Visit' and '{$ress->month}' between month_from and month_to and '{$ress->count}' between enrollment_from and enrollment_to");
        $res_i = $obj->fetchNextObject($get_i);
        if($obj->numRows($get_i) > 0){
            $get_b = $obj->query("SELECT * FROM $tbl_branch_incentive where branch_id='3' and type='CRM Visit' and '{$ress->month}' between month_from and month_to and crm_visit_eligible_for_bonus <= '$ress->count'");
            if($obj->numRows($get_b) > 0){
                $res_b = $obj->fetchNextObject($get_b);
                $bonus = $res_b->crm_visit_bonus;
            }else{
                $bonus = 0;
            }
            // print_r($res_i);
            $amount = $ress->count * $res_i->amount + $bonus;
            $obj->query("INSERT $insentive_calculated SET `user_id`='{$ress->crm_executive_id}',`amount`='$amount',`month`='{$ress->month}',`year`='{$ress->year}',`type`='CRM Visit'");
            $obj->query("UPDATE $tbl_lead SET `crm_visit_insentive_status`='1' where crm_executive_id='{$ress->crm_executive_id}'");
        }
        
        }
    }
    // echo '///////////////////////////////////////////////////////////////////////////<br><br>';
}
echo 'Updated successfully....';
?>