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
$_SESSION['whq'] ='';
$_SESSION['get_status'] ='';
$whq = '';
$get_status = ''; 
$addtional_role = explode(',',$_SESSION['additional_role']);
if(isset($_POST['statuss1'])){
  $condition = '';
  if($_SESSION['level_id']==10){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $condition = " and a.branch_id in ($branch_id)";
    }elseif(in_array(3,$addtional_role) || $_SESSION['level_id']==12){
      $condition = " and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
      }
  if($_POST['statuss1'] == 'Total Visa Outcomes'){
    $get_status = "select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 $condition";
  }elseif($_POST['statuss1'] == 'Pending Visa Outcomes'){
    $get_status = "select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 and (b.cstatus!='Visa Approved' and b.cstatus!=' Visa Refused' and b.cstatus!=' Status Unknown') $condition";
  }else{
  $get_status = "select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0 and a.country_id=3 and a.visa_id=1 and b.stage_id=13 and b.cstatus='".$_POST['statuss1']."' $condition";
  }
  $_SESSION['get_status'] = $get_status;
}
if(isset($_POST['statuss'])){
  $whra = '';
          if($_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25 || $_SESSION['level_id']==17 || in_array(2,$addtional_role)){
            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
            $whra .= " and a.branch_id in ($branch_id)";
          }
          if($_SESSION['level_id']==14){
            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
            $whra .= " and a.branch_id in ($branch_id)";
          }
          if($_SESSION['level_id'] == 3){
            $account_manager_id = $_SESSION['sess_admin_id'];
            $whra .= " and a.am_id in ($account_manager_id)";
          }
          if($_SESSION['level_id'] == 4){
            $counsellor_id = $_SESSION['sess_admin_id'];
            $whra .= " and a.c_id in ($counsellor_id)";
          }

          $whq = "select a.* from $tbl_student as a inner join $tbl_student_updated_time as d ON a.id=d.stu_id where 1=1  $whra and TIMESTAMPDIFF(HOUR, d.cdate, NOW()) > 30";
}
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

if($_REQUEST['pre_state_id']){
  $pre_state_id = $_REQUEST['pre_state_id'];
  $whr .= " and a.pre_state_id=$pre_state_id";
}
if($_REQUEST['accept_student']){
    if($_REQUEST['accept_student'] == 'Yes'){
        $accept_student = 1;
    }else{
        $accept_student = 0;
    }
  $whr .= " and a.accept_student = $accept_student";
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
}else{
  $stage_status = '';
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

if($_REQUEST['intake']){
  $intake = $_REQUEST['intake'];
  $whr .= " and a.intake = '$intake'";
}

if($_REQUEST['intake_year']){
  $intake_year = $_REQUEST['intake_year'];
  $whr .= " and a.intake_year = '$intake_year'";
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
  }elseif($filter_admission_check=='never'){
    $tomorrow_date = 'never';
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
$_SESSION['whr_slot'] = '';
$whr_slot = '';
if(!empty($_REQUEST['type'])){
  if($_REQUEST['type'] == 'Allocated'){
    $whr_slot .= " and (c.slot_executive_id!='0' or c.slot_executive_id!='')";
  }else{
    $whr_slot .= " and (c.slot_executive_id='0' or c.slot_executive_id='')";
  }
}
if(!empty($_REQUEST['slot_executive_id'])){
    $whr_slot .= " and c.slot_executive_id='".$_REQUEST['slot_executive_id']."'";
}
if(!empty($_REQUEST['slot_type'])){
    $whr_slot .= " and c.slot_type='".$_REQUEST['slot_type']."'";
}
if(!empty($_REQUEST['slot_agent_id'])){
    $whr_slot .= " and c.slot_agent_id='".$_REQUEST['slot_agent_id']."'";
}
if(!empty($_REQUEST['priority'])){
    $whr_slot .= " and c.priority='".$_REQUEST['priority']."'";
}
if(!empty($_REQUEST['pdf_status'])){
    $whr_slot .= " and c.pdf_status='".$_REQUEST['pdf_status']."'";
}
if((!empty($_REQUEST['biometric_start_date']) && empty($_REQUEST['biometric_end_date'])) || (!empty($_REQUEST['biometric_end_date']) && empty($_REQUEST['biometric_start_date']))){
    $whr_slot .= " and (c.biometric_date='".$_REQUEST['biometric_start_date']."' or c.biometric_date='".$_REQUEST['biometric_end_date']."')";
}
if(!empty($_REQUEST['biometric_start_date']) && !empty($_REQUEST['biometric_end_date'])){
    $whr_slot .= " and c.biometric_date between'".$_REQUEST['biometric_start_date']."' and '".$_REQUEST['biometric_end_date']."'";
}
if((!empty($_REQUEST['interview_start_date']) && empty($_REQUEST['interview_end_date'])) || (!empty($_REQUEST['interview_end_date']) && empty($_REQUEST['interview_start_date']))){
    $whr_slot .= " and (c.interview_date='".$_REQUEST['interview_start_date']."' or c.interview_date='".$_REQUEST['interview_end_date']."')";
}
if(!empty($_REQUEST['interview_start_date']) && !empty($_REQUEST['interview_end_date'])){
    $whr_slot .= " and c.interview_date between'".$_REQUEST['interview_start_date']."' and '".$_REQUEST['interview_end_date']."'";
}

$_SESSION['whr_slot'] = $whr_slot;
$_SESSION['whr'] = $whr;
$_SESSION['whq'] = $whq;
$_SESSION['stage_status'] = $stage_status;

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
    
    $obj->query("update $tbl_student set transfer=1, $fsql where id in ($userIdarr)",-1); //die;
    foreach($_REQUEST['userIdarr'] as $val){
        $student_contact_no = getField("student_contact_no",$tbl_student, $val);
        $alternate_contact = getField("alternate_contact",$tbl_student, $val);
        $obj->query("update $tbl_visit set transfer=1 where (applicant_contact_no in ($student_contact_no, $alternate_contact) or applicant_alternate_no in ($student_contact_no, $alternate_contact))",-1); //die;
      $obj->query("insert into $tbl_transfer_student set stu_id='$val',user_type='$transfer_user_type',user_from_id='$transfer_user_from_id',user_to_id='$transfer_user_to_id'");
    }    
    $_SESSION['sess_msg'] = "Student Successfully Transfered.";
  }else{
    $_SESSION['sess_msg'] = "Please select check box.";
  }
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

.dt-buttons {
    float: none !important;
    margin-top: 15px !important;
}

.buttons-csv {
    float: right !important;
    margin-top: 15px !important;
}

.text-pagination {
    width: 304px;
    position: absolute;
    top: 1.5%;
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
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Student</h5>
                    </div>
                    <?php  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14){?>
                    <form class="form-horizontal form_csv_download_student"
                        action="download_csv.php?table_name=tbl_student&amp;p=student-list" method="post"
                        name="upload_excel" enctype="multipart/form-data" style="">
                        <div class="row">
                            <!-- <div class="col-md-4 col-6">
                  <input type="submit" name="studentList" class="btn btn-primary download_csv_button" value="Download CSV" style="background: yellow; color: #000">
                </div> -->
                        </div>
                    </form>
                    <?php }?>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <?php
              if($_SESSION['level_id']!=1){
                ?>
                            <li class="active"><span><a href="#">Mangae Student</a></span></li>
                            <?php
              }else{
                ?>
                            <li class="active"><span><a href="student-addf.php">Add Student</a></span></li>
                            <?php
              }
              ?>
                        </ol>
                    </div>
                    <?php
            if(isset($_SESSION['success'])){
              ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;">Student deleted successfully.</h5>
                    </div>
                    <?php
              unset($_SESSION['success']);
            }
            ?>
                </div>
                <?php
        if(base64_decode(base64_decode(base64_decode($_GET['transfer'])))!=1 && $_SESSION['level_id']!=10){?>
                <form method="post" name="searchfrm" id="searchfrm" action="student-list.php">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">
                                    <?php  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || $_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25  || $_SESSION['level_id']==17 || $_SESSION['level_id']==3 || $_SESSION['level_id']==24 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8){?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="branch_id[]" id="branch_id" class="form-control select2"
                                                multiple="">
                                                <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
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
                                    <?php
                                        if($_SESSION['level_id']!=3){
                                        ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="sraccount_manager_id" id="sraccount_manager_id"
                                                class="form-control">
                                                <option value="">Admission Manager</option>
                                                <?php
                                                    if(!empty($_REQUEST['branch_id'])){
                                                    $idArr = $_REQUEST['branch_id'];
                                                    $i=1; $whrr='';
                                                    foreach($idArr as $val){
                                                        if($i==1){
                                                        $whrr .=" and ( FIND_IN_SET($val, a.branch_id)";
                                                        }else{
                                                        $whrr .=" or FIND_IN_SET($val, a.branch_id)";
                                                        }
                                                        if($i==count($idArr)){
                                                        $whrr .=" )";
                                                        }
                                                        $i++;
                                                    }
                                                    }
                                                    $amSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.am_id where a.status=1 and a.level_id=2 and b.sam_assign=1 $whrr group by a.id",-1);
                                                    while($amResult = $obj->fetchNextObject($amSql)){?>
                                                <option value="<?php echo $amResult->id; ?>"
                                                    <?php if($_REQUEST['sraccount_manager_id']==$amResult->id){?>
                                                    selected <?php } ?>><?php echo $amResult->name; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="account_manager_id" id="account_manager_id"
                                                class="form-control">
                                                <option value="">Admission Executive</option>
                                                <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, b.branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, b.branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }
                                                }
                                                $amSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.am_id where a.status=1 and a.level_id=3 and b.am_id!=0 $whrr group by a.id",-1);
                                                while($amResult = $obj->fetchNextObject($amSql)){?>
                                                <option value="<?php echo $amResult->id; ?>"
                                                    <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected
                                                    <?php } ?>><?php echo $amResult->name; ?></option>
                                                <?php }
                     
                                             ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="filter" id="filter" class="form-control">
                                                <option value="">Admission Type</option>
                                                <option value="3" <?php if($_REQUEST['filter']==3){?> selected
                                                    <?php } ?>>Allocated </option>
                                                <option value="2" <?php if($_REQUEST['filter']==2){?> selected
                                                    <?php } ?>>Unallocated </option>
                                                <option value="4" <?php if($_REQUEST['filter']==4){?> selected
                                                    <?php } ?>>Inactive </option>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                    if($_SESSION['level_id']!=2){
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="filling_manager_project_id" id="filling_manager_project_id"
                                                class="form-control">
                                                <option value="">Filling Manager Projects</option>
                                                <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, a.branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, a.branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }        
                                                }                  
                                                $fmSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.fm_id where a.status=1 and a.level_id=7 and b.fm_assign=1 $whrr group by a.id",-1);
                                                while($fmResult = $obj->fetchNextObject($fmSql)){?>
                                                <option value="<?php echo $fmResult->id; ?>"
                                                    <?php if($_REQUEST['filling_manager_project_id']==$fmResult->id){?>
                                                    selected <?php } ?>><?php echo $fmResult->name; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="filling_executive_id" id="filling_executive_id"
                                                class="form-control">
                                                <option value="">Filling Executive</option>
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
                          $feSql = $obj->query("select * from $tbl_admin where status=1 and level_id=8 $whrr");
                          while($feResult = $obj->fetchNextObject($feSql)){?>
                                                <option value="<?php echo $feResult->id; ?>"
                                                    <?php if($_REQUEST['filling_executive_id']==$feResult->id){?>
                                                    selected <?php } ?>><?php echo $feResult->name; ?></option>
                                                <?php }
                       
                        ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="filing_filter" id="filing_filter" class="form-control">
                                                <option value="">Filing Type</option>
                                                <option value="1" <?php if($_REQUEST['filing_filter']==1){?> selected
                                                    <?php } ?>>Allocated </option>
                                                <option value="2" <?php if($_REQUEST['filing_filter']==2){?> selected
                                                    <?php } ?>>Unallocated </option>
                                                <option value="3" <?php if($_REQUEST['filing_filter']==3){?> selected
                                                    <?php } ?>>Inactive </option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } } ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="counsellor_id" id="counsellor_id" class="form-control">
                                                <option value="">Counsellor</option>
                                                <?php
                                                     // if(!empty($_REQUEST['branch_id'])){      
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
                                                        $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr");
                                                        while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['counsellor_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php 
                                                    // }
                                                    }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php }?>
                                    <?php
                                    if($_SESSION['level_id'] == '3'){
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="accept_student" id="accept_student" class="form-control">
                                                <option value="">Student Acceptance</option>
                                                <option value="Yes"
                                                    <?=$_REQUEST['accept_student'] == 'Yes' ? 'selected' : ''?>>Accepted
                                                </option>
                                                <option value="No"
                                                    <?=$_REQUEST['accept_student'] == 'No' ? 'selected' : ''?>>Pending
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control">
                                                <option value="">Select
                                                    <?=$_REQUEST['country_id'] == 7 ? 'Area' : 'Country'?></option>
                                                <?php
                        $cSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                        while($cResult = $obj->fetchNextObject($cSql)){?>
                                                <option value="<?php echo $cResult->id; ?>"
                                                    <?php if(isset($_POST['statuss1'])){ if($cResult->id == 3) { echo 'selected'; } }else{ if($_REQUEST['country_id']==$cResult->id){?>
                                                    selected <?php } } ?>><?php echo $cResult->name; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="pre_state_id" id="pre_state_id">
                                                <option value="">Select
                                                    <?=$_REQUEST['country_id'] == 7 ? 'Country' : 'State'?></option>
                                                <?php
                                            if($_REQUEST['country_id']!=''){
                                                $stateSql=$obj->query("select * from $tbl_state where 1=1 and status=1 and country_id='".$_REQUEST['country_id']."' group by state",-1);
                                                while($stateResult=$obj->fetchNextObject($stateSql)){?>
                                                <option value="<?php echo $stateResult->id ?>"
                                                    <?php if($_REQUEST['pre_state_id']==$stateResult->id){?> selected
                                                    <?php } ?>><?php echo $stateResult->state; ?></option>
                                                <?php } 
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="visa_id" id="visa_id" class="form-control">
                                                <option value="">Select Visa</option>
                                                <option value="1"
                                                    <?php if(isset($_POST['statuss1'])){ echo 'selected'; }else{ if($_REQUEST['visa_id']==1){?>
                                                    selected <?php } } ?>>Study Visa</option>
                                                <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected
                                                    <?php } ?>>Tourist Visa</option>
                                                <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected
                                                    <?php } ?>>Visitor Visa</option>
                                                <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected
                                                    <?php } ?>>Work Visa</option>
                                                <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected
                                                    <?php } ?>>Spouse Visa</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="stage_id" id="stage_id" class="form-control">
                                                <option value="">Select Stage</option>
                                                <?php
                                            if($_REQUEST['visa_id'] && $_POST['country_id']){
                                                $swhrs = " and country_id='".$_REQUEST['country_id']."' and visa_id='".$_REQUEST['visa_id']."'";
                                            $sSql = $obj->query("select * from $tbl_stage where  status=1  $swhrs  order by displayorder asc");
                                            while($sResult = $obj->fetchNextObject($sSql)){?>
                                                <option value="<?php echo $sResult->id; ?>"
                                                    <?php if(isset($_POST['statuss1'])){ if($sResult->id == 13) { echo 'selected'; } }else{ if($_REQUEST['stage_id']==$sResult->id){?>
                                                    selected <?php } }?>><?php echo $sResult->stage; ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="stage_status" id="stage_status" class="form-control">
                                                <option value="">Select Stage Status</option>
                                                <?php
                        if($_REQUEST['stage_id'] || isset($_POST['statuss1'])){   
                          $cstatusArr = array();
                          if($_REQUEST['stage_id']){
                          $stage = $_REQUEST['stage_id'];
                          }else{
                            $stage = 13;
                          }
                          $ssSql = $obj->query("select cstatus from $tbl_stage where id='$stage'  order by displayorder asc");
                          $ssResult = $obj->fetchNextObject($ssSql);
                          $cstatusArr = explode(', ',$ssResult->cstatus);
                          if(sizeof($cstatusArr)>0){
                            foreach($cstatusArr as $csval){?>
                                                <option value="<?php echo $csval; ?>"
                                                    <?php if(isset($_POST['statuss1']) && $_POST['statuss1'] == $csval){ echo 'selected'; }else{ if($_REQUEST['stage_status']==$csval){?>
                                                    selected <?php } } ?>><?php echo $csval; ?></option>
                                                <?php }
                          }
                        }?>

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
                                    <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="student_type" id="student_type" class="form-control">
                                                <option value="">Student Type</option>
                                                <option value="1" <?php if($_REQUEST['student_type']==1){?> selected
                                                    <?php } ?>>New</option>
                                                <option value="3" <?php if($_REQUEST['student_type']==3){?> selected <?php } ?>>Refused</option> 
                                                <option value="2" <?php if($_REQUEST['student_type']==2){?> selected
                                                    <?php } ?>>Defer</option>
                                                <option value="4" <?php if($_REQUEST['student_type']==4){?> selected
                                                    <?php } ?>>Re-apply (Same Intake)</option>
                                                <option value="6" <?php if($_REQUEST['student_type']==6){?> selected
                                                    <?php } ?>>Re-apply(Defer)</option>
                                                <option value="5" <?php if($_REQUEST['student_type']==5){?> selected
                                                    <?php } ?>>Re-Apply(New Applications)</option>
                                                <option value="7" <?php if($_REQUEST['student_type']==7){?> selected
                                                    <?php } ?>>New(Outsider Refused)</option>
                                                <option value="8" <?php if($_REQUEST['student_type']==8){?> selected
                                                    <?php } ?>>New (Filing Only)</option>
                                                <option value="9" <?php if($_REQUEST['student_type']==9){?> selected
                                                    <?php } ?>>University Transfer</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="student_type" id="student_type" class="form-control">
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="required form-control" name="student_type" id="student_type">
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
                                            <select name="founds_source" id="founds_source" class="form-control">
                                                <option value="">Funds Source</option>
                                                <option value="outside"
                                                    <?php if($_REQUEST['founds_source']=='outside'){?> selected
                                                    <?php } ?>>Outside </option>
                                                <option value="self" <?php if($_REQUEST['founds_source']=='self'){?>
                                                    selected <?php } ?>>Self </option>
                                                <option value="partial"
                                                    <?php if($_REQUEST['founds_source']=='partial'){?> selected
                                                    <?php } ?>>Partial </option>
                                                <option value="hold" <?php if($_REQUEST['founds_source']=='hold'){?>
                                                    selected <?php } ?>>Hold </option>
                                                <option value="pending_confirmation"
                                                    <?php if($_REQUEST['founds_source']=='pending_confirmation'){?>
                                                    selected <?php } ?>>Pending confirmation</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="filter_admission_check" id="filter_admission_check"
                                                class="form-control">
                                                <option value="">Last Checked on</option>
                                                <option value="50" <?php if($_REQUEST['filter_admission_check']==50){?>
                                                    selected <?php } ?>>Today</option>
                                                <?php
                        for($j=1; $j<31; $j++){?>
                                                <option value="<?php echo $j ?>"
                                                    <?php if($_REQUEST['filter_admission_check']==$j){?> selected
                                                    <?php } ?>><?php echo $j ?> Days</option>
                                                <?php }?>
                                                <option value="never"
                                                    <?php if($_REQUEST['filter_admission_check']=='never'){?> selected
                                                    <?php } ?>>Not Updated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control required" id="intake" name="intake">
                                                <option value="">Select Intake Month</option>
                                                <option value="1" <?php if($_REQUEST['intake']==1){?> selected <?php }?>>January</option>
                                                <option value="2" <?php if($_REQUEST['intake']==2){?> selected <?php }?>>February</option>
                                                <option value="3" <?php if($_REQUEST['intake']==3){?> selected <?php }?>>March</option>
                                                <option value="4" <?php if($_REQUEST['intake']==4){?> selected <?php }?>>April</option>
                                                <option value="5" <?php if($_REQUEST['intake']==5){?> selected <?php }?>>May</option>
                                                <option value="6" <?php if($_REQUEST['intake']==6){?> selected <?php }?>>June</option>
                                                <option value="7" <?php if($_REQUEST['intake']==7){?> selected <?php }?>>July</option>
                                                <option value="8" <?php if($_REQUEST['intake']==8){?> selected <?php }?>>August</option>
                                                <option value="9" <?php if($_REQUEST['intake']==9){?> selected <?php }?>>September</option>
                                                <option value="10" <?php if($_REQUEST['intake']==10){?> selected <?php }?>>October</option>
                                                <option value="11" <?php if($_REQUEST['intake']==11){?> selected <?php }?>>November </option>
                                                <option value="12" <?php if($_REQUEST['intake']==12){?> selected <?php }?>>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control required" id="intake_year" name="intake_year">
                                                <option value="">Select Intake Year</option>
                                                <?php
                                            for($i = 2024; $i < date("Y")+10; $i++){
                                                ?>
                                                <option value="<?=$i?>"
                                                    <?=$_REQUEST['intake_year'] == $i ? 'selected' : ''?>>
                                                    <?=$i?></option>
                                                <?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>

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
                <?php }?>

                <?php  
                if (($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || $_SESSION['level_id']==25) && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                <form method="post" name="filterfrm" id="filterfrm"
                    action="student-list.php?transfer=<?php echo base64_encode(base64_encode(base64_encode(1))); ?>">
                    <input type="hidden" name="transfer_val" value="yes">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="transfer_branch_id" id="transfer_branch_id"
                                                class="form-control" placeholder="Select Branch">
                                                <option value="">Select Branch</option>
                                                <?php                          
                                                  $branchSql1 = $obj->query("select * from $tbl_branch where status=1");
                                                  while($branchResult1 = $obj->fetchNextObject($branchSql1)){?>
                                                <option value="<?php echo $branchResult1->id; ?>"
                                                    <?php if($branchResult1->id==$_REQUEST['transfer_branch_id']){?>
                                                    selected <?php } ?>><?php echo $branchResult1->name; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="transfer_user_type" id="transfer_user_type"
                                                class="form-control">
                                                <option value="">Type of User</option>
                                                <option value="2" <?php if($_REQUEST['transfer_user_type']==2){?>
                                                    selected <?php } ?>>Admission Manager</option>
                                                <option value="3" <?php if($_REQUEST['transfer_user_type']==3){?>
                                                    selected <?php } ?>>Admission Executive</option>
                                                <option value="4" <?php if($_REQUEST['transfer_user_type']==4){?>
                                                    selected <?php } ?>>Counseller</option>
                                                <option value="5" <?php if($_REQUEST['transfer_user_type']==5){?>
                                                    selected <?php } ?>>Document Manager</option>
                                                <option value="6" <?php if($_REQUEST['transfer_user_type']==6){?>
                                                    selected <?php } ?>>Media Manager</option>
                                                <option value="7" <?php if($_REQUEST['transfer_user_type']==7){?>
                                                    selected <?php } ?>>File Manager</option>
                                                <option value="8" <?php if($_REQUEST['transfer_user_type']==8){?>
                                                    selected <?php } ?>>File Executive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="transfer_user_from_id" id="transfer_user_from_id"
                                                class="form-control">
                                                <option value="">Shift From</option>
                                                <?php
                                                if(!empty($_REQUEST['transfer_branch_id']) && !empty($_REQUEST['transfer_user_type'])){
                                                  $transfer_branch_id = $_REQUEST['transfer_branch_id'];
                                                  $t_user_type = $_REQUEST['transfer_user_type'];
                                                  
                                                  $ssql = $obj->query("select * from $tbl_admin where status=1 and level_id='$t_user_type' and FIND_IN_SET($transfer_branch_id, branch_id)",-1); //die();
                                                  while($sResult = $obj->fetchNextObject($ssql)){?>
                                                <option value="<?php echo $sResult->id; ?>"
                                                    <?php if($_REQUEST['transfer_user_from_id']==$sResult->id){?>
                                                    selected <?php } ?>><?php echo $sResult->name; ?></option>';
                                                <?php }
                                                  }
                                                  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="transfer_user_to_id" id="transfer_user_to_id"
                                                class="form-control">
                                                <option value="">Shift To</option>
                                                <?php
                                                if(!empty($_REQUEST['transfer_branch_id']) && !empty($_REQUEST['transfer_user_type'])){
                                                  $transfer_branch_id = $_REQUEST['transfer_branch_id'];
                                                  $t_user_type = $_REQUEST['transfer_user_type'];
                                                  $transfer_user_from_id='';
                                                  if($_REQUEST['transfer_user_from_id']){
                                                    $transfer_user_from_id = $_REQUEST['transfer_user_from_id'];
                                                  }
                                                  $ssql = $obj->query("select * from $tbl_admin where status=1 and level_id='$t_user_type' and FIND_IN_SET($transfer_branch_id, branch_id) and id!='$transfer_user_from_id'",-1); //die();
                                                  while($sResult = $obj->fetchNextObject($ssql)){?>
                                                <option value="<?php echo $sResult->id; ?>">
                                                    <?php echo $sResult->name; ?></option>';
                                                <?php }
                                                  }
                                                  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" name="subit"
                                                class="btn btn-primary download_csv_button"
                                                style="width: 170px; height: 40px;">Transfer</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php }?>



                    <?php  
                    if ($_SESSION['level_id']==10){?>
                    <form method="post" name="slotfilterfrm" id="slotfilterfrm" action="student-list.php">
                        <input type="hidden" name="transfer_val" value="yes">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper">
                                        <div class="col-md-3">
                                            <select name="type" class="form-control slot_filter">
                                                <option value="">Select Type</option>
                                                <option value="Allocated"
                                                    <?php echo $_REQUEST['type'] == 'Allocated' ? 'selected' : ''; ?>>
                                                    Allocated</option>
                                                <option value="Unallocated"
                                                    <?php echo $_REQUEST['type'] == 'Unallocated' ? 'selected' : ''; ?>>
                                                    Unallocated</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control slot_filter" name="slot_executive_id"
                                                id="slot_executive_id">
                                                <option value="">Select Slot Executive</option>
                                                <?php
														$sql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and additional_role like '%3%'",-1);  
														while($resultt=$obj->fetchNextObject($sql)){?>
                                                <option value="<?php echo $resultt->id ?>"
                                                    <?php echo $_REQUEST['slot_executive_id'] == $resultt->id  ? 'selected' : ''; ?>>
                                                    <?php echo $resultt->name .'  ('.$resultt->email.')'; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control  slot_filter form-select" name="slot_type"
                                                id="slot_type">
                                                <option value="">Select Slot Type</option>
                                                <option value="Paid"
                                                    <?php echo $_REQUEST['slot_type'] == 'Paid' ? 'selected' : ''; ?>>
                                                    Paid</option>
                                                <option value="Free"
                                                    <?php echo $_REQUEST['slot_type'] == 'Free' ? 'selected' : ''; ?>>
                                                    Free</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control slot_filter form-select" name="slot_agent_id"
                                                id="slot_agent_id">
                                                <option value="">Select Slot Agent Name</option>
                                                <?php
													$sagentSql = $obj->query("select * from $tbl_slot_agent where status=1");
													while($sagentResult = $obj->fetchNextObject($sagentSql)){?>
                                                <option value="<?php echo $sagentResult->id;  ?>"
                                                    <?php echo $_REQUEST['slot_agent_id'] == $sagentResult->id ? 'selected' : ''; ?>>
                                                    <?php echo $sagentResult->name;  ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <select class="form-control slot_filter form-select" name="priority">
                                                <option value="">Select Priority</option>
                                                <option value="Critical"
                                                    <?php echo $_REQUEST['priority'] == 'Critical' ? 'selected' : ''; ?>>
                                                    Critical - Paid + urgent (Iritating)</option>
                                                <option value="HiHigh"
                                                    <?php echo $_REQUEST['priority'] == 'High' ? 'selected' : ''; ?>>
                                                    High - All paid</option>
                                                <option value="Medium"
                                                    <?php echo $_REQUEST['priority'] == 'Medium' ? 'selected' : ''; ?>>
                                                    Medium - Unpaid defer</option>
                                                <option value="Low"
                                                    <?php echo $_REQUEST['priority'] == 'Low' ? 'selected' : ''; ?>>Low
                                                    - All unpaid fresh</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <select class="form-control slot_filter form-select" name="pdf_status">
                                                <option value="">Select PDF Status</option>
                                                <option value="Sent" <?php if($_REQUEST['pdf_status']=='Sent'){?>
                                                    selected <?php } ?>>Sent</option>
                                                <option value="Not Sent"
                                                    <?php if($_REQUEST['pdf_status']=='Not Sent'){?> selected
                                                    <?php } ?>>Not Sent</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <div class="form-group">
                                                <input type="text" name="biometric_start_date" id="biometric_start_date"
                                                    class="form-control slot_filter" style="height: 36px;"
                                                    value="<?php echo $_REQUEST['biometric_start_date']; ?>"
                                                    placeholder="Biometric Start Date" onfocus="(this.type='date')"
                                                    onblur="(this.type='text')">
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <div class="form-group">
                                                <input type="text" name="biometric_end_date" id="biometric_end_date"
                                                    class="form-control slot_filter" style="height: 36px;"
                                                    value="<?php echo $_REQUEST['biometric_end_date']; ?>"
                                                    placeholder="Biometric End Date" onfocus="(this.type='date')"
                                                    onblur="(this.type='text')">
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <div class="form-group">
                                                <input type="text" name="interview_start_date" id="interview_start_date"
                                                    class="form-control slot_filter" style="height: 36px;"
                                                    value="<?php echo $_REQUEST['interview_start_date']; ?>"
                                                    placeholder="Interview Start Date" onfocus="(this.type='date')"
                                                    onblur="(this.type='text')">
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
                                            <div class="form-group">
                                                <input type="text" name="interview_end_date" id="interview_end_date"
                                                    class="form-control slot_filter" style="height: 36px;"
                                                    value="<?php echo $_REQUEST['interview_end_date']; ?>"
                                                    placeholder="Interview End Date" onfocus="(this.type='date')"
                                                    onblur="(this.type='text')">
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="margin-top:15px">
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

                        <?php }?>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                            <div class="table-wrap">
                                                <div class="row">
                                                    <div class="col-md-12 mt-3 mb-3"> Color Code: <span
                                                            style="color:red"><?php if($_SESSION['level_id']==1){ ?>AE
                                                            Not Selected
                                                            <?php }elseif($_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25){ echo "AE Not Selected";} elseif($_SESSION['level_id']==3 || $_SESSION['level_id']==24){?>
                                                            Project not accepted
                                                            <?php } elseif($_SESSION['level_id']==7 || $_SESSION['level_id']==8 ){ echo "Filling Creadentials not added"; }elseif($_SESSION['level_id']==10){ echo "Appointment not added"; } ?></span>,
                                                        <span style="color:green">I-20 Received</span>, <span
                                                            style="color:blue">New Application added</span>, <span
                                                            style="color:purple">Time Stamp not updated</span>,
                                                        <span style="color:white;background:red;padding:4px;">Visa
                                                            Refused</span>,
                                                        <span style="color:white;background:orange;padding:4px;">
                                                            Back-Out</span>,
                                                        <span style="color:white;background:green;padding:4px;">Visa
                                                            Approved</span>
                                                        <span style="background:pink;padding:4px;">Rejected by
                                                            H.O</span>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="studentList" class="table table-hover display  pb-30">
                                                        <div class="choose_prog" style="">
                                                        </div>
                                                        <thead>
                                                            <tr>
                                                                <?php  
                                                                 if (($_SESSION['level_id']==1 || $_SESSION['level_id']==25) && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                                                                <th></th>
                                                                <?php }?>
                                                                <th>Student Id</th>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Name</th>
                                                                <th>Mobile Number</th>
                                                                <th>Father Name</th>
                                                                <th>Passport No.</th>
                                                                <th>Country</th>
                                                                <th>Intake</th>
                                                                <th>Student/Case Type</th>
                                                                <th>Visa Type</th>
                                                                <th>Counsellor Name</th>
                                                                <th>Admission\Tourist Visa Executive</th>
                                                                <th>Branch Name</th>
                                                                <th>Profile Status</th>
                                                                <th>Screening Interview Status</th>
                                                                <?php  
                                                                  if ($_SESSION['level_id']==1){?>
                                                                <th>Filling Executive</th>
                                                                <?php } ?>
                                                                <?php  
                                                                  if ($_SESSION['level_id']==4 || $_SESSION['level_id']==11 || $_SESSION['level_id']==1){?>
                                                                <th>Management Meet</th>
                                                                <?php  
                                                                  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==4){?>
                                                                <th>Passcode</th>
                                                                <?php } ?>
                                                                <?php  
                                                                 }
                                                                 if ($_SESSION['level_id']==1){?>
                                                                <th>Status</th>
                                                                <th>Student Login</th>
                                                                <?php } ?>
                                                                <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || in_array(6,$addtional_role) || $_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25  || $_SESSION['level_id']==17 || $_SESSION['level_id']==3 || $_SESSION['level_id']==24 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8 || $_SESSION['level_id']==10 || $_SESSION['level_id']==11 || $_SESSION['level_id']==11 || in_array(6,$addtional_role)){?>
                                                                <th>Action</th>
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


                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-white">
                                    <h5 class="modal-title pull-left" id="exampleModalLabel">Management Meet</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="controller.php" method="post" id="get_modal_data">

                                </form>
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
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
    $(".select2").select2({
        placeholder: "Select Branch",
        allowClear: true
    });

    function del_prompt(frmobj, comb) {
        alert(comb);
        if (comb == 'Delete') {
            if (confirm("Are you sure you want to delete record(s)")) {
                frmobj.action = "student-del.php";
                frmobj.what.value = "Delete";
                frmobj.submit();

            } else {
                return false;
            }
        } else if (comb == 'Disable') {
            frmobj.action = "student-del.php";
            frmobj.what.value = "Disable";
            frmobj.submit();
        } else if (comb == 'Enable') {
            frmobj.action = "student-del.php";
            frmobj.what.value = "Enable";
            frmobj.submit();
        }

    }


    // $('#country_id').change(function() {
    //   var id = $('#country_id').val();
    //   var action='get_stage_id'
    //   $.ajax({
    //     type:"post",
    //     url:"ajax/getModalData.php",
    //     data :{
    //       'key' : id,'action': action              
    //     },          
    //     success:function(res){
    //       $('#stage_id').html(res); 
    //       $("#searchfrm").submit();

    //     }
    //   });
    // });

    // $('#visa_id').change(function() {
    //   var country_id = $('#country_id').val();
    //   var id = $('#visa_id').val();
    //   var action='get_cstage_id'
    //   $.ajax({
    //     type:"post",
    //     url:"ajax/getModalData.php",
    //     data :{
    //       'key' : id,'country_id':country_id,'action': action              
    //     },          
    //     success:function(res){
    //       $('#stage_id').html(res); 
    //       $("#searchfrm").submit();

    //     }
    //   });
    // });


    // $("#transfer_user_type").change(function(){
    //   var t_user_type = $(this).val();
    //   var t_branch_id = $("#transfer_branch_id").val();
    //   $.ajax({
    //     type:"post",
    //     url:"ajax/getModalData.php",
    //     data :{
    //       'user_type' : t_user_type,'t_branch_id':t_branch_id,'action':'getTransferUserList'              
    //     },          
    //     success:function(res){
    //       res = res.split('##');
    //       $('#transfer_user_from_id').html(res[0]); 
    //       $('#transfer_user_to_id').html(res[1]); 
    //     }
    //   });
    // })


    $("#stage_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#accept_student").change(function() {
        $("#searchfrm").submit();
    })

    $("#stage_status").change(function() {
        $("#searchfrm").submit();
    })

    $("#filter").change(function() {
        $("#searchfrm").submit();
    })

    $("#branch_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#account_manager_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#sraccount_manager_id").change(function() {
        $("#searchfrm").submit();
    })



    $("#counsellor_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#filling_manager_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#filling_manager_project_id").change(function() {
        $("#searchfrm").submit();
    })


    $("#filling_executive_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#country_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#pre_state_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#visa_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#student_type").change(function() {
        $("#searchfrm").submit();
    })

    $("#filing_filter").change(function() {
        $("#searchfrm").submit();
    })

    $("#filter_admission_check").change(function() {
        $("#searchfrm").submit();
    })

    $("#founds_source").change(function() {
        $("#searchfrm").submit();
    })
    $("#intake").change(function() {
        $("#searchfrm").submit();
    })
    $("#intake_year").change(function() {
        $("#searchfrm").submit();
    })


    $("#transfer_branch_id").change(function() {
        $("#filterfrm").submit();
    })

    $("#transfer_user_type").change(function() {
        $("#filterfrm").submit();
    })
    $("#transfer_user_from_id").change(function() {
        $("#filterfrm").submit();
    })




    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
        ],
        "pageLength": 10,
        <?php  
    if ($_SESSION['level_id']==1){?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            }
        ],
        <?php }?> "ajax": {
            url: "student-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
        <?php  
    if ($_SESSION['level_id']==1){?> "dom": '<"top"lfB>rt<"bottom"ip><"clear">',
        "buttons": [{
            extend: 'csvHtml5',
            text: 'Download CSV',
            title: 'Student List',
            exportOptions: {
                columns: ':not(:last-child):not(:nth-last-child(2))'
            }
        }],
        <?php } ?> "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData[13] == "Visa Approved" || aData[14] == "Visa Approved" || aData[15] ==
                "Visa Approved") {
                $('td', nRow).css('background-color', 'green').css('color', 'white !important');
            } else if (aData[13] == "Visa Refused" || aData[14] == "Visa Refused" || aData[15] ==
                "Visa Refused") {
                $('td', nRow).css('background-color', '#C5221F').css('color', 'white !important');
            } else if (aData[13] == 'Back-out' || aData[14] == 'Back-out' || aData[15] == 'Back-out') {
                $('td', nRow).css('background-color', 'orange').css('color', 'white !important');
            } else if (aData[15] == 'Disqualified') {
                $('td', nRow).css('background-color', 'pink').css('color', 'white !important');
            } else {
                $('td', nRow).css('background-color', '');
            }
        }
    });

    $("div#studentList_wrapper").append(
        '<div class="text-pagination"><label for="page-input">Go to page: </label><input id="usermobile" type="text" min="1" style="width: 60px;"></div>'
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
    $(".slot_filter").change(function() {
        $("#slotfilterfrm").submit();
    });

    function warning(x, y) {
        Swal.fire({
            title: "Are you sure?",
            text: x,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = y;
            }
        });
    }
    </script>

    <script>
    function get_modal(id) {
        $.ajax({
            type: "post",
            url: "controller.php",
            data: {
                'get_student_modal': id
            },
            success: function(data) {
                $("#exampleModal").modal('show');
                $("#get_modal_data").html(data);
            }
        });
    }
    </script>
    <script>
    function chage_login_status(id, val) {
        if (val.checked) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajax({
            type: "post",
            url: "controller.php",
            data: {
                'chage_login_status': id,
                'status': status
            },
            success: function(data) {

            }
        });
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