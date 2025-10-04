<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['whr_new']='';
$_SESSION['whr_new1']='';
$_SESSION['con']='';
$_SESSION['con1']='';
$_SESSION['status']=1;

if(isset($_GET['filter_end_date'])){
$whr=" and $tbl_visit.enquiry_type!='Re-apply'";
$whr1=" and a.enquiry_type!='Re-apply'";
$whr_new='';
$whr_new1='';
$whr2=" and $tbl_visit.enquiry_type!='Re-apply' and $tbl_visit.status=1";
}else{
    $whr='';
    $whr1='';
    $whr_new='';
    $whr_new1='';
    $whr2=" and $tbl_visit.status=1";
}
$con='';
$con1='';
$todate = date('Y-m-d');
$mtodate = date('Y-m-d' , strtotime(' -1 Days'));
$branchid = '';

$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";

$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id'] == '1' || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19 || in_array(6,$addtional_role) || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role) || in_array(4,$addtional_role)){
  if($_SESSION['level_id'] == 11 || in_array(1,$addtional_role) || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 9 || in_array(6,$addtional_role)  || in_array(4,$addtional_role)){
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
  if(is_array($branchArr)){
  $branch_id = implode(',',$branchArr);
}else{
      $branch_id = $_REQUEST['branch_id'];
  }
  $whr .= " and $tbl_visit.branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and $tbl_visit.pre_country_id=$country_id";
  $whr1 .= " and a.pre_country_id=$country_id";
}
if($_REQUEST['pre_state_id']){
  $pre_state_id = $_REQUEST['pre_state_id'];
  $whr .= " and $tbl_visit.pre_state_id=$pre_state_id";
  $whr1 .= " and a.pre_state_id=$pre_state_id";
}

if($_REQUEST['councellor_id']){
  $councellor_id = $_REQUEST['councellor_id'];
  $whr .= " and FIND_IN_SET('$councellor_id', $tbl_visit.councellor_id) > 0";
  $whr1 .= " and FIND_IN_SET('$councellor_id', a.councellor_id) > 0";
}

if($_REQUEST['telecaller_id']){
  $telecaller_id = $_REQUEST['telecaller_id'];

//   $con .= " inner join $tbl_lead as d on $tbl_visit.applicant_contact_no=d.applicant_contact_no or $tbl_visit.applicant_alternate_no = d.applicant_alternate_no or $tbl_visit.applicant_contact_no=d.applicant_alternate_no or $tbl_visit.applicant_alternate_no = d.applicant_contact_no";
//   $con1 .= " inner join $tbl_lead as d on a.applicant_contact_no=d.applicant_contact_no or a.applicant_alternate_no = d.applicant_alternate_no or a.applicant_contact_no=d.applicant_alternate_no or a.applicant_alternate_no = d.applicant_contact_no";

//   $whr .= " and ($tbl_visit.telecaller_id in ($telecaller_id) or d.crm_executive_id in ($telecaller_id))";
//   $whr1 .= " and (a.telecaller_id in ($telecaller_id) or d.crm_executive_id in ($telecaller_id))";
  $whr .= " and ($tbl_visit.telecaller_id in ($telecaller_id))";
  $whr1 .= " and (a.telecaller_id in ($telecaller_id))";
}

if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  if($visa_type == 'Visitior/tourist'){
      $whr .= " and (FIND_IN_SET('Visitor',$tbl_visit.visa_type) OR FIND_IN_SET('Visitior/tourist',$tbl_visit.visa_type) OR FIND_IN_SET('Tourist',$tbl_visit.visa_type))";
      $whr1 .= " and (FIND_IN_SET('Visitor',a.visa_type) OR FIND_IN_SET('Visitior/tourist',a.visa_type) OR FIND_IN_SET('Tourist',a.visa_type))";
  }else{
      $whr .= " and FIND_IN_SET('$visa_type',$tbl_visit.visa_type)";
      $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
  }
}
if($_REQUEST['visa_source']){
  $visa_source = $_REQUEST['visa_source'];
  $whr .= " and $tbl_visit.source='$visa_source'";
  $whr1 .= " and a.source='$visa_source'";
}
if($_REQUEST['state_id']){
    $state_id = $_REQUEST['state_id'];
    $whr .= " and $tbl_visit.state_id=$state_id";
    $whr1 .= " and a.state_id=$state_id";
  }
  if($_REQUEST['city_id']){
    $city_id = $_REQUEST['city_id'];
    $whr .= " and $tbl_visit.city_id=$city_id";
    $whr1 .= " and a.city_id=$city_id";
  }
  if($_REQUEST['enquiry_type']){
    $enquiry_type = $_REQUEST['enquiry_type'];
    $whr .= " and $tbl_visit.enquiry_type='$enquiry_type'";
    $whr1 .= " and a.enquiry_type='$enquiry_type'";
  }
if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date($tbl_visit.cdate) >= '$filter_start_date' and date($tbl_visit.cdate) <= '$filter_end_date'";
  $whr1 .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
}
if($_REQUEST['enrollment_start_date'] && $_REQUEST['enrollment_end_date']){
  $enrollment_start_date = $_REQUEST['enrollment_start_date'];
  $enrollment_end_date = $_REQUEST['enrollment_end_date'];
//   $con .= " inner join $tbl_visit_fee as c on $tbl_visit.id = c.visit_id";
//   $con1 .= " inner join $tbl_visit_fee as c on a.id = c.visit_id";
//   $whr .= " and c.payment_type in ('Enrollment','Direct Enrollment') and date(c.cdate) >= '$enrollment_start_date' and date(c.cdate) <= '$enrollment_end_date'";
//   $whr1 .= " and c.payment_type in ('Enrollment','Direct Enrollment') and date(c.cdate) >= '$enrollment_start_date' and date(c.cdate) <= '$enrollment_end_date'";
  $whr_new1 .= " and date($tbl_visit.enrollment_counselor_date) >= '$enrollment_start_date' and date($tbl_visit.enrollment_counselor_date) <= '$enrollment_end_date'";
  $whr_new .= " and date(a.enrollment_counselor_date) >= '$enrollment_start_date' and date(a.enrollment_counselor_date) <= '$enrollment_end_date'";
}

if($_REQUEST['status']){
  $status = $_REQUEST['status'];
  if($status==1){
    $_SESSION['status']=1; 
    $stauscontent='Total Visits'; 
  }else if($status==2){
    $_SESSION['status']=2;
    $stauscontent='Intersted';
 
  }else if($status==3){
    $_SESSION['status']=3;
    $stauscontent='Not Intersted';
    
  }else if($status==4){
    $stauscontent='Enrolled';
    $_SESSION['status']=4;
  }else if($status==5){
    $stauscontent='Not Enrolled'; 
    $_SESSION['status']=5;
  }else if($status==6){
    $_SESSION['status']=6;
    $stauscontent='Pending Daily Follow Up';
 
  }else if($status==7){
    $_SESSION['status']=7;
    $stauscontent='Pending 1st Follow Up';
  
  }else if($status==8){
    $_SESSION['status']=8;
    $stauscontent='Pending 2nd Follow Up';
  }else if($status==9){
    $_SESSION['status']=9;
    $stauscontent='Pending 3rd Follow Up';
  }else if($status==10){
    $_SESSION['status']=10;
    $stauscontent='Pending Last Follow Up';
  }else if($status==11){
    $_SESSION['status']=11;
    $stauscontent='Partially Interested';
  }
  else if($status==12){
    $_SESSION['status']=12;
    $stauscontent='Highly Interested';
  }
  else if($status==13){
    $_SESSION['status']=13;
    $stauscontent='Unable To Connect';
  }
  else{
    $_SESSION['status']=1;
    $stauscontent='';
  }
  
}


$_SESSION['whr'] = $whr;
$_SESSION['whr1'] = $whr1;
$_SESSION['con'] = $con;
$_SESSION['con1'] = $con1;
$_SESSION['whr2'] = $whr2;
$_SESSION['whr_new'] = $whr_new;
$_SESSION['whr_new1'] = $whr_new1;

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
                        <h5 class="txt-dark">Manage Visits
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>
                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form method="post" name="searchfrm" id="searchfrm" action="visit-list.php">
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
                                                    if($_SESSION['level_id']!==1){
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
                                        <select name="enquiry_type" id="enquiry_type" class="form-control form-select">
                                            <option value="">Select Enquiry Type</option>
                                            <option value="Online"
                                                <?php echo $_REQUEST['enquiry_type'] == 'Online' ? 'selected' : ''  ?>>
                                                Online</option>
                                            <option value="Walkin"
                                                <?php echo $_REQUEST['enquiry_type'] == 'Walkin' ? 'selected' : ''  ?>>
                                                Walkin</option>
                                            <option value="Old Walkin"
                                                <?php echo $_REQUEST['enquiry_type'] == 'Old Walkin' ? 'selected' : ''  ?>>
                                                Old Walkin</option>
                                            <option value="Re-apply"
                                                <?php echo $_REQUEST['enquiry_type'] == 'Re-apply' ? 'selected' : ''  ?>>
                                                Re-apply (Existing IBT Student)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control">
                                                <option value="">Select <?=$_REQUEST['country_id'] == 7 ? 'Area' : 'Country'?></option>
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
                                            <select name="telecaller_id" id="telecaller_id" class="form-control">
                                                <option value="">CRM Executive</option>
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
                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 $whrr order by name",-1);
                        }else{
                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name",-1);
                        }
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['telecaller_id']==$clResult->id){?> selected
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
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <?php
                        $sSql = $obj->query("select * from $tbl_location_states where 1=1 and status=1 order by name asc");
                        while($sResult = $obj->fetchNextObject($sSql)){?>
                                                <option value="<?php echo $sResult->id; ?>"
                                                    <?php if($_REQUEST['state_id']==$sResult->id){?> selected
                                                    <?php } ?>><?php echo $sResult->name; ?></option>
                                                <?php } ?>
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
                                            <select class="form-control" id="visa_source" name="visa_source">
                                                <option value="">Source Type</option>
                                                <option value="Youtube" <?php if($_REQUEST['visa_source']=='Youtube'){?>
                                                    selected <?php }?>>Youtube</option>
                                                <option value="Facebook"
                                                    <?php if($_REQUEST['visa_source']=='Facebook'){?> selected
                                                    <?php }?>>Facebook</option>
                                                <option value="Instagram"
                                                    <?php if($_REQUEST['visa_source']=='Instagram'){?> selected
                                                    <?php }?>>Instagram</option>
                                                <option value="Google" <?php if($_REQUEST['visa_source']=='Google'){?>
                                                    selected <?php }?>>Google</option>
                                                <option value="Website" <?php if($_REQUEST['visa_source']=='Website'){?>
                                                    selected <?php }?>>Website</option>
                                                <option value="Hoarding/Banner"
                                                    <?php if($_REQUEST['visa_source']=='Hoarding/Banner'){?> selected
                                                    <?php }?>>Hoarding/Banner</option>
                                                <option value="Friends" <?php if($_REQUEST['visa_source']=='Friends'){?>
                                                    selected <?php }?>>Friends</option>
                                                <option value="Paper Ad"
                                                    <?php if($_REQUEST['visa_source']=='Paper Ad'){?> selected
                                                    <?php }?>> Newspaper Advertisement</option>
                                                <option value="Seminar" <?php if($_REQUEST['visa_source']=='Seminar'){?>
                                                    selected <?php }?>>Seminar</option>
                                                <option value="Relatives"
                                                    <?php if($_REQUEST['visa_source']=='Relatives'){?> selected
                                                    <?php }?>> Relatives</option>
                                                <option value="Seminar/Education Fair"
                                                    <?php if($_REQUEST['visa_source']=='Seminar/Education Fair'){?>
                                                    selected <?php }?>> Seminar/Education Fair</option>
                                                <option value="Direct Visit"
                                                    <?php if($_REQUEST['visa_source']=='Direct Visit'){?> selected
                                                    <?php }?>> Direct Visit</option>
                                                <option value="Recommend by other Consultant"
                                                    <?php if($_REQUEST['visa_source']=='Recommend by other Consultant'){?>
                                                    selected <?php }?>> Recommend by other Consultant</option>
                                                <option value="Telecalling"
                                                    <?php if($_REQUEST['visa_source']=='Telecalling'){?>
                                                    selected <?php }?>>Telecalling</option>

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
                                            <input type="text" name="enrollment_start_date" id="enrollment_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['enrollment_start_date']; ?>"
                                                placeholder="Enrollment Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="enrollment_end_date" id="enrollment_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['enrollment_end_date']; ?>"
                                                placeholder="Enrollment End Date" onfocus="(this.type='date')"
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
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Visits</span>
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
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr $whr2 and (($tbl_visit.inital_status=6 and $tbl_visit.followup1_status=0 ) OR ($tbl_visit.followup1_status=6 and $tbl_visit.followup2_status =0 )  OR ($tbl_visit.followup2_status=6 and  $tbl_visit.followup3_status =0 ) OR ($tbl_visit.followup3_status=6 and  $tbl_visit.last_followup_status =0 ))",$debug=-1);
                                                                    $line4=$obj->fetchNextObject($sql);
                                                                    echo $line4->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Partially
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(12)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr $whr2 and (($tbl_visit.inital_status=7 and $tbl_visit.followup1_status=0 ) OR ($tbl_visit.followup1_status=7 and $tbl_visit.followup2_status =0 )  OR ($tbl_visit.followup2_status=7 and  $tbl_visit.followup3_status =0 ) OR ($tbl_visit.followup3_status=7 and  $tbl_visit.last_followup_status =0 ))",$debug=-1);
                                                                    $line4=$obj->fetchNextObject($sql);
                                                                    echo $line4->num_rows;
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr $whr2 and (($tbl_visit.inital_status=3 and $tbl_visit.followup1_status=0 ) OR ($tbl_visit.followup1_status=3 and $tbl_visit.followup2_status =0 )  OR ($tbl_visit.followup2_status=3 and  $tbl_visit.followup3_status =0 ) OR ($tbl_visit.followup3_status=3 and  $tbl_visit.last_followup_status =0 ))",$debug=-1);
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
                                                                $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr $whr2 and (($tbl_visit.inital_status=4 and $tbl_visit.followup1_status=0 ) OR ($tbl_visit.followup1_status=4 and $tbl_visit.followup2_status =0 )  OR ($tbl_visit.followup2_status=4 and  $tbl_visit.followup3_status =0 ) OR ($tbl_visit.followup3_status=4 and  $tbl_visit.last_followup_status =0 ))",$debug=-1);
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(13)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1 and enquiry_type!='Re-apply' $whr $whr2 and (($tbl_visit.inital_status=8 and $tbl_visit.followup1_status=0 ) OR ($tbl_visit.followup1_status=8 and $tbl_visit.followup2_status =0 )  OR ($tbl_visit.followup2_status=8 and  $tbl_visit.followup3_status =0 ) OR ($tbl_visit.followup3_status=8 and  $tbl_visit.last_followup_status =0 ))",$debug=-1);
                                                                $line5=$obj->fetchNextObject($sql);
                                                                echo $line5->num_rows;
                                                                ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Unable To Connect</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(4)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                // $obj->query("select COUNT(DISTINCT a.id) as num_rows from $tbl_visit  as a $con1 $tbl_visa_sub_type_join  join $tbl_student as b on  a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no = b.alternate_contact where 1=1 $condition_of_visa_sub_type $whr1 $whr_new",$debug=-1);
                                                                $obj->query("select COUNT(DISTINCT $tbl_visit.id) as num_rows from $tbl_visit $con where 1=1 and $tbl_visit.visit_status='Enrolled' $whr $whr_new1 ",$debug=-1);
                                                                $line=$obj->fetchNextObject($sql);
                                                                echo $enrollCount=$line->num_rows;
                                                                ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Enrolled</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(5)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                            // $obj->query("select COUNT(a.id) as num_rows from $tbl_visit $con  as a left join $tbl_student as b on a.applicant_contact_no=b.student_contact_no where 1=1 AND a.applicant_contact_no!=b.student_contact_no",$debug=-1);
                                                            // $line=$obj->fetchNextObject($sql);
                                                            // echo $line->num_rows;
                                                            echo $totalVisit-$enrollCount;
                                                            ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Not
                                                            Enrolled</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(6)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $todate = date('Y-m-d');
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1  and enquiry_type!='Re-apply' $whr $whr2 and ((date($tbl_visit.inital_next_followup_date) = '$todate' and $tbl_visit.followup1_remarks =0  and $tbl_visit.inital_status!='4') OR (date($tbl_visit.followup1_next_followup_date) = '$todate' and $tbl_visit.followup2_remarks =0  and $tbl_visit.followup1_status!='4') OR (date($tbl_visit.followup2_next_followup_date) = '$todate' and  $tbl_visit.followup3_remarks =0  and $tbl_visit.followup2_status!='4') OR (date($tbl_visit.followup3_next_followup_date) = '$todate' and  $tbl_visit.last_followup_remarks=0  and $tbl_visit.followup3_status!='4'))",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending
                                                            Daily Follow Up</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1  and enquiry_type!='Re-apply' $whr $whr2 and date($tbl_visit.inital_start_date) < '$mtodate'  and $tbl_visit.followup1_status=0  and $tbl_visit.inital_status!='4'",$debug=-1);
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(8)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1  and enquiry_type!='Re-apply' $whr $whr2 and date($tbl_visit.followup1_start_date) < '$mtodate'  and $tbl_visit.followup2_status=0  and $tbl_visit.followup1_status!='4'",$debug=-1);
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(9)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php                              
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1  and enquiry_type!='Re-apply' $whr $whr2 and date($tbl_visit.followup2_start_date) < '$mtodate'  and $tbl_visit.followup3_status=0  and $tbl_visit.followup2_status!='4' ",$debug=-1);
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord(10)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_visit $con  where 1=1  and enquiry_type!='Re-apply' $whr $whr2 and date($tbl_visit.last_followup_start_date) < '$mtodate'  and $tbl_visit.last_followup_status=0  and $tbl_visit.followup3_status!='4'",$debug=-1);
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
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-12r">Color Code: <span
                                                    style="color:red"><?php  if($_SESSION['level_id']==1 || in_array(1,$addtional_role)){ ?>Counsellor
                                                    Not Selected / Remark Pending<?php }else{ ?> Initial Status is not selected
                                                    <?php } ?></span>, <span style="color:orange"> Registration Only</span>, <span style="color:blue"> Partial Enrolled (Can be Enrolled)</span>, <span style="color:green"> Enrolled</span>, <span style="color:red;font-weight:bold"> Visa Refused(Can be Reapplied)</span>, <span style="color:green;font-weight:bold"> Visa Approved(Can proceed for University Transfer / Refund)</span></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="ApplicationList" class="table table-hover display pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <!-- <th>Student Code</th> -->
                                                        <th>Date</th>
                                                        <!-- <th>Registration / Enrollment Date</th> -->
                                                        <th>Name</th>
                                                        <!-- <th>Enquiry Type</th> -->
                                                        <!-- <th>DOB</th> -->
                                                         <th>Father Name</th>
                                                        <!--<th>Online/Offline (Date & Time)</th> -->
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <!-- <th>Visa Sub Type</th> -->
                                                        <th>Contact</th>
                                                        <!-- <th>Source</th> -->
                                                        <th>District</th>
                                                        <th>Branch</th>
                                                        <th>Counsellor</th>
                                                        <th>Remark</th>
                                                        <th>Telecaller</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){ ?>
                                                        <th>Expected Ernollement</th>
                                                        <?php } ?>
                                                        <th>Action</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 9){
                                                            ?>
                                                        <th>Claim</th>
                                                        <?php
                                                        }
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
                                                        ?>
                                                        <th>Profile Completion</th>
                                                        <th>Auditor Status</th>
                                                        <?php } if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){ ?>
                                                        <th>Update Profile</th>
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



    <div class="modal fade payNow" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #fffee0;">
                <div class="modal-header bg-white">
                    <h5 class="modal-title pull-left" id="exampleModalLabel">Reupgrade Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-fee.php" method="get">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" class="form-control" id="get_id" name="id" required>
                        <input type="hidden" class="form-control" id="get_type" name="type" value="Reapply"
                            required>
                        <center>
                            <div class="row">
                                <div class="style-radio col-md-3">
                                    <input type="radio" name="types" id="University_Transfer" value="University Transfer"
                                        onchange="change_radio(this.value)" required>
                                    <label for="University_Transfer">University Transfer</label>
                                </div>
                                <div class="col-md-1" style="padding: 1rem"> or</div>
                                <div class="style-radio col-md-3">
                                    <input type="radio" name="types" id="Refund" value="Refund"
                                        onchange="change_radio(this.value)" required>
                                    <label for="Refund">Refund</label>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary rounded">Reupgrade Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="get_auditor_status" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Profile Status Update</h5>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Profile Status (%)</th>
                                <th>Added By</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>Action (If disapproved)</th>
                            </tr>
                        </thead>
                        <tbody id="get_auditor_status_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="expected_enrollment" tabindex="-1" role="dialog"
        aria-labelledby="applicationPassModalLabeladd" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Select Enrollment Date</h5>
                </div>
                <form method="post" action="controller.php" autocomplete="off">
                    <input type="hidden" name="appid_pass" id="appid_pass">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="visit_id" id="visit_id" class="form-control">
                            <input type="hidden" name="back_url" id="back_url" value="visit-list.php"
                                class="form-control">
                            <input type="date" name="expected_enrollment_date" id="expected_enrollment_date"
                                class="form-control" placeholder="Date & Time">
                            <span id="err_university_id_pass" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name='submit_expected_enrollment_date'
                            class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="show_popup" tabindex="-1" role="dialog" aria-labelledby="applicationPassModalLabeladd"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Enter Disapproved Remark</h5>
                </div>
                <div class="modal-body custom-modal text-center">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="status_id" name="status_id">
                        <input type="text" class="form-control" placeholder="Enter Remark" name="remark" required>
                        <button type="submit" class="btn btn-primary mt-20"
                            name="change_status_reject">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="warning1" tabindex="-1" role="dialog" aria-labelledby="applicationPassModalLabeladd"
        aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h5 class="modal-title" id="applicationPassModalLabeladd">Claim</h5>
                </div>
                <div class="modal-body custom-modal text-center">
                    <form action="controller.php" method="post">
                        <input type="hidden" id="warning" name="id">
                        <input type="number" class="form-control" placeholder="Enter Lead Id" name="lead_id" required>
                        <button type="submit" class="btn btn-primary mt-20"
                            name="claim_id_btn">Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });

    $(document).ready(function() {
        var dataTable = $('#ApplicationList').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": false,
            "lengthMenu": [
                [50, 100, 500, 1000, 1500, 2000],
                [50, 100, 500, 1000, 1500, 2000]
            ],
            "pageLength": 50,
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                {
                    "bSearchable": false,
                    "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            ],
            "ajax": {
                url: "visit-list-ajax.php",
                type: "post",
                error: function() {
                    $(".product-grid-error").html("");
                    $("#product-grid").append(
                        '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                    );
                    $("#product-grid_processing").css("display", "none");
                }
            }
            <?php
        if($_SESSION['level_id'] == 1){
        ?>,
            "dom": '<"top"lfB>rt<"bottom"ip><"clear">', // Include this line to add the buttons container
            "buttons": [{
                extend: 'csvHtml5',
                text: 'Download CSV',
                title: 'Visit List',
                exportOptions: {
                    columns: ':not(:last-child):not(:nth-last-child(2)):not(:nth-last-child(3))' // Exclude last three columns
                }
            }]
            <?php } ?>
        });
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
    $("#state_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#city_id").change(function() {
        $("#searchfrm").submit();
    })
    $("#enquiry_type").change(function() {
        $("#searchfrm").submit();
    })
    $("#pre_state_id").change(function() {
        $("#searchfrm").submit();
    })


    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
    <script>
    function get_modal(id) {
        $("#get_id").val(id);
        $("#exampleModal").modal('show');
    }

    function change_radio(val) {
        $("#get_type").val(val);
        $("#exampleModal").modal('show');
    }
    </script>
    <script src="js/change-status.js"></script>
    <script>
        function warning(val) {
        $("#warning").val(val);
        $("#warning1").modal('show');

        // Swal.fire({
        //     title: "Are you sure?",
        //     text: "Do you want to claim it?",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#3085d6",
        //     cancelButtonColor: "#d33",
        //     confirmButtonText: "Yes",
        //     cancelButtonText: "No"
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         window.location.href = url;
        //     }
        // });
    }
    </script>
    <script>
    function expected_enrollment(id) {
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                expected_enrollment: id
            },
            success: function(data) {
                $("#expected_enrollment").modal('show');
                $("#visit_id").val(id);
                $("#expected_enrollment_date").val(data);
            }
        })
    }
    </script>
    <script>
    function get_auditor_status(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                get_auditor_status: id
            },
            success: function(data) {
                $("#get_auditor_status").modal('show');
                $("#get_auditor_status_data").html(data);

            }
        })
    }
    </script>
    <script>
    function change_status(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve it?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Approve",
            cancelButtonText: "Disapprove"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: "controller.php",
                    data: {
                        change_status_success: id
                    },
                    success: function(data) {
                        location.reload();
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                $("#status_id").val(id);
                $("#show_popup").modal('show');
                // $.ajax({
                //     method: "POST",
                //     url: "controller.php",
                //     data: {
                //         change_status_reject: id
                //     },
                //     success: function(data) {
                //         location.reload();
                //     }
                // });
            }
        });
    }
    </script>
    <script>
        function get_popup(id){
            $("#get_id").val(id);
            $("#exampleModal").modal('show');
        }
    </script>
</body>

</html>