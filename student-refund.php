<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr1 = " and a.refund_status=1 and a.country_id=3";
$half = "";
$_SESSION['whr1'] = '';
$_SESSION['half'] = '';

if($_SESSION['level_id']==19 || $_SESSION['level_id']==31){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.branch_id in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr1 .= " and a.country_id=$country_id";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr1 .= " and (
        CASE 
            WHEN c.visa_issue_date != '' THEN c.visa_issue_date 
            ELSE b.cdate 
        END
    ) >= '$filter_start_date' 
    AND (
        CASE 
            WHEN c.visa_issue_date != '' THEN c.visa_issue_date 
            ELSE b.cdate 
        END
    ) <= '$filter_end_date' ";
  }
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status=='Refund Under Process'){
        $whr1 .= " and c.refund_status='Under processing'";
    }
   elseif($status=='Refund Denied'){
        $whr1 .= " and c.refund_status='Denied'";
    }
    elseif($status=='Refund Approved'){
        $whr1 .= " and c.refund_status='Approved' and (c.refund_payment_status is null or c.refund_payment_status='Pending')";
    }
    elseif($status=='Refund Received'){
        $whr1 .= "  and c.refund_status='Approved' and c.refund_payment_status='Received'";
    }
}
$_SESSION['whr1'] = $whr1;
$_SESSION['half'] = $half;
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
                        <h5 class="txt-dark">Refund Status</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>Refund Status</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
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
                        <!-- <div class="col-md-3">
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
                        </div> -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control form-select" name="status" id="status"
                                    onchange="form_submit()">
                                    <option value="">Select Status</option>
                                    <option value="Refund Under Process" <?php if($_REQUEST['status']=='Refund Under Process'){?>selected
                                        <?php } ?>>Refund Under Process</option>
                                    <option value="Refund Denied" <?php if($_REQUEST['status']=='Refund Denied'){?>selected
                                        <?php } ?>>Refund Denied</option>
                                    <option value="Refund Approved" <?php if($_REQUEST['status']=='Refund Approved'){?>selected
                                        <?php } ?>>Refund Approved</option>
                                    <option value="Refund Received" <?php if($_REQUEST['status']=='Refund Received'){?>selected
                                        <?php } ?>>Refund Received</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2"> 
                            <div class="form-group">
                                <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                    placeholder="Visa Issued Start Date" onfocus="(this.type='date')"
                                    onblur="(this.type='text')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_end_date" id="filter_end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                    placeholder="Visa Issued End Date" onfocus="(this.type='date')"
                                    onblur="(this.type='text')">
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
                                                    <a href="javascript:void(0)" onclick="submit_data('Refund Under Process')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $sql = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and a.refund_status=1  and c.refund_status='Under processing' GROUP BY a.id",$debug=-1);
                                                                $line=$obj->numRows($sql);
                                                                echo $line;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Refund Under Process</span>
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
                                                    <a href="javascript:void(0)" onclick="submit_data('Refund Denied')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $sql = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and a.refund_status=1  and c.refund_status='Denied' GROUP BY a.id",$debug=-1);
                                                                $line=$obj->numRows($sql);
                                                                echo $line;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Refund Denied</span>
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
                                                    <a href="javascript:void(0)" onclick="submit_data('Refund Approved')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $sql = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and c.refund_status='Approved' and a.refund_status=1   and (c.refund_payment_status is null or c.refund_payment_status='Pending') GROUP BY a.id",$debug=-1);
                                                                $line=$obj->numRows($sql);
                                                                echo $line;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">REFUND APPROVED BUT NOT RECEIVED</span>
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
                                                    <a href="javascript:void(0)" onclick="submit_data('Refund Received')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $sql = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Approved' and c.refund_status='Approved'  and a.refund_status=1  and c.refund_payment_status='Received' GROUP BY a.id",$debug=-1);
                                                                $line=$obj->numRows($sql);
                                                                echo $line;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Refund Approved & Recieved</span>
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
                                            <!-- <div class="col-md-12">Color Code:
                                                <span style="color:blue">Settlement Pending / Paying Fee - TT/ Receipt
                                                    No. is empty</span>,
                                                <span style="color:green;font-weight:bold">Settlement Received / Paying
                                                    Fee - TT/ Receipt No. is not empty</span>
                                            </div> -->
                                        </div>
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Student Id</th>
                                                        <th>Student Name</th>
                                                        <th>Portal Id</th>
                                                        <th>Visa Issue Date</th>
                                                        <th style="width:250px">University Name</th>
                                                        <th>Refund Applied By</th>
                                                        <th>Refund Affidavit</th>
                                                        <th>Refund Reason</th>
                                                        
                                                        <th>Refund Applied Date</th>
                                                        <th>Refund Commission committed</th>
                                                        <th>Refund Status</th>
                                                        <th>Refund Payment Status</th>
                                                        <th>Refund Received Amount</th>
                                                        <th>Refund Commission Status</th>
                                                        <th>Refund Commission Received</th>
                                                        <th>Mode</th>
                                                        <th>Refund Remark</th>
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
      if ($_SESSION['level_id']==1){?> "aoColumnDefs": [{
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
            url: "student-refund-ajax.php",
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
        function submit_data(val){
            $("#status").val(val);
            $("#searchfrm").submit();
        }
    </script>
</body>

</html>