<?php
ob_start();
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr1'] = '';
$_SESSION['whr2'] = '';
$fourty_days_ago = date("Y-m-d", strtotime("-45 days"));
$whr1 = " and date(c.cdate) < '$fourty_days_ago' and c.welcome_call_status='Completed'";
$whr2 = " and date(c.cdate) < '$fourty_days_ago' and c.welcome_call_status='Completed'";
$fourty_days_ago = date("Y-m-d", strtotime("-45 days"));
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id']==21){
    $whr1 .= " and c.wc_id ='".$_SESSION['sess_admin_id']."' ";
}
if(isset($_REQUEST['branch_id']) && is_array($_REQUEST['branch_id'])){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr1 .= " and c.branch_id in ($branch_id)";
}else{
    if($_SESSION['level_id']==20){
        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
        $whr1 .= " and c.branch_id in ($branch_id)";
    }
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr1 .= " and c.country_id=$country_id";
  }
  if($_REQUEST['councellor_id']){
    $councellor_id = $_REQUEST['councellor_id'];
    $whr1 .= " and c.c_id=$councellor_id";
  }
  if($_REQUEST['payment_type']){
    $payment_type = $_REQUEST['payment_type']; 
    $whr1 .= " and a.visa_sub_type=$payment_type";
  }
  
  if($_REQUEST['status']){
    $status = $_REQUEST['status']; 
    $whr2 .= " and c.welcome_call_status='$status'";
  }
  
  
  if($_REQUEST['status1']){
    $status1 = $_REQUEST['status1']; 
    if($status1 == 'Pending'){
        $whr2 .= " and c.welcome_call_status2 is null";
    }else{
        $whr2 .= " and c.welcome_call_status2='$status1'";
    }
  }
  
  if($_REQUEST['visa_type']){
    $visa_type = $_REQUEST['visa_type'];
    $whr1 .= " and FIND_IN_SET('$visa_type',c.visa_id)";
  }

  if($_REQUEST['start_date'] && $_REQUEST['end_date']){
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $whr1 .= " and date(c.cdate) >= '$start_date' and date(c.cdate) <= '$end_date'";
  }
  $_SESSION['whr1'] = $whr1; 
  $_SESSION['whr2'] = $whr2; 
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
                    <?php echo $_SESSION['sess_msg'];
                    $_SESSION['sess_msg'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Welcome Call2 Students</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form method="post" name="searchfrm" id="searchfrm" action="">
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
                                                    }elseif(isset($branchids)){
                                                        $branchArr = $branchids;
                                                    }else{
                                                    $branchArr = array();
                                                    }                      
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
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="councellor_id" id="councellor_id" class="form-control">
                                                <option value="">Counsellor</option>
                                                <?php
                                            if(!empty($_REQUEST['branch_id'])){
                                            $idArr = $_REQUEST['branch_id'];
                                            $idArr = $_REQUEST['branch_id'];
                                            $i=1; $whrr='';
                                            foreach($idArr as $val){
                                                if($i==1){
                                                $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                                                }else{
                                                $whrr .=" or FIND_IN_SET($val, branch_id)";
                                                }
                                                if($i==count($idArr)){
                                                $whrr .=" )";
                                                }
                                                $i++;
                                            }                          
                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr order by name",-1);
                                            }else{
                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4  order by name",-1);
                                            }
                                            while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['councellor_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control">
                                                <option value="">Country</option>
                                                <?php                       
                                                    $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                                                    while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['country_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="visa_type" id="visa_type"
                                                <?php echo $udisabled; ?>>
                                                <option value="">Select Visa Type</option>
                                                <option value="1" <?php if($_REQUEST['visa_type']=='1'){?> selected
                                                    <?php }?>>Study Visa</option>
                                                <option value="2" <?php if($_REQUEST['visa_type']=='2'){?> selected
                                                    <?php }?>>Tourist Visa</option>
                                                <option value="3" <?php if($_REQUEST['visa_type']=='3'){?> selected
                                                    <?php }?>>Visitor Visa</option>
                                                <option value="4" <?php if($_REQUEST['visa_type']=='4'){?> selected
                                                    <?php }?>>Work Visa</option>
                                                <option value="5" <?php if($_REQUEST['visa_type']=='5'){?> selected
                                                    <?php }?>> Spouse Visa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="payment_type" name="payment_type">
                                                <option value="">Payment Type</option>
                                                <?php
                                                $conn = '';
                                                if($_REQUEST['country_id'] && $_REQUEST['visa_type']){
                                                    if($_REQUEST['visa_type']=='1'){
                                                        $visa_type = 'Study';
                                                    }
                                                    elseif($_REQUEST['visa_type']=='2' || $_REQUEST['visa_type']=='3'){
                                                        $visa_type = 'Visitor/tourist';
                                                    }
                                                    elseif($_REQUEST['visa_type']=='4'){
                                                        $visa_type = 'Work';
                                                    }
                                                    elseif($_REQUEST['visa_type']=='5'){
                                                        $visa_type = 'Spouse';
                                                    }
                                                    $conn = " and country_id='".$_REQUEST['country_id']."' and visa_type='$visa_type'"; 
                                                $stateSqls = $obj->query("select * from $tbl_visa_sub_type where 1 = 1 and student_show=1 $conn", -1);
                                                while ($stateResult = $obj->fetchNextObject($stateSqls)) { ?>
                                                <option value="<?php echo $stateResult->id ?>"
                                                    <?php if ($_REQUEST['payment_type'] ==  $stateResult->id) { ?>
                                                    selected <?php } ?>>
                                                    <?php echo $stateResult->visa_sub_type;?>
                                                </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                style="height: 36px;" value="<?php echo $_REQUEST['start_date']; ?>"
                                                placeholder="Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="end_date" id="end_date" class="form-control"
                                                style="height: 36px;" value="<?php echo $_REQUEST['end_date']; ?>"
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1 and date(c.cdate) < '$fourty_days_ago' $whr1 group by a.id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Students</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord1('Pending')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a  inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1 and c.welcome_call_status2 is null  and date(c.cdate) < '$fourty_days_ago' $whr1 group by a.id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            Calls 2</span>
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
                                                    <a href="javascript:void(0)"
                                                        onclick="getAppRecord1('Not Completed')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1 and c.welcome_call_status2='Not Completed'  and date(c.cdate) < '$fourty_days_ago'  and c.welcome_call_status!='Pending' $whr1 group by a.id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not
                                                            Completed Calls 2</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord1('Completed')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sqls=$obj->query("select COUNT(a.id) as num_rows from $tbl_visit as a inner join $tbl_student as c on a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact inner join $tbl_visa_sub_type as d on d.id=a.visa_sub_type where 1=1 and d.student_show=1 and c.welcome_call_status2='Completed' and date(c.cdate) > '2025-04-01' $whr1 group by a.id",$debug=-1);
                                                                    echo $obj->numRows($sqls);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Completed
                                                            Calls 2</span>
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
                                    <div class="table-responsive">
                                        <table id="ApplicationList" class="table table-hover display  pb-30">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <!-- <th>Payment Date</th> -->
                                                    <th>Student Code</th>
                                                    <th>Name</th>
                                                    <th>Father Name</th>
                                                    <th>Country</th>
                                                    <!-- <th>Visa Type</th> -->
                                                    <th>Payment Type</th>
                                                    <th>Contact</th>
                                                    <th>Branch</th>
                                                    <th>Counsellor Name</th>
                                                    <!-- <th>After Visa Fee Commitment</th> -->
                                                    <th>View Profile</th>
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
                url: "welcome-call-student2-ajax.php",
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
        $("#payment_type").change(function() {
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

        function getAppRecord1(status) {
            $('#searchfrm').append('<input name="status1" value="' + status + '" type="hidden"/>');
            $("#searchfrm").submit();
        }
        </script>
        <script src="js/change-status.js"></script>
</body>

</html>