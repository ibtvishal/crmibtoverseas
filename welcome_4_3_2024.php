<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from hencework.com/theme/philbert/full-width-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 May 2023 05:24:49 GMT -->

<head>
    <?php include('head.php'); ?>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!-- /Preloader -->
    <div class="wrapper theme-1-active pimary-color-green">
        <!-- Top Menu Items -->
<!--  -->
        <?php include("menu.php"); ?>
        <!-- /Top Menu Items -->
        <!-- Main Content -->
        <div class="page-wrapper">

        <div class="container-fluid pt-25">
                <!-- Row -->
                <div class="row">

                    <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2) {?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                  <a href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(3))) ?>">
                                                    <span class="txt-dark block counter"><span class="counter-anim"><?php
                                                        if ($_SESSION['level_id']==1){
                                                        $sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=3",$debug=-1); 
                                                        }else {
                                                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                    
                                                        $sql=$obj->query("select * from tbl_admin where 1=1 and level_id=3 and branch_id in($branch_id)",$debug=-1);
                                                        };
                                                    
                                                      echo $query=$obj->numRows($sql);
                                                     
                                                   ?></span></span>

                                                    <span class="weight-500 uppercase-font block font-13">Account Manager</span>
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
                        if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3 ) {
                      ?>
                      <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                  <a href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(4))) ?>">
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

                    <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3  || $_SESSION['level_id']==4 || $_SESSION['level_id']==5 || $_SESSION['level_id']==6 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8) {
                      ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                  <a href="<?php if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?> student-diploma.php <?php }else{?>student-list.php <?php }?>">
                                                    <span class="txt-dark block counter"><span class="counter-anim"><?php

                                                if ($_SESSION['level_id']==4){
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."'",$debug=-1);
                                                }else if ($_SESSION['level_id']==1){
                                                  $sql=$obj->query("select * from $tbl_student where 1=1",$debug=-1); 
                                                }elseif ($_SESSION['level_id']==2) {
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                 
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id)",$debug=-1);
                                                }elseif ($_SESSION['level_id']==3) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."'",$debug=-1);
                                                }elseif ($_SESSION['level_id']==5) {
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                  $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request'",$debug=-1);
                                                }elseif ($_SESSION['level_id']==6) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                   $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.diploma_id,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.media_gap_status,b.pimg,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.student_approval_status=1",$debug=-1);
                                                }elseif ($_SESSION['level_id']==7) {
                                                   	  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                      $msql = "select a.*";
						                              $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id)";
						                        
						                              $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','Proceed on Dummy I-20','CAS Received')";                              
						                              $msql .=" $whr1 group by a.id";
						                              //echo $msql; die;
						                              $sql=$obj->query($msql);
                                                }elseif ($_SESSION['level_id']==8) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                   $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' ",$debug=-1);
                                                }
                                                     echo $obj->numRows($sql); ?></span></span>
                                                    <span class="weight-500 uppercase-font block">
                                                        <?php
                                                        if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                                            Manage Diploma
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
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' and am_id=0",$debug=-1);
                                                }else if ($_SESSION['level_id']==1){
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and am_id=0",$debug=-1); 
                                                }elseif ($_SESSION['level_id']==2) {
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                 
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id=0",$debug=-1);
                                                }elseif ($_SESSION['level_id']==3) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                  $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' and am_id=0",$debug=-1);

                                                }elseif ($_SESSION['level_id']==5) {
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                  $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,c.name as company_name from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request'",$debug=-1);
                                                }elseif ($_SESSION['level_id']==6) {
                                                  $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                   $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,b.counsellor_status,b.pimg,c.name as company_name from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.address_proof=1",$debug=-1);
                                               }elseif ($_SESSION['level_id']==7) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
					                              $msql = "select a.*";
					                              $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id)";
					                        
					                              $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','Proceed on Dummy I-20','I-20 Issued','CAS Received')";                              
					                              $msql .=" and a.am_id =0 group by a.id";
					                              //echo $msql; die;
					                              $sql=$obj->query($msql);
                                                }elseif ($_SESSION['level_id']==8) {
                                                   $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                   $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' ",$debug=-1);
                                                }

                                                     echo $obj->numRows($sql); ?></span></span>
                                                    <span class="weight-500 uppercase-font block">
                                                    <?php
                                                        if($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                                            Manage Experience
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
                if($_SESSION['level_id']==1){?>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                  <a href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(7))) ?>">
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
                                                    <span class="weight-500 uppercase-font block">Filling Manager</span>
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
                                                  <a href="employee-list.php?level_id=<?php echo base64_encode(base64_encode(base64_encode(8))) ?>">
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
                                                    <span class="weight-500 uppercase-font block">Filling Executive</span>
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
                                                    <span class="weight-500 uppercase-font block">Total Application</span>
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
                                                    <span class="txt-dark block counter"><span class="counter-anim">0</span></span>
                                                    <span class="weight-500 uppercase-font block">Visa Approved</span>
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
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><h5>USA Application Details</h5></div>
        </div>
        <form method="post" name="searchfrm" id="searchfrm" action="application-list.php" >
        <div class="row">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
                              $appsql1 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!=''",$debug=-1);
                              $linem1=$obj->fetchNextObject($appsql1);
                              echo $linem1->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Total Application</span>
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
                           <a href="javascript:void(0)" onclick="getAppRecord('University Allotted')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                               <?php
                              $appsql2 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='University Allotted'",$debug=-1);
                              $appline2=$obj->fetchNextObject($appsql2);
                              echo $appline2->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">University Allotted</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Application Incomplete')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql3 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Application Incomplete'",$debug=-1);
                              $appline3=$obj->fetchNextObject($appsql3);
                              echo $appline3->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Application Incomplete</span>
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
                           <a href="javascript:void(0)" onclick="getAppRecord('Intake Closed')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql4 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Intake Closed'",$debug=-1);
                              $appline4=$obj->fetchNextObject($appsql4);
                              echo $appline4->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Intake Closed</span>
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
                           <a href="javascript:void(0)" onclick="getAppRecord('Application Submitted')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql5 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Application Submitted'",$debug=-1);
                              $appline5=$obj->fetchNextObject($appsql5);
                              echo $appline5->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Application Submitted</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Offer Received')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql6 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Offer Received'",$debug=-1);
                              $appline6=$obj->fetchNextObject($appsql6);
                              echo $appline6->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Offer Received</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Offer Rejected')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql7 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Offer Rejected'",$debug=-1);
                              $appline7=$obj->fetchNextObject($appsql7);
                              echo $appline7->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Offer Rejected</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Deposit Paid')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql8 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Deposit Paid'",$debug=-1);
                              $appline8=$obj->fetchNextObject($appsql8);
                              echo $appline8->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Deposit Paid</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Funds Pending')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql9 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Funds Pending'",$debug=-1);
                              $appline9=$obj->fetchNextObject($appsql9);
                              echo $appline9->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Funds Pending</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Financials Done')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql10 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Financials Done'",$debug=-1);
                              $appline10=$obj->fetchNextObject($appsql10);
                              echo $appline10->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Financials Done</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('Financials Rejected')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql11 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='Financials Rejected'",$debug=-1);
                              $appline11=$obj->fetchNextObject($appsql11);
                              echo $appline11->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">Financials Rejected </span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('I-20 Received')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql12 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='I-20 Received'",$debug=-1);
                              $appline12=$obj->fetchNextObject($appsql12);
                              echo $appline12->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">I-20 Received</span>
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
                            <a href="javascript:void(0)" onclick="getAppRecord('I-20 Deferred')">
                            <span class="txt-dark block counter"><span class="counter-anim">
                              <?php
                              $appsql13 = $obj->query("select COUNT(a.id) as num_rows from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and a.app_id!='' and a.status='I-20 Deferred'",$debug=-1);
                              $appline13=$obj->fetchNextObject($appsql13);
                              echo $appline13->num_rows;
                              ?>
                            </span></span>
                            <span class="weight-500 uppercase-font block font-13">I-20 Deferred</span>
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

                <?php
                if($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8){?>
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-7 col-sm-12 col-xs-12">
                        <div class="panel panel-default card-view panel-refresh">
                            <div class="refresh-container">
                                <div class="la-anim-1"></div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">Manage Student</h6>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="pull-left inline-block refresh mr-15">
                                        <i class="zmdi zmdi-replay"></i>
                                    </a>
                                    <a href="#" class="pull-left inline-block full-screen mr-15">
                                        <i class="zmdi zmdi-fullscreen"></i>
                                    </a>                                   
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body row pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                      <th>Student Id</th>
                                                      <th>Date</th>
                                                      <th>Name</th>
                                                      <th>Father Name</th>
                                                      <th>Passport No.</th>
                                                      <th>Country</th>
                                                      <th>Counseller Name</th>
                                                      <th>Account Manager</th>
                                                      <th>Branch Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                            <?php
                            $i=1;
                             if ($_SESSION['level_id']==4){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' order by id desc limit 10",$debug=-1);
                            }else if ($_SESSION['level_id']==1){
                              $sql=$obj->query("select * from $tbl_student where 1=1 order by id desc limit 10",$debug=-1); 
                            }elseif ($_SESSION['level_id']==2) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                             
                              $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) order by id desc limit 20",$debug=-1);
                            }elseif ($_SESSION['level_id']==3) {
                               $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' order by id desc limit 20",$debug=-1);
                             }elseif ($_SESSION['level_id']==7) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $msql="select a.*,b.stage_id,b.cstatus";
                              $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id)";
                        
                              $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24,16) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','CAS Received','GIC Paid') order by a.id desc limit 20";
                              //echo $msql; die;
                              $sql=$obj->query($msql);
                             }elseif ($_SESSION['level_id']==8) {
                               $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' $whr1 group by a.id order by id desc limit 20",$debug=-1);

                            }

                            while($line=$obj->fetchNextObject($sql)){

                            	if($line->country_id==1){
                                $showval = 0;
                                if($line->stage_id==3 && $line->cstatus=='Tuition Fees Paid'){
                                  $rsql = $obj->query("select stage_id,cstatus from $tbl_student_status where stu_id='".$line->id."'");
                                  $rResult = $obj->fetchNextObject($rsql);
                                  if($rResult->stage_id==16 && $rResult->cstatus=='GIC Paid'){
                                    $showval = 1;
                                  }
                                }else if($line->stage_id==16 && $line->cstatus=='GIC Paid'){
                                  $rsql = $obj->query("select stage_id,cstatus from $tbl_student_status where stu_id='".$line->id."'");
                                  $rResult = $obj->fetchNextObject($rsql);
                                  if($rResult->stage_id==3 && $rResult->cstatus=='Tuition Fees Paid'){
                                    $showval = 1;
                                  }
                                }
                                
                              }else{
                                $showval = 1;
                              }
                            	if($showval == 1){
                                $color='';
                                if($_SESSION['level_id']==3){
                                  if($line->application_check==1){
                                    $color = "style='color:blue'";
                                  }else if($line->accept_student==0 || $line->am_id==0){
                                    $color = "style='color:red'";    
                                  }
                                                              
                                }else if($_SESSION['level_id']==7){
                                  $sqlf = $obj->query("select fe_id from $tbl_filing_credentials where student_id='".$line->id."'");
                                  $ResultF = $obj->fetchNextObject($sqlf);
                                  if($ResultF->fe_id==0){
                                    $color = "style='color:red'";
                                  }
                                }else if($_SESSION['level_id']==8){
                                  $sqlf = $obj->query("select pstatus from $tbl_filing_credentials where student_id='".$line->id."'",-1);
                                  $ResultF = $obj->fetchNextObject($sqlf);
                                  if($ResultF->psatus==0)
                                  {
                                    $color = "style='color:red'";
                                  }
                                }
                                ?>
                              <tr <?php echo $color; ?> >
                                <td><?php echo $line->student_no ?></td>
                                <td><?php echo date("d M y",strtotime($line->cdate)); ?></td>
                                <td><?php echo $line->stu_name ?></td>
                                <td>
                                   <?php 
                                    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
                                    $rResult = $obj->fetchNextObject($rSql);
                                    echo $rResult->name;
                                    ?> 
                                </td>
                                <td><?php echo $line->passport_no ?></td>
                                <td><?php echo getField('name',$tbl_country,$line->country_id) ?></td>
                                <td><?php echo getField('name',$tbl_admin,$line->c_id) ?></td>
                                <td><?php echo getField('name',$tbl_admin,$line->am_id) ?></td>
                                <td><?php echo getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id)) ?></td>
                                </tr>
                                <?php ++$i; } 
                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>  
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>  
                <?php }?>
               
            </div>
          
            <!-- Footer -->
            <footer class="footer container-fluid pl-30 pr-30">
                <div class="row">
                    <div class="col-sm-12">
                        <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                    </div>
                </div>
            </footer>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->

    <!-- JavaScript -->
    <?php include("footer.php"); ?>

    <!-- jQuery -->
    
</body>

<script type="text/javascript">
    /*Accordion js*/
        $(document).on('show.bs.collapse', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').addClass('activestate');
    });
    
    $(document).on('hide.bs.collapse', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').removeClass('activestate');
    });
    $(".panel-heading").on("click", function() {
  $(".panel-heading").removeClass("activestate");
});



    function getAppRecord(status){
      $('#searchfrm').append('<input name="status" value="'+status+'" type="hidden"/>');
      $("#searchfrm").submit();
   }
</script>


<!-- Mirrored from hencework.com/theme/philbert/full-width-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 May 2023 05:25:18 GMT -->
<script type="text/javascript">


</script>

</html>