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

$whr=''; 
$whr1='';
$whr2= " and status=1";
$addtional_role = explode(',',$_SESSION['additional_role']);

$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";

if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || in_array(4,$addtional_role)){
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and crm_executive_id in ($crm_executive_id)";
    $whr1 .= " and a.crm_executive_id in ($crm_executive_id)";
  }
  if($_SESSION['level_id']==19){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and branch_id in ($branchid)";
    $whr1 .= " and a.branch_id in ($branchid)";
  }
}else{
  if($_REQUEST['crm_executive_id']){
    $crm_executive_id = $_REQUEST['crm_executive_id'];
    $whr .= " and (crm_executive_id in ($crm_executive_id) or crm_executive_id ='".$_SESSION['sess_admin_id']."')";
    $whr1 .= " and (a.crm_executive_id in ($crm_executive_id) or a.crm_executive_id ='".$_SESSION['sess_admin_id']."')";
  }else{
  $whr .= " and crm_executive_id ='".$_SESSION['sess_admin_id']."'";
  $whr1 .= " and a.crm_executive_id  ='".$_SESSION['sess_admin_id']."'";
  }
}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['state_id']){
  $state_id = $_REQUEST['state_id'];
  $whr .= " and state_id=$state_id";
  $whr1 .= " and a.state_id=$state_id";
}
if($_REQUEST['city_id']){
  $city_id = $_REQUEST['city_id'];
  $whr .= " and city_id=$city_id";
  $whr1 .= " and a.city_id=$city_id";
}

if($_REQUEST['visa_type']){
  $visa_type = $_REQUEST['visa_type'];
  $whr .= " and FIND_IN_SET('$visa_type',visa_type)";
  $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
}
if($_REQUEST['source']){
  $source = $_REQUEST['source'];
  $whr .= " and source = '$source'";
  $whr1 .= " and a.source = '$source'";
}
if($_REQUEST['recent_qualification']){
  $recent_qualification = $_REQUEST['recent_qualification'];
  $whr .= " and recent_qualification = '$recent_qualification'";
  $whr1 .= " and a.recent_qualification = '$recent_qualification'";
}
if($_REQUEST['pre_country_id']){
    $pre_country_id = $_REQUEST['pre_country_id'];
    $whr .= " and pre_country_id=$pre_country_id";
    $whr1 .= " and a.pre_country_id=$pre_country_id";
  }
if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(cdate) >= '$filter_start_date' and date(cdate) <= '$filter_end_date'";
  $whr1 .= " and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) >= '$filter_start_date' and date(a.enrollment_counselor_date) <= '$filter_end_date'";
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
table td,table th{
    text-align:center !important
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
                        <h5 class="txt-dark">Manage Source Report
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form method="post" name="searchfrm" id="searchfrm" action="source-report.php">
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
                                                onblur="(this.type='text')" min="2024-09-20">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_end_date" id="filter_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                                placeholder="End Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')" min="2024-09-20">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" name="subit"
                                                class="btn btn-primary download_csv_button"
                                                style="width: 170px; height: 40px;">Submit</button>
                                                <a href="controller.php?export_source_report" class="btn btn-primary" style="padding: 9px 25px;">Download Excel</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="row">
                    <div class="col-md-12">
                        <div id="lead_source" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="visit_source" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="Enrollment_source" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="border-right:1px solid">Source</th>
                                                    <th colspan="2" style="border-right:1px solid">Lead</th>
                                                    <th colspan="2" style="border-right:1px solid">Visit</th>
                                                    <th colspan="2">Enrollment</th>
                                                </tr>
                                                <tr>
                                                    <th style="border-right:1px solid"></th>
                                                    <th>Count</th>
                                                    <th style="border-right:1px solid">Percentage</th>
                                                    <th>Count</th>
                                                    <th style="border-right:1px solid">Percentage</th>
                                                    <th>Count</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $get_lead = $obj->query("SELECT id FROM `$tbl_lead` where 1=1 and date(cdate) > '2024-09-20'   $whr",-1);
                                                $total_lead = $obj->numRows($get_lead);
                                                if($total_lead == 0){
                                                    $total_lead = 1;
                                                }
                                                $get_visit = $obj->query("SELECT id FROM `$tbl_visit` where 1=1 and enquiry_type!='Re-apply' and date(cdate) > '2024-09-20'   $whr",-1);
                                                $total_visit = $obj->numRows($get_visit);
                                                $total_visits = $obj->numRows($get_visit);
                                                if($total_visit == 0){
                                                    $total_visit = 1;
                                                }
                                                $get_enrollment = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.status=0 and  date(a.cdate) > '2024-09-20' $condition_of_visa_sub_type $whr1",-1);
                                                $total_enrollment = $obj->numRows($get_enrollment);
                                                $total_enrollments = $obj->numRows($get_enrollment);
                                                if($total_enrollment == 0){
                                                    $total_enrollment = 1;
                                                }
                                                $get = $obj->query("SELECT source,COUNT(*) as total FROM `$tbl_lead` where  date(cdate) > '2024-09-20' and source is not null $whr group by source order by COUNT(*) desc",-1);
                                                while($res = $obj->fetchNextObject($get)){
                                                    $g_visit = $obj->query("SELECT id FROM `$tbl_visit` where  enquiry_type!='Re-apply' and date(cdate) > '2024-09-20' and  source='".$res->source."' $whr",-1);
                                                    $t_visit = $obj->numRows($g_visit);
                                                    $g_en = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.status=0 and  date(a.cdate) > '2024-09-20' and a.source='".$res->source."' $condition_of_visa_sub_type $whr1",-1);
                                                    $t_en = $obj->numRows($g_en);
                                                    ?>
                                                    <tr>
                                                        <td style="border-right:1px solid black"><?=$res->source?></td>
                                                        <td><?=$res->total?></td>
                                                        <td style="border-right:1px solid black"><?=number_format($res->total / $total_lead * 100,2)?> %</td>
                                                        <td><?=$t_visit?></td>
                                                        <td style="border-right:1px solid black"><?=number_format($t_visit / $total_visit * 100,2)?> %</td>
                                                        <td><?=$t_en?></td>
                                                        <td><?=number_format($t_en / $total_enrollment * 100,2)?> %</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        $("#pre_country_id").change(function() {
            $("#searchfrm").submit();
        })
        </script>
        <script>
        var chart = new CanvasJS.Chart("lead_source", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Lead Source (<?=$total_lead?>)",
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
                    $get = $obj->query("SELECT source,COUNT(*) as total FROM `$tbl_lead` where date(cdate) > '2024-09-20' and source is not null $whr group by source order by COUNT(*) desc",-1);
                    $totalLeads = 0;
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['name' => addslashes($res->source), 'y' => $res->total];
                        $totalLeads += $res->total;
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
     $get = $obj->query("SELECT id FROM `$tbl_visit` where 1=1 and enquiry_type!='Re-apply' and date(cdate) > '2024-09-20' $whr",-1);
    ?>
        var chart = new CanvasJS.Chart("visit_source", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Visit Source (<?=$total_visits?>)",
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
                    $get = $obj->query("SELECT source,COUNT(*) as total FROM `$tbl_visit` where date(cdate) > '2024-09-20' and enquiry_type!='Re-apply' and source is not null $whr group by source order by COUNT(*) desc",-1);
                    $totalLeads = 0;
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['name' => addslashes($res->source), 'y' => $res->total];
                        $totalLeads += $res->total;
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
     $get = $obj->query("SELECT a.id FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.status=0 $condition_of_visa_sub_type $whr1",-1);
    ?>
        var chart = new CanvasJS.Chart("Enrollment_source", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Enrollment Source (<?=$total_enrollments?>)",
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
                    $get = $obj->query("SELECT a.source,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where date(a.cdate) > '2024-09-20' and a.status=0 and a.source is not null $condition_of_visa_sub_type $whr1 group by a.source order by COUNT(a.id) desc",-1);
                    $totalLeads = 0;
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[] = ['name' => addslashes($res->source), 'y' => $res->total];
                        $totalLeads += $res->total;
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

<?php
    if(!isset($_REQUEST['filter_start_date'])){
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
            $("#filter_end_date").val(formatDate(lastDay));   // Set last date of the month
            $("#searchfrm").submit();
        });

    </script>
    <?php } ?>
</body>

</html>