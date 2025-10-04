<?php
$addtional_role = explode(',', $_SESSION['additional_role']);
$gte = $obj->fetchNextObject($obj->query("SELECT * FROM tbl_admin where status=1 and id='{$_SESSION['sess_admin_id']}'"));
if($gte->status == 0){
    header("location:logout.php");
}
?>
<style>
.containers {
    text-align: center;
    margin: 20px auto;
}

.previews {
    margin-top: 20px;
    width: 240px;
    height: 240px;
    overflow: hidden;
    border-radius: 50%;
    border: 1px solid #ddd;
    margin: 0 auto;
}

#resultCanvas {
    border-radius: 50%;
    background: #f0f0f0;
}

.counter-notification {
    position: relative;
    display: inline-block;
}

.counter-notification-div {
    position: absolute;
    top: 24px;
    right: 8px;
    background: #363e91;
    color: white;
    font-size: xx-small;
    border-radius: 50%;
    height: 12px;
    width: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translate(50%, -50%);
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="mobile-only-brand pull-left">
        <div class="nav-header pull-left">
            <div class="logo-wrap">
                <a href="welcome.php">
                    <img class="brand-img" src="img/logo.svg" alt="brand" style="width: 88px;" />
                </a>
            </div>
        </div>
        <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i
                class="zmdi zmdi-menu"></i></a>

        <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
        <form id="search_form" role="search" class="top-nav-search collapse pull-left" style="width:700px;display:none">
            <?php
            if ($_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role)) { ?>
            <span style="font-size: 18px;color: blue;">
                <?php
                    $branchArr = explode(',', getField('branch_id', $tbl_admin, $_SESSION['sess_admin_id']));
                    foreach ($branchArr as $val) {
                        echo getField('name', $tbl_branch, $val) . " Office OTP : " . getField('office_otp', $tbl_branch, $val) . ", Student OTP : " . getField('student_otp', $tbl_branch, $val);
                        echo "<br>";
                    }

                    ?></span>
            <!-- <input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
                <span class="input-group-btn">
                    <button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
                </span> -->
            <?php } ?>
        </form>
    </div>
    <?php
     $get_note = $obj->query('select * from tbl_note where id=1');
     $res_note = mysqli_fetch_array($get_note);
    ?>
    <marquee behavior="" direction="" style="position: absolute;width: 60%;margin: 20px 10px;z-index:-1;color:red">
        <?=$res_note['note'];?>
    </marquee>
    <div id="mobile_only_nav" class="mobile-only-nav pull-right" style="background: white;">
        <a href="update-notiifcation.php" class="btn btn-primary" style="margin-top: 10px;">Update & Notifications</a>
        <?php
            if ($_SESSION['level_id'] == 1) { ?>
        <button href="javascript:void();" onclick="get_note_modal()" class="btn btn-primary" style="margin-top: 10px;">+
            Add Note</button>
        <?php } ?>
        <ul class="nav navbar-right top-nav mobile-only-nav pull-right">
            <?php
            if ($_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role)) { ?>
            <li class="auth-drp" id="show_otp"><a href="#" onclick="show_otp()"><i class="fa fa-eye"></i> Show OTP</a>
            </li>
            <li class="auth-drp" id="hide_otp" style="display:none"><a href="#" onclick="hide_otp()"><i
                        class="fa fa-eye-slash"></i> Hide OTP</a></li>
            <?php } ?>
            <?php
            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 22 || $_SESSION['level_id'] == 23 || $_SESSION['level_id'] == 24){
                $whr_requires = '';
                if($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 22 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 23){
                    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                    $whr_requires .= " and b.branch_id in ($branchid)";
                    if($_SESSION['level_id'] == 23){
                        $whr_requires .= " and b.visa_id in (2,3,5)";
                    }
                }
                if($_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 24){
                    $whr_requires .= " and b.am_id ='".$_SESSION['sess_admin_id']."'";
                }
                if($_SESSION['level_id'] == 4){
                    $whr_requires .= " and b.c_id  ='".$_SESSION['sess_admin_id']."'";
                }
                $sql_require=$obj->query("select a.id from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id LEFT join $tbl_requirement_notification_seen AS c ON a.id = c.notification_id where 1=1 and a.response_by is null AND (c.status = 0 OR c.status IS NULL) $whr_requires",$debug=-1);
            ?>
            <li class="auth-drp"><a href="request-notification-list.php" class="counter-notification"><img
                        src="img/list.png" style="height: 20px; width: 20px; margin: 25px 0 0px 0px;">
                    <div class="counter-notification-div"><?=$obj->numRows($sql_require)?></div>
                </a></li>
            <?php } ?>
            <li class="auth-drp"><a href="notification-list.php"><img src="img/notification.png"
                        style="height: 20px; width: 20px; margin: 25px 13px 0px 0px;"></a></li>
            <li class="dropdown auth-drp">
                <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"> <span style="margin: 0px 11px 0px 0px;
                font-size: 16px !important;"><?php echo getField('name', $tbl_admin, $_SESSION['sess_admin_id']); ?>
                        (<?= get_user_role($_SESSION['level_id'], getField('director', $tbl_admin, $_SESSION['sess_admin_id'])) ?>)</span>
                    <?php
                    $pimg = getField('img', $tbl_admin, $_SESSION['sess_admin_id']);
                    if (!empty($pimg)) { ?>
                    <img src="uploads/<?php echo $pimg; ?>" alt="user_auth" class="user-auth-img img-circle" />
                    <?php } else { ?>
                    <img src="img/user1.png" alt="user_auth" class="user-auth-img img-circle" />
                    <?php } ?>

                    <span class="user-online-status"></span></a>
                <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                    <?php
                    $phone = getField('phone', $tbl_admin, $_SESSION['sess_admin_id']);
                    $sqls = $obj->query("select * from $tbl_admin where status=1 and phone='$phone' and id!='".$_SESSION['sess_admin_id']."' ORDER BY id DESC ", $debug = -1);
                    if ($obj->numRows($sqls) > 0) {
                        while ($line = $obj->fetchNextObject($sqls)) {
                            ?>
                    <li>
                        <a
                            href="controller.php?change_level_id=<?=base64_encode(base64_encode(base64_encode($line->id))) ?>"><i
                                class="zmdi zmdi-account"></i><span> =>
                                <?=$line->name?> (<?= get_user_role($line->level_id); ?> )</span></a>
                    </li>
                    <?php }
                    } ?>
                    <li>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#imgprofileupload"
                            onclick="userprofileupload(<?php echo $_SESSION['sess_admin_id'] ?>,'profileupload')"><i
                                class="zmdi zmdi-account"></i><span>Change Profile Photo</span></a>
                    </li>
                    <li>
                        <a href="active-log.php"><i class="fas fa-info"></i><span>Active Logs</span></a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<?php
$ibtv = 0;
if (basename($_SERVER['SCRIPT_NAME']) == 'country-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'state-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'univercity-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'branch-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'user-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'stage-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'country-status-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'portal-status-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php' || basename($_SERVER['SCRIPT_NAME']) == 'course-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'portal-status-list') {
    $ibtv = 1;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'search-programmes-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'programmes-list.php') {
    $ibtv = 2;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'search-gap-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'manage-gap-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'programmes-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'gap-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'qualification-list.php') {
    $ibtv = 3;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'diploma-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'institute-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'company-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'designation-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-diploma.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-experience.php') {
    $ibtv = 4;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'category-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'question-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'wikipedia-list.php') {
    $ibtv = 5;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'lead-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'lead-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'followup-lead-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'lead-status-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'lead-remarks-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'visit-lead-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'enrolled-lead-list.php') {
    $ibtv = 6;
} else if (basename($_SERVER['SCRIPT_NAME']) == 'enquiry-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'enquiry-list.php') {
    $ibtv = 7;
} else {
    $ibtv = 0;
}

?>
<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span>Dashboard</span>
            <i class="zmdi zmdi-more"></i>
        </li>
        <?php
        if ($_SESSION['level_id'] != 14 || $_SESSION['level_id'] != 11 || !in_array(6, $addtional_role) || !in_array(1, $addtional_role)) {
            ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome.php') ? 'active-page' : '' ?>"
                href="welcome.php"><i class="zmdi zmdi-landscape mr-20"></i>Dashboard</a>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 9) {
            ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#visit_wps">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Welcome
                        Call</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="visit_wps" class="collapse collapse-level-1">
                <?php
                    if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome-call-admin.php') ? 'active-page' : '' ?>"
                        href="welcome-call-admin.php">WC Admin</a>
                </li>
                <?php } ?>
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome-call-student.php') ? 'active-page' : '' ?>"
                        href="welcome-call-student.php">Welcome Call Students</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome-call-student2.php') ? 'active-page' : '' ?>"
                        href="welcome-call-student2.php">Welcome Call 2 Students</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome-call-issue_raised-student.php') ? 'active-page' : '' ?>"
                        href="welcome-call-issue_raised-student.php">Issue Raised Students</a>
                </li>
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'welcome-call-consultant-student.php') ? 'active-page' : '' ?>"
                        href="welcome-call-consultant-student.php">Consultation Required Students</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 1) {
            ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#visit_wpsw">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Location</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="visit_wpsw" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-state.php') ? 'active-page' : '' ?>"
                        href="lead-state.php">Manage State</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-city.php') ? 'active-page' : '' ?>"
                        href="lead-city.php">Manage District</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-city.php?transfer') ? 'active-page' : '' ?>"
                        href="lead-city.php?transfer">Transfer District</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
        if($_SESSION['level_id'] == 23 || $_SESSION['level_id'] == 24){
            ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list-travel.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php') ? 'active-page' : '' ?>"
                href="student-list-travel.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Student</a>
        </li>
        <?php
        }
        ?>
        <?php
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9 || $_SESSION['sess_admin_id'] == 155){
            ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#website_enquiries">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Website
                        Enquiries</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="website_enquiries" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-new-enquiry.php') ? 'active-page' : '' ?>"
                        href="manage-new-enquiry.php">New Enquiries</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-enquiry.php') ? 'active-page' : '' ?>"
                        href="manage-enquiry.php">Old Enquiries</a>
                </li>
            </ul>
        </li>
        <?php
        }
        ?>
        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9 || in_array(4, $addtional_role) || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25) { ?>
        <li>
            <a <?php if ($ibtv == 6) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#visit_wp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Leads</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="visit_wp" class="collapse collapse-level-1 <?php if ($ibtv == 6) { ?> collapse in <?php } ?>">

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-addf.php') ? 'active-page' : '' ?>"
                        href="lead-addf.php">Add Leads</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-list.php') ? 'active-page' : '' ?>"
                        href="lead-list.php">View Leads</a>
                </li>
                <?php
                    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-today-list.php') ? 'active-page' : '' ?>"
                        href="lead-today-list.php">Today Leads</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'today-expected-visits.php') ? 'active-page' : '' ?>"
                        href="today-expected-visits.php">Today Expected Visit</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-lead-list.php') ? 'active-page' : '' ?>"
                        href="followup-lead-list.php">Followup Leads</a>
                </li>
                <?php
                    if($_SESSION['level_id'] == 1 || in_array(4, $addtional_role) || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-lead-list.php?pending=1') ? 'active-page' : '' ?>"
                        href="followup-lead-list.php?pending=1">Pending Followup Leads (Review)</a>
                </li>
                <?php } ?>
                <?php
                    if ($_SESSION['level_id'] == 1 || in_array(4, $addtional_role)) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-status-list.php') ? 'active-page' : '' ?>"
                        href="lead-status-list.php">Manage Status</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-remarks-list.php') ? 'active-page' : '' ?>"
                        href="lead-remarks-list.php">Manage Remarks</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-lead-list.php') ? 'active-page' : '' ?>"
                        href="visit-lead-list.php">Visit Lead</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'enrolled-lead-list.php') ? 'active-page' : '' ?>"
                        href="enrolled-lead-list.php">Enrolled Lead</a>
                </li>
                <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25) {
                    ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'lead-list.php') ? 'active-page' : '' ?>"
                        href="lead-list.php?transfer">Lead Transfer</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'outbound-call.php') ? 'active-page' : '' ?>"
                        href="outbound-call.php">Outbound Calls Stats</a>
                </li>

                <?php
                }
            ?>
            </ul>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 25) { ?>
        <li>
            <a <?php if ($ibtv == 7) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#enquiry_wp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Visit</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="enquiry_wp" class="collapse collapse-level-1 <?php if ($ibtv == 7) { ?> collapse in <?php } ?>">
                <?php
                    if ($_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-addf.php') ? 'active-page' : '' ?>"
                        href="visit-addf.php">Add Visit</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-list.php') ? 'active-page' : '' ?>"
                        href="visit-list.php">View Visit</a>
                </li>
                <?php if ($_SESSION['level_id'] ==4 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'counselor-target.php') ? 'active-page' : '' ?>"
                        href="counselor-target.php">Counsellor Target</a>
                </li>
                <?php if ($_SESSION['level_id'] ==4 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'expected-enrollment-list.php') ? 'active-page' : '' ?>"
                        href="expected-enrollment-list.php">Today Expected Enrollment</a>
                </li>
                <?php } } ?>
                <?php
                    if ($_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'claim-visit-list.php') ? 'active-page' : '' ?>"
                        href="claim-visit-list.php">Claimed Visit</a>
                </li>
                <?php } ?>
                <?php
                    if ($_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 25) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-visit-list.php') ? 'active-page' : '' ?>"
                        href="followup-visit-list.php">Followup Visit</a>
                </li>
                <?php } ?>
                <?php
                    if($_SESSION['level_id'] == 1 || in_array(4, $addtional_role) || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-visit-list.php?pending=1') ? 'active-page' : '' ?>"
                        href="followup-visit-list.php?pending=1">Pending Followup Visit (Review)</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>

        <?php
        $addtional_role = explode(',', $_SESSION['additional_role']);
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role) || $_SESSION['level_id'] == 13 || in_array(7, $addtional_role) || $_SESSION['level_id'] == 14 || in_array(6, $addtional_role) || in_array(4, $addtional_role) || $_SESSION['level_id'] == 19) { ?>
        <li <?php if ($_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 13 || in_array(7, $addtional_role)) { ?>style="display:none"
            <?php } ?>>
            <a <?php if ($ibtv == 7) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#enquiry_wp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Visit</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="enquiry_wp" class="collapse collapse-level-1 <?php if ($ibtv == 7) { ?> collapse in <?php } ?>">
                <?php if ($_SESSION['level_id'] != 14 || !in_array(6, $addtional_role) || in_array(4, $addtional_role)) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-addf.php') ? 'active-page' : '' ?>"
                        href="visit-addf.php">Add Visit</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-list.php') ? 'active-page' : '' ?>"
                        href="visit-list.php">View Visit</a>
                </li>
                <?php if ($_SESSION['level_id'] ==1 ) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'expected-enrollment-list.php') ? 'active-page' : '' ?>"
                        href="expected-enrollment-list.php">Today Expected Enrollment</a>
                </li>
                <?php } ?>

                <?php if ($_SESSION['level_id'] != 14 || !in_array(6, $addtional_role) || in_array(4, $addtional_role)) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-visit-list.php') ? 'active-page' : '' ?>"
                        href="followup-visit-list.php">Followup Visit</a>
                </li>
                <?php } ?>
                <?php
                    if($_SESSION['level_id'] == 1 || in_array(4, $addtional_role) || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'followup-visit-list.php?pending=1') ? 'active-page' : '' ?>"
                        href="followup-visit-list.php?pending=1">Pending Followup Visit (Review)</a>
                </li>
                <?php
                    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'counselor-target.php') ? 'active-page' : '' ?>"
                        href="counselor-target.php">Counsellor Target</a>
                </li>
                <?php } } ?>
                <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){
            ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-management-member.php') ? 'active-page' : '' ?>"
                        href="visit-management-member.php">Management Meet</a>
                </li> -->
                <?php
        }
        ?>
                <?php
                    if ($_SESSION['level_id'] == 1 || in_array(4, $addtional_role) || $_SESSION['level_id'] == 19) {
                        ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'claim-visit-list.php') ? 'active-page' : '' ?>"
                        href="claim-visit-list.php">Claimed Visit</a>
                </li>
                <?php } ?>
                <?php
                        if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-status-list.php') ? 'active-page' : '' ?>"
                        href="visit-status-list.php">Manage Status</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visit-remarks-list.php') ? 'active-page' : '' ?>"
                        href="visit-remarks-list.php">Manage Remarks</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-visa-sub-type.php') ? 'active-page' : '' ?>"
                        href="manage-visa-sub-type.php">Manage Payment Type</a>
                </li>
                <?php } ?>


            </ul>

        <li <?php if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 13 || in_array(7, $addtional_role) || $_SESSION['level_id'] == 19) {
                echo '';
            } else { ?> style="display:none" <?php } ?>>
            <a <?php if ($ibtv == 7) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#enquiry_wpd_pending">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Pending
                        Enrollments</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="enquiry_wpd_pending"
                class="collapse collapse-level-1 <?php if ($ibtv == 7) { ?> collapse in <?php } ?>">
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 13 || in_array(6, $addtional_role) || $_SESSION['level_id'] == 19) {
                        ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'pending-enrollment.php') ? 'active-page' : '' ?>"
                        href="pending-enrollment.php">Pending Enrollment Verification</a>
                </li>

                <?php
                    } ?>
            </ul>
        </li>
        <li <?php if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 13 || in_array(7, $addtional_role) || $_SESSION['level_id'] == 14 || in_array(6, $addtional_role) || $_SESSION['level_id'] == 19) {
                echo '';
            } else { ?>style="display:none" <?php } ?>>
            <a <?php if ($ibtv == 7) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#enquiry_wpd">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Financial
                        By Passed</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="enquiry_wpd" class="collapse collapse-level-1 <?php if ($ibtv == 7) { ?> collapse in <?php } ?>">
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 14 || in_array(6, $addtional_role) || $_SESSION['level_id'] == 19) {
                        ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-registration-fee.php') ? 'active-page' : '' ?>"
                        href="manage-registration-fee.php">Registered Students</a>
                </li> -->
                <?php
                        if ($_SESSION['level_id'] == 1) {
                            ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-fee.php') ? 'active-page' : '' ?>"
                        href="manage-fee.php">Enrolled Students</a>
                </li> -->
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-reapply-fee.php') ? 'active-page' : '' ?>"
                        href="manage-reapply-fee.php">Reapplied Students</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-after-visa-fee.php') ? 'active-page' : '' ?>"
                        href="manage-after-visa-fee.php">After Visa Students</a>
                </li> -->

                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-visa-sub-type.php') ? 'active-page' : '' ?>"
                        href="manage-visa-sub-type.php">Manage Payment Type</a>
                </li> -->


                <?php }
                ?>
                <?php
                        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4) {
                            ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-enrolled-fee.php') ? 'active-page' : '' ?>"
                        href="manage-enrolled-fee.php">Manage Fee</a>
                </li> -->
                <?php }
                    ?>
                <?php
                    } ?>

                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 13 || in_array(7, $addtional_role) || $_SESSION['level_id'] == 14 || in_array(6, $addtional_role) || $_SESSION['level_id'] == 19) {
                    // if ($_SESSION['level_id'] == 1) {
                        ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-fee-report.php') ? 'active-page' : '' ?>"
                        href="manage-fee-report.php">Manage Report</a>
                </li> -->

                <?php } ?>
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14) {
                    ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'financial-approval.php?pending') ? 'active-page' : '' ?>"
                        href="financial-approval.php?pending">Financial By Passed</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        </li>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14) {
        ?>
        <li>
            <!-- <a aria-expanded="false" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps1">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span
                        class="right-nav-text">Franchise</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a> -->
            <ul id="dashboard_wps1" class="collapse collapse-level-1 ">
                <?php
                if($_SESSION['level_id'] == 1){
                    $get_fra_branch = $obj->query("select * from $tbl_branch where franchise_bill=1 and status=1");
                    while($res_fra_branch = $obj->fetchNextObject($get_fra_branch)){
                    ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'franchise-admin-branch.php') ? 'active-page' : '' ?>"
                        href="franchise-admin-branch.php?branch_id=<?=base64_encode(base64_encode(base64_encode($res_fra_branch->id)))?>"><?=$res_fra_branch->name?>
                        Franchise Admin</a>
                </li>
                <?php
                    }
                    ?>
                <!-- <li>
                        <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'franchise-admin.php') ? 'active-page' : '' ?>"
                            href="franchise-admin.php">Franchise Admin</a>
                    </li> -->
                <?php
                }
                ?>
                <?php
                    if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14) {
                        $b_con = '';
                        if ($_SESSION['level_id'] != 1) {
                            $branch_id = getField('branch_id', $tbl_admin, $_SESSION['sess_admin_id']);
                            $b_con = " and id in ($branch_id)";
                        }
                        $branchSql = $obj->query("select * from $tbl_branch where status=1 and show_franchises=1 $b_con");
                        $cou = $obj->numRows($branchSql);
                        if ($cou > 0 || $_SESSION['level_id'] == 1) {
                            ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'franchise-bill.php') ? 'active-page' : '' ?>"
                        href="franchise-bill.php">Franchise Bill</a>
                </li>

                <?php }
                ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'financial-approval.php') ? 'active-page' : '' ?>"
                        href="financial-approval.php">Financial Approval</a>
                </li> -->

                <?php
                    } ?>

            </ul>
        </li>
        <?php
            }
            ?>
        <?php
        if ($_SESSION['level_id'] == 1 || in_array(3, $addtional_role) || $_SESSION['level_id'] == 10 || $_SESSION['level_id'] == 12 || $_SESSION['level_id'] == 15 || $_SESSION['level_id'] == 16 || $_SESSION['level_id'] == 17 || in_array(9, $addtional_role) || $_SESSION['level_id'] == 18 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 32 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || $_SESSION['level_id'] == 11 || $_SESSION['level_id'] == 31 || in_array(1, $addtional_role) || $_SESSION['sess_admin_id'] == 73 || $_SESSION['level_id'] == 33 || $_SESSION['level_id'] == 34) {
            ?>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 18 || $_SESSION['level_id'] == 31 || in_array(9, $addtional_role) || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 32 || $_SESSION['sess_admin_id'] == 73 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || $_SESSION['level_id'] == 33 || $_SESSION['level_id'] == 34) {
        ?>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 18 || in_array(10, $addtional_role) || in_array(9, $addtional_role)) {
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php') ? 'active-page' : '' ?>"
                href="student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Student</a>
        </li>
        <?php
         }
         ?>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 32 || $_SESSION['level_id'] == 33 || $_SESSION['level_id'] == 34) {
        ?>
        <li>
            <a aria-expanded="false" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps-1">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Classes</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wps-1" class="collapse collapse-level-1">
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 32){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-interview-list.php') ? 'active-page' : '' ?>"
                        href="student-interview-list.php">Interview Preparation</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 33){
                    ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-duolingo-list.php') ? 'active-page' : '' ?>"
                        href="student-duolingo-list.php">Duolingo</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 31 || $_SESSION['level_id'] == 34){
                    ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-spoken-list.php') ? 'active-page' : '' ?>"
                        href="student-spoken-list.php">Spoken</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['sess_admin_id'] == 73 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8) {
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-ds-160.php') ? 'active-page' : '' ?>"
                href="student-ds-160.php"><i class="zmdi zmdi-landscape mr-20"></i>DS-160 Verification</a>
        </li>
        <?php } ?>
        <?php
        if($_SESSION['level_id'] == 25){
            ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-review-list.php') ? 'active-page' : '' ?>"
                href="student-review-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Review Student</a>
        </li>
        <?php
        }
        ?>
        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role)) {
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'application-list.php') ? 'active-page' : '' ?>"
                href="application-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Application</a>
        </li>
        <?php } } ?>

        <?php
         if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25) {
        ?>
        <li>
            <a aria-expanded="false" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Admission
                        Load</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wps" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-admission-load.php') ? 'active-page' : '' ?>"
                        href="manage-admission-load.php">New Admission Load</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-defer-admission-load.php') ? 'active-page' : '' ?>"
                        href="manage-defer-admission-load.php">Defer & Refused Admission Load</a>
                </li>

            </ul>
        </li>
        <?php
            }
            ?>
        <?php
            if($_SESSION['level_id'] == 1 || in_array(9, $addtional_role) || $_SESSION['level_id'] == 18){ ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps11">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Affidavit</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wps11" class="collapse collapse-level-1 ">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'filling_noc_issued.php') ? 'active-page' : '' ?>"
                        href="filling_noc_issued.php">Affidavit Verification 1</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'filling_noc_issued.php?second') ? 'active-page' : '' ?>"
                        href="filling_noc_issued.php?second">Affidavit Verification 2</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'filling_noc_issued.php?pending') ? 'active-page' : '' ?>"
                        href="filling_noc_issued.php?pending">Affidavit By Passed</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
            if (in_array(3, $addtional_role) || $_SESSION['level_id'] == 10 || $_SESSION['level_id'] == 12 || $_SESSION['level_id'] == 12 || $_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 15 || $_SESSION['level_id'] == 16 || $_SESSION['level_id'] == 17 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || in_array(10, $addtional_role) || $_SESSION['level_id'] == 32 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role)) {
                 ?>
        <?php
                if (in_array(3, $addtional_role) || $_SESSION['level_id'] == 10 || $_SESSION['level_id'] == 12 || $_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19) { ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'slot-student-list.php') ? 'active-page' : '' ?>"
                href="slot-student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Slot Student</a>
        </li>
        <?php
                }
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 17 || $_SESSION['level_id'] == 15 || $_SESSION['level_id'] == 16 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || in_array(10, $addtional_role)) { ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps1s11">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Visa
                        Approved</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wps1s11" class="collapse collapse-level-1 ">

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-visa-approved.php') ? 'active-page' : '' ?>"
                        href="student-visa-approved.php">View Student</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-visa-approved-enrollment.php') ? 'active-page' : '' ?>"
                        href="student-visa-approved-enrollment.php">View Details</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-visa-approved-enrollment.php?passport') ? 'active-page' : '' ?>"
                        href="student-visa-approved-enrollment.php?passport">Passport Status</a>
                </li>

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-refund.php') ? 'active-page' : '' ?>"
                        href="student-refund.php">Refund Students</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'embessy-report.php') ? 'active-page' : '' ?>"
                        href="embessy-report.php">Embessy Report</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'university-report.php') ? 'active-page' : '' ?>"
                        href="university-report.php">University Report</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'university-transfer.php') ? 'active-page' : '' ?>"
                        href="university-transfer.php">University Transfer</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4) { ?>

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wp1_uk">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Visa
                        Status- UK</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wp1_uk" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'uk-visa-approved.php') ? 'active-page' : '' ?>"
                        href="uk-visa-approved.php">Approved </a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'uk-visa-refused.php') ? 'active-page' : '' ?>"
                        href="uk-visa-refused.php">Refused </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 35) { ?>

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_commission">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span
                        class="right-nav-text">Commission</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_commission" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'commission-student.php') ? 'active-page' : '' ?>"
                        href="commission-student.php">Manage Commission</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 15 || $_SESSION['level_id'] == 16) { ?>
        <!-- <li>
              <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-visa-approved.php') ? 'active-page' : '' ?>"
              href="student-visa-approved.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Students</a>
            </li>
              <li>
                <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-visa-approved-enrollment.php') ? 'active-page' : '' ?>"
                    href="student-visa-approved-enrollment.php"><i class="zmdi zmdi-landscape mr-20"></i>Visa Approved</a>
            </li> -->
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role) || $_SESSION['level_id'] == 19 || in_array(10, $addtional_role) || $_SESSION['level_id'] == 32) { ?>

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wp1">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span
                        class="right-nav-text">Videos</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wp1" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'application-videos.php') ? 'active-page' : '' ?>"
                        href="application-videos.php">University Application Videos </a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'filing-videos.php') ? 'active-page' : '' ?>"
                        href="filing-videos.php">Filing Videos </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19) { ?>

        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wpp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Policy</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wpp" class="collapse collapse-level-1">
                <?php
                            if ($_SESSION['level_id'] == 1) {
                                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'policy-category-list.php') ? 'active-page' : '' ?>"
                        href="policy-category-list.php">Manage Category</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'subcategory-list.php') ? 'active-page' : '' ?>"
                        href="policy-subcategory-list.php">Manage Sub Category</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'policy-question-list.php') ? 'active-page' : '' ?>"
                        href="policy-question-list.php">Manage Question</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'policy-list.php') ? 'active-page' : '' ?>"
                        href="policy-list.php">Policy List</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php }
            if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25) { ?>
        <li>
            <a <?php if ($ibtv == 2) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#dashboard_sp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span
                        class="right-nav-text">Courses</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_sp" class="collapse collapse-level-1 <?php if ($ibtv == 2) { ?> collapse in <?php } ?>">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'search-programmes-list.php') ? 'active-page' : '' ?>"
                        href="search-programmes-list.php">Search Courses</a>
                </li>
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'programmes-list.php') ? 'active-page' : '' ?>"
                        href="programmes-list.php">Manage Courses</a>
                </li>
                <?php } ?>
            </ul>
        </li>


        <!--  <li>
            <a <?php if ($ibtv == 3) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#dashboard_sg">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Find Gap
                        Setting</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_sg" class="collapse collapse-level-1 <?php if ($ibtv == 3) { ?> collapse in <?php } ?>">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'search-gap-list.php') ? 'active-page' : '' ?>"
                        href="search-gap-list.php">Search Gap/Diploma</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'gap-list.php') ? 'active-page' : '' ?>"
                        href="gap-list.php">Find Gap/Diploma</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'qualification-list.php') ? 'active-page' : '' ?>"
                        href="qualification-list.php">Manage Qualification</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-gap-list.php') ? 'active-page' : '' ?>"
                        href="manage-gap-list.php">Manage Duration</a>
                </li>

            </ul>
        </li> -->
        <!--  <li>
            <a <?php if ($ibtv == 4) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#dashboard_gs">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Gap
                        Setting</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_gs" class="collapse collapse-level-1 <?php if ($ibtv == 4) { ?> collapse in <?php } ?>">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'diploma-list.php') ? 'active-page' : '' ?>"
                        href="diploma-list.php">Manage Diploma Name </a>
                </li>

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'institute-list.php') ? 'active-page' : '' ?>"
                        href="institute-list.php">Manage Institute Name </a>
                </li>

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'company-list.php') ? 'active-page' : '' ?>"
                        href="company-list.php">Manage Company </a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'designation-list.php') ? 'active-page' : '' ?>"
                        href="designation-list.php">Manage Designation Name </a>
                </li>

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-diploma.php') ? 'active-page' : '' ?>"
                        href="student-diploma.php">Manage Student Diploma </a>
                </li>

                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-experience.php') ? 'active-page' : '' ?>"
                        href="student-experience.php">Manage Student Experience </a>
                </li>
            </ul>
        </li> -->
        <?php }
        } ?>
        <?php
         if ($_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21 || $_SESSION['level_id'] == 25) {
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'request-notification-list.php') ? 'active-page' : '' ?>"
                href="request-notification-list.php"><i class="zmdi zmdi-landscape mr-20"></i> Requirement Module</a>
        </li>
        <?php
         }
         if ($_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 23) {
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'financial-approval.php?pending') ? 'active-page' : '' ?>"
                href="financial-approval.php?pending"><i class="zmdi zmdi-landscape mr-20"></i> Financial By Passed</a>
        </li>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'filling_noc_issued.php?pending') ? 'active-page' : '' ?>"
                href="filling_noc_issued.php?pending"><i class="zmdi zmdi-landscape mr-20"></i> Affidavit By Passed</a>
        </li>
        <?php
            }
            ?>
        <?php
        if ($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 23 || $_SESSION['level_id'] == 24) { ?>
        <?php
            // if($_SESSION['level_id']==2 || $_SESSION['level_id']==3){
            if ($_SESSION['level_id'] == 1) {
                ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php') ? 'active-page' : '' ?>"
                href="student-addf.php"><i class="zmdi zmdi-landscape mr-20"></i> Add Student</a>
        </li>
        <?php }
        if($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 4){
        ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php') ? 'active-page' : '' ?>"
                href="student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Student</a>
        </li>
        <?php
        }
            if ($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3) {
                ?>
        <li>
            <a aria-expanded="false" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wps">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Admission
                        Load</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wps" class="collapse collapse-level-1 <?php if ($ibtv == 5) { ?> collapse in <?php } ?>">
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-admission-load.php') ? 'active-page' : '' ?>"
                        href="manage-admission-load.php">New Admission Load</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-defer-admission-load.php') ? 'active-page' : '' ?>"
                        href="manage-defer-admission-load.php">Defer & Refused Admission Load</a>
                </li>

            </ul>
        </li>
        <?php } ?>
        <?php
            if ($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 4) {
                ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'application-list.php') ? 'active-page' : '' ?>"
                href="application-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Application</a>
        </li>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'search-programmes-list.php') ? 'active-page' : '' ?>"
                href="search-programmes-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Search programmes</a>
        </li>

        <?php } ?>
        <!-- <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'search-gap-list.php') ? 'active-page' : '' ?>"
                href="search-gap-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Search Gap/Diploma</a>
        </li> -->

        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 5 || $_SESSION['level_id'] == 6) { ?>
        <!-- <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-diploma.php') ? 'active-page' : '' ?>"
                href="student-diploma.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Diploma</a>
        </li>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-experience.php') ? 'active-page' : '' ?>"
                href="student-experience.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Experience</a>
        </li> -->
        <?php } else if ($_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || in_array(6, $addtional_role) || $_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 17) { ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php') ? 'active-page' : '' ?>"
                href="student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Student</a>
        </li>
        <?php
                if ($_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8) {
                    ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'application-list.php') ? 'active-page' : '' ?>"
                href="application-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Application</a>
        </li>
        <?php }
        } ?>





        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 18 || $_SESSION['level_id'] == 10 || $_SESSION['level_id'] == 12 || $_SESSION['level_id'] == 15 || in_array(9, $addtional_role)) { ?>
        <li>
            <a <?php if ($ibtv == 7) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#enquiry_wpa">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Manage
                        Download</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="enquiry_wpa" class="collapse collapse-level-1 <?php if ($ibtv == 7) { ?> collapse in <?php } ?>">
                <?php
                    if ($_SESSION['level_id'] == 1) {
                        ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-download-category.php') ? 'active-page' : '' ?>"
                        href="manage-download-category.php">Manage Category</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-download-subcategory.php') ? 'active-page' : '' ?>"
                        href="manage-download-subcategory.php">Manage Subcategory</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'manage-file.php') ? 'active-page' : '' ?>"
                        href="manage-file.php">Manage File</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'download-section.php') ? 'active-page' : '' ?>"
                        href="download-section.php">Download Section</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 2 && in_array(3, $addtional_role)) {
            ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == '' ? 'active-page' : '' ?>"
                href="manage-review.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Review</a>
        </li>
        <?php } ?>
        <?php
        if (in_array(8, $addtional_role)) {
            ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'user-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'user-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'user-list.php') ? 'active-page' : '' ?>"
                href="user-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage User</a>
        </li>
        <?php } ?>
        <?php if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25) { ?>
        <li>


            <a <?php if ($ibtv == 1) { ?> class="active" aria-expanded="true" <?php } ?> href="javascript:void(0);"
                data-toggle="collapse" data-target="#dashboard_dr">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Admin
                        Setting</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_dr" class="collapse collapse-level-1 <?php if ($ibtv == 1) { ?> collapse in <?php } ?>">
                <?php if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'country-list.php') ? 'active-page' : '' ?>"
                        href="country-list.php">Manage Country</a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'state-list.php') ? 'active-page' : '' ?>"
                        href="state-list.php">Manage State</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'univercity-list.php') ? 'active-page' : '' ?>"
                        href="univercity-list.php">Manage University</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'course-list.php') ? 'active-page' : '' ?>"
                        href="course-list.php">Manage Course</a>
                </li>
                <?php if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'branch-list.php') ? 'active-page' : '' ?>"
                        href="branch-list.php">Manage Branch</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'department-list.php') ? 'active-page' : '' ?>"
                        href="department-list.php">Manage Department</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'support-user-list.php') ? 'active-page' : '' ?>"
                        href="support-user-list.php">Manage Support User</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'user-list.php') ? 'active-page' : '' ?>"
                        href="user-list.php">Manage User</a>
                </li>
                <?php } ?>
                <!-- <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'user-list.php') ? 'active-page' : '' ?>"
                        href="user-list.php?account">Manage Review Managers</a>
                </li> -->
                <?php if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'stage-list.php') ? 'active-page' : '' ?>"
                        href="stage-list.php">Manage Stage</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'country-status-list.php') ? 'active-page' : '' ?>"
                        href="country-status-list.php">Manage Application Status </a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'portal-status-list.php') ? 'active-page' : '' ?>"
                        href="portal-status-list.php">Manage Application Portal </a>
                </li>
                <?php if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php') ? 'active-page' : '' ?>"
                        href="student-addf.php">Add Student </a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list.php') ? 'active-page' : '' ?>"
                        href="student-list.php?transfer=<?php echo base64_encode(base64_encode(base64_encode(1))); ?>">Manage
                        Student Transfer</a>
                </li>
                <?php if ($_SESSION['level_id'] == 1) { ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'slot-agent.php') ? 'active-page' : '' ?>"
                        href="slot-agent.php">Manage Slot Agent</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'request-module-field.php') ? 'active-page' : '' ?>"
                        href="request-module-field.php">Manage Request Module</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'enrollment-setting.php') ? 'active-page' : '' ?>"
                        href="enrollment-setting.php">Report Graph Setting</a>
                </li>
                <?php } ?>
            </ul>
        </li>

        <?php
        }
        ?>
        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 ) { ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_drs">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Social
                        Media Stats</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_drs" class="collapse collapse-level-1 ">
                <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25) { ?>

                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'manage-report.php' ? 'active-page' : '' ?>"
                        href="manage-report.php">Counsellor Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'source-report.php' ? 'active-page' : '' ?>"
                        href="source-report.php">Source Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'location-report.php' ? 'active-page' : '' ?>"
                        href="location-report.php">Location Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'common-branch-report.php' ? 'active-page' : '' ?>"
                        href="common-branch-report.php">Common Branch Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'funding-report.php' ? 'active-page' : '' ?>"
                        href="funding-report.php">Funding Report (Student)</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'funding-report-counsellor.php' ? 'active-page' : '' ?>"
                        href="funding-report-counsellor.php">Funding Report (Counsellor)</a>
                </li>
                <?php } ?>
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 9){
                ?>
                <!-- <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'crm-executive-report.php' ? 'active-page' : '' ?>"
                        href="crm-executive-report.php">CRM Executive Report</a>
                </li> -->
                <?php } ?>
                <!-- <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'lead-source-report.php' ? 'active-page' : '' ?>"
                        href="lead-source-report.php">Lead Source Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'visit-source-report.php' ? 'active-page' : '' ?>"
                        href="visit-source-report.php">Visit Source Report</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'enrollment-source-report.php' ? 'active-page' : '' ?>"
                        href="enrollment-source-report.php">Enrollment Source Report</a>
                </li> -->
            </ul>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role)) { ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_drs1">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Management
                        Meet</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_drs1" class="collapse collapse-level-1 -">
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'visit-management-member.php' ? 'active-page' : '' ?>"
                        href="visit-management-member.php">New Visit</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'student-management-member.php' ? 'active-page' : '' ?>"
                        href="student-management-member.php">Enrolled Students</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 26) { ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'visa-approved-media.php') ? 'active-page' : '' ?>"
                href="visa-approved-media.php"><i class="zmdi zmdi-landscape mr-20"></i>Visa Approved</a>
        </li>
        <?php } ?>
        <?php
        if ($_SESSION['level_id'] == 10 || $_SESSION['level_id'] == 11) { ?>
        <li>
            <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'student-list.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-addf.php' || basename($_SERVER['SCRIPT_NAME']) == 'student-editf.php') ? 'active-page' : '' ?>"
                href="student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Manage Student</a>
        </li>
        <?php } ?>


        <?php
        if ($_SESSION['level_id'] == 22 && in_array(2, $addtional_role)) { ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'review-student-list.php' ? 'active-page' : '' ?>"
                href="review-student-list.php"><i class="zmdi zmdi-landscape mr-20"></i>Review Student</a>
        </li>
        <?php } ?>
        <?php
        $get = $obj->query("SELECT * FROM $tbl_btn_click where date(`date`) = '".date('Y-m-d')."'");
        if ($_SESSION['level_id'] == 1 && $obj->numRows($get) == 0) { ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'update-appointment-data.php' ? 'active-page' : '' ?>"
                href="update-appointment-data.php"><i class="zmdi zmdi-landscape mr-20"></i>Update Appointment</a>
        </li>
        <?php } ?>

        <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 9) { ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_drs1s">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Incentive
                        Report</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_drs1s" class="collapse collapse-level-1 ">
                <?php
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 9) { ?>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'crm-incentive.php' ? 'active-page' : '' ?>"
                        href="crm-incentive.php">CRM Incetives</a>
                </li>
                <?php
        }
        if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4) { ?>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'counsellor-incentive.php' ? 'active-page' : '' ?>"
                        href="counsellor-incentive.php">Counsellor Incetives</a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <?php
                if ($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 7 || $_SESSION['level_id'] == 8 || $_SESSION['level_id'] == 11 || in_array(1, $addtional_role) || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 32) { ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_wp">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">USA
                        Wikkipedia</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="dashboard_wp" class="collapse collapse-level-1">
                <?php
                            if ($_SESSION['level_id'] == 1) {
                                ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'category-list.php') ? 'active-page' : '' ?>"
                        href="category-list.php">Manage Category </a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'subcategory-list.php') ? 'active-page' : '' ?>"
                        href="subcategory-list.php">Manage Sub Category</a>
                </li>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'question-list.php') ? 'active-page' : '' ?>"
                        href="question-list.php">Manage Question </a>
                </li>
                <?php } ?>
                <li>
                    <a class="<?php echo (basename($_SERVER['SCRIPT_NAME']) == 'wikipedia-list.php') ? 'active-page' : '' ?>"
                        href="wikipedia-list.php">FAQ USA Wikipedia</a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php
        if($_SESSION['level_id'] != 1){
            ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'support-users.php' ? 'active-page' : '' ?>"
                href="support-users.php"><i class="zmdi zmdi-landscape mr-20"></i>Support Users</a>
        </li>
        <?php
        }
        ?>
        <?php
        if($_SESSION['level_id'] == 1){
            ?>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#studashboard_drs1">
                <div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Student
                        Dashboard</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="studashboard_drs1" class="collapse collapse-level-1">
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'event-list.php' ? 'active-page' : '' ?>"
                        href="event-list.php">Manage Events</a>
                </li>
                <li>
                    <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'video-list.php' ? 'active-page' : '' ?>"
                        href="video-list.php">Manage Videos</a>
                </li>
            </ul>
        </li>
        <?php
        }
        ?>
        <?php
        if($_SESSION['level_id'] == 1){
            ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'google-sheet.php' ? 'active-page' : '' ?>"
                href="google-sheet.php"><i class="zmdi zmdi-landscape mr-20"></i>Google Sheet</a>
        </li>
        <?php } ?>
        <?php
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25){
            ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'uk-package.php' ? 'active-page' : '' ?>"
                href="uk-package.php"><i class="zmdi zmdi-landscape mr-20"></i>Package Calculator</a>
        </li>
        <?php } ?>
        <?php
        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4){
            ?>
        <li>
            <a class="<?php echo basename($_SERVER['SCRIPT_NAME']) == 'incentive-calculator.php' ? 'active-page' : '' ?>"
                href="incentive-calculator.php"><i class="zmdi zmdi-landscape mr-20"></i>Incetive Plan</a>
        </li>
        <?php } ?>
    </ul>
</div>
<div class="right-sidebar-backdrop"></div>

<div class="modal fade" id="imgprofileupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="containers">
                    <h3>Select Profile Image</h3>
                    <input type="file" id="imageInput" accept="image/*">
                    <div>
                        <img id="image" style="max-width: 100%; display: none;" />
                    </div>
                    <button id="cropButton" class="btn btn-primary" disabled>Crop & Save</button>
                    <div class="previews" style="display:none">
                        <canvas id="resultCanvas" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>