<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = "  and a.country_id=6";
$whr1 = "  and a.country_id=6";
// $whr = "  ";
// $whr1 = " ";
$join = "";
$_SESSION['join'] = '';
$_SESSION['whr1'] = '';
$_SESSION['half'] = '';
$oct_date = '2024-10-01';
if($_SESSION['level_id'] == 4){
    $whr .= " and a.c_id ='{$_SESSION['sess_admin_id']}'";
    $whr1 .= " and a.c_id='{$_SESSION['sess_admin_id']}'";
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
  if($_REQUEST['visa_id']){
    $visa_id = $_REQUEST['visa_id'];
    $whr .= " and a.visa_id=$visa_id";
    $whr1 .= " and a.visa_id=$visa_id";
  }
  if($_REQUEST['student_type']){
    $student_type = $_REQUEST['student_type'];
    $whr .= " and a.student_type=$student_type";
    $whr1 .= " and a.student_type=$student_type";
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

if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    $whr1 .= " and c.enrollment_status='{$_REQUEST['status']}'";
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
                           UK Visa Refused Students
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>UK Visa Refused Students</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
                    <input type="hidden" name="status" id="status">
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
                        <div class="col-md-3">
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
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="visa_id" id="visa_id" onchange="form_submit()">
                                <option value="">Select Visa Type</option>
                                <option value="1" <?php if($_REQUEST['visa_id']==1){?> selected <?php } ?>>
                                    Study Visa</option>
                                <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>
                                    Tourist Visa</option>
                                <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>
                                    Visitor Visa</option>
                                <!-- <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work
                                    Visa</option> -->
                                <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>
                                    Spouse Visa</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="display:none">
                            <div class="form-group">
                                <select class="form-control form-select" name="status" id="status"
                                    onchange="form_submit()">
                                    <option value="">Select Status</option>
                                    <option value="Defer Next Intake" value="Full Done"
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

                        <?php
                                if((!isset($_REQUEST['visa_id'])) || ($_REQUEST['visa_id']=='1' || $_REQUEST['visa_id']=='4')){
                                    $pre_country_id = $_REQUEST['country_id'];
                                    $change_type = $_REQUEST['visa_id'];
                                    if($change_type == 1){
                                      $visa_type = 'Study';
                                      }elseif($change_type == 4){
                                          $visa_type = 'Work';
                                      }
                                    ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="student_type" id="student_type" onchange="form_submit()"
                                    class="form-control">
                                    <option value="">Select Visa Sub Type</option>
                                    <?php
                                $clSql = $obj->query("select * from $tbl_enrolled_fee where country_id='$pre_country_id' and visa_type = '$visa_type' order by displayorder asc");
                                while($clResult = $obj->fetchNextObject($clSql)){
                                    ?>
                                    <option value="<?php echo $clResult->visa_sub_type; ?>"
                                        <?=$clResult->visa_sub_type == $_REQUEST['student_type'] ? 'selected' : ''?>>
                                        <?php echo getField('visa_sub_type',$tbl_visa_sub_type,$clResult->visa_sub_type);?>
                                    </option>
                                    <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <?php }else{
                                          $pre_country_id = $_REQUEST['country_id'];
                                          $change_type = $_REQUEST['visa_id'];
                                          if($change_type == 2){
                                            $visa_type = 'Tourist';
                                            }
                                            elseif($change_type == 3){
                                                $visa_type = 'Visitor';
                                            }
                                            elseif($change_type == 5){
                                                $visa_type = 'Spouse';
                                            }
                                      ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="required form-control" name="student_type" onchange="form_submit()"
                                    id="student_type">
                                    <option value="">Select Case Type</option>
                                    <?php
                                                $clSql = $obj->query("select * from $tbl_enrolled_fee where country_id='$pre_country_id' and visa_type = '$visa_type' order by displayorder asc");
                                                while($clResult = $obj->fetchNextObject($clSql)){
                                                    ?>
                                    <option value="<?php echo $clResult->visa_sub_type; ?>"
                                        <?=$clResult->visa_sub_type == $_REQUEST['student_type'] ? 'selected' : ''?>>
                                        <?php echo getField('visa_sub_type',$tbl_visa_sub_type,$clResult->visa_sub_type);?>
                                    </option>
                                    <?php
                                                }
                                                ?>
                                </select>
                            </div>
                        </div>
                        <?php 
                                    } ?>
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
                    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
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
                                                                $sql = $obj->query("SELECT a.id FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on b.stu_id = a.id LEFT JOIN $tbl_student_enrollment as c on c.stu_id = a.id WHERE b.cstatus = 'Visa Refused' $whr GROUP BY a.id",$debug=-1);
                                                                $line=$obj->numRows($sql);
                                                                echo $line;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">All
                                                            Students</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-right">
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
                                            <table id="studentList" class="table table-hover display pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Visa Issue Date</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <!-- <th>Enrollment Executive</th> -->
                                                        <th>Tuition Fees paid</th>
                                                        <th>IHS Fees paid</th>
                                                        <th>Branch Name</th>
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
            url: "uk-visa-refused-ajax.php",
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
        $('#searchfrm').append('<input name="status" value="' + val + '" type="hidden"/>');
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