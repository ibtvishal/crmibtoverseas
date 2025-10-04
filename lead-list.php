<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['whr3']='';
$_SESSION['whr4']='';
$_SESSION['status']=1;
$todate = date('Y-m-d');
$mtodate = date('Y-m-d' , strtotime(' -1 Days'));
if(isset($_GET['transfer'])){
    $_SESSION['transfer_lead']=1;
}else{
    $_SESSION['transfer_lead']=0;
}
$whr=''; 
$whr1='';
$whr3='';
$whr4='';
$whr2= " and status=1";
// $whr2=" and (NOT EXISTS ( SELECT b.applicant_contact_no,b.applicant_alternate_no FROM $tbl_visit as b  WHERE ($tbl_lead.applicant_contact_no=b.applicant_contact_no or $tbl_lead.applicant_alternate_no=b.applicant_alternate_no or $tbl_lead.applicant_contact_no=b.applicant_alternate_no or $tbl_lead.applicant_alternate_no=b.applicant_contact_no )) or NOT EXISTS ( SELECT b.student_contact_no,b.alternate_contact FROM $tbl_student as b  WHERE ($tbl_lead.applicant_contact_no=b.student_contact_no or $tbl_lead.applicant_alternate_no=b.alternate_contact or $tbl_lead.applicant_contact_no=b.alternate_contact or $tbl_lead.applicant_alternate_no=b.student_contact_no )))";
// $whr2=" and NOT EXISTS (
//       SELECT 1
//       FROM $tbl_visit b
//       WHERE ($tbl_lead.applicant_contact_no=b.applicant_contact_no
//        or $tbl_lead.applicant_alternate_no=b.applicant_alternate_no
//         or $tbl_lead.applicant_contact_no=b.applicant_alternate_no 
//         or $tbl_lead.applicant_alternate_no=b.applicant_contact_no )
//   ) and NOT EXISTS (
//       SELECT 1
//       FROM $tbl_student c
//       WHERE ($tbl_lead.applicant_contact_no=c.student_contact_no
//        or $tbl_lead.applicant_alternate_no=c.alternate_contact
//         or $tbl_lead.applicant_contact_no=c.alternate_contact 
//         or $tbl_lead.applicant_alternate_no=c.student_contact_no )
//   )";
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id']==1 || $_SESSION['level_id']==25 || $_SESSION['level_id']==19 || in_array(4,$addtional_role)){
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and crm_executive_id in ($crm_executive_id)";

    $whr1 .= " and a.crm_executive_id in ($crm_executive_id)";
    $whr3 .= " and a.crm_executive_id in ($crm_executive_id)";
  }
  if($_SESSION['level_id']==19 || $_SESSION['level_id']==25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
    $whr3 .= " and a.branch_id in ($branchid)";
  }
}else{
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and (crm_executive_id in ($crm_executive_id) or crm_executive_id ='".$_SESSION['sess_admin_id']."')";
    $whr1 .= " and (a.crm_executive_id in ($crm_executive_id) or a.crm_executive_id ='".$_SESSION['sess_admin_id']."')";
    $whr3 .= " and (a.crm_executive_id in ($crm_executive_id) or a.crm_executive_id ='".$_SESSION['sess_admin_id']."')";
  }else{
  $whr .= " and crm_executive_id ='".$_SESSION['sess_admin_id']."'";
  $whr4 .= " and crm_executive_id = '".$_SESSION['sess_admin_id']."'";
  $whr1 .= " and a.crm_executive_id  ='".$_SESSION['sess_admin_id']."'";
  $whr3 .= " and a.crm_executive_id  ='".$_SESSION['sess_admin_id']."'";
  }
}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  if(is_array($branchArr)){
    $branch_id = implode(',',$branchArr);
  }else{
        $branch_id = $_REQUEST['branch_id'];
    }
  $whr .= " and branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
  $whr3 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['state_id']){
  $state_id = $_REQUEST['state_id'];
  $whr .= " and state_id=$state_id";
  $whr1 .= " and a.state_id=$state_id";
  $whr3 .= " and a.state_id=$state_id";
}
if($_REQUEST['city_id']){
  $city_id = $_REQUEST['city_id'];
  $whr .= " and city_id=$city_id";
  $whr1 .= " and a.city_id=$city_id";
  $whr3 .= " and a.city_id=$city_id";
}
if($_REQUEST['pre_country_id']){
  $pre_country_id = $_REQUEST['pre_country_id'];
  $whr .= " and pre_country_id=$pre_country_id";
  $whr1 .= " and a.pre_country_id=$pre_country_id";
  $whr3 .= " and a.pre_country_id=$pre_country_id";
}

if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  $whr .= " and FIND_IN_SET('$visa_type',visa_type)";
  $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
  $whr3 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
}
if($_REQUEST['source']){
  $source = $_REQUEST['source'];
  $whr .= " and source = '$source'";
  $whr1 .= " and a.source = '$source'";
  $whr3 .= " and a.source = '$source'";
}
if($_REQUEST['lead_type']){
  $lead_type = $_REQUEST['lead_type'];
  $whr .= " and lead_type = '$lead_type'";
  $whr1 .= " and a.lead_type = '$lead_type'";
  $whr3 .= " and a.lead_type = '$lead_type'";
}
if($_REQUEST['recent_qualification']){
  $recent_qualification = $_REQUEST['recent_qualification'];
  $whr .= " and recent_qualification = '$recent_qualification'";
  $whr1 .= " and a.recent_qualification = '$recent_qualification'";
  $whr3 .= " and a.recent_qualification = '$recent_qualification'";
}

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
  $whr1 .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
  $whr3 .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
}


if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    
    if($status==1){
      $_SESSION['status']=1;
      $stauscontent='Total Visits';
    }else if($status==2){
      $_SESSION['status']=2;
      $stauscontent='Intersted';
   
    }
    else if($status==3){
      $_SESSION['status']=3;
      $stauscontent='Not Intersted';
      
    }
    else if($status==4){
      $_SESSION['status']=4;
      $stauscontent='Visited';
      
    }
    else if($status==5){
      $_SESSION['status']=5;
      $stauscontent='Not Visited';
      
    }
    else if($status==6){
      $stauscontent='Enrolled';
      $_SESSION['status']=6;
    }else if($status==7){
      $_SESSION['status']=7;
      $stauscontent='Pending Daily Follow Ups';
   
    }else if($status==8){
      $_SESSION['status']=8;
      $stauscontent='Pending 1st Follow Up';
    
    }else if($status==9){
      $_SESSION['status']=9;
      $stauscontent='Pending 2nd Follow Up';
    }else if($status==10){
      $_SESSION['status']=10;
      $stauscontent='Pending 3rd Follow Up';
    }else if($status==11){
      $_SESSION['status']=11;
      $stauscontent='Pending Last Follow Up';
    }else if($status==12){
      $_SESSION['status']=12;
      $stauscontent='Highly Interested';
    }
  
  else if($status==13){
    $_SESSION['status']=13;
    $stauscontent='Partial Interested';
  }
  else if($status==14){
    $_SESSION['status']=14;
    $stauscontent='Partial Interested'; 
  }
  elseif($status==15){
    $_SESSION['status']=15;
    $stauscontent='Total Visited'; 
  }
  elseif($status==16){
    $_SESSION['status']=16;
    $stauscontent='Today Outbound Calls'; 
  }
  elseif($status==17){
    $_SESSION['status']=17;
    $stauscontent='Today Outbound Calls'; 
  }
  else{
    $_SESSION['status']=1;
    $stauscontent='';
  }
  
}

$_SESSION['whr'] = $whr;
$_SESSION['whr1'] = $whr1;
$_SESSION['whr2'] = $whr2;
$_SESSION['whr3'] = $whr3;
$_SESSION['whr4'] = $whr4;

if(isset($_POST['lead_transfer']) && $_POST['lead_transfer'] == 'yes' && isset($_POST['leadIdarr']) && count($_POST['leadIdarr']) > 0){
    foreach($_POST['leadIdarr'] as $res){
        $obj->query("update $tbl_lead set crm_executive_id='".$_POST['to_crm_executive_id']."' where id='$res'",-1);
    }
    header("location:lead-list.php?transfer");
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
                        <h5 class="txt-dark">Manage Leads
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <?php
                if(!isset($_GET['transfer'])){
                ?>
                <form method="post" name="searchfrm" id="searchfrm" action="lead-list.php">
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
                                                    if(is_array($branchArr)){
                                                        $branchArr = $branchArr;
                                                        }else{
                                                            $branchArr = array($branchArr);
                                                        }
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
                                            <select class="required form-control" name="pre_country_id"
                                                id="pre_country_id" onchange="change_country(this.value)">
                                                <option value="">Select Preferred
                                                    <?=$_REQUEST['pre_country_id'] == 7 ? 'Area' : 'Country'?></option>
                                                <?php
                                            $ctsql=$obj->query("select * from $tbl_country where status=1 order by displayorder",-1);
                                            while($ctresult=$obj->fetchNextObject($csql)){?>
                                                <option value="<?php echo $ctresult->id ?>"
                                                    <?php if($ctresult->id==$_REQUEST['pre_country_id']){?>selected<?php } ?>>
                                                    <?php echo $ctresult->name; ?></option>
                                                <?php } ?>
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
                                            <select name="recent_qualification" id="recent_qualification"
                                                class="form-control">
                                                <option value="">Select Qualification</option>
                                                <option value="1" <?php if($_REQUEST['recent_qualification']==1){?>
                                                    selected <?php } ?>>Matriculation</option>
                                                <option value="2" <?php if($_REQUEST['recent_qualification']==2){?>
                                                    selected <?php } ?>>Senior Secondary</option>
                                                <option value="3" <?php if($_REQUEST['recent_qualification']==3){?>
                                                    selected <?php } ?>>Any Diploma</option>
                                                <option value="4" <?php if($_REQUEST['recent_qualification']==4){?>
                                                    selected <?php } ?>>Bachelor</option>
                                                <option value="5" <?php if($_REQUEST['recent_qualification']==5){?>
                                                    selected <?php } ?>>Masters</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="lead_type" id="lead_type" class="form-control">
                                                <option value="">Select Lead Type</option>
                                                <option value="Call" <?php if($_REQUEST['lead_type']=='Call'){?>
                                                    selected <?php } ?>>Call</option>
                                                <option value="Chat" <?php if($_REQUEST['lead_type']=='Chat'){?>
                                                    selected <?php } ?>>Chat</option>
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
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr",$debug=-1);
                              $line1=$obj->fetchNextObject($sql);
                              echo $totallead = $line1->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Leads</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(12)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2 $whr and ((inital_status=8 and followup1_status=0 ) OR (followup1_status=8 and followup2_status =0 )  OR (followup2_status=8 and  followup3_status =0 ) OR (followup3_status=8 and  last_followup_status =0 ))",$debug=-1);
                              $line2=$obj->fetchNextObject($sql);
                              echo $line2->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Highly
                                                            Interested</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(13)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2  $whr and ((inital_status=9 and followup1_status=0 ) OR (followup1_status=9 and followup2_status =0 )  OR (followup2_status=9 and  followup3_status =0 ) OR (followup3_status=9 and  last_followup_status =0 ))",$debug=-1);
                              $line3=$obj->fetchNextObject($sql);
                              echo $line3->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Partial
                                                            Interested</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2 $whr and ((inital_status=3 and followup1_status=0 ) OR (followup1_status=3 and followup2_status =0 )  OR (followup2_status=3 and  followup3_status =0 ) OR (followup3_status=3 and  last_followup_status =0 ))",$debug=-1);
                              $line4=$obj->fetchNextObject($sql);
                              echo $line4->num_rows;
                              ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Interested</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2 $whr and ((inital_status=4 and followup1_status=0 ) OR (followup1_status=4 and followup2_status =0 )  OR (followup2_status=4 and  followup3_status =0 ) OR (followup3_status=4 and  last_followup_status =0 ))",$debug=-1);
                              $line5=$obj->fetchNextObject($sql);
                              echo $line5->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not
                                                            Interested</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(17)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr2 $whr and ((inital_status=12 and followup1_status=0 ) OR (followup1_status=12 and followup2_status =0 )  OR (followup2_status=12 and  followup3_status =0 ) OR (followup3_status=12 and  last_followup_status =0 ))",$debug=-1);
                              $line5=$obj->fetchNextObject($sql);
                              echo $line5->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Unable To
                                                            Connect</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php          
                              $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr2 
                              and ((date(inital_next_followup_date) = '$todate' and followup1_remarks =0  and inital_remarks !=0  and inital_status not in (4,10,11) ) 
                                OR (date(followup1_next_followup_date) = '$todate' and followup2_remarks =0  and followup1_remarks !=0 and followup1_status not in (4,10,11) ) 
                                OR (date(followup2_next_followup_date) = '$todate' and  followup3_remarks =0  and followup2_remarks !=0   and followup2_status not in (4,10,11) ) 
                                OR (date(followup3_next_followup_date) = '$todate' and  last_followup_remarks=0  and followup3_remarks !=0   and followup3_status not in (4,10,11) ))",$debug=-1);
                              $line9=$obj->fetchNextObject($sql);
                              echo $line9->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            Daily Follow Ups</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(8)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr2 and status=1 and date(inital_next_followup_date) < '$mtodate' and inital_remarks !=0 and followup1_status=0  and inital_status not in (4,10,11)",$debug=-1);
                              $line10=$obj->fetchNextObject($sql);
                              echo $line10->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            1st Follow Up</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(9)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr2 and status=1 and date(followup1_next_followup_date) < '$mtodate' and followup1_remarks !=0 and followup2_status=0  and followup1_status not in (4,10,11) ",$debug=-1);
                              $line11=$obj->fetchNextObject($sql);
                              echo $line11->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            2nd Follow Up</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(10)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php                              
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr2 and status=1 and date(followup2_next_followup_date) < '$mtodate' and followup2_remarks !=0 and followup3_status=0  and followup2_status not in (4,10,11) ",$debug=-1);
                              $line12=$obj->fetchNextObject($sql);
                              echo $line12->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            3rd Follow Up</span>
                                                    </a>
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
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(11)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr2 and status=1 and date(followup3_next_followup_date) < '$mtodate' and followup3_remarks !=0 and last_followup_status=0  and followup3_status not in (4,10,11) ",$debug=-1);
                                                                    $line13=$obj->fetchNextObject($sql);
                                                                    echo $line13->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            Last Follow Up</span>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($_SESSION['level_id'] == 9){
                    ?>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord(16)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                               $obj->query("select COUNT(id) as num_rows from $tbl_lead where 1=1 $whr $whr4 and ((date(followup1_start_date) = '$todate' and followup1_status!=0) or (date(followup2_start_date) = '$todate' and followup2_status!=0) or (date(followup3_start_date) = '$todate' and followup3_status!=0) or (date(last_followup_start_date) = '$todate' and last_followup_status!=0))",$debug=-1);
                              $line13=$obj->fetchNextObject($sql);
                              echo $line13->num_rows;
                              ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Today
                                                            Outbound
                                                            Calls</span>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <button type="button" onclick="show_counter()" class="btn btn-primary download_csv_button"
                        style="width: 200px; height: 40px;float: right;margin-bottom: 15px;">Show Enrollment
                        Counters</button>
                </div>
                <div id="get_counter_data"></div>
                <?php } ?>

                <?php
                if(isset($_GET['transfer'])){
                    ?>
                <form action="lead-list.php?transfer" method="post" id="searchfrms">
                    <input type="hidden" name="lead_transfer" value="yes">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            Select Branch
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
                                            From CRM Executives
                                            <select name="crm_executive_id" id="crm_executive_id" class="form-control">
                                                <option value="">From CRM Executive</option>
                                                <?php
                                                    $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                                    while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['crm_executive_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            To CRM Executives
                                            <select name="to_crm_executive_id" class="form-control">
                                                <option value="">To CRM Executive</option>
                                                <?php
                                                    $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                                    while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>">
                                                    <?php echo $clResult->name; ?></option>
                                                <?php }
                                                 ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" name="subit"
                                                class="btn btn-primary download_csv_button"
                                                style="width: 170px; height: 40px;margin-top: 20px;">Transfer</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <div class="row">
                                                    <div class="col-md-12">Color Core: <span style="color:red">Pending
                                                            Daily
                                                            Followups</span>, <span style="color:green">Visited</span>,
                                                        <span style="color:white;background:green">Enrolled</span>
                                                    </div>
                                                </div>
                                                <table id="ApplicationList" class="table table-hover display pb-30">
                                                    <div class="choose_prog" style="">
                                                    </div>
                                                    <thead>
                                                        <tr>
                                                            <?php
                                                        if(isset($_GET['transfer'])){
                                                            echo "<th>Transfer</th>";
                                                        }
                                                            ?>
                                                            <th>ID</th>
                                                            <th>Date</th>
                                                            <th>Applicant Name</th>
                                                            <th>Father Name</th>
                                                            <th>Contact No.</th>
                                                            <!-- <th>State</th> -->
                                                            <th>District</th>
                                                            <!-- <th>Visa Type</th> -->
                                                            <th>Preferred Country</th>
                                                            <th>Branch</th>
                                                            <th>Telecaller</th>
                                                            <!-- <th>Source</th> -->
                                                            <th>Status</th>
                                                            <th>System Status</th>
                                                            <th>Remarks </th>
                                                            <th>Action</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9){
                                                            ?>
                                                            <th>Book Appointment</th>
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
                    <?php
                if(isset($_GET['transfer'])){
                    ?>
                </form>
                <?php
                }
                ?>
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
    <div class="modal fade" id="management_meet" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Select Appointment Date & Time</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off">
                    <input type="hidden" name="appid_pass" id="appid_pass">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="lead_id" id="lead_id" class="form-control">
                            <input type="hidden" name="back_url" id="back_url" value="lead-list.php"
                                class="form-control">
                            <input type="datetime-local" name="management_datetime" id="management_datetime"
                                class="form-control" placeholder="Date & Time">
                            <span id="err_university_id_pass" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name='submit_appointment_booking' class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branches",
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
            url: "lead-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData[10] == "Enrolled") {
                $('td', nRow).css('background-color', 'green').css('color', 'white !important');
            } else {
                $('td', nRow).css('background-color', '');
            }

        }
        <?php
        if($_SESSION['level_id'] == 1){
        ?>,
        "dom": '<"top"lfB>rt<"bottom"ip><"clear">',
        "buttons": [{
            extend: 'csvHtml5',
            text: 'Download CSV',
            title: 'Lead List',
            exportOptions: {
                columns: ':not(:last-child)' // Exclude last three columns
            }
        }]
        <?php } ?>
    })


    $("#branch_id").change(function() {
        $("#searchfrm").submit();
        $("#searchfrms").submit();
    })
    $("#crm_executive_id").change(function() {
        $("#searchfrms").submit();
        $("#searchfrm").submit();
    })
    $("#counsellor_id").change(function() {
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
    $("#pre_country_id").change(function() {
        $("#searchfrm").submit();
    })

    $("#lead_type").change(function() {
        $("#searchfrm").submit();
    })




    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function show_counter() {
        $("#get_counter_data").html(`
            <div style="text-align:center">
                <h4>Loading Counters...</h4>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
        $.ajax({
            method: "post",
            url: "ajax/lead-counter.php",
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
    function managent_meet(id) {
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                managent_meet: id
            },
            success: function(data) {
                $("#management_meet").modal('show');
                $("#lead_id").val(id);
                $("#management_datetime").val(data);
            }
        })
    }
    </script>
    <script>
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
    function change_country(val) {
        if (val == 7) {
            $("#pre_country_id option:first").text("Preferred Area");
        } else {
            $("#pre_country_id option:first").text("Preferred Country");
        }
    }
    </script>
</body>

</html>