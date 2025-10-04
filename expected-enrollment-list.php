<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['whr_new']='';
$_SESSION['whr_new1']='';
$_SESSION['con']='';
$_SESSION['con1']='';
$_SESSION['status']=1;

$whr='';
$todate = date('Y-m-d');
$branchid = '';
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id'] == 4){
    $councellor_id = $_SESSION['sess_admin_id'];
    $whr .= " and FIND_IN_SET('$councellor_id', councellor_id) > 0";
}
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    if(is_array($branchArr)){
    $branch_id = implode(',',$branchArr);
  }else{
        $branch_id = $_REQUEST['branch_id'];
    }
    $whr .= " and branch_id in ($branch_id)";
  }

if($_REQUEST['enrollment_start_date'] && $_REQUEST['enrollment_end_date']){
  $enrollment_start_date = $_REQUEST['enrollment_start_date'];
  $enrollment_end_date = $_REQUEST['enrollment_end_date'];
  $whr .= " and expected_enrollment_date >= '$enrollment_start_date' and expected_enrollment_date <= '$enrollment_end_date'";
}else{
    $whr .= " and expected_enrollment_date = '$todate'";
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
                        <h5 class="txt-dark">Today Expected Enrollment
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>
                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form method="post" name="searchfrm" id="searchfrm" action="expected-enrollment-list.php">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="branch_id[]" id="branch_id" class="form-control select2"
                                                multiple="">
                                                <?php
                                                    if(!empty($_REQUEST['branch_id'])){
                                                    $branchArr = $_REQUEST['branch_id'];
                                                    if(is_array($branchArr)){
                                                        $branchArr = $branchArr;
                                                         }else{
                                                            $branchArr = array($branchArr);
                                                        }
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="enrollment_start_date" id="enrollment_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['enrollment_start_date']; ?>"
                                                placeholder="Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="enrollment_end_date" id="enrollment_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['enrollment_end_date']; ?>"
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
                                    <div class="row">
                                                <div class="col-md-12r">Color Code: <span style="color:red"><?php  if($_SESSION['level_id']==1 || in_array(1,$addtional_role)){ ?>Counsellor Not Selected<?php }else{ ?> Initial Status is not selected <?php } ?></span>, <span style="color:green"> Enrolled</span></div>
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
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){ ?>
                                                        <th>Expected Ernollement</th>
                                                        <?php } ?>
                                                        <th>Action</th>
                                                        <?php if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){ ?>
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
    <div class="modal fade" id="expected_enrollment" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Select Enrollment Date</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off">
                    <input type="hidden" name="appid_pass" id="appid_pass">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="visit_id" id="visit_id" class="form-control">
                            <input type="hidden" name="back_url" id="back_url" value="visit-list.php" class="form-control">
                            <input type="date" name="expected_enrollment_date" id="expected_enrollment_date" class="form-control"
                                placeholder="Date & Time">
                            <span id="err_university_id_pass" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name='submit_expected_enrollment_date' class="btn btn-primary">Submit</button>
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
                url: "expected-enrollment-list-ajax.php",
                type: "post",
                error: function() {
                    $(".product-grid-error").html("");
                    $("#product-grid").append(
                        '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                    );
                    $("#product-grid_processing").css("display", "none");
                }
            },
            
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
      <script>
    function expected_enrollment(id) {
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                expected_enrollment: id
            },
            success: function(data) {
                $("#expected_enrollment").modal('show');
                $("#visit_id").val(id);
                $("#expected_enrollment_date").val(data);
            }
        })
    }
    </script>
</body>

</html>