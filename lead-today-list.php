<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$whr=''; 

if($_SESSION['level_id']==9 || $_SESSION['level_id'] == 25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.crm_executive_id='".$_SESSION['sess_admin_id']."'";
  }

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(a.management_datetime) >= '$filter_start_date' and date(a.management_datetime) <= '$filter_end_date'";
}else{
    $whr .= " and  (seen_status = 0 AND DATE(a.management_datetime) <= '".date('Y-m-d')."') 
        OR (seen_status = 1 AND DATE(a.management_datetime) = '".date('Y-m-d')."')";
}


$_SESSION['whr'] = $whr;


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
    right: 0;
    margin-top: -8px;
    position: absolute;
    top: 0px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}

.material-switch>input[type="checkbox"]:checked+label::before {
    background: inherit;
    opacity: 0.5;
    left: 0;
}

.material-switch>input[type="checkbox"]:checked+label::after {
    background: inherit;
    left: 20px;
}

.dataTables_filter {
    margin-top: -17px !important
}

.dt-buttons {
    float: none !important
}

.buttons-csv {
    float: right !important
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
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Today Leads
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

           
                <form method="post" name="searchfrm" id="searchfrm" action="lead-today-list.php">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_start_date" id="filter_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                                placeholder="Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_end_date" id="filter_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                                placeholder="End Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" name="subit"
                                                class="btn btn-primary download_csv_button"
                                                style="width: 170px; height: 40px;">Submit</button>
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
                                                <div class="row">
                                                    <div class="col-md-12">Color Core: <span style="color:red">Pending
                                                            Daily
                                                            Followups</span>, <span style="color:green">Visited</span>,
                                                        <span style="color:white;background:green">Enrolled</span>
                                                    </div>
                                                </div>
                                                <table id="ApplicationList" class="table table-hover display  pb-30">
                                                    <div class="choose_prog" style="">
                                                    </div>
                                                    <thead>
                                                        <tr>
                                                         
                                                            <th>ID</th>
                                                            <th>Appointment Date & Time</th>
                                                            <th>Applicant Name</th>
                                                            <th>Father Name</th>
                                                            <th>Contact No.</th>
                                                            <th>State</th>
                                                            <th>District</th>
                                                            <th>Visa Type</th>
                                                            <th>Preferred Country</th>
                                                            <th>Branch</th>
                                                            <th>Telecaller</th>
                                                            <th>Source</th>
                                                            <th>Status</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9){
                                                            ?>
                                                            <th>Book Reappointment</th>
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
    <div class="modal fade" id="management_meet" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Select Appointment Date & Time</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off">
                    <input type="hidden" name="appid_pass" id="appid_pass">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="lead_id" id="lead_id" class="form-control">
                            <input type="hidden" name="back_url" id="back_url" value="lead-today-list.php" class="form-control">
                            <input type="datetime-local" name="management_datetime" id="management_datetime" class="form-control"
                                placeholder="Date & Time">
                            <span id="err_university_id_pass" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name='submit_appointment_booking' class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branches",
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
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            }
        ],
        "ajax": {
            url: "lead-today-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
     
    })

    </script>
    <script src="js/change-status.js"></script>
    <script>
    function managent_meet(id) {
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                managent_meet: id,
            },
            success: function(data) {
                $("#management_meet").modal('show');
                $("#lead_id").val(id);
                $("#management_datetime").val(data);
            }
        })
    }
    </script>
</body>

</html>