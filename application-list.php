<?php 
ob_start();  
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['filling_executive_id']='';
$whr='';
$whr1='';

$whr = "and a.app_id!=''";
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id']==2 || $_SESSION['level_id']==25 || $_SESSION['level_id']==19 || in_array(2,$addtional_role)){
  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
  $whr .= " and b.branch_id in ($branch_id)";
}
if($_SESSION['level_id'] == 3){
  $account_manager_id = $_SESSION['sess_admin_id'];
  $whr .= " and b.am_id in ($account_manager_id)";
}
if($_SESSION['level_id'] == 4){
  $counsellor_id = $_SESSION['sess_admin_id'];
  $whr .= " and b.c_id in ($counsellor_id)";
}
if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and b.branch_id in ($branch_id)";
}
if($_REQUEST['state_id']){
  $state_id = $_REQUEST['state_id'];
  $whr .= " and a.location=$state_id";
}
if($_REQUEST['institute_id']){
  $institute_id = $_REQUEST['institute_id'];
  $whr .= " and a.college_name=$institute_id";
}
if($_REQUEST['counsellor_id']){
  $counsellor_id = $_REQUEST['counsellor_id'];
  $whr .= " and b.c_id in ($counsellor_id)";
}
if($_REQUEST['sraccount_manager_id']){
  $sraccount_manager_id = $_REQUEST['sraccount_manager_id'];
  $whr .= " and b.am_id=$sraccount_manager_id and b.sam_assign=1";
}
if($_REQUEST['account_manager_id']){
  $account_manager_id = $_REQUEST['account_manager_id'];
  $whr .= " and b.am_id in ($account_manager_id)";
}
if($_REQUEST['filling_manager_id']){
  $filling_manager_id = $_REQUEST['filling_manager_id'];
  $whr .= " and b.fm_id=$filling_manager_id and b.fm_assign=1";
}
if($_REQUEST['filling_executive_id']){
  $filling_executive_id = $_REQUEST['filling_executive_id'];
  $_SESSION['filling_executive_id'] = $filling_executive_id;
}

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
}

if($_REQUEST['portal_status']){
  $portal_status = $_REQUEST['portal_status'];
  $whr .= " and a.portal_status='$portal_status'";
}
if($_REQUEST['month']){
  $month = $_REQUEST['month'];
  $whr .= " and a.month='$month'";
}
if($_REQUEST['year']){
  $year = $_REQUEST['year'];
  $whr .= " and a.year=$year";
}

if($_REQUEST['status']){
  $status = $_REQUEST['status'];
  if($status!='Total Application'){
    $whr1 .= " and a.status='$status'";
  }
  
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

.canvasjs-chart-credit {
    display: none !important;
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
                        <h5 class="txt-dark">Manage USA Application
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$_REQUEST['status']."</span>"; } ?>
                        </h5>
                    </div>

                    <?php  if ($_SESSION['level_id']==1 || in_array(8,$addtional_role)){?>
                    <form class="form-horizontal form_csv_download_student"
                        action="download_csv.php?table_name=tbl_application&amp;p=application-list" method="post"
                        name="upload_excel" enctype="multipart/form-data" style="">
                        <div class="row">
                            <div class="col-md-4 col-6">
                                <input type="submit" name="applicationList" class="btn btn-primary download_csv_button"
                                    value="Download CSV" style="background: yellow; color: #000">
                            </div>
                        </div>
                    </form>
                    <?php }?>
                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>


                <form method="post" name="searchfrm" id="searchfrm" action="application-list.php">
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
                                    <?php
                  if($_SESSION['level_id']!=3 && $_SESSION['level_id']!=4){
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
                              $whrr .=" and ( FIND_IN_SET($val, b.branch_id)";
                            }else{
                              $whrr .=" or FIND_IN_SET($val, b.branch_id)";
                            }
                            if($i==count($idArr)){
                              $whrr .=" )";
                            }
                            $i++;
                          }
                          
                          $amSql = $obj->query("select c.id,c.name from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id inner join $tbl_admin as c on c.id=b.am_id where 1=1 and b.sam_assign=1 and c.level_id='2' $whrr group by c.id");

                          while($amResult = $obj->fetchNextObject($amSql)){?>
                                                <option value="<?php echo $amResult->id; ?>"
                                                    <?php if($_REQUEST['sraccount_manager_id']==$amResult->id){?>
                                                    selected <?php } ?>><?php echo $amResult->name; ?></option>
                                                <?php }
                        }
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
                              $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                            }else{
                              $whrr .=" or FIND_IN_SET($val, branch_id)";
                            }
                            if($i==count($idArr)){
                              $whrr .=" )";
                            }
                            $i++;
                          }

                          $amSql = $obj->query("select * from $tbl_admin where status=1 and level_id=3 $whrr",-1);
                          while($amResult = $obj->fetchNextObject($amSql)){?>
                                                <option value="<?php echo $amResult->id; ?>"
                                                    <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected
                                                    <?php } ?>><?php echo $amResult->name; ?></option>
                                                <?php }
                        }
                        ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                  if($_SESSION['level_id']!=2){
                  ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="filling_manager_id" id="filling_manager_id"
                                                class="form-control">
                                                <option value="">Filling Manager</option>
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
                          
                          $amSql = $obj->query("select c.id,c.name from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id inner join $tbl_admin as c on c.id=b.fm_id where 1=1 and c.status=1 and c.level_id=7 and b.fm_assign=1 $whrr group by c.id");

                          while($amResult = $obj->fetchNextObject($amSql)){?>
                                                <option value="<?php echo $amResult->id; ?>"
                                                    <?php if($_REQUEST['filling_manager_id']==$amResult->id){?> selected
                                                    <?php } ?>><?php echo $amResult->name; ?></option>
                                                <?php }
                        }
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
                          $feSql = $obj->query("select * from $tbl_admin where status=1 and level_id=8 $whrr",-1);
                          while($feResult = $obj->fetchNextObject($feSql)){?>
                                                <option value="<?php echo $feResult->id; ?>"
                                                    <?php if($_REQUEST['filling_executive_id']==$feResult->id){?>
                                                    selected <?php } ?>><?php echo $feResult->name; ?></option>
                                                <?php }
                        }
                        ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } } ?>
                                    <?php
                  if($_SESSION['level_id']!=4){
                  ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="counsellor_id" id="counsellor_id" class="form-control">
                                                <option value="">Counsellor</option>
                                                <?php
                        if(!empty($_REQUEST['branch_id'])){                          
                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 order by name");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['counsellor_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                        }
                        ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php  } ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <?php
                        $sSql = $obj->query("select * from $tbl_state where status=1 order by state asc");
                        while($sResult = $obj->fetchNextObject($sSql)){?>
                                                <option value="<?php echo $sResult->id; ?>"
                                                    <?php if($_REQUEST['state_id']==$sResult->id){?> selected
                                                    <?php } ?>><?php echo $sResult->state; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="institute_id" id="institute_id" class="form-control">
                                                <option value="">Select Institute Name</option>
                                                <?php
                        if($_REQUEST['state_id']){
                          $iSql = $obj->query("select * from $tbl_univercity where status=1 and country_id=3 and state_id='".$_REQUEST['state_id']."' order by name asc");
                          while($iResult = $obj->fetchNextObject($iSql)){?>
                                                <option value="<?php echo $iResult->id; ?>"
                                                    <?php if($_REQUEST['institute_id']==$iResult->id){?> selected
                                                    <?php } ?>><?php echo $iResult->name; ?></option>
                                                <?php } 
                        } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="month" name="month">
                                                <option value="0">intake </option>
                                                <option value="January" <?php if($_REQUEST['month']=='January'){?>
                                                    selected <?php }?>>January</option>
                                                <option value="February" <?php if($_REQUEST['month']=='February'){?>
                                                    selected <?php }?>>February</option>
                                                <option value="March" <?php if($_REQUEST['month']=='March'){?> selected
                                                    <?php }?>>March</option>
                                                <option value="April" <?php if($_REQUEST['month']=='April'){?> selected
                                                    <?php }?>>April</option>
                                                <option value="May" <?php if($_REQUEST['month']=='May'){?> selected
                                                    <?php }?>>May</option>
                                                <option value="June" <?php if($_REQUEST['month']=='June'){?> selected
                                                    <?php }?>>June</option>
                                                <option value="July" <?php if($_REQUEST['month']=='July'){?> selected
                                                    <?php }?>>July</option>
                                                <option value="August" <?php if($_REQUEST['month']=='August'){?>
                                                    selected <?php }?>>August</option>
                                                <option value="September" <?php if($_REQUEST['month']=='September'){?>
                                                    selected <?php }?>>September</option>
                                                <option value="October" <?php if($_REQUEST['month']=='October'){?>
                                                    selected <?php }?>>October</option>
                                                <option value="November" <?php if($_REQUEST['month']=='November'){?>
                                                    selected <?php }?>>November </option>
                                                <option value="December" <?php if($_REQUEST['month']=='December'){?>
                                                    selected <?php }?>>December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="portal_status" id="portal_status">
                                                <option value="" selected="">Select Portal</option>
                                                <?php
                                                $con = ''; 
                                                // $con = ' and country_id='".$result->country_id."'';
                                            $ssql = $obj->query("select * from $tbl_portal_status where status=1 $con",-1);//die();
                                            while($sResult = $obj->fetchNextObject($ssql)){
                                              $portalArr = explode(",",$sResult->cstatus);
                                              foreach($portalArr as $vint){
                                                ?>
                                                <option value="<?php echo trim($vint); ?>" <?php if($_REQUEST['portal_status']==trim($vint)){?>
                                                  selected <?php }?>><?php echo trim($vint); ?>
                                                </option>
                                                <?php  }  }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="year" name="year">
                                                <option value="">Year</option>
                                                <?php
                      $firstYear = (int)date('Y')-10;
                      $lastYear = $firstYear+16;
                      for($i=$firstYear;$i<=$lastYear;$i++)
                        {?>
                                                <option value="<?php echo $i; ?>" <?php if($_REQUEST['year']==$i){?>
                                                    selected <?php }?>><?php echo $i; ?></option>';
                                                <?php }
                        ?>
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



                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)"
                                                        onclick="getAppRecord('Total Application')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Application</span>
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
                                                        onclick="getAppRecord('University Allotted')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='University Allotted' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">University
                                                            Allotted</span>
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
                                                        onclick="getAppRecord('Application Incomplete')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Application Incomplete' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Application
                                                            Incomplete</span>
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
                                                        onclick="getAppRecord('Intake Closed')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Intake Closed' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Intake
                                                            Closed</span>
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
                                                        onclick="getAppRecord('Application Submitted')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Application Submitted' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Application
                                                            Submitted</span>
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
                                                        onclick="getAppRecord('Offer Received')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Offer Received' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Offer
                                                            Received</span>
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
                                                    <a href="javascript:void(0)"
                                                        onclick="getAppRecord('Offer Rejected')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Offer Rejected' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Offer
                                                            Rejected</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Deposit Paid')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Deposit Paid' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Deposit
                                                            Paid</span>
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
                                                        onclick="getAppRecord('Funds Pending')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Funds Pending' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Funds
                                                            Pending</span>
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
                                                        onclick="getAppRecord('Financials Done')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Financials Done' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Financials
                                                            Done</span>
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
                                                        onclick="getAppRecord('Financials Rejected')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='Financials Rejected' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Financials
                                                            Rejected </span>
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
                                                        onclick="getAppRecord('I-20 Received')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='I-20 Received' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">I-20
                                                            Received</span>
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
                                                    <a href="javascript:void(0)"
                                                        onclick="getAppRecord('I-20 Deferred')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.status='I-20 Deferred' $whr",$debug=-1);
                              $line=$obj->fetchNextObject($sql);
                              echo $line->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">I-20
                                                            Deferred</span>
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
                        <?php
        if($_POST['status'] == 'See Report'){
          ?>
                        <button class="btn btn-success" onclick="getAppRecord('')">Table</button>
                        <?php }else { ?>
                        <button class="btn btn-success" onclick="getAppRecord('See Report')">Report</button>
                        <?php } ?>
                    </div>
                </div>
                <?php
        if($_POST['status'] == 'See Report'){
        ?>
                <div class="row">
                    <div id="chartContainer" style="height: 500px; width: 100%;"></div>
                    <div id="chartContainers" style="height: 500px; width: 100%; margin-top:50px"></div>
                </div>
                <?php }else { ?>
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
                                                        <th>App Id</th>
                                                        <th>Student Id</th>
                                                        <th>Student Name</th>
                                                        <th>Office Email</th>
                                                        <th>Institute Name</th>
                                                        <th>Location</th>
                                                        <th>Course</th>
                                                        <th>Intake</th>
                                                        <th>Portal</th>
                                                        <th>Year</th>
                                                        <th>Branch</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Account Manager</th>
                                                        <th>Filling Executive</th>
                                                        <th>Last Updated Status</th>
                                                        <th>Remarks</th>
                                                        <?php if($_SESSION['level_id']!=7 && $_SESSION['level_id']!=8){?>
                                                        <th>Action</th>
                                                        <?php }?>
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
                <?php } ?>
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
        "stateSave": true,
        "lengthMenu": [
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
            }
        ],
        "ajax": {
            url: "application-list-ajax.php",
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
    $("#state_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#institute_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#counsellor_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#sraccount_manager_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#account_manager_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#portal_status").change(function() {
        $("#searchfrm").submit();
    })
    $("#filling_manager_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#filling_executive_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#month").change(function() {
        $("#searchfrm").submit();
    })
    $("#year").change(function() {
        $("#searchfrm").submit();
    })

    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
    <script src="js/change-status.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Branch Wise Application Data"
            },
            axisY: {
                title: "Application Counts",
                titleFontColor: "#2a3e4c",
                lineColor: "#2a3e4c",
                labelFontColor: "#2a3e4c",
                tickColor: "#2a3e4c"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [{
                    type: "column",
                    name: "Total Applications",
                    legendText: "Total Applications",
                    showInLegend: true,
                    dataPoints: [
                        <?php
				$sql=$obj->query("select COUNT(a.id) as num_rows,b.branch_id from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and b.branch_id!='' $whr group by b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                },
                {
                    type: "column",
                    name: "Offer Received",
                    legendText: "Offer Received",
                    showInLegend: true,
                    dataPoints: [
                        <?php
				$sql1=$obj->query("SELECT COUNT(a.id) AS num_rows, b.branch_id FROM $tbl_student_application AS a LEFT JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON a.stu_id=c.student_id WHERE 1=1 AND b.branch_id!='' AND a.status='Offer Received' $whr GROUP BY b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql1)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                },
                {
                    type: "column",
                    name: "i20 Received",
                    legendText: "i20 Received",
                    showInLegend: true,
                    dataPoints: [
                        <?php
			$sql2=	$obj->query("SELECT COUNT(a.id) AS num_rows, b.branch_id FROM $tbl_student_application AS a LEFT JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON a.stu_id=c.student_id WHERE 1=1 AND b.branch_id!='' AND a.status='I-20 Received' $whr GROUP BY b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql2)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                }
            ]
        });
        chart.render();

        function toggleDataSeries(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }



        var chart = new CanvasJS.Chart("chartContainers", {
            animationEnabled: true,
            title: {
                text: "Student Wise Application Data"
            },
            axisY: {
                title: "Students Counts",
                titleFontColor: "#2a3e4c",
                lineColor: "#2a3e4c",
                labelFontColor: "#2a3e4c",
                tickColor: "#2a3e4c"
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeriess
            },
            data: [{
                    type: "column",
                    name: "Total Students",
                    legendText: "Total Students",
                    showInLegend: true,
                    color: "#009299",
                    dataPoints: [
                        <?php
      $whrs = str_replace("and a.app_id!=''", '',$whr);
				$sql=$obj->query("SELECT count(*) as num_rows, b.branch_id FROM $tbl_student as b where 1=1 $whrs GROUP by b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                },
                {
                    type: "column",
                    name: "Offer Received",
                    legendText: "Offer Received",
                    showInLegend: true,
                    dataPoints: [
                        <?php
				$sql1=$obj->query("SELECT COUNT(a.id) AS num_rows, b.branch_id FROM $tbl_student_application AS a LEFT JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON a.stu_id=c.student_id WHERE 1=1 AND b.branch_id!='' AND a.status='Offer Received' $whr GROUP BY b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql1)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                },
                {
                    type: "column",
                    name: "i20 Received",
                    legendText: "i20 Received",
                    showInLegend: true,
                    dataPoints: [
                        <?php
			$sql2=	$obj->query("SELECT COUNT(a.id) AS num_rows, b.branch_id FROM $tbl_student_application AS a LEFT JOIN $tbl_student AS b ON a.stu_id=b.id LEFT JOIN $tbl_filing_credentials AS c ON a.stu_id=c.student_id WHERE 1=1 AND b.branch_id!='' AND a.status='I-20 Received' $whr GROUP BY b.branch_id",$debug=-1);
				while($line=$obj->fetchNextObject($sql2)){
			?> {
                            label: "<?=getField('name',$tbl_branch,$line->branch_id)?>",
                            y: <?=$line->num_rows?>
                        },
                        <?php } ?>
                    ]
                }
            ]
        });
        chart.render();

        function toggleDataSeriess(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }

    }
    </script>

</body>

</html>