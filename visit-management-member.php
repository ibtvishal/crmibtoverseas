<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$addtional_role = explode(',', $_SESSION['additional_role']);
if($_SESSION['level_id'] == 11 || in_array(1, $addtional_role)){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr=" and branch_id in ($branchid) and management_member_date='".date("Y-m-d")."'";
}else{
    $whr=" and management_member='".$_SESSION['sess_admin_id']."' and management_member_date='".date("Y-m-d")."'";
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
                        <h5 class="txt-dark">New Visit Meet
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>
                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-12r">Color Code: <span style="color:red">Not Meet</span>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="ApplicationList" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Enrollment Paid Date</th>
                                                        <th>Name</th>
                                                        <th>DOB</th>
                                                        <th>Father Name</th>
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <th>Visa Sub Type</th>
                                                        <th>Contact</th>
                                                        <th>Source</th>
                                                        <th>Address</th>
                                                        <th>Branch</th>
                                                        <th>Counsellor</th>
                                                        <th>Telecaller</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 11 || in_array(1, $addtional_role)){
                                                            echo '<th>Manamgent Member</th>';
                                                        }
                                                        ?>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){
                                                        ?>
                                                        <th>Action</th>
                                                        <?php
                                                        }
                                                        if($_SESSION['level_id'] == 9){
                                                            ?>
                                                        <th>Claim</th>
                                                        <?php
                                                        }
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){
                                                        ?>
                                                        <!-- <th>Pay Now</th> -->
                                                        <?php } if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){ ?>
                                                        <th>Update Profile</th>
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



    <div class="modal fade payNow" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #fffee0;">
                <div class="modal-header bg-white">
                    <h5 class="modal-title pull-left" id="exampleModalLabel">Pay Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-fee.php" method="get">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" class="form-control" id="get_id" name="id" required>
                        <input type="hidden" class="form-control" id="get_type" name="type" value="Registration"
                            required>
                        <center>
                            <div class="row ">
                                <div class="style-radio col-md-3 col-md-offset-2">
                                    <input type="radio" name="types" id="registration" value="Registration"
                                        onchange="change_radio(this.value)" required>
                                    <label for="registration">Registration</label>
                                </div>
                                <div class="col-md-1" style="padding: 1rem"> or</div>
                                <div class="style-radio col-md-3">
                                    <input type="radio" name="types" id="enroll" value="Enrollment"
                                        onchange="change_radio(this.value)" required>
                                    <label for="enroll">Enrollment</label>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });

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
                    "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                },
                {
                    "bSearchable": false,
                    "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                }
            ],
            "ajax": {
                url: "visit-management-member-ajax.php",
                type: "post",
                error: function() {
                    $(".product-grid-error").html("");
                    $("#product-grid").append(
                        '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                    );
                    $("#product-grid_processing").css("display", "none");
                }
            },
            "dom": '<"top"lfB>rt<"bottom"ip><"clear">', // Include this line to add the buttons container
            "buttons": [{
                extend: 'csvHtml5',
                text: 'Download CSV',
                title: 'Visit List',
                exportOptions: {
                    columns: ':not(:last-child):not(:nth-last-child(2)):not(:nth-last-child(3))' // Exclude last three columns
                }
            }]
        });
    });


    $("#branch_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#country_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#councellor_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#telecaller_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#visa_type").change(function() {
        $("#searchfrm").submit();
    })
    $("#visa_source").change(function() {
        $("#searchfrm").submit();
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
    <script src="js/change-status.js"></script>
    <script>
    function warning(url) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to claim it?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
    </script>
</body>

</html>