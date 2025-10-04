<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr1 = " and b.cstatus = 'Move to Visa Appointment'";
$whr2 = " and b.cstatus = 'Move to Visa Appointment'";
$whr3 = "";
$whr4 = "";
$group = "  GROUP BY b.stu_id";
$status = 1;
$join = " inner join $tbl_student_status as b on a.id=b.stu_id";
$next7 = date('Y-m-d' , strtotime(' +7 Days'));;
$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
if($_SESSION['level_id']==10 || $_SESSION['level_id']==19){
$whr1 =" and a.branch_id in ($branch_id)";
$whr2 =" and a.branch_id in ($branch_id)";
$whr4 =" and a.branch_id in ($branch_id)";
}elseif($_SESSION['level_id']==12){
    $whr1 =" and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
    $whr2 =" and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
    $whr4 =" and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
}
$_SESSION['whr1'] = '';
$_SESSION['whr4'] = '';
$_SESSION['join'] = '';
$_SESSION['status1'] = '';
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr1 .= " and a.branch_id in ($branch_id)";
    $whr2 .= " and a.branch_id in ($branch_id)";
    $whr4 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['student_type']){
    $student_type = $_REQUEST['student_type'];
    $whr1 .= " and a.student_type = $student_type";
    $whr2 .= " and a.student_type = $student_type";
    $whr4 .= " and a.student_type = $student_type";
  }
if($_REQUEST['slot_executive_id']){
    $slot_executive_id = $_REQUEST['slot_executive_id'];
    $whr1 .= " and c.slot_executive_id = '$slot_executive_id'";
    $whr2 .= " and c.slot_executive_id = '$slot_executive_id'";
    $whr4 .= " and c.slot_executive_id = '$slot_executive_id'";
}
if($_REQUEST['visa_id']){
    $visa_id = $_REQUEST['visa_id'];
    $whr1 .= " and a.visa_id = '$visa_id'";
    $whr2 .= " and a.visa_id = '$visa_id'";
    $whr4 .= " and a.visa_id = '$visa_id'";
}
if($_REQUEST['slot_type']){
    $slot_type = $_REQUEST['slot_type'];
    $whr1 .= " and c.slot_type1 = '$slot_type'";
    $whr2 .= " and c.slot_type1 = '$slot_type'";
    $whr4 .= " and c.slot_type1 = '$slot_type'";
}
if($_REQUEST['slot_payment']){
    $slot_payment = $_REQUEST['slot_payment'];
    $whr1 .= " and c.slot_type = '$slot_payment'";
    $whr2 .= " and c.slot_type = '$slot_payment'";
    $whr4 .= " and c.slot_type = '$slot_payment'";
}
if($_REQUEST['biometric_location']){
    $biometric_location = $_REQUEST['biometric_location'];
    $whr1 .= " and c.biometric_location = '$biometric_location'";
    $whr2 .= " and c.biometric_location = '$biometric_location'";
    $whr4 .= " and c.biometric_location = '$biometric_location'";
  }
  if($_REQUEST['interview_location']){
    $interview_location = $_REQUEST['interview_location'];
    $whr1 .= " and c.interview_location = '$interview_location'";
    $whr2 .= " and c.interview_location = '$interview_location'";
    $whr4 .= " and c.interview_location = '$interview_location'";
  }
  if($_REQUEST['pdf_status']){
      $pdf_status = $_REQUEST['pdf_status'];
      $whr1 .= " and c.pdf_status = '$pdf_status'";
      $whr2 .= " and c.pdf_status = '$pdf_status'";
      $whr4 .= " and c.pdf_status = '$pdf_status'";
    }
    if($_REQUEST['id_owner']){
        $id_owner = $_REQUEST['id_owner'];
        $whr1 .= " and c.id_owner = '$id_owner'";
        $whr2 .= " and c.id_owner = '$id_owner'";
        $whr4 .= " and c.id_owner = '$id_owner'";
    }
    if($_REQUEST['slot_status']){
        $slot_status = $_REQUEST['slot_status'];
        $whr1 .= " and c.slot_status = '$slot_status'";
        $whr2 .= " and c.slot_status = '$slot_status'";
        $whr4 .= " and c.slot_status = '$slot_status'";
    }
    if($_REQUEST['status']){
        $_SESSION['status1'] = $_REQUEST['status'];
    } 
   
    if($_REQUEST['biometric_start_date'] && $_REQUEST['biometric_end_date']){
        $biometric_start_date = $_REQUEST['biometric_start_date'];
        $biometric_end_date = $_REQUEST['biometric_end_date'];
        $whr1 .= " and c.biometric_date >= '$biometric_start_date' and c.biometric_date <= '$biometric_end_date'";
        $whr3 .= " and c.biometric_date >= '$biometric_start_date' and c.biometric_date <= '$biometric_end_date'";
        $whr4 .= " and c.biometric_date >= '$biometric_start_date' and c.biometric_date <= '$biometric_end_date'";
      }
    if($_REQUEST['interview_start_date'] && $_REQUEST['interview_end_date']){
        $interview_start_date = $_REQUEST['interview_start_date'];
        $interview_end_date = $_REQUEST['interview_end_date'];
        $whr1 .= " and c.interview_date >= '$interview_start_date' and c.interview_date <= '$interview_end_date'";
        $whr3 .= " and c.interview_date >= '$interview_start_date' and c.interview_date <= '$interview_end_date'";
        $whr4 .= " and c.interview_date >= '$interview_start_date' and c.interview_date <= '$interview_end_date'";
      }
    $_SESSION['whr1'] = $whr1;
    $_SESSION['whr3'] = $whr3;
    $_SESSION['whr4'] = $whr4;
    $_SESSION['join'] = $join;
    $_SESSION['group'] = $group;
    $_SESSION['status'] = $status;
    
  
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

.text-pagination {
    width: 304px;
    position: absolute;
    top: 0.4%;
    left: 15%;
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
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Slot Student</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a>Manage Slot Student</a></span></li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple=""
                                    onchange="form_submit()">
                                    <?php
                                    if(!empty($_REQUEST['branch_id'])){
                                    $branchArr = $_REQUEST['branch_id'];
                                    }else{
                                    $branchArr = array();
                                    }                       
                                    $b_con = '';
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
                                <select name="student_type" id="student_type" class="form-control"
                                    onchange="form_submit()">
                                    <option value="">Student Type</option>
                                    <option value="1" <?php if($_REQUEST['student_type']==1){?> selected <?php } ?>>New
                                    </option>
                                    <!-- <option value="3" <?php if($_REQUEST['student_type']==3){?> selected <?php } ?>>Refused</option> -->
                                    <option value="2" <?php if($_REQUEST['student_type']==2){?> selected <?php } ?>>
                                        Defer</option>
                                    <option value="4" <?php if($_REQUEST['student_type']==4){?> selected <?php } ?>>
                                        Re-apply (Same Intake)</option>
                                    <option value="6" <?php if($_REQUEST['student_type']==6){?> selected <?php } ?>>
                                        Re-apply(Defer)</option>
                                    <option value="5" <?php if($_REQUEST['student_type']==5){?> selected <?php } ?>>
                                        Re-Apply(New Applications)</option>
                                    <option value="7" <?php if($_REQUEST['student_type']==7){?> selected <?php } ?>>
                                        New(Outsider Refused)</option>
                                    <option value="8" <?php if($_REQUEST['student_type']==8){?> selected <?php } ?>>New
                                        (Filing Only)</option>
                                    <option value="9" <?php if($_REQUEST['student_type']==9){?> selected <?php } ?>>
                                        University Transfer</option>
                                </select>
                            </div>
                        </div>
                        <?php
                        if($_SESSION['level_id']==1 || $_SESSION['level_id']==10){
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="slot_executive_id" id="slot_executive_id"
                                    onchange="form_submit()">
                                    <option value="">
                                        Select Slot
                                        Executive
                                    </option>
                                    <?php
                                 if(!empty($_REQUEST['branch_id'])){
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
                                  }
														$sql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and additional_role like '%3%' $whrr",-1);  
														while($resultt=$obj->fetchNextObject($sql)){?>
                                    <option value="<?php echo $resultt->id ?>"
                                        <?php if($resultt->id==$_REQUEST['slot_executive_id']){?>selected<?php } ?>>
                                        <?php echo $resultt->name .'  ('.$resultt->email.')'; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="slot_type" onchange="form_submit()">
                                    <option value="">
                                        Select Slot Type
                                    </option>
                                    <option value="Fresh" <?php if($_REQUEST['slot_type']=='Fresh'){?> selected
                                        <?php } ?>>
                                        Fresh
                                    </option>
                                    <option value="Refused" <?php if($_REQUEST['slot_type']=='Refused'){?> selected
                                        <?php } ?>>
                                        Refused
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="visa_id" id="visa_id" class="form-control" onchange="form_submit()">
                                    <option value="">Select Visa</option>
                                    <option value="1" <?php if($_REQUEST['visa_id']==1){?> selected <?php } ?>>Study Visa</option>
                                    <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist
                                        Visa</option>
                                    <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor
                                        Visa</option>
                                    <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work Visa
                                    </option>
                                    <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>Spouse
                                        Visa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="slot_payment" onchange="form_submit()">
                                    <option value="">
                                        Select Slot Payment
                                    </option>
                                    <option value="Paid" <?php if($_REQUEST['slot_payment']=='Paid'){?> selected
                                        <?php } ?>>
                                        Paid
                                    </option>
                                    <option value="Free" <?php if($_REQUEST['slot_payment']=='Free'){?> selected
                                        <?php } ?>>
                                        Free
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="biometric_location"
                                    id="biometric_location" onchange="form_submit()">
                                    <option value="">
                                        Select
                                        Biometric
                                        Location
                                    </option>
                                    <option value="Delhi" <?php if($_REQUEST['biometric_location']=='Delhi'){?> selected
                                        <?php } ?>>
                                        Delhi
                                    </option>
                                    <option value="Mumbai" <?php if($_REQUEST['biometric_location']=='Mumbai'){?>
                                        selected <?php } ?>>
                                        Mumbai
                                    </option>
                                    <option value="Hyderabad" <?php if($_REQUEST['biometric_location']=='Hyderabad'){?>
                                        selected <?php } ?>>
                                        Hyderabad
                                    </option>
                                    <option value="Kolkata" <?php if($_REQUEST['biometric_location']=='Kolkata'){?>
                                        selected <?php } ?>>
                                        Kolkata
                                    </option>
                                    <option value="Chennai" <?php if($_REQUEST['biometric_location']=='Chennai'){?>
                                        selected <?php } ?>>
                                        Chennai
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="interview_location"
                                    id="interview_location" onchange="form_submit()">
                                    <option value="">
                                        Select
                                        Interview
                                        Location
                                    </option>
                                    <option value="Delhi" <?php if($_REQUEST['interview_location']=='Delhi'){?> selected
                                        <?php } ?>>
                                        Delhi
                                    </option>
                                    <option value="Mumbai" <?php if($_REQUEST['interview_location']=='Mumbai'){?>
                                        selected <?php } ?>>
                                        Mumbai
                                    </option>
                                    <option value="Hyderabad" <?php if($_REQUEST['interview_location']=='Hyderabad'){?>
                                        selected <?php } ?>>
                                        Hyderabad
                                    </option>
                                    <option value="Kolkata" <?php if($_REQUEST['interview_location']=='Kolkata'){?>
                                        selected <?php } ?>>
                                        Kolkata
                                    </option>
                                    <option value="Chennai" <?php if($_REQUEST['interview_location']=='Chennai'){?>
                                        selected <?php } ?>>
                                        Chennai
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="pdf_status" onchange="form_submit()">
                                    <option value="">
                                        Select PDF
                                        Status
                                    </option>
                                    <option value="Sent" <?php if($_REQUEST['pdf_status']=='Sent'){?> selected
                                        <?php } ?>>
                                        Sent
                                    </option>
                                    <option value="Not Sent" <?php if($_REQUEST['pdf_status']=='Not Sent'){?> selected
                                        <?php } ?>>
                                        Not Sent
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="id_owner" onchange="form_submit()">
                                    <option value="">
                                        Select ID
                                        Onwer
                                    </option>
                                    <option value="IBT" <?php if($_REQUEST['id_owner']=='IBT'){?> selected <?php } ?>>
                                        IBT
                                    </option>
                                    <option value="Student" <?php if($_REQUEST['id_owner']=='Student'){?> selected
                                        <?php } ?>>
                                        Student
                                    </option>
                                    <option value="Slot Agent" <?php if($_REQUEST['id_owner']=='Slot Agent'){?> selected
                                        <?php } ?>>
                                        Slot Agent
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control form-select" name="slot_status" id="slot_status"
                                    onchange="form_submit()">
                                    <option value="">
                                        Select Slot
                                        Status
                                    </option>
                                    <option value="Booked" <?php if($_REQUEST['slot_status']=='Booked'){?> selected
                                        <?php } ?>>
                                        Booked
                                    </option>
                                    <option value="Not Booked" <?php if($_REQUEST['slot_status']=='Not Booked'){?>
                                        selected <?php } ?>>
                                        Not Booked
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="biometric_start_date" id="filter_start_date"
                                    class="form-control" style="height: 36px;" value=""
                                    placeholder="Biometric Start Date" onfocus="(this.type='date')"
                                    onblur="(this.type='text')" value="<??>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="biometric_end_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="" placeholder="Biometric End Date"
                                    onfocus="(this.type='date')" onblur="(this.type='text')" value="<??>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="interview_start_date" id="filter_start_date"
                                    class="form-control" style="height: 36px;" value=""
                                    placeholder="Interview Start Date" onfocus="(this.type='date')"
                                    onblur="(this.type='text')" value="<??>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="interview_end_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="" placeholder="Interview End Date"
                                    onfocus="(this.type='date')" onblur="(this.type='text')" value="<??>">
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
                <!-- <div class="row">
                    <button type="button" onclick="show_counter()" class="btn btn-primary download_csv_button"
                        style="width: 170px; height: 40px;float: right;margin-bottom: 15px;">Show Counters</button>
                </div> -->
                <div id="get_counter_data"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-12">Color Code: <span style="color:blue">Today Interview
                                                    Date</span>, <span style="color:orange">High Priority</span>, <span
                                                    style="color:green">Booked</span>, <span style="color:red">Slot Type
                                                    is not selected</span></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Branch Name</th>
                                                        <th>Slot Type</th>
                                                        <th>Priority</th>
                                                        <th>Location Preference </th>
                                                        <th>Biometric Date</th>
                                                        <th>Biometric Location </th>
                                                        <th>Interview Date</th>
                                                        <th>Interview Location </th>
                                                        <th>PFD status </th>
                                                        <th>ID Owner</th>
                                                        <th>Slot Status</th>
                                                        <th>Slot Executive</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <th>Remark</th>
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
    $(".select2").select2({
        placeholder: "Select Branch",
        allowClear: true
    });
    </script>
    <script>
    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
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
            url: "slot-student-list-ajax.php",
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

    $("div#studentList_wrapper").append(
        '<div class="text-pagination"><label for="usermobile">Go to page: </label><input type="text" id="usermobile" min="1" style="width: 60px;"></div>'
    );

    $('#usermobile').on('change', function() {
        var page = $(this).val();
        if (page > 0 && page <= dataTable.page.info().pages) {
            dataTable.page(page - 1).draw(false);
        } else {
            alert('Invalid page number.');
        }
    });
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function form_submit() {
        $("#searchfrm").submit();
    }

    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
    <script>
        $(document).ready(function(){
            show_counter();
        })
    function show_counter() {
        $("#get_counter_data").html(`
            <div style="text-align:center">
                <h4>Loading Counters...</h4>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
        $.ajax({
            method: "post",
            url: "ajax/slot-counter.php",
            data: {
                lead: 1
            },
            success: function(data) {
                $("#get_counter_data").html(data);
            }
        })
    }
    </script>
    <script>
    $('#usermobile').on('input', function() {
        const phoneNumber = $(this).val();

        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 3);
        $(this).val(limitedNumber);
    });
    </script>
</body>

</html>