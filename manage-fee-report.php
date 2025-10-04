<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$whr='';
$whr1='';
$status = 0;
if($_SESSION['level_id']!=1){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
}
// if($_SESSION['level_id']==19){
//     $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
//     $whr .= " and a.branch_id in ($branch_id)";
//     $whr1 .= " and a.branch_id in ($branch_id)";
// }
if($_REQUEST['branch']){
    $branchArr = $_REQUEST['branch'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and a.branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
if($_REQUEST['cash_bank']){
    $cash_bank = $_REQUEST['cash_bank'];
    if($cash_bank == 'Cash'){
        $whr .= " and cash IS NOT NULL and bank IS NULL and upi IS NULL and cheque IS NULL and swipe IS NULL";
    }elseif($cash_bank == 'Bank'){
        $whr .= " and cash IS NULL and bank IS NOT NULL and upi IS NOT NULL and cheque IS NOT NULL and swipe IS NOT NULL";
    }else{
        $whr .= "";
    }
  }
if($_REQUEST['payment_type']){
    $payment_type = $_REQUEST['payment_type'];
        $whr .= " and payment_type='$payment_type'";
    $status = 1;
  }
if($_REQUEST['payment']){
    $payment = $_REQUEST['payment'];
    if($payment == 'Approved'){
        $pa = 1;
    }else{
        $pa = 0;
    }
        $whr .= " and audit_status='$pa'";
    $status = 1;
  }
  if($_REQUEST['filter_start_date'] && !$_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $whr .= " and date(b.cdate) = '$filter_start_date'";
    $whr1 .= " and date(b.cdate) = '$filter_start_date'";
  }
  if(!$_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and date(b.cdate) = '$filter_end_date'";
    $whr1 .= " and date(b.cdate) = '$filter_end_date'";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
    $whr1 .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
  }

  $_SESSION['whr'] = $whr;
  $_SESSION['status'] = $status;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Counselling and Enrollment Report</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" id="submit_form" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branch[]" id="branch_id" class="form-control select2" multiple
                                onchange="submit_form()">
                                <?php
                                        if(!empty($_REQUEST['branch'])){
                                        $branchArr = $_REQUEST['branch'];
                                        if(is_array($branchArr)){
                                            $branchArr = $branchArr;
                                        }else{
                                            $branchArr = explode(',',$branchArr);
                                        }
                                        }else{
                                        $branchArr = array();
                                        }     
                                        $b_con = '';                 
                                        if($_SESSION['level_id']!=1){
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $b_con = " and id in ($branch_id)";
                                        }
                                        $branchSql = $obj->query("select * from $tbl_branch where status=1 $b_con");
                                        while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                <option value="<?php echo $branchResult->id; ?>"
                                    <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?>
                                    selected <?php }} ?>><?php echo $branchResult->name; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <!-- <div class="col-md-3">
                            <select name="cash_bank" id="cash_bank" class="form-control" onchange="submit_form()">
                                <option value="">Select Payment Method</option>
                                <option value="Cash" <?=$_REQUEST['cash_bank'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                                <option value="Bank" <?=$_REQUEST['cash_bank'] == 'Bank' ? 'selected' : '' ?>>Bank</option>
                                <option value="Both" <?=$_REQUEST['cash_bank'] == 'Both' ? 'selected' : '' ?>>Both</option>
                            </select>
                        </div> -->
                        <div class="col-md-3">
                            <select name="payment_type" id="payment_type" class="form-control" onchange="submit_form()">
                                <option value="">Select Payment Type</option>
                                <option value="Registration"
                                    <?=$_REQUEST['payment_type'] == 'Registration' ? 'selected' : '' ?>>Registration
                                </option>
                                <option value="Enrollment"
                                    <?=$_REQUEST['payment_type'] == 'Enrollment' ? 'selected' : '' ?>>Enrollment
                                </option>
                                <option value="Direct Enrollment"
                                    <?=$_REQUEST['payment_type'] == 'Direct Enrollment' ? 'selected' : '' ?>>Direct
                                    Enrollment</option>
                                <option value="After Visa"
                                    <?=$_REQUEST['payment_type'] == 'After Visa' ? 'selected' : '' ?>>After Visa
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="payment" id="payment" class="form-control" onchange="submit_form()">
                                <option value="">Select Auditor Status</option>
                                <option value="Approved"
                                    <?=$_REQUEST['payment'] == 'Approved' ? 'selected' : '' ?>>Approved
                                </option>
                                <option value="Pending"
                                    <?=$_REQUEST['payment'] == 'Pending' ? 'selected' : '' ?>>Pending
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top:0.75rem">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')"
                                    onchange="submit_form()">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="filter_end_date" id="filter_end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                    placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')"
                                    onchange="submit_form()">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    $q1 = "select sum(cash) as cash,sum(upi) as upi,sum(bank) as bank,sum(swipe) as swipe,sum(cheque) as cheque from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->fetchNextObject($sqls);
                                                                    echo number_format($lines->cash+$lines->upi+$lines->bank+$lines->swipe+$lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13" style="font-weight: bold !important;text-decoration: underline;">Total
                                                                Amount</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cash,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Cash</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->upi,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                UPI</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->bank,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Net Banking</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Cheque</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->swipe,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Swipe</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    $q1 = "select sum(cash) as cash,sum(upi) as upi,sum(bank) as bank,sum(swipe) as swipe,sum(cheque) as cheque from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.audit_status = 1 $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->fetchNextObject($sqls);
                                                                    echo number_format($lines->cash+$lines->upi+$lines->bank+$lines->swipe+$lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13" style="font-weight: bold !important;text-decoration: underline;">Total Approval
                                                                Amount</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cash,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Approval Cash</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->upi,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                                Approval UPI</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->bank,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Approval Net Banking</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Approval Cheque</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->swipe,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Approval Swipe</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord('Pending')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    $q1 = "select sum(cash) as cash,sum(upi) as upi,sum(bank) as bank,sum(swipe) as swipe,sum(cheque) as cheque from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id  where  1=1 and b.audit_status = 0 $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->fetchNextObject($sqls);
                                                                    echo number_format($lines->cash+$lines->upi+$lines->bank+$lines->swipe+$lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13" style="font-weight: bold !important;text-decoration: underline;">Total Pending
                                                                Amount</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cash,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Pending Cash</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->upi,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Pending UPI</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->bank,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Pending Net Banking</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->cheque,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Pending Cheque</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                            <span class="txt-dark block counter"><span
                                                                    class="">
                                                                    <?php
                                                                    echo number_format($lines->swipe,0);
                                                                     ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">
                                                            Pending Swipe</span>
                                                        </a>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_3s" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Date</th>
                                                        <th>Student Code</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th> 
                                                        <th>Country</th>
                                                        <th>Payment Type</th>
                                                        <th>Branch</th>
                                                        <th>Payment Type</th>
                                                        <th>Amount Received</th>
                                                        <th>Registration Slip</th>
                                                        <th>Enrollment Slip</th>
                                                        <th>After Visa Slip</th>
                                                        <th>Payment History</th>
                                                       
                                                        <th>Accountant Remarks</th>
                                                        <th>Auditor Remarks</th>
                                                        <th>Auditor Approval</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <div id="invoiceModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="img/logo.svg" alt="logo" height="50px">
                        <span style="font-weight: 700; color: black;">Student Payment Details</span>
                        <span></span>
                    </h4>
                </div>
                <div class="modal-body bg-light px-0" id="get_modal_data">

                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/change-status.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>

    <script>
    function submit_form() {
        $("#submit_form").submit();
    }
    </script>
    <script>
    function change_hide_status(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve it?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Approve it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_audit_id: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status" + id).html('Approved');
                            $("#change_hide_status" + id).removeAttr('class');
                            $("#change_hide_status" + id).attr('class', 'btn btn-success');
                        }
                    } 
                })
            }
        });
    }
    </script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });

    var dataTable = $('#datable_3s').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "lengthMenu": [
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]
            }
        ],
        "ajax": {
            url: "manage-fee-report-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
        "createdRow": function(row, data, dataIndex) {
            $('td', row).eq(-5).css('text-align', 'center');
            $('td', row).eq(-4).css('text-align', 'center');
            $('td', row).eq(-3).css('text-align', 'center');
            $('td', row).eq(-2).css('text-align', 'center');
            $('td', row).eq(-1).css('text-align', 'center');
        }
    })
    </script>
    <script>
    function get_modal_data(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                type: 'Registration',
                get_modal_data_fee: 1
            },
            success: function(data) {
                $("#get_modal_data").html(data);
            }
        })
    }
    </script>
    <script>
    function change_remakrs(val,id) {
     
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                remark: val,
                update_remark: 1
            },
            success: function(data) {
                $(".text-success").html('');
                $("#success"+id).html('Remarks Saved');
            }
        })
    }
    </script>
    <script>
        function getAppRecord(val){
            $("#payment").val(val);
            $("#submit_form").submit();
        }
    </script>
</body>


</html>