<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$whr=''; 
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and ((date(followup1_start_date) between '$filter_start_date' and '$filter_end_date' and followup1_status!=0) or (date(followup2_start_date) between '$filter_start_date' and '$filter_end_date'  and followup2_status!=0) or (date(followup3_start_date) between '$filter_start_date' and '$filter_end_date' and followup3_status!=0) or (date(last_followup_start_date) between '$filter_start_date' and '$filter_end_date') and last_followup_status!=0) ";
}else{
    $filter_start_date = date('Y-m-d');
    $filter_end_date = date('Y-m-d');
    $whr .= " and ((date(followup1_start_date) between '$filter_start_date' and '$filter_end_date' and followup1_status!=0) or (date(followup2_start_date) between '$filter_start_date' and '$filter_end_date'  and followup2_status!=0) or (date(followup3_start_date) between '$filter_start_date' and '$filter_end_date' and followup3_status!=0) or (date(last_followup_start_date) between '$filter_start_date' and '$filter_end_date') and last_followup_status!=0) ";
}


$_SESSION['whr'] = $whr;

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
                        <h5 class="txt-dark">Manage Outbound Call Stats
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form method="post" name="searchfrm" id="searchfrm" action="outbound-call.php">
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

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_start_date" id="filter_start_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_start_date'] ? $_REQUEST['filter_start_date'] : date("Y-m-d"); ?>"
                                                placeholder="Start Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="filter_end_date" id="filter_end_date"
                                                class="form-control" style="height: 36px;"
                                                value="<?php echo $_REQUEST['filter_end_date'] ? $_REQUEST['filter_end_date'] : date("Y-m-d"); ?>"
                                                placeholder="End Date" onfocus="(this.type='date')"
                                                onblur="(this.type='text')">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
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

        $("#branch_id").change(function() {
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
        </script>
        <?php
            $get1 = $obj->query("SELECT id FROM `$tbl_lead` where crm_executive_id is not null $whr",-1);
            $totalLeads = $obj->numRows($get1);
        ?>
        <script>
        var chart = new CanvasJS.Chart("lead_location", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Outbound Call (<?=$totalLeads?>)",
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
                            $get = $obj->query("SELECT crm_executive_id,COUNT(*) as total FROM `$tbl_lead` where crm_executive_id is not null $whr group by crm_executive_id order by COUNT(*) desc",-1);
                            $data = [];
                            while($res = $obj->fetchNextObject($get)){
                                $data[] = ['name' => addslashes(getField('name', $tbl_admin, $res->crm_executive_id)), 'y' => $res->total];
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
</body>

</html>