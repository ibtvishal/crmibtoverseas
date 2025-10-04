<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = " and a.enrollment_counselor_date is not null";
$whr1 = " and a.enrollment_counselor_date is not null";
$_SESSION['whr1'] = '';
$oct_date = '2024-10-01';
if($_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 33){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and b.duolingo_branch in ($branchid)";
    $whr1 .= " and b.duolingo_branch in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and b.duolingo_branch in ($branch_id)";
    $whr1 .= " and b.duolingo_branch in ($branch_id)";
}
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 2){
        $whr1 .= " and a.dulingo_date_status='0'";
    }
    elseif($status == 3){
        $whr1 .= " and a.dulingo_date_status='1'";
    }
    elseif($status == 'Pending'){
        $whr1 .= " and a.dulingo_status='0'";
    }
    elseif($status == '1'){
        $whr1 .= " and a.dulingo_status='1'";
    }

  }
$_SESSION['whr1'] = $whr1;
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

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
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
                            Duolingo Students
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>Duolingo Students</a></span>
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
                                        selected <?php } } ?>><?php echo $branchResult->name; ?></option>
                                    <?php }?>
                                </select>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)">
                                                        <span class="txt-dark block counter"><span class="">
                                                                <?php
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 $whr GROUP BY a.id";
                                                                    echo $obj->numRows($obj->query($q1));
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13"
                                                            style="font-weight: bold !important;text-decoration: underline;">Total
                                                            Student</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Pending')">
                                                        <span class="txt-dark block counter"><span class="">
                                                                <?php
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 and dulingo_status=0 $whr GROUP BY a.id";
                                                                    echo $obj->numRows($obj->query($q1));
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13"
                                                            style="font-weight: bold !important;text-decoration: underline;">Pending</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('1')">
                                                        <span class="txt-dark block counter"><span class="">
                                                                <?php
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 and dulingo_status=1 $whr GROUP BY a.id";
                                                                    echo $obj->numRows($obj->query($q1));
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13"
                                                            style="font-weight: bold !important;text-decoration: underline;">Accepted</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('3')">
                                                        <span class="txt-dark block counter"><span class="">
                                                                <?php
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 and dulingo_date_status=1 $whr GROUP BY a.id";
                                                                    echo $obj->numRows($obj->query($q1));
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13"
                                                            style="font-weight: bold !important;text-decoration: underline;">Active</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('2')">
                                                        <span class="txt-dark block counter"><span class="">
                                                                <?php
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_visit AS a INNER JOIN $tbl_duolingo_classe AS b on b.visit_id = a.id where 1=1 and dulingo_date_status=0 $whr GROUP BY a.id";
                                                                    echo $obj->numRows($obj->query($q1));
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13"
                                                            style="font-weight: bold !important;text-decoration: underline;">Inactive</span>
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
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                        </div>
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Code</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Student Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Branch Name</th>
                                                        <th>Class Mode</th>
                                                        <th>No. Of Days</th>
                                                        <th>Desired Score</th>
                                                        <th>Class Start Date</th>
                                                        <th>Class End Date</th>
                                                        <th>Accept</th>
                                                        <th>Exam Status</th>
                                                        <th>Exam Final Status</th>
                                                        <th>Status</th>
                                                        <th>Entry Card</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
                                                        ?>
                                                        <th>Update Branch</th>
                                                        <?php } ?>
                                                        <!-- <th>Action</th> -->
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

    <div class="modal" id="from_date_logic" tabindex="-1" role="dialog">
        <form method="post" action="controller.php">
            <input type="hidden" name="note_id" id="note_id" value="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            Class Mode
                            <input type="hidden" name="stu_id" id="stu_id" class="form-control">
                            <select required name="class_mode" id="class_mode" class="form-control"
                                placeholder="Enter Class Mode">
                                <option value="">Select Class Mode</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                            <span id="err_class_mode" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            No of days
                            <input required type="number" name="no_of_days" id="no_of_days" class="form-control"
                                placeholder="Enter No of days">
                            <span id="err_no_of_days" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btn_submit_class_mode_duolingo"
                            class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="get_interview_log1" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Logs</h5>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Class start by</th>
                                <th>Class Mode</th>
                                <th>No. Of Days</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="get_interview_log">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="get_all_record" tabindex="-1" role="dialog"
        aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Exam Status</h5>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Move to Exam By</th>
                                <th>Mock Score</th>
                                <th>Duolingo Official Email</th>
                                <th>Duolingo Official Password</th>
                                <th>Status</th>
                                <th>Approved/Not Approved By</th>
                                <th>Remark</th>
                                <th>Date/Time of Exam</th>
                            </tr>
                        </thead>
                        <tbody id="get_all_record1">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="final_record" tabindex="-1" role="dialog"
        aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Exam Status</h5>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Final Status At</th>
                                <th>Final Status By</th>
                                <th>Appear Date & Time</th>
                                <th>Final Bond Score</th>
                                <th>Remark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="final_record1">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="get_duolingo_dezire_score" tabindex="-1" role="dialog"
        aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Exam Status</h5>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Added By</th>
                                <th>Duolingo Score</th>
                                <th>Crated At</th>
                            </tr>
                        </thead>
                        <tbody id="get_duolingo_dezire_score1">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="get_duolingo_branch_log" tabindex="-1" role="dialog"
        aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Exam Status</h5>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Update By</th>
                                <th>Branch From</th>
                                <th>Branch To</th>
                                <th>Remark</th>
                                <th>Crated At</th>
                            </tr>
                        </thead>
                        <tbody id="get_duolingo_branch_log1">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="get_interview_log2" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Desired Score</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post">
                        Desired Score
                        <input type="hidden" id="dezired_score_id" name="dezired_score_id" class="form-control">
                        <input type="number" name="dezired_score" class="form-control">
                        <button type="submit" name="btn_dezired_score" class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="move_to_exam1" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Duolingo Details</h5>
                </div>
                <div class="modal-body" id="move_to_exam1_data">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approve_move_to_exam" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Date Time of Exam</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="approvemove_to_exam" name="id" class="form-control">
                        Date Time of Exam
                        <input type="datetime-local" name="date_time_exam" class="form-control mb-10"
                            placeholder="Date Time of Exam">
                        Remark
                        <input type="text" name="remark" class="form-control mb-10" placeholder="Remark">
                        <button type="submit" name="btn_approve_move_to_exam"
                            class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notapprove_move_to_exam" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Remark</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="notapproveemove_to_exam" name="id" class="form-control">
                        Remark
                        <input type="text" name="remark" class="form-control mb-10" placeholder="Renark">
                        <button type="submit" name="btn_not_approve_move_to_exam"
                            class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="invalid_remark" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Invalid Remark</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="invalid_remark_id" name="id" class="form-control">
                        Remark
                        <input type="text" name="remark" class="form-control mb-10" placeholder="Renark" required>
                        <button type="submit" name="btn_invalid_remark" class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="invalid_reapply_remark" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Invalid Remark</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="invalid_reapply_remark_id" name="id" class="form-control">
                        Remark
                        <input type="text" name="remark" class="form-control mb-10" placeholder="Renark" required>
                        Date & Time
                        <input type="datetime-local" name="date_time_exam" class="form-control mb-10"
                            placeholder="Date Time of Exam" required>
                        <button type="submit" name="btn_invalid_reapply_remark"
                            class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="success_remark" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Upload result PDF</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="success_remark_id" name="id" class="form-control">
                        Final Exam score
                        <input type="number" name="band_score" class="form-control mb-10" placeholder="Final Exam score"
                            required>
                        Upload result PDF
                        <input type="file" name="file" class="form-control mb-10" placeholder="Renark" required>
                        <button type="submit" name="btn_success_remark" class="btn btn-success mt-20">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update_branch" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="statusModalLabeladd">Update Branch</h5>
                </div>
                <div class="modal-body">
                    <form action="controller.php" method="post" class="">
                        <input type="hidden" name="id" id="update_branch1">
                        <select name="branch" class="form-control mb-20">
                            <option value="">Select Branch</option>
                            <?php
                            $branchSql = $obj->query("select * from $tbl_branch where status=1 $b_con");
                            while($branchResult = $obj->fetchNextObject($branchSql)){?>
                            <option value="<?php echo $branchResult->id; ?>"><?php echo $branchResult->name; ?></option>
                            <?php }?>
                        </select>
                        <div class="form-group mv-20">
                            Remaining days
                            <input required type="number" name="remaining_days" id="remaining_days" class="form-control"
                                placeholder="Remaining days">
                        </div>
                        <div class="form-group mv-20">
                            Remark
                            <input required type="text" name="remark" id="remark" class="form-control"
                                placeholder="Remark">
                        </div>
                        <button type="submit" class="btn btn-success" name="btn_update_duolingo_branch">Submit</button>
                    </form>
                </div>
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
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        <?php  
      if ($_SESSION['level_id']==1  || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==25){?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
            }
        ],
        <?php }?> "ajax": {
            url: "student-duolingo-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        }
    })
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
    function change_pending_status(id) {
        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "Do you want to approve it?",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#3085d6",
        //     cancelButtonColor: "#d33",
        //     confirmButtonText: "Yes, Approve it!"
        // }).then((result) => {
        //     if (result.isConfirmed) {
        $("#stu_id").val(id);
        $("#from_date_logic").modal("show");
        // $.ajax({
        //     method: "POST",
        //     url: "controller.php",
        //     data: {
        //         change_immigration_status_id: id
        //     },
        //     success: function(data) {
        //         location.reload();
        //     }
        // })
        //     }
        // });

    }
    </script>
    <script>
    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
    <script>
    function get_log(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_duolingo_log: id
            },
            success: function(data) {
                $("#get_interview_log1").modal('show');
                $("#get_interview_log").html(data);
            }
        })
    }
    </script>
    <script>
    function get_all_record(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_all_record: id
            },
            success: function(data) {
                $("#get_all_record").modal('show');
                $("#get_all_record1").html(data);
            }
        })
    }
    </script>
    <script>
    function final_record(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                final_record: id
            },
            success: function(data) {
                $("#final_record").modal('show');
                $("#final_record1").html(data);
            }
        })
    }
    </script>
    <script>
    function change_pending_status1(id) {
        $("#dezired_score_id").val(id);
        $("#get_interview_log2").modal('show');
    }
    </script>
    <script>
    function move_to_exam(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                duolingo_details: id
            },
            success: function(data) {
                $("#move_to_exam1_data").html(data);
                $("#move_to_exam1").modal('show');
            }
        })

    }
    </script>
    <script>
    function get_duolingo_dezire_score(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_duolingo_dezire_score: id
            },
            success: function(data) {
                $("#get_duolingo_dezire_score1").html(data);
                $("#get_duolingo_dezire_score").modal('show');
            }
        })

    }
    </script>
    <script>
    function get_branch_log(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_duolingo_branch_log: id
            },
            success: function(data) {
                $("#get_duolingo_branch_log1").html(data);
                $("#get_duolingo_branch_log").modal('show');
            }
        })

    }
    </script>
    <script>
    function move_to_exam1(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve it?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Approved",
            cancelButtonText: "Not Approved"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#approvemove_to_exam").val(id);
                $("#approve_move_to_exam").modal('show');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                $("#notapproveemove_to_exam").val(id);
                $("#notapprove_move_to_exam").modal('show');
            }
        });
    }
    </script>
    <script>
    function change_final_status(id, val) {
        if (val == '1') {
            $("#success_remark").modal('show');
            $("#success_remark_id").val(id);
        } else if (val == '2') {
            $("#invalid_remark").modal('show');
            $("#invalid_remark_id").val(id);
        } else if (val == '3') {
            $("#invalid_reapply_remark").modal('show');
            $("#invalid_reapply_remark_id").val(id);
        } else if (val == '4') {
            $.ajax({
                method: "POST",
                url: "controller.php",
                data: {
                    banned_final_exam: id
                },
                success: function(data) {
                    location.reload();
                }
            })
        }
    }
    </script>
    <script>
    function update_branch(id) {
        $("#update_branch").modal('show');
        $("#update_branch1").val(id);
    }
    </script>
</body>

</html>