<?php
ob_start();
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr='';
$whr1='';
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and branch_id in ($branch_id)";
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  $tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
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

.heading-text {
    text-align: center;
    font-weight: bold;
    background: skyblue;
    padding: 8px;
    color: black;
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
                    <?php echo $_SESSION['sess_msg'];
                    $_SESSION['sess_msg'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Counsellor Report
                            <?php if ($_REQUEST['status']) {
                                echo "<span style='color:#2e0cdd;'>of " . $stauscontent . "</span>";
                            } ?>
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" id="submit_form" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branch_id[]" id="branch_id" class="form-control select2" multiple>
                                <?php
                                        if(!empty($_REQUEST['branch_id'])){
                                        $branchArr = $_REQUEST['branch_id'];
                                        if(is_array($branchArr)){
                                            $branchArr = $branchArr;
                                        }else{
                                            $branchArr = explode(',',$branchArr);
                                        }
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
                        <div class="col-md-3">
                            <select name="report_type" id="report_type" class="form-control" onchange="submit_form()">
                                <option value="">Select Report Type</option>
                                <option value="weekly" <?=$_REQUEST['report_type'] == 'weekly' ? 'selected' : ''?>>
                                    Weekly</option>
                                <option value="fortnightly"
                                    <?=$_REQUEST['report_type'] == 'fortnightly' ? 'selected' : ''?>>Fornightly</option>
                                <option value="monthly" <?=$_REQUEST['report_type'] == 'monthly' ? 'selected' : ''?>>
                                    Monthly</option>
                                <option value="till_date"
                                    <?=$_REQUEST['report_type'] == 'till_date' ? 'selected' : ''?>>Till Date</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="years" id="years" class="form-control" onchange="submit_form()">
                                <option value="">Select Year</option>
                                <?php
                                $y = date('Y');
                                for($i = 2023; $i <= $y; $i++){
                                ?>
                                <option value="<?=$i?>" <?=$_REQUEST['years'] == $i ? 'selected' : ''?>><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="month" id="months" class="form-control" onchange="submit_form()">
                                <option value="">Select Month</option>
                                <option value="1" <?=$_REQUEST['month'] == '1' ? 'selected' : ''?>>January</option>
                                <option value="2" <?=$_REQUEST['month'] == '2' ? 'selected' : ''?>>February</option>
                                <option value="3" <?=$_REQUEST['month'] == '3' ? 'selected' : ''?>>March</option>
                                <option value="4" <?=$_REQUEST['month'] == '4' ? 'selected' : ''?>>April</option>
                                <option value="5" <?=$_REQUEST['month'] == '5' ? 'selected' : ''?>>May</option>
                                <option value="6" <?=$_REQUEST['month'] == '6' ? 'selected' : ''?>>June</option>
                                <option value="7" <?=$_REQUEST['month'] == '7' ? 'selected' : ''?>>July</option>
                                <option value="8" <?=$_REQUEST['month'] == '8' ? 'selected' : ''?>>August</option>
                                <option value="9" <?=$_REQUEST['month'] == '9' ? 'selected' : ''?>>September</option>
                                <option value="10" <?=$_REQUEST['month'] == '10' ? 'selected' : ''?>>October</option>
                                <option value="11" <?=$_REQUEST['month'] == '11' ? 'selected' : ''?>>November</option>
                                <option value="12" <?=$_REQUEST['month'] == '12' ? 'selected' : ''?>>December</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="margin-top:10px">
                            <div class="form-group">
                                <button type="submit" name="subit" class="btn btn-primary download_csv_button"
                                    style="width: 170px; height: 40px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>


                <?php
                if($_SESSION['level_id'] == 4){

                    if($_REQUEST['report_type']){
                            // Example usage
                            if($_REQUEST['month']){
                                $month = $_REQUEST['month'];
                            }else{
                                $month = date('m');
                            }
                            if($_REQUEST['years']){
                                $year = $_REQUEST['years'];
                            }else{
                                $year = date('Y');
                            }
                            $weeks = getDateRanges($year, $month, $_REQUEST['report_type']);
                            
                    ?>
                <div class="row" style="margin-top:20px">
                    <?php
                    foreach($weeks as $week){
                        $week_date = explode(' to ', $week);
                        $from_date = date("Y-m-d", strtotime($week_date[0]));
                        $to_date = date("Y-m-d", strtotime($week_date[1]));
                    ?>
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-12 heading-text"><?=$week?></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table table-hover display pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Branch</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Counselling</th>
                                                        <th>Enrollment</th>
                                                        <th>Conversion Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $c = 1;
                                                    if($_REQUEST['branch_id']){
                                                        foreach($_REQUEST['branch_id'] as $branch){
                                                        $gets = $obj->query("select id,name from $tbl_admin where id='{$_SESSION['sess_admin_id']}' and status=1 and branch_id like '%$branch%'",-1);
                                                        while($res = $obj->fetchNextObject($gets)){ 
                                                            $get1 = $obj->query("SELECT count(b.id) as total from $tbl_visit as a inner join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no ) $tbl_visa_sub_type_join where b.transfer=0 and a.status=0 and  a.enrollment_counselor='".$res->id."' and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '$from_date' and '$to_date' $condition_of_visa_sub_type $whr1",-1);
                                                            $res1 = $obj->fetchNextObject($get1);
    
                                                            $get2 = $obj->query("select count(*) as total from $tbl_visit where councellor_id LIKE '%".$res->id."%' and date(cdate) between '$from_date' and '$to_date' $whr",-1);
                                                            $res2 = $obj->fetchNextObject($get2);
                                                        ?>
                                                    <tr>
                                                        <td><?=getField('name',$tbl_branch,$branch) ?></td>
                                                        <td><?=$res->name; ?></td>
                                                        <td><?=$res2->total?></td>
                                                        <td><?=$res1->total?></td>
                                                        <td>
                                                            <?php
                                                                if($res1->total>0 && $res2->total>0){
                                                                    $conv = number_format($res1->total*100/$res2->total);
                                                                     echo $conv."%";
                                                                }else{
                                                                    echo "0%";
                                                                }?>
                                                        </td>
                                                    </tr>
                                                    <?php } }
                                                    }else{
                                                    $gets = $obj->query("select id,name,branch_id from $tbl_admin where level_id=4 and status=1 $whr1",-1);
                                                    while($res = $obj->fetchNextObject($gets)){ 
                                                        $get1 = $obj->query("SELECT count(b.id) as total from $tbl_visit as a inner join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no ) $tbl_visa_sub_type_join where b.transfer=0 and  a.enrollment_counselor='".$res->id."' and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '$from_date' and '$to_date' $condition_of_visa_sub_type $whr1",-1);
                                                        $res1 = $obj->fetchNextObject($get1);

                                                        $get2 = $obj->query("select count(*) as total from $tbl_visit where councellor_id LIKE '%".$res->id."%' and date(cdate) between '$from_date' and '$to_date' $whr",-1);
                                                        $res2 = $obj->fetchNextObject($get2);
                                                    ?>
                                                    <tr>
                                                        <td><?=$c++?></td>
                                                        <td><?=getField('name',$tbl_branch,$res->branch_id) ?></td>
                                                        <td><?=$res->name; ?></td>
                                                        <td><?=$res2->total?></td>
                                                        <td><?=$res1->total?></td>
                                                        <td>
                                                            <?php
                                                            if($res1->total>0 && $res2->total>0){
                                                                $conv = number_format($res1->total*100/$res2->total);
                                                                 echo $conv."%";
                                                            }else{
                                                                echo "0%";
                                                            }?>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php }else{
                    ?>
                <div id="chartContainer" style="height: 400px; width: 100%; margin-top:20px"></div>
                <?php
                } ?>
                <?php
                }
                ?>
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19){
                    $branch_con = '';
                    $branch_con1 = '';
                    if($_SESSION['level_id'] != 1){
                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                        $branch_con = " and branch_id in ($branch_id)";
                        $branch_con1 = " and a.branch_id in ($branch_id)";
                    }
                    if($_REQUEST['report_type']){
                            // Example usage
                            if($_REQUEST['month']){
                                $month = $_REQUEST['month'];
                            }else{
                                $month = date('m');
                            }
                            if($_REQUEST['years']){
                                $year = $_REQUEST['years'];
                            }else{
                                $year = date('Y');
                            }
                            $weeks = getDateRanges($year, $month, $_REQUEST['report_type']);
                    ?>
                <div class="row" style="margin-top:20px">
                    <?php
                    foreach($weeks as $week){
                        $week_date = explode(' to ', $week);
                        $from_date = date("Y-m-d", strtotime($week_date[0]));
                        $to_date = date("Y-m-d", strtotime($week_date[1]));
                    ?>
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                            <div class="col-md-12 heading-text"><?=$week?></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Branch Name</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Counselling</th>
                                                        <th>Enrollment</th>
                                                        <th>Conversion Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $c = 1;
                                                    if($_REQUEST['branch_id']){
                                                        foreach($_REQUEST['branch_id'] as $branch){
                                                        $gets = $obj->query("select id,name from $tbl_admin where level_id=4 and status=1 and branch_id like '%$branch%'",-1);
                                                        while($res = $obj->fetchNextObject($gets)){ 
                                                            $get1 = $obj->query("SELECT count(b.id) as total from $tbl_visit as a inner join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no ) $tbl_visa_sub_type_join where b.transfer=0 and  a.enrollment_counselor='".$res->id."' and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '$from_date' and '$to_date' $condition_of_visa_sub_type $whr1",-1);
                                                            // $get1 = $obj->query("select count(*) as total from $tbl_student where c_id='".$res->id."' and date(cdate) between '$from_date' and '$to_date' $whr",-1);
                                                            $res1 = $obj->fetchNextObject($get1);
    
                                                            $get2 = $obj->query("select count(*) as total from $tbl_visit where councellor_id LIKE '%".$res->id."%' and date(cdate) between '$from_date' and '$to_date' $whr",-1);
                                                            $res2 = $obj->fetchNextObject($get2);
    
                                                        ?>
                                                    <tr>
                                                        <td><?=getField('name',$tbl_branch,$branch) ?></td>
                                                        <td><?=$res->name; ?></td> 
                                                        <td><?=$res2->total?></td>
                                                        <td><?=$res1->total?></td>
                                                        <td>
                                                            <?php
                                                                if($res1->total>0 && $res2->total>0){
                                                                    $conv = number_format($res1->total*100/$res2->total);
                                                                     echo $conv."%";
                                                                }else{
                                                                    echo "0%";
                                                                }?>
                                                        </td>
                                                    </tr>
                                                    <?php } }
                                                    }else{
                                                    $gets = $obj->query("select id,name,branch_id from $tbl_admin where level_id=4 and status=1 $branch_con $whr1",-1);
                                                    while($res = $obj->fetchNextObject($gets)){ 
                                                        $get1 = $obj->query("SELECT count(b.id) as total from $tbl_visit as a inner join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no ) $tbl_visa_sub_type_join where b.transfer=0 and  a.enrollment_counselor='".$res->id."' and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '$from_date' and '$to_date' $condition_of_visa_sub_type $branch_con1 $whr1",-1);
                                                        $res1 = $obj->fetchNextObject($get1);

                                                        $get2 = $obj->query("select count(*) as total from $tbl_visit where councellor_id LIKE '%".$res->id."%' and date(cdate) between '$from_date' and '$to_date' $branch_con $whr",-1);
                                                        $res2 = $obj->fetchNextObject($get2);

                                                    ?>
                                                    <tr>
                                                        <td><?=getField('name',$tbl_branch,$res->branch_id) ?></td>
                                                        <td><?=$res->name; ?></td>
                                                        <td><?=$res2->total?></td>
                                                        <td><?=$res1->total?></td>
                                                        <td>
                                                            <?php
                                                            if($res1->total>0 && $res2->total>0){
                                                                $conv = number_format($res1->total*100/$res2->total);
                                                                 echo $conv."%";
                                                            }else{
                                                                echo "0%";
                                                            }?>
                                                        </td>
                                                    </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php  }else{
                    ?>
                <div id="chartContainer1" style="height: 400px; width: 100%; margin-top:20px"></div>
                <?php
                } } ?>

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

    <!-- model table -->

    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/change-status.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>
    <script>
    window.onload = function() {
<?php
    if($_SESSION['level_id'] == 4){
    ?>
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Current Month Councellors Data"
            },
            axisY: {
                includeZero: true,
                title: "Total Enrollment",
            },
            axisX: {
                title: "Counsellor Names",
                interval: 1,
                labelAngle: -45,
                labelFontSize: 14,
                labelFontColor: "#5A5757"
            },
            data: [{
                type: "column",
                indexLabelFontColor: "#5A5757",
                indexLabelFontSize: 16,
                indexLabelPlacement: "outside",
                dataPoints: [
                    <?php
                      if($_REQUEST['month']){ 
                        $month = $_REQUEST['month'];
                    }else{
                        $month = date('m');
                    }
                    if($_REQUEST['years']){
                        $year = $_REQUEST['years'];
                    }else{
                        $year = date('Y');
                    }
                $get = $obj->query("select * from $tbl_admin where status=1 and level_id='4'  order by name",-1);
                while($res = $obj->fetchNextObject($get)){
                    $id = $res->id;
                    $get1 = $obj->query("SELECT COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.enrollment_counselor = '$id' and a.visit_status='Enrolled' and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month $condition_of_visa_sub_type $whr1 ",-1);
                    $res1 = $obj->fetchNextObject($get1);
                    echo "{ label: '".addslashes($res->name)."', y: $res1->total },";
                }
                ?>
                ]
            }]
        });
        <?php } ?>
        <?php
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19){
    ?>
        var chart = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            title: {
                text: "Current Month Branch Data"
            },
            axisY: {
                includeZero: true,
                title: "Total Enrollment",
            },
            axisX: {
                title: "Branch Names",
                interval: 1,
                labelAngle: -45,
                labelFontSize: 14,
                labelFontColor: "#5A5757"
            },
            data: [{
                type: "column",
                indexLabelFontColor: "#5A5757",
                indexLabelFontSize: 16,
                indexLabelPlacement: "outside",
                dataPoints: [
                    <?php
             if($_REQUEST['month']){
                $month = $_REQUEST['month'];
            }else{
                $month = date('m');
            }
            if($_REQUEST['years']){
                $year = $_REQUEST['years'];
            }else{
                $year = date('Y');
            }
                $get = $obj->query("SELECT branch_id,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.enrollment_counselor!=0 and a.visit_status='Enrolled' and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month $condition_of_visa_sub_type $branch_con1 $whr1 GROUP BY a.branch_id",-1);
                while($res = $obj->fetchNextObject($get)){
                    echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                }
                ?>
                ]
            }]
        });
        <?php } ?>
        chart.render();

    }
    </script>
    <script>
    // function submit_form() {
    //     $("#submit_form").submit();
    // }
    </script>
    <?php
    if(!isset($_REQUEST['report_type'])){
    ?>
    <script>
        $(document).ready(function(){
            $("#report_type").val('monthly');
            $("#years").val('<?=date("Y")?>');
            $("#months").val('<?=date("n")?>');
            $("#submit_form").submit();
        })
    </script>
    <?php } ?>
</body>

</html>