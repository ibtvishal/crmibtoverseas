<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
$whr1 = " and b.cstatus = 'Move to Visa Appointment'";
$whr1 = " and b.cstatus = 'Move to Visa Appointment'";
$join = '';
$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
if($_SESSION['whr1']!=''){
  $whr1 .= $_SESSION['whr1'];
}
if($_SESSION['whr4']!=''){
  $whr3 .= $_SESSION['whr4'];
}
if($_SESSION['join']!=''){
  $join = $_SESSION['join'];
}

?>
<div class="row">
    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1  $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Students</span>
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
                    </div> -->
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1  and c.biometric_date='".date('Y-m-d')."' $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Today's
                                            Biometrics</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1   and c.interview_date='".date('Y-m-d')."' $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Today's
                                            Interviews</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(4)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1   and c.biometric_date > '".date("Y-m-d")."' $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Upcoming Biometrics</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(5)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1   and c.interview_date > '".date("Y-m-d")."' $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Upcoming Interviews</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)" onclick="getAppRecord(6)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a  $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1  and c.interview_date!='' and c.biometric_date!='' and c.biometric_location!='' and c.interview_location!='' $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">All
                                            Booked</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1 and (c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL) $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">All Not
                                            Booked</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(8)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select c.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1  and priority='High'  and ( c.interview_date IS NULL OR c.biometric_date IS NULL OR c.biometric_location IS NULL OR c.interview_location IS NULL) $whr1 group by a.id",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">High
                                            Priority(Not booked) </span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)" onclick="getAppRecord(9)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1 and cstatus IN ('Visa Approved', 'Move to Visa Appointment') $whr3 GROUP BY stu_id HAVING COUNT(DISTINCT cstatus) = 2",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Visa
                                            Approved</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(10)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where 1=1 and cstatus IN ('Visa Refused', 'Move to Visa Appointment') $whr3 GROUP BY stu_id HAVING COUNT(DISTINCT cstatus) = 2;",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Visa
                                            Refused</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(11)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id  where c.final_biometric_status='Not Appeared' $whr1",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Biometric Not
                                            Appeared</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(12)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id where c.final_interview_status='Not Appeared' $whr1",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Interview Not
                                            Appeared</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(13)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id  where c.final_biometric_status='Appeared' $whr1",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Biometric Done</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                    <a href="javascript:void(0)" onclick="getAppRecord(14)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $sql = $obj->query("select a.id from $tbl_student as a $join left join $tbl_appointment as c ON a.id=c.student_id  where c.final_interview_status='Appeared'  $whr1",$debug=-1);
                                                                    $lines=$obj->numRows($sql);
                                                                    echo $totalVisit = $lines;
                                                                 ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Interview Done</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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

</div>
<script>
function form_submit() {
    $("#searchfrm").submit();
}

function getAppRecord(status) {
    $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
    $("#searchfrm").submit();
}
</script>