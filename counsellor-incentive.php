<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
if($_REQUEST['month']){
    $month = $_REQUEST['month'];
}else{
    $month = date('m');
}
if($_REQUEST['year']){
    $year = $_REQUEST['year'];
}else{
    $year = date('Y');
}
$whr = '';
if($_SESSION['level_id'] == 4){
    $whr = " and id='{$_SESSION['sess_admin_id']}'";
}
if($_SESSION['level_id'] == 19){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr = " and FIND_IN_SET('$branch_id', branch_id) > 0";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Counsellor Incentive</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']=''; ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="form-submit">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="month" id="month" class="form-control form-select">
                                    <option value="">Select Month</option>
                                    <option value="1" <?=$_POST['month'] == 1 ? 'selected' : ''?>>January</option>
                                    <option value="2" <?=$_POST['month'] == 2 ? 'selected' : ''?>>February</option>
                                    <option value="3" <?=$_POST['month'] == 3 ? 'selected' : ''?>>March</option>
                                    <option value="4" <?=$_POST['month'] == 4 ? 'selected' : ''?>>April</option>
                                    <option value="5" <?=$_POST['month'] == 5 ? 'selected' : ''?>>May</option>
                                    <option value="6" <?=$_POST['month'] == 6 ? 'selected' : ''?>>June</option>
                                    <option value="7" <?=$_POST['month'] == 7 ? 'selected' : ''?>>July</option>
                                    <option value="8" <?=$_POST['month'] == 8 ? 'selected' : ''?>>August</option>
                                    <option value="9" <?=$_POST['month'] == 9 ? 'selected' : ''?>>September</option>
                                    <option value="10" <?=$_POST['month'] == 10 ? 'selected' : ''?>>October</option>
                                    <option value="11" <?=$_POST['month'] == 11 ? 'selected' : ''?>>November</option>
                                    <option value="12" <?=$_POST['month'] == 12 ? 'selected' : ''?>>December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="year" id="year" class="form-control form-select">
                                    <option value="">Select Year</option>
                                    <?php
                                    for($i = 2024; $i < 2031; $i++){
                                    ?>
                                    <option value="<?=$i?>" <?=$_POST['year'] == $i ? 'selected' : ''?>><?=$i?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <h5>Counsellor Enrollments Incentive</h5>
                                            <table id="datable_3" class="table table-hover display pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>CRM Executive Name</th>
                                                        <th>Month - Year</th>
                                                        <th>Total Visits</th>
                                                        <th>Total Enrollments</th>
                                                        <th>Incentive Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                           
                                                            $sql = $obj->query("SELECT id, name FROM $tbl_admin WHERE level_id = 4 and branch_id not in(5,6) $whr ORDER BY id DESC", $debug = -1);
                                                            while ($line = $obj->fetchNextObject($sql)) {
                                                                $res = $obj->fetchNextObject($obj->query("SELECT SUM(amount) AS total, month, year FROM $insentive_calculated WHERE user_id = '{$line->id}' AND month = '$month' AND year = '$year' AND type = 'Counsellor' GROUP BY year, month", $debug = -1));
                                                                $total_visit = $obj->numRows($obj->query("SELECT * from $tbl_visit where councellor_id='{$line->id}' AND month(cdate) = '$month' AND year(cdate) = '$year'", $debug = -1));
                                                                $total_enrollment = $obj->numRows($obj->query("SELECT * from $tbl_visit  as a join $tbl_student as b on  a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no = b.alternate_contact where a.enrollment_counselor='{$line->id}' AND month(a.enrollment_counselor_date) = '$month' AND year(a.enrollment_counselor_date) = '$year'", $debug = -1));
                                                                ?>
                                                    <tr>
                                                        <td><?= $line->id ?></td>
                                                        <td><?= $line->name ?></td>
                                                        <td><?= $res ? date("F", strtotime("1-{$res->month}-{$res->year}")) . " - {$res->year}" : date("F", strtotime("1-{$month}-{$year}")) . ' - ' . $year ?></td>
                                                        <td><?= $total_visit ?></td>
                                                        <td><?= $total_enrollment ?></td>
                                                        <td><?= $res ? number_format($res->total, 2) : "0.00" ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <script src="js/change-status.js"></script>
</body>
<script>
    function form_submit(){
        $("#form-submit").submit();
    }
</script>

</html>