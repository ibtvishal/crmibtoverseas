<?php
ob_start();
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr1'] = '';
$_SESSION['whr'] = '';
$whr = '';
$whr1 = '';
if($_SESSION['sess_admin_id'] == 155){

}else{
    if($_SESSION['level_id']!=1){
        $whr .= " and crm_executive_id = '".$_SESSION['sess_admin_id']."'";
        $whr1 .= " and crm_executive_id = '".$_SESSION['sess_admin_id']."'";
    }
}
    
    if($_REQUEST['start_date'] && $_REQUEST['end_date']){
        $filter_start_date = $_REQUEST['start_date'];
        $filter_end_date = $_REQUEST['end_date'];
        $whr .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
        $whr1 .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
    }
    if($_REQUEST['status']){
        $status = $_REQUEST['status'];
        if($status == 'Pending'){
            $whr1 .= " and status='0'";
        }else{
            $whr1 .= " and ((status='$status' and status1 is null) or (status1='$status' and status2 is null) or status2='$status')";
        }
    }
    if($_REQUEST['remark']){
        $remark = $_REQUEST['remark'];
        $whr1 .= " and ((status='$remark' and status1 is null) or (status1='$remark' and status2 is null) or status2='$remark')";
        
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
                    <?php echo $_SESSION['sess_msg1'];
                    $_SESSION['sess_msg1'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage enquiry
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" id="form-submit" method="post">
                    <input type="hidden" name="status" id="status">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class='form-control form-select' name="remark" onchange="form_submit()">
                                    <option value=''>Select Remark</option>
                                    <option value='1' <?=$_REQUEST['remark'] == '1' ? 'selected' : ''?>>Interested
                                    </option>
                                    <option value='2' <?=$_REQUEST['remark'] == '2' ? 'selected' : ''?>>Not Interested
                                    </option>
                                    <option value='3' <?=$_REQUEST['remark'] == '3' ? 'selected' : ''?>>Unable to
                                        Connect</option>
                                    <option value='5' <?=$_REQUEST['remark'] == '5' ? 'selected' : ''?>>Close Enquiry
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="end_date" id="end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['end_date']; ?>"
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)"
                                                        onclick="window.location.href='manage-enquiry.php'">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_enquiry where 1=1 $whr GROUP BY number",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Enquiries</span>
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
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_enquiry where 1=1 and status='0' $whr GROUP BY number",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            Remarks</span>
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
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows from $tbl_enquiry where 1=1 and ((`status`='1' and status1 is null) or (status1='1' and status2 is null) or status2='1') $whr GROUP BY `number`",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Interested
                                                            Enquiries</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows from $tbl_enquiry where 1=1 and ((`status`='2' and status1 is null) or (status1='2' and status2 is null) or status2='2') $whr GROUP BY `number`",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not Interested
                                                            Enquiries</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows from $tbl_enquiry where 1=1 and ((`status`='3' and status1 is null) or (status1='3' and status2 is null) or status2='3') $whr GROUP BY `number`",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Unable to Connect Enquiries</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(5)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("SELECT COUNT(*) as num_rows from $tbl_enquiry where 1=1 and ((`status`='5' and status1 is null) or (status1='5' and status2 is null) or status2='5') $whr GROUP BY `number`",$debug=-1);
                                                                    $line=$obj->numRows($sql);
                                                                    echo $totalVisit = $line;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Close Enquiry Enquiries</span>
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
                                        <div class="table-responsive">
                                            <table id="ApplicationList" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Mobile Number</th>
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <th>Url</th>
                                                        <th>Remark 1</th>
                                                        <th>Remark 2</th>
                                                        <th>Remark 3</th>
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

    <div class="modal fade" id="enquiry_form" tabindex="-1" role="dialog" aria-labelledby="applicationPassModalLabeladd"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Enter Remark</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off" id="form-validate">
                    <input type="hidden" name="enquiry_id" id="enquiry_id">
                    <input type="hidden" name="status" id="type">
                    <input type="hidden" name="column" id="column_name">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="remark" id="remark" class="form-control" placeholder="Remark"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_btn" name='submit_expected_enrollment_date'
                            class="btn btn-primary">Submit</button>
                    </div>
                </form>

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
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3]
            }
        ],
        "ajax": {
            url: "manage-enquiry-ajax.php",
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
    function change_manage_enquiry(val, id, column, type) {
        if (val == '') {
            alert("Please select status");
            return
        }
        if(val == 6){
            $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                val: val,
                change_to_enquiry_id: id,
                column: column
            },
            success: function(data) {
                location.reload();
            }
        })
        }else{
        $("#remark").val('');
        $("#type").val(val);
        $("#column_name").val(column);
        $("#enquiry_id").val(id);
        $("#enquiry_form").modal('show');
            if (val == 1) {
                $("#form-validate").prop('target', '_blank');
                $("#submit_btn").html('Move to Lead')
            } else {
                $("#form-validate").prop('target', '');
                $("#submit_btn").html('Add Remark')
            }
        }
        // $.ajax({
        //     method: "POST",
        //     url: "controller.php",
        //     data: {
        //         val: val,
        //         id: id,
        //         column: column
        //     },
        //     success: function(data) {
        //         $(".manage_enquiry_" + id).css("color", "inherit");
        //         if (val == 2 || val == 4 || val == 5) {
        //             $(".manage_enquiry_select1_" + id).prop("disabled", true);
        //             $(".manage_enquiry_select2_" + id).prop("disabled", true);
        //             $(".manage_enquiry_select3_" + id).prop("disabled", true);
        //         } else {
        //             if (type == 1) {
        //                 $(".manage_enquiry_select1_" + id).prop("disabled", false);
        //                 $(".manage_enquiry_select2_" + id).prop("disabled", false);
        //                 $(".manage_enquiry_select3_" + id).prop("disabled", true);
        //             } else if (type == 2) {
        //                 $(".manage_enquiry_select1_" + id).prop("disabled", true);
        //                 $(".manage_enquiry_select2_" + id).prop("disabled", false);
        //                 $(".manage_enquiry_select3_" + id).prop("disabled", false);
        //             } else if (type == 3) {
        //                 $(".manage_enquiry_select1_" + id).prop("disabled", true);
        //                 $(".manage_enquiry_select2_" + id).prop("disabled", true);
        //                 $(".manage_enquiry_select3_" + id).prop("disabled", false);
        //             }
        //         }
        //     }
        // })
    }
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function getAppRecord(val) {
        $("#status").val(val);
        $("#form-submit").submit();
    }
    </script>
    <script>
    document.getElementById('form-validate').addEventListener('submit', function() {
        setTimeout(function() {
            window.location.href = 'manage-enquiry.php';
        }, 1000);
    });
    </script>

    <script>
    function form_submit() {
        $("#form-submit").submit();
    }
    </script>
</body>

</html>