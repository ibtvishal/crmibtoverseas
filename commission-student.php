<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = "  and a.visa_id=1";
$whr1 = "  and a.visa_id=1 and b.commission_status='Yes'";
$join = " ";
$join1 = " ";
$_SESSION['join'] = '';
$_SESSION['join1'] = '';
$_SESSION['whr1'] = '';
$_SESSION['half'] = '';
$oct_date = '2024-10-01';
if($_SESSION['level_id'] == 35 || $_SESSION['level_id'] == 25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and a.branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr .= " and a.country_id=$country_id";
    $whr1 .= " and a.country_id=$country_id";
  }
  if($_REQUEST['visa_id']){
    $visa_id = $_REQUEST['visa_id'];
    $whr .= " and a.visa_id=$visa_id";
    $whr1 .= " and a.visa_id=$visa_id";
  }
  if($_REQUEST['student_type']){
    $student_type = $_REQUEST['student_type'];
    $whr .= " and a.student_type=$student_type";
    $whr1 .= " and a.student_type=$student_type";
  }

  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $join = " INNER JOIN tbl_student_commision_details as d on a.id=d.stu_id";
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and date(d.commission_recieved_date) >= '$filter_start_date' and date(d.commission_recieved_date) <= '$filter_end_date'";
    $whr1 .= " and date(d.commission_recieved_date) >= '$filter_start_date' and date(d.commission_recieved_date) <= '$filter_end_date'";
}

if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 2){
        $join = " INNER JOIN tbl_student_commision_details as d on a.id=d.stu_id";
        $whr1 .= " and d.commission_received_amount is not null";
    }
    elseif($status == 3){
        $whr1 .= " and (c.enrollment_status!='Done' or c.enrollment_status is null)";
    }
    elseif($status == 4){
        $join = " INNER JOIN tbl_student_commision_details as d on a.id=d.stu_id";
        $whr1 .= " and d.invoice_status='Created' and (d.commission_received_amount='' or d.commission_received_amount is null)";
    }
    elseif($status == 5){
        $join = " INNER JOIN tbl_student_commision_details as d on a.id=d.stu_id";
        $whr1 .= " and (d.commission_received_amount!='' or d.commission_received_amount is not null)";
    }
    elseif($status == 6){
        $join = " INNER JOIN tbl_student_commision_details as d on a.id=d.stu_id";
        $whr1 .= " and d.invoice_status='Created'";
    }
    elseif($status == 7){
        $join1 = " INNER JOIN tbl_student_commision as e on a.id=e.stu_id";
        $whr1 .= " and e.student_status='Studying'";
    }
    elseif($status == 8){
        $join1 = " INNER JOIN tbl_student_commision as e on a.id=e.stu_id";
        $whr1 .= " and e.student_status='Not Enrolled'";
    }
    elseif($status == 9){
        $join1 = " INNER JOIN tbl_student_commision as e on a.id=e.stu_id";
        $whr1 .= " and e.student_status='Drop out after 1 Semester'";
    }
    elseif($status == 10){
        $join1 = " INNER JOIN tbl_student_commision as e on a.id=e.stu_id";
        $whr1 .= " and e.student_status='Drop out after 2 Semester'";
    }
  }
 
$_SESSION['whr1'] = $whr1;
$_SESSION['join'] = $join;
$_SESSION['join1'] = $join1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.material-switch>input[type="checkbox"] {
    display: none;
}

.material-switch>label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
}

.material-switch>label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position: absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}

.material-switch>label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}

.material-switch>input[type="checkbox"]:checked+label::before {
    background: inherit;
    opacity: 0.5;
}

.material-switch>input[type="checkbox"]:checked+label::after {
    background: inherit;
    left: 20px;
}
</style>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">
                            Commission Student
                        </h5>
                    </div>
                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>Commission Student</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
                    <input type="hidden" name="status1" id="status1">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" onchange="form_submit()"
                                    class="form-control select2" multiple="">
                                    <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                        }elseif(isset($branchids)){
                            $branchArr = $branchids;
                        }else{
                          $branchArr = array();
                        }                      
                        $b_con = '';
                        if($_SESSION['level_id']!==19){
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
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_id" onchange="form_submit()" class="form-control">
                                    <option value="">Country</option>
                                    <?php                       
                          $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_end_date" id="filter_end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                    placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" name="subit" class="btn btn-primary download_csv_button"
                                    style="width: 170px; height: 40px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="commission-student.php">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT a.id as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and a.visa_id=1 and b.commission_status='Yes' $whr GROUP BY a.id",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Commision Students</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows FROM $tbl_student AS a INNER JOIN tbl_student_commision_details AS d on d.stu_id = a.id WHERE d.commission_received_amount is not null $whr group by d.stu_id",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Commission
                                                            Received Students</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id LEFT JOIN tbl_student_commision_details as d on d.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and (c.enrollment_status!='Done' or c.enrollment_status is null) GROUP BY a.id $whr",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not
                                                            Enrolled</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(4)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN tbl_student_commision_details AS d on d.stu_id = a.id WHERE d.invoice_status='Created' and (d.commission_received_amount='' or d.commission_received_amount is null) $whr group by d.stu_id",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Invoice
                                                            Created but receiving pending Students</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(4)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sql= $obj->query("SELECT sum(d.invoice_amount_inr) as total_invoice_amount_inr FROM $tbl_student AS a INNER JOIN tbl_student_commision_details AS d on d.stu_id = a.id WHERE d.invoice_status='Created' and (d.commission_received_amount='' or d.commission_received_amount is null) $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $line->total_invoice_amount_inr;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Invoice
                                                            Created but receiving pending Students Amount</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(5)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT sum(d.commission_received_amount) as total_commission_received_amount FROM $tbl_student AS a INNER JOIN tbl_student_commision_details AS d on d.stu_id = a.id WHERE (d.commission_received_amount!='' or d.commission_received_amount is not null) $whr",$debug=-1);
                                                                     $lines = $obj->fetchNextObject($sql1);
                                                                     echo $lines->total_commission_received_amount ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Commission Received</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(6)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN tbl_student_commision_details AS d on d.stu_id = a.id WHERE d.invoice_status='Created' $whr group by d.stu_id",$debug=-1);
                                                                     $lines = $obj->numRows($sql1);
                                                                     echo $lines ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Invoice Created</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT a.id FROM $tbl_student AS a $join INNER JOIN tbl_student_commision AS e on e.stu_id = a.id WHERE e.student_status='Studying' $whr group by e.stu_id",$debug=-1);
                                                                     $lines = $obj->numRows($sql1);
                                                                     echo $lines ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Studying Student</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(8)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT a.id FROM $tbl_student AS a $join INNER JOIN tbl_student_commision AS e on e.stu_id = a.id WHERE e.student_status='Not Enrolled' $whr group by e.stu_id",$debug=-1);
                                                                     $lines = $obj->numRows($sql1);
                                                                     echo $lines ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not Enrolled Student</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(9)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT a.id FROM $tbl_student AS a $join INNER JOIN tbl_student_commision AS e on e.stu_id = a.id WHERE e.student_status='Drop out after 1 Semester' $whr group by e.stu_id",$debug=-1);
                                                                     $lines = $obj->numRows($sql1);
                                                                     echo $lines ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Drop out after 1 Semester Student</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(10)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $sql1 = $obj->query("SELECT a.id FROM $tbl_student AS a $join INNER JOIN tbl_student_commision AS e on e.stu_id = a.id WHERE e.student_status='Drop out after 2 Semester' $whr group by e.stu_id",$debug=-1);
                                                                     $lines = $obj->numRows($sql1);
                                                                     echo $lines ?? 0;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Drop out after 2 Semester Student</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Name</th>
                                                        <th>Student Id</th>
                                                        <th>DOB</th>
                                                        <th>Portal Name</th>
                                                        <th>Student Portal ID</th>
                                                        <th>Application Portal ID</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Class Start Date</th>
                                                        <th>Branch</th>
                                                        <th>University</th>
                                                        <th>Course</th>
                                                        <th>Tuition Fees Paid</th>
                                                        <th>Enrollment Status</th>
                                                        <th>Total Commission Received</th>
                                                        <th>Action</th>
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
                </form>

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
    <div class="modal fade" id="get_comission" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Enter Details</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off">
                    <input type="hidden" name="stu_id" id="get_comission1" class="form-control">
                    <div class="modal-body">
                        <div class="form-group mb-20">
                            Student Portal Id
                            <input type="text" name="stu_portal_id" id="stu_portal_id" class="form-control"
                                placeholder="Student Portal Id" required>
                        </div>
                        <div class="form-group mb-20">
                            Application Portal Id
                            <input type="text" name="app_portal_id" id="app_portal_id" class="form-control"
                                placeholder="Application Portal Id" required>
                        </div>
                        <!-- <div class="form-group mb-20">
                            Class Start Date
                            <input type="date" name="class_start_date" id="class_start_date" class="form-control"
                                placeholder="Class Start Date" style="line-height: 20px;">
                        </div> -->
                        <div class="form-group mb-20">
                            No of Semesters
                            <input type="number" name="no_of_commission" id="no_of_commission" class="form-control"
                                placeholder="No of Semesters" min='1' max='8' required>
                        </div>
                        <!-- <div class="form-group mb-20">
                            Total Tuition Fee
                            <input type="number" name="total_tuition_fee" id="total_tuition_fee" class="form-control"
                                placeholder="Total Tuition Fee" min='1' max='8'>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name='submit_get_comission' class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>

    <script>
    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
        ],
        "pageLength": 10,
        "aoColumnDefs": [{
                "targets": 0, // First column (Sr. No.)
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
        ],
        "ajax": {
            url: "commission-student-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        }
    });
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function form_submit() {
        $("#searchfrm").submit();
    }
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>
    <script>
    function submit_data(val) {
        $("#status").val(val);
        $("#searchfrm").submit();
    }
    </script>
    <script>
    function get_comission(id) {
        $("#get_comission1").val(id);
        $("#get_comission").modal('show');
    }
    </script>
    <script>
    function getAppRecord(id) {
        $('#searchfrm').append('<input name="status" value="' + id + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
</body>

</html>