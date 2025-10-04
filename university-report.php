<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$whr=''; 
$addtional_role = explode(',',$_SESSION['additional_role']);

  if($_SESSION['level_id'] == 17 || $_SESSION['level_id'] == 15 || $_SESSION['level_id'] == 16 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 31){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branchid)";
  }

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and a.branch_id in ($branch_id)";
}

if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and a.country_id='$country_id'";
}



if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(b.visa_issue_date) >= '$filter_start_date' and date(b.visa_issue_date) <= '$filter_end_date'";
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
                        <h5 class="txt-dark">Manage University Report
                            <?php if($_REQUEST['status']){ echo "<span style='color:#2e0cdd;'>of ".$stauscontent."</span>"; } ?>
                        </h5>
                    </div>


                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form method="post" name="searchfrm" id="searchfrm" action="university-report.php">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="country_id" id="country_id" class="form-control">
                                                <option value="">Select Country</option>
                                                <?php
                                                $branchSql = $obj->query("select * from $tbl_country where status=1");
                                                while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                                <option value="<?php echo $branchResult->id; ?>" <?=$branchResult->id == $_REQUEST['country_id'] ? 'selected' : ''?>><?php echo $branchResult->name; ?></option>
                                                <?php }?>
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
                        <div id="total_visa_approved" style="height:300px;margin-bottom: 20px;"></div>
                    </div>
                    <div class="col-md-12">
                        <div id="total_interview" style="height:300px;margin-bottom: 20px;"></div>
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
        $("#country_id").change(function() {
            $("#searchfrm").submit();
        })
        $("#visa_type").change(function() {
            $("#searchfrm").submit();
        })
        $("#source").change(function() {
            $("#searchfrm").submit();
        })
        </script>
        <script>
        <?php
                    $get = $obj->query("SELECT count(*) as total, LTRIM(b.university_name) AS university_name  FROM $tbl_student_enrollment as b inner join $tbl_student as a on a.id=b.stu_id where b.university_name is not null $whr group by LTRIM(b.university_name) order by count(*) desc limit 20",-1);
                    $totalapproved = 0;
                    $data = [];
                    while($res = $obj->fetchNextObject($get)){
                        $data[$res->university_name] = ['name' => addslashes($res->university_name), 'y' => $res->total];
                        $totalapproved += $res->total;
                    }
                ?>
        var chart = new CanvasJS.Chart("total_visa_approved", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Top 20 Universities  (<?=$totalapproved?>)",
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
                
                    foreach($data as $d){
                        $percentage = round(($d['y'] / $totalapproved) * 100, 2);
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
                    $get = $obj->query("SELECT count(*) as total, LTRIM(b.university_name) AS university_name  FROM $tbl_student_enrollment as b inner join $tbl_student as a on a.id=b.stu_id where b.university_name is not null $whr group by LTRIM(b.university_name) order by count(*) asc limit 20",-1);
                    $totalapproved = 0;
                    $datas = [];
                    while($res = $obj->fetchNextObject($get)){
                        $datas[$res->university_name] = ['name' => addslashes($res->university_name), 'y' => $res->total];
                        $totalapproved += $res->total;
                    }
                ?>
        var chart = new CanvasJS.Chart("total_interview", {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Least 20 Universities (<?=$totalapproved?>)",
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
                    foreach($datas as $d){
                        $percentage = round(($d['y'] / $totalapproved) * 100, 2);
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

