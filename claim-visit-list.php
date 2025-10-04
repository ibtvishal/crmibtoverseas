<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
$_SESSION['whr1'] = '';
$whr1 = '';
$_SESSION['whr'] = '';
$whr = '';
if($_SESSION['level_id'] == 9){
    $whr1 .= " and b.user_id = {$_SESSION['sess_admin_id']}";
}
if(in_array(4,$addtional_role) || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.branch_id in ($branchid)";
}

if($_REQUEST['status'] && $_REQUEST['status'] != 'total'){
    if($_REQUEST['status'] == 'pending'){
        $status = 0;
    }else{
        $status = $_REQUEST['status'];
    }
    $whr .= " and b.status = $status";
}
$_SESSION['whr1'] = $whr1;
$_SESSION['whr'] = $whr;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.select2-search__field {
    width: 100% !important;
}

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
                <div class="row heading-bg">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Claimed Visit</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#">Claimed Visit</a></span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <form action="" id="searchfrm" method="post"></form>
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord('total')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $q1 = "select a.*,b.user_id,b.status as claim_status,b.updated_by  from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where 1=1 $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->numRows($sqls);
                                                                    echo $lines;
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Claim</span>
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
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord('pending')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $q1 = "select a.*,b.user_id,b.status as claim_status,b.updated_by  from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where b.status=0  $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->numRows($sqls);
                                                                    echo $lines;
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending Claim</span>
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
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
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
                                                                    $q1 = "select a.*,b.user_id,b.status as claim_status,b.updated_by  from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where b.status=1 $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->numRows($sqls);
                                                                    echo $lines;
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Approved Claim</span>
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
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
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
                                                                    $q1 = "select a.*,b.user_id,b.status as claim_status,b.updated_by  from $tbl_visit as a inner join $tbl_visit_claim as b on a.id = b.visit_id where b.status=2  $whr1";
                                                                    $sqls=$obj->query($q1);
                                                                    $lines=$obj->numRows($sqls);
                                                                    echo $lines;
                                                                     ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Disapproved Claim</span>
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
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table id="ApplicationList" class="table  display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Visit ID</th>
                                                            <th>Claimed By</th>
                                                            <th>Updated By</th>
                                                            <th>Visit Date</th>
                                                            <th>Name</th>
                                                            <th>DOB</th>
                                                            <th>Father Name</th>
                                                            <th>Country</th>
                                                            <th>Contact</th>
                                                            <th>Branch</th>
                                                            <th>Approve</th>
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


        <?php include("footer.php"); ?>
        <script src="js/select2.full.min.js"></script>
        <script src="js/change-status.js"></script>
        <script>
        $(document).ready(function() {
            var dataTable = $('#ApplicationList').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": false,
                "lengthMenu": [
                    [50, 100, 500, 1000, 1500, 2000],
                    [50, 100, 500, 1000, 1500, 2000]
                ],
                "pageLength": 50,
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    },
                    {
                        "bSearchable": false,
                        "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                ],
                "ajax": {
                    url: "claim-visit-list-ajax.php",
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
        });
        </script>
        <script>
      function claim(id, user_id, claim_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to approve, disapprove, or transfer it?",
        icon: "warning",
        showCancelButton: false, 
        showConfirmButton: false, 
        showDenyButton: false, 
        showCloseButton: true,
        html: `
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button id="approveButton" class="swal2-confirm swal2-styled" style="background-color: #2ecd99;">Approve</button>
                <button id="disapproveButton" class="swal2-deny swal2-styled" style="background-color: #ed6f56;">Disapprove</button>
                <button id="transferButton" class="swal2-warning swal2-styled">Add Lead</button>
            </div>
        `,
        didRender: () => {
            // Approve button click
            document.getElementById('approveButton').addEventListener('click', () => {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_claim: id,
                        user_id: user_id,
                        claim_id: claim_id,
                        type: 'approve'
                    },
                    success: function(data) {
                        if(data == 1){
                        location.reload();
                        }
                    }
                });
            });

            // Transfer button click
            document.getElementById('transferButton').addEventListener('click', () => {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_claim: id,
                        user_id: user_id,
                        claim_id: claim_id,
                        type: 'transfer'
                    },
                    success: function(data) {
                        if(data == 1){
                        location.reload();
                        }else if(data == 2){
                            Swal.fire({
                                title: "Opps!",
                                text: "This lead already exist",
                                icon: "error"
                            });
                        }
                    }
                });
            });

            // Disapprove button click
            document.getElementById('disapproveButton').addEventListener('click', () => {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_claim: id,
                        user_id: user_id,
                        claim_id: claim_id,
                        type: 'disapprove'
                    },
                    success: function(data) {
                        if(data == 1){
                        location.reload();
                        }
                    }
                });
            });
        }
    });
}

        </script>
        <script>
    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
        </script>
</body>


</html>