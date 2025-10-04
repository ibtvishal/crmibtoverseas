<?php 
include('include/config.php');
include("include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
</head>
<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container">

                <h5 style="color:#2a911d; text-align: center;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">Edit Enquiry</h4>
                    <form method="post" action="" name="studentfrm" id="studentfrm" enctype= multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-calendar-days" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="required form-control" placeholder="ENQUIRY ID" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-calendar-days" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="required form-control" placeholder="ENQUIRY DATE" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-newspaper" style="font-size:15px;"></i></span></div>
                                        <input type="text" class="required form-control" placeholder="COUNSELLOR" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-newspaper" style="font-size:15px;"></i></span></div>
                                        <input type="text" class="required form-control" placeholder="TELECALLER" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="required form-control" placeholder="Applicant Name" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user" style="font-size:15px;"></i></span></div>
                                        <input type="text" class="required form-control" placeholder="Father Name" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-calendar" style="font-size:15px;"></i></span></div>
                                        <input type="date" class="required form-control" placeholder="Date Of Birth" name="dob" id="dob" value="<?php echo stripslashes($result->dob); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"> <span><i class="fa-solid fa-people-group" style="font-size:15px;"></i></span></div>
                                        <select class="required form-control" name="country_id" id="country_id">
                                            <option value="">Marital Status</option>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                                <option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6" id="">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon text-uppercase"><span><i class="fa-solid fa-phone-volume" style="font-size:15px;"></i></span> </div>                                        
                                        <input type="text" class="form-control" placeholder="Phone NUmber" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon text-uppercase"><span><i class="fa-solid fa-tty" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="form-control" placeholder="Alternate NUmber" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon text-uppercase"><span><i class="fa-solid fa-house" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="form-control" placeholder="Address" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                <div class="text-uppercase" style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;"><span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span> <Span> Visa type</Span></div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        study
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        study
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        study
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        study
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2 form-group" style="display:flex;gap:10px;">
                                <div class="input-group-addon text-uppercase" style="height: 35px;"> <span><i class="fa-solid fa-message" style="font-size:15px;  margin-top:10px;"></i></span> </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        Yes
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="required form-control" name="student_type" id="student_type">
                                            <option value="">Select State</option>
                                            <option value="1" selected <?php if($result->student_type==1){?> selected <?php } ?>>New</option>
                                            <option value="2" <?php if($result->student_type==2){?> selected <?php } ?>>Defer</option>
                                            <option value="3" <?php if($result->student_type==3){?> selected <?php } ?>>Refused</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="view-details" style="padding: 0 15px; display:none;">
                            <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Educational Deatils</h6></div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <P style="text-align: center; text-transform: uppercase;background:#4b4b4d; padding:5px; color:white; border-radius:5px;">Matriculation</P>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="BOARD" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p style="text-align: center; text-transform: uppercase;background:#4b4b4d; padding:5px; color:white; border-radius:5px;">SENIOR SECONDARY :</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="BOARD" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">                           
                                        <input type="text" class="form-control" placeholder="STREAM" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p style="text-align: center; text-transform: uppercase;background:#4b4b4d; padding:5px; color:white; border-radius:5px;">ANY DIPLOMA:</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="INSTITUTE/UNIVERSITY" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">                           
                                        <input type="text" class="form-control" placeholder="STREAM" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p style="text-align: center; text-transform: uppercase;background:#4b4b4d; padding:5px; color:white; border-radius:5px;">BACHELOR</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="UNIVERSITY/INSTITUTE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">                           
                                        <input type="text" class="form-control" placeholder="DEGREE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p style="text-align: center; text-transform: uppercase;background:#4b4b4d; padding:5px; color:white; border-radius:5px;">MASTERS:</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="UNIVERSITY/INSTITUTE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">                           
                                        <input type="text" class="form-control" placeholder="DEGREE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="display:flex; gap:15px;">
                                    <div class="input-group" style="width:80%;">                           
                                        <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                    <div class="input-group" style="width:20%;">                           
                                        <div style="width:40px; height:30px; background-color:lightgray; padding-top:6px; text-align:center;">
                                            <Span><i class="fa-solid fa-plus" style="font-size:20px;margin-bottom:14px;"></i></Span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row form-group" id="view-details" style="padding: 0 15px; display:none;">
                            <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Language Proficiancy Details</h6></div>
                        </div>
                        <div class="row" id="view-details"  style="display:none;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="LISTENING" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="READING" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="WRITING" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="SPEAKING" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="OVERALL BANDS/SCORES" name="student_contact_no" id="student_contact_no" value="" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="view-details"  style="display:none;">
                            <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                <div class="text-uppercase" style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;"><span>EXAM TIME</span></div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked=""> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        IELTS
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked=""> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        PTE
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked=""> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        TOEFL
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked=""> &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                        DUOLINGO
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="view-details" style="padding: 0 15px; display:none;">
                            <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Employment Details</h6></div>
                        </div>
                        <div class="row" id="view-details" style="display:none;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="COMPANY NAME" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">                           
                                        <input type="text" class="form-control" placeholder="DESIGNATION" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="display:flex; gap:15px;">
                                    <div class="input-group" style="width:80%;">                           
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                    </div>
                                    <div class="input-group" style="width:20%;">                           
                                        <button style="border:none; width:40px; height:30px; background-color:lightgray; padding-top:6px; text-align:center;">
                                            <Span><i class="fa-solid fa-plus" style="font-size:20px;margin-bottom:14px;"></i></Span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" id="view-details" style="padding: 0 15px; display:none;">
                                <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Available Family Funds</h6></div>
                            </div>
                            <div class="row form-group" id="view-details" style="display:none;">
                                <div class="col-md-12">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="TOTAL FUNDS AVAILABLE IN ALL ACCOUNTS" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" id="view-details" style="display:none; padding: 0 15px;">
                                <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">HOW DID YOU FIND US ?</h6></div>
                            </div>
                            <div class="row"  id="view-details" style="display:none; padding: 0 15px;">
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Youtube
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Facebook
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Instagram
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Goggle
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            website
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Hoarding/Banner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Friends
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Paper Ad
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Seminar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            other
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group"  style="padding:0 15px; display:flex; justify-content: center;">
                                <div><Button class="btn btn-primary" id="view-btn" onclick="myFunction()" style="border:none;">View details</Button></div>
                            </div>
                            <div class="row form-group" style="padding:0 15px;">
                                <div><h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Remark</h6></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group-addon text-uppercase text-upparcase" style="height: 35px; color: #fff;">Inital remark</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="width:100%;">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="required form-control" placeholder="ENTER REMARK" name="stu_name" id="stu_name" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group-addon text-uppercase" style="height: 35px; color: #fff;">Follow up 2</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group-addon text-uppercase" style="height: 35px; color: #fff;">Follow up 3</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group-addon text-uppercase" style="height: 35px; color: #fff;">Last Follow up</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group-addon text-uppercase" style="height: 35px; color: #fff;">Status</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected="">New</option>
                                                <option value="2">Defer</option>
                                                <option value="3">Refused</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group" style="width:100%;">
                                        <select class="required form-control" name="student_type" id="student_type">
                                            <option value="">Select State</option>
                                            <option value="1" selected="">New</option>
                                            <option value="2">Defer</option>
                                            <option value="3">Refused</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>                   
                    </div>
                    <div class="row">
                        <div class="add_stdnt_btn">
                            <button type="submit" id="submitbtn"  class="btn mr-10">Submit</button>
                        </div>
                    </div>
                </form>
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <?php include("footer.php"); ?>
        <script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <link rel="stylesheet" href="calender/css/jquery-ui.css">
        <script src="calender/js/jquery-ui.js"></script>
    </body>
    </html>