<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
$today_date = date("Y-m-d");
$addtional_role = explode(',',$_SESSION['additional_role']);
$tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
$condition_of_visa_sub_type = " and c.enrollment_count=1";
if(isset($_POST['today_performance'])){
   
                    if($_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259){
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $condition = " and date(a.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition1 = " and date(a.enrollment_counselor_date) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition2 = " and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $from_date = $_POST['from_date'];
                            $to_date = $_POST['to_date'];
                        }else{
                            $condition = " and date(a.cdate)='$today_date'";
                            $condition1 = " and date(a.enrollment_counselor_date)='$today_date'";
                            $condition2 = " and a.visit_status='Enrolled' and date(a.enrollment_counselor_date)='$today_date'";
                            $from_date = $today_date;
                            $to_date = $today_date;
                        }
                        if($_SESSION['level_id'] == 4){
                            $condition .= " and a.councellor_id='".$_SESSION['sess_admin_id']."'";
                            $condition1 .= " and a.councellor_id='".$_SESSION['sess_admin_id']."'";
                            $condition2 .= " and a.councellor_id='".$_SESSION['sess_admin_id']."'";
                        }elseif($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259){
                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                            $condition .= " and a.branch_id='$branch_id'";
                            $condition1 .= " and a.branch_id='$branch_id'";
                            $condition2 .= " and a.branch_id='$branch_id'";
                        }
                        ?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
        <?=$_POST['perform']?>
        <?=$_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259 ? 'Branch ': ''?>Performance</h5>
    <?php
                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259){
                        ?>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select count(a.id) as num_rows from $tbl_lead as a where 1=1 $condition",$debug=-1);
                                                                        $linem1=$obj->fetchNextObject($appsql1);
                                                                        echo $linem1->num_rows;
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13"
                                            onclick="go_url('lead-list.php','<?=$branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_lead')">Leads</span>
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
    <?php } ?>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select count(a.id) as num_rows from $tbl_visit as a where 1=1 $condition",$debug=-1);
                                                                        $linem1=$obj->fetchNextObject($appsql1);
                                                                        echo $linem1->num_rows;
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13"
                                            onclick="go_url('visit-list.php','<?=$branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_visit')">Visits</span>
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
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select count(a.id) as num_rows from $tbl_visit as a $tbl_visa_sub_type_join where 1=1 and a.visit_status in ('Registered','Register') $condition1 $condition_of_visa_sub_type",$debug=-1);
                                                                        $linem1=$obj->fetchNextObject($appsql1);
                                                                        echo $linem1->num_rows;
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13"
                                            onclicks="go_url('manage-registration-fee.php','<?=$branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_registration')">Registrations</span>
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
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select count(a.id) as num_rows from $tbl_visit as a $tbl_visa_sub_type_join where 1=1 and a.visit_status='Enrolled' $condition1 $condition_of_visa_sub_type",$debug=-1);
                                                                        $linem1=$obj->fetchNextObject($appsql1);
                                                                        echo $linem1->num_rows;
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13"
                                            onclicks="go_url('manage-fee.php','<?=$branch_id?>','','<?=$from_date?>','<?=$to_date?>')">Enrollments</span>
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
<?php
                    }
                    ?>

<!-- CRM EXECUTIVE TODAY PERFORMANCE -->
<?php
                    if($_SESSION['level_id'] == 9){
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $condition = " and date(a.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition1 = " and b.enquiry_type!='Re-apply' and date(b.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition2 = " and date(b.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $from_date = $_POST['from_date'];
                            $to_date = $_POST['to_date'];
                        }else{
                        $condition = " and date(a.cdate)='$today_date'";
                        $condition1 = " and b.enquiry_type!='Re-apply' and date(b.cdate)='$today_date'";
                        $condition2 = " and date(b.cdate)='$today_date'";
                        $from_date = $today_date;
                            $to_date = $today_date;
                        }
                        ?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
        <?=$_POST['perform']?> Performance</h5>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                $total = 0;
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_lead as a where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $condition group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Leads</span>
                                    </a>
                                    <?php
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p
                                        onclick="go_url('list-list.php','<?=$linem1->branch_id?>','<?=$_SESSION['sess_admin_id']?>','<?=$from_date?>','<?=$to_date?>')">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $condition1 group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13"
                                            onclick="go_url('list-list.php','<?=$linem1->branch_id?>','<?=$_SESSION['sess_admin_id']?>','<?=$from_date?>','<?=$to_date?>')">Visits</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p><?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_lead as a join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no ) where 1=1 and a.crm_executive_id='".$_SESSION['sess_admin_id']."' $condition2 group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Enrollments</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p><?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
<?php
                    }
                    ?>
<?php
                    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $condition = " and date(a.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition1 = " and a.visit_status='Enrolled' and date(a.enrollment_counselor_date) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition2 = " and date(a.visit_status_date) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $from_date = $_POST['from_date'];
                            $to_date = $_POST['to_date'];
                        }else{
                        $condition = " and date(a.cdate)='$today_date'";
                        $condition1 = " and a.visit_status='Enrolled'  and date(a.enrollment_counselor_date)='$today_date'";
                        $condition2 = "  and date(a.visit_status_date)='$today_date'";
                        $from_date = date("Y-m-d");
                        $to_date = date("Y-m-d");
                        }
                        ?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
        <?=$_POST['perform']?> Performance</h5>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_lead as a where 1=1 $condition group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Leads</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p style="cursor:pointer"
                                        onclick="go_urls('lead-list.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_lead')">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_visit as a where 1=1  and a.enquiry_type!='Re-apply' $condition group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Visits</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                       $total += $linem1->total;
                                                        ?>
                                    <p style="cursor:pointer"
                                        onclick="go_urls('visit-list.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_visit')">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_visit as a $tbl_visa_sub_type_join where 1=1 and a.visit_status in ('Registered','Register') $condition2 $condition_of_visa_sub_type group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Registration</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p style="cursor:pointer"
                                        onclicks="go_urls('manage-registration-fee.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_registration')">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_visit as a $tbl_visa_sub_type_join where 1=1 and a.visit_status='Enrolled' $condition1 $condition_of_visa_sub_type group by a.branch_id",$debug=-1);
                                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Enrollment</span>
                                    </a>
                                    <?php
                                                    $total = 0;
                                                    while($linem1=$obj->fetchNextObject($appsql1)){
                                                        $total += $linem1->total;
                                                        ?>
                                    <p style="cursor:pointer"
                                        onclicks="go_urls('manage-fee.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_enrollment')">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                    }
                                                    ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
                    }
                    if($_SESSION['level_id'] == 3){
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $condition = " and date(cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition1 = " and profile_accessed_date between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                        }else{
                        $condition = " and date(cdate)='$today_date'";
                        $condition1 = " and profile_accessed_date='$today_date'";
                        }
                        ?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
        <?=$_POST['perform']?> Performance</h5>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                            $appsql1 = $obj->query("select id as num_rows from $tbl_student where 1=1 $condition1 and am_id='{$_SESSION['sess_admin_id']}' and profile_accessed=1",$debug=-1);
                                                                            $linem1=$obj->numRows($appsql1);
                                                                            
                                                                        ?>
                                                <?=$linem1;?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Profile Accessed</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$_SESSION['sess_admin_id']}' and status='Application Submitted'",$debug=-1);
                                                                        $linem1=$obj->numRows($appsql1);
                                                                            
                                                                        ?>
                                                <?=$linem1;?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Application Submitted</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                        $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$_SESSION['sess_admin_id']}' and status='Offer Received'",$debug=-1);
                                                                        $linem1=$obj->numRows($appsql1);
                                                                            
                                                                        ?>
                                                <?=$linem1;?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Offer Letter Received</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                            $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$_SESSION['sess_admin_id']}' and status='I-20 Received'",$debug=-1);
                                                                            $linem1=$obj->numRows($appsql1);
                                                                            
                                                                        ?>
                                                <?=$linem1;?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">I-20 Received</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
                    }
                    if($_SESSION['level_id'] == 2 ){
                        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                            $condition = " and date(a.cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                            $condition1 = " and profile_accessed_date between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                        }else{
                        $condition = " and date(a.cdate)='$today_date'";
                        $condition1 = " and profile_accessed_date='$today_date'";
                        }
                        ?>


<?php
      $branch_id = explode(',',getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']));
      foreach($branch_id as $branch){
        echo '<div class="row"> <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">'.$_POST['perform'].' Performance - '.getField('name',$tbl_branch,$branch).'</h5>';
      $get = $obj->query("select * from $tbl_admin where FIND_IN_SET('$branch', branch_id) > 0 and level_id=3 and status=1 group by phone");
      while($res = $obj->fetchNextObject($get)){
    ?>
<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                            <a href="javascript:void(0)">
                                <h6
                                    style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
                                    <?=getField('name',$tbl_admin,$res->id)?></h6>
                            </a>
                            <?php
                                    $appsql1 = $obj->query("select id as num_rows from $tbl_student where 1=1 and branch_id = $branch $condition1 and am_id='{$res->id}' and profile_accessed=1",$debug=-1);
                                    $linem1=$obj->numRows($appsql1);
                                    
                                ?>
                            <p>Profile Accessed => <?=$linem1;?></p>
                            <?php
                                    $appsql1 = $obj->query("select a.id as num_rows from $tbl_student_application as a inner join $tbl_student as b on a.stu_id = b.id  where 1=1 and b.branch_id = $branch $condition and a.parent_id=0 and a.user_id='{$res->id}' and a.status='Application Submitted'",$debug=-1);
                                    $linem1=$obj->numRows($appsql1);
                                    
                                ?>
                            <p>Application Submitted => <?=$linem1;?></p>
                            <?php
                                    $appsql1 = $obj->query("select a.id as num_rows from $tbl_student_application as a inner join $tbl_student as b on a.stu_id = b.id  where 1=1 and b.branch_id = $branch $condition and a.parent_id=0 and a.user_id='{$res->id}' and a.status='Offer Received'",$debug=-1);
                                    $linem1=$obj->numRows($appsql1);
                                    
                                ?>
                            <p>Offer Letter Received => <?=$linem1;?></p>
                            <?php
                                    $appsql1 = $obj->query("select a.id as num_rows from $tbl_student_application as a inner join $tbl_student as b on a.stu_id = b.id  where 1=1 and b.branch_id = $branch $condition and a.parent_id=0 and a.user_id='{$res->id}' and a.status='I-20 Received'",$debug=-1);
                                    $linem1=$obj->numRows($appsql1);
                                    
                                ?>
                            <p>I-20 Received => <?=$linem1;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
      }
                    ?>
</div>
<?php
                    }
                }

                if($_SESSION['level_id'] == 2 ){
                    if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                        $condition = " and date(cdate) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                        $condition1 = " and profile_accessed_date between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
                    }else{
                        $condition = " and date(cdate)='$today_date'";
                        $condition1 = " and profile_accessed_date='$today_date'";
                    }
                    $account_manager = getField('account_manager',$tbl_admin,$_SESSION['sess_admin_id']);
                    if($account_manager != ''){
                    echo '<div class="row"> <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">'.$_POST['perform'].' Performance </h5>';
                    $get = $obj->query("select * from $tbl_admin where id in ($account_manager) and status=1");
                     while($res = $obj->fetchNextObject($get)){
                   ?>
<div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
    <div class="panel panel-default card-view pa-0">
        <div class="panel-wrapper collapse in">
            <div class="panel-body pa-0">
                <div class="sm-data-box">
                    <div class="container-fluid">
                        <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                            <a href="javascript:void(0)">
                                <h6
                                    style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
                                    <?=getField('name',$tbl_admin,$res->id)?></h6>
                            </a>
                            <?php
                                                   $appsql1 = $obj->query("select id as num_rows from $tbl_student where 1=1 $condition1 and am_id='{$res->id}' and profile_accessed=1",$debug=-1);
                                                   $linem1=$obj->numRows($appsql1);
                                                   
                                               ?>
                            <p>Profile Accessed => <?=$linem1;?></p>
                            <?php
                                                   $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$res->id}' and status='Application Submitted'",$debug=-1);
                                                   $linem1=$obj->numRows($appsql1);
                                                   
                                               ?>
                            <p>Application Submitted => <?=$linem1;?></p>
                            <?php
                                                   $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$res->id}' and status='Offer Received'",$debug=-1);
                                                   $linem1=$obj->numRows($appsql1);
                                                   
                                               ?>
                            <p>Offer Letter Received => <?=$linem1;?></p>
                            <?php
                                                   $appsql1 = $obj->query("select id as num_rows from $tbl_student_application where 1=1 $condition and parent_id=0 and user_id='{$res->id}' and status='I-20 Received'",$debug=-1);
                                                   $linem1=$obj->numRows($appsql1);
                                                   
                                               ?>
                            <p>I-20 Received => <?=$linem1;?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php               
                               }
                            }
                               ?>
</div>
<?php
                }
}

if(isset($_POST['expected_data'])){
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
        $whr = "";
    }elseif($_SESSION['level_id'] == 4){
        $whr = " and a.councellor_id ='{$_SESSION['sess_admin_id']}'";
    }else{
        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
        $whr = " and a.branch_id in ($branch_id)";
    }
    if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
        $e_vi = " $whr and date(a.management_datetime) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
        $e_en = " $whr and date(a.expected_enrollment_date) between '{$_POST['from_date']}' and '{$_POST['to_date']}'";
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        
    }else{
        $e_vi = " $whr and date(a.management_datetime) = '$today_date'";
        $e_en = " $whr and date(a.expected_enrollment_date) = '$today_date'";
        $from_date = date('Y-m-d');
        $to_date = date('Y-m-d');
    }
    ?>
<h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
    <?=$_POST['perform']?> Expected Visits and Enrollments</h5>
<div class="row">
    <?php
    if($_SESSION['level_id']==1){
    ?>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_lead as a where 1=1 $e_vi group by a.branch_id",$debug=-1);
                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Expected Visit</span>
                                    </a>
                                    <?php
                                                        $total = 0;
                                                        while($linem1=$obj->fetchNextObject($appsql1)){
                                                            $total += $linem1->total;
                                                            ?>
                                    <p <?php if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){ ?>
                                        onclick="go_urls('today-expected-visits.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_lead')"
                                        <?php } ?> style="cursor:pointer">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                        }
                                                        ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                        $appsql1 = $obj->query("select COUNT(a.id) as total,a.branch_id from $tbl_visit as a where 1=1 $e_en group by a.branch_id",$debug=-1);
                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Expected Enrollment</span>
                                    </a>
                                    <?php
                                                        $total = 0;
                                                        while($linem1=$obj->fetchNextObject($appsql1)){
                                                            $total += $linem1->total;
                                                            ?>
                                    <p <?php if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){ ?>
                                        onclick="go_urls('expected-enrollment-list.php','<?=$linem1->branch_id?>','','<?=$from_date?>','<?=$to_date?>','show_admin_lead')"
                                        <?php } ?> style="cursor:pointer">
                                        <?=getField('name',$tbl_branch,$linem1->branch_id)?> =>
                                        <?=$linem1->total?></p>
                                    <?php
                                                        }
                                                        ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="">
                                                <?php
                                                $whr_c = '';
                                                if($_SESSION['level_id'] == 4){
                                                    $whr_c = " and a.id='{$_SESSION['sess_admin_id']}'";
                                                }
                                                        $appsql1 = $obj->query("select a.*,b.counsellor_target from $tbl_admin as a inner join tbl_target as b on a.id=b.counsellor_id where 1=1 and a.level_id=4 and b.target_date='".date('Y-m-d')."' and counsellor_target!=0 $whr_c ORDER BY a.id DESC",$debug=-1);
                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Today's Targets</span>
                                    </a>
                                    <?php
                                                        $total = 0;
                                                        while($linem1=$obj->fetchNextObject($appsql1)){
                                                            $total += $linem1->counsellor_target;
                                                            ?>
                                    <p style="cursor:pointer"><?=$linem1->name?> => <?=$linem1->counsellor_target?></p>
                                    <?php
                                                        }
                                                        ?>
                                    <p style="font-weight:bold">Total => <?=$total?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if($_SESSION['level_id']==4){
    $whr_require = " and b.c_id  ='".$_SESSION['sess_admin_id']."'";
    ?>
<h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">Requirements</h5>
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="request-notification-list.php">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Total
                                            Requirements</span>
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
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="request-notification-list.php">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1  and a.status=1 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Pending</span>
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
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="request-notification-list.php">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1  and a.status=0 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Done</span>
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
<?php } ?>
<?php
}

///////GRAPH DATA////////////////////////////////////////////////////////

if(isset($_POST['graph_data'])){
?>
<script>
var chartContainer = document.getElementById("Current_Month_Leads_All_Branches");
if (chartContainer) {
    var charts = new CanvasJS.Chart("Current_Month_Leads_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Leads - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Leads",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            
                                $month = date('m');
                                $year = date('Y');
                                $get = $obj->query("SELECT branch_id,COUNT(*) as total FROM `$tbl_lead` where YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY branch_id order by COUNT(*) desc",-1);
                                while($res = $obj->fetchNextObject($get)){
                                    echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                }
                                ?>
            ]
        }]
    });
    charts.render();
}
</script>


<?php
if(isset($_POST['show_graphs_counsellor'])){
                            ?>
<script>
var chartContainer6 = document.getElementById("Current_Month_Visits_All_Branches");
if (chartContainer6) {
    var chart = new CanvasJS.Chart("Current_Month_Visits_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Visits - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Visits",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    
                                        $month = date('m');
                                        $year = date('Y');
                                        $get = $obj->query("SELECT branch_id,COUNT(*) as total FROM `$tbl_visit` where YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY branch_id order by COUNT(*) desc",-1);
                                        while($res = $obj->fetchNextObject($get)){
                                            echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                        }
                                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer40 = document.getElementById("Current_Month_registration_All_Branches");
if (chartContainer40) {
    var chart = new CanvasJS.Chart("Current_Month_registration_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Registration - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Registration",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT branch_id,COUNT(*) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.visit_status in ('Registered','Register') and YEAR(a.visit_status_date) = $year AND MONTH(a.visit_status_date) = $month $condition_of_visa_sub_type GROUP BY a.branch_id order by COUNT(*) desc",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                        echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                    }
                                    ?>
            ]
        }]
    });
    chart.render();
}
</script>

<script>
var chartContainer14 = document.getElementById("Last_Month_Enrollment_All_Branches");
if (chartContainer14) {
    var chart = new CanvasJS.Chart("Last_Month_Enrollment_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Last Month Enrollment - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Enrollment",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabel: "{y}",
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                $m = date('m');
                                $y = date('Y');
                                if($m != 1){
                                $month = $m-1;
                                $year = date('Y');
                                }else{
                                    $month = 12;
                                    $year = $y - 1;
                                }
                                $get = $obj->query("SELECT a.branch_id,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.enrollment_counselor!=0 and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type  GROUP BY a.branch_id order by COUNT(a.id) desc",-1);
                                while($res = $obj->fetchNextObject($get)){
                                    echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                }
                                ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer16 = document.getElementById("Visa_Approved_All_Branches");
if (chartContainer16) {

    var chart = new CanvasJS.Chart("Visa_Approved_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        title: {
            text: "Visa Approved - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        legend: {
            fontSize: 14,
            fontFamily: "Arial"
        },
        data: [{
            type: "pie",
            indexLabelFontSize: 14,
            indexLabelFontFamily: "Arial",
            valueRepresents: "area",
            indexLabel: "{label}: {y}",
            toolTipContent: "<b>{label}:</b> {y}",
            toolTipFontFamily: "Arial",
            dataPoints: [
                <?php
                                $get = $obj->query("SELECT a.branch_id, COUNT(*) as total FROM `$tbl_student` as a 
                                    INNER JOIN $tbl_student_status as b ON a.id = b.stu_id 
                                    WHERE b.cstatus = 'Visa Approved' 
                                    GROUP BY a.branch_id 
                                    ORDER BY COUNT(*) DESC;", -1);

                                $dataPoints = [];
                                while ($res = $obj->fetchNextObject($get)) {
                                    $branchName = addslashes(getField('name', $tbl_branch, $res->branch_id));
                                    $dataPoints[] = "{ y: {$res->total}, label: '{$branchName}' }"; 
                                }
                                echo implode(',', $dataPoints); 
                                ?>
            ]
        }]
    });
    chart.render();

}
</script>
<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT branch_id, COUNT(*) as total_visits FROM `$tbl_visit` WHERE branch_id!=0 and  date(cdate) > '2024-08-01' GROUP BY branch_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->branch_id]['visits'] = $resVisits->total_visits;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.branch_id as branch_id, COUNT(a.id) as total_enrollments FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE a.branch_id!=0 and  date(a.cdate) > '2024-08-01'  $condition_of_visa_sub_type GROUP BY a.branch_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->branch_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_branch, $branch_id))
                ];
            }
            ?>

<script>
var chartContainer12 = document.getElementById("Over_All_Conversion_Rate_All_Branches");
if (chartContainer12) {
    var chart = new CanvasJS.Chart("Over_All_Conversion_Rate_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Conversion Rate - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversions",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                if($dataPoint['y'] != 0){
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                                }
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>

<script>
var chartContainer15 = document.getElementById("Current_Month_Enrollment_All_Councellors");
if (chartContainer15) {
    var chart = new CanvasJS.Chart("Current_Month_Enrollment_All_Councellors", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Enrollments - All Councellors",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Enrollment",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabel: "{y}",
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                $month = date('m');
                                $year = date('Y');
                                $get = $obj->query("SELECT a.enrollment_counselor,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.enrollment_counselor!=0 and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type  GROUP BY a.enrollment_counselor order by COUNT(a.id) desc",-1);
                                while($res = $obj->fetchNextObject($get)){
                                    $reapply_counsellor = addslashes(getField('reapply_counsellor', $tbl_admin, $res->enrollment_counselor));
                                    if($reapply_counsellor == 0 || $reapply_counsellor == null){
                                    echo "{ label: '".addslashes(getField('name', $tbl_admin, $res->enrollment_counselor))." (".addslashes(getField('branch_code',$tbl_branch,getField('branch_id', $tbl_admin, $res->enrollment_counselor))).")', y: $res->total },";
                                    }
                                }
                                ?>
            ]
        }]
    });
    chart.render();
}
</script>
<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT councellor_id, COUNT(*) as total_visits FROM `$tbl_visit` WHERE councellor_id!=0 and  date(cdate) > '2024-08-01' GROUP BY councellor_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->councellor_id]['visits'] = $resVisits->total_visits;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.enrollment_counselor as councellor_id, COUNT(a.id) as total_enrollments FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE a.enrollment_counselor!=0 and  date(a.cdate) > '2024-08-01' and a.visit_status='Enrolled'  $condition_of_visa_sub_type GROUP BY a.enrollment_counselor", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->councellor_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $counselor_id => $data) {
                $reapply_counsellor = addslashes(getField('reapply_counsellor', $tbl_admin, $counselor_id));
                if($reapply_counsellor == 0 || $reapply_counsellor == null){
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_admin, $counselor_id))
                ];
            }
            }
            ?>

<script>
var chartContainer12 = document.getElementById("Overall_Conversion_Rate_All_Councellors");
if (chartContainer12) {
    var chart = new CanvasJS.Chart("Overall_Conversion_Rate_All_Councellors", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Conversion Rate - All Councellors",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversions",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Counsellor",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                if($dataPoint['y'] != 0){
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                                }
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer10 = document.getElementById("Current_Month_Visits");
if (chartContainer10) {
    var chart = new CanvasJS.Chart("Current_Month_Visits", {
        exportEnabled: true,
        animationEnabled: true,
        title: {
            text: "Current Month Visits",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        legend: {
            cursor: "pointer",
            itemclick: explodePie,
            fontFamily: "Arial"
        },
        data: [{
            type: "pie",
            toolTipContent: "{name}: <strong>{y}</strong>",
            indexLabel: "{name} - {y}",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT councellor_id,COUNT(*) as total FROM `$tbl_visit` where branch_id='$branch_id' and  councellor_id!=0 and  YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY councellor_id",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                ?> {
                    y: <?=$res->total?>,
                    name: "<?=addslashes(getField('name', $tbl_admin, $res->councellor_id))?>"
                },
                <?php } ?>
            ]
        }]
    });
    chart.render();

    function explodePie(e) {
        if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e
                .dataPointIndex].exploded) {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
        } else {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
        }
        e.chart.render();

    }
}
</script>

<script>
var chartContainer9 = document.getElementById("Current_Month_Enrollment");
if (chartContainer9) {
    var chart = new CanvasJS.Chart("Current_Month_Enrollment", {
        exportEnabled: true,
        animationEnabled: true,
        title: {
            text: "Current Month Enrollment",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        legend: {
            cursor: "pointer",
            itemclick: explodePie,
            fontFamily: "Arial"
        },
        data: [{
            type: "pyramid",
            toolTipContent: "{name}: <strong>{y}</strong>",
            indexLabel: "{name} - {y}",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT a.enrollment_counselor,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.branch_id='$branch_id' and a.enrollment_counselor!=0 and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type  GROUP BY a.enrollment_counselor order by COUNT(a.id)  desc",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                ?> {
                    y: <?=$res->total?>,
                    name: "<?=addslashes(getField('name', $tbl_admin, $res->enrollment_counselor))?>"
                },
                <?php } ?>
            ]
        }]
    });
    chart.render();

    function explodePie(e) {
        if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e
                .dataPointIndex].exploded) {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
        } else {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
        }
        e.chart.render();

    }
}
</script>

<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT councellor_id, COUNT(*) as total_visits FROM `$tbl_visit` WHERE branch_id='$branch_id' and  councellor_id!=0 and  YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY councellor_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->councellor_id]['visits'] = $resVisits->total_visits;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.enrollment_counselor as councellor_id, COUNT(a.id) as total_enrollments FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE a.branch_id='$branch_id' and  a.enrollment_counselor!=0 and  YEAR(a.cdate) = $year AND MONTH(a.cdate) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type GROUP BY a.enrollment_counselor", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->councellor_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $counselor_id => $data) {
                $reapply_counsellor = addslashes(getField('reapply_counsellor', $tbl_admin, $counselor_id));
                if($reapply_counsellor == 0 || $reapply_counsellor == null){
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_admin, $counselor_id))
                ];
            }
            }
            ?>

<script>
var chartContainer11 = document.getElementById("Current_Month_Conversion_Rate");
if (chartContainer11) {
    var chart = new CanvasJS.Chart("Current_Month_Conversion_Rate", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversions",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Counsellor",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>

<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT councellor_id, COUNT(*) as total_visits FROM `$tbl_visit` WHERE branch_id='$branch_id' and  councellor_id!=0 and  date(cdate) > '2024-08-01' GROUP BY councellor_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->councellor_id]['visits'] = $resVisits->total_visits;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.enrollment_counselor as councellor_id, COUNT(a.id) as total_enrollments FROM `$tbl_visit` as a $tbl_visa_sub_type_join WHERE a.branch_id='$branch_id' and  a.enrollment_counselor!=0 and  date(a.cdate) > '2024-08-01' and a.visit_status='Enrolled'  $condition_of_visa_sub_type  GROUP BY a.councellor_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->councellor_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $counselor_id => $data) {
                $reapply_counsellor = addslashes(getField('reapply_counsellor', $tbl_admin, $counselor_id));
                if($reapply_counsellor == 0 || $reapply_counsellor == null){
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_admin, $counselor_id))
                ];
            }
            }
            ?>

<script>
var chartContainer13 = document.getElementById("Overall_Conversion_Rate");
if (chartContainer13) {
    var chart = new CanvasJS.Chart("Overall_Conversion_Rate", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversions",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Counsellor",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                foreach($dataPoints as $dataPoint) {
                                    echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                                }
                            ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer7 = document.getElementById("Current_Month_Enrollments_All_Branches");
if (chartContainer7) {
    var chart = new CanvasJS.Chart("Current_Month_Enrollments_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Enrollments - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Enrollment",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT a.branch_id,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where enrollment_counselor!=0 and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type  GROUP BY a.branch_id order by COUNT(a.id) desc",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                        echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                    }
                                    ?>
            ]
        }]
    });
    chart.render();
}
</script>
<?php
                $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
            ?>

<script>
var chartContainer8 = document.getElementById("Last_Month_Enrollment");
if (chartContainer8) {
    var chart = new CanvasJS.Chart("Last_Month_Enrollment", {
        exportEnabled: true,
        animationEnabled: true,
        title: {
            text: "Last Month Enrollment",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        legend: {
            cursor: "pointer",
            itemclick: explodePie,
            fontFamily: "Arial"
        },
        data: [{
            type: "pyramid",
            toolTipContent: "{name}: <strong>{y}</strong>",
            indexLabel: "{name} - {y}",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                        $m = date('m');
                                        $y = date('Y');
                                        if($m != 1){
                                        $month = $m-1;
                                        $year = date('Y');
                                        }else{
                                            $month = 12;
                                            $year = $y - 1;
                                        }
                                        $get = $obj->query("SELECT a.enrollment_counselor,COUNT(a.id) as total FROM `$tbl_visit` as a $tbl_visa_sub_type_join where a.branch_id='$branch_id' and a.enrollment_counselor!=0 and YEAR(a.enrollment_counselor_date) = $year AND MONTH(a.enrollment_counselor_date) = $month and a.visit_status='Enrolled' $condition_of_visa_sub_type GROUP BY a.enrollment_counselor order by COUNT(a.id) desc",-1);
                                        while($res = $obj->fetchNextObject($get)){
                                            echo "{ name: '".addslashes(getField('name', $tbl_admin, $res->enrollment_counselor))."', y: $res->total },";
                                        }
                                        ?>
            ]
        }]
    });
    chart.render();

    function explodePie(e) {
        if (typeof(e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e
                .dataPointIndex].exploded) {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
        } else {
            e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
        }
        e.chart.render();

    }
}
</script>
<?php
 if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">Visits,
        Enrollments Data</h5>
    <div class="col-md-4">
        <div id="Current_Month_Visits_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_registration_All_Branches" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Enrollments_All_Branches" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-4">
        <div id="Last_Month_Enrollment_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Visa_Approved_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Over_All_Conversion_Rate_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>

    <div class="col-md-12">
        <div id="Current_Month_Enrollment_All_Councellors" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-12">
        <div id="Overall_Conversion_Rate_All_Councellors" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
</div>
<?php } ?>
<?php
                        if($_SESSION['level_id'] == 4){
                            ?>
<div class="row">
    <div class="col-md-4">
        <div id="Current_Month_Visits" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Enrollment" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="m" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Overall_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Enrollments_All_Branches" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
</div>
<?php } ?>
<?php
                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259){
                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                            $branch_name = getField('name',$tbl_branch,$branch_id);
                    ?>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
        <?=$branch_name?> Data</h5>
    <div class="col-md-4">
        <div id="Current_Month_Visits" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Enrollment" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Last_Month_Enrollment" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Overall_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
</div>
<div class="row">
    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">All Branches
        Data</h5>
    <div class="col-md-4">
        <div id="Current_Month_Leads_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Visits_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Enrollments_All_Branches" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-4">
        <div id="Last_Month_Enrollment_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Visa_Approved_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
</div>
<?php } }?>
<?php
if(isset($_POST['show_graphs_crm'])){
    ?>
<script>
var chartContainer1 = document.getElementById("Current_Month_Leads_All_CRM_Executives");
if (chartContainer1) {
    var charts = new CanvasJS.Chart("Current_Month_Leads_All_CRM_Executives", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Leads - All CRM Executives",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Leads",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executives",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT crm_executive_id,COUNT(*) as total FROM `$tbl_lead` where YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY crm_executive_id order by COUNT(*) desc",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                        echo "{ label: '".addslashes(getField('name', $tbl_admin, $res->crm_executive_id))."', y: $res->total },";
                                    }
                                    ?>
            ]
        }]
    });
    charts.render();
}
</script>
<script>
var chartContainer4 = document.getElementById("Current_Month_Visit_All_Branches");
if (chartContainer4) {
    var charts = new CanvasJS.Chart("Current_Month_Visit_All_Branches", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Visit From Leads - All Branches",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        data: [{
            type: "pie",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{label}: {y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT a.branch_id,COUNT(a.id) as total FROM $tbl_lead as a inner join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no )  where YEAR(b.cdate) = $year AND MONTH(b.cdate) = $month GROUP BY a.branch_id",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                        echo "{ label: '".addslashes(getField('name', $tbl_branch, $res->branch_id))."', y: $res->total },";
                                    }
                                ?>
            ]
        }]
    });
    charts.render();
}
</script>
<script>
var chartContainer5 = document.getElementById("Current_Month_Visit_All_Executive");
if (chartContainer5) {
    var charts = new CanvasJS.Chart("Current_Month_Visit_All_Executive", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Visit From Leads - All CRM Executives",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Total Leads",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executives",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    
                                        $month = date('m');
                                        $year = date('Y');
                                        $get = $obj->query("SELECT a.crm_executive_id,COUNT(a.id) as total FROM $tbl_lead as a inner join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no )  where YEAR(b.cdate) = $year AND MONTH(b.cdate) = $month GROUP BY a.crm_executive_id order by COUNT(a.id) desc",-1);
                                        while($res = $obj->fetchNextObject($get)){
                                            echo "{ label: '".addslashes(getField('name', $tbl_admin, $res->crm_executive_id))."', y: $res->total },";
                                        }
                                        ?>
            ]
        }]
    });
    charts.render();
}
</script>

<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_lead FROM $tbl_lead as a WHERE YEAR(a.cdate) = $year AND MONTH(a.cdate) = $month GROUP BY a.branch_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->branch_id]['visits'] = $resVisits->total_lead;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_enrollments FROM $tbl_lead as a INNER JOIN $tbl_visit as b ON (a.applicant_contact_no = b.applicant_contact_no OR a.applicant_alternate_no = b.applicant_alternate_no OR a.applicant_contact_no = b.applicant_alternate_no OR a.applicant_alternate_no = b.applicant_contact_no) WHERE YEAR(a.cdate) = $year AND MONTH(a.cdate) = $month GROUP BY a.branch_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->branch_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_branch, $branch_id))
                ];
            }
            ?>

<script>
var chartContainer18 = document.getElementById("Cuurent_Month_Visits_Conversion_Rate");
if (chartContainer18) {
    var chart = new CanvasJS.Chart("Cuurent_Month_Visits_Conversion_Rate", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Leads to Visits - Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial",
        },
        axisX: {
            title: "Branch",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    foreach($dataPoints as $dataPoint) {
                                        echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                                    }
                                ?>
            ]
        }]
    });
    chart.render();
}
</script>
<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_lead FROM $tbl_lead as a GROUP BY a.branch_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->branch_id]['visits'] = $resVisits->total_lead;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_enrollments FROM $tbl_lead as a INNER JOIN $tbl_visit as b ON (a.applicant_contact_no = b.applicant_contact_no OR a.applicant_alternate_no = b.applicant_alternate_no OR a.applicant_contact_no = b.applicant_alternate_no OR a.applicant_alternate_no = b.applicant_contact_no)  GROUP BY a.branch_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->branch_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_branch, $branch_id))
                ];
            }
            ?>
<script>
var chartContainer19 = document.getElementById("overall_Visits_Conversion_Rate");
if (chartContainer19) {
    var chart = new CanvasJS.Chart("overall_Visits_Conversion_Rate", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Leads to Visits - Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executives",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT a.crm_executive_id, COUNT(a.id) as total_lead FROM $tbl_lead as a WHERE YEAR(a.cdate) = $year AND MONTH(a.cdate) = $month GROUP BY a.crm_executive_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->crm_executive_id]['visits'] = $resVisits->total_lead;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.crm_executive_id, COUNT(a.id) as total_enrollments FROM $tbl_lead as a INNER JOIN $tbl_visit as b ON (a.applicant_contact_no = b.applicant_contact_no OR a.applicant_alternate_no = b.applicant_alternate_no OR a.applicant_contact_no = b.applicant_alternate_no OR a.applicant_alternate_no = b.applicant_contact_no) WHERE YEAR(a.cdate) = $year AND MONTH(a.cdate) = $month GROUP BY a.crm_executive_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->crm_executive_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_admin, $branch_id))
                ];
            }
            ?>

<script>
var chartContainer18 = document.getElementById("Cuurent_Month_Visits_Conversion_Rate_CRM");
if (chartContainer18) {
    var chart = new CanvasJS.Chart("Cuurent_Month_Visits_Conversion_Rate_CRM", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Leads to Visits - Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executive",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    foreach($dataPoints as $dataPoint) {
                                        echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                                    }
                                ?>
            ]
        }]
    });
    chart.render();
}
</script>

<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT a.crm_executive_id, COUNT(a.id) as total_lead FROM $tbl_lead as a GROUP BY a.crm_executive_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->crm_executive_id]['visits'] = $resVisits->total_lead;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.crm_executive_id, COUNT(a.id) as total_enrollments FROM $tbl_lead as a INNER JOIN $tbl_visit as b ON (a.applicant_contact_no = b.applicant_contact_no OR a.applicant_alternate_no = b.applicant_alternate_no OR a.applicant_contact_no = b.applicant_alternate_no OR a.applicant_alternate_no = b.applicant_contact_no)  GROUP BY a.crm_executive_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->crm_executive_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_admin, $branch_id))
                ];
            }
            ?>
<script>
var chartContainer19 = document.getElementById("overall_Visits_Conversion_Rate_CRM");
if (chartContainer19) {
    var chart = new CanvasJS.Chart("overall_Visits_Conversion_Rate_CRM", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Leads to Visits - Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executives",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer4 = document.getElementById("current_Month_Leads_TO_Enrollment");
if (chartContainer4) {
    var charts = new CanvasJS.Chart("current_Month_Leads_TO_Enrollment", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Enrollment From Leads - All CRM Executives",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        data: [{
            type: "pie",
            indexLabelFontColor: "#5A5757",
            indexLabel: "{label}: {y}",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                                    $month = date('m');
                                    $year = date('Y');
                                    $get = $obj->query("SELECT a.crm_executive_id,COUNT(a.id) as total FROM $tbl_lead as a inner join $tbl_student as b on (a.applicant_contact_no=b.student_contact_no or a.applicant_alternate_no=b.alternate_contact or a.applicant_contact_no=b.alternate_contact or a.applicant_alternate_no=b.student_contact_no )  where YEAR(b.cdate) = $year AND MONTH(b.cdate) = $month GROUP BY a.crm_executive_id",-1);
                                    while($res = $obj->fetchNextObject($get)){
                                        echo "{ label: '".addslashes(getField('name', $tbl_admin, $res->crm_executive_id))."', y: $res->total },";
                                    }
                                ?>
            ]
        }]
    });
    charts.render();
}
</script>

<?php
            // Define the month and year
            $month = date('m');
            $year = date('Y');
            $counselorData = [];

            // Get visits data
            $getVisits = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_lead FROM $tbl_lead as a GROUP BY a.branch_id", -1);
            while($resVisits = $obj->fetchNextObject($getVisits)){
                $counselorData[$resVisits->branch_id]['visits'] = $resVisits->total_lead;
            }

            // Get enrollments data
            $getEnrollments = $obj->query("SELECT a.branch_id, COUNT(a.id) as total_enrollments FROM $tbl_lead as a INNER JOIN $tbl_student as b ON (a.applicant_contact_no = b.student_contact_no OR a.applicant_alternate_no = b.alternate_contact OR a.applicant_contact_no = b.alternate_contact OR a.applicant_alternate_no = b.student_contact_no)  GROUP BY a.branch_id", -1);
            while($resEnrollments = $obj->fetchNextObject($getEnrollments)){
                $counselorData[$resEnrollments->branch_id]['enrollments'] = $resEnrollments->total_enrollments;
            }

            // Prepare data points for the chart
            $dataPoints = [];
            foreach($counselorData as $branch_id => $data) {
                $visits = isset($data['visits']) ? $data['visits'] : 0;
                $enrollments = isset($data['enrollments']) ? $data['enrollments'] : 0;
                $conversionRatio = ($visits > 0) ? intval(($enrollments / $visits) * 100) : 0;

                $dataPoints[] = [
                    'y' => $conversionRatio,
                    'label' => addslashes(getField('name', $tbl_branch, $branch_id))
                ];
            }
            ?>
<script>
var chartContainer19 = document.getElementById("overall_Leads_TO_Enrollment");
if (chartContainer19) {
    var chart = new CanvasJS.Chart("overall_Leads_TO_Enrollment", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Overall Leads to Enrolment - Conversion Rate",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial",
        },
        axisX: {
            title: "CRM Executives",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            foreach($dataPoints as $dataPoint) {
                                echo "{ y: " . $dataPoint['y'] . ", label: '" . $dataPoint['label'] . "', indexLabel: '" . $dataPoint['y'] . "%' },";
                            }
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer20 = document.getElementById("Current_Month_Visits_counselor");
if (chartContainer20) {
    var chart = new CanvasJS.Chart("Current_Month_Visits_counselor", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Current Month Visits - All Counselors",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial"
        },
        axisX: {
            title: "Counselor",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            $month = date('m');
                            $year = date('Y');
                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                            $query = "SELECT councellor_id, COUNT(*) as total FROM `$tbl_visit` WHERE branch_id = '$branch_id' AND councellor_id != 0 AND YEAR(cdate) = $year AND MONTH(cdate) = $month GROUP BY councellor_id";
                            $result = $obj->query($query, -1);

                            $dataPoints = [];
                            while($res = $obj->fetchNextObject($result)){
                                $name = addslashes(getField('name', $tbl_admin, $res->councellor_id));
                                $dataPoints[] = "{ y: {$res->total}, indexLabel: \"{$res->total}\", label: \"$name\" }";
                            }

                            echo implode(", ", $dataPoints);
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<script>
var chartContainer21 = document.getElementById("today_Visits_counselor");
if (chartContainer21) {
    var chart = new CanvasJS.Chart("today_Visits_counselor", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Today Visits - All Counselors",
            fontFamily: "Arial",
            fontWeight: "bold",
            fontSize: 14
        },
        axisY: {
            includeZero: true,
            title: "Conversion Rate (%)",
            fontFamily: "Arial"
        },
        axisX: {
            title: "Counselor",
            interval: 1,
            labelAngle: -45,
            labelFontSize: 14,
            labelFontColor: "#5A5757",
            fontFamily: "Arial"
        },
        data: [{
            type: "column",
            indexLabelFontColor: "#5A5757",
            indexLabelFontSize: 16,
            indexLabelPlacement: "outside",
            fontFamily: "Arial",
            dataPoints: [
                <?php
                            $date = date('Y-m-d');
                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                            $query = "SELECT councellor_id, COUNT(*) as total FROM `$tbl_visit` WHERE branch_id = '$branch_id' AND councellor_id != 0 AND date(cdate) = '$date' GROUP BY councellor_id";
                            $result = $obj->query($query, -1);

                            $dataPoints = [];
                            while($res = $obj->fetchNextObject($result)){
                                $name = addslashes(getField('name', $tbl_admin, $res->councellor_id));
                                $dataPoints[] = "{ y: {$res->total}, indexLabel: \"{$res->total}\", label: \"$name\" }";
                            }

                            echo implode(", ", $dataPoints);
                        ?>
            ]
        }]
    });
    chart.render();
}
</script>
<?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 9 || in_array(4,$addtional_role)){
                    ?>
<div class="row">
    <?php
                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){                        
                        ?>

    <h5 style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">CRM Executive
        Data</h5>
    <?php } ?>
    <div class="col-md-4">
        <div id="Current_Month_Leads_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Leads_All_CRM_Executives" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-4">
        <div id="Current_Month_Visit_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <!-- <div class="col-md-4">
        <div id="Past_Month_Visit_All_Branches" style="height:300px;margin-bottom: 20px;"></div>
    </div> -->
    <div class="col-md-4">
        <div id="Current_Month_Visit_All_Executive" style="height:300px;margin-bottom: 20px;"></div>
    </div>

    <div class="col-md-4">
        <div id="Cuurent_Month_Visits_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="overall_Visits_Conversion_Rate" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="Cuurent_Month_Visits_Conversion_Rate_CRM" style="height:300px;margin-bottom: 20px;">
        </div>
    </div>
    <div class="col-md-4">
        <div id="overall_Visits_Conversion_Rate_CRM" style="height:300px;margin-bottom: 20px;"></div>
    </div>
    <div class="col-md-4">
        <div id="current_Month_Leads_TO_Enrollment" style="height:300px;margin-bottom: 20px;"></div>
    </div>

    <div class="col-md-4">
        <div id="overall_Leads_TO_Enrollment" style="height:300px;margin-bottom: 20px;"></div>
    </div>
</div>
<?php
                }
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 251 || in_array(1,$addtional_role)){
                    ?>
<div class="col-md-4">
    <div id="Current_Month_Visits_counselor" style="height:300px;margin-bottom: 20px;"></div>
</div>
<div class="col-md-4">
    <div id="today_Visits_counselor" style="height:300px;margin-bottom: 20px;"></div>
</div>
<?php
                }
            }
            if(isset($_POST['show_graphs_data'])){
                
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 2  || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 259 || $_SESSION['level_id'] == 2 ){
                ?>

<script>
function loadChart(chartContainerId, status, chartTitle) {
    var chartContainer = document.getElementById(chartContainerId);
    if (chartContainer) {
        $.ajax({
            url: 'ajax/chart-ajax.php', // The PHP file that returns the data
            type: 'GET',
            data: {
                status: status
            }, // Send the status to the server
            success: function(dataPoints) {
                if (dataPoints.error) {
                    console.error(dataPoints.error); // Handle error if PHP returns one
                    return;
                }

                var chart = new CanvasJS.Chart(chartContainerId, {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light1",
                    title: {
                        text: chartTitle,
                        fontFamily: "Arial",
                        fontWeight: "bold",
                        fontSize: 14
                    },
                    axisY: {
                        includeZero: true,
                        title: "Total",
                        fontFamily: "Arial"
                    },
                    axisX: {
                        title: "Admission Executives",
                        interval: 1,
                        labelAngle: -45,
                        labelFontSize: 14,
                        labelFontColor: "#5A5757",
                        fontFamily: "Arial"
                    },
                    data: [{
                        type: "column",
                        indexLabelFontColor: "#5A5757",
                        indexLabelFontSize: 16,
                        indexLabelPlacement: "outside",
                        indexLabel: "{y}",
                        fontFamily: "Arial",
                        dataPoints: dataPoints
                    }]
                });
                chart.render();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data for chart: " + chartContainerId + " - " + status + ": " +
                    error);
            }
        });
    }
}

// Load each chart with corresponding status and title
loadChart("Current_Month_Application_Submitted", "Application Submitted",
    "Current Month Application Submitted - All Admission Executives");
loadChart("Current_Month_Offer_Letter_Received", "Offer Received",
    "Current Month Offer Letter Received - All Admission Executives");
loadChart("Current_Month_I-20_Received", "I-20 Received", "Current Month I-20 Received - All Admission Executives");
</script>

<div class="col-md-12">
    <div id="Current_Month_Application_Submitted" style="height:300px;margin-bottom: 20px;"></div>
</div>
<div class="col-md-12">
    <div id="Current_Month_Offer_Letter_Received" style="height:300px;margin-bottom: 20px;"></div>
</div>
<div class="col-md-12">
    <div id="Current_Month_I-20_Received" style="height:300px;margin-bottom: 20px;"></div>
</div>
<?php } ?>

<?php
            }
}

//////////COUNTER DATA//////////////////////////////////////////////////////////
if(isset($_POST['counter_data'])){
    $addtional_role = explode(',',$_SESSION['additional_role']);
    ?>
<!-- Row -->

<div class="row">

    <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id'] == 2 ) {?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a <?php if ($_SESSION['level_id']==1){ ?>
                                        href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(3))) ?>"
                                        <?php } ?>>
                                        <span class="txt-dark block counter"><span class="counter-anim"><?php
                                                    if ($_SESSION['level_id']==1){
                                                    $sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=3",$debug=-1); 
                                                    }else {
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                
                                                    $sql=$obj->query("select * from tbl_admin where 1=1 and level_id=3 and branch_id in($branch_id)",$debug=-1);
                                                    };
                                                
                                                echo $query=$obj->numRows($sql);
                                                
                                            ?></span></span>

                                        <span class="weight-500 uppercase-font block font-13">Account
                                            Manager</span>
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
    <?php } 
                    if ($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id'] == 2  ) {
                ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a <?php if ($_SESSION['level_id']==1){ ?>
                                        href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(4))) ?>"
                                        <?php } ?>>
                                        <span class="txt-dark block counter"><span class="counter-anim"><?php
                                                if ($_SESSION['level_id']==1){
                                                    $sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=4",$debug=-1); 
                                                    }else{
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);

                                                    $sql=$obj->query("select * from tbl_admin where 1=1 and level_id=4 and branch_id in($branch_id)",$debug=-1);
                                                    }
                                                
                                                echo $query=$obj->numRows($sql);

                                            ?></span></span>
                                        <span class="weight-500 uppercase-font block">Counselor</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id'] == 2   || $_SESSION['level_id']==4 || $_SESSION['level_id']==5 || $_SESSION['level_id']==6 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8) {
                ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a
                                        href="<?php if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?> student-diploma.php <?php }else{?>student-list.php <?php }?>">
                                        <span class="txt-dark block counter"><span class="counter-anim"><?php

                                            if ($_SESSION['level_id']==4){
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' and reapply_status=0",$debug=-1);
                                            }else if ($_SESSION['level_id']==1){
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and reapply_status=0",$debug=-1); 
                                            }elseif ($_SESSION['level_id'] == 2  || $_SESSION['level_id']==19) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and reapply_status=0",$debug=-1);
                                            }elseif ($_SESSION['level_id']==3) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' and reapply_status=0",$debug=-1);
                                            }elseif ($_SESSION['level_id']==5) {
                                            // $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            // $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request'",$debug=-1);
                                            }elseif ($_SESSION['level_id']==6) {
                                            // $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            // $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.diploma_id,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.media_gap_status,b.pimg,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.student_approval_status=1",$debug=-1);
                                            }elseif ($_SESSION['level_id']==7) {
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                $msql = "select a.*";
                                                $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and reapply_status=0";
                                            
                                                $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','Proceed on Dummy I-20','CAS Received') and reapply_status=0";                              
                                                $msql .=" $whr1 group by a.id";
                                                //echo $msql; die;
                                                $sql=$obj->query($msql);
                                            }elseif ($_SESSION['level_id']==8) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' and reapply_status=0",$debug=-1);
                                            }
                                                echo $obj->numRows($sql); ?></span></span>
                                        <span class="weight-500 uppercase-font block">
                                            <?php
                                                    if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                            <!-- Manage Diploma -->
                                            <?php }else{?>
                                            Total Student
                                            <?php }
                                                    ?>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="
                                            <?php
                                            if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                            student-experience.php
                                            <?php }else{?>
                                                student-list.php?filter=<?php echo base64_encode(base64_encode(base64_encode(2))); ?>
                                            <?php }?>
                                            ">
                                        <span class="txt-dark block counter"><span class="counter-anim"><?php

                                            if ($_SESSION['level_id']==4){
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' and am_id=0 and reapply_status=0",$debug=-1);
                                            }else if ($_SESSION['level_id']==1){
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and am_id=0 and reapply_status=0",$debug=-1); 
                                            }elseif ($_SESSION['level_id'] == 2  || $_SESSION['level_id']==19) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id=0 and reapply_status=0",$debug=-1);
                                            }elseif ($_SESSION['level_id']==3) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' and am_id=0 and reapply_status=0",$debug=-1);

                                            }elseif ($_SESSION['level_id']==5) {
                                            // $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            // $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,c.name as company_name from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request'",$debug=-1);
                                            }elseif ($_SESSION['level_id']==6) {
                                            // $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            //  $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,b.counsellor_status,b.pimg,c.name as company_name from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.address_proof=1",$debug=-1);
                                        }elseif ($_SESSION['level_id']==7) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $msql = "select a.*";
                                            $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and reapply_status=0";
                                        
                                            $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','Proceed on Dummy I-20','I-20 Issued','CAS Received')";                              
                                            $msql .=" and a.am_id =0 and reapply_status=0 group by a.id";
                                            //echo $msql; die;
                                            $sql=$obj->query($msql);
                                            }elseif ($_SESSION['level_id']==8) {
                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                            $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."'  and reapply_status=0",$debug=-1);
                                            }

                                                echo $obj->numRows($sql); ?></span></span>
                                        <span class="weight-500 uppercase-font block">
                                            <?php
                                                    if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                            <!-- Manage Experience -->
                                            <?php }else{?>
                                            UNALLOCATED Student
                                            <?php }
                                                    ?>

                                        </span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php }?>
</div>
<!-- /Row -->



<?php
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==19){?>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a <?php if ($_SESSION['level_id']==1){ ?>
                                        href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(7))) ?>"
                                        <?php } ?>>
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php if ($_SESSION['level_id']==1){
                                                    $sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=7",$debug=-1); 
                                                    }else {
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                    $sql=$obj->query("select * from tbl_admin where 1=1 and level_id=7 and branch_id in($branch_id)",$debug=-1);
                                                    };                                                    
                                                    echo $query=$obj->numRows($sql);                                                    
                                                    ?>

                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Filling
                                            Manager</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a <?php if ($_SESSION['level_id']==1){ ?>
                                        href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(8))) ?>"
                                        <?php } ?>>
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php if ($_SESSION['level_id']==1){
                                                    $sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=8",$debug=-1); 
                                                    }else {
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                    $sql=$obj->query("select * from tbl_admin where 1=1 and level_id=8 and branch_id in($branch_id)",$debug=-1);
                                                    };                                                    
                                                    echo $query=$obj->numRows($sql);                                                    
                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Filling
                                            Executive</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($_SESSION['level_id']==1){ ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="application-list.php">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php if ($_SESSION['level_id']==1){
                                                    $sql=$obj->query("select * from $tbl_student_application where 1=1",$debug=-1); 
                                                    }else {
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                    $sql=$obj->query("select * from tbl_student_application where 1=1 ",$debug=-1);
                                                    };                                                    
                                                    echo $query=$obj->numRows($sql);
                                                    ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Total
                                            Application</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php                             
                                                        $condition = '';
                                                        if($_SESSION['level_id']==10 || $_SESSION['level_id']==19){
                                                            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                            $condition = " and a.branch_id in ($branch_id)";
                                                            }elseif(in_array(3,$addtional_role) || $_SESSION['level_id']==12){
                                                                $condition = " and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
                                                        }
                                                        $visaSql1 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id  where 1=1 and b.parent_id=0  and a.visa_id=1 and b.stage_id=13  and b.cstatus='Visa Approved' $condition",$debug=-1);
                                                        echo $VisaResult1=$obj->numRows($visaSql1);
                                                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block">Visa
                                            Approved</span>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<?php
                $whr = '';
                $addtional_role = explode(',',$_SESSION['additional_role']);
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id'] == 2  || $_SESSION['level_id']==3 || $_SESSION['level_id']==4 || in_array(2,$addtional_role)){
                if($_SESSION['level_id'] == 2  || $_SESSION['level_id']==19 || in_array(2,$addtional_role)){
                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                    $whr .= " and b.branch_id in ($branch_id)";
                }
                if($_SESSION['level_id'] == 3){
                    $account_manager_id = $_SESSION['sess_admin_id'];
                    $whr .= " and b.am_id in ($account_manager_id)";
                }
                if($_SESSION['level_id'] == 4){
                    $counsellor_id = $_SESSION['sess_admin_id'];
                    $whr .= " and b.c_id in ($counsellor_id)";
                }
                ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <h5>USA Application Details</h5>
    </div>
</div>
<form method="post" name="searchfrm" id="searchfrm" action="application-list.php">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Total Application')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql1 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!=''",$debug=-1);
                        $linem1=$obj->fetchNextObject($appsql1);
                        echo $linem1->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Total
                                                Application</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('University Allotted')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql2 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='University Allotted'",$debug=-1);
                        $appline2=$obj->fetchNextObject($appsql2);
                        echo $appline2->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">University
                                                Allotted</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Application Incomplete')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql3 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Application Incomplete'",$debug=-1);
                        $appline3=$obj->fetchNextObject($appsql3);
                        echo $appline3->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Application
                                                Incomplete</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Intake Closed')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql4 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Intake Closed'",$debug=-1);
                        $appline4=$obj->fetchNextObject($appsql4);
                        echo $appline4->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Intake
                                                Closed</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Application Submitted')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql5 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1  $whr and a.app_id!='' and a.status='Application Submitted'",$debug=-1);
                        $appline5=$obj->fetchNextObject($appsql5);
                        echo $appline5->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Application
                                                Submitted</span>
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

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Offer Received')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql6 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Offer Received'",$debug=-1);
                        $appline6=$obj->fetchNextObject($appsql6);
                        echo $appline6->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Offer
                                                Received</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Offer Rejected')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql7 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Offer Rejected'",$debug=-1);
                        $appline7=$obj->fetchNextObject($appsql7);
                        echo $appline7->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Offer
                                                Rejected</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Deposit Paid')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql8 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Deposit Paid'",$debug=-1);
                        $appline8=$obj->fetchNextObject($appsql8);
                        echo $appline8->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Deposit
                                                Paid</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Funds Pending')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql9 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Funds Pending'",$debug=-1);
                        $appline9=$obj->fetchNextObject($appsql9);
                        echo $appline9->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Funds
                                                Pending</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Financials Done')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql10 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Financials Done'",$debug=-1);
                        $appline10=$obj->fetchNextObject($appsql10);
                        echo $appline10->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Financials
                                                Done</span>
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

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('Financials Rejected')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql11 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='Financials Rejected'",$debug=-1);
                        $appline11=$obj->fetchNextObject($appsql11);
                        echo $appline11->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Financials
                                                Rejected </span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('I-20 Received')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql12 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='I-20 Received'",$debug=-1);
                        $appline12=$obj->fetchNextObject($appsql12);
                        echo $appline12->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">I-20
                                                Received</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord('I-20 Deferred')">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $appsql13 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 $whr and a.app_id!='' and a.status='I-20 Deferred'",$debug=-1);
                        $appline13=$obj->fetchNextObject($appsql13);
                        echo $appline13->num_rows;
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">I-20
                                                Deferred</span>
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
</form>
<?php }?>






<?php
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){
                $condition = '';
                if($_SESSION['level_id']==10 || $_SESSION['level_id']==19){
                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                    $condition = " and a.branch_id in ($branch_id)";
                    }elseif(in_array(3,$addtional_role) || $_SESSION['level_id']==12){
                        $condition = " and c.slot_executive_id='".$_SESSION['sess_admin_id']."'";
                }
                ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <h5>Visa Outcomes</h5>
    </div>
</div>
<form method="post" name="searchfrm2" id="searchfrm2" action="student-list.php">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)"
                                            <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){ ?>
                                            onclick="getAppRecord2('Total Visa Outcomes')" <?php } ?>>
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $visaSql = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0  and a.visa_id=1 and b.stage_id=13 $condition",$debug=-1);
                        echo $VisaResult=$obj->numRows($visaSql);
                        //13 Visa Approved
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Total
                                                Visa Outcomes</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)"
                                            <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==19 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){ ?>
                                            onclick="getAppRecord2('Visa Approved')" <?php } ?>>
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php                             

                        $visaSql1 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id  where 1=1 and b.parent_id=0  and a.visa_id=1 and b.stage_id=13  and b.cstatus='Visa Approved' $condition",$debug=-1);
                        echo $VisaResult1=$obj->numRows($visaSql1);
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)"
                                            <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){ ?>
                                            onclick="getAppRecord2('Visa Refused')" <?php } ?>>
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $visaSql3 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id  where 1=1 and b.parent_id=0  and a.visa_id=1 and b.stage_id=13  and b.cstatus='Visa Refused' $condition",$debug=-1);
                        echo $VisaResult2=$obj->numRows($visaSql3);
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)"
                                            <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){ ?>
                                            onclick="getAppRecord2('Status Unknown')" <?php } ?>>
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                        $visaSql3 = $obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id  left join $tbl_appointment as c on c.student_id=a.id where 1=1 and b.parent_id=0  and a.visa_id=1 and b.stage_id=13 and b.cstatus='Status Unknown' $condition",$debug=-1);
                        echo $VisaResult3=$obj->numRows($visaSql3);
                        ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Status
                                                Unknown</span>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)"
                                            <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==10  || $_SESSION['level_id']==19){ ?>
                                            onclick="getAppRecord2s('Pending Visa Outcomes')" <?php } ?>>
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php echo $VisaResult-$VisaResult1-$VisaResult2-$VisaResult3; ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Pending
                                                Visa Outcomes</span>
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
</form>
<?php }?>
<?php
                if($_SESSION['level_id']==1 || $_SESSION['level_id'] == 2  || $_SESSION['level_id']==3 || $_SESSION['level_id']==4  || in_array(2,$addtional_role)){
                $whra = '';
                if($_SESSION['level_id'] == 2  || in_array(2,$addtional_role)){
                $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                $whra .= " and a.branch_id in ($branch_id)";
                }
                if($_SESSION['level_id'] == 3){
                $account_manager_id = $_SESSION['sess_admin_id'];
                $whra .= " and a.am_id in ($account_manager_id)";
                }
                if($_SESSION['level_id'] == 4){
                $counsellor_id = $_SESSION['sess_admin_id'];
                $whra .= " and a.c_id in ($counsellor_id)";
                }
                ?>
<div div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        <h5>Other Details</h5>
    </div>
</div>
<div class="row">
    <form action="student-list.php" method="post" id="sent_not_submit">

    </form>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="sm-data-box">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                    <a href="javascript:void(0)" onclick="getAppRecords('Not Submit')">
                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                <?php
                                                            
                        $visaSql = $obj->query("select count(a.id) as num_rows from $tbl_student as a inner join $tbl_student_updated_time as d ON a.id=d.stu_id where 1=1  $whra and TIMESTAMPDIFF(HOUR, d.cdate, NOW()) > 30",$debug=-1);
                        $VisaResult=$obj->fetchNextObject($visaSql);
                        echo $VisaResult->num_rows;
                        ?>
                                            </span></span>
                                        <span class="weight-500 uppercase-font block font-13">Application
                                            Not Submitted</span>
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
<?php } ?>
</div>

<?php
}
?>

<script>
function go_urls(url, branch_id, executive_id, from_date, to_date, data) {
    window.location.href = url + '?branch_id=' + branch_id + '&filter_start_date=' + from_date + '&filter_end_date=' +
        to_date;
}
</script>