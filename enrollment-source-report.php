<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['status']=1;
$todate = date('Y-m-d');
$mtodate = date('Y-m-d' , strtotime(' -7 Days'));


$whr=' and status=0';
$whr1='';
$whr2=" and $tbl_visit.status=1";
$con='';
$con1='';
$todate = date('Y-m-d');
$mtodate = date('Y-m-d' , strtotime(' -7 Days'));
$branchid = '';
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id'] == '1' || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 19 || in_array(6,$addtional_role) || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role) || in_array(4,$addtional_role)){
  if($_SESSION['level_id'] == 11 || in_array(1,$addtional_role) || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 9 || in_array(6,$addtional_role)  || in_array(4,$addtional_role)){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and $tbl_visit.branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
    $branchids = explode(',',$branchid);
    if(count($branchids) == 1){
        $branchid = $branchids;
    }
  }
}else{
  $councellor_id = $_SESSION['sess_admin_id'];
  $whr .= " and FIND_IN_SET('$councellor_id', $tbl_visit.councellor_id) > 0";
  $whr1 .= " and FIND_IN_SET('$councellor_id', a.councellor_id) > 0";
}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and $tbl_visit.branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and $tbl_visit.pre_country_id=$country_id";
  $whr1 .= " and a.pre_country_id=$country_id";
}

if($_REQUEST['councellor_id']){
  $councellor_id = $_REQUEST['councellor_id'];
  $whr .= " and FIND_IN_SET('$councellor_id', $tbl_visit.councellor_id) > 0";
  $whr1 .= " and FIND_IN_SET('$councellor_id', a.councellor_id) > 0";
}



if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  $whr .= " and FIND_IN_SET('$visa_type',$tbl_visit.visa_type)";
  $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
}
if($_REQUEST['visa_source']){
  $visa_source = $_REQUEST['visa_source'];
  $whr .= " and $tbl_visit.source='$visa_source'";
  $whr1 .= " and a.source='$visa_source'";
}
if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date($tbl_visit.cdate) >= '$filter_start_date' and date($tbl_visit.cdate) <= '$filter_end_date'";
  $whr1 .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
}

$_SESSION['whr'] = $whr;
$_SESSION['whr1'] = $whr1;

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
    right: 0;
    margin-top: -8px;
    position: absolute;
    top: 0px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}

.material-switch>input[type="checkbox"]:checked+label::before {
    background: inherit;
    opacity: 0.5;
    left: 0;
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
.counter{
    font-size: 15px !important;
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
                        <h5 class="txt-dark">Manage Enrollment Source Report
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form method="post" name="searchfrm" id="searchfrm" action="visit-source-report.php">
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
                                            <select class="form-control" id="visa_type" name="visa_type">
                                                <option value="">Visa Type</option>
                                                <option value="Study" <?php if($_REQUEST['visa_type']=='Study'){?>
                                                    selected <?php }?>>Study</option>
                                                <option value="Visitior/tourist"
                                                    <?php if($_REQUEST['visa_type']=='Visitior/tourist'){?> selected
                                                    <?php }?>>Visitior/tourist</option>
                                                <option value="Spouse" <?php if($_REQUEST['visa_type']=='Spouse'){?>
                                                    selected <?php }?>>Spouse</option>
                                                <option value="Work" <?php if($_REQUEST['visa_type']=='Work'){?>
                                                    selected <?php }?>>Work</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_start_date" id="filter_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                                placeholder="Visit Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_end_date" id="filter_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                                placeholder="Visit End Date" onfocus="(this.type='date')"
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
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $totallead = $line1->num_rows;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Youtube' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Youtube Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Facebook' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Facebook Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Instagram' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Instagram Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Goggle' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Goggle Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Hoarding/Banner' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Hoarding/Banner Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Friends' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Friends Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Paper Ad' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Paper Ad Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Seminar' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Seminar Visits</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span >
                                                                <?php
                                                                $obj->query("select COUNT(id) as num_rows from $tbl_visit where 1=1 and source='Other' $whr",$debug=-1);
                                                                $line1=$obj->fetchNextObject($sql);
                                                                echo $yt_lead = $line1->num_rows; 
                                                                $pr = $yt_lead > 0 ?   ($yt_lead / $totallead)*100 : '';
                                                                echo $yt_lead > 0 ?  '<br>('.number_format($pr,2).'%)' : ''
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Other Visits</span>
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
    <script src="js/change-status.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branches",
        allowClear: true
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


    </script>
</body>

</html>