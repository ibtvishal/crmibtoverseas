<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = "  and a.country_id=3";
$whr1 = "  and a.country_id=3";
$join = "";
$_SESSION['join'] = '';
$_SESSION['whr1'] = '';
$_SESSION['half'] = '';
$oct_date = '2024-10-01';
if($_SESSION['level_id'] == 19 || $_SESSION['level_id']==25 || $_SESSION['level_id']==31){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and a.branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr .= " and a.country_id=$country_id";
    $whr1 .= " and a.country_id=$country_id";
  }
  if($_REQUEST['after_visa_fee']){
    $after_visa_fee = $_REQUEST['after_visa_fee'];
    $whr .= " and c.visa_issue_date > '$oct_date' and c.after_visa_fee='$after_visa_fee'";
    $whr1 .= " and c.visa_issue_date > '$oct_date' and c.after_visa_fee='$after_visa_fee'";
  }
  if($_REQUEST['fee_payment']){
    $fee_payment = $_REQUEST['fee_payment'];
    $whr .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='$fee_payment'";
    $whr1 .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='$fee_payment'";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and (
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
  if($_REQUEST['status1']){
    $whr1 .= " and c.passport_status='{$_REQUEST['status1']}'";
  }

  if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 'Defer Next Intake'){
        $whr1 .= " and c.defer_next_intake=1";
    }
    if($status == 'Traveled without Paying our Fee'){
        $whr1 .= " and c.defer_next_intake=2";
    }
    if($status == 'Defer Next Intake'){
        $whr1 .= " and c.defer_next_intake=1";
    }
    elseif($status == 'AfterVisa Fee Pending'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.after_visa_fee='Pending'";
    }
    elseif($status == 'AfterVisa Fee Paid'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.after_visa_fee='Paid'";
    }
    elseif($status == 'Pending Payment Status'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='Pending'";
    }
    elseif($status == 'Settlement Payment Status'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='Settlement'";
    }
    elseif($status == 'Paying Fee Payment Status'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='Paying Fee'";
    }
    elseif($status == 'Fee Payment at University Payment Status'){
        $whr1 .= " and c.visa_issue_date > '$oct_date' and c.fee_payment='Fee Payment at University'";
    }
    if($status == 'All Pending'){
        $whr1 .= " and (c.defer_next_intake=1 or c.defer_next_intake=0 or c.defer_next_intake is null) and ((c.fee_payment='Pending' or c.fee_payment is null) or (c.fee_payment='Paying Fee' and c.tt_receipt_no is null) or (c.fee_payment='Settlement' and (c.sattlement_amount_status !='Received' or c.sattlement_amount_status is null))) and (c.after_visa_fee='Pending' or c.after_visa_fee is null) and (c.advisor_meeting='Required - Pending' or c.advisor_meeting is null)";
    }
    elseif($status == 'Half Done'){ 
        $whr1 .= " and (c.defer_next_intake=1 or c.defer_next_intake=0 or c.defer_next_intake is null) and ((c.fee_payment='Settlement' and c.sattlement_amount_status='Received') or (c.fee_payment='Paying Fee' and c.tt_receipt_no is not null) or c.fee_payment='Fee Payment at University' or c.after_visa_fee='Paid'  or c.advisor_meeting='Not Required' or c.advisor_meeting='Required - Done')";

        $half = " AND NOT EXISTS (
      SELECT 1
      FROM $tbl_student_enrollment AS c2
      WHERE c2.stu_id = a.id
      AND (
        (c.fee_payment = 'Settlement' AND c.sattlement_amount_status = 'Received') 
        OR (c.fee_payment = 'Paying Fee' AND c.tt_receipt_no IS NOT NULL)
        OR c.fee_payment='Fee Payment at University'
    ) 
    AND c.after_visa_fee = 'Paid' 
    AND (c.advisor_meeting = 'Not Required' 
    OR c.advisor_meeting = 'Required - Done')
  )";
    }
    elseif($status == 'Full Done'){
        $whr1 .= " and (c.defer_next_intake=1 or c.defer_next_intake=0 or c.defer_next_intake is null) and ((c.fee_payment='Settlement' and c.sattlement_amount_status='Received') or (c.fee_payment='Paying Fee' and c.tt_receipt_no is not null) or c.fee_payment='Fee Payment at University') and c.after_visa_fee='Paid' and (c.advisor_meeting='Not Required' or c.advisor_meeting='Required - Done')";
    }
    elseif($status == 'Form Done'){
        $join = " inner join $tbl_student_passport_noc as d on a.id=d.stu_id";
        $whr1 .= " and d.value='form'";
    }
    elseif($status == 'Form Pending'){
        $join = " LEFT JOIN $tbl_student_passport_noc as d on a.id=d.stu_id";
        $whr1 .= " AND NOT EXISTS (SELECT 1 FROM $tbl_student_passport_noc AS e WHERE e.stu_id = a.id AND e.value = 'form')";
    }
}
$_SESSION['join'] = $join;
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
                        <h5 class="txt-dark">
                            <?=$_SESSION['level_id']==1  || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==25 ? 'University Transfer' : 'Manage Students' ?>
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a><?=$_SESSION['level_id']==1  || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==25 ? 'University Transfer' : 'Manage Students' ?></a></span>
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
                        </div>--> 
                        <div class="col-md-3" style="display:none">
                            <div class="form-group">
                                <select class="form-control form-select" name="status" id="status"
                                    onchange="form_submit()">
                                    <option value="">Select Status</option>
                                    <option value="Full Done"
                                        <?php if($_REQUEST['status']=='Full Done'){?>selected<?php } ?>>Full Done
                                    </option>
                                    <option value="Half Done"
                                        <?php if($_REQUEST['status']=='Half Done'){?>selected<?php } ?>>Half Done
                                    </option>
                                    <option value="All Pending"
                                        <?php if($_REQUEST['status']=='All Pending'){?>selected<?php } ?>>All Pending
                                    </option>
                                    <option value="Traveled without Paying our Fee"
                                        <?php if($_REQUEST['status']=='Traveled without Paying our Fee'){?>selected<?php } ?>>
                                        Traveled without Paying our Fee</option>
                                    <option value="AfterVisa Fee Pending"
                                        <?php if($_REQUEST['status']=='AfterVisa Fee Pending'){?>selected <?php } ?>>
                                        AfterVisa Fee Pending</option>
                                    <option value="Pending Payment Status"
                                        <?=$_REQUEST['status']  == 'Pending Payment Status' ? 'selected' : '' ?>>
                                        University fee Pending</option>
                                    <option value="Settlement Payment Status"
                                        <?=$_REQUEST['status']  == 'Settlement Payment Status' ? 'selected' : '' ?>>
                                        University fee Sattlement</option>
                                    <?php if($_REQUEST['status']=='Defer Next Intake'){?>selected <?php } ?>>Defer
                                    Next Intake</option>
                                    <?php
                                        if($_SESSION['level_id'] == 31){
                                            ?>
                                    <option value="Form Done" <?php if($_REQUEST['status']=='Form Done'){?>selected
                                        <?php } ?>>Form Done</option>
                                    <option value="Form Pending"
                                        <?php if($_REQUEST['status']=='Form Pending'){?>selected <?php } ?>>Form Pending
                                    </option>
                                    <?php                                            
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="after_visa_fee" id="after_visa_fee"
                                    onchange="form_submit()">
                                    <option value="">Select Aftervisa Fee</option>
                                    <option value="Pending" <?php if($_REQUEST['after_visa_fee']=='Pending'){?>selected
                                        <?php } ?>>Pending</option>
                                    <option value="Paid" <?php if($_REQUEST['after_visa_fee']=='Paid'){?>selected
                                        <?php } ?>>Paid</option>
                                </select>
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
                                                        <th>Student Id</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <th>Branch Name</th>
                                                        <th>Profile Status</th>
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
                "aTargets": [0, 1, 2, 3, 4, 5, 6]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6]
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
            url: "university-transfer-ajax.php",
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
    function submit_data(val) {
        $("#status").val(val);
        $("#searchfrm").submit();
    }
    </script>
       <script>
    function submit_data1(val) {
        $("#status1").val(val);
        $("#searchfrm").submit();
    }
    </script>
</body>

</html>