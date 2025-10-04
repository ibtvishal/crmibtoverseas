<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = " and b.cstatus in ('Start Classes','Classes Completed')";
$whr1 = " and b.cstatus in ('Start Classes','Classes Completed')";
$_SESSION['whr1'] = '';
$oct_date = '2024-10-01';
if($_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 32){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and b.status_branch in ($branchid)";
    $whr1 .= " and b.status_branch in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and b.status_branch in ($branch_id)";
    $whr1 .= " and b.status_branch in ($branch_id)";
}
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 'Pending' || $status == 1){
    if($status == 'Pending'){
        $status = 0;
    }else{
        $status = $status;
    }
    $whr1 .= " and a.immigration_trainning_status='$status'";
    }else{
    if($status == 2){
        $status1 = 0;
    }else{
        $status1 = 1;
    }
    $whr1 .= " and a.interview_status='$status1'";
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
                            Interview Preparation Students
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>Interview Preparation Students</a></span>
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
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 $whr GROUP BY a.id";
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
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 and immigration_trainning_status=0 $whr GROUP BY a.id";
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
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 and immigration_trainning_status=1 $whr GROUP BY a.id";
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
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 and interview_status=1 $whr GROUP BY a.id";
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
                                                                    $q1 = "SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id where 1=1 and interview_status=0 $whr GROUP BY a.id";
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
                                                        <th>Student Id</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <th>Branch Name</th>
                                                        <th>Branch Allocated</th>
                                                        <th>Class Start By</th>
                                                        <th>Class Start Date</th>
                                                        <th>Class End Date</th>
                                                        <th>Status</th>
                                                        <th>Entry Card</th>
                                                        <th>Interview Preparation Status</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31){
                                                        ?>
                                                        <th>Update Branch</th>
                                                        <?php } ?>
                                                        <th>Logs</th>
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
                            <input type="hidden" name="branch_id_stu" id="branch_id_stu" class="form-control">
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
                        <button type="submit" name="btn_submit_class_mode" class="btn btn-primary">Submit</button>
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
    <div class="modal fade" id="get_branch_log_interview" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
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
                                <th>Changed By</th>
                                <th>Branch From</th>
                                <th>Branch To</th>
                                <th>Remark</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody id="get_branch_log_interview1">

                        </tbody>
                    </table>
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
                        <button type="submit" class="btn btn-success" name="btn_update_branch">Submit</button>
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
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
        ],
        <?php }?> "ajax": {
            url: "student-interview-list-ajax.php",
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
    function change_pending_status(id, branch_id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_min_pending_day_id: id
            },
            success: function(data) {
                if (data != 0) {
                    $("#no_of_days").val(data);
                    $("#no_of_days").attr('readonly', 'readonly');
                    // $("#no_of_days").attr("max",data);
                } else {
                    $("#no_of_days").val('');
                    $("#no_of_days").removeAttr('readonly', 'readonly');
                }
            }

        })
        $("#stu_id").val(id);
        $("#branch_id_stu").val(branch_id);
        $("#from_date_logic").modal("show");
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
                get_interview_log: id
            },
            success: function(data) {
                $("#get_interview_log1").modal('show');
                $("#get_interview_log").html(data);
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
                get_branch_log_interview: id
            },
            success: function(data) {
                $("#get_branch_log_interview").modal('show');
                $("#get_branch_log_interview1").html(data);
            }
        })
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