<?php
ob_start();
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr1'] = '';
$whr1 = " and date(b.cdate) > '2025-04-01'";
if($_SESSION['level_id']==25){
    $whr1 .= " and (b.message LIKE '%\'student_login\'\":\"Not Ok%'
    OR b.message LIKE '%\'location_preference\'\":\"Not Ok%'
    OR b.message LIKE '%\'university_allocation\'\":\"Not Ok%'
    OR b.message LIKE '%\'course_allocation\'\":\"Not Ok%'
    OR b.message LIKE '%\'sponser_clarification\'\":\"Not Ok%'
    OR b.message LIKE '%\'intake_commitment\'\":\"Not Ok%')";
}elseif($_SESSION['level_id']==9){
    $whr1 .= " and b.message LIKE '%\'Payments\'\":\"Not Ok%'";
}else{
    $whr1 .= " and (b.message LIKE '%\'student_login\'\":\"Not Ok%'
    OR b.message LIKE '%\'location_preference\'\":\"Not Ok%'
    OR b.message LIKE '%\'university_allocation\'\":\"Not Ok%'
    OR b.message LIKE '%\'course_allocation\'\":\"Not Ok%'
    OR b.message LIKE '%\'sponser_clarification\'\":\"Not Ok%'
    OR b.message LIKE '%\'Payments\'\":\"Not Ok%'
    OR b.message LIKE '%\'intake_commitment\'\":\"Not Ok%')";
}
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 1){
        $whr1 .= " and b.message LIKE '%\'student_login\'\":\"Not Ok%'";
    }
    elseif($status == 2){
        $whr1 .= " and b.message LIKE '%\'location_preference\'\":\"Not Ok%'";
    }
    elseif($status == 3){
        $whr1 .= " and b.message LIKE '%\'university_allocation\'\":\"Not Ok%'";
    }
    elseif($status == 4){
        $whr1 .= " and b.message LIKE '%\'course_allocation\'\":\"Not Ok%'";
    }
    elseif($status == 5){
        $whr1 .= " and b.message LIKE '%\'sponser_clarification\'\":\"Not Ok%'";
    }
    elseif($status == 6){
        $whr1 .= " and b.message LIKE '%\'intake_commitment\'\":\"Not Ok%'";
    }
    elseif($status == 7){
        $whr1 .= " and b.message LIKE '%\'Payments\'\":\"Not Ok%'";
    }
}
if($_SESSION['level_id']==20){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.branch_id in ($branch_id)";
}
if($_SESSION['level_id']==21){
    $whr1 .= " and a.wc_id ='".$_SESSION['sess_admin_id']."' ";
}
if($_SESSION['level_id']==4){
    $whr1 .= " and a.c_id ='".$_SESSION['sess_admin_id']."' ";
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


.rating {
    border: none;
    float: left;
}

.rating>label {
    color: #90A0A3;
    float: right;
}

.rating>label:before {
    margin: 5px;
    font-size: 2em;
    font-family: FontAwesome;
    content: "\f005";
    display: inline-block;
}

.rating>input {
    display: none;
}

.rating>input:checked~label,
.rating:not(:checked)>label:hover,
.rating:not(:checked)>label:hover~label {
    color: #F79426;
}

.rating>input:checked+label:hover,
.rating>input:checked~label:hover,
.rating>label:hover~input:checked~label,
.rating>input:checked~label:hover~label {
    color: #FECE31;
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
                    <?php echo $_SESSION['sess_msg'];
                    $_SESSION['sess_msg'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Issue Raised Students
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">

                </form>
                <?php
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==25){
                ?>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'student_login\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Student
                                                            Login</span>
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
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'location_preference\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Location
                                                            Preference</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'university_allocation\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">University
                                                            Allocation</span>
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
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'course_allocation\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Course
                                                            Allocation</span>
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
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'sponser_clarification\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Sponser
                                                            Clarification</span>
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
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'intake_commitment\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Intake
                                                            Commitment</span>
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
                <?php }
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==9){
                    ?>
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
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_student as a inner join $tbl_welcome as b on a.id=b.stu_id where 1=1 and b.message LIKE '%\'Payments\'\":\"Not Ok%' group by b.stu_id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Payments
                                                            Amount</span>
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
                <?php
                } ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="ApplicationList" class="table table-hover display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Student Code</th>
                                                    <th>Name</th>
                                                    <th>Country</th>
                                                    <th>Contact</th>
                                                    <th>Branch</th>
                                                    <th>Counsellor Name</th>
                                                    <th>Counsellor Rateing</th>
                                                    <th>Issues</th>
                                                    <?php
                                                    if($_SESSION['level_id'] != 4){
                                                    ?>
                                                    <th>View Profile</th>
                                                    <?php } ?>
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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pay Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-fee.php" method="get">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" class="form-control" id="get_id" name="id" required>
                        <input type="hidden" class="form-control" id="get_type" value="After Visa" name="type" required>
                        <center>
                            <div class="row">
                                <div class="style-radio col-md-6">
                                    <label for="after_visa">After Visa</label>
                                    <input type="radio" name="types" id="after_visa" value="After Visa"
                                        onchange="change_radio(this.value)" checked required>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- model table -->

    <div id="invoiceModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="img/logo.svg" alt="logo" height="50px">
                        <span style="font-weight: 700; color: black;">Student Fee Details</span>
                        <span></span>
                    </h4>
                </div>
                <div class="modal-body bg-light px-0" id="get_modal_data">

                </div>

            </div>
        </div>


        <?php include("footer.php"); ?>
        <script src="js/select2.full.min.js"></script>
        <script src="js/select2.full.min.js"></script>
        <script type="text/javascript">
        $(".select2").select2({
            placeholder: "All Branch",
            allowClear: true
        });

        var dataTable = $('#ApplicationList').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": false,
            "lengthMenu": [
                [10, 50, 100, 500, 1000, 1500],
                [10, 50, 100, 500, 1000, 1500]
            ],
            "pageLength": 10,
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
                url: "welcome-call-issue_raised-student-ajax.php",
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

        function getAppRecord(status) {
            $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
            $("#searchfrm").submit();
        }
        </script>
        <script>
        function get_modal(id) {
            $("#get_id").val(id);
            $("#exampleModal").modal('show');
        }

        function change_radio(val) {
            $("#get_type").val(val);
            $("#exampleModal").modal('show');
        }
        </script>
        <script>
        function get_modal_data(id, payment_type) {
            $.ajax({
                method: "POST",
                url: "controller.php",
                data: {
                    id: id,
                    type: payment_type,
                    get_modal_data_fee: 1
                },
                success: function(data) {
                    $("#get_modal_data").html(data);
                }
            })
        }
        </script>
        <script>
        function getAppRecord(status) {
            $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
            $("#searchfrm").submit();
        }
        </script>
        <script src="js/change-status.js"></script>
</body>

</html>