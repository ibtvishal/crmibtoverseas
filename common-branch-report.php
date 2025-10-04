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
$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
$whr=''; 
$whr1='';
$whr2= "";
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || in_array(4,$addtional_role)){
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and crm_executive_id in ($crm_executive_id)";
    $whr1 .= " and a.crm_executive_id in ($crm_executive_id)";
    $whr2 .= " and a.crm_executive_id in ($crm_executive_id)";
  }
  if($_SESSION['level_id']==19){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
    $whr2 .= " and a.branch_id in ($branchid)";
  }
}else{
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and (crm_executive_id in ($crm_executive_id) or crm_executive_id ='".$_SESSION['sess_admin_id']."')";
    $whr1 .= " and (a.crm_executive_id in ($crm_executive_id) or a.crm_executive_id ='".$_SESSION['sess_admin_id']."')";
    $whr2 .= " and (a.crm_executive_id in ($crm_executive_id) or a.crm_executive_id ='".$_SESSION['sess_admin_id']."')";
  }else{
  $whr .= " and crm_executive_id ='".$_SESSION['sess_admin_id']."'";
  $whr1 .= " and a.crm_executive_id  ='".$_SESSION['sess_admin_id']."'";
  $whr2 .= " and a.crm_executive_id  ='".$_SESSION['sess_admin_id']."'";
  }
}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
  $whr2 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['state_id']){
  $state_id = $_REQUEST['state_id'];
  $whr .= " and state_id=$state_id";
  $whr1 .= " and a.state_id=$state_id";
  $whr2 .= " and a.state_id=$state_id";
}
if($_REQUEST['city_id']){
  $city_id = $_REQUEST['city_id'];
  $whr .= " and city_id=$city_id";
  $whr1 .= " and a.city_id=$city_id";
  $whr2 .= " and a.city_id=$city_id";
}

if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  $whr .= " and FIND_IN_SET('$visa_type',visa_type)";
  $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
  $whr2 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
}
if($_REQUEST['source']){
  $source = $_REQUEST['source'];
  $whr .= " and source = '$source'";
  $whr1 .= " and a.source = '$source'";
  $whr2 .= " and a.source = '$source'";
}
if($_REQUEST['visa_source']){
  $visa_source = $_REQUEST['visa_source'];
  $whr .= " and source = '$visa_source'";
  $whr1 .= " and a.source = '$visa_source'";
  $whr2 .= " and a.source = '$visa_source'";
}
if($_REQUEST['recent_qualification']){
  $recent_qualification = $_REQUEST['recent_qualification'];
  $whr .= " and recent_qualification = '$recent_qualification'";
  $whr1 .= " and a.recent_qualification = '$recent_qualification'";
  $whr2 .= " and a.recent_qualification = '$recent_qualification'";
}
if($_REQUEST['pre_country_id']){
    $pre_country_id = $_REQUEST['pre_country_id'];
    $whr .= " and pre_country_id=$pre_country_id";
    $whr1 .= " and a.pre_country_id=$pre_country_id";
    $whr2 .= " and a.pre_country_id=$pre_country_id";
  }
if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
  $whr1 .= " and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) >= '$filter_start_date' and date(a.enrollment_counselor_date) <= '$filter_end_date'";
  $whr2 .= " and a.visit_status in ('Registered','Register') and date(a.visit_status_date) >= '$filter_start_date' and date(a.visit_status_date) <= '$filter_end_date'";
}


$_SESSION['whr'] = $whr;
$_SESSION['whr1'] = $whr1;
$_SESSION['whr2'] = $whr2;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.canvasjs-chart-credit {
    display: none !important;
}

.canvasjs-chart-toolbar {
    display: none !important;
}

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

.counter {
    font-size: 15px !important;
}

table td,
table th {
    text-align: center !important
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
                        <h5 class="txt-dark">Manage Common Branch Report
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form method="post" name="searchfrm" id="searchfrm" action="common-branch-report.php">
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
                                                    }elseif(isset($branchids)){
                                                        $branchArr = $branchids;
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
                                        <div class="form-group">
                                            <select class="required form-control" name="pre_country_id"
                                                id="pre_country_id">
                                                <option value="">Select Preferred Country</option>
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
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <?php
                        $sSql = $obj->query("select * from $tbl_location_states where 1=1 order by name asc");
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
                          $iSql = $obj->query("select * from $tbl_location_cities where 1=1 and state_id='".$_REQUEST['state_id']."' order by name asc");
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

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
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
                    <div class="col-md-12">
                        <div id="lead_location" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="visit_location" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="registration_location" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="Enrollment_location" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                </div>

            </div>
        </div>
        <?php include("footer.php"); ?>
        <script src="js/select2.full.min.js"></script>
        <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script src="js/change-status.js"></script>
        <script type="text/javascript">
        $(".select2").select2({
            placeholder: "All Branches",
            allowClear: true
        });

        // $("#branch_id").change(function() {
        //     $("#searchfrm").submit();
        // })
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
        $("#visa_source").change(function() {
            $("#searchfrm").submit();
        })
        $("#pre_country_id").change(function() {
            $("#searchfrm").submit();
        })
        </script>
        <?php
                                                $get_lead = $obj->query("SELECT id FROM `$tbl_lead` where 1=1  $whr",-1);
                                                $total_lead = $obj->numRows($get_lead);
                                                $get_visit = $obj->query("SELECT id FROM `$tbl_visit` where 1=1 and  enquiry_type!='Re-apply'  $whr",-1);
                                                $total_visit = $obj->numRows($get_visit);
                                                $get_enrollment = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where 1=1 $condition_of_visa_sub_type $whr1",-1);
                                                $total_enrollment = $obj->numRows($get_enrollment);
                                                $get_enrollment1 = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where 1=1 $condition_of_visa_sub_type $whr2",-1);
                                                $total_enrollment1 = $obj->numRows($get_enrollment1);
                                                    ?>
        <script>
        var chart = new CanvasJS.Chart("lead_location", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Branch Lead (<?=$total_lead?>)",
                fontFamily: "Arial",
                fontWeight: "bold",
                fontSize: 14
            },
            data: [{
                type: "column",
                toolTipContent: "{label}: <strong>{y}</strong> ({percentage}%)",
                indexLabel: "{y}({percentage}%)",
                fontFamily: "Arial",
                dataPoints: [
                    <?php
                    $get = $obj->query("SELECT branch_id,COUNT(*) as total FROM `$tbl_lead` where branch_id is not null $whr group by branch_id order by COUNT(*) desc limit 20",-1);
                    $get1 = $obj->query("SELECT id FROM `$tbl_lead` where branch_id is not null $whr",-1);
                    $totalLeads = $obj->numRows($get1);
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['name' => addslashes(getField('name', $tbl_branch, $res->branch_id)), 'y' => $res->total];
                        // $totalLeads += $res->total;
                    }
                    foreach($data as $d){
                        $percentage = round(($d['y'] / $totalLeads) * 100, 2);
                        echo "{ label: '".$d['name']."', y: ".$d['y'].", percentage: $percentage },";
                    }
                ?>
                ]
            }]
        });
        chart.render();
        </script>
        <script>
        <?php
     $get = $obj->query("SELECT id FROM `$tbl_visit` where 1=1 and enquiry_type!='Re-apply' $whr",-1);
    ?>
        var chart = new CanvasJS.Chart("visit_location", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Branch Visit (<?=$total_visit?>)",
                fontFamily: "Arial",
                fontWeight: "bold",
                fontSize: 14
            },
            data: [{
                type: "column",
                toolTipContent: "{label}: <strong>{y}</strong> ({percentage}%)",
                indexLabel: "{y}({percentage}%)",
                fontFamily: "Arial",
                dataPoints: [
                    <?php
                    $get = $obj->query("SELECT branch_id,COUNT(*) as total FROM `$tbl_visit` where branch_id is not null and enquiry_type!='Re-apply' $whr group by branch_id order by COUNT(*) desc limit 20",-1);
                    $get1 = $obj->query("SELECT id FROM `$tbl_visit` where branch_id is not null and enquiry_type!='Re-apply' $whr",-1);
                    $totalLeads = $obj->numRows($get1);
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['name' => addslashes(getField('name', $tbl_branch, $res->branch_id)), 'y' => $res->total];
                        // $totalLeads += $res->total;
                    }
                    foreach($data as $d){
                        $percentage = round(($d['y'] / $totalLeads) * 100, 2);
                        echo "{ label: '".$d['name']."', y: ".$d['y'].", percentage: $percentage },";
                    }
                ?>
                ]
            }]
        });
        chart.render();
        </script>
        <script>
        var chart = new CanvasJS.Chart("Enrollment_location", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Branch Enrollment (<?=$total_enrollment?>)",
                fontFamily: "Arial",
                fontWeight: "bold",
                fontSize: 14
            },
            data: [{
                type: "column",
                toolTipContent: "{label}: <strong>{y}</strong> ({percentage}%)",
                indexLabel: "{y}({percentage}%)",
                fontFamily: "Arial",
                dataPoints: [
                    <?php
                    $get = $obj->query("SELECT a.branch_id,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.branch_id is not null $condition_of_visa_sub_type $whr1 group by a.branch_id order by COUNT(a.id) desc limit 20",-1);
                    $get1 = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where  a.branch_id is not null $condition_of_visa_sub_type $whr1",-1);
                    $totalLeads = $obj->numRows($get1);
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['label' => addslashes(getField('name', $tbl_branch, $res->branch_id)), 'y' => $res->total];
                    }
                    foreach($data as $d){
                        $percentage = round(($d['y'] / $totalLeads) * 100, 2);
                        echo "{ label: '".$d['label']."', y: ".$d['y'].", percentage: $percentage },";
                    }
                ?>
                ]
            }]
        });
        chart.render();
        </script>
        <script>
        var chart = new CanvasJS.Chart("registration_location", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Branch Registration (<?=$total_enrollment1?>)",
                fontFamily: "Arial",
                fontWeight: "bold",
                fontSize: 14
            },
            data: [{
                type: "column",
                toolTipContent: "{label}: <strong>{y}</strong> ({percentage}%)",
                indexLabel: "{y}({percentage}%)",
                fontFamily: "Arial",
                dataPoints: [
                    <?php
                    $get = $obj->query("SELECT a.branch_id,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.branch_id is not null $condition_of_visa_sub_type $whr2 group by a.branch_id order by COUNT(a.id) desc limit 20",-1);
                    $get1 = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.branch_id is not null $condition_of_visa_sub_type $whr2",-1);
                    $totalLeads = $obj->numRows($get1);
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['label' => addslashes(getField('name', $tbl_branch, $res->branch_id)), 'y' => $res->total];
                    }
                    foreach($data as $d){
                        $percentage = round(($d['y'] / $totalLeads) * 100, 2);
                        echo "{ label: '".$d['label']."', y: ".$d['y'].", percentage: $percentage },";
                    }
                ?>
                ]
            }]
        });
        chart.render();
        </script>
        <?php
    if(!$_REQUEST['filter_start_date']){
    ?>
        <script>
        $(document).ready(function() {
            const today = new Date();

            // Get the first and last day of the current month
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            // Format the dates to `YYYY-MM-DD` for input values
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            $("#filter_start_date").val(formatDate(firstDay)); // Set first date of the month
            $("#filter_end_date").val(formatDate(lastDay)); // Set last date of the month
            $("#searchfrm").submit();
        });
        </script>
        <?php } ?>
</body>

</html>