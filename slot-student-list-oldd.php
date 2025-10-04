<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = "";

$_SESSION['whr'] = '';
$_SESSION['stage_status'] = '';

$_SESSION['filter']='';
$_SESSION['branch_id']='';
$_SESSION['counsellor_id']='';
$_SESSION['account_manager_id']='';
$_SESSION['filling_manager_id']='';
$_SESSION['filling_executive_id']='';
$_SESSION['stage_id']='';
$_SESSION['transfer']='';
$_SESSION['transfer_branch_id'] = '';
$_SESSION['transfer_user_type'] = '';
$_SESSION['transfer_user_from_id'] = '';
$_SESSION['transfer_user_to_id'] = '';
$_SESSION['filter_admission_check'] ='';
$_SESSION['filing_filter'] ='';
$_SESSION['founds_source'] ='';
$_SESSION['get_status'] = '';
$get_status = '';
if(!empty($_GET['transfer'])){
  $_SESSION['transfer'] = $_GET['transfer'];
}

if($_GET['filter']){
  $_REQUEST['filter'] = base64_decode(base64_decode(base64_decode($_GET['filter'])));
  $_SESSION['filter'] = $_REQUEST['filter'];
}
if($_GET['b_id']){
  $_REQUEST['branch_id'] = explode(',',base64_decode(base64_decode(base64_decode($_GET['b_id']))));
  $_SESSION['branch_id'] = $_REQUEST['branch_id'];
}
if($_GET['c_id']){
  $_REQUEST['counsellor_id'] = base64_decode(base64_decode(base64_decode($_GET['c_id'])));
  $_SESSION['counsellor_id'] = $_REQUEST['counsellor_id'];
}

if($_GET['a_id']){
  $_REQUEST['account_manager_id'] = base64_decode(base64_decode(base64_decode($_GET['a_id'])));
  $_SESSION['account_manager_id'] = $_REQUEST['account_manager_id'];
}

if($_GET['f_id']){
  $_REQUEST['filling_manager_id'] = base64_decode(base64_decode(base64_decode($_GET['f_id'])));
  $_SESSION['filling_manager_id'] = $_REQUEST['filling_manager_id'];
}

if($_GET['fe_id']){
  $_REQUEST['filling_executive_id'] = base64_decode(base64_decode(base64_decode($_GET['fe_id'])));
  $_SESSION['filling_executive_id'] = $_REQUEST['filling_executive_id'];
}


if($_REQUEST['filter']==2){
 $whr = " and a.am_id =0";
}
if($_REQUEST['filter']==3){
  $whr = " and a.am_id !='0'";
}
if($_REQUEST['filter']==4){
  $whr = " and a.status=0";
}

if($_REQUEST['filing_filter']==1){
 $whr = " and a.fm_allocated_id !='0'";
}
if($_REQUEST['filing_filter']==2){
   $whr = " and a.fm_allocated_id =0";
}
if($_REQUEST['filing_filter']==3){
  $whr = " and a.status=0";
}


if($_REQUEST['sraccount_manager_id']){
  $sraccount_manager_id = $_REQUEST['sraccount_manager_id'];
  $whr .= " and a.am_id=$sraccount_manager_id and sam_assign=1";
}

if($_REQUEST['filling_manager_project_id']){
  $filling_manager_project_id = $_REQUEST['filling_manager_project_id'];
  $whr .= " and a.fm_id=$filling_manager_project_id and fm_assign=1";
}


if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and a.country_id=$country_id";
}
if($_REQUEST['visa_id']){
  $visa_id = $_REQUEST['visa_id'];
  $whr .= " and a.visa_id=$visa_id";
}

if($_REQUEST['stage_id']){
  $stage_id = $_REQUEST['stage_id'];
  $whr .= " and b.stage_id=$stage_id";
  $_SESSION['stage_id'] = $stage_id;
}

if($_REQUEST['stage_status']){
  $stage_status = $_REQUEST['stage_status'];
  $whr .= " and b.cstatus='$stage_status'";

}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and a.branch_id in ($branch_id)";
}

if($_REQUEST['account_manager_id']){
  $account_manager_id = $_REQUEST['account_manager_id'];
  $whr .= " and a.am_id in ($account_manager_id)";
}

if($_REQUEST['counsellor_id']){
  $counsellor_id = $_REQUEST['counsellor_id'];
  $whr .= " and a.c_id in ($counsellor_id)";
}


if($_REQUEST['filling_executive_id']){
  $_SESSION['filling_executive_id'] = $_REQUEST['filling_executive_id'];
}

if($_REQUEST['student_type']){
  $student_type = $_REQUEST['student_type'];
  $whr .= " and a.student_type = $student_type";
}


if($_REQUEST['student_type']){
  $student_type = $_REQUEST['student_type'];
  $whr .= " and a.student_type = $student_type";
}

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
}

if($_REQUEST['founds_source']){
  $_SESSION['founds_source'] = $_REQUEST['founds_source'];
}

if($_REQUEST['filter_admission_check']){
  $filter_admission_check = $_REQUEST['filter_admission_check'];
  if($filter_admission_check==50){
    $tomorrow_date = date("Y-m-d");
  }else{
    $tomorrow_date = date("Y-m-d", strtotime("- $filter_admission_check day"));
  }
  
  $_SESSION['filter_admission_check'] = $tomorrow_date;
}



if($_REQUEST['transfer_branch_id']){
    $_SESSION['transfer_branch_id'] = $_REQUEST['transfer_branch_id'];
}

if($_REQUEST['transfer_user_type']){
    $_SESSION['transfer_user_type'] = $_REQUEST['transfer_user_type'];
}

if($_REQUEST['transfer_user_from_id']){
    $_SESSION['transfer_user_from_id'] = $_REQUEST['transfer_user_from_id'];
}

if($_REQUEST['transfer_user_to_id']){
    $_SESSION['transfer_user_to_id'] = $_REQUEST['transfer_user_to_id'];
}

$_SESSION['whr'] = $whr;

if(!empty($_REQUEST['transfer_val']) && !empty($_REQUEST['transfer_user_to_id'])){
  if(!empty($_REQUEST['userIdarr']) && count($_REQUEST['userIdarr'])>0){
    $transfer_user_from_id = $_REQUEST['transfer_user_from_id'];
    $transfer_user_type = $_REQUEST['transfer_user_type'];
    $transfer_user_to_id = $_REQUEST['transfer_user_to_id'];
    $userIdarr = implode(',',$_REQUEST['userIdarr']);

    $fsql='';
    if($transfer_user_type==3){
      $fsql .= "am_id='$transfer_user_to_id'";
    }else if($transfer_user_type==4){
      $branch_id = getField('branch_id','tbl_admin',$transfer_user_to_id);
      if($branch_id!=''){
        $fsql .= "branch_id='$branch_id',c_id='$transfer_user_to_id'";
      }
    }else if($transfer_user_type==8){
      $fsql .= "fe_id='$transfer_user_to_id'";
    }
    
    $obj->query("update $tbl_student set $fsql where id in ($userIdarr)",-1); //die;
    foreach($_REQUEST['userIdarr'] as $val){
      $obj->query("insert into $tbl_transfer_student set stu_id='$val',user_type='$transfer_user_type',user_from_id='$transfer_user_from_id',user_to_id='$transfer_user_to_id'");
    }    
    $_SESSION['sess_msg'] = "Student Successfully Transfered.";
  }else{
    $_SESSION['sess_msg'] = "Please select check box.";
  }
}
$addtional_role = explode(',',$_SESSION['additional_role']);
$condition = '';
            if(in_array(3,$addtional_role) || $_SESSION['level_id']==12){
                    $condition = " and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
            }

            if(isset($_POST['statuss1'])){
              if($_POST['statuss1'] == 'Total Visa Outcomes'){
                $get_status = " and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 $condition";
              }elseif($_POST['statuss1'] == 'Pending Visa Outcomes'){
                $get_status = " and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 and (b.cstatus!='Visa Approved' and b.cstatus!=' Visa Refused' and b.cstatus!=' Status Unknown') $condition";
              }else{
              $get_status = " and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 and b.cstatus='".$_POST['statuss1']."' $condition";
              }
              $_SESSION['get_status'] = $get_status;
            }
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
                <form action="slot-student-list.php" method="post" id="searchfrm">

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="priority">
                                <option value="">
                                    Select
                                    Priority
                                </option>
                                <option value="Critical" <?php if($userAppointmentResult->priority=='Critical'){?>
                                    selected <?php } ?>>
                                    Critical -
                                    Paid
                                    + urgent
                                    (Iritating)
                                </option>
                                <option value="High" <?php if($userAppointmentResult->priority=='High'){?> selected
                                    <?php } ?>>
                                    High - All
                                    paid
                                </option>
                                <option value="Medium" <?php if($userAppointmentResult->priority=='Mediumx'){?> selected
                                    <?php } ?>>
                                    Medium -
                                    Unpaid
                                    defer
                                </option>
                                <option value="Low" <?php if($userAppointmentResult->priority=='Low'){?> selected
                                    <?php } ?>>
                                    Low - All
                                    unpaid
                                    fresh
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="preference">
                                <option value="">
                                    Select
                                    Preference
                                </option>
                                <option value="Delhi" <?php if($userAppointmentResult->preference=='Delhi'){?> selected
                                    <?php } ?>>
                                    Delhi
                                </option>
                                <option value="Mumbai" <?php if($userAppointmentResult->preference=='Mumbai'){?>
                                    selected <?php } ?>>
                                    Mumbai
                                </option>
                                <option value="Heydrabad" <?php if($userAppointmentResult->preference=='Heydrabad'){?>
                                    selected <?php } ?>>
                                    Hyderabad
                                </option>
                                <option value="Kolkata" <?php if($userAppointmentResult->preference=='Kolkata'){?>
                                    selected <?php } ?>>
                                    Kolkata
                                </option>
                                <option value="Chennai" <?php if($userAppointmentResult->preference=='Chennai'){?>
                                    selected <?php } ?>>
                                    Chennai
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="biometric_location" id="biometric_location">
                                <option value="">
                                    Select
                                    Biometric
                                    Location
                                </option>
                                <option value="Delhi" <?php if($userAppointmentResult->biometric_location=='Delhi'){?>
                                    selected <?php } ?>>
                                    Delhi
                                </option>
                                <option value="Mumbai" <?php if($userAppointmentResult->biometric_location=='Mumbai'){?>
                                    selected <?php } ?>>
                                    Mumbai
                                </option>
                                <option value="Heydrabad"
                                    <?php if($userAppointmentResult->biometric_location=='Heydrabad'){?> selected
                                    <?php } ?>>
                                    Hyderabad
                                </option>
                                <option value="Kolkata"
                                    <?php if($userAppointmentResult->biometric_location=='Kolkata'){?> selected
                                    <?php } ?>>
                                    Kolkata
                                </option>
                                <option value="Chennai"
                                    <?php if($userAppointmentResult->biometric_location=='Chennai'){?> selected
                                    <?php } ?>>
                                    Chennai
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="interview_location" id="interview_location">
                                <option value="">
                                    Select
                                    Interview
                                    Location
                                </option>
                                <option value="Delhi" <?php if($userAppointmentResult->interview_location=='Delhi'){?>
                                    selected <?php } ?>>
                                    Delhi
                                </option>
                                <option value="Mumbai" <?php if($userAppointmentResult->interview_location=='Mumbai'){?>
                                    selected <?php } ?>>
                                    Mumbai
                                </option>
                                <option value="Hyderabad"
                                    <?php if($userAppointmentResult->interview_location=='Hyderabad'){?> selected
                                    <?php } ?>>
                                    Hyderabad
                                </option>
                                <option value="Kolkata"
                                    <?php if($userAppointmentResult->interview_location=='Kolkata'){?> selected
                                    <?php } ?>>
                                    Kolkata
                                </option>
                                <option value="Chennai"
                                    <?php if($userAppointmentResult->interview_location=='Chennai'){?> selected
                                    <?php } ?>>
                                    Chennai
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="pdf_status">
                                <option value="">
                                    Select PDF
                                    Status
                                </option>
                                <option value="Sent" <?php if($userAppointmentResult->pdf_status=='Sent'){?> selected
                                    <?php } ?>>
                                    Sent
                                </option>
                                <option value="Not Sent" <?php if($userAppointmentResult->pdf_status=='Not Sent'){?>
                                    selected <?php } ?>>
                                    Not Sent
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="id_owner"
                                <?=$_SESSION['level_id']==14 || in_array(6,$addtional_role) ? 'disabled' : ''?>>
                                <option value="">
                                    Select ID
                                    Onwer
                                </option>
                                <option value="IBT" <?php if($userAppointmentResult->id_owner=='IBT'){?> selected
                                    <?php } ?>>
                                    IBT
                                </option>
                                <option value="Student" <?php if($userAppointmentResult->id_owner=='Student'){?>
                                    selected <?php } ?>>
                                    Student
                                </option>
                                <option value="Slot Agent" <?php if($userAppointmentResult->id_owner=='Slot Agent'){?>
                                    selected <?php } ?>>
                                    Slot Agent
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control form-select" name="slot_status" id="slot__status"
                                <?=$_SESSION['level_id']==14  || in_array(6,$addtional_role)? 'disabled' : ''?>>
                                <option value="">
                                    Select Slot
                                    Status
                                </option>
                                <option value="Picked" <?php if($userAppointmentResult->slot_status=='Picked'){?>
                                    selected <?php } ?>>
                                    Picked
                                </option>
                                <option value="Not Picked"
                                    <?php if($userAppointmentResult->slot_status=='Not Picked'){?> selected <?php } ?>>
                                    Not Picked
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                style="height: 36px;" value="" placeholder="Biometric Start Date" onfocus="(this.type='date')"
                                onblur="(this.type='text')">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                style="height: 36px;" value="" placeholder="Biometric End Date"
                                onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                style="height: 36px;" value="" placeholder="Interview Start Date"
                                onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                style="height: 36px;" value="" placeholder="Interview End Date"
                                onfocus="(this.type='date')" onblur="(this.type='text')">
                        </div>
                    </div>
                </form>
                <?php
        if(in_array(3,$addtional_role) || $_SESSION['level_id']==12){
        ?>
                <form method="post" name="searchfrm2" id="searchfrm2" action="slot-student-list.php">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)"
                                                            onclick="getAppRecord2('Total Visa Outcomes')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="counter-anim">
                                                                    <?php
                              $visaSql = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 $condition $whr",$debug=-1);
                              echo $VisaResult=$obj->numRows($visaSql);
                              //13 Visa Approved
                              ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">Total
                                                                Visa Outcomes</span>
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
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)"
                                                            onclick="getAppRecord2('Visa Approved')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="counter-anim">
                                                                    <?php                             

                               $visaSql1 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id  where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13  and b.cstatus='Visa Approved' $condition $whr",$debug=-1);
                              echo $VisaResult1=$obj->numRows($visaSql1);
                              ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">Visa
                                                                Approved</span>
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
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)"
                                                            onclick="getAppRecord2(' Visa Refused')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="counter-anim">
                                                                    <?php
                              $visaSql3 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id  where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13  and b.cstatus=' Visa Refused' $condition $whr",$debug=-1);
                              echo $VisaResult2=$obj->numRows($visaSql3);
                              ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">Visa
                                                                Refused</span>
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
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)"
                                                            onclick="getAppRecord2(' Status Unknown')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="counter-anim">
                                                                    <?php
                              $visaSql3 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id  left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 and b.cstatus=' Status Unknown' $condition $whr",$debug=-1);
                              echo $VisaResult3=$obj->numRows($visaSql3);
                              ?>
                                                                </span></span>
                                                            <span class="weight-500 uppercase-font block font-13">Status
                                                                Unknown</span>
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
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <div class="panel panel-default card-view pa-0">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body pa-0">
                                        <div class="sm-data-box">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="javascript:void(0)"
                                                            onclick="getAppRecord2('Pending Visa Outcomes')">
                                                            <span class="txt-dark block counter"><span
                                                                    class="counter-anim">
                                                                    <?php echo $VisaResult-$VisaResult1-$VisaResult2-$VisaResult3; ?>
                                                                </span></span>
                                                            <span
                                                                class="weight-500 uppercase-font block font-13">Pending
                                                                Visa Outcomes</span>
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
                </form>
                <?php } ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-3">Color Code: <span style="color:red">Appointment not
                                                    added</span></div>
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
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
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
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
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
    })
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function getAppRecord2(status) {
        $('#searchfrm2').append('<input name="statuss1" value="' + status + '" type="hidden"/>');
        $("#searchfrm2").submit();
    }
    $("#country_id").change(function() {
        $("#searchfrm").submit();
    });

    $("#visa_id").change(function() {
        $("#searchfrm").submit();
    });

    $("#stage_id").change(function() {
        $("#searchfrm").submit();
    });
    $("#stage_status").change(function() {
        $("#searchfrm").submit();
    });
    </script>
</body>

</html>