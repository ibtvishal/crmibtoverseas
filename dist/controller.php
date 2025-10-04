<?php 
session_start();
include('include/config.php');
include("include/functions.php");


if(isset($_POST['btn_add_file'])){
    $name = $obj->escapestring($_POST['file_name']);
    $category_id = $obj->escapestring($_POST['category_id']);
    $subcat_id = $obj->escapestring($_POST['subcat_id']);

    if($_FILES['file']['name']!=''){
        $file_name = 'file-'.rand('1','10000').'-'.$_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, 'uploads/'.$file_name);
    }

 $insert = $obj->query("INSERT `tbl_file` SET `category_id`='$category_id',`subcategory_id`='$subcat_id',`file_name`='$name',`file`='$file_name'");
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

    if($_FILES['file']['name']!=''){
        $file_name = 'file-'.rand('1','10000').'-'.$_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, 'uploads/'.$file_name);
    }else{
        $file_name = $obj->escapestring($_POST['old_file']);
    }

 $insert = $obj->query("UPDATE `tbl_file` SET `category_id`='$category_id',`subcategory_id`='$subcat_id',`file_name`='$name',`file`='$file_name' WHERE id='$id'");
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
    $sql="INSERT $tbl_enrolled_fee SET `country_id`='$country_id',`visa_type`='$visa_type',`amount`='$amount',`gst`='$gst',`discount`='$discount',`after_visa_amount`='$after_visa_amount',`after_visa_gst`='$after_visa_gst',`after_visa_discount`='$after_visa_discount'"; 
    $obj->query($sql);
    $sess_msg='Enrolled Fee Added successfully';
    $_SESSION['sess_msg']=$sess_msg;
    header("location: add-enrolled-fee.php");
}
if(isset($_POST['btn_update_enrolled_fee'])){
    extract($_POST);
    $gst = intval($_POST['gst']);
    $after_visa_gst = intval($_POST['after_visa_gst']);
    $sql="UPDATE $tbl_enrolled_fee SET `country_id`='$country_id',`visa_type`='$visa_type',`amount`='$amount',`gst`='$gst',`discount`='$discount',`after_visa_amount`='$after_visa_amount',`after_visa_gst`='$after_visa_gst',`after_visa_discount`='$after_visa_discount' WHERE id='$id'"; 
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
    $payment_type = $_POST['payment_type'];
    $date = $_POST['date'];
    // print_r($_POST);die;
   if(count($_POST['visa_type']) > 0){
    $visa_type = implode(",", $_POST['visa_type']);
    $sql="UPDATE $tbl_visit SET `visa_type`='$visa_type' WHERE id='$id'"; 
    $obj->query($sql);
   }

   $c = '';
   if($_POST['registration_amount'] != ''){
    $c .= " ,registration_amount=".$_POST['registration_amount'];
   }
   if($_POST['gst_amount'] != ''){
    $gst = intval($_POST['gst_amount']);
    $c .= " ,gst_amount='$gst'";
   }
   if($_POST['total_amount'] != ''){
    $c .= " ,total_amount=".$_POST['total_amount'];
   }
   if($_POST['bank'] != ''){
    $c .= " ,bank=".$_POST['bank'];
   }
   if($_POST['cash'] != ''){
    $c .= " ,cash=".$_POST['cash'];
   }
   if($_POST['enrollment_amount'] != ''){
    $c .= " ,enrollment_amount=".$_POST['enrollment_amount'];
   }
   if($_POST['amount_already_paid'] != ''){
    $c .= " ,amount_already_paid=".$_POST['amount_already_paid'];
   }
   if($_POST['pending_enrollement_amount'] != ''){
    $c .= " ,pending_enrollement_amount=".$_POST['pending_enrollement_amount'];
   }
   if($_POST['discount_amount'] != ''){
    $c .= " ,discount_amount=".$_POST['discount_amount'];
   }
   if($_POST['net_amount'] != ''){
    $c .= " ,net_amount=".$_POST['net_amount'];
   }
   if($_POST['bank_tid'] != ''){
    $c .= " ,bank_tid='".$_POST['bank_tid']."'";
   }
   if($_POST['upi'] != ''){
    $c .= " ,upi=".$_POST['upi'];
   }
   if($_POST['upi_tid'] != ''){
    $c .= " ,upi_tid='".$_POST['upi_tid']."'";
   }
   if($_POST['cheque'] != ''){
    $c .= " ,cheque=".$_POST['cheque'];
   }
   if($_POST['cheque_tid'] != ''){
    $c .= " ,cheque_tid='".$_POST['cheque_tid']."'";
   }
   if($_POST['swipe'] != ''){
    $c .= " ,swipe=".$_POST['swipe'];
   }
   if($_POST['swipe_tid'] != ''){
    $c .= " ,swipe_tid='".$_POST['swipe_tid']."'";
   }
   if($_POST['fee_id'] == ''){
       $sql_v= $obj->query("select * from $tbl_visit WHERE id='$id'"); 
       $visa =$obj->fetchNextObject($sql_v);
    $get_r = $obj->query("select a.* from $tbl_visit_fee as a inner join $tbl_visit as b on b.id = a.visit_id where b.branch_id = '".$visa->branch_id."'  order by code desc");
    $res_r = $obj->fetchNextObject($get_r);
    $count_r = $obj->numRows($get_r);

    $get_branch = substr(getField('branch_code',$tbl_branch,$visa->branch_id), 0, 3);
    if($count_r > 0){
        if($res_r->id < 10){
            $zeros = '00';
        }elseif($res_r->id > 9 && $res_r->id < 100){
            $zeros = '0';
        }else{
            $zero = '';
        }
        $code = $res_r->code+1;
        $reciept_no = $get_branch.$zeros.$code;
    }else{
        $code = 1;
        $reciept_no = $get_branch.'001';
    }
      
       $c .= " ,code='$code'";
       $c .= " ,reciept_no='$reciept_no'";
       $obj->query("UPDATE $tbl_visit_fee SET status='0' WHERE visit_id='$id'");
   $sql="INSERT $tbl_visit_fee SET visit_id='$id', payment_type='$payment_type',payment_date='$date' $c"; 
   echo $sql;
   }else{
       $sql="UPDATE $tbl_visit_fee SET visit_id='$id', payment_type='$payment_type',payment_date='$date' $c WHERE id='".$_POST['fee_id']."'"; 
   }
   $obj->query($sql);

   header("location:slip.php?id=".base64_encode(base64_encode(base64_encode($id)))."&type=".$payment_type.""); 
}

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
            <td>Visit Code</td>
            <td>:</td>
            <td> <?=$result->enquiry_id?></td>
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
            <td>₹ <?=$result_fee->registration_amount-$result_fee->gst_amount?></td>
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
                         $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type in ('Enrollment','Direct Enrollment')");
                         $result_fee2 = $obj->fetchNextObject($sql2);
                         $totalFiltered=$obj->numRows($sql2);
                        if($totalFiltered > 0){
                            ?>
    <!-- <p class="table-devider"></p> -->
    <p class="text-center bg-white table-title" style="font-weight:bold;color:black">Enrollment Payment History</p>
    <table class="table table-sm mb-3">
        <tr>
            <th>Enrollment Fee Details</th>
            <td>:</td>
            <th><?=date('d M, Y',strtotime($result_fee2->payment_date))?></th>
        </tr>
        <tr>
            <td>Enrollment Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->enrollment_amount?></td>
        </tr>
        <?php
                                    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                                    $result2 = $obj->fetchNextObject($sql2);
                                    $result_fee_count = $obj->numRows($sql2);
                                    if($result_fee_count > 0){
                                        ?>
        <tr>
            <td>Amount Already Paid</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->amount_already_paid?></td>
        </tr>
        <tr>
            <td> Pending Enrollment Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->pending_enrollement_amount?></td>
        </tr>
        <?php
                                    }
                                ?>
        <tr>
            <td>Discount Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->discount_amount?></td>
        </tr>
        <tr>
            <td>Net Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->net_amount-$result_fee2->gst_amount?></td>
        </tr>
        <tr>
            <td>GST Amount</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->gst_amount?></td>
        </tr>
        <tr class="total">
            <td>TOTAL</td>
            <td>:</td>
            <td>₹ <?=$result_fee2->total_amount + $result_fee2->amount_already_paid?></td>
        </tr>
        <?php
        if($result_fee2->cash != '' && $result_fee2->cash != '0'){
        ?>
        <tr>
            <th>Cash</th>
            <td>:</td>
            <th>₹ <?=$result_fee2->cash?></th>
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
     
    </table>
    <?php }
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
            <td>₹ <?=$result_fee3->net_amount-$result_fee3->gst_amount?></td>
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
     
    </table>
    <?php
                        } ?>
</div>
<?php
}

if(isset($_GET['chagne_audit_fee'])){
    echo "update tbl_visit_fee set audit_status = 1 where id='".$_GET['chagne_audit_fee']."'";die;
    $sql=$obj->query("update tbl_visit_fee set audit_status = 1 where id='".$_GET['chagne_audit_fee']."'");
    $url = '';
    if(isset($_GET['branch'])){
        $url .= '&branch='.$_GET['branch'];
    }
    if(isset($_GET['date'])){
        $url .= '&date='.$_GET['date'];
    }
    header('location:manage-fee-report.php?'.$url);
}
?>