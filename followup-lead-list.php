<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

$fromdate = '2025-04-17';
$todate = date("Y-m-d", strtotime("-1 day"));
$_SESSION['whr'] = '';
if($_REQUEST['status']){
  $status = $_REQUEST['status'];
  if($status==1){
    $whr =" and status=1 and (date(inital_start_date) between '$fromdate' and  '$todate' and inital_remarks!=0 and support_inital_additional_remarks is null)";
  }
  elseif($status==2){
    $whr =" and status=1 and (date(followup1_start_date) between '$fromdate' and  '$todate' and followup1_remarks!=0 and support_followup1_additional_remarks is null)";
  }
  elseif($status==3){
    $whr =" and status=1 and (date(followup2_start_date) between '$fromdate' and  '$todate' and followup2_remarks!=0 and support_followup2_additional_remarks is null)";
  }
  elseif($status==4){
    $whr =" and status=1 and (date(followup3_start_date) between '$fromdate' and  '$todate' and followup3_remarks!=0 and support_followup3_additional_remarks is null)";
  }
  elseif($status==5){
    $whr =" and status=1 and (date(last_followup_start_date) between '$fromdate' and  '$todate' and last_followup_remarks!=0 and support_last_followup_additional_remarks is null)";
  }else{
      $whr=" and status=1 and ((date(followup3_start_date) between '$fromdate' and  '$todate' and followup1_remarks!=0 and support_followup1_additional_remarks is null  ) 
    OR (date(followup2_start_date) between '$fromdate' and  '$todate' and followup2_remarks!=0 and support_followup2_additional_remarks is null  ) )";
    //   $whr=" and ((date(inital_start_date) between '$fromdate' and  '$todate' and inital_remarks!=0 and support_inital_additional_remarks is null  ) 
    // OR (date(followup3_start_date) between '$fromdate' and  '$todate' and followup1_remarks!=0 and support_followup1_additional_remarks is null  ) 
    // OR (date(followup2_start_date) between '$fromdate' and  '$todate' and followup2_remarks!=0 and support_followup2_additional_remarks is null  ) 
    // OR (date(followup3_start_date) between '$fromdate' and  '$todate' and followup3_remarks!=0 and support_followup3_additional_remarks is null )
    // OR (date(last_followup_start_date) between '$fromdate' and  '$todate' and last_followup_remarks!=0 and support_last_followup_additional_remarks is null ))";
  }
}else{
if(isset($_REQUEST['pending']) && $_REQUEST['pending'] != ''){
    $whr=" and status=1 and ((date(followup1_start_date) between '$fromdate' and  '$todate' and followup1_remarks!=0 and support_followup1_additional_remarks is null  ) 
    OR (date(followup2_start_date) between '$fromdate' and  '$todate' and followup2_remarks!=0 and support_followup2_additional_remarks is null  ))";
}else{
  $whr=" and ((date(inital_next_followup_date) = '$todate' and followup1_remarks =0  and inital_status!='4' ) 
OR (date(followup1_next_followup_date) = '$todate' and followup2_remarks =0  and followup1_status!='4' ) 
OR (date(followup2_next_followup_date) = '$todate' and followup3_remarks =0  and followup2_status!='4' ) 
OR (date(followup3_next_followup_date) = '$todate' and last_followup_remarks=0  and followup3_status!='4' ))";
}
}
$whr1 = "";
if($_SESSION['level_id']==19 || $_SESSION['level_id'] == 25){
  $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
  $whr .= " and branch_id in ($branchid)";
  $whr1 .= " and branch_id in ($branchid)";
}
if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and branch_id in ($branch_id)";
  $whr1 .= " and branch_id in ($branch_id)";
}
if($_REQUEST['state_id']){
  $state_id = $_REQUEST['state_id'];
  $whr .= " and state_id=$state_id";
  $whr1 .= " and state_id=$state_id";
}
if($_REQUEST['city_id']){
  $city_id = $_REQUEST['city_id'];
  $whr .= " and city_id=$city_id";
  $whr1 .= " and city_id=$city_id";
}
if($_REQUEST['crm_executive_id']){
  $crm_executive_id = $_REQUEST['crm_executive_id'];
  $whr .= " and crm_executive_id = $crm_executive_id";
  $whr1 .= " and crm_executive_id = $crm_executive_id";
}
if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  $whr .= " and FIND_IN_SET('$visa_type',visa_type)";
  $whr1 .= " and FIND_IN_SET('$visa_type',visa_type)";
}
if($_REQUEST['source']){
  $source = $_REQUEST['source'];
  $whr .= " and source = '$source'";
  $whr1 .= " and source = '$source'";
}

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
  $whr1 .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
}

if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 6){
        $whr .= " and ((inital_status=8 and followup1_status=0 ) OR (followup1_status=8 and followup2_status =0 )  OR (followup2_status=8 and  followup3_status =0 ) OR (followup3_status=8 and  last_followup_status =0 ))";
    }
    elseif($status == 7){
        $whr .= " and ((inital_status=9 and followup1_status=0 ) OR (followup1_status=9 and followup2_status =0 )  OR (followup2_status=9 and  followup3_status =0 ) OR (followup3_status=9 and  last_followup_status =0 ))";
    }
    elseif($status == 8){
        $whr .= " and ((inital_status=3 and followup1_status=0 ) OR (followup1_status=3 and followup2_status =0 )  OR (followup2_status=3 and  followup3_status =0 ) OR (followup3_status=3 and  last_followup_status =0 ))";
    }
    elseif($status == 9){
        $whr .= " and ((inital_status=4 and followup1_status=0 ) OR (followup1_status=4 and followup2_status =0 )  OR (followup2_status=4 and  followup3_status =0 ) OR (followup3_status=4 and  last_followup_status =0 ))";
    }
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
                        <h5 class="txt-dark">Manage Follow Up Leads
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form method="post" name="searchfrm" id="searchfrm" action="followup-lead-list.php">
                    <input type="hidden" name="pending" value="<?=$_REQUEST['pending'] ? '1' : ''?>">
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
                                            <select name="crm_executive_id" id="crm_executive_id" class="form-control">
                                                <option value="">CRM Executive</option>
                                                <?php
                        // if(!empty($_REQUEST['branch_id'])){                          
                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['crm_executive_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                        // }
                        ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <?php
                        $sSql = $obj->query("select * from $tbl_location_states where 1=1 and status=1 order by name asc");
                        while($sResult = $obj->fetchNextObject($sSql)){?>
                                                <option value="<?php echo $sResult->id; ?>"
                                                    <?php if($_REQUEST['state_id']==$sResult->id){?> selected
                                                    <?php } ?>><?php echo $sResult->name; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="city_id" id="city_id" class="form-control">
                                                <option value="">Select District</option>
                                                <?php
                        if($_REQUEST['state_id']){
                          $iSql = $obj->query("select * from $tbl_location_cities where 1=1 and status=1 and state_id='".$_REQUEST['state_id']."' order by name asc");
                          while($iResult = $obj->fetchNextObject($iSql)){?>
                                                <option value="<?php echo $iResult->id; ?>"
                                                    <?php if($_REQUEST['city_id']==$iResult->id){?> selected <?php } ?>>
                                                    <?php echo $iResult->name; ?></option>
                                                <?php } 
                        } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                              <select class="form-control" id="visa_type" name="visa_type">
                                                <option value="">Visa Type</option>
                                                <option value="Study" <?php if($_REQUEST['visa_type']=='Study'){?>
                                                    selected <?php }?>>Study</option>
                                                <option value="Visitior/tourist"
                                                    <?php if($_REQUEST['visa_type']=='Visitior/tourist'){?> selected
                                                    <?php }?>>Visitor/tourist</option>
                                                <option value="Spouse" <?php if($_REQUEST['visa_type']=='Spouse'){?>
                                                    selected <?php }?>>Spouse</option>
                                                <option value="Work" <?php if($_REQUEST['visa_type']=='Work'){?>
                                                    selected <?php }?>>Work</option>
                                                <option value="Interview Preparation"
                                                    <?php if($_REQUEST['visa_type']=='Interview Preparation'){?>
                                                    selected <?php }?>>Interview Preparation</option>
                                                <option value="Filing Only"
                                                    <?php if($_REQUEST['visa_type']=='Filing Only'){?> selected
                                                    <?php }?>>Filing Only</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="source" name="source">
                                                <option value="">Source Type</option>
                                                <option value="Youtube" <?php if($_REQUEST['source']=='Youtube'){?>
                                                    selected <?php }?>>Youtube</option>
                                                <option value="Facebook" <?php if($_REQUEST['source']=='Facebook'){?>
                                                    selected <?php }?>>Facebook</option>
                                                <option value="Instagram" <?php if($_REQUEST['source']=='Instagram'){?>
                                                    selected <?php }?>>Instagram</option>
                                                <option value="Google" <?php if($_REQUEST['source']=='Google'){?>
                                                    selected <?php }?>>Google</option>
                                                <option value="Website" <?php if($_REQUEST['source']=='Website'){?>
                                                    selected <?php }?>>Website</option>
                                                <option value="Hoarding/Banner"
                                                    <?php if($_REQUEST['source']=='Hoarding/Banner'){?> selected
                                                    <?php }?>>Hoarding/Banner</option>
                                                <option value="Friends" <?php if($_REQUEST['source']=='Friends'){?>
                                                    selected <?php }?>>Friends</option>
                                                <option value="Paper Ad" <?php if($_REQUEST['source']=='Paper Ad'){?>
                                                    selected <?php }?>> Newspaper Advertisement</option>
                                                <option value="Seminar" <?php if($_REQUEST['source']=='Seminar'){?>
                                                    selected <?php }?>>Seminar</option>
                                                <option value="Relatives" <?php if($_REQUEST['source']=='Relatives'){?>
                                                    selected <?php }?>> Relatives</option>
                                                <option value="Seminar/Education Fair"
                                                    <?php if($_REQUEST['source']=='Seminar/Education Fair'){?> selected
                                                    <?php }?>> Seminar/Education Fair</option>
                                                <option value="Direct Visit"
                                                    <?php if($_REQUEST['source']=='Direct Visit'){?> selected <?php }?>>
                                                    Direct Visit</option>
                                                <option value="Recommend by other Consultant"
                                                    <?php if($_REQUEST['source']=='Recommend by other Consultant'){?>
                                                    selected <?php }?>> Recommend by other Consultant</option>
                                                <option value="Telecalling"
                                                    <?php if($_REQUEST['source']=='Telecalling'){?> selected <?php }?>>
                                                    Telecalling</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="filter_start_date" id="filter_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                                placeholder="Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
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

                <?php
                if(isset($_REQUEST['pending']) && $_REQUEST['pending'] != ''){
                ?>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(6)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr  and status=1 and ((inital_status=8 and followup1_status=0 ) OR (followup1_status=8 and followup2_status =0 )  OR (followup2_status=8 and  followup3_status =0 ) OR (followup3_status=8 and  last_followup_status =0 ))",$debug=-1);
                              $line2=$obj->fetchNextObject($sql);
                              echo $line2->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Highly
                                                            Interested</span>
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1  $whr and status=1 and ((inital_status=9 and followup1_status=0 ) OR (followup1_status=9 and followup2_status =0 )  OR (followup2_status=9 and  followup3_status =0 ) OR (followup3_status=9 and  last_followup_status =0 ))",$debug=-1);
                              $line3=$obj->fetchNextObject($sql);
                              echo $line3->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Partial
                                                            Interested</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(8)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr and status=1 and ((inital_status=3 and followup1_status=0 ) OR (followup1_status=3 and followup2_status =0 )  OR (followup2_status=3 and  followup3_status =0 ) OR (followup3_status=3 and  last_followup_status =0 ))",$debug=-1);
                              $line4=$obj->fetchNextObject($sql);
                              echo $line4->num_rows;
                              ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Interested</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(9)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr and status=1 and ((inital_status=4 and followup1_status=0 ) OR (followup1_status=4 and followup2_status =0 )  OR (followup2_status=4 and  followup3_status =0 ) OR (followup3_status=4 and  last_followup_status =0 ))",$debug=-1);
                              $line5=$obj->fetchNextObject($sql);
                              echo $line5->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not
                                                            Interested</span>
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr1 and status=1 and date(followup1_start_date) between '$fromdate' and  '$todate' and followup1_remarks!=0 and support_followup1_additional_remarks is null",$debug=-1);
                              $line11=$obj->fetchNextObject($sql);
                              echo $line11->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            1st Follow Up</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php                              
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr1 and status=1 and date(followup2_start_date) between '$fromdate' and  '$todate' and followup2_remarks!=0 and support_followup2_additional_remarks is null",$debug=-1);
                              $line12=$obj->fetchNextObject($sql);
                              echo $line12->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            2nd Follow Up</span>
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
                <?php } ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="ApplicationList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Applicant Name</th>
                                                        <th>Contact No.</th>
                                                        <th>State</th>
                                                        <th>District</th>
                                                        <th>Visa Type</th>
                                                        <th>Preferred Country</th>
                                                        <th>Branch</th>
                                                        <th>Telecaller</th>
                                                        <th>Source</th>
                                                        <th>Status</th>
                                                        <th>Remarks </th>
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
    <script src="js/select2.full.min.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "Select Branch",
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
            url: "followup-lead-ajax.php",
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


    $("#branch_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#crm_executive_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#state_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#city_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#visa_type").change(function() {
        $("#searchfrm").submit();
    })
    $("#source").change(function() {
        $("#searchfrm").submit();
    })
    $("#recent_qualification").change(function() {
        $("#searchfrm").submit();
    })

    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
</body>

</html>