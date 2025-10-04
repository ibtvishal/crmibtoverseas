<?php 
session_start();
include('include/config.php');
include("include/functions.php");
require 'excel/vendor/autoload.php';
// error_reporting(E_ALL);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$first_date = '2025-01-01';
$addtional_role = explode(',',$_SESSION['additional_role']);
if(isset($_POST['btn_add_file'])){
    $name = $obj->escapestring($_POST['file_name']);
    $category_id = $obj->escapestring($_POST['category_id']);
    $subcat_id = $obj->escapestring($_POST['subcat_id']);
    $country_id = $obj->escapestring($_POST['country_id']);
    $visa_id = $obj->escapestring($_POST['visa_id']);
 
    if($_FILES['file']['name']!=''){
        $file_name = 'file-'.rand('1','10000').'-'.$_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, 'uploads/'.$file_name);
    }

 $insert = $obj->query("INSERT `tbl_file` SET visa_id='$visa_id',country_id='$country_id', `category_id`='$category_id',`subcategory_id`='$subcat_id',`file_name`='$name',`file`='$file_name'");
if($insert){
    $_SESSION['sess_msg']='File added sucessfully';   
    header('location:manage-file.php');
}
}

if(isset($_POST['btn_update_file'])){
    $name = $obj->escapestring($_POST['file_name']);
    $category_id = $obj->escapestring($_POST['category_id']);
    $subcat_id = $obj->escapestring($_POST['subcat_id']);
    $id = $obj->escapestring($_POST['id']);
    $country_id = $obj->escapestring($_POST['country_id']);
    $visa_id = $obj->escapestring($_POST['visa_id']);
    if($_FILES['file']['name']!=''){
        $file_name = 'file-'.rand('1','10000').'-'.$_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, 'uploads/'.$file_name);
    }else{
        $file_name = $obj->escapestring($_POST['old_file']);
    }

 $insert = $obj->query("UPDATE `tbl_file` SET visa_id='$visa_id',country_id='$country_id', `category_id`='$category_id',`subcategory_id`='$subcat_id',`file_name`='$name',`file`='$file_name' WHERE id='$id'");
if($insert){
    $_SESSION['sess_msg']='File updated sucessfully';   
    header('location:manage-file.php');
}
}

if(isset($_GET['file_delete_id'])){
    $sql="delete from $tbl_file where id='".$_GET['file_delete_id']."'"; 

    $obj->query($sql);
    $sess_msg='Selected record(s) deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: manage-file.php");
    exit();
}
if(isset($_POST['account_manage'])){
   foreach($_POST['account_manage'] as $res){
    $get = $obj->query("select * from tbl_admin where `branch_id` LIKE '%$res%' and level_id='3'");
    while($ress = $obj->fetchNextObject($get)){
        ?>
<option value="<?=$ress->id?>"><?=$ress->name?></option>
<?php
    }
   }
}
if(isset($_POST['get_account'])){
    $get = $obj->query("select * from tbl_admin where id='".$_POST['get_account']."'");
    $res = $obj->fetchNextObject($get);
    ?>
<option value="<?=$res->id?>" selected><?=$res->name?></option>
<?php
}
if(isset($_GET['slot_agent_del_id'])){
    $sql="delete from $tbl_slot_agent where id='".$_GET['slot_agent_del_id']."'"; 

    $obj->query($sql);
    $sess_msg='Selected record(s) deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: slot-agent.php");
    exit();
}
if(isset($_POST['change_seen_status'])){
    $sql="update $tbl_student_notes set seen_status='1' where univercity_id='".$_POST['u_id']."' and stu_id='".$_POST['s_id']."'"; 
    $obj->query($sql);
}
if(isset($_POST['submit_to_family_fund'])){
    $id = $_POST['id'];
    $to = $_POST['to'];
    $sql="update $tbl_student_document set dtype='$to' where id='$id'"; 
    $obj->query($sql);
}

if(isset($_POST['btn_add_enrolled_fee'])){
    extract($_POST);
    $gst = intval($_POST['gst']);
    $after_visa_gst = intval($_POST['after_visa_gst']);
    $type = $_POST['type'];
    $sql="INSERT $tbl_enrolled_fee SET `country_id`='$country_id',`visa_type`='$visa_type',`visa_sub_type`='$visa_sub_type',`amount`='$amount',`gst`='$gst',`discount`='$discount',`after_visa_amount`='$after_visa_amount',`after_visa_gst`='$after_visa_gst',`after_visa_discount`='$after_visa_discount',amount_after_gst='$amount_after_gst',after_visa_amount_after_gst='$after_visa_amount_after_gst',`type`='$type',registration_percentage='$registration_percentage'"; 
    $obj->query($sql);
    $sess_msg='Enrolled Fee Added successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: add-enrolled-fee.php");
}
if(isset($_POST['btn_update_enrolled_fee'])){
    extract($_POST);
    $gst = intval($_POST['gst']);
    $after_visa_gst = intval($_POST['after_visa_gst']);
    $type = $_POST['type'];
    $sql="UPDATE $tbl_enrolled_fee SET `country_id`='$country_id',`visa_type`='$visa_type',`visa_sub_type`='$visa_sub_type',`amount`='$amount',`gst`='$gst',`discount`='$discount',`after_visa_amount`='$after_visa_amount',`after_visa_gst`='$after_visa_gst',`after_visa_discount`='$after_visa_discount',amount_after_gst='$amount_after_gst',after_visa_amount_after_gst='$after_visa_amount_after_gst',`type`='$type',registration_percentage='$registration_percentage' WHERE id='$id'"; 
    $obj->query($sql);
    $sess_msg='Enrolled Fee Updated successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: manage-enrolled-fee.php");
}
if(isset($_GET['delete_enrolled_fee'])){
    $id = $_GET['delete_enrolled_fee'];
    $sql="DELETE FROM $tbl_enrolled_fee WHERE id='$id'"; 
    $obj->query($sql);
    $sess_msg='Enrolled Fee Deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: manage-enrolled-fee.php");
}

if(isset($_POST['btn_visit_fee'])){
    $id = $_POST['visit_id'];
    $applicant_contact_no = getField("applicant_contact_no",$tbl_visit, $id);
    $applicant_alternate_no = getField("applicant_alternate_no",$tbl_visit, $id);
    $c = '';
    $c1 = '';
    if(is_array($_POST['visa_type']) && count($_POST['visa_type']) > 0){
        $visa_types = implode(",", $_POST['visa_type']);
        $c .= " ,visa_type='".$visa_types."'";
        $c1 .= " ,visa_type='".$visa_types."'";
        $c .= " ,visa_sub_type='".$_POST['visa_sub_type']."'";
        $c1 .= " ,visa_sub_type='".$_POST['visa_sub_type']."'";
    }
    if(isset($_POST['reapply'])){
        $c .= " ,reapply='1'";
    }
    if($_POST['remark'] != ''){
       $remark =  $obj->escapestring($_POST['remark']);
        $c .= " ,remark='$remark'";
    }
    if($_POST['allocate_counsellor'] != ''){
        $allocate_counsellor = $obj->escapestring($_POST['allocate_counsellor']);
        $c .= " ,counsellor_allocate='$allocate_counsellor'";
    }
    $profile_visa = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_visa_sub_type where id='".$_POST['visa_sub_type']."'"));
    $profile_visa_count = $obj->numRows($obj->query("SELECT * FROM $tbl_profile_status where visit_id='$id'"));
      $min = $_POST['profile_status'];
  if($min < 100 && $profile_visa_count == 0){
      if($min >= $profile_visa->registration_percentage){
          $c1 .= " ,visit_status='Registered',visit_status_date='".date("Y-m-d H:i:s")."'";
        }else{
          $c1 .= " ,visit_status='Register',visit_status_date='".date("Y-m-d H:i:s")."'";
      }
  }
        // $min = 0;
        // $profile_visa = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_visa_sub_type where id='{$_POST['visa_sub_type']}'"));
        // $profile_s_count = $obj->query("SELECT * FROM $tbl_profile_status where visit_id='$id'");
        // if($obj->numRows($profile_s_count) == 0){
        //     $min = $_POST['profile_status'];
        // }else{
        //     $profile_s_counts = $obj->fetchNextObject($profile_s_count);
        //     $min = $_POST['profile_status'] + $profile_s_counts->percentage;
        // }
        // if($min < 100){
        //     if($min >= $profile_visa->registration_percentage){
        //         $c1 .= " ,visit_status='Registered'";
        //     }
        // }else{
        //     // $obj->query("UPDATE $tbl_student SET `type`='Enrolled' where alternate_contact in ('$applicant_contact_no','$applicant_alternate_no') or student_contact_no in ('$applicant_contact_no','$applicant_alternate_no')");
        //     $c1 .= " ,visit_status='Enrolled'";
        // }
    if(isset($_POST['status_id'])){
        $obj->query("UPDATE $tbl_profile_status SET user_id='{$_SESSION['sess_admin_id']}', `percentage`='{$_POST['profile_status']}' $c where id='{$_POST['status_id']}'");
        $obj->query("UPDATE $tbl_visit SET `status`='1' $visa_type $c1 WHERE id='$id'"); 
    }else{
        $obj->query("INSERT $tbl_profile_status SET type='{$_POST['type']}', visit_id='$id', user_id='{$_SESSION['sess_admin_id']}', `percentage`='{$_POST['profile_status']}' $c");
        $obj->query("UPDATE $tbl_visit SET `status`='1' $visa_type $c1 WHERE id='$id'"); 
    }
    $obj->query("UPDATE $tbl_visit SET reapply_status=0,university_change_status=0 where id='$id'");   
    
    if(isset($_POST['duolingo']) && $_POST['duolingo'] == 'Yes'){
        $no_of_days = $_POST['no_of_days'];
        $class_start_date = date('Y-m-d');
        $class_end_date = date('Y-m-d', strtotime('+'.$_POST['duolingo_days'].' days'));
        $obj->query("INSERT $tbl_duolingo_classe SET visit_id='$id', user_id='{$_SESSION['sess_admin_id']}', `class_mode`='{$_POST['duolingo_mode']}', `no_of_days`='{$_POST['duolingo_days']}',status=0");
        $obj->query("UPDATE $tbl_visit SET `duolingo_branch`=branch_id WHERE id='$id'"); 
    }
    if(isset($_POST['spoken']) && $_POST['spoken'] == 'Yes'){
        $class_start_date = date('Y-m-d');
        $class_end_date = date('Y-m-d', strtotime('+'.$_POST['spoken_days'].' days'));
        $obj->query("INSERT $tbl_spoken_classe SET visit_id='$id', user_id='{$_SESSION['sess_admin_id']}',`no_of_days`='{$_POST['spoken_days']}',status=0");
        $obj->query("UPDATE $tbl_visit SET `spoken_branch`=branch_id WHERE id='$id'"); 
        // $obj->query("UPDATE $tbl_visit SET `spoken_date_status`='1' WHERE id='$id'"); 
    }
    $sess_msg='Profile Status Updated Successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header('location:visit-list.php');
    exit();
}

// if(isset($_POST['btn_visit_fee'])){
//     $id = $_POST['visit_id'];
//     $payment_type = $_POST['payment_type'];
//     $date = $_POST['date'];
//     // print_r($_POST);die;
//     $visa_type = '';
// //    if(count($_POST['visa_type']) > 0){
//     // $visa_types = implode(",", $_POST['visa_type']);
//     // $visa_type = " ,visa_type='".$visa_types."'";
// // }
// $get_visit = $obj->query("select * from $tbl_visit where id='$id'");
// $res_visit = $obj->fetchNextObject($get_visit);
// $billing_name = getField('billing_name',$tbl_branch,$res_visit->branch_id);
// $billing_address = getField('address',$tbl_branch,$res_visit->branch_id);
// $gst_no = getField('gst',$tbl_branch,$res_visit->branch_id);

// if($_POST['visa_sub_type'] != ''){
//     $visa_type .= " ,visa_sub_type='".$_POST['visa_sub_type']."'";
//    }
// $sql="UPDATE $tbl_visit SET `status`='1',billing_name='$billing_name',billing_address='$billing_address',gst_no='$gst_no' $visa_type WHERE id='$id'"; 
// $obj->query($sql);

//    $c = '';
//    if($_POST['registration_amount'] != ''){
//     $c .= " ,registration_amount=".$_POST['registration_amount'];
//    }
//    if($_POST['gst_amount'] != ''){
//     $gst = intval($_POST['gst_amount']);
//     $c .= " ,gst_amount='$gst'";
//    }
//    if($_POST['total_amount'] != ''){
//     $c .= " ,total_amount=".$_POST['total_amount'];
//    }
//    if($_POST['bank'] != ''){
//     $c .= " ,bank=".$_POST['bank'];
//    }
//    if($_POST['cash'] != ''){
//     $c .= " ,cash=".$_POST['cash'];
//    }
//    if($_POST['enrollment_amount'] != ''){
//     $c .= " ,enrollment_amount=".$_POST['enrollment_amount'];
//    }
//    if($_POST['amount_already_paid'] != ''){
//     $c .= " ,amount_already_paid=".$_POST['amount_already_paid'];
//    }
//    if($_POST['pending_enrollement_amount'] != ''){
//     $c .= " ,pending_enrollement_amount=".$_POST['pending_enrollement_amount'];
//    }
//    if($_POST['discount_amount'] != ''){
//     $c .= " ,discount_amount=".$_POST['discount_amount'];
//    }
//    if($_POST['net_amount'] != ''){
//     $c .= " ,net_amount=".$_POST['net_amount'];
//    }
//    if($_POST['bank_tid'] != ''){
//     $c .= " ,bank_tid='".$_POST['bank_tid']."'";
//    }
//    if($_POST['upi'] != ''){
//     $c .= " ,upi=".$_POST['upi'];
//    }
//    if($_POST['upi_tid'] != ''){
//     $c .= " ,upi_tid='".$_POST['upi_tid']."'";
//    }
//    if($_POST['cheque'] != ''){
//     $c .= " ,cheque=".$_POST['cheque'];
//    }
//    if($_POST['cheque_tid'] != ''){
//     $c .= " ,cheque_tid='".$_POST['cheque_tid']."'";
//    }
//    if($_POST['swipe'] != ''){
//     $c .= " ,swipe=".$_POST['swipe'];
//    }
//    if($_POST['accountant_remark'] != ''){
//     $c .= " ,accountant_remark='".$_POST['accountant_remark']."'";
//    }
//    if($_POST['swipe_tid'] != ''){
//     $c .= " ,swipe_tid='".$_POST['swipe_tid']."'";
//    }
//    if(isset($_POST['accepted_by']) && $_POST['accepted_by'] != ''){
//     $c .= " ,accepted_by='".$_POST['accepted_by']."'";
//    }
//    if(isset($_POST['discount_reason']) && $_POST['discount_reason'] != ''){
//     $c .= " ,discount_reason='".$_POST['discount_reason']."'";
//    }
//    if(isset($_POST['after_visa_fee_commitment']) && $_POST['after_visa_fee_commitment'] != ''){
//     $after_visa_fee_commitment = number_format($_POST['after_visa_fee_commitment']/100000,2);
//     $c .= " ,after_visa_fee_commitment='$after_visa_fee_commitment'";
//    }
//    $visa_s_type = '';
//    if($_POST['visa_sub_type'] != ''){
//     $c .= " ,visa_sub_type='".$_POST['visa_sub_type']."'";
//     $visa_s_type = $_POST['visa_sub_type'];
//    }else{
//     $sql_vs= $obj->query("select * from $tbl_visit_fee WHERE visit_id='$id'"); 
//     $visas =$obj->fetchNextObject($sql_vs);
//     $count_rs = $obj->numRows($sql_vs);
//     if($count_rs > 0){
//     $c .= " ,visa_sub_type='".$visas->visa_sub_type."'";
//     $visa_s_type = $visas->visa_sub_type;
//     }
//    }
// //    $get_v_s = $obj->query("select * from $tbl_enrolled_fee WHERE visa_sub_type='$visa_s_type'");
// //    if($obj->numRows($get_v_s) > 0){
// //     $v_s_type =$obj->fetchNextObject($get_v_s);
// //     if($res_visit->branch_id == 1 || $res_visit->branch_id == 4){
// //         $c .= " ,franchise_percentage='25'";
// //         $c .= " ,av_franchise_percentage='25'";
// //     }else{
// //     $c .= " ,franchise_percentage='".$v_s_type->share_percentage."'";
// //     $c .= " ,av_franchise_percentage='".$v_s_type->av_share_percentage."'";
// //     }
// //    }
// $get_v_s1 = $obj->fetchNextObject($obj->query("SELECT * FROM `tbl_enrolled_fee` WHERE `visa_sub_type` = '$visa_s_type'"));
// // echo "select * from $tbl_branch_franchise WHERE visa_sub_type='{$get_v_s1->id}' and branch_id='{$res_visit->branch_id}'";die;
//    $get_v_s = $obj->query("select * from $tbl_branch_franchise WHERE visa_sub_type='{$get_v_s1->id}' and branch_id='{$res_visit->branch_id}'");
//    if($obj->numRows($get_v_s) > 0){
//     $v_s_type =$obj->fetchNextObject($get_v_s);
//     $c .= " ,franchise_percentage='".$v_s_type->bv_per."'";
//     $c .= " ,av_franchise_percentage='".$v_s_type->av_per."'";
//    }
//     if(isset($_POST['visa_type']) && count($_POST['visa_type']) > 0){
//     $visa_types = implode(",", $_POST['visa_type']);
//     $c .= " ,visa_type='".$visa_types."'";
// }else{
//     $sql_vs= $obj->query("select * from $tbl_visit_fee WHERE visit_id='$id'"); 
//     $visas =$obj->fetchNextObject($sql_vs);
//     $count_rs = $obj->numRows($sql_vs);
//     if($count_rs > 0){
//     $c .= " ,visa_type='".$visas->visa_type."'";
//     }
//     }
//    if($_POST['fee_id'] == ''){
//        $sql_v= $obj->query("select * from $tbl_visit WHERE id='$id'"); 
//        $visa =$obj->fetchNextObject($sql_v);
//     $get_r = $obj->query("select a.* from $tbl_visit_fee as a inner join $tbl_visit as b on b.id = a.visit_id where b.branch_id = '".$visa->branch_id."'  order by code desc");
//     $res_r = $obj->fetchNextObject($get_r);
//     $count_r = $obj->numRows($get_r);

//     $get_branch = substr(getField('branch_code',$tbl_branch,$visa->branch_id), 0, 3);
//     if($count_r > 0){
//         if($res_r->id < 10){
//             $zeros = '00';
//         }elseif($res_r->id > 9 && $res_r->id < 100){
//             $zeros = '0';
//         }else{
//             $zero = '';
//         }
//         $code = $res_r->code+1;
//         $reciept_no = $get_branch.$zeros.$code;
//     }else{
//         $code = 1;
//         $reciept_no = $get_branch.'001';
//     }
//        $c .= " ,code='$code'";
//        $c .= " ,reciept_no='$reciept_no'";
       
//        if($payment_type != 'Reapply'){
//        $obj->query("UPDATE $tbl_visit_fee SET status='0' WHERE visit_id='$id'");
//        }
//    $sql="INSERT $tbl_visit_fee SET visit_id='$id', payment_type='$payment_type',payment_date='$date' $c"; 
//    }else{
//        $sql="UPDATE $tbl_visit_fee SET visit_id='$id', payment_type='$payment_type',payment_date='$date' $c WHERE id='".$_POST['fee_id']."'"; 
//     }
//    $obj->query($sql);
   
//    if (strpos($payment_type, 'Reapply') !== false) {
//        $count_stu=$obj->query("select * from $tbl_student where 1=1 and (student_contact_no in('{$res_visit->applicant_contact_no}','{$res_visit->applicant_alternate_no}') or alternate_contact in('{$res_visit->applicant_contact_no}','{$res_visit->applicant_alternate_no}')) and reapply_status=1",-1); //die();
//        if($obj->numRows($count_stu) == 0){
//            $sqll=$obj->query("select * from $tbl_student where 1=1 order by id desc",-1); //die();
//            $result=$obj->fetchNextObject($sqll);
//            $parts = explode("IBT", $result->student_no);
//         $student_no=codeGenerate($parts[1]);
        
//         $old_stu=$obj->fetchNextObject($obj->query("select * from $tbl_student where 1=1 and student_contact_no in('{$res_visit->applicant_contact_no}','{$res_visit->applicant_alternate_no}') or alternate_contact in('{$res_visit->applicant_contact_no}','{$res_visit->applicant_alternate_no}')",-1)); //die();
//         $stu_old_id=$old_stu->id;

//         if($visa_s_type == 50 || $visa_s_type == 48){
//             $student_type = 6;
//         }
//         if($visa_s_type == 20 || $visa_s_type == 47){
//             $student_type = 4;
//         }
//         if($visa_s_type == 42){
//             $student_type = 5;
//         }
        
//        $obj->query("INSERT INTO $tbl_student 
//         (branch_id, c_id, am_id, wc_id, am_assign_date_time, fm_id, slot_executive_id, student_no, stu_name, dob, alternate_contact, enrolment_date, crm_executive_id, passport_no, country_id, address, state_id, city_id, postalcode, visa_id, student_type, accept_student, education_verify, language_proficiency, student_contact_no, ten_start_year, ten_end_year, ten_stream, ten_percent, twl_start_year, twl_end_year, twl_stream, twl_percent, dip_start_year, dip_end_year, dip_stream, dip_percent, dip1_start_year, dip1_end_year, dip1_stream, dip1_percent, grd_start_year, grd_end_year, grd_stream, grd_percent, grd1_start_year, grd1_end_year, grd1_stream, grd1_percent, pgrd_start_year, pgrd_end_year, pgrd_stream, pgrd_percent, pgdrd_start_year, pgdrd_end_year, pgdrd_stream, pgdrd_percent, application_check, course_recomandateion_one, course_recomandateion_two, application_id, sam_assign, fm_assign, fm_allocated_id, status, refund_status, affidavit_remarks, with_financial_affidavit_remark, transfer_id, approve_review, special_remarks, management_member, management_type, management_remark, management_date, management_member_status, profile_accessed, profile_accessed_date, welcome_call_status, insentive_status, crm_insentive_status, passcode, student_login,reapply_status)
//         SELECT branch_id, '".$_POST['allocate_counsellor']."', 0, 0, null, 0, slot_executive_id, '$student_no', stu_name, dob, alternate_contact, enrolment_date, crm_executive_id, passport_no, country_id, address, state_id, city_id, postalcode, visa_id, '$student_type', 0, education_verify, language_proficiency, student_contact_no, ten_start_year, ten_end_year, ten_stream, ten_percent, twl_start_year, twl_end_year, twl_stream, twl_percent, dip_start_year, dip_end_year, dip_stream, dip_percent, dip1_start_year, dip1_end_year, dip1_stream, dip1_percent, grd_start_year, grd_end_year, grd_stream, grd_percent, grd1_start_year, grd1_end_year, grd1_stream, grd1_percent, pgrd_start_year, pgrd_end_year, pgrd_stream, pgrd_percent, pgdrd_start_year, pgdrd_end_year, pgdrd_stream, pgdrd_percent, application_check, course_recomandateion_one, course_recomandateion_two, application_id, sam_assign, fm_assign, fm_allocated_id, status, refund_status, affidavit_remarks, with_financial_affidavit_remark, transfer_id, approve_review, special_remarks, management_member, management_type, management_remark, management_date, management_member_status, profile_accessed, profile_accessed_date, welcome_call_status, insentive_status, crm_insentive_status, passcode, student_login,1
//         FROM $tbl_student 
//         WHERE id=$stu_old_id");
//         $new_stu_id = $obj->lastInsertedId();
       
//        $obj->query("INSERT INTO $tbl_student_course (stu_id, course_name)
//                     SELECT '$new_stu_id', course_name
//                     FROM $tbl_student_course
//                     WHERE stu_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_relation (`sutdent_id`, `relation`, `name`, `sponser`, `dob`, `contact_no`, `email`)
//                     SELECT '$new_stu_id',`relation`, `name`, `sponser`, `dob`, `contact_no`, `email`
//                     FROM $tbl_student_relation
//                     WHERE sutdent_id = $stu_old_id;");
                    
//        $obj->query("INSERT INTO $tbl_student_univercity_course (`sutdent_id`,`state_id`, `univercity_id`, `course_id`, `month`, `year`)
//                     SELECT '$new_stu_id',`state_id`, `univercity_id`, `course_id`, `month`, `year`
//                     FROM $tbl_student_univercity_course
//                     WHERE sutdent_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_diploma (
//                         sutdent_id, registration_no, diploma_id, institute_id, start_date, end_date, 
//                         time_duration, status, slip_number, slip_photo, mother_name, stu_contact_number, 
//                         imp_remarks, photo, days, roll_no_1, roll_no_2, institute_forms_status, 
//                         exam_status, student_approval_status, media_gap_status, pimg, draft, changes
//                     )
//                     SELECT 
//                         '$new_stu_id', registration_no, diploma_id, institute_id, start_date, end_date, 
//                         time_duration, status, slip_number, slip_photo, mother_name, stu_contact_number, 
//                         imp_remarks, photo, days, roll_no_1, roll_no_2, institute_forms_status, 
//                         exam_status, student_approval_status, media_gap_status, pimg, draft, changes
//                     FROM 
//                         $tbl_student_diploma
//                     WHERE sutdent_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_experience (
//                         `registration_no`, `sutdent_id`, `designation_id`, `company_id`, `start_date`, `end_date`, `time_duration`, `status`, `slip_number`, `slip_photo`, `stu_contact_number`, `salary`, `issue_date`, `imp_remarks`, `resume`, `address_proof`, `counsellor_status`, `pimg`
//                     )
//                     SELECT 
//                         `registration_no`, '$new_stu_id', `designation_id`, `company_id`, `start_date`, `end_date`, `time_duration`, `status`, `slip_number`, `slip_photo`, `stu_contact_number`, `salary`, `issue_date`, `imp_remarks`, `resume`, `address_proof`, `counsellor_status`, `pimg`
//                     FROM 
//                         $tbl_student_experience
//                     WHERE sutdent_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_found (
//                         `sutdent_id`, `amount`, `notes`, `status`, `stu_status`
//                     )
//                     SELECT 
//                         '$new_stu_id', `amount`, `notes`, `status`, `stu_status`
//                     FROM 
//                         $tbl_student_found
//                     WHERE sutdent_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_english_proficiency (
//                          `sutdent_id`, `course`, `wirting`, `reading`, `listening`, `speaking`, `overall_bands`, `exam_date`, `login_id`, `password`
//                     )
//                     SELECT 
//                         '$new_stu_id', `course`, `wirting`, `reading`, `listening`, `speaking`, `overall_bands`, `exam_date`, `login_id`, `password`
//                     FROM 
//                         $tbl_student_english_proficiency
//                     WHERE sutdent_id = $stu_old_id;");

//        $obj->query("INSERT INTO $tbl_student_work_experience (
//                          `sutdent_id`, `company_name`, `designation`, `start_date`, `end_date`
//                     )
//                     SELECT 
//                         '$new_stu_id', `company_name`, `designation`, `start_date`, `end_date`
//                     FROM 
//                         $tbl_student_work_experience
//                     WHERE sutdent_id = $stu_old_id;");



//                     $old_code = getField('student_no',$tbl_student, $stu_old_id);
//                     $new_code = getField('student_no',$tbl_student, $new_stu_id);
//                     $new_id = $new_stu_id;

//                     $obj->query("update $tbl_student set transfer_id='$old_code' where id='$new_id'",-1); 

//                     $sql = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$old_code'", -1);
//                     $line = $obj->fetchNextObject($sql);

//                     $sql2 = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$new_code'", -1);
//                     $line2 = $obj->fetchNextObject($sql2);

//                     $sql1 = $obj->query("SELECT * FROM $tbl_student_document WHERE stu_id = '{$line->id}'", -1);
//                     $file_uplaod = false;
//                     if($obj->numRows($sql1) > 0){
//                     while ($res = $obj->fetchNextObject($sql1)) {
//                         // $new_file = str_replace($old_code, $new_code, $res->name);
//                         // if (copy('uploads/' . $res->name, 'uploads/' . $new_file)) {
//                             $file_uplaod = $obj->query("INSERT INTO $tbl_student_document SET stu_id = '$new_id', dtype = '{$res->dtype}', `name` = '{$res->name}', `orgname` = '{$res->name}', user_id = '" . $_SESSION['sess_admin_id'] . "', desiredExt = '{$res->desiredExt}', transfer_status = 1", -1);
//                         // }
//                     }
//                     }else{
//                         $file_uplaod = true;
//                     }
//                     // if($line->country_id == $line2->country_id && $file_uplaod){
//                         $sql3 = $obj->query("SELECT * FROM $tbl_student_application WHERE stu_id = '{$line->id}'", -1);
//                         while ($totald = $obj->fetchNextObject($sql3)) {
//                             if($totald->status == 'I-20 Issued'){
//                                 $status = 'I-20 Issued(Old)';
//                             }else{
//                                 $status = $totald->status;
//                             }
//                             $obj->query("insert into $tbl_student_application set stu_id='$new_id',college_name='".$totald->college_name."',location='".$totald->location."',course='".$totald->course."',month='".$totald->month."',year='".$totald->year."',status='$status',portal_status='".$totald->portal_status."',remarks='".$obj->escapestring($totald->remarks)."',user_id='".$totald->user_id."',parent_id='".$totald->parent_id."',cdate='".$totald->cdate."',portal_id='".$totald->portal_id."',university_id='".$totald->university_id."',university_pass='".$totald->university_pass."',transfer_status=1", -1);
//                         }

//                         $sql31 = $obj->query("SELECT * FROM $tbl_user_recovery WHERE student_id = '{$line->id}'", -1);
//                     while ($totald = $obj->fetchNextObject($sql31)) {
//                         $obj->query("insert into $tbl_user_recovery set student_id='$new_id',user_id='".$totald->user_id."',offical_email='".$totald->offical_email."',password='".$totald->password."',recovery_email='".$totald->recovery_email."',recovery_number='".$totald->recovery_number."',transfer_status=1", -1);
//                     }
//                     $obj->query("INSERT $tbl_student_noc SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$new_id',type=1,transfer_status=1");  
//                     $usql=$obj->query("select * from $tbl_filing_credentials where student_id='{$line->id}'",-1);//die();
//                     $res1=$obj->fetchNextObject($usql);
//                     $obj->query("INSERT INTO $tbl_filing_credentials SET `user_id`='{$_SESSION['sess_admin_id']}',`student_id`='$new_id',`cgi_user_id`='{$res1->cgi_user_id}',`cgi_password`='{$res1->cgi_password}',`cgi_email`='{$res1->cgi_email}',`email_password`='{$res1->email_password}',`recovery_email`='{$res1->recovery_email}',`recovery_number`='{$res1->recovery_number}',`security_answer`='{$res1->security_answer}',`ds_application_id`='{$res1->ds_application_id}',`status`='{$res1->status}',`pstatus`='{$res1->pstatus}',`savis_id`='{$res1->savis_id}',`savis_payment_status`='{$res1->savis_payment_status}',`university`='{$res1->university}',`ds_status`='{$res1->ds_status}',`gc_key`='{$res1->gc_key}',`gc_password`='{$res1->gc_password}',`gc_code`='{$res1->gc_code}',`security_question`='{$res1->security_question}',`recovery_question`='{$res1->recovery_question}',`recovery_annser`='{$res1->recovery_annser}',`transfer_status`='1'");  

//                     header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($new_id)))); 
//                     exit();
//                 }else{
//                     $res = $obj->fetchNextObject($count_stu);
//                     $obj->query("UPDATE $tbl_student set c_id='".$_POST['allocate_counsellor']."', am_id=0, wc_id=0, am_assign_date_time=null, slot_executive_id=0 WHERE id={$res->id}");
//                     $id = $res->id;
//                     $sql = $obj->query("delete from $tbl_appointment where student_id='$id'",-1); 
//                     // $sql = $obj->query("delete from $tbl_user_recovery where student_id='$id'",-1); 
//                     // $sql = $obj->query("delete from $tbl_student_application where stu_id='$id'",-1); 
//                     $sql = $obj->query("delete from $tbl_student_enrollment where stu_id='$id'",-1); 
//                     $sql = $obj->query("delete from $tbl_student_noc where stu_id='$id'",-1); 
//                     // $sql = $obj->query("delete from $tbl_student_notes where stu_id='$id'",-1); 
//                     $sql = $obj->query("delete from $tbl_student_passport_noc where stu_id='$id'",-1); 
//                     $sql = $obj->query("delete from $tbl_student_status where stu_id='$id'",-1); 
//                     // $sql = $obj->query("delete from $tbl_student_updated_time where stu_id='$id'",-1); 
//                     header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($id))));
//                     exit(); 
//                 }
//                 // header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($new_id)))); 
//    }else{
//    header("location:slip.php?id=".base64_encode(base64_encode(base64_encode($id)))."&full_payment&type=".$payment_type.""); 
//    }
// }

if(isset($_POST['get_modal_data_fee'])){
    $id = $_POST['id'];
    $sql = $obj->query("select * from $tbl_visit where id='$id'");
    $result = $obj->fetchNextObject($sql);

   ?>
<div>
    <table class="table table-borderless table-sm px-3">
        <tr>
            <td>
                Visit date
            </td>
            <td>:</td>
            <td>
                <?=date('d-m-Y',strtotime($result->cdate))?>
            </td>
        </tr>
        <tr>
            <td>
                Student Name
            </td>
            <td>:</td>
            <td>
                <?=$result->applicant_name?>
            </td>
        </tr>
        <tr>
            <td>Student Code</td>
            <td>:</td>
            <?php
                $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$result->applicant_contact_no."' or alternate_contact='".$result->applicant_contact_no."' or student_contact_no='".$result->applicant_alternate_no."' or alternate_contact='".$result->applicant_alternate_no."'");
                $student = $obj->fetchNextObject($get_student);
            ?>
            <td> <?=$student->student_no?></td>
        </tr>
        <!-- <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td> <?=$result->enquiry_id?></td>
                            </tr> -->
        <tr>
            <td>Father Name</td>
            <td>:</td>
            <td> <?=$result->father_name?></td>
        </tr>
        <tr>
            <td>Contact No</td>
            <td>:</td>
            <td> <?=$result->applicant_contact_no?></td>
        </tr>
        <!-- <tr>
                                <td>Membership</td>
                                <td>:</td>
                                <td> <?=$result1->payment_type?></td>
                            </tr> -->
    </table>
    <?php
                           $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                           $result_fee = $obj->fetchNextObject($sql2);
                           $totalFiltered=$obj->numRows($sql2);
                        if($totalFiltered > 0){
                        ?>
    <p class="text-center bg-white table-title" style="font-weight:bold;color:black">Registration Payment History</p>

    <table class="table table-sm">
        <tr>
            <th>Registration Fee Details</th>
            <td>:</td>
            <th><?=date('d M, Y',strtotime($result_fee->payment_date))?></th>
        </tr>
        <tr>
            <td>Registration Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee->registration_amount?></td>
        </tr>
        <tr>
            <td>GST Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee->gst_amount?></td>
        </tr>
        <tr class="total">
            <td>TOTAL</td>
            <td>:</td>
            <td>₹ <?=$result_fee->total_amount?></td>
        </tr>
        <?php
        if($result_fee->cash != '' && $result_fee->cash != '0'){
        ?>
        <tr>
            <th>Cash</th>
            <td>:</td>
            <th>₹ <?=$result_fee->cash?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee->upi != '' && $result_fee->upi != '0'){
        ?>
        <tr>
            <th>UPI (<?=$result_fee->upi_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee->upi?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee->bank != '' && $result_fee->bank != '0'){
        ?>
        <tr>
            <th>Net Banking (<?=$result_fee->bank_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee->bank?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee->cheque != '' && $result_fee->cheque != '0'){
        ?>
        <tr>
            <th>Cheque / DD (<?=$result_fee->cheque_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee->cheque?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee->swipe != '' && $result_fee->swipe != '0'){
        ?>
        <tr>
            <th>Swipe (<?=$result_fee->swipe_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee->swipe?></th>
        </tr>
        <?php } ?>

    </table>
    <?php }
                         $sql2s = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and (payment_type IN ('Enrollment', 'Direct Enrollment') OR payment_type LIKE '%Reapply%')");
                         $totalFiltered=$obj->numRows($sql2s);
                         if($totalFiltered > 0){
                         while($result_fee2 = $obj->fetchNextObject($sql2s)){
                            if($result_fee2->payment_type == 'Direct Enrollment' && $result_fee2->upi == null && $result_fee2->cheque == null && $result_fee2->swipe == null && $result_fee2->bank == null && $result_fee2->payment_date > $first_date && ($result->visa_sub_type == 3 || $result->visa_sub_type == 43 || $result->visa_sub_type == 44)){
                                $net_amount = $result_fee2->net_amount*10/100;
                                $gst_amount = $result_fee2->gst_amount*10/100;
                                $total_amount = $result_fee2->total_amount*10/100;
                                $amount_already_paid = $result_fee2->amount_already_paid*10/100;
                                $enrollment_amount = $result_fee2->enrollment_amount*10/100;
                                $discount_amount = $result_fee2->discount_amount*10/100;
                                $cash = $result_fee2->cash*10/100;
                                $ten_per = 1;
                            }else{
                                $net_amount = $result_fee2->net_amount;
                                $gst_amount = $result_fee2->gst_amount;
                                $total_amount = $result_fee2->total_amount;
                                $amount_already_paid = $result_fee2->amount_already_paid;
                                $enrollment_amount = $result_fee2->enrollment_amount;
                                $discount_amount = $result_fee2->discount_amount;
                                $cash = $result_fee2->cash;
                                $ten_per = 0;
                            }
                            ?>
    <!-- <p class="table-devider"></p> -->
    <p class="text-center bg-white table-title" style="font-weight:bold;color:black">
        <?=$result_fee2->payment_type == 'Enrollment' || $result_fee2->payment_type == 'Direct Enrollment' ? 'Enrollment' : 'Reapply'?>
        Payment History</p>
    <table class="table table-sm mb-3">
        <tr>
            <th>Enrollment Fee Details</th>
            <td>:</td>
            <th><?=date('d M, Y',strtotime($result_fee2->payment_date))?></th>
        </tr>

        <?php
                                    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                                    $result2 = $obj->fetchNextObject($sql2);
                                    $result_fee_count = $obj->numRows($sql2);
                                    if($result_fee_count > 0 && $result_fee2->payment_type != 'Reapply'){
                                        ?>
        <tr>
            <td>Registration Paid</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->amount_already_paid?></td>
        </tr>
        <tr>
            <td>Pending Enrollment Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->pending_enrollement_amount?></td>
        </tr>
        <?php
                                    }
                                ?>
        <tr>
            <td><?=$result_fee2->payment_type == 'Reapply' ? 'Reapply' : 'Enrollment'?> Amount</td>
            <td>:</td>
            <td>₹ <?=$enrollment_amount?></td>
        </tr>
        <tr>
            <td>Discount Amount</td>
            <td>:</td>
            <td>₹ <?=$discount_amount?></td>
        </tr>
        <tr>
            <td>Net Amount</td>
            <td>:</td>
            <td>₹ <?=$net_amount?></td>
        </tr>
        <?php
          if($result_fee_count > 0 && $result_fee2->payment_type != 'Reapply'){
            ?>
        <tr>
            <td>Registration GST Amount</td>
            <td>:</td>
            <td>₹ <?=$result2->gst_amount?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?=$result_fee2->payment_type == 'Reapply' ? 'Reapply' : 'Enrollment'?> GST Amount</td>
            <td>:</td>
            <td>₹ <?=$gst_amount?></td>
        </tr>
        <tr class="total">
            <td>TOTAL</td>
            <td>:</td>
            <?php
            if($result_fee2->payment_type == 'Enrollment' || $result_fee2->payment_type == 'Direct Enrollment'){
                $ttl_amt = $total_amount + $amount_already_paid + $result2->gst_amount;
            }else{
                $ttl_amt = $total_amount + $amount_already_paid;
            }
            ?>
            <td>₹ <?=$ttl_amt?> <?=$ten_per == 1 ? '*' : ''?></td>
        </tr>
        <?php
        if($result_fee2->cash != '' && $result_fee2->cash != '0'){
        ?>
        <tr>
            <th>Cash</th>
            <td>:</td>
            <th>₹ <?=$cash?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee2->upi != '' && $result_fee2->upi != '0'){
        ?>
        <tr>
            <th>UPI (<?=$result_fee2->upi_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee2->upi?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee2->bank != '' && $result_fee2->bank != '0'){
        ?>
        <tr>
            <th>Net Banking (<?=$result_fee2->bank_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee2->bank?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee2->cheque != '' && $result_fee2->cheque != '0'){
        ?>
        <tr>
            <th>Cheque / DD (<?=$result_fee2->cheque_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee2->cheque?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee2->swipe != '' && $result_fee2->swipe != '0'){
        ?>
        <tr>
            <th>Swipe (<?=$result_fee2->swipe_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee2->swipe?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee2->discount_amount!='' && $result_fee2->discount_amount!='0'){
            ?>
        <tr>
            <th>Discount Reason</th>
            <td>:</td>
            <th><?=$result_fee2->discount_reason?></th>
        </tr>
        <tr>
            <th>Discount Approved By</th>
            <td>:</td>
            <th><?=$result_fee2->accepted_by?></th>
        </tr>
        <?php
        }
        ?>

    </table>
    <?php } }
                         $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='After Visa'");
                         $result_fee3 = $obj->fetchNextObject($sql2);
                         $totalFiltered=$obj->numRows($sql2);
                        if($totalFiltered > 0){
                            ?>
    <p class="text-center bg-white table-title" style="font-weight:bold;color:black">After Visa Payment History</p>
    <table class="table table-sm mb-3">
        <tr>
            <th>Aftter Visa Fee Details</th>
            <td>:</td>
            <th><?=date('d M, Y',strtotime($result_fee3->payment_date))?></th>
        </tr>
        <tr>
            <td>After Visa Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee3->enrollment_amount?></td>
        </tr>
        <tr>
            <td>Discount Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee3->discount_amount?></td>
        </tr>
        <tr>
            <td>Net Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee3->net_amount?></td>
        </tr>
        <tr>
            <td>GST Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee3->gst_amount?></td>
        </tr>
        <tr class="total">
            <td>TOTAL</td>
            <td>:</td>
            <td>₹ <?=$result_fee3->total_amount?></td>
        </tr>
        <?php
        if($result_fee3->cash != '' && $result_fee3->cash != '0'){
        ?>
        <tr>
            <th>Cash</th>
            <td>:</td>
            <th>₹ <?=$result_fee3->cash?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee3->upi != '' && $result_fee3->upi != '0'){
        ?>
        <tr>
            <th>UPI (<?=$result_fee3->upi_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee3->upi?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee3->bank != '' && $result_fee3->bank != '0'){
        ?>
        <tr>
            <th>Net Banking (<?=$result_fee3->bank_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee3->bank?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee3->cheque != '' && $result_fee3->cheque != '0'){
        ?>
        <tr>
            <th>Cheque / DD (<?=$result_fee3->cheque_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee3->cheque?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee3->swipe != '' && $result_fee3->swipe != '0'){
        ?>
        <tr>
            <th>Swipe (<?=$result_fee3->swipe_tid?>)</th>
            <td>:</td>
            <th>₹ <?=$result_fee3->swipe?></th>
        </tr>
        <?php } ?>
        <?php
        if($result_fee3->discount_amount!='' && $result_fee3->discount_amount!='0'){
            ?>
        <tr>
            <th>Discount Reason</th>
            <td>:</td>
            <th><?=$result_fee3->discount_reason?></th>
        </tr>
        <tr>
            <th>Discount Approved By</th>
            <td>:</td>
            <th><?=$result_fee3->accepted_by?></th>
        </tr>
        <?php
        }
        ?>

    </table>
    <?php
      } ?>
</div>
<?php
}

if(isset($_POST['change_audit_id'])){
    $sql=$obj->query("update $tbl_visit_fee set audit_status = 1 where id='".$_POST['change_audit_id']."'");
    echo 1;exit;
}
if(isset($_POST['change_noc_id'])){
    $sql=$obj->query("update $tbl_student_document set with_financial_verify = 1 where stu_id='".$_POST['change_noc_id']."'");
    $sql=$obj->query("INSERT $tbl_student_filing_noc SET `user_id`='".$_SESSION['sess_admin_id']."',`stu_id`='".$_POST['change_noc_id']."',value='second_affidavit', status=1");
    echo 1;exit;
}
if(isset($_POST['change_noc_id1'])){
    $sql=$obj->query("update $tbl_student_document set verify = 1 where stu_id='".$_POST['change_noc_id1']."'");
    $get = $obj->query("select * from $tbl_student_filing_noc where `stu_id`='".$_POST['change_noc_id1']."' and `value`='Affidavit'");
       if($obj->numRows($get) > 0){
           $sql=$obj->query("UPDATE $tbl_student_filing_noc SET `user_id`='".$_SESSION['sess_admin_id']."', status=1 where `stu_id`='".$_POST['change_noc_id1']."' and value='Affidavit'");
       }else{
    $sql=$obj->query("INSERT $tbl_student_filing_noc SET `user_id`='".$_SESSION['sess_admin_id']."',`stu_id`='".$_POST['change_noc_id1']."',value='Affidavit', status=1");
       }
    echo 1;exit;
}

if(isset($_POST['change_financial_id1'])){
    $sql=$obj->query("update $tbl_student_document set financial_verify = 1 where stu_id='".$_POST['change_financial_id1']."'");
    // $get = $obj->query("select * from $tbl_student_filing_noc where `stu_id`='".$_POST['change_financial_id1']."' and `value`='Financials'");
    //    if($obj->numRows($get) > 0){
    //     //    $sql=$obj->query("UPDATE $tbl_student_filing_noc SET `user_id`='".$_SESSION['sess_admin_id']."', status=1 where `stu_id`='".$_POST['change_financial_id1']."' and value='Financials'");
    //    }else{
    // // $sql=$obj->query("INSERT $tbl_student_filing_noc SET `user_id`='".$_SESSION['sess_admin_id']."',`stu_id`='".$_POST['change_financial_id1']."',value='Financials', status=1");
    //    }
    echo 1;exit;
}
if(isset($_POST['change_financial_id1_dis1'])){
    $sql=$obj->query("update $tbl_student_document set financial_verify = 2 where stu_id='".$_POST['change_financial_id1_dis1']."'");
    echo 1;exit;
}
if(isset($_POST['change_noc_id_dis'])){
    $sql=$obj->query("update $tbl_student_document set with_financial_verify = 2 where stu_id='".$_POST['change_noc_id_dis']."'");
    echo 1;exit;
}
if(isset($_POST['change_noc_id_dis1'])){
    $sql=$obj->query("update $tbl_student_document set verify = 2 where stu_id='".$_POST['change_noc_id_dis1']."'");
    echo 1;exit;
}

if(isset($_POST['btn_add_appointment'])){
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $csvFile = $_FILES['file']['tmp_name'];
        
        $handle = fopen($csvFile, 'r');
        
        $data = [];
        $c = 1;
        while (($row = fgetcsv($handle)) !== false) {
            if($c != 1){
                $sql='';
                $user_id = $obj->escapestring($row['0']);
                if($user_id!=''){
                    $sql .= "user_id='$user_id'";
                }
                $student_ids = $obj->escapestring($row['1']);
                if($student_ids!=''){
                    $get_s = $obj->query("select * from $tbl_student where student_no='$student_ids'");
                    $res_s=$obj->fetchNextObject($get_s);
                    $res_s_count=$obj->numRows($get_s);
                    $student_id = $res_s->id;
                    $sql .= ",student_id='$student_id'";
                }
                $slot_executive_id =$obj->escapestring($row['2']);
                if($slot_executive_id!=''){
                    $sql .= ",slot_executive_id='$slot_executive_id'";
                }
                $slot_type = $obj->escapestring($row['3']);
                if($slot_type!=''){
                    $sql .= ",slot_type='$slot_type'";
                }

                $reciept_no = $obj->escapestring($row['4']);
                if($reciept_no!=''){
                    $sql .= ",reciept_no='$reciept_no'";
                }
                $slot_agent_id = $obj->escapestring($row['5']);
                if($slot_agent_id!=''){
                    $sql .= ",slot_agent_id='$slot_agent_id'";
                }
                $priority = $obj->escapestring($row['6']);
                if($priority!=''){
                    $sql .= ",priority='$priority'";
                }
                $preference = $obj->escapestring($row['7']);
                if($preference!=''){
                    $sql .= ",preference='$preference'";
                }
                $biometric_date = $obj->escapestring($row['8']);
                if($biometric_date!=''){
                    $biometric_date = str_replace('/','-',$biometric_date);
                    $biometric_date = date('Y-m-d',strtotime($biometric_date));
                    $sql .= ",biometric_date='$biometric_date'";
                }
                $biometric_location = $obj->escapestring($row['9']);
                if($biometric_location!=''){
                    $sql .= ",biometric_location='$biometric_location'"; 
                }
                
                $interview_date = $obj->escapestring($row['10']);
                if($interview_date!=''){
                    $interview_date = str_replace('/','-',$interview_date);
                    $interview_date = date('Y-m-d',strtotime($interview_date));
                    $sql .= ",interview_date='$interview_date'";
                }

                $pdf_status = $obj->escapestring($row['12']);
                if($pdf_status!=''){
                    $sql .= ",pdf_status='$pdf_status'";
                }

                $interview_location=$obj->escapestring($row['11']);
                if($interview_location!=''){
                    $sql .= ",interview_location='$interview_location'";
                }

                $id_owner=$obj->escapestring($row['13']);
                if($id_owner!=''){
                    $sql .= ",id_owner='$id_owner'";
                }

                $refund_status	=$obj->escapestring($row['14']);
                if($refund_status !=''){
                    $sql .= ",refund_status	='$refund_status'";
                }

                $slot_status	=$obj->escapestring($row['15']);
                if($slot_status !=''){
                    $sql .= ",slot_status='$slot_status'";
                }
                $fee_status	=$obj->escapestring($row['16']);
                if($fee_status !=''){
                    $sql .= ",fee_status='$fee_status'";
                }
                $slot_type1	=$obj->escapestring($row['17']);
                if($slot_type1 !=''){
                    $sql .= ",slot_type1='$slot_type1'";
                }
                // echo $sql.'<br><br>';
                $get_a = $obj->query("select * from $tbl_appointment where student_id='$student_id'");
                $res_a=$obj->numRows($get_a);
                if($student_ids!='' && $res_s_count > 0){
                if ($res_a==0){
                    $obj->query("insert into $tbl_student_status set `parent_id`='0',`stu_id`='$student_id',`stage_id`='34',`cstatus`='Move to Visa Appointment',`remarks`='Appointment Booked',`user_id`='$user_id'",-1);	
                    $obj->query("insert into $tbl_appointment set $sql",-1);	
                }else{
                    $obj->query("UPDATE $tbl_appointment set $sql where student_id='$student_id'",-1);
                }
            }
            }
            $c++;
        }
        // die;
        $_SESSION['sess_msg'] = 'CSV Uploaded Successfully...';
        header("location:add-appointment-file.php");
    }else{
        $_SESSION['sess_msg_error'] = 'Something wents wrong...';
        header("location:add-appointment-file.php");
    }
}

if(isset($_POST['btn_add_filling'])){
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $csvFile = $_FILES['file']['tmp_name'];
        
        $handle = fopen($csvFile, 'r');
        
        $data = [];
        $c = 1;
        while (($row = fgetcsv($handle)) !== false) {
            if($c != 1){
                $sql='';
                $user_id = $obj->escapestring($row['0']);
                if($user_id!=''){
                    $sql .= "user_id='$user_id'";
                }
                $student_ids = $obj->escapestring($row['1']);
                if($student_ids!=''){
                    $get_s = $obj->query("select * from $tbl_student where student_no='$student_ids'");
                    $res_s=$obj->fetchNextObject($get_s);
                    $res_s_count=$obj->numRows($get_s);
                    $student_id = $res_s->id;
                    $sql .= ",student_id='$student_id'";
                }
                $fe_id =$obj->escapestring($row['2']);
                if($fe_id!=''){
                    $sql .= ",fe_id='$fe_id'";
                }
                $cgi_user_id = $obj->escapestring($row['3']);
                if($cgi_user_id!=''){
                    $sql .= ",cgi_user_id='$cgi_user_id'";
                }

                $cgi_password = $obj->escapestring($row['4']);
                if($cgi_password!=''){
                    $sql .= ",cgi_password='$cgi_password'";
                }
                $cgi_email = $obj->escapestring($row['5']);
                if($cgi_email!=''){
                    $sql .= ",cgi_email='$cgi_email'";
                }
                $email_password = $obj->escapestring($row['6']);
                if($email_password!=''){
                    $sql .= ",email_password='$email_password'";
                }
                $recovery_email = $obj->escapestring($row['7']);
                if($recovery_email!=''){
                    $sql .= ",recovery_email='$recovery_email'";
                }
                $recovery_number = $obj->escapestring($row['8']);
                if($recovery_number!=''){
                    $sql .= ",recovery_number='$recovery_number'";
                }
                $security_answer = $obj->escapestring($row['9']);
                if($security_answer!=''){
                    $sql .= ",security_answer='$security_answer'";
                }
                
                $ds_application_id = $obj->escapestring($row['10']);
                if($ds_application_id!=''){
                    $sql .= ",ds_application_id='$ds_application_id'";
                }

                $status = $obj->escapestring($row['11']);
                if($status!=''){
                    $sql .= ",status='$status'";
                }

                $pstatus=$obj->escapestring($_POST['12']);
                if($pstatus!=''){
                    $sql .= ",pstatus='$pstatus'";
                }

                $savis_id=$obj->escapestring($_POST['13']);
                if($savis_id!=''){
                    $sql .= ",savis_id='$savis_id'";
                }

                $savis_payment_status	=$obj->escapestring($_POST['14']);
                if($savis_payment_status !=''){
                    $sql .= ",savis_payment_status	='$savis_payment_status'";
                }

                $ds_status	=$obj->escapestring($_POST['15']);
                if($ds_status !=''){
                    $sql .= ",ds_status	='$ds_status'";
                }
                $get_a = $obj->query("select * from $tbl_filing_credentials where student_id='$student_id'");
                $res_a=$obj->numRows($get_a);
                if($student_ids!='' && $res_s_count > 0){
                if ($res_a==0){
                    // $obj->query("insert into $tbl_student_status set `parent_id`='0',`stu_id`='$student_id',`stage_id`='34',`cstatus`='Move to Visa Appointment',`remarks`='Appointment Booked',`user_id`='$user_id'",-1);	
                    $obj->query("insert into $tbl_filing_credentials set $sql",-1);	
                }else{
                    $obj->query("UPDATE $tbl_filing_credentials set $sql where student_id='$student_id'",-1);
                }
            }
            }
            $c++;
        }
        $_SESSION['sess_msg'] = 'CSV Uploaded Successfully...';
        header("location:add-filing-csv.php");
    }else{
        $_SESSION['sess_msg_error'] = 'Something wents wrong...';
        header("location:add-filing-csv.php");
    }
}


if(isset($_POST['btn_add_enrollment'])){
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $csvFile = $_FILES['file']['tmp_name'];
        
        $handle = fopen($csvFile, 'r');
        
        $data = [];
        $c = 1;
        while (($row = fgetcsv($handle)) !== false) {
            if($c != 1){
                $sql='';
                $user_id = $obj->escapestring($row['0']);
                if($user_id!=''){
                    $sql .= "user_id='$user_id'";
                }
                $student_ids = $obj->escapestring($row['1']);
                if($student_ids!=''){
                    $get_s = $obj->query("select * from $tbl_student where student_no='$student_ids'");
                    $res_s=$obj->fetchNextObject($get_s);
                    $res_s_count=$obj->numRows($get_s);
                    $student_id = $res_s->id;
                    $sql .= ",stu_id='$student_id'";
                }
                
                $portal_id	 = $obj->escapestring($row['2']);
                if($portal_id!=''){
                    $sql .= ",portal_id='$portal_id'";
                }
                $visa_issue_date = $obj->escapestring($row['3']);
                if($visa_issue_date!=''){
                    $visa_issue_date = date('Y-m-d',strtotime($visa_issue_date));
                    $sql .= ",visa_issue_date='$visa_issue_date'";
                }
                $university_name = $obj->escapestring($row['4']);
                if($university_name!=''){
                    $sql .= ",university_name='$university_name'";
                }
                $passport_status = $obj->escapestring($row['5']);
                if($passport_status!=''){
                    $sql .= ",passport_status='$passport_status'";
                }
                $after_visa_fee = $obj->escapestring($row['6']);
                if($after_visa_fee!=''){
                    $sql .= ",after_visa_fee='$after_visa_fee'";
                }
                $enrollment_status = $obj->escapestring($row['7']);
                if($enrollment_status!=''){
                    $sql .= ",enrollment_status='$enrollment_status'";
                }
                $mail_id = $obj->escapestring($row['8']);
                if($mail_id!=''){
                    $sql .= ",mail_id='$mail_id'";
                }
                $mail_password = $obj->escapestring($row['9']);
                if($mail_password!=''){
                    $sql .= ",mail_password='$mail_password'";
                }
                $university_portal_login	 = $obj->escapestring($row['10']);
                if($university_portal_login!=''){
                    $sql .= ",university_portal_login='$university_portal_login'";
                }
                $university_portal_password = $obj->escapestring($row['11']);
                if($university_portal_password!=''){
                    $sql .= ",university_portal_password='$university_portal_password'";
                }
                $advisor_meeting = $obj->escapestring($row['12']);
                if($advisor_meeting!=''){
                    $sql .= ",advisor_meeting='$advisor_meeting'";
                }
                $classes_start_date = $obj->escapestring($row['13']);
                if($classes_start_date!=''){
                    $classes_start_date = date('Y-m-d',strtotime($classes_start_date));
                    $sql .= ",classes_start_date='$classes_start_date'";
                }
                $total_fee = $obj->escapestring($row['14']);
                if($total_fee!=''){
                    $sql .= ",total_fee='$total_fee'";
                }
                $minimum_fee = $obj->escapestring($row['15']);
                if($minimum_fee!=''){
                    $sql .= ",minimum_fee='$minimum_fee'";
                }
                $rate = $obj->escapestring($row['16']);
                if($rate!=''){
                    $sql .= ",rate='$rate'";
                }
                $fee_in_inr = $obj->escapestring($row['17']);
                if($fee_in_inr!=''){
                    $sql .= ",fee_in_inr='$fee_in_inr'";
                }$fee_payment = $obj->escapestring($row['18']);
                if($fee_payment!=''){
                    $sql .= ",fee_payment='$fee_payment'";
                }$sattlement_amount = $obj->escapestring($row['19']);
                if($sattlement_amount!=''){
                    $sql .= ",sattlement_amount='$sattlement_amount'";
                }$sattlement_amount_status = $obj->escapestring($row['20']);
                if($sattlement_amount_status!=''){
                    $sql .= ",sattlement_amount_status='$sattlement_amount_status'";
                }$fee_paid_through = $obj->escapestring($row['21']);
                if($fee_paid_through!=''){
                    $sql .= ",fee_paid_through='$fee_paid_through'";
                }$payment_method = $obj->escapestring($row['22']);
                if($payment_method!=''){
                    $sql .= ",payment_method='$payment_method'";
                }$tt_receipt_no = $obj->escapestring($row['23']);
                if($tt_receipt_no!=''){
                    $sql .= ",tt_receipt_no='$tt_receipt_no'";
                }
                $refund_reason = $obj->escapestring($row['24']);
                if($refund_reason!=''){
                    $sql .= ",refund_reason='$refund_reason'";
                }
                $refund_applied_date = $obj->escapestring($row['25']);
                if($refund_applied_date!=''){
                    $sql .= ",refund_applied_date='$refund_applied_date'";
                }
                $refund_commission_committed = $obj->escapestring($row['26']);
                if($refund_commission_committed!=''){
                    $sql .= ",refund_commission_committed='$refund_commission_committed'";
                }
                $refund_status = $obj->escapestring($row['27']);
                if($refund_status!=''){
                    $sql .= ",refund_status='$refund_status'";
                }
                $refund_payment_status = $obj->escapestring($row['28']);
                if($refund_payment_status!=''){
                    $sql .= ",refund_payment_status='$refund_payment_status'";
                }
                $refund_received_amount = $obj->escapestring($row['29']);
                if($refund_received_amount!=''){
                    $sql .= ",refund_received_amount='$refund_received_amount'";
                }
                $refund_comission_status = $obj->escapestring($row['30']);
                if($refund_comission_status!=''){
                    $sql .= ",refund_comission_status='$refund_comission_status'";
                }
                $refund_comission_received = $obj->escapestring($row['31']);
                if($refund_comission_received!=''){
                    $sql .= ",refund_comission_received='$refund_comission_received'";
                }
                $mode = $obj->escapestring($row['32']);
                if($mode!=''){
                    $sql .= ",mode='$mode'";
                }
                $travel_status = $obj->escapestring($row['33']);
                if($travel_status!=''){
                    $sql .= ",travel_status='$travel_status'";
                }
                // $video_shoot = $obj->escapestring($row['33']);
                // if($video_shoot!=''){
                //     $sql .= ",video_shoot='$video_shoot'";
                // }
            //     $sql1 = '';
            //     $travel_status = $obj->escapestring($row['34']);
            //     if($travel_status!=''){
                //         $sql1 .= "user_id='$user_id'";
                //         $sql1 .= ",type='4'";
                //         $sql1 .= ",travel_status='$travel_status'";
                //     }
                
                //     $get_as = $obj->query("select * from $tbl_student_noc where stu_id='$student_id'");
                //     $res_as=$obj->numRows($get_as);
                //     if($student_ids!='' && $res_s_count > 0){
            //     if ($res_as==0){
                //         $obj->query("insert into $tbl_student_noc set $sql1",-1);	
                //     }else{
                    //         $obj->query("UPDATE $tbl_student_noc set $sql1 where stu_id='$student_id'",-1);
                    //     }
                    // }
                    
                    $get_a = $obj->query("select * from $tbl_student_enrollment where stu_id='$student_id'");
                    $res_a=$obj->numRows($get_a);
                    if($student_ids!='' && $res_s_count > 0){
                        if ($res_a==0){
                            $obj->query("insert into $tbl_student_enrollment set $sql",-1);	
                }else{
                    $obj->query("UPDATE $tbl_student_enrollment set $sql where stu_id='$student_id'",-1);
                }
            }
            }
            $c++;
        }
        $_SESSION['sess_msg'] = 'CSV Uploaded Successfully...';
        header("location:add-filing-csv.php");
    }else{
        $_SESSION['sess_msg_error'] = 'Something wents wrong...';
        header("location:add-filing-csv.php");
    }
}

if(isset($_GET['delete_visa_sub_type'])){
    $id = $_GET['delete_visa_sub_type'];
    $obj->query("delete from $tbl_visa_sub_type where id='$id'",-1);
    $_SESSION['sess_msg']='Visa Sub Type deleted sucessfully';   
    header('location:manage-visa-sub-type.php');
}

if(isset($_POST['visa_type'])){
    $country_id = $_POST['country_id'];
    $visa_type = $_POST['visa_type'];
    $sql=$obj->query("select * from $tbl_visa_sub_type where 1=1 and country_id='$country_id' and visa_type='$visa_type'",$debug=-1);
    ?>
<option value="">Select Visa Sub Type</option>
<?php
	while($line=$obj->fetchNextObject($sql)){
    ?>
<option value="<?=$line->id?>"><?=$line->visa_sub_type?></option>
<?php
    }
}

if(isset($_POST['get_visa_sub_type'])){
    echo getField('registration_percentage',$tbl_visa_sub_type,$_POST['get_visa_sub_type']);
}

if(isset($_POST['change_visa_type'])){
    $visa_types = $_POST['change_visa_type'];
    $_SESSION['visa_type_session'] = $visa_types;
    // $id = $_POST['id'];
    // $type = $_POST['type'];
    // $visit_id = $_POST['visit_id'];
    //     $visa_type = " ,visa_type='".$visa_types."'";
    //     if($id != ''){
    //         $sql="UPDATE $tbl_visit_fee SET `status`='1',payment_type='$type',visit_id='$visit_id' $visa_type where id='$id'"; 
    //         $obj->query($sql);
    //         echo $id;
    //     }else{
    //         $sql="INSERT $tbl_visit_fee SET `status`='1',payment_type='$type',visit_id='$visit_id' $visa_type"; 
    //         $obj->query($sql);
    //         echo $obj->lastInsertedId();
    //     }
}

if(isset($_POST['change_counsellor_id'])){
    $id = $_POST['change_counsellor_id'];
    $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 and FIND_IN_SET($id, branch_id) order by name");
    while($clResult = $obj->fetchNextObject($clSql)){?>
<option value="<?php echo $clResult->id; ?>">
    <?php echo $clResult->name; ?></option>
<?php }
}
if(isset($_POST['change_management_member'])){
    $id = $_POST['change_management_member'];
    echo '<option value="">Select Management Member</option>';
    $clSql = $obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id in (1,19) and id not in (1,182,218) and branch_id and FIND_IN_SET(".$id.", branch_id)");
    while($clResult = $obj->fetchNextObject($clSql)){?>
<option value="<?php echo $clResult->id; ?>">
    <?php echo $clResult->name; ?></option>
<?php }
}

if(isset($_POST['chagne_refund_status_id'])){
    $id = $_POST['chagne_refund_status_id'];
    $obj->query("update $tbl_student set refund_status='".$_POST['status']."' where id='$id'",-1);
}

if(isset($_POST['update_remark'])){
    $remark = $_POST['remark'];
    $id = $_POST['id'];
    $obj->query("update $tbl_visit_fee set remark='$remark' where id='$id'",-1);
}

if(isset($_POST['update_remark1'])){
    $remark = $obj->escapestring($_POST['remark']);
    $id = $_POST['id'];
    $obj->query("update $tbl_profile_status set disapproved_remark='$remark' where id='$id'",-1);
}
if(isset($_POST['update_remark_of_affidavit'])){
    $remark = $obj->escapestring($_POST['remark']);
    $id = $_POST['id'];
    $obj->query("update $tbl_student set affidavit_remarks='$remark' where id='$id'",-1);
}
if(isset($_POST['update_remark_of_affidavit1'])){
    $remark = $obj->escapestring($_POST['remark']);
    $id = $_POST['id'];
    $obj->query("update $tbl_student set with_financial_affidavit_remark='$remark' where id='$id'",-1);
}

if(isset($_GET['delete_pass_noc'])){
    $id = $_GET['delete_pass_noc'];
    $type = $_GET['type'];
    $obj->query("delete from $tbl_student_passport_noc where stu_id='$id' and value='$type'",-1);
    header('location:student-editf.php?id='.base64_encode(base64_encode(base64_encode($id))));
}

if(isset($_GET['delete_filing_noc'])){
    $id = $_GET['delete_filing_noc'];
    $type = $_GET['type'];
    $obj->query("delete from $tbl_student_filing_noc where stu_id='$id' and value='$type'",-1);
    header('location:student-editf.php?id='.base64_encode(base64_encode(base64_encode($id))));
}
if(isset($_POST['change_remarks'])){
    $stu_id = $_POST['stu_id'];
    $data = [];
    $clSql = $obj->query("SELECT * FROM $tbl_student_application WHERE `stu_id` = '$stu_id' AND `status` = 'I-20 Received'",-1);
    while($line = $obj->fetchNextObject($clSql)){ 
        $data[] = getField('name','tbl_univercity',$line->college_name) != '' ?getField('name','tbl_univercity',$line->college_name) : $line->college_name;
    }
    echo implode('/ ',$data);
}
if(isset($_GET['change_level_id'])){
    $id = base64_decode(base64_decode(base64_decode($_GET['change_level_id'])));

    $sql = $obj->query("select * from $tbl_admin where id='$id'",-1); //die;
    $line = mysqli_fetch_assoc($sql);
    $_SESSION['sess_admin_id']=$line['id'];
    $_SESSION['sess_admin_username']=$line['username'];
    $_SESSION['level_id']=$line['level_id'];
    $_SESSION['additional_role']=$line['additional_role'];
   
    setcookie('mobile', $line['phone'], time() + (86400 * 30), "/"); 
    
  
        ms_redirect("welcome.php");     
}

if(isset($_GET['delete_stu_id'])){
    $id = base64_decode(base64_decode(base64_decode($_GET['delete_stu_id'])));
    $sql = $obj->query("delete from $tbl_student where id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_appointment where student_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_application where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_diploma where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_document where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_english_proficiency where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_enrollment where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_experience where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_found where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_noc where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_notes where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_passport_noc where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_relation where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_status where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_univercity_course where sutdent_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_updated_time where stu_id='$id'",-1); 
    $sql = $obj->query("delete from $tbl_student_work_experience where sutdent_id='$id'",-1);
    $_SESSION['success'] = 1;
    header('location:student-list.php');
}

if (isset($_POST['transfer'])) {
    $old_code = $_POST['old_ibt_code'];
    $new_code = $_POST['new_ibt_code'];
    $new_id = $_POST['new_id'];
    $obj->query("update $tbl_student set transfer_id='$old_code' where id='$new_id'",-1); 

    $sql = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$old_code'", -1);
    $line = $obj->fetchNextObject($sql);

    $sql2 = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$new_code'", -1);
    $line2 = $obj->fetchNextObject($sql2);

    $sql1 = $obj->query("SELECT * FROM $tbl_student_document WHERE stu_id = '{$line->id}'", -1);
    $file_uplaod = false;
    if($obj->numRows($sql1) > 0){
    while ($res = $obj->fetchNextObject($sql1)) {
        // $new_file = str_replace($old_code, $new_code, $res->name);
        // if (copy('uploads/' . $res->name, 'uploads/' . $new_file)) {
            $file_uplaod = $obj->query("INSERT INTO $tbl_student_document SET stu_id = '$new_id', dtype = '{$res->dtype}', `name` = '{$res->name}', `orgname` = '{$res->name}', user_id = '" . $_SESSION['sess_admin_id'] . "', desiredExt = '{$res->desiredExt}', transfer_status = 1", -1);
        // }
    }
    }else{
        $file_uplaod = true;
    }
    if($line->country_id == $line2->country_id && $file_uplaod){
        $sql3 = $obj->query("SELECT * FROM $tbl_student_application WHERE stu_id = '{$line->id}'", -1);
        while ($totald = $obj->fetchNextObject($sql3)) {
            if($totald->status == 'I-20 Received'){
                $status = 'I-20 Received(Old)';
            }else{
                $status = $totald->status;
            }
            $obj->query("insert into $tbl_student_application set stu_id='$new_id',college_name='".$totald->college_name."',location='".$totald->location."',course='".$totald->course."',month='".$totald->month."',year='".$totald->year."',status='$status',portal_status='".$totald->portal_status."',remarks='".$obj->escapestring($totald->remarks)."',user_id='".$totald->user_id."',parent_id='".$totald->parent_id."',cdate='".$totald->cdate."',portal_id='".$totald->portal_id."',university_id='".$totald->university_id."',university_pass='".$totald->university_pass."',transfer_status=1", -1);
        }

        $sql31 = $obj->query("SELECT * FROM $tbl_user_recovery WHERE student_id = '{$line->id}'", -1);
    while ($totald = $obj->fetchNextObject($sql31)) {
        $obj->query("insert into $tbl_user_recovery set student_id='$new_id',user_id='".$totald->user_id."',offical_email='".$totald->offical_email."',password='".$totald->password."',recovery_email='".$totald->recovery_email."',recovery_number='".$totald->recovery_number."',transfer_status=1", -1);
    }
    $obj->query("INSERT $tbl_student_noc SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$new_id',type=1,transfer_status=1");  
    $usql=$obj->query("select * from $tbl_filing_credentials where student_id='{$line->id}'",-1);//die();
    $res1=$obj->fetchNextObject($usql);
    $obj->query("INSERT INTO $tbl_filing_credentials SET `user_id`='{$_SESSION['sess_admin_id']}',`student_id`='$new_id',`cgi_user_id`='{$res1->cgi_user_id}',`cgi_password`='{$res1->cgi_password}',`cgi_email`='{$res1->cgi_email}',`email_password`='{$res1->email_password}',`recovery_email`='{$res1->recovery_email}',`recovery_number`='{$res1->recovery_number}',`security_answer`='{$res1->security_answer}',`ds_application_id`='{$res1->ds_application_id}',`status`='{$res1->status}',`pstatus`='{$res1->pstatus}',`savis_id`='{$res1->savis_id}',`savis_payment_status`='{$res1->savis_payment_status}',`university`='{$res1->university}',`ds_status`='{$res1->ds_status}',`gc_key`='{$res1->gc_key}',`gc_password`='{$res1->gc_password}',`gc_code`='{$res1->gc_code}',`security_question`='{$res1->security_question}',`recovery_question`='{$res1->recovery_question}',`recovery_annser`='{$res1->recovery_annser}',`transfer_status`='1'");  
}
    header('Location: student-editf.php?id=' . base64_encode(base64_encode(base64_encode($new_id))));
}

if(isset($_GET['transfer_undo'])){
    $new_id = $_GET['transfer_undo'];
    $result = $obj->query("SELECT name FROM $tbl_student_document WHERE stu_id='$new_id' and transfer_status=1", -1);
    while ($row = $obj->fetchNextObject($result)) {
        // $filePath = 'uploads/'.$row->name;
        // if (file_exists($filePath)) {
        //     unlink($filePath);
        // }
    }
    $sql = $obj->query("delete from $tbl_student_document where stu_id='$new_id' and transfer_status=1",-1); 
    $sql = $obj->query("delete from $tbl_student_application where stu_id='$new_id' and transfer_status=1",-1); 
    $sql = $obj->query("delete from $tbl_student_noc where stu_id='$new_id' and transfer_status=1",-1); 
    $sql = $obj->query("delete from $tbl_filing_credentials where student_id='$new_id' and transfer_status=1",-1); 
    $sql = $obj->query("delete from $tbl_user_recovery where student_id='$new_id' and transfer_status=1",-1); 
    if($sql){
        header('Location: student-editf.php?id=' . base64_encode(base64_encode(base64_encode($new_id))));
    }
}

if(isset($_POST['claim_id_btn'])){
    $id = $_POST['id'];
    $lead_id = $_POST['lead_id'];
    $sql = $obj->query("insert into $tbl_visit_claim set user_id='{$_SESSION['sess_admin_id']}',visit_id='$id',lead_id='$lead_id'",-1); 
    $sql = $obj->query("update $tbl_visit set claim_staus='1' where id='$id'",-1); 
    header('Location: visit-list.php');
}

if(isset($_POST['change_claim'])){
    $id = $_POST['change_claim'];
    $type = $_POST['type'];
    $user_id = $_POST['user_id'];
    $claim_id = $_POST['claim_id'];
    if($type == 'approve'){
        $sql = $obj->query("update $tbl_visit_claim set updated_by='{$_SESSION['sess_admin_id']}', status = 1 where id='$claim_id'",-1); 
        $sql = $obj->query("update $tbl_visit set claim_staus='2',telecaller_id='$user_id' where id='$id'",-1); 
        $sql_v= $obj->query("select * from $tbl_visit WHERE id='$id'"); 
        $visa =$obj->fetchNextObject($sql_v);
        $lead_id = getField('lead_id',$tbl_visit_claim,$claim_id);
        $sql = $obj->query("update $tbl_lead set applicant_alternate_no='".$visa->applicant_contact_no."' where lead_no='$lead_id'",-1); 
        $sql = $obj->query("update $tbl_student set crm_executive_id='$user_id' where alternate_contact='".$visa->applicant_contact_no."' or student_contact_no='".$visa->applicant_contact_no."' or alternate_contact='".$visa->applicant_alternate_no."' or student_contact_no='".$visa->applicant_alternate_no."'",-1); 
        echo 1;exit;
    }elseif($type == 'transfer'){
        $sql_v= $obj->query("select * from $tbl_visit WHERE id='$id'"); 
        $visa =$obj->fetchNextObject($sql_v);
        
        $sql=" crm_executive_id='$user_id',source='".$visa->source."'";
  
    $applicant_name=$obj->escapestring($visa->applicant_name);
    if($applicant_name!=''){
        $sql .= ",applicant_name='$applicant_name'";
    }
    $applicant_contact_no=$obj->escapestring($visa->applicant_contact_no);
    if($applicant_contact_no!=''){
        $sql .= ",applicant_contact_no='$applicant_contact_no'";
    }
    $applicant_alternate_no=$obj->escapestring($visa->applicant_alternate_no);
    if($applicant_alternate_no!=''){ 
        $sql .= ",applicant_alternate_no='$applicant_alternate_no'";
    }
    $state_id=$obj->escapestring($visa->state_id);
    if($state_id!=''){
        $sql .= ",state_id='$state_id'";
    }
    $city_id=$obj->escapestring($visa->city_id);
    if($city_id!='' && $city_id!=1000){
        $sql .= ",city_id='$city_id'";
    }
 
    $visa_type=$visa->visa_type;
    if($visa_type!=''){
        $sql .= ",visa_type='$visa_type'";
    }
    
    $pre_country_id=$visa->pre_country_id;
    if($pre_country_id!=''){
        $sql .= ",pre_country_id='$pre_country_id'";
    }

    $branch_id=$visa->branch_id;
    if($branch_id!=''){
        $sql .= ",branch_id='$branch_id'";
    }
    $sqls = $obj->query("select * from $tbl_lead where applicant_alternate_no='".$visa->applicant_contact_no."' or applicant_contact_no='".$visa->applicant_contact_no."' or applicant_alternate_no='".$visa->applicant_alternate_no."' or applicant_contact_no='".$visa->applicant_alternate_no."'",-1); 
    if($obj->numRows($sqls) == 0){
        $vN = $obj->query("select lead_no from $tbl_lead where 1=1 order by id desc");
        $vNum = $obj->numRows($vN);
        if($vNum>0){
            $Vresult = $obj->fetchNextObject($vN);
            $lead_no=$Vresult->lead_no+1;
        }else{
            $lead_no=10000;
        }

        $sql .= ",lead_no='$lead_no'";
    $obj->query("insert into $tbl_lead set $sql",-1); //die;
    $sql = $obj->query("update $tbl_student set crm_executive_id='$user_id' where alternate_contact='".$visa->applicant_contact_no."' or student_contact_no='".$visa->applicant_contact_no."' or alternate_contact='".$visa->applicant_alternate_no."' or student_contact_no='".$visa->applicant_alternate_no."'",-1); 
    $sql = $obj->query("update $tbl_visit_claim set updated_by='{$_SESSION['sess_admin_id']}', status = 1 where id='$claim_id'",-1); 
    $sql = $obj->query("update $tbl_visit set claim_staus='2',telecaller_id='$user_id' where id='$id'",-1); 
    echo 1;exit;
    }else{
        echo 2;exit;
    }
    }else{
        $sql = $obj->query("update $tbl_visit_claim set updated_by='{$_SESSION['sess_admin_id']}', status = 2 where id='$claim_id'",-1); 
        $sql = $obj->query("update $tbl_visit set claim_staus='0' where id='$id'",-1); 
        echo 1;exit;
    }
}

if(isset($_POST['change_review'])){
    $id = $_POST['id'];
    $sql = $obj->query("update $tbl_student set approve_review='1' where id='$id'",-1); 
    echo 1;exit;
}
if(isset($_POST['change_share_percentage'])){
    $val = $_POST['change_share_percentage'];
    $id = $_POST['id'];
    $branch_id = $_POST['branch_id'];
    $get = $obj->query("select * from $tbl_branch_franchise where branch_id='$branch_id' and visa_sub_type='$id'");
    if($obj->numRows($get) > 0){
        $sql = $obj->query("update $tbl_branch_franchise set bv_per='$val' where branch_id='$branch_id' and visa_sub_type='$id'",-1); 
    }else{
        $sql = $obj->query("insert $tbl_branch_franchise set branch_id='$branch_id',visa_sub_type='$id',bv_per='$val'",-1); 
    }
    // $sql = $obj->query("update $tbl_enrolled_fee set share_percentage='$val' where id='$id'",-1); 
    echo 1;exit;
}
if(isset($_POST['change_share_percentages'])){
    $val = $_POST['change_share_percentages'];
    $id = $_POST['id'];
    $branch_id = $_POST['branch_id'];
    $get = $obj->query("select * from $tbl_branch_franchise where branch_id='$branch_id' and visa_sub_type='$id'");
    if($obj->numRows($get) > 0){
        $sql = $obj->query("update $tbl_branch_franchise set av_per='$val' where branch_id='$branch_id' and visa_sub_type='$id'",-1); 
    }else{
        $sql = $obj->query("insert $tbl_branch_franchise set branch_id='$branch_id',visa_sub_type='$id',av_per='$val'",-1); 
    }
    // $sql = $obj->query("update $tbl_enrolled_fee set av_share_percentage='$val' where id='$id'",-1); 
    echo 1;exit;
}
if(isset($_POST['btn_submit_branch'])){
    $sql = $obj->query("update $tbl_branch set show_franchises='0'",-1); 
    foreach($_POST['branch_id'] as $res){
        $sql = $obj->query("update $tbl_branch set show_franchises='1' where id='$res'",-1); 
    }
    header('location:franchise-admin.php');
}
if(isset($_POST['note_home'])){
    $note_home= $obj->escapestring($_POST['note_home']);
    $student_note_home= $obj->escapestring($_POST['student_note_home']);
    $sql = $obj->query("update tbl_note set note='$note_home',student_note='$student_note_home'",-1); 
    echo 1;exit;
}

if(isset($_POST['country_wise_visa_subtype'])){
    foreach($_POST['country_wise_visa_subtype'] as $res){
        ?>
<h4>Choose <?=getField('name',$tbl_country,$res)?> Payment Type</h4>
<div class="row">
    <?php
            $stateSqls = $obj->query("select * from $tbl_visa_sub_type where country_id='$res'", -1);
            while($ress = $obj->fetchNextObject($stateSqls)){
            ?>
    <div class="col-md-4">
        <input type="checkbox" value="1" onchange="change_status(this, <?=$ress->id?>)" id="chechbox<?=$ress->id?>"
            <?=$ress->student_show == 1 ? 'checked' : ''?>>
        <label for="chechbox<?=$ress->id?>"><?=$ress->visa_sub_type?></label>
    </div>
    <?php } ?>
</div>
<?php
    }
}
if(isset($_POST['country_wise_visa_subtype1'])){
    foreach($_POST['country_wise_visa_subtype1'] as $res){
        ?>
<h4>Choose <?=getField('name',$tbl_country,$res)?> Payment Type</h4>
<div class="row">
    <?php
            $stateSqls = $obj->query("select * from $tbl_visa_sub_type where country_id='$res'", -1);
            while($ress = $obj->fetchNextObject($stateSqls)){
            ?>
    <div class="col-md-4">
        <input type="checkbox" value="1" onchange="change_status(this, <?=$ress->id?>)" id="chechbox<?=$ress->id?>"
            <?=$ress->enrollment_count == 1 ? 'checked' : ''?>>
        <label for="chechbox<?=$ress->id?>"><?=$ress->visa_sub_type?></label>
    </div>
    <?php } ?>
</div>
<?php
    }
}
if(isset($_POST['subtype_checkbox'])){
    $subtype_checkbox= $_POST['subtype_checkbox'];
    $id= $_POST['id'];
    $sql = $obj->query("update $tbl_visa_sub_type set student_show='$subtype_checkbox' where id='$id'",-1); 
    echo 1;exit;
}
if(isset($_POST['subtype_checkbox1'])){
    $subtype_checkbox= $_POST['subtype_checkbox1'];
    $id= $_POST['id'];
    $sql = $obj->query("update $tbl_visa_sub_type set enrollment_count='$subtype_checkbox' where id='$id'",-1); 
    echo 1;exit;
}
if(isset($_GET['event_delete_id'])){
    $id= $_GET['event_delete_id'];
    $sql = $obj->query("delete from $tbl_event  where id='$id'",-1); 
    $_SESSION['sess_msg']='Event Deleted sucessfully';  
    header('location:event-list.php'); 
}

if(isset($_POST['get_welcome_data'])){
    $get_f_welcome = $obj->query("select * from $tbl_welcome where id='".$_POST['get_welcome_data']."'");
    $res_f_welcome = $obj->fetchNextObject($get_f_welcome);
    ?>
<div class="table-wrap">
    <div class="table-responsive">
        <div class="student_filter application_filter">
            <form action="" id="welcome_call_form_submit<?=$res_f_welcome->id?>" method="post">
                <input type="hidden" name="submit_welcome" id="submit_welcome" value="yes">
                <input type="hidden" name="user_id" id="user_id" value="<?php print_r($_SESSION['sess_admin_id']); ?>">
                <input type="hidden" name="sutdent_id" id="sutdent_id" value="<?php echo $res_f_welcome->stu_id; ?>">
                <input type="hidden" name="welcome_id" id="welcome_id" value="<?=$res_f_welcome->id?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Date - Time
                                </div>
                                <input type="datetime-local" name="date_time" id="date_time_welcome"
                                    class="form-control required" value="<?=$res_f_welcome->date_time?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Call Status
                                </div>
                                <select name="call_status" id="call_status_welcome<?=$res_f_welcome->id?>"
                                    class="form-control form-select required"
                                    onchange="change_complete(this.value,'<?=$res_f_welcome->id?>')">
                                    <option value="">Select Call Status</option>
                                    <option value="Completed"
                                        <?=$res_f_welcome->call_status == 'Completed' ? 'selected' : ''?>>Completed
                                    </option>
                                    <option value="Not Completed"
                                        <?=$res_f_welcome->call_status == 'Not Completed' ? 'selected' : ''?>>Not
                                        Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="call_not_connect<?=$res_f_welcome->id?>" style="<?=$res_f_welcome->call_status == 'Completed' ? 'display:none' : ''?>">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <img src="uploads/<?=$res_f_welcome->call_screenshot?>" style="height:200px">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <img src="uploads/<?=$res_f_welcome->whatsapp_screenshot?>" style="height:200px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $w_style = '';
                        if($res_f_welcome->call_status == 'Not Completed'){
                        $w_style = 'style="display:none"';
                        }
                        // $message = explode(', ',$res_f_welcome->message);
                        $message = json_decode($res_f_welcome->message, true);
                        $cleaned_message = array();
                        foreach ($message as $key => $value) {
                            $cleaned_key = trim($key, "'");
                            $cleaned_value = is_string($value) ? trim($value, "'") : $value; 
                            $cleaned_message[$cleaned_key] = $cleaned_value;
                        }

                        $executive_remark = json_decode($res_f_welcome->executive_remark, true);
                        $cleaned_executive_remark = array();
                        foreach ($executive_remark as $key => $value) {
                            $cleaned_key = trim($key, "'");
                            $cleaned_value = is_string($value) ? trim($value, "'") : $value; 
                            $cleaned_executive_remark[$cleaned_key] = $cleaned_value;
                        }

                        $manager_remark = json_decode($res_f_welcome->manager_remark, true);
                        $cleaned_manager_remark = array();
                        foreach ($manager_remark as $key => $value) {
                            $cleaned_key = trim($key, "'");
                            $cleaned_value = is_string($value) ? trim($value, "'") : $value; 
                            $cleaned_manager_remark[$cleaned_key] = $cleaned_value;
                        }
                     ?>
                    <div class="col-md-12" id="welcome_complete<?=$res_f_welcome->id?>" <?=$w_style?>>
                        <table class="table table-bordered checklist-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Check List</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action Taken by Manager</th>
                                </tr>
                            </thead>
                            <tbody class="messages<?=$res_f_welcome->id?>">
                                <tr>
                                    <td>Payments Amount & Receipt Received</td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['Payments']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id')"
                                                    <?=$cleaned_message['Payments'] == 'Ok' ? 'checked' : ''; ?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['Payments']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id')"
                                                    <?=$cleaned_message['Payments'] == 'Not Ok' ? 'checked' : ''; ?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id<?=$res_f_welcome->id?>" name="remark_exe['Payments']"
                                            placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['Payments']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input" name="remark_manager['Payments']"
                                            placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['Payments'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['Payments']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>CRM Student Login Message Received
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['student_login']"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id1')"
                                                    value="Ok"
                                                    <?=$cleaned_message['student_login'] == 'Ok' ?'checked' : '' ;?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['student_login']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id1')"
                                                    <?=$cleaned_message['student_login'] == 'Not Ok' ? 'checked' : '' ;?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id1<?=$res_f_welcome->id?>"
                                            name="remark_exe['student_login']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['student_login']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input" name="remark_manager['student_login']"
                                            placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['student_login'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['student_login']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Location Preference Considered
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['location_preference']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id2')"
                                                    <?=$cleaned_message['location_preference'] == 'Ok' ? 'checked' : '' ;?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['location_preference']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id2')"
                                                    <?=$cleaned_message['location_preference'] == 'Not Ok' ? 'checked'  : '';?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id2<?=$res_f_welcome->id?>"
                                            name="remark_exe['location_preference']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['location_preference']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            name="remark_manager['location_preference']" placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['location_preference'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['location_preference']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>University Names Shared
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['university_allocation']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id3')"
                                                    <?=$cleaned_message['university_allocation'] == 'Ok' ?'checked'  : '';?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['university_allocation']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id3')"
                                                    <?=$cleaned_message['university_allocation'] == 'Not Ok' ? 'checked' : '' ;?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id3<?=$res_f_welcome->id?>"
                                            name="remark_exe['university_allocation']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['university_allocation']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            name="remark_manager['university_allocation']" placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['university_allocation'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['university_allocation']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Course Name Shared
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['course_allocation']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id4')"
                                                    required
                                                    <?=$cleaned_message['course_allocation'] == 'Ok' ? 'checked'  : '';?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['course_allocation']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id4')"
                                                    required
                                                    <?=$cleaned_message['course_allocation'] == 'Not Ok' ? 'checked'  : '';?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id4<?=$res_f_welcome->id?>"
                                            name="remark_exe['course_allocation']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['course_allocation']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            name="remark_manager['course_allocation']" placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['course_allocation'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['course_allocation']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sponser Clarification done
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['sponser_clarification']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id5')"
                                                    required
                                                    <?=$cleaned_message['sponser_clarification'] == 'Ok' ? 'checked'  : '';?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['sponser_clarification']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id5')"
                                                    required
                                                    <?=$cleaned_message['sponser_clarification'] == 'Not Ok' ? 'checked'  : '';?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id5<?=$res_f_welcome->id?>"
                                            name="remark_exe['sponser_clarification']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['sponser_clarification']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            name="remark_manager['sponser_clarification']" placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['sponser_clarification'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['sponser_clarification']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Intake commitment
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['intake_commitment']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id6')"
                                                    required
                                                    <?=$cleaned_message['intake_commitment'] == 'Ok' ? 'checked'  : '';?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['intake_commitment']" value="Not Ok"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id6')"
                                                    required
                                                    <?=$cleaned_message['intake_commitment'] == 'Not Ok' ? 'checked'  : '';?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id6<?=$res_f_welcome->id?>"
                                            name="remark_exe['intake_commitment']" placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['intake_commitment']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            name="remark_manager['intake_commitment']" placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['intake_commitment'] != 'Not Ok' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['intake_commitment']?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Any Consultation if require from Manbir Sir or Pardeep Sir
                                    </td>
                                    <td>
                                        <div class="checkbox-container">
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['Consultation']" value="Ok"
                                                    onchange="check_validation1(this,'<?=$res_f_welcome->id?>','remark_exe_id7')"
                                                    required
                                                    <?=$cleaned_message['Consultation'] == 'Ok' ? 'checked'  : '';?>>Yes
                                            </div>
                                            <div>
                                                <input type="radio" class="message<?=$res_f_welcome->id?>"
                                                    name="complete_feedback['Consultation']" value="None"
                                                    onchange="check_validation(this,'<?=$res_f_welcome->id?>','remark_exe_id7')"
                                                    required
                                                    <?=$cleaned_message['Consultation'] == 'None' ? 'checked'  : '';?>>No
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="text" class="remarks-input"
                                            id="remark_exe_id7<?=$res_f_welcome->id?>" name="remark_exe['Consultation']"
                                            placeholder="Enter Remarks"
                                            value="<?=$cleaned_executive_remark['Consultation']?>">
                                    </td>
                                    <td><input type="text" class="remarks-input" name="remark_manager['Consultation']"
                                            placeholder="Enter Remarks"
                                            <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 ? '' : 'disabled'?>
                                            <?=$cleaned_message['Consultation'] != 'None' ? 'style="display:none"'  : ''?>
                                            value="<?=$cleaned_manager_remark['Consultation']?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21){
                        ?>
                        <div class="col-md-12" style="display: flex;align-items: center;">
                            <div>
                                <p style="margin: auto;font-weight: bold;text-decoration: underline;">
                                    Counsellor
                                    Rating: </p>
                            </div>
                            <div class="rating" id="rating<?=$res_f_welcome->id?>">
                                <input type="radio" id="star5<?=$res_f_welcome->id?>" name="rating" value="5"
                                    <?=$res_f_welcome->rating == '5' ? 'checked' : ''?> />
                                <label class="star" for="star5<?=$res_f_welcome->id?>" title="Awesome"
                                    aria-hidden="true"></label>
                                <input type="radio" id="star4<?=$res_f_welcome->id?>" name="rating" value="4"
                                    <?=$res_f_welcome->rating == '4' ? 'checked' : ''?> />
                                <label class="star" for="star4<?=$res_f_welcome->id?>" title="Great"
                                    aria-hidden="true"></label>
                                <input type="radio" id="star3<?=$res_f_welcome->id?>" name="rating" value="3"
                                    <?=$res_f_welcome->rating == '3' ? 'checked' : ''?> />
                                <label class="star" for="star3<?=$res_f_welcome->id?>" title="Very good"
                                    aria-hidden="true"></label>
                                <input type="radio" id="star2<?=$res_f_welcome->id?>" name="rating" value="2"
                                    <?=$res_f_welcome->rating == '2' ? 'checked' : ''?> />
                                <label class="star" for="star2<?=$res_f_welcome->id?>" title="Good"
                                    aria-hidden="true"></label>
                                <input type="radio" id="star1<?=$res_f_welcome->id?>" name="rating" value="1"
                                    <?=$res_f_welcome->rating == '1' ? 'checked' : ''?> />
                                <label class="star" for="star1<?=$res_f_welcome->id?>" title="Bad"
                                    aria-hidden="true"></label>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    Remarks
                                </div>
                                <input type="text" name="remark" id="remark_welcome" class="form-control required"
                                    value="<?=$res_f_welcome->remark?>">
                            </div>
                        </div>
                        <span style="background: green;color: white;padding: 10px;border-radius: 10px;">Called
                            By :
                            <?php echo getField('name',$tbl_admin,$res_f_welcome->user_id); ?></span>
                    </div>
                </div>
                <!-- <button type="submit" class="btn btn-sm" style="margin-top: 10px;=">Submit</button> -->
                <?php
                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 9){
                ?>
                <button type="button" class="btn btn-sm" style="margin-top: 10px;"
                    onclick="submit_welcome_call(<?=$res_f_welcome->id?>)">Submit</button>
                <?php } ?>
            </form>
        </div>

    </div>
</div>
<?php
}

if(isset($_POST['change_city_status_id'])){
    $id = $_POST['change_city_status_id'];
    $status = $_POST['status'];
    $obj->query("update $tbl_location_cities set status='$status' where id='$id'") ;
}
if(isset($_POST['chagne_management_member_status'])){
    $id = $_POST['chagne_management_member_status'];
    $status = $_POST['status'];
    $obj->query("update $tbl_admin set management_member='$status' where id='$id'") ;
}

if(isset($_POST['btn_city_transfer'])){
    $new_city_id = $_POST['transfer_to'];
    foreach($_POST['city_id'] as $res){
        $obj->query("update $tbl_lead set city_id='$new_city_id' where city_id='$res'") ;
        $obj->query("update $tbl_visit set city_id='$new_city_id' where city_id='$res'") ;
        $obj->query("update $tbl_student set city_id='$new_city_id' where city_id='$res'") ;
    }

    $_SESSION['sess_msg'] = 'Lead, Visit, Students District updated successfully..';
    header("location:lead-city.php?transfer");
}
if(isset($_POST['btn_city_delete'])){
    foreach($_POST['city_id'] as $res){
        $obj->query("delete from $tbl_location_cities where id='$res'") ;
    }
    $_SESSION['sess_msg'] = 'Cities deleted successfully..';
    header("location:lead-city.php");
}

if(isset($_POST['check_lead_validation'])){
    if(in_array(4,$addtional_role)){
        echo 2; die;
    }
    $applicant_contact_no = $_POST['applicant_contact_no'];
    $applicant_alternate_no = $_POST['applicant_alternate_no'];
	if(isset($_POST['id'])){
        $sql = $obj->query("select id from $tbl_lead where id!='".$_REQUEST['id']."' and (applicant_contact_no in ('$applicant_contact_no','$applicant_alternate_no') OR applicant_alternate_no in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	}else{
        $sql = $obj->query("select id from $tbl_lead where (applicant_contact_no in ('$applicant_contact_no','$applicant_alternate_no') OR applicant_alternate_no in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	}
    
	$sql2 = $obj->query("select id from $tbl_visit where (applicant_contact_no in ('$applicant_contact_no','$applicant_alternate_no') OR applicant_alternate_no in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	$resultNum2 = $obj->numRows($sql2);
	$sql1 = $obj->query("select id from $tbl_student where (student_contact_no in ('$applicant_contact_no','$applicant_alternate_no') or alternate_contact in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	$resultNum1 = $obj->numRows($sql1);
	$resultNum = $obj->numRows($sql);
	if($resultNum>0){
		echo 1; die;
	}
	elseif($resultNum1>0){
		echo 1; die;
	}
	elseif($resultNum2>0){
		echo 1; die;
	}else{
		echo 2; die;
	}
}
if(isset($_POST['check_visit_validation'])){
    $applicant_contact_no = $_POST['applicant_contact_no'];
    $applicant_alternate_no = $_POST['applicant_alternate_no'];
 
	$sql2 = $obj->query("select id from $tbl_visit where (applicant_contact_no in ('$applicant_contact_no','$applicant_alternate_no') OR applicant_alternate_no in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	$resultNum2 = $obj->numRows($sql2);
	$sql1 = $obj->query("select id from $tbl_student where (student_contact_no in ('$applicant_contact_no','$applicant_alternate_no') or alternate_contact in ('$applicant_contact_no','$applicant_alternate_no'))",-1);
	$resultNum1 = $obj->numRows($sql1);
	if($resultNum1>0){
		echo 1; die;
	}
	elseif($resultNum2>0){
		echo 1; die;
	}else{
		echo 2; die;
	}
}

if(isset($_POST['get_student_modal'])){
    $id = $_POST['get_student_modal'];
    $branch_id = getField('branch_id',$tbl_student,$id);
    $get1 = $obj->query("select * from $tbl_student where id='$id'");
    $result1 = $obj->fetchNextObject($get1);
    $get = $obj->query("select * from $tbl_student where id='$id' and management_date='".date("Y-m-d")."'");
    $result = $obj->fetchNextObject($get);
    ?>
<div class="modal-body">
    <input type="hidden" class="form-control" name="id" required value="<?=$id?>">
    <div class="form-group">
        <label class="control-label mb-10">Select Member:</label>
        <select name="management_member" id="management_member" class="form-control" required>
            <option value="">Select Management Member</option>
            <?php
                        $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id in (1,19) and id not in (1,182,218,113) and branch_id and FIND_IN_SET(".$result1->branch_id.", branch_id) and management_member = 1",-1);
                        while($cresult=$obj->fetchNextObject($csql)){?>
            <option value="<?php echo $cresult->id ?>"
                <?=$cresult->id == $result->management_member ? 'selected' : ''?>>
                <?php echo $cresult->name; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label mb-10">Select Reason:</label>
        <select class="form-control" name="management_type" id="management_type" required>
            <option value="">Select Reason</option>
            <option value="Application" <?='Application' == $result->management_type ? 'selected' : ''?>>Application
            </option>
            <option value="Offer Letter" <?='Offer Letter' == $result->management_type ? 'selected' : ''?>>Offer Letter
            </option>
            <option value="Funds" <?='Funds' == $result->management_type ? 'selected' : ''?>>Funds</option>
            <option value="Filing" <?='Filing' == $result->management_type ? 'selected' : ''?>>Filing</option>
            <option value="Visa Outcome" <?='Visa Outcome' == $result->management_type ? 'selected' : ''?>>Visa Outcome
            </option>
            <option value="University Refund" <?='University Refund' == $result->management_type ? 'selected' : ''?>>
                University Refund</option>
            <option value="Student Refund" <?='Student Refund' == $result->management_type ? 'selected' : ''?>>Student
                Refund</option>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label mb-10">Remarks:</label>
        <input type="text" class="form-control" name="management_remark" id="management_remark"
            value="<?=$result->management_remark?>">
    </div>
</div>
<div class="modal-footer">
    <button type="submit" name="submit_student_management" class="btn btn-primary rounded">Submit</button>
</div>
<?php
}

if(isset($_POST['submit_student_management'])){
    $management_member = $obj->escapestring($_POST['management_member']);
    $management_remark = $obj->escapestring($_POST['management_remark']);
    $management_type = $obj->escapestring($_POST['management_type']);
    $id = $obj->escapestring($_POST['id']);
    $management_date = date("Y-m-d");

    $obj->query("update $tbl_student set management_member='$management_member',management_remark='$management_remark',management_type='$management_type',management_date='$management_date' where id='$id'");
    header('location:student-list.php');
}

if(isset($_GET['export_source_report'])){
// File to export data
$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }
if($_SESSION['whr1']!=''){
    $whr1 = $_SESSION['whr1'];
  }
$spreadsheet = new Spreadsheet();

// Set the active sheet to "Leads"
$sheet1 = $spreadsheet->setActiveSheetIndex(0);
$sheet1->setTitle('Leads');

// First, export tbl_lead source, total, and percentage data
$get = $obj->query("SELECT source, COUNT(*) as total FROM `$tbl_lead` WHERE date(cdate) > '2024-09-20' and source IS NOT NULL $whr GROUP BY source ORDER BY COUNT(*) DESC", -1);
$total_lead = $obj->numRows($obj->query("SELECT id FROM `$tbl_lead` WHERE 1=1 and date(cdate) > '2024-09-20'  $whr", -1)); // Total leads

// Set header row for "Leads" sheet
$sheet1->setCellValue('A1', 'Source Name');
$sheet1->setCellValue('B1', 'Total Leads');
$sheet1->setCellValue('C1', 'Percentage (%)');

// Fill data for "Leads" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get)) {
    $percentage_lead = number_format($res->total / $total_lead * 100, 2);
    $sheet1->setCellValue('A' . $row, $res->source);
    $sheet1->setCellValue('B' . $row, $res->total);
    $sheet1->setCellValue('C' . $row, $percentage_lead . ' %');
    $row++;
}

// Create second sheet for "Visits"
$spreadsheet->createSheet();
$sheet2 = $spreadsheet->setActiveSheetIndex(1);
$sheet2->setTitle('Visits');

// Next, export tbl_visit source, total, and percentage data
$get_visit = $obj->query("SELECT source, COUNT(*) as total FROM `$tbl_visit` WHERE date(cdate) > '2024-09-20' and source IS NOT NULL and status=1 and enquiry_type!='Re-apply' $whr GROUP BY source ORDER BY COUNT(*) DESC", -1);
$total_visit = $obj->numRows($obj->query("SELECT id FROM `$tbl_visit` where 1=1 and status=1 and enquiry_type!='Re-apply' and date(cdate) > '2024-09-20' $whr", -1)); // Total visits

// Set header row for "Visits" sheet
$sheet2->setCellValue('A1', 'Source Name');
$sheet2->setCellValue('B1', 'Total Visits');
$sheet2->setCellValue('C1', 'Percentage (%)');

// Fill data for "Visits" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get_visit)) {
    $percentage_visit = number_format($res->total / $total_visit * 100, 2);
    $sheet2->setCellValue('A' . $row, $res->source);
    $sheet2->setCellValue('B' . $row, $res->total);
    $sheet2->setCellValue('C' . $row, $percentage_visit . ' %');
    $row++;
}

// Create third sheet for "Enrollments"
$spreadsheet->createSheet();
$sheet3 = $spreadsheet->setActiveSheetIndex(2);
$sheet3->setTitle('Enrollments');

// Finally, export tbl_visit where status=0 (enrollment) source, total, and percentage data
$get_enrollment = $obj->query("SELECT a.source, COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE date(a.cdate) > '2024-09-20' and a.status=0 AND a.source IS NOT NULL $whr1 $condition_of_visa_sub_type GROUP BY a.source ORDER BY COUNT(a.id) DESC", -1);
$total_enrollment = $obj->numRows($obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE date(a.cdate) > '2024-09-20' and a.status=0 $condition_of_visa_sub_type $whr1", -1)); // Total enrollments

// Set header row for "Enrollments" sheet
$sheet3->setCellValue('A1', 'Source Name');
$sheet3->setCellValue('B1', 'Total Enrollments');
$sheet3->setCellValue('C1', 'Percentage (%)');

// Fill data for "Enrollments" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get_enrollment)) {
    $percentage_enrollment = number_format($res->total / $total_enrollment * 100, 2);
    $sheet3->setCellValue('A' . $row, $res->source);
    $sheet3->setCellValue('B' . $row, $res->total);
    $sheet3->setCellValue('C' . $row, $percentage_enrollment . ' %');
    $row++;
}

// Set the first sheet as active again
$spreadsheet->setActiveSheetIndex(0);

// Save the Excel file to the output
$writer = new Xlsx($spreadsheet);
$filename = 'export_source_data.xlsx';

// Output headers to prompt the user for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write the file to output
$writer->save('php://output');

}

/////////////////////////////////////////////////////////////////////////////LOCATION REPORT////////////////////////////////////////////////////////
if(isset($_GET['export_location_report'])){
// File to export data
$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
if($_SESSION['whr']!=''){
    $whr = $_SESSION['whr'];
  }
if($_SESSION['whr1']!=''){
    $whr1 = $_SESSION['whr1'];
  }
$spreadsheet = new Spreadsheet();

// Set the active sheet to "Leads"
$sheet1 = $spreadsheet->setActiveSheetIndex(0);
$sheet1->setTitle('Leads');

// First, export tbl_lead source, total, and percentage data
$get = $obj->query("SELECT city_id, COUNT(*) as total FROM `$tbl_lead` WHERE city_id IS NOT NULL $whr GROUP BY city_id ORDER BY COUNT(*) DESC", -1);
$total_lead = $obj->numRows($obj->query("SELECT id FROM `$tbl_lead` WHERE 1=1 and city_id IS NOT NULL $whr", -1)); // Total leads

// Set header row for "Leads" sheet
$sheet1->setCellValue('A1', 'District Name');
$sheet1->setCellValue('B1', 'Total Leads');
$sheet1->setCellValue('C1', 'Percentage (%)');

// Fill data for "Leads" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get)) {
    $percentage_lead = number_format($res->total / $total_lead * 100, 2);
    $sheet1->setCellValue('A' . $row, getField('name', $tbl_location_cities, $res->city_id));
    $sheet1->setCellValue('B' . $row, $res->total);
    $sheet1->setCellValue('C' . $row, $percentage_lead . ' %');
    $row++;
}

// Create second sheet for "Visits"
$spreadsheet->createSheet();
$sheet2 = $spreadsheet->setActiveSheetIndex(1);
$sheet2->setTitle('Visits');

// Next, export tbl_visit source, total, and percentage data
$get_visit = $obj->query("SELECT city_id, COUNT(*) as total FROM `$tbl_visit` WHERE city_id IS NOT NULL and status=1 and enquiry_type!='Re-apply' $whr GROUP BY city_id ORDER BY COUNT(*) DESC", -1);
$total_visit = $obj->numRows($obj->query("SELECT id FROM `$tbl_visit` where 1=1 and status=1 and enquiry_type!='Re-apply' and city_id IS NOT NULL $whr", -1)); // Total visits

// Set header row for "Visits" sheet
$sheet2->setCellValue('A1', 'District Name');
$sheet2->setCellValue('B1', 'Total Visits');
$sheet2->setCellValue('C1', 'Percentage (%)');

// Fill data for "Visits" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get_visit)) {
    $percentage_visit = number_format($res->total / $total_visit * 100, 2);
    $sheet2->setCellValue('A' . $row, getField('name', $tbl_location_cities, $res->city_id));
    $sheet2->setCellValue('B' . $row, $res->total);
    $sheet2->setCellValue('C' . $row, $percentage_visit . ' %');
    $row++;
}

// Create third sheet for "Enrollments"
$spreadsheet->createSheet();
$sheet3 = $spreadsheet->setActiveSheetIndex(2);
$sheet3->setTitle('Enrollments');

// Finally, export tbl_visit where status=0 (enrollment) source, total, and percentage data
// $get_enrollment = $obj->query("SELECT city_id, COUNT(*) as total FROM `$tbl_student` WHERE  city_id IS NOT NULL $whr $condition_of_visa_sub_type GROUP BY city_id ORDER BY COUNT(*) DESC", -1);
// $total_enrollment = $obj->numRows($obj->query("SELECT id FROM `$tbl_student` WHERE 1=1 and city_id IS NOT NULL $whr $condition_of_visa_sub_type", -1)); // Total enrollments

$get_enrollment = $obj->query("SELECT a.city_id, COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE  a.status=0 AND a.source IS NOT NULL $whr1 $condition_of_visa_sub_type GROUP BY a.city_id ORDER BY COUNT(a.id) DESC", -1);
$total_enrollment = $obj->numRows($obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE a.status=0 $condition_of_visa_sub_type $whr1", -1)); // Total enrollments

// Set header row for "Enrollments" sheet
$sheet3->setCellValue('A1', 'District Name');
$sheet3->setCellValue('B1', 'Total Enrollments');
$sheet3->setCellValue('C1', 'Percentage (%)');

// Fill data for "Enrollments" sheet
$row = 2;
while ($res = $obj->fetchNextObject($get_enrollment)) {
    $percentage_enrollment = number_format($res->total / $total_enrollment * 100, 2);
    $sheet3->setCellValue('A' . $row, getField('name', $tbl_location_cities, $res->city_id));
    $sheet3->setCellValue('B' . $row, $res->total);
    $sheet3->setCellValue('C' . $row, $percentage_enrollment . ' %');
    $row++;
}

// Set the first sheet as active again
$spreadsheet->setActiveSheetIndex(0);

// Save the Excel file to the output
$writer = new Xlsx($spreadsheet);
$filename = 'export_city_data.xlsx';

// Output headers to prompt the user for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write the file to output
$writer->save('php://output');

}


if(isset($_GET['bypass'])){
    $id = base64_decode(base64_decode(base64_decode($_GET['bypass'])));
    $value=$_GET['value'];
    $obj->query("INSERT $tbl_student_filing_noc SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$id',`value`='$value',`status`=2");
    header('location:student-editf.php?id='.$_GET['bypass']);
    exit();
} 

if(isset($_GET['changeDisplayOrder'])){
	$obj->query("update $tbl_stage set displayorder='".$_REQUEST['ival']."' where id ='".$_REQUEST['changeDisplayOrder']."'",-1);
	echo 1; die;
}

if(isset($_POST['get_team_member'])){
    $level = explode(',',$_POST['get_team_member']);
    $users = explode(',',$_POST['users']);
    $branch_id = $_POST['branch_id'];
    echo "<option value=''>Select Team Member</option>";
    foreach($level as $level_id){
        $get = $obj->query("select * from $tbl_support_user where level_id='$level_id' and find_in_set('$branch_id',branch_id) and status=1",-1);
        while($res = $obj->fetchNextObject($get)){
            ?><option value='<?=$res->id?>' <?=in_array($res->id, $users) ? 'selected' : ''?>><?=$res->name?>
    (<?=get_user_role($res->level_id, $res->director)?>) </option>
<?php
        }
    }
}
if(isset($_POST['change_type'])){
    $change_type = $_POST['change_type'];
    if($change_type == 2){
        $visa_type = 'Tourist';
        $type='Case';
    }
    elseif($change_type == 1){
        $visa_type = 'Study';
        $type='Student';
    }
    elseif($change_type == 4){
        $visa_type = 'Work';
        $type='Student';
    }
    elseif($change_type == 3){
        $visa_type = 'Visitor';
        $type='Case';
    }
    elseif($change_type == 5){
        $visa_type = 'Spouse';
        $type='Case';
    }
    ?>
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon"><?=$type?> Type</div>
        <select class="required form-control" name="student_type" id="student_type"
            onchange="change_uk_premium(this.value)">
            <option value="">Select <?=$type?> Type</option>
            <?php
                $clSql = $obj->query("select * from $tbl_visa_sub_type where country_id='{$_POST['country_id']}' and visa_type = '$visa_type'");
          
    while($clResult = $obj->fetchNextObject($clSql)){
        ?>
            <option value="<?php echo $clResult->id; ?>">
                <?php echo $clResult->visa_sub_type?>
            </option>
            <?php
    }
    ?>
        </select>
    </div>
</div>
<?php
}


if(isset($_POST['insentive_branch_id'])){
    $get = $obj->query("select * from $tbl_branch_incentive WHERE `branch_id`='{$_POST['insentive_branch_id']}'");
    $res = $obj->fetchNextObject($get);
    ?>
<div class="row">
    <button type="button" class="add_insentive btn btn-primary mt-15" style="float: right;margin-right: 30px;">Add Row
        +</button>
</div>
<div id="insentive_div">
    <div class="row mt-20">
        <div class="col-md-1">
            Type
        </div>
        <div class="col-md-2">
            From Month
        </div>
        <div class="col-md-2">
            To Month
        </div>
        <div class="col-md-1">
            From
        </div>
        <div class="col-md-1">
            To
        </div>
        <div class="col-md-1">
            Zone Name
        </div>
        <div class="col-md-1">
            Amount
        </div>
        <div class="col-md-1">
            Eligible
        </div>
        <div class="col-md-1">
            Bonus
        </div>
    </div>

    <?php
    $get = $obj->query("select * from $tbl_branch_incentive WHERE `branch_id`='{$_POST['insentive_branch_id']}'");
    if($obj->numRows($get)){
        $c = 1; 
    while($res = $obj->fetchNextObject($get)){
        if($res->type == 'Counsellor'){
            $eligible_for_bonus = $res->eligible_for_bonus;
            $bonus = $res->bonus;
        }elseif($res->type == 'CRM'){
            $eligible_for_bonus = $res->crm_eligible_for_bonus;
            $bonus = $res->crm_bonus;
        }elseif($res->type == 'CRM Visit'){
            $eligible_for_bonus = $res->crm_visit_eligible_for_bonus;
            $bonus = $res->crm_visit_bonus;
        }
    ?>
    <div class="row <?=$c != 1 ? 'mt-20' : ''?>">
        <div class="col-md-1">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Type</option>
                <option value="Counsellor" <?=$res->type == 'Counsellor' ? 'selected' : ''?>>Counsellor</option>
                <option value="CRM" <?=$res->type == 'CRM' ? 'selected' : ''?>>CRM</option>
                <option value="CRM Visit" <?=$res->type == 'CRM Visit' ? 'selected' : ''?>>CRM Visit</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_from[]" class="form-control form-select" required>
                <option value="">From Month</option>
                <option value="1" <?=$res->month_from == 1 ? 'selected' : ''?>>January</option>
                <option value="2" <?=$res->month_from == 2 ? 'selected' : ''?>>February</option>
                <option value="3" <?=$res->month_from == 3 ? 'selected' : ''?>>March</option>
                <option value="4" <?=$res->month_from == 4 ? 'selected' : ''?>>April</option>
                <option value="5" <?=$res->month_from == 5 ? 'selected' : ''?>>May</option>
                <option value="6" <?=$res->month_from == 6 ? 'selected' : ''?>>June</option>
                <option value="7" <?=$res->month_from == 7 ? 'selected' : ''?>>July</option>
                <option value="8" <?=$res->month_from == 8 ? 'selected' : ''?>>August</option>
                <option value="9" <?=$res->month_from == 9 ? 'selected' : ''?>>September</option>
                <option value="10" <?=$res->month_from == 10 ? 'selected' : ''?>>October</option>
                <option value="11" <?=$res->month_from == 11 ? 'selected' : ''?>>November</option>
                <option value="12" <?=$res->month_from == 12 ? 'selected' : ''?>>December</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_to[]" class="form-control form-select" required>
                <option value="">To Month</option>
                <option value="1" <?=$res->month_to == 1 ? 'selected' : ''?>>January</option>
                <option value="2" <?=$res->month_to == 2 ? 'selected' : ''?>>February</option>
                <option value="3" <?=$res->month_to == 3 ? 'selected' : ''?>>March</option>
                <option value="4" <?=$res->month_to == 4 ? 'selected' : ''?>>April</option>
                <option value="5" <?=$res->month_to == 5 ? 'selected' : ''?>>May</option>
                <option value="6" <?=$res->month_to == 6 ? 'selected' : ''?>>June</option>
                <option value="7" <?=$res->month_to == 7 ? 'selected' : ''?>>July</option>
                <option value="8" <?=$res->month_to == 8 ? 'selected' : ''?>>August</option>
                <option value="9" <?=$res->month_to == 9 ? 'selected' : ''?>>September</option>
                <option value="10" <?=$res->month_to == 10 ? 'selected' : ''?>>October</option>
                <option value="11" <?=$res->month_to == 11 ? 'selected' : ''?>>November</option>
                <option value="12" <?=$res->month_to == 12 ? 'selected' : ''?>>December</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_from[]" placeholder="From" class="form-control"
                value="<?=$res->enrollment_from?>" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_to[]" placeholder="To" class="form-control"
                value="<?=$res->enrollment_to?>" required>
        </div>
        <div class="col-md-1">
            <input type="text" name="zone[]" placeholder="Zone Name" class="form-control" value="<?=$res->zone?>"
                required>
        </div>
        <div class="col-md-1">
            <input type="number" name="amount[]" placeholder="Amount" class="form-control" value="<?=$res->amount?>"
                required>
        </div>
        <div class="col-md-1">
            <input type="number" name="eligible_for_bonus[]" placeholder="Eligible" class="form-control"
                value="<?=$eligible_for_bonus?>" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="bonus[]" placeholder="Bonus" class="form-control" value="<?=$bonus?>" required>
        </div>
        <div class="col-md-1">
            <a href="#" class="remove_field">X</a>
        </div>
    </div>
    <?php $c++; } }else{
    ?>
    <div class="row">
        <div class="col-md-1">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Type</option>
                <option value="Counsellor">Counsellor</option>
                <option value="CRM">CRM</option>
                <option value="CRM Visit">CRM Visit</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_from[]" class="form-control form-select" required>
                <option value="">From Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_to[]" class="form-control form-select" required>
                <option value="">To Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_from[]" placeholder="From" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_to[]" placeholder="To" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="text" name="zone[]" placeholder="Zone Name" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="amount[]" placeholder="Amount" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="eligible_for_bonus[]" placeholder="Eligible" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="bonus[]" placeholder="Bonus" class="form-control" required>
        </div>
        <div class="col-md-1">

        </div>
    </div>
    <?php

    } ?>
</div>

<script>
var addButtonns = $('.add_insentive');
var wrapperrs = $('#insentive_div');
$(addButtonns).click(function() {
    $(wrapperrs).append(
        `    <div class="row mt-20">
        <div class="col-md-1">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Type</option>
                <option value="Counsellor">Counsellor</option>
                <option value="CRM">CRM</option>
                <option value="CRM Visit">CRM Visit</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_from[]" class="form-control form-select" required>
                <option value="">From Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="month_to[]" class="form-control form-select" required>
                <option value="">To Month</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_from[]" placeholder="From" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="enrollment_to[]" placeholder="To" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="text" name="zone[]" placeholder="Zone Name" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="amount[]" placeholder="Amount" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="eligible_for_bonus[]" placeholder="Eligible" class="form-control" required>
        </div>
        <div class="col-md-1">
            <input type="number" name="bonus[]" placeholder="Bonus" class="form-control" required>
        </div>
         <div class="col-md-1">
            <a href="#" class="remove_field">X</a>
         </div>
    </div>`
    );
});
$(wrapperrs).on('click', '.remove_field', function(e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});
</script>
<?php
}

if(isset($_POST['insentive_submit'])){

    extract($_POST);
    $obj->query("DELETE FROM $tbl_branch_incentive WHERE `branch_id`='$branch_id'");
    echo '<pre>';
    foreach($type as $key => $res){
        $eligible_for_bonuss = '';
        $bonuss = '';
        if ($res === 'Counsellor') {
            $eligible_for_bonuss = ", eligible_for_bonus = '{$eligible_for_bonus[$key]}'";
            $bonuss = ", bonus = '{$bonus[$key]}'";
        } elseif ($res === 'CRM') {
            $eligible_for_bonuss = ", crm_eligible_for_bonus = '{$eligible_for_bonus[$key]}'";
            $bonuss = ", crm_bonus = '{$bonus[$key]}'";
        } elseif ($res === 'CRM Visit') {
            $eligible_for_bonuss = ", crm_visit_eligible_for_bonus = '{$eligible_for_bonus[$key]}'";
            $bonuss = ", crm_visit_bonus = '{$bonus[$key]}'";
        }
        $obj->query("INSERT $tbl_branch_incentive SET `user_id`='{$_SESSION['sess_admin_id']}',`branch_id`='$branch_id',`type`='$res',`month_from`='{$month_from[$key]}',`month_to`='{$month_to[$key]}',`enrollment_from`='{$enrollment_from[$key]}',`enrollment_to`='{$enrollment_to[$key]}',`zone`='{$zone[$key]}',`amount`='{$amount[$key]}' $eligible_for_bonuss $bonuss");
    }
    $_SESSION['sess_msg']='Insentive added sucessfully';
    header('location:branch-list.php');
}
if(isset($_POST['change_second_noc_required'])){

        $stu_id = $_POST['change_second_noc_required'];
       $get = $obj->query("SELECT * from $tbl_second_filing_request WHERE `stu_id`='$stu_id'");
        if($obj->numRows($get) == 0){
        $obj->query("INSERT $tbl_second_filing_request SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$stu_id',status=1");
         }else{
            $obj->query("UPDATE $tbl_second_filing_request SET `user_id`='{$_SESSION['sess_admin_id']}',status=1 where `stu_id`='$stu_id'");
        }
        echo 1;
}
if(isset($_POST['change_second_noc_required_no'])){

        $stu_id = $_POST['change_second_noc_required_no'];
       $get = $obj->query("SELECT * from $tbl_second_filing_request WHERE `stu_id`='$stu_id'");
        if($obj->numRows($get) == 0){
        $obj->query("INSERT $tbl_second_filing_request SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$stu_id',status=0");
         }else{
            $obj->query("UPDATE $tbl_second_filing_request SET `user_id`='{$_SESSION['sess_admin_id']}',status=0 where `stu_id`='$stu_id'");
        }
        echo 1;
    }
    
if(isset($_POST['change_visit_status'])){
    $id = $_POST['change_visit_status'];
    $status= $_POST['status'];
    $obj->query("UPDATE $tbl_file SET for_student_view='$status' where `id`='$id'");
}
if(isset($_POST['chage_login_status'])){
    $id = getField('student_no',$tbl_student,$_POST['chage_login_status']);
    $status= $_POST['status'];
    $obj->query("UPDATE $tbl_student SET student_login='$status' where `student_no`='$id'");
}
if(isset($_POST['get_user_detail'])){
    $id = $_POST['get_user_detail'];
    $img = getField('img',$tbl_support_user,$id);
    ?>
<style>
.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-border {
    display: inline-block;
    position: relative;
    padding: 10px;
    background-image: url('img/side.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-radius: 10px;
}

.image-border img {
    display: block;
}
</style>
<table class="table table-bordered">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Department</th>
        <th>Number</th>
        <th>Email</th>
    </tr>
    <tr>
        <th><?php if($img!= ''){ ?><a href="javascript:void" class="image-border"><img src="uploads/<?=$img?>"
                    height="100px" loading="lazy"></a> <?php } ?></th>
        <th><?=getField('name',$tbl_support_user,$id)?></th>
        <th><?=getField('name',$tbl_department,getField('designation',$tbl_support_user,$id))?></th>
        <th> <a href="tel:<?=getField('phone',$tbl_support_user,$id)?>"><?=getField('phone',$tbl_support_user,$id)?></a>
        </th>
        <th> <a
                href="mailto:<?=getField('email',$tbl_support_user,$id)?>"><?=getField('email',$tbl_support_user,$id)?></a>
        </th>
    </tr>
</table>
<?php
}


if(isset($_POST['get_module_request'])){
    $gets = $obj->query("select * from $tbl_request_module WHERE `unique_no`='{$_POST['get_module_request']}'");
    $ress = $obj->fetchNextObject($gets);
    ?>
<div class="row" style="padding:20px">
    <div class="col-md-12">
        <input type="hidden" name="unique_no" value="<?=$_POST['get_module_request']?>" required>
        <input type="text" name="request_module" placeholder="Request Module Name" class="form-control"
            value="<?=isset($ress->request_module) ? $ress->request_module : ''?>" required>
    </div>
</div>
<div class="row">
    <button type="button" class="add_insentive btn btn-primary mt-15" style="float: right;margin-right: 30px;">Add Row
        +</button>
</div>

<div id="insentive_div">
    <div class="col-md-1">

    </div>
    <div class="row mt-20">
        <div class="col-md-5">
            Field Name
        </div>
        <div class="col-md-5">
            Field Type
        </div>
    </div>



    <?php
    if($_POST['get_module_request'] == ''){
        ?>
    <div class="row">
        <div class="col-md-1">

        </div>
        <div class="col-md-5">
            <input type="text" name="feild_name[]" placeholder="Field Name" class="form-control" required>
        </div>
        <div class="col-md-5">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Field Type</option>
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="date">Date</option>
                <option value="file">File</option>
                <option value="url">Url</option>
            </select>
        </div>
        <div class="col-md-1">

        </div>
    </div>
    <?php
    }else{
        $get = $obj->query("select * from $tbl_request_module WHERE `unique_no`='{$_POST['get_module_request']}'");
        while($res = $obj->fetchNextObject($get)){
            ?>
    <div class="row mt-20">
        <div class="col-md-1">

        </div>
        <div class="col-md-5">
            <input type="text" name="feild_name[]" placeholder="Field Name" class="form-control"
                value="<?=$res->feild_name?>" required>
        </div>
        <div class="col-md-5">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Field Type</option>
                <option value="text" <?=$res->type == 'text' ? 'selected' : ''?>>Text</option>
                <option value="number" <?=$res->type == 'number' ? 'selected' : ''?>>Number</option>
                <option value="email" <?=$res->type == 'email' ? 'selected' : ''?>>Email</option>
                <option value="date" <?=$res->type == 'date' ? 'selected' : ''?>>Date</option>
                <option value="file" <?=$res->type == 'file' ? 'selected' : ''?>>File</option>
                <option value="url" <?=$res->type == 'url' ? 'selected' : ''?>>Url</option>
            </select>
        </div>
        <div class="col-md-1">

        </div>
    </div>
    <?php
        }
    }
    ?>
</div>
<button class="btn btn-primary" type="submit" style="margin: 15px 55px;" name="btn_request_module">Submit</button>
<div class="row mt-20"></div>
<script>
var addButtonns = $('.add_insentive');
var wrapperrs = $('#insentive_div');
$(addButtonns).click(function() {
    $(wrapperrs).append(
        `     <div class="row mt-20">
        <div class="col-md-1">

        </div>
        <div class="col-md-5">
            <input type="text" name="feild_name[]" placeholder="Field Name" class="form-control" required>
        </div>
        <div class="col-md-5">
            <select name="type[]" class="form-control form-select" required>
                <option value="">Select Field Type</option>
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="date">Date</option>
                <option value="file">File</option>
                <option value="url">Url</option>
            </select>
        </div>
        <div class="col-md-1">
             <a href="#" class="remove_field">X</a>
        </div>
    </div>`
    );
});
$(wrapperrs).on('click', '.remove_field', function(e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});
</script>
<?php
}

if(isset($_POST['btn_request_module'])){
    extract($_POST);
    if($unique_no == ''){
        $rand = rand(10, 99999);
        foreach($feild_name as $key=>$res){
            $obj->query("INSERT $tbl_request_module SET `unique_no`='$rand',`request_module`='$request_module',feild_name='$res',type='{$type[$key]}',`required`=1");
        }
        $_SESSION['sess_msg']='Request Module added sucessfully';
    }else{
        $rand = $unique_no;
        $obj->query("DELETE FROM $tbl_request_module WHERE `unique_no`='$rand'");
        foreach($feild_name as $key=>$res){
            $obj->query("INSERT $tbl_request_module SET `unique_no`='$rand',`request_module`='$request_module',feild_name='$res',type='{$type[$key]}',`required`=1");
        }
        $_SESSION['sess_msg']='Request Module updated sucessfully';
    }

    header('location:request-module-field.php');
}

if(isset($_GET['request_module_delete'])){
    extract($_GET);
        $obj->query("DELETE FROM $tbl_request_module WHERE `unique_no`='$request_module_delete'");
        $_SESSION['sess_msg']='Request Module deleted sucessfully';
        header('location:request-module-field.php');
}
if(isset($_GET['department_del_id'])){
    extract($_GET);
        $obj->query("DELETE FROM $tbl_department WHERE `id`='$department_del_id'");
        $_SESSION['sess_msg']='Department deleted sucessfully';
        header('location:department-list.php');
}
if(isset($_POST['chagnedisplayOrderSupportUser'])){
    extract($_POST);
        $obj->query("UPDATE  $tbl_support_user set display_order='$val' WHERE `id`='$chagnedisplayOrderSupportUser'");
}
if(isset($_POST['chagnedisplayOrderdepartment'])){
    extract($_POST);
        $obj->query("UPDATE  $tbl_department set displayorder='$val' WHERE `id`='$chagnedisplayOrderdepartment'");
    }
    
    if(isset($_POST['send_requirement_requests'])){
        $request = $obj->escapestring($_POST['request']);
        $request_remark = $obj->escapestring($_POST['request_remark']);
        $university = $obj->escapestring($_POST['university']);
        $stu_id = base64_decode(base64_decode(base64_decode($_POST['ids'])));
        $user_id = $_SESSION['sess_admin_id'];
        $send_by_level = $_SESSION['level_id'];
        $obj->query("INSERT $tbl_student_request set user_id='$user_id', stu_id='$stu_id',university='$university', request='$request',request_remark='$request_remark'");
        $requirement_id = $obj->lastInsertedId();
        $res = $obj->fetchNextObject($obj->query("select * from $tbl_request_module where 1=1 and unique_no='{$request}'"));
        $message = $res->request_module;
        $visible_by = date("Y-m-d", strtotime("+50 years"));
        $obj->query("INSERT $tbl_requirement_notification set send_by='$user_id', send_by_level='$send_by_level',stu_id='$stu_id', requirement_id='$requirement_id',`message`='$message',visible_by='$visible_by'");
        header("location:student-editf.php?id=".$_POST['ids'].'&request');
        exit();
}
if(isset($_POST['add_response'])){
    $id = $_POST['add_response'];
    $unique_no = getField("request", 'tbl_student_request', $id);
    ?>
<form action="controller.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$_POST['add_response']?>">
    <div class="row">
        <?php
		$sql=$obj->query("select * from tbl_request_module where 1=1 and unique_no='$unique_no'",$debug=-1);
		while($line=$obj->fetchNextObject($sql)){
    ?>
        <div class="col-md-4">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon"><?=$line->feild_name?></div>
                    <input type="<?=$line->type?>" class="form-control" placeholder="<?=$line->feild_name?>"
                        name="response[]" style="line-height: normal;pointer-events: all;" required>
                    <input type="hidden" value=" <?=$line->feild_name?>" name="feild_name[]" required>
                    <input type="hidden" value="<?=$line->type?>" name="type[]" required>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-12 mt-20">
            <textarea name="request_remark" id="request_remark" class="form-control"
                placeholder="Enter Request Remark"></textarea>
        </div>
        <div class="col-md-3 mt-20">
            <button name="send_requirement_request" class="btn btn-success mt-20" type="submit">Submit</button>
        </div>
    </div>
</form>
<?php
}

if(isset($_POST['send_requirement_request'])){

    $data = '';
    $i  = 1;
    foreach($_POST['response'] as $key => $res){
        if($_POST['type'][$key] == 'url'){
            $data .= '<p><b>'.$_POST['feild_name'][$key].'</b> : <br> <a href="'.$res.'" target="_blank">View Link <i class="fa fa-eye"></i></a></p><br>';
        }else{
            $data .= '<p><b>'.$_POST['feild_name'][$key].'</b> : <br> '.$res.'</p><br>';
        }
    }
 foreach($_FILES['response']['name'] as $key => $res){
        $stu_code = getField("student_no", $tbl_student, $_SESSION['sess_admin_id']);
        $uploadsDir = 'uploads/';
        
        $fileName = pathinfo($_FILES['response']['name'][$key], PATHINFO_FILENAME);
        $fileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $fileName);
        $fileName = str_replace(' ', '_', $fileName);
        $fileName = generateSlug($obj->escapestring($fileName));
        
        $file = pathinfo($_FILES['response']['name'][$key]);
        $fileType = $file['extension'];
        
        $allowedExtensions = ['docx', 'doc', 'xlsx', 'xls', 'pdf'];
        $desiredExt = in_array($fileType, $allowedExtensions) ? $fileType : 'txt';
        
        $fileNameNew = $fileName . "_" . $stu_code . '_' . rand(0, 10) . "." . $desiredExt;
        
        $filePath = $uploadsDir . $fileNameNew;
        if(!is_dir($uploadsDir)){
            mkdir($uploadsDir, 0777, true);
        }
        if (move_uploaded_file($_FILES['response']['tmp_name'][$key], $filePath)){
            $data .= '<p><b>Files '.$i++.'</b> : <br> <a href="javascript:void"  onclick="show_file(\'https://crm.ibtoverseas.com/'.$filePath.'\')"><i class="fa fa-eye"></i> View</a></p> <br> ';
        }
    }
    $data = $obj->escapestring($data);
    $request_remark = $obj->escapestring($_POST['request_remark']);
    if($request_remark != ''){
        $sql = " ,student_response_remark='$request_remark'";
    }
    $user = getField("name",$tbl_admin, $_SESSION['sess_admin_id']);
    $obj->query("UPDATE tbl_student_request set responsed_by='Counsellor ($user)', response_by_type='".$_SESSION['level_id']."',response_by='".$_SESSION['sess_admin_id']."', student_response_date_time='".date('Y-m-d H:i:s')."',student_response='$data' $sql where id='{$_POST['id']}'");
    $visible_by = date("Y-m-d", strtotime("+2 days"));
    $obj->query("UPDATE tbl_requirement_notification set `status`='0',visible_by='$visible_by',response_by='".$_SESSION['sess_admin_id']."', response_by_type='".$_SESSION['level_id']."' where requirement_id='{$_POST['id']}'");
    $get_notify = $obj->fetchNextObject($obj->query("select * from tbl_requirement_notification where requirement_id='{$_POST['id']}'"));

    $obj->query("INSERT tbl_requirement_notification_seen set `user_id`='".$_SESSION['sess_admin_id']."', notification_id='{$get_notify->id}'");
    $stu_id = getField("stu_id", 'tbl_student_request', $_POST['id']);

    // $visible_by = date("Y-m-d", strtotime("+50 years"));
    // $obj->query("INSERT tbl_requirement_notification set `send_by`='".$_SESSION['sess_admin_id']."', send_by_level='".$_SESSION['level_id']."',stu_id='$stu_id',requirement_id='{$_POST['id']}',message='Reponse Submitted',visible_by='$visible_by'");

    header('location:student-editf.php?id='.base64_encode(base64_encode(base64_encode(getField("stu_id", 'tbl_student_request', $_POST['id'])))).'&request');
    exit();
}

if(isset($_GET['del_policy_id'])){
    $id = $_GET['del_policy_id'];
    $sql="delete from $tbl_policy_category where id='$id'"; 

    $obj->query($sql);
    $sess_msg='category deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: policy-category-list.php");
    exit();
}

if(isset($_GET['subcat_delete_id'])){
    $id = $_GET['subcat_delete_id'];
    $sql="delete from $tbl_policy_subcategory where id='$id'"; 

    $obj->query($sql);
    $sess_msg='subcategory deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: policy-subcategory-list.php");
    exit();
}

if(isset($_GET['question_delete_id'])){
    $id = $_GET['question_delete_id'];
    $sql="delete from $tbl_policy_question where id='$id'"; 

    $obj->query($sql);
    $sess_msg='Question deleted successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: policy-question-list.php");
    exit();
}

if(isset($_POST['requirement_status'])){
    $status  = $_POST['requirement_status'];
    $id = $_POST['id'];
    $get = $obj->query("select * from $tbl_requirement_notification_seen where notification_id='$id' and user_id='{$_SESSION['sess_admin_id']}'");
    if($obj->numRows($get) > 0){
        $res = $obj->fetchNextObject($get);
        $get = $obj->query("UPDATE $tbl_requirement_notification_seen set status='$status' where id='{$res->id}'");
    }else{
        $get = $obj->query("INSERT $tbl_requirement_notification_seen set `status`='$status',notification_id='$id',user_id='{$_SESSION['sess_admin_id']}'");
    }
}

if(isset($_POST['managent_meet'])){
    $id  = $_POST['managent_meet'];
    $get = $obj->fetchNextObject($obj->query("select * from $tbl_lead where id='$id'"));
    echo $get->management_datetime;
}
if(isset($_POST['expected_enrollment'])){
    $id  = $_POST['expected_enrollment'];
    $get = $obj->fetchNextObject($obj->query("select * from $tbl_visit where id='$id'"));
    echo $get->expected_enrollment_date;
}
if(isset($_POST['submit_appointment_booking'])){
    $id  = $_POST['lead_id'];
    $management_datetime  = $_POST['management_datetime'];
    $get = $obj->query("update $tbl_lead set management_datetime='$management_datetime' where id='$id'");
    $_SESSION['sess_msg']='Appointment Booked Successfully';
    header("location: ".$_POST['back_url']);
}
if(isset($_POST['submit_expected_enrollment_date'])){
    $id  = $_POST['visit_id'];
    $expected_enrollment_date  = $_POST['expected_enrollment_date'];
    $get = $obj->query("update $tbl_visit set expected_enrollment_date='$expected_enrollment_date' where id='$id'");
    $_SESSION['sess_msg']='Expected enrollment date updated Booked Successfully';
    header("location: ".$_POST['back_url']);
}
if(isset($_GET['lead_delete_id'])){
    $id  = base64_decode(base64_decode(base64_decode($_GET['lead_delete_id'])));
    $get = $obj->query("delete from $tbl_lead where id='$id'");
    $_SESSION['sess_msg']='Lead deleted Successfully';
    header("location: lead-list.php");
}

if(isset($_POST['change_to_enquiry_id'])){
    $id = $_POST['change_to_enquiry_id'];
    $column = $_POST['column'];
    $remark = $obj->escapestring($_POST['remark']);
    if($column == 'status'){
        $added_by_column = 'remark_added_by1';
        $remark_column = 'remark1';
        $remark_added_at = 'remark_added_at1';
    }
    elseif($column == 'status1'){
        $added_by_column = 'remark_added_by2';
        $remark_column = 'remark2';
        $remark_added_at = 'remark_added_at2';
    }
    elseif($column == 'status2'){
        $added_by_column = 'remark_added_by3';
        $remark_column = 'remark3';
        $remark_added_at = 'remark_added_at3';
    }
    $val = $_POST['val'];
    $time_date = date("Y-m-d H:i:s");
    $obj->query("update $tbl_enquiry set $column = '$val',$added_by_column='{$_SESSION['sess_admin_id']}',$remark_added_at='$time_date'  where id='$id'");
    $_SESSION['sess_msg1']='Remark Added Successfully';
  
}
if(isset($_POST['column'])){
    $id = $_POST['enquiry_id'];
    $column = $_POST['column'];
    $remark = $obj->escapestring($_POST['remark']);
    if($column == 'status'){
        $added_by_column = 'remark_added_by1';
        $remark_column = 'remark1';
        $remark_added_at = 'remark_added_at1';
    }
    elseif($column == 'status1'){
        $added_by_column = 'remark_added_by2';
        $remark_column = 'remark2';
        $remark_added_at = 'remark_added_at2';
    }
    elseif($column == 'status2'){
        $added_by_column = 'remark_added_by3';
        $remark_column = 'remark3';
        $remark_added_at = 'remark_added_at3';
    }
    $val = $_POST['status'];
    $time_date = date("Y-m-d H:i:s");
    $obj->query("update $tbl_enquiry set $column = '$val',$remark_column = '$remark',$added_by_column='{$_SESSION['sess_admin_id']}',$remark_added_at='$time_date'  where id='$id'");
    $_SESSION['sess_msg1']='Remark Added Successfully';
    if($val == 1){
        header("location: lead-addf.php?enquiry_id=".base64_encode(base64_encode(base64_encode($id))));
    }else{
    header("location: manage-enquiry.php");
    }
}
if(isset($_GET['change_student_otp'])){
    $id = $_GET['change_student_otp'];
    $whr = '';
    if($id != 'All'){
        $id = base64_decode(base64_decode(base64_decode($id)));
        $whr = " and id='$id'";
    }
    $get = $obj->query("select * from $tbl_student where 1=1 $whr");
    while($res = $obj->fetchNextObject($get)){
        $rand = rand(1000,9999);
        $obj->query("update $tbl_student set passcode=$rand where id='{$res->id}'");
    }
    $_SESSION['sess_msg']='OTP Updated Successfully';
    header("location: student-list.php");
}

if(isset($_POST['frachise_branch_id'])){
    $id = $_POST['frachise_branch_id'];
    $status = $_POST['status'];
    $obj->query("update $tbl_branch set franchise_bill=$status where id='$id'");

}

if(isset($_POST['get_auditor_status'])){
    $id = $_POST['get_auditor_status'];
    $sql = $obj->query("SELECT * FROM $tbl_profile_status where visit_id='$id' order by id desc");
    $c = 1;
    while($res = $obj->fetchNextObject($sql)){
        ?>
<tr>
    <td><?=$res->cdate?></td>
    <td><?=getField('visa_sub_type',$tbl_visa_sub_type,$res->visa_sub_type)?></td>
    <td><?=$res->percentage?>%</td>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->remark?></td>
    <td>
        <?php
                    if($res->status == 0){
                        ?>
        <a href="javascript:void;" class="btn btn-primary">Pending</a>
        <?php
                    } elseif($res->status == 2){
                        ?>
        <a href="javascript:void" class="btn btn-danger">Disapproved</a>
        <?=$res->disapproved_remark?>
        <?php
                    }else{
                        ?>
        <a href="javascript:void" class="btn btn-success">Approved</a>
        <?php
                    }
                ?>
    </td>
    <td>
        <?php
                    if($res->status == 2){
                        ?>
        <a href="add-fee.php?id=<?=base64_encode(base64_encode(base64_encode($id)))?>&profile=<?=base64_encode(base64_encode(base64_encode($res->id)))?>&type=<?=getField("type",$tbl_visa_sub_type, $res->visa_sub_type)?>"
            class="text"><i class="fa fa-edit"></i></a>
        <?php } ?>
    </td>
</tr>
<?php
    }
}

if(isset($_POST['change_status_success'])){
    $id = $_POST['change_status_success'];
    $date = date('Y-m-d H:i:s');
    $sql = $obj->query("UPDATE $tbl_profile_status set status=1, approved_by='{$_SESSION['sess_admin_id']}',approved_date='$date' where id='$id'");
    $visit_id = getField('visit_id',$tbl_profile_status,$id);
    $reapply = getField('reapply',$tbl_profile_status,$id);
    $counsellor_allocate = getField('counsellor_allocate',$tbl_profile_status,$id);
    $visa_sub_type = getField('visa_sub_type',$tbl_profile_status,$id);
    $applicant_contact_no = getField("applicant_contact_no",$tbl_visit, $visit_id);
    $applicant_alternate_no = getField("applicant_alternate_no",$tbl_visit, $visit_id);
    $stu_id1 = getField("student_id",$tbl_visit, $visit_id);
    $date = date('Y-m-d H:i:s');
    $c1 = '';
    $profile_s_count = $obj->query("select SUM(percentage) as percentage from $tbl_profile_status where visit_id='$visit_id' and `status`=1");
   
        $profile_s_counts = $obj->fetchNextObject($profile_s_count);
    $profile_visa = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_visa_sub_type where id='$visa_sub_type'"));
      $min = $profile_s_counts->percentage;
  if($min < 100){
      if($min >= $profile_visa->registration_percentage){
          $c1 .= " visit_status='Registered',visit_status_date='".date("Y-m-d H:i:s")."'";
        }else{
            $c1 .= " visit_status='Register',visit_status_date='".date("Y-m-d H:i:s")."'";
        }
        $obj->query("UPDATE $tbl_student SET student_status='1' where alternate_contact in ('$applicant_contact_no','$applicant_alternate_no') or student_contact_no in ('$applicant_contact_no','$applicant_alternate_no')");
  }else{
      $obj->query("UPDATE $tbl_student SET student_status='1', `type`='Enrolled' where alternate_contact in ('$applicant_contact_no','$applicant_alternate_no') or student_contact_no in ('$applicant_contact_no','$applicant_alternate_no')");
      $c1 .= " visit_status='Enrolled',visit_status_date='".date("Y-m-d H:i:s")."'";
  }
  
  $obj->query("UPDATE $tbl_visit SET $c1 where id='$visit_id'");   
  $obj->query("UPDATE $tbl_visit SET reapply_status=0 where id='$visit_id'");   


  if ($_POST['type'] == 'Reapply') {
           $obj->query("UPDATE $tbl_student set work_status=0 where 1=1 and (student_contact_no in ('{$applicant_contact_no}','{$applicant_alternate_no}') or alternate_contact in('{$applicant_contact_no}','{$applicant_alternate_no}'))",-1); //die();
           $count_stu=$obj->query("select * from $tbl_student where 1=1 and (student_contact_no in('{$applicant_contact_no}','{$applicant_alternate_no}') or alternate_contact in('{$applicant_contact_no}','{$applicant_alternate_no}')) and reapply_status=1",-1); //die();
        //    if($obj->numRows($count_stu) == 0){
            //    $sqll=$obj->query("select * from $tbl_student where 1=1 order by id desc",-1); //die();
            //    $result=$obj->fetchNextObject($sqll);
            //    $parts = explode("IBT", $result->student_no);
            //  $student_no=codeGenerate($parts[1]);
            

            $old_stu=$obj->fetchNextObject($obj->query("select * from $tbl_student where 1=1 and student_contact_no in('{$applicant_contact_no}','{$applicant_alternate_no}') or alternate_contact in('{$applicant_contact_no}','{$applicant_alternate_no}') order by id desc",-1)); //die();
            $stu_old_id=$old_stu->id;
    
            // if($visa_sub_type == 50 || $visa_sub_type == 48){
            //     $student_type = 6;
            // }
            // if($visa_sub_type == 20 || $visa_sub_type == 47){
            //     $student_type = 4; 
            // }
            // if($visa_sub_type == 42){
                $student_type = $visa_sub_type;
            // }
            
           $obj->query("INSERT INTO $tbl_student 
            (branch_id, c_id, am_id, wc_id, am_assign_date_time, fm_id, slot_executive_id, student_no, stu_name, dob, alternate_contact, enrolment_date, crm_executive_id, passport_no, country_id, address, state_id, city_id, postalcode, visa_id, student_type, accept_student, education_verify, language_proficiency, student_contact_no, ten_start_year, ten_end_year, ten_stream, ten_percent, twl_start_year, twl_end_year, twl_stream, twl_percent, dip_start_year, dip_end_year, dip_stream, dip_percent, dip1_start_year, dip1_end_year, dip1_stream, dip1_percent, grd_start_year, grd_end_year, grd_stream, grd_percent, grd1_start_year, grd1_end_year, grd1_stream, grd1_percent, pgrd_start_year, pgrd_end_year, pgrd_stream, pgrd_percent, pgdrd_start_year, pgdrd_end_year, pgdrd_stream, pgdrd_percent, application_check, course_recomandateion_one, course_recomandateion_two, application_id, sam_assign, fm_assign, fm_allocated_id, status, refund_status, affidavit_remarks, with_financial_affidavit_remark, transfer_id, approve_review, special_remarks, management_member, management_type, management_remark, management_date, management_member_status, profile_accessed, profile_accessed_date, welcome_call_status, insentive_status, crm_insentive_status, passcode, student_login,reapply_status,`type`,student_status)
            SELECT branch_id, '$counsellor_allocate', 0, 0, null, 0, slot_executive_id, student_no, stu_name, dob, alternate_contact, enrolment_date, crm_executive_id, passport_no, country_id, address, state_id, city_id, postalcode, visa_id, '$student_type', 0, education_verify, language_proficiency, student_contact_no, ten_start_year, ten_end_year, ten_stream, ten_percent, twl_start_year, twl_end_year, twl_stream, twl_percent, dip_start_year, dip_end_year, dip_stream, dip_percent, dip1_start_year, dip1_end_year, dip1_stream, dip1_percent, grd_start_year, grd_end_year, grd_stream, grd_percent, grd1_start_year, grd1_end_year, grd1_stream, grd1_percent, pgrd_start_year, pgrd_end_year, pgrd_stream, pgrd_percent, pgdrd_start_year, pgdrd_end_year, pgdrd_stream, pgdrd_percent, application_check, course_recomandateion_one, course_recomandateion_two, application_id, sam_assign, fm_assign, fm_allocated_id, status, refund_status, affidavit_remarks, with_financial_affidavit_remark, transfer_id, 0, special_remarks, management_member, management_type, management_remark, management_date, management_member_status, profile_accessed, profile_accessed_date, welcome_call_status, insentive_status, crm_insentive_status, passcode, student_login,1,type,1
            FROM $tbl_student 
            WHERE id=$stu_old_id");
            $new_stu_id = $obj->lastInsertedId();
           
           $obj->query("INSERT INTO $tbl_student_course (stu_id, course_name)
                        SELECT '$new_stu_id', course_name
                        FROM $tbl_student_course
                        WHERE stu_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_relation (`sutdent_id`, `relation`, `name`, `sponser`, `dob`, `contact_no`, `email`)
                        SELECT '$new_stu_id',`relation`, `name`, `sponser`, `dob`, `contact_no`, `email`
                        FROM $tbl_student_relation
                        WHERE sutdent_id = $stu_old_id;");
                        
           $obj->query("INSERT INTO $tbl_student_univercity_course (`sutdent_id`,`state_id`, `univercity_id`, `course_id`, `month`, `year`)
                        SELECT '$new_stu_id',`state_id`, `univercity_id`, `course_id`, `month`, `year`
                        FROM $tbl_student_univercity_course
                        WHERE sutdent_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_diploma (
                            sutdent_id, registration_no, diploma_id, institute_id, start_date, end_date, 
                            time_duration, status, slip_number, slip_photo, mother_name, stu_contact_number, 
                            imp_remarks, photo, days, roll_no_1, roll_no_2, institute_forms_status, 
                            exam_status, student_approval_status, media_gap_status, pimg, draft, changes
                        )
                        SELECT 
                            '$new_stu_id', registration_no, diploma_id, institute_id, start_date, end_date, 
                            time_duration, status, slip_number, slip_photo, mother_name, stu_contact_number, 
                            imp_remarks, photo, days, roll_no_1, roll_no_2, institute_forms_status, 
                            exam_status, student_approval_status, media_gap_status, pimg, draft, changes
                        FROM 
                            $tbl_student_diploma
                        WHERE sutdent_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_experience (
                            `registration_no`, `sutdent_id`, `designation_id`, `company_id`, `start_date`, `end_date`, `time_duration`, `status`, `slip_number`, `slip_photo`, `stu_contact_number`, `salary`, `issue_date`, `imp_remarks`, `resume`, `address_proof`, `counsellor_status`, `pimg`
                        )
                        SELECT 
                            `registration_no`, '$new_stu_id', `designation_id`, `company_id`, `start_date`, `end_date`, `time_duration`, `status`, `slip_number`, `slip_photo`, `stu_contact_number`, `salary`, `issue_date`, `imp_remarks`, `resume`, `address_proof`, `counsellor_status`, `pimg`
                        FROM 
                            $tbl_student_experience
                        WHERE sutdent_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_found (
                            `sutdent_id`, `amount`, `notes`, `status`, `stu_status`
                        )
                        SELECT 
                            '$new_stu_id', `amount`, `notes`, `status`, `stu_status`
                        FROM 
                            $tbl_student_found
                        WHERE sutdent_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_english_proficiency (
                             `sutdent_id`, `course`, `wirting`, `reading`, `listening`, `speaking`, `overall_bands`, `exam_date`, `login_id`, `password`
                        )
                        SELECT 
                            '$new_stu_id', `course`, `wirting`, `reading`, `listening`, `speaking`, `overall_bands`, `exam_date`, `login_id`, `password`
                        FROM 
                            $tbl_student_english_proficiency
                        WHERE sutdent_id = $stu_old_id;");
    
           $obj->query("INSERT INTO $tbl_student_work_experience (
                             `sutdent_id`, `company_name`, `designation`, `start_date`, `end_date`
                        )
                        SELECT 
                            '$new_stu_id', `company_name`, `designation`, `start_date`, `end_date`
                        FROM 
                            $tbl_student_work_experience
                        WHERE sutdent_id = $stu_old_id;");
    
    
    
                        $old_code = getField('student_no',$tbl_student, $stu_old_id);
                        $new_code = getField('student_no',$tbl_student, $new_stu_id);
                        $new_id = $new_stu_id;
    
                        $obj->query("update $tbl_student set transfer_id='$old_code' where id='$new_id'",-1); 
    
                        $sql = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$old_code'", -1);
                        $line = $obj->fetchNextObject($sql);
    
                        $sql2 = $obj->query("SELECT id,country_id FROM $tbl_student WHERE student_no = '$new_code'", -1);
                        $line2 = $obj->fetchNextObject($sql2);
    
                        $sql1 = $obj->query("SELECT * FROM $tbl_student_document WHERE stu_id = '{$line->id}'", -1);
                        $file_uplaod = false;
                        if($obj->numRows($sql1) > 0){
                        while ($res = $obj->fetchNextObject($sql1)) {
                            // $new_file = str_replace($old_code, $new_code, $res->name);
                            // if (copy('uploads/' . $res->name, 'uploads/' . $new_file)) {
                                $file_uplaod = $obj->query("INSERT INTO $tbl_student_document SET stu_id = '$new_id', dtype = '{$res->dtype}', `name` = '{$res->name}', `orgname` = '{$res->name}', user_id = '" . $_SESSION['sess_admin_id'] . "', desiredExt = '{$res->desiredExt}', transfer_status = 1", -1);
                            // }
                        }
                        }else{
                            $file_uplaod = true;
                        }
                        // if($line->country_id == $line2->country_id && $file_uplaod){
                            $sql3 = $obj->query("SELECT * FROM $tbl_student_application WHERE stu_id = '$stu_old_id'", -1);
                            while ($totald = $obj->fetchNextObject($sql3)) {
                                if($totald->status == 'I-20 Received' && $student_type != '20' && $student_type != '47'){
                                    $status = 'I-20 Received(Old)';
                                }else{
                                    $status = $totald->status;
                                }
                                $obj->query("insert into $tbl_student_application set stu_id='$new_id',college_name='".$totald->college_name."',location='".$totald->location."',course='".$totald->course."',month='".$totald->month."',year='".$totald->year."',status='$status',portal_status='".$totald->portal_status."',remarks='".$obj->escapestring($totald->remarks)."',user_id='".$totald->user_id."',parent_id='".$totald->parent_id."',cdate='".$totald->cdate."',portal_id='".$totald->portal_id."',university_id='".$totald->university_id."',university_pass='".$totald->university_pass."',transfer_status=1", -1);
                            }
    
                            $sql31 = $obj->query("SELECT * FROM $tbl_user_recovery WHERE student_id = '$stu_old_id'", -1);
                        while ($totald = $obj->fetchNextObject($sql31)) {
                            $obj->query("insert into $tbl_user_recovery set student_id='$new_id',user_id='".$totald->user_id."',offical_email='".$totald->offical_email."',password='".$totald->password."',recovery_email='".$totald->recovery_email."',recovery_number='".$totald->recovery_number."',transfer_status=1", -1);
                        }
                        $obj->query("INSERT $tbl_student_noc SET `user_id`='{$_SESSION['sess_admin_id']}',`stu_id`='$new_id',type=1,transfer_status=1");  
                        $usql=$obj->query("select * from $tbl_filing_credentials where student_id='$stu_old_id'",-1);//die();
                        $res1=$obj->fetchNextObject($usql);
                        $obj->query("INSERT INTO $tbl_filing_credentials SET `user_id`='{$_SESSION['sess_admin_id']}',`student_id`='$new_id',`cgi_user_id`='{$res1->cgi_user_id}',`cgi_password`='{$res1->cgi_password}',`cgi_email`='{$res1->cgi_email}',`email_password`='{$res1->email_password}',`recovery_email`='{$res1->recovery_email}',`recovery_number`='{$res1->recovery_number}',`security_answer`='{$res1->security_answer}',`ds_application_id`='{$res1->ds_application_id}',`status`='{$res1->status}',`pstatus`='{$res1->pstatus}',`savis_id`='{$res1->savis_id}',`savis_payment_status`='{$res1->savis_payment_status}',`university`='{$res1->university}',`ds_status`='{$res1->ds_status}',`gc_key`='{$res1->gc_key}',`gc_password`='{$res1->gc_password}',`gc_code`='{$res1->gc_code}',`security_question`='{$res1->security_question}',`recovery_question`='{$res1->recovery_question}',`recovery_annser`='{$res1->recovery_annser}',`transfer_status`='1'");
    
                        // header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($new_id)))); 
                        // exit();
                    // }else{
                    //     $res = $obj->fetchNextObject($count_stu);
                    //     $obj->query("UPDATE $tbl_student set c_id='".$_POST['allocate_counsellor']."', am_id=0, wc_id=0, am_assign_date_time=null, slot_executive_id=0 WHERE id={$res->id}");
                    //     $id = $res->id;
                    //     $sql = $obj->query("delete from $tbl_appointment where student_id='$id'",-1); 
                    //     // $sql = $obj->query("delete from $tbl_user_recovery where student_id='$id'",-1); 
                    //     // $sql = $obj->query("delete from $tbl_student_application where stu_id='$id'",-1); 
                    //     $sql = $obj->query("delete from $tbl_student_enrollment where stu_id='$id'",-1); 
                    //     $sql = $obj->query("delete from $tbl_student_noc where stu_id='$id'",-1); 
                    //     // $sql = $obj->query("delete from $tbl_student_notes where stu_id='$id'",-1); 
                    //     $sql = $obj->query("delete from $tbl_student_passport_noc where stu_id='$id'",-1); 
                    //     $sql = $obj->query("delete from $tbl_student_status where stu_id='$id'",-1); 
                    //     // $sql = $obj->query("delete from $tbl_student_updated_time where stu_id='$id'",-1); 
                    //     header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($id))));
                    //     exit(); 
                    // }
                    // header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($new_id)))); 
    }
    elseif($_POST['type'] == 'University Transfer'){
        $student_type = $visa_sub_type;
        $obj->query("UPDATE $tbl_student set am_id=0, student_type='$student_type',university_transfer=1 where id='$stu_id1'",-1);
    }
    elseif($_POST['type'] == 'Refund'){
        $obj->query("UPDATE $tbl_student set refund_status='1' where id='$stu_id1'",-1);
        // $student_type = $visa_sub_type;
        // $res1_refund=$obj->fetchNextObject($obj->query("SELECT * from $tbl_student where 1=1 and reapply_status=0 and student_contact_no in('{$applicant_contact_no}','{$applicant_alternate_no}') or alternate_contact in('{$applicant_contact_no}','{$applicant_alternate_no}')",-1));
        // $get_r=$obj->query("SELECT * from $tbl_student_enrollment where stu_id = '{$res1_refund->id}'",-1);
        // echo "SELECT * from $tbl_student_enrollment where stu_id = '{$res1_refund->id}'";die;
        // if($obj->numRows($get_r) > 0){
        //     $obj->query("UPDATE $tbl_student_enrollment set refund_status=1 where stu_id = '{$res1_refund->id}'",-1);
        // }else{
        //     $obj->query("INSERT $tbl_student_enrollment set refund_status=1 , stu_id = '{$res1_refund->id}'",-1);
        // }
    }
    
    
        echo 'hi';
}

if(isset($_POST['change_status_reject'])){
    $id = $_POST['change_status_reject'];
    // $remark = $obj->escapestring($_POST['remark']);
    $date = date('Y-m-d H:i:s');
    $sql = $obj->query("UPDATE $tbl_profile_status set status=2, disapproved_by='{$_SESSION['sess_admin_id']}',disapproved_date='$date' where id='$id'");
    $visit_id = getField('visit_id',$tbl_profile_status,$id);
    $sql = $obj->query("UPDATE $tbl_visit set visit_status=null where id='$visit_id'");

    $applicant_contact_no = getField("applicant_contact_no",$tbl_visit, $visit_id);
    $applicant_alternate_no = getField("applicant_alternate_no",$tbl_visit, $visit_id);

    $obj->query("UPDATE $tbl_student SET student_status='2' where alternate_contact in ('$applicant_contact_no','$applicant_alternate_no') or student_contact_no in ('$applicant_contact_no','$applicant_alternate_no')");
    // $_SESSION['sess_msg']='Disapproved Successfully';
    // header("location: visit-list.php");
}


// if(isset($_GET['change_visa_sub_type'])){
//     $get = $obj->query("SELECT * FROM $tbl_lead");
//     while($res = $obj->fetchNextObject($get)){
//         $applicant_contact_no = $obj->escapestring($res->applicant_contact_no);
//         $applicant_alternate_no =  $obj->escapestring($res->applicant_alternate_no);
//         $gets = $obj->query("SELECT * FROM $tbl_visit where telecaller_id is null and (applicant_alternate_no in ('{$applicant_contact_no}','{$applicant_alternate_no}') or applicant_contact_no in ('{$applicant_contact_no}','{$applicant_alternate_no}'))",-1);
//         if($obj->numRows($gets) != 0){
//             echo $res->applicant_alternate_no.'<br>';
//             while($ress = $obj->fetchNextObject($gets)){
//                 $obj->query("UPDATE $tbl_visit set telecaller_id='{$res->crm_executive_id}' where telecaller_id is null and (applicant_alternate_no in ('{$applicant_contact_no}','{$applicant_alternate_no}') or applicant_contact_no in ('{$applicant_contact_no}','{$applicant_alternate_no}'))",-1);
//             }
//         }
//     }
//     echo 'hi';
// }
if(isset($_GET['delete_enrollment'])){
    $id = base64_decode($_GET['delete_enrollment']);
    $obj->query("DELETE FROM $tbl_profile_status where id='$id'",-1);
    $_SESSION['sess_msg']='Deleted successfully';
    header("location: pending-enrollment.php");
}
if(isset($_GET['get_ip'])){
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
echo "User Agent: " . $userAgent;
}
if(isset($_POST['change_passport_id'])){
    $obj->query("DELETE FROM $tbl_student_document where stu_id='{$_POST['stu_id']}' and dtype='44'",-1);
    $obj->query("UPDATE $tbl_student_document set dtype='44' where id='{$_POST['change_passport_id']}'",-1);
}

if(isset($_POST['counsellor_target'])){
    $counsellor_target = $_POST['counsellor_target'];
    $counsellor_id = $_POST['user_id'];
    $target_date = date("Y-m-d");
    $get = $obj->query("SELECT * FROM tbl_target where counsellor_id='$counsellor_id' and target_date='$target_date'");
    if($obj->numRows($get) > 0){
        $res = $obj->fetchNextObject($get);
        $obj->query("UPDATE tbl_target set counsellor_target='$counsellor_target' where id='{$res->id}'");
    }else{
        $obj->query("INSERT tbl_target set user_id='{$_SESSION['sess_admin_id']}', counsellor_id='$counsellor_id', target_date='$target_date', counsellor_target='$counsellor_target'");
    }
}

if(isset($_POST['change_immigration_status_id'])){
    $id = $_POST['change_immigration_status_id'];
    $obj->query("UPDATE $tbl_student set immigration_trainning_status=1 where id='$id'");
}

if(isset($_GET['delete_student'])){
    // $get = $obj->query("SELECT a.* FROM $tbl_student as a inner join $tbl_student_status as b on a.id=b.stu_id where b.cstatus='Visa Refused' and a.student_no < 'IBT7516'");
    // // while($res = $obj->fetchNextObject($get)){
    // //     $gets = $obj->fetchNextObject($obj->query("SELECT a.* FROM $tbl_student as a where a.passport_no='{$res->passport_no}' and date(a.cdate) > '2025-03-01'"));
    // //     if($gets != ''){
    // //     echo $gets->student_no.'<br>';
    // //     }
    // // }


    // // die;
    // while($res = $obj->fetchNextObject($get)){
    // $id = $res->id;
    //  $result = $obj->query("SELECT name FROM $tbl_student_document WHERE stu_id='$id'", -1);
    // while ($row = $obj->fetchNextObject($result)) {
    //     $filePath = 'uploads/'.$row->name;
    //     if (file_exists($filePath)) {
    //         unlink($filePath);
    //     }
    // }
    // $sql = $obj->query("delete from $tbl_student where id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_appointment where student_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_application where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_diploma where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_document where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_english_proficiency where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_enrollment where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_experience where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_found where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_noc where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_notes where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_passport_noc where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_relation where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_status where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_univercity_course where sutdent_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_updated_time where stu_id='$id'",-1); 
    // $sql = $obj->query("delete from $tbl_student_work_experience where sutdent_id='$id'",-1);
    // }
    echo 'hi';
}

if(isset($_POST['change_head_office'])){
    $id = $_POST['change_head_office'];
    $ds_head_office_added_at = date('Y-m-d H:i:s');
    $obj->query("UPDATE $tbl_student set ds_head_office_status='2',ds_head_office_added_by='{$_SESSION['sess_admin_id']}',ds_head_office_added_at='$ds_head_office_added_at' where id='$id'",-1);
}

if(isset($_POST['change_pending_branch_status'])){
    $id = $_POST['change_pending_branch_status'];
    $ds_head_office_added_at = date('Y-m-d H:i:s');
    $obj->query("UPDATE $tbl_student set branch_ds_160_status='1',branch_ds_160_added_by='{$_SESSION['sess_admin_id']}',branch_ds_160_added_at='$ds_head_office_added_at' where id='$id'",-1);
}

if(isset($_POST['submit_ds_160_remark'])){
    $id = $_POST['stu_id'];
    $ho_remark = $obj->escapestring($_POST['remark']);
    $obj->query("UPDATE $tbl_student set ds_head_office_status='1',ho_remark='$ho_remark' where id='$id'",-1);
    $sess_msg='Remark updated successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header('location:student-ds-160.php');
}
if(isset($_POST['change_change_remark'])){
    $branch_remark = $_POST['change_change_remark'];
    $id = $_POST['id'];
    $obj->query("UPDATE $tbl_student set branch_remark='$branch_remark' where id='$id'",-1);
}

if(isset($_POST['btn_submit_class_mode'])){
    $id = $_POST['stu_id'];
    $class_mode = $_POST['class_mode'];
    $no_of_days = $_POST['no_of_days'];
    $branch = $_POST['branch_id_stu'];
    $class_start_date = date('Y-m-d');
    $class_end_date = date('Y-m-d', strtotime('+'.$_POST['no_of_days'].' days'));
    $obj->query("INSERT $tbl_student_interview_preparation set stu_id='$id',user_id='{$_SESSION['sess_admin_id']}', class_mode='$class_mode', no_of_days='$no_of_days',class_start_date='$class_start_date',class_end_date='$class_end_date',branch='$branch'",-1);
    $obj->query("UPDATE $tbl_student set immigration_trainning_status='1',interview_status=1 where id='$id'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-interview-list.php");
}

if(isset($_POST['btnSubmit1'])){
    	$subcat = $obj->escapestring($_REQUEST['subcat_id']);
	if($subcat==''){
		$subcat=0;
	}
    if($_POST['id'] == ''){
        $obj->query("insert into $tbl_policy_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."'",-1); //die;
        $_SESSION['sess_msg']='Added successfully';
    }else{
       $obj->query("update $tbl_policy_question set cat_id='".$obj->escapestring($_REQUEST['cat_id'])."',question='".$obj->escapestring($_REQUEST['question'])."',answer='".$obj->escapestring($_REQUEST['answer'])."',subcat_id='".$subcat."' where id=".$obj->escapestring($_REQUEST['id']),-1); //die; 
        $_SESSION['sess_msg']='Updated successfully';
    }
    header("location: policy-question-list.php");
}
if(isset($_POST['get_interview_log'])){
    $stu_id = $_POST['get_interview_log'];
    $get = $obj->query("SELECT * FROM $tbl_student_interview_preparation where stu_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->class_mode?></td>
    <td><?=$res->no_of_days?></td>
    <td><?=$res->class_start_date?></td>
    <td><?=$res->class_end_date?></td>
    <td><?=$res->status == 0 ? 'Inactive' : 'Active'?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_branch_log_interview'])){
    $stu_id = $_POST['get_branch_log_interview'];
    $get = $obj->query("SELECT * FROM tbl_student_interview_branch where stu_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_from)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_to)?></td>
    <td><?=$res->remark?></td>
    <td><?=$res->cdate?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_duolingo_branch_log'])){
    $stu_id = $_POST['get_duolingo_branch_log'];
    $get = $obj->query("SELECT * FROM tbl_duolingo_branch where visit_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_from)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_to)?></td>
    <td><?=$res->remark?></td>
    <td><?=$res->cdate?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_spoken_branch_log'])){
    $stu_id = $_POST['get_spoken_branch_log'];
    $get = $obj->query("SELECT * FROM tbl_spoken_branch where visit_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_from)?></td>
    <td><?=getField('name',$tbl_branch,$res->branch_to)?></td>
    <td><?=$res->remark?></td>
    <td><?=$res->cdate?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_duolingo_log'])){
    $stu_id = $_POST['get_duolingo_log'];
    $get = $obj->query("SELECT * FROM $tbl_duolingo_classe where visit_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->class_mode?></td>
    <td><?=$res->no_of_days?></td>
    <td><?=$res->class_start_date?></td>
    <td><?=$res->class_end_date?></td>
    <td><?=$res->status == 0 ? 'Inactive' : 'Active'?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_duolingo_dezire_score'])){
    $stu_id = $_POST['get_duolingo_dezire_score'];
    $get = $obj->query("SELECT * FROM tbl_duolingo_dezire_score where visit_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->score?></td>
    <td><?=$res->cdate?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_spoken_log'])){
    $stu_id = $_POST['get_spoken_log'];
    $get = $obj->query("SELECT * FROM $tbl_spoken_classe where visit_id='$stu_id' order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->no_of_days?></td>
    <td><?=$res->class_start_date?></td>
    <td><?=$res->class_end_date?></td>
    <td><?=$res->status == 0 ? 'Inactive' : 'Active'?></td>
</tr>
<?php
    }
}
if(isset($_POST['get_all_record'])){
    $stu_id = $_POST['get_all_record'];
    $get = $obj->query("SELECT * FROM $tbl_duolingo_exam where visit_id='$stu_id' and status!=0 order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->moke_score?></td>
    <td><?=$res->duolingo_email?></td>
    <td><?=$res->duolingo_password?></td>
    <td><?php
            if($res->status == '1'){
                echo 'Pending';
            }elseif($res->status == '2'){
                echo 'Approved';
            }elseif($res->status == '3'){
                echo 'Not Approved';
            }
            ?></td>
    <td><?=getField('name',$tbl_admin,$res->status_changed_by)?></td>
    <td><?=$res->remark?></td>
    <td><?=$res->date_time_exam?></td>
</tr>
<?php
    }
}
if(isset($_POST['final_record'])){
    $stu_id = $_POST['final_record'];
    $get = $obj->query("SELECT * FROM $tbl_duolingo_final_exam where visit_id='$stu_id' and visit_status=1 order by id desc");
    while($res = $obj->fetchNextObject($get)){
        ?>
<tr>
    <td><?=$res->cdate?></td>
    <td><?=getField('name',$tbl_admin,$res->user_id)?></td>
    <td><?=$res->reappear_date_time?></td>
    <td><?=$res->band_score?></td>
    <td><?=$res->remark?></td>
    <td><?php
            if($res->status == '1'){
                echo 'Successfull';
            }elseif($res->status == '2'){
                echo 'Invalid';
            }
            elseif($res->status == '3'){
                echo 'Invalid and Re-appear';
            }
            elseif($res->status == '4'){
                echo 'Banned';
            }
            ?></td>
</tr>
<?php
    }
}

if(isset($_POST['btn_submit_class_mode_duolingo'])){
    $id = $_POST['stu_id'];
    $class_mode = $_POST['class_mode'];
    $no_of_days = $_POST['no_of_days'];
    $class_start_date = date('Y-m-d');
    $class_end_date = date('Y-m-d', strtotime('+'.$_POST['no_of_days'].' days'));
    $obj->query("INSERT $tbl_duolingo_classe set visit_id='$id',user_id='{$_SESSION['sess_admin_id']}', class_mode='$class_mode', no_of_days='$no_of_days',class_start_date='$class_start_date',class_end_date='$class_end_date'",-1);
    $obj->query("UPDATE $tbl_visit set dulingo_date_status=1 where id='$id'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_submit_class_mode_spoken'])){
    $id = $_POST['stu_id'];
    $no_of_days = $_POST['no_of_days'];
    $class_start_date = date('Y-m-d');
    $class_end_date = date('Y-m-d', strtotime('+'.$_POST['no_of_days'].' days'));
    $obj->query("INSERT $tbl_spoken_classe set visit_id='$id',user_id='{$_SESSION['sess_admin_id']}', no_of_days='$no_of_days',class_start_date='$class_start_date',class_end_date='$class_end_date'",-1);
    $obj->query("UPDATE $tbl_visit set spoken_date_status=1 where id='$id'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-spoken-list.php");
}
if(isset($_POST['btn_dezired_score'])){
    $id = $_POST['dezired_score_id'];
        $duolingo_dezire_score = $_POST['dezired_score'];
    $obj->query("UPDATE $tbl_visit set duolingo_dezire_score='$duolingo_dezire_score',dulingo_status=1,dulingo_date_status='1' where id='$id'",-1);
    $get = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_duolingo_classe where visit_id='$id' and class_start_date is null order by id desc",-1));
    // print_r($get);die;
     $no_of_days = $get->no_of_days;
     $class_start_date = date('Y-m-d');
     $class_end_date = date('Y-m-d', strtotime('+'.$get->no_of_days.' days'));
     $ids = $get->id;
    $obj->query("UPDATE $tbl_duolingo_classe set class_start_date='$class_start_date',class_end_date='$class_end_date',status=1 where id='$ids'",-1);
    $obj->query("INSERT tbl_duolingo_dezire_score set visit_id='$id',user_id='{$_SESSION['sess_admin_id']}', score='$duolingo_dezire_score'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}
if(isset($_POST['btn_move_to_exam'])){
    $id = $_POST['id'];
    $moke_score = $obj->escapestring($_POST['moke_score']);
    $duolingo_email = $obj->escapestring($_POST['duolingo_email']);
    $duolingo_password = $obj->escapestring($_POST['duolingo_password']);
        $duolingo_dezire_score = $_POST['dezired_score'];
    $obj->query("INSERT $tbl_duolingo_exam set visit_id='$id', user_id='{$_SESSION['sess_admin_id']}',moke_score='$moke_score',duolingo_email='$duolingo_email',duolingo_password='$duolingo_password'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_approve_move_to_exam'])){
    $id = $_POST['id'];
    $date_time_exam = $_POST['date_time_exam'];
    $remark = $obj->escapestring($_POST['remark']);
    $obj->query("UPDATE $tbl_duolingo_exam set status=2, date_time_exam='$date_time_exam', status_changed_by='{$_SESSION['sess_admin_id']}',remark='$remark' where visit_id='$id' and status=1",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_not_approve_move_to_exam'])){
    $id = $_POST['id'];
    $remark = $obj->escapestring($_POST['remark']);
    $obj->query("UPDATE $tbl_duolingo_exam set status=3, status_changed_by='{$_SESSION['sess_admin_id']}', remark='$remark' where visit_id='$id' and status=1",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['banned_final_exam'])){
    $id = $_POST['banned_final_exam'];
    $obj->query("INSERT $tbl_duolingo_final_exam set status=4, user_id='{$_SESSION['sess_admin_id']}', visit_id='$id'",-1);
    // $_SESSION['sess_msg']='Updated successfully';
    // header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_invalid_remark'])){
    $id = $_POST['id'];
    $remark = $obj->escapestring($_POST['remark']);
    $obj->query("INSERT $tbl_duolingo_final_exam set status=2, user_id='{$_SESSION['sess_admin_id']}', visit_id='$id', remark='$remark'",-1);
    $obj->query("UPDATE $tbl_duolingo_exam set status=3, status_changed_by='{$_SESSION['sess_admin_id']}' where visit_id='$id'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_invalid_reapply_remark'])){
    $id = $_POST['id'];
    $remark = $obj->escapestring($_POST['remark']);
    $date_time_exam = $_POST['date_time_exam'];
    $obj->query("INSERT $tbl_duolingo_final_exam set status=3, user_id='{$_SESSION['sess_admin_id']}', visit_id='$id', remark='$remark',reappear_date_time='$date_time_exam'",-1);
    $get = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_duolingo_exam where visit_id='$id' and status=2",-1));
    $remark = 'Invalid & Re-appear:- '.$remark;
    $obj->query("INSERT $tbl_duolingo_exam set status=2, user_id='{$_SESSION['sess_admin_id']}', visit_id='{$get->visit_id}', duolingo_email='{$get->duolingo_email}', duolingo_password='{$get->duolingo_password}', moke_score='{$get->moke_score}', status_changed_by='{$get->status_changed_by}', remark='$remark',date_time_exam='$date_time_exam'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_success_remark'])){
    $id = $_POST['id'];
    $band_score = $_POST['band_score'];
    $obj->query("INSERT $tbl_duolingo_final_exam set status=1, band_score='$band_score', user_id='{$_SESSION['sess_admin_id']}', visit_id='$id'",-1);
    $applicant_contact_no = getField("applicant_contact_no",$tbl_visit, $id);
    $applicant_alternate_no = getField("applicant_alternate_no",$tbl_visit, $id);
    $get = $obj->fetchNextObject($obj->query("SELECT id,student_no FROM $tbl_student where work_status=1 and alternate_contact in ('$applicant_contact_no','$applicant_alternate_no') or student_contact_no in ('$applicant_contact_no','$applicant_alternate_no')"));
    // print_r($get);die;

         $fileName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);

      $fileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $fileName); 
      $fileName = str_replace(' ', '_', $fileName);
      $fileName = generateSlug($obj->escapestring($fileName)); 
      $file = pathinfo($_FILES['file']['name']);
      $fileType = $file["extension"];

      $desiredExt = match ($fileType) {
          'docx', 'doc', 'xlsx', 'xls', 'pdf' => $fileType,
          default => $fileType,
      };

      $fileNameNew = $fileName . "_" . $get->student_no . "." . $desiredExt;

      $suffix = 1;
      while ($obj->numRows($obj->query("SELECT * FROM $tbl_student_document WHERE name='$fileNameNew' AND status=1")) > 0) {
          $fileNameNew = $fileName . "_" . $studentid . "($suffix)." . $desiredExt;
          $suffix++;
      }

    if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $fileNameNew)) {
      $obj->query("INSERT INTO $tbl_student_document SET stu_id='{$get->id}', dtype='2', name='$fileNameNew', user_id='" . $_SESSION['sess_admin_id'] . "', desiredExt='$desiredExt'");
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}
}
if(isset($_POST['duolingo_details'])){
    $id = $_POST['duolingo_details'];
    $res = $obj->fetchNextObject($obj->query("SELECT * FROM  $tbl_duolingo_exam where visit_id='$id' order by id desc",-1));
    ?>
<form action="controller.php" method="post">
    <input type="hidden" id="move_to_exam" name="id" class="form-control" value="<?=$id?>">
    Mock Score
    <input type="number" name="moke_score" class="form-control mb-10" placeholder="Mock Score"
        value="<?=$res->moke_score?>" maxlength="3" max="160" min="10">
    Duolingo Official Email
    <input type="email" name="duolingo_email" class="form-control mb-10" placeholder="Duolingo Official Email"
        value="<?=$res->duolingo_email?>">
    Duolingo Official Password
    <input type="text" name="duolingo_password" class="form-control" placeholder="Duolingo Official Password"
        value="<?=$res->duolingo_password?>">
    <button type="submit" name="btn_move_to_exam" class="btn btn-success mt-20">Submit</button>
</form>
<?php
}

if(isset($_POST['change_pending_status1'])){
    $id = $_POST['change_pending_status1'];
    $obj->query("UPDATE $tbl_visit set spoken_status=1,spoken_date_status='1' where id='$id'",-1);
    $get = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_spoken_classe where visit_id='$id' and class_end_date is null order by id desc",-1));
    // print_r($get);die;
    $no_of_days = $get->no_of_days;
    $class_start_date = date('Y-m-d');
    $class_end_date = date('Y-m-d', strtotime('+'.$get->no_of_days.' days'));
    $ids = $get->id;
    $obj->query("UPDATE $tbl_spoken_classe set class_start_date='$class_start_date',class_end_date='$class_end_date',status=1 where id='$ids'",-1);
}

if(isset($_POST['submit_get_comission'])){
    $id = $_POST['stu_id'];
    $stu_portal_id = $_POST['stu_portal_id'];
    $app_portal_id = $_POST['app_portal_id'];
    $class_start_date = $_POST['class_start_date'];
    $no_of_commission = $_POST['no_of_commission'];
    $total_tuition_fee = $_POST['total_tuition_fee'];
    $obj->query("INSERT tbl_student_commision set total_tuition_fee='$total_tuition_fee', user_id='{$_SESSION['sess_admin_id']}', stu_id='$id',stu_portal_id='$stu_portal_id',app_portal_id='$app_portal_id',class_start_date='$class_start_date',no_of_commission='$no_of_commission'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-editf.php?commission&id=".base64_encode(base64_encode(base64_encode($id))));
}
if(isset($_POST['btn_submit_commisition'])){
    $obj->query("DELETE FROM tbl_student_commision_details where stu_id='{$_POST['id']}'",-1);
        $stu_portal_id = $_POST['stu_portal_id'];
        $app_portal_id = $_POST['app_portal_id'];
        $class_start_date = $_POST['class_start_date'];
        $no_of_commission = $_POST['no_of_commission'];
        $total_tuition_fee = $_POST['total_tuition_fee'];
        $com_id = $_POST['com_id'];
          $student_status = $_POST['student_status'];
          $sql = '';
          if($student_status != ''){
              $sql .= ",student_status='$student_status'";
            }
            $date1 = $_POST['date1'];
            if($date1 != ''){
            $sql .= ",date1='$date1'";
            }
            $remark1 = $_POST['remark1'];
            if($remark1 != ''){
            $sql .= ",remark1='$remark1'";
            }
            $date2 = $_POST['date2'];
            if($date2 != ''){
            $sql .= ",date2='$date2'";
            }
            $remark2 = $_POST['remark2'];
            if($remark2 != ''){
            $sql .= ",remark2='$remark2'";
            }
            $date3 = $_POST['date3'];
            if($date3 != ''){
            $sql .= ",date3='$date3'";
            }
            $remark3 = $_POST['remark3'];
            if($remark3 != ''){
            $sql .= ",remark3='$remark3'";
            }
            $student_status1 = $_POST['student_status1'];
            if($student_status1 != ''){
            $sql .= ",student_status1='$student_status1'";
            }
        if($com_id != ''){
            $obj->query("UPDATE tbl_student_commision set total_tuition_fee='$total_tuition_fee', stu_portal_id='$stu_portal_id',app_portal_id='$app_portal_id',class_start_date='$class_start_date' $sql where id='$com_id'",-1);
        }else{
            $obj->query("INSERT tbl_student_commision set user_id='{$_SESSION['sess_admin_id']}', stu_id='{$_POST['id']}', no_of_commission='$no_of_commission', total_tuition_fee='$total_tuition_fee', stu_portal_id='$stu_portal_id',app_portal_id='$app_portal_id',class_start_date='$class_start_date' $sql",-1);
        }
    foreach($_POST['enrollment_status'] as $i => $enrollment_status){
        $sql = '';
        if($enrollment_status != ''){
            $sql .= ",enrollment_status='$enrollment_status'";
        }
        $tution_fee_paid = $_POST['tution_fee_paid'][$i];
        if($tution_fee_paid != ''){
            $sql .= ",tution_fee_paid='$tution_fee_paid'";
        }
        $expected_commission_date = $_POST['expected_commission_date'][$i];
        if($expected_commission_date != ''){
            $sql .= ",expected_commission_date='$expected_commission_date'";
        }
        $committed_commission_per = $_POST['committed_commission_per'][$i];
        if($committed_commission_per != ''){
            $sql .= ",committed_commission_per='$committed_commission_per'";
        }
        $expected_commission_amount = $_POST['expected_commission_amount'][$i];
        if($expected_commission_amount != ''){
            $sql .= ",expected_commission_amount='$expected_commission_amount'";
        }
        $expected_commission_amount_inr = $_POST['expected_commission_amount_inr'][$i];
        if($expected_commission_amount_inr != ''){
            $sql .= ",expected_commission_amount_inr='$expected_commission_amount_inr'";
        }
        $invoice_status = $_POST['invoice_status'][$i];
        if($invoice_status != ''){
            $sql .= ",invoice_status='$invoice_status'";
        }
        $invoice_date = $_POST['invoice_date'][$i];
        if($invoice_date != ''){
            $sql .= ",invoice_date='$invoice_date'";
        }
        $invoice_amount_inr = $_POST['invoice_amount_inr'][$i];
        if($invoice_amount_inr != ''){
            $sql .= ",invoice_amount_inr='$invoice_amount_inr'";
        }
        $inovice_amount_foreign = $_POST['inovice_amount_foreign'][$i];
        if($inovice_amount_foreign != ''){
            $sql .= ",inovice_amount_foreign='$inovice_amount_foreign'";
        }
        $commission_recieved_date = $_POST['commission_recieved_date'][$i];
        if($commission_recieved_date != ''){
            $sql .= ",commission_recieved_date='$commission_recieved_date'";
        }
        $commission_received_amount = $_POST['commission_received_amount'][$i];
        if($commission_received_amount != ''){
            $sql .= ",commission_received_amount='$commission_received_amount'";
        }
        $follow_up_remark1 = $obj->escapestring($_POST['follow_up_remark1'][$i]);
        if($follow_up_remark1 != ''){
            $sql .= ",follow_up_remark1='$follow_up_remark1'";
        }
        $follow_up_date1 = $_POST['follow_up_date1'][$i];
        if($follow_up_date1 != ''){
            $sql .= ",follow_up_date1='$follow_up_date1'";
        }
        $follow_up_remark2 = $obj->escapestring($_POST['follow_up_remark2'][$i]);
        if($follow_up_remark2 != ''){
            $sql .= ",follow_up_remark2='$follow_up_remark2'";
        }
        $follow_up_date2 = $_POST['follow_up_date2'][$i];
        if($follow_up_date2 != ''){
            $sql .= ",follow_up_date2='$follow_up_date2'";
        }
        $follow_up_remark3 = $obj->escapestring($_POST['follow_up_remark3'][$i]);
        if($follow_up_remark3 != ''){
            $sql .= ",follow_up_remark3='$follow_up_remark3'";
        }
        $follow_up_date3 = $_POST['follow_up_date3'][$i];
        if($follow_up_date3 != ''){
            $sql .= ",follow_up_date3='$follow_up_date3'";
        }
        $tution_fee_paid_in_future = $_POST['tution_fee_paid_in_future'][$i];
        if($tution_fee_paid_in_future != ''){
            $sql .= ",tution_fee_paid_in_future='$tution_fee_paid_in_future'";
        }
        $tution_fee_paid_in_future_status = $_POST['tution_fee_paid_in_future_status'][$i];
        if($tution_fee_paid_in_future_status != ''){
            $sql .= ",tution_fee_paid_in_future_status='$tution_fee_paid_in_future_status'";
        }
        $tution_fee_eligible_for_commission = $_POST['tution_fee_eligible_for_commission'][$i];
        if($tution_fee_eligible_for_commission != ''){
            $sql .= ",tution_fee_eligible_for_commission='$tution_fee_eligible_for_commission'";
        }
     
        $commission_received_amount_in_forgeign = $_POST['commission_received_amount_in_forgeign'][$i];
        if($commission_received_amount_in_forgeign != ''){
            $sql .= ",commission_received_amount_in_forgeign='$commission_received_amount_in_forgeign'";
        }
        $bank_name = $_POST['bank_name'][$i];
        if($bank_name != ''){
            $sql .= ",bank_name='$bank_name'";
        }
        $bank_account_name = $_POST['bank_account_name'][$i];
        if($bank_account_name != ''){
            $sql .= ",bank_account_name='$bank_account_name'";
        }
        $bank_account_no = $_POST['bank_account_no'][$i];
        if($bank_account_no != ''){
            $sql .= ",bank_account_no='$bank_account_no'";
        }
     
        $obj->query("INSERT tbl_student_commision_details set user_id='{$_SESSION['sess_admin_id']}', stu_id='{$_POST['id']}' $sql",-1);
    }
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-editf.php?id=".base64_encode(base64_encode(base64_encode($_POST['id'])))."&commission");
}

if(isset($_POST['btn_update_branch'])){
    $id = $_POST['id'];
    $remaining_days = $_POST['remaining_days'];
    $branch = $_POST['branch'];
    $remark = $obj->escapestring($_POST['remark']);


    $get = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_student_status where stu_id='$id' and cstatus='Start Classes'"));

    $obj->query("INSERT tbl_student_interview_branch set user_id='{$_SESSION['sess_admin_id']}', stu_id='$id',branch_from='{$get->status_branch}',branch_to='$branch',remark='$remark'",-1);

    $get = $obj->query("SELECT * FROM $tbl_student_interview_preparation where stu_id='$id' and status=1");
    if($obj->numRows($get)>0){
        $res = $obj->fetchNextObject($get);
        $class_start_date = $res->class_start_date;
        $today = date("Y-m-d");
        $start_timestamp = strtotime($class_start_date);
        $today_timestamp = strtotime($today);
        $diff_seconds = $today_timestamp - $start_timestamp;
        $diff_days = round($diff_seconds / 86400);
        // $remaining_days = $res->no_of_days-$diff_days;
        $obj->query("UPDATE $tbl_student_interview_preparation set no_of_days='$diff_days', class_end_date='$today',status=0,remaining_days='$remaining_days',remark='$remark',branch_changed_by='{$_SESSION['sess_admin_id']}' where id='{$res->id}'",-1);
    }
    $obj->query("UPDATE $tbl_student_status set status_branch='$branch' where stu_id='$id' and cstatus='Start Classes'",-1);
    $obj->query("UPDATE $tbl_student set interview_status='0' where id='$id'",-1);
    
    header("location: student-interview-list.php");
}

if(isset($_POST['submit_no_commission'])){
    $id = $_POST['submit_no_commission'];
    $no = $_POST['no'];
    $obj->query("UPDATE tbl_student_commision set no_of_commission='$no' where stu_id='$id'",-1);
    $obj->query("DELETE FROM tbl_student_commision_details where stu_id='$id'",-1);
    echo 'hgi';
}

if(isset($_POST['get_min_pending_day_id'])){
    $id = $_POST['get_min_pending_day_id'];
    $get = $obj->query("SELECT * FROM tbl_student_interview_preparation where stu_id='$id' and remaining_days is not null order by id desc",-1);
    if($obj->numRows($get) > 0){
        $res = $obj->fetchNextObject($get);
        echo $res->remaining_days;
    }else{
        echo 0;
    }
}

if(isset($_POST['btn_update_duolingo_branch'])){
    extract($_POST);
    $remark = $obj->escapestring($remark);
    $branch_from = getField('branch_id',$tbl_visit,$id);
    $obj->query("INSERT tbl_duolingo_branch set user_id='{$_SESSION['sess_admin_id']}', visit_id='$id',branch_from='$branch_from',branch_to='$branch',remaining_days='$remaining_days',remark='$remark'",-1);
    $obj->query("UPDATE $tbl_visit set dulingo_date_status='0',dulingo_status='0' where id='$id'",-1);
    $obj->query("UPDATE tbl_duolingo_classe set status='0' where visit_id='$id'",-1);
     $obj->query("INSERT $tbl_duolingo_classe SET visit_id='$id', user_id='{$_SESSION['sess_admin_id']}', `class_mode`='Offline', `no_of_days`='$remaining_days',status=0");
     $obj->query("INSERT $tbl_duolingo_final_exam set status=0, visit_status='0', user_id='{$_SESSION['sess_admin_id']}', visit_id='$id'",-1);
     $obj->query("INSERT $tbl_duolingo_exam set status=0, user_id='{$_SESSION['sess_admin_id']}', visit_id='$id'",-1);
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-duolingo-list.php");
}

if(isset($_POST['btn_update_spoken_branch'])){
    extract($_POST);
    $remark = $obj->escapestring($remark);
    $branch_from = getField('branch_id',$tbl_visit,$id);
    $obj->query("INSERT tbl_spoken_branch set user_id='{$_SESSION['sess_admin_id']}', visit_id='$id',branch_from='$branch_from',branch_to='$branch',remaining_days='$remaining_days',remark='$remark'",-1);
    $obj->query("UPDATE $tbl_visit set spoken_date_status='0',spoken_status='0' where id='$id'",-1);
    $obj->query("UPDATE tbl_spoken_classe set status='0' where visit_id='$id'",-1);
    $obj->query("INSERT tbl_spoken_classe SET visit_id='$id', user_id='{$_SESSION['sess_admin_id']}', `no_of_days`='$remaining_days',status=0");
    $_SESSION['sess_msg']='Updated successfully';
    header("location: student-spoken-list.php");
}

if(isset($_POST['btn_first_funding'])){
    print_r($_POST);
    $stu_id = $_POST['stu_id'];
    $c_id = getField('c_id', $tbl_student, $_POST['stu_id']);
    foreach($_POST['funding1'] as $res){
        $obj->query("INSERT tbl_student_function SET stu_id='$stu_id', c_id='$c_id', fund_type='1', `value`='$res', user_id='{$_SESSION['sess_admin_id']}'");
    }
    header("location: student-editf.php?id=".base64_encode(base64_encode(base64_encode($stu_id))));
}

if(isset($_POST['btn_second_funding'])){
    print_r($_POST);
    $stu_id = $_POST['stu_id'];
    $c_id = getField('c_id', $tbl_student, $_POST['stu_id']);
    foreach($_POST['funding2'] as $res){
        $obj->query("INSERT tbl_student_function SET stu_id='$stu_id', c_id='$c_id', fund_type='2', `value`='$res', user_id='{$_SESSION['sess_admin_id']}'");
    }
    header("location: student-editf.php?id=".base64_encode(base64_encode(base64_encode($stu_id))));
}

if(isset($_POST['btn_third_funding'])){
    print_r($_POST);
    $stu_id = $_POST['stu_id'];
    $c_id = getField('c_id', $tbl_student, $_POST['stu_id']);
    foreach($_POST['funding3'] as $res){
        $obj->query("INSERT tbl_student_function SET stu_id='$stu_id', c_id='$c_id', fund_type='3', `value`='$res', user_id='{$_SESSION['sess_admin_id']}'");
    }
    header("location: student-editf.php?id=".base64_encode(base64_encode(base64_encode($stu_id))));
}

if(isset($_POST['update_prog_value'])){
    $country_id = $_POST['country_id'];
    $field = $_POST['field'];
    $prog = $_POST['prog'];
    $update_prog_value = $_POST['update_prog_value'];
    $get = $obj->query("SELECT * FROM tbl_package where country_id='$country_id' and program_type='$prog' and `key`='$field'");
    if($obj->numRows($get) > 0){
        $res = $obj->fetchNextObject($get);
        $obj->query("UPDATE tbl_package set `value`='$update_prog_value' where id='{$res->id}'",-1);
    }else{
        $obj->query("INSERT tbl_package set user_id='{$_SESSION['sess_admin_id']}', `value`='$update_prog_value', country_id='$country_id', program_type='$prog', `key`='$field'",-1);
    }
}

if(isset($_GET['delete_google_sheet'])){
    $id = $_GET['delete_google_sheet'];
    $obj->query("DELETE FROM tbl_google_sheet where id='$id'",-1);
    $_SESSION['sess_msg']='Deleted successfully';
    header("location: google-sheet.php");
}
?>