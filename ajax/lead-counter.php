<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
$whr = '';
$whr1 = '';
$whr2 = '';
$whr3 = '';
$todate = date('Y-m-d');
$mtodate = date('Y-m-d',strtotime('-1 Days'));
if($_SESSION['whr']!=''){
  $whr = $_SESSION['whr'];
}
if($_SESSION['whr1']!=''){
  $whr1 = $_SESSION['whr1'];
}
if($_SESSION['whr2']!=''){
  $whr2 = $_SESSION['whr2'];
}
if($_SESSION['whr3']!=''){
  $whr3 = $_SESSION['whr3'];
}
if($_SESSION['whr4']!=''){
  $whr3 = $_SESSION['whr4'];
}
$addtional_role = explode(',',$_SESSION['additional_role']);


?>


    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
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
                                                                $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and b.enquiry_type!='Re-apply' $whr1 ",$debug=-1);
                                                                $line6=$obj->fetchNextObject($sql);
                                                                echo $enrollCount=$line6->num_rows;
                                                                ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Visited</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-12 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="panel panel-default card-view pa-0">
                <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                        <div class="sm-data-box">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 text-center pl-0 pr-0 data-wrap-left">
                                        <a href="javascript:void(0)" onclick="getAppRecord(15)">
                                            <span class="txt-dark block counter"><span class="counter-anim">
                                                    <?php
                                                                $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no ) where 1=1 and b.enquiry_type!='Re-apply'  $whr3 ",$debug=-1);
                                                                $line6=$obj->fetchNextObject($sql);
                                                                echo $enrollCount=$line6->num_rows;
                                                                ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Total
                                                Visited</span>
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
                              $obj->query("SELECT COUNT(a.applicant_contact_no) as num_rows FROM $tbl_lead as a WHERE NOT EXISTS ( SELECT b.applicant_contact_no FROM $tbl_visit as b  WHERE (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no )) $whr1 ",$debug=-1);
                              $line7=$obj->fetchNextObject($sql);
                             echo $enrollCount=$line7->num_rows;
                              //echo $totallead-$enrollCount;
                              ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Not
                                                Visited</span>
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
                              $obj->query("select COUNT(a.id) as num_rows from $tbl_lead as a join $tbl_visit as b on (a.applicant_contact_no=b.applicant_contact_no or a.applicant_alternate_no=b.applicant_alternate_no or a.applicant_contact_no=b.applicant_alternate_no or a.applicant_alternate_no=b.applicant_contact_no )  inner join $tbl_visa_sub_type as d on b.visa_sub_type=d.id join $tbl_student as c on (a.applicant_contact_no=c.student_contact_no or a.applicant_alternate_no=c.student_contact_no or a.applicant_alternate_no=c.alternate_contact or a.applicant_contact_no = c.alternate_contact) where 1=1  and d.enrollment_count=1 $whr1 ",$debug=-1);
                              $line8=$obj->fetchNextObject($sql);
                              echo $enrollCount=$line8->num_rows;
                              ?>
                                                </span></span>
                                            <span class="weight-500 uppercase-font block font-13">Enrolled</span>
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