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
                    <!-- <h4 class="my-3">Add Student</h4> -->
                    <form method="post" action="" name="studentfrm" id="studentfrm" enctype= multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">                       
                       
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

                        <div class="row">
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

                        <div class="row " style="margin-bottom:10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                <div class="input-group ">
                                    <div class="input-group-addon text-uppercase"><span><i class="fa-solid fa-location-dot"  style="font-size:15px;"></i></span> </div>
                                    <select class="required form-control" name="student_type" id="student_type">
                                        <option value="">Select State</option>
                                        <option value="1" selected <?php if($result->student_type==1){?> selected <?php } ?>>New</option>
                                        <option value="2" <?php if($result->student_type==2){?> selected <?php } ?>>Defer</option>
                                        <option value="3" <?php if($result->student_type==3){?> selected <?php } ?>>Refused</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <div class="input-group">
                                    
                                    <div class="input-group-addon text-uppercase"> <span><i class="fa-solid fa-city" style="font-size:15px;"></i></span> </div>
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

                        <div class="row">
                          <div class="col-md-2 form-group">
                                <div class="input-group">

                                            <div class="input-group-addon text-uppercase" STYLE="height: 35px; color: #fff;"> <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span> <Span> Visa type</Span> </div>
                                          
                                </div>
                            </div>

                            <div class="col-md-2 form-group"  >
                                <div class="input-group">

                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                    study
                                </label>
                                </div>
                            </div>

                            <div class="col-md-2 form-group " >
                                <div class="input-group">

                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>&nbsp;
                                <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                    Visitior/tourist
                                </label>
                                </div>
                            </div>
                            <div class="col-md-2 form-group " >
                                <div class="input-group">

                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                    Spouse
                                </label>
                                </div>
                            </div>
                            <div class="col-md-2 form-group"  >
                                <div class="input-group">

                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked> &nbsp;
                                <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                    Work
                                </label>
                                </div>
                            </div>
                        
                    </div>
                  
                    <div class="row " style="margin-top:10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                <div class="input-group">
                                            <div class="input-group-addon text-uppercase"> <span><i class="fa-solid fa-globe" style="font-size:15px;"></i></span> </div>
                                            <select class="required form-control" name="student_type" id="student_type">
                                                <option value="">Select State</option>
                                                <option value="1" selected <?php if($result->student_type==1){?> selected <?php } ?>>New</option>
                                                <option value="2" <?php if($result->student_type==2){?> selected <?php } ?>>Defer</option>
                                                <option value="3" <?php if($result->student_type==3){?> selected <?php } ?>>Refused</option>
                                            </select>
                                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                               <div class="input-group">
                                    
                                    <div class="input-group-addon text-uppercase"><i class="fa-solid fa-location-crosshairs" style="font-size:15px;"></i></div>
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

                        <div class="row ">
                            <div class="col-md-6">
                           <div class="form-group">

                           <div class="input-group" style="display:flex;">

                                <div class="input-group-addon text-uppercase" style="height: 35px;"> <span><i class="fa-solid fa-message" style="font-size:15px;  margin-top:10px;"></i></span> </div> &nbsp;
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="margin-left:10px;"> &nbsp;
                                    <label class="form-check-label" for="flexCheckDefault" style="margin-top:10px;">
                                        yes 
                                    </label>

                                    
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" style="margin-left:10px;"> &nbsp;
                                    <label class="form-check-label" for="flexCheckDefault" style="margin-top:10px;">
                                        NO 
                                    </label>
                                </div>
                           </div>
                            </div>
                            <div class="col-md-6">
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

                        <div class="row " style="margin:20px; display:flex; justify-content:center">
                            <div><h4 style="background:#4b4b4d;padding:10px; color:white;">Educational Deatils</h4></div>
                        </div>

                        <div class="row">
                            <h5 style="margin-left:15px; text-transform: uppercase;">Matriculation</h5>
                        <div class="col-md-12">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <!-- <div class="input-group-addon text-uppercase"><span><i class="fa-solid fa-house" style="font-size:15px;"></i></span> </div>                                         -->
                                                <input type="text" class="form-control" placeholder="BOARD" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5 style="margin-left:15px; text-transform: uppercase;">Senior Secondary :</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control text-uppercase" placeholder="BOARD" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="STREAM" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="FINISHER YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5 style="margin-left:15px; text-transform: uppercase;">Any Diploma</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="INSTITUTE/UNIVERSITY" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="STREAM" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5 style="margin-left:15px; text-transform: uppercase;">Bachelor</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="UNIVERSITY/INSTITUTE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="DEGREE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="ANY BACKLOG" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <h5 style="margin-left:15px; text-transform: uppercase;">Masters:</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="UNIVERSITY/INSTITUTE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="DEGREE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="START YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">                           
                                            <input type="text" class="form-control" placeholder="FINISH YEAR" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                                                           
                                            <input type="text" class="form-control" placeholder="PERCENTAGE" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="margin:0; padding:0;">
                            <div class="col-md-10">
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
                        </div>

                        <div class="row" style="margin:20px; display:flex; justify-content:center">
                            <div><h4 style="background:#4b4b4d;padding:10px; color:white;">Language proficiancy details</h4></div>
                        </div>

                        <div class="row" style="padding: 0 15px;">
                            <div class="col-md-12 exam-name" style="margin:0; padding:0; display:flex; flex-wrap:wrap; gap:20px;align-items: center;">
                                <div style="height: 35px; width: 90px; background: #4b4b4d; text-align: center; padding-top: 7px; color: white;">EXAM NAME</div>
                           <div style="display:flex;justify-content;center; gap:30px; text-align:center;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       IELTS
                                    </label>
                                    </div>

                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       PTE
                                    </label>
                                    </div>

                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        TOEFL
                                    </label>
                                    </div>

                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        DUOLINGO
                                    </label>
                                    </div>

                           </div>    
                           
                           
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                                            
                                                <input type="text" class="form-control" placeholder="LISTENING" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">                           
                                                <input type="text" class="form-control" placeholder="READING" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                                            
                                                <input type="text" class="form-control" placeholder="WRITING" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">                           
                                                <input type="text" class="form-control" placeholder="SPEAKING" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                                            
                                                <input type="text" class="form-control" placeholder="OVERALL BANDS/SCORES" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="input-group" style="width:100%;">
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                    </div>
                                </div>
                        </div>
                        <div class="row " style="margin:20px; display:flex; justify-content:center">
                            <div><h4 style="background:#4b4b4d;padding:10px; color:white;">Employment details</h4></div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                                            
                                                <input type="text" class="form-control" placeholder="COMPANY NAME" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                            <div class="input-group" style="width:100%;">                           
                                                <input type="text" class="form-control" placeholder="DESIGNATION" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                            </div>
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                         <div class="form-group">
                               <div class="input-group" style="width:100%;">
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                    </div>
                                </div>
                         </div>

                                <div class="col-md-6" style="margin:0; padding:0;">
                                <div class="col-md-10">
                                  <div class="form-group" style="display:flex; gap:15px;">
                                        <div class="input-group" style="width:80%;">                           
                                        <input type="date" class="form-control" placeholder="EXAM DATE" name="relation[0][dob]" value="">
                                        </div>
                                        <div class="input-group" style="width:20%;">                           
                                            <div style="width:40px; height:30px; background-color:lightgray; padding-top:6px; text-align:center;">
                                              <Span><i class="fa-solid fa-plus" style="font-size:20px;margin-bottom:14px;"></i></Span>
                                        </div>
                                        </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="row " style="margin:20px; display:flex; justify-content:center">
                            <div><h4 style="background:#4b4b4d;padding:10px; color:white;">Available Family funds</h4></div>
                        </div>

                        <div class="row">
                        <div class="col-md-12">
                            <div class="input-group" style="width:100%;">
                            <input type="text" class="form-control" placeholder="TOTAL FUNDS AVAILABLE IN ALL ACCOUNTS" name="student_contact_no" id="student_contact_no" value=""  maxlength="10">
                                    </div>
                                </div>
                        </div>

                        <div class="row " style="margin:20px; display:flex; justify-content:center">
                            <div><h4 style="background:#4b4b4d;padding:10px; color:white;">HOW DID YOU FIND US ?</h4></div>
                        </div>

                        <div class="row">
                           
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
                        </div>

                        
                    
                        <div class="row">
<div class="add_stdnt_btn">
    <button type="submit" id="submitbtn"  class="btn mr-10">Submit</button>
</div>
                        </div>
                           


<div class="row">
    <div class="col-md-5 text-center " style="padding: 30px 0; box-shadow:5px 5px 12px lightgray; background:white; margin-top:10px;">
    <div style="background:#4b4b4d; color:white;    width: 150px;    padding: 5px; text-align:center;     margin: 0 auto;">
    <h5 style="color:white;">office code</h5>
    </div>
      

    <div class="" style="display:flex; justify-content:center; align-items:center; margin-top:30px; gap:20px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">        
                                     
                      
    </div>
     
    
    </div>
</div>    

<div class="row gx-5" >
    <div class="col-md-5 text-center " style="padding: 30px 0; box-shadow:5px 5px 12px lightgray; background:white; margin-top:10px;">
    <div style="background:#4b4b4d; color:white;    width: 150px;    padding: 5px; text-align:center;     margin: 0 auto;">
    <h5 style="color:white;">Enquiry OTP</h5>
    </div>
      

    <div class="" style="display:flex; justify-content:center; align-items:center; margin-top:30px; gap:20px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">
                        <input class="form-control text-center m-1 code" type="text" min="0" max="9" placeholder="0" maxlength="1" required="" style="width: 50px;">        
                                     
                      
    </div>
    <p style="text-align:center; margin-top:10px;">Didn't receive OTP ?  <span class="text-primary"> <a href="#" class="text-decoration-none">Resend OTP</a> </span></p>
    <p style="text-align:center; margin-top:10px;"><span class="text-primary"> <a href="#" class="text-decoration-none">Change Number</a> </span></p>
    </div>

    <div class="col-md-5 text-center " style="padding: 30px 0; margin-left:20px; box-shadow:5px 5px 12px lightgray; height: 195px; background:white; margin-top:10px;">
    <div style="background:#4b4b4d; color:white;    width: 190px;    padding: 5px; text-align:center;     margin: 0 auto;">
    <h5 style="color:white;">Form submitted</h5>
    </div>
      

   
     
    
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
<script> 



    $(function() {

    	$(".extra_field").hide();
    	$("#er_extra_field").hide();


        $("#er_start_date0").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            changeMonth:true,
            changeYear:true,
            onSelect: function (selected) {
                $("#er_end_date0").datepicker("option", "minDate", selected);
            }

        });

        $("#er_end_date0").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            changeMonth:true,
            changeYear:true,
            onSelect: function (selected) {
                $("#er_start_date0").datepicker("option", "maxDate", selected);
                var start = $('#er_start_date0').val();
                var end = $('#er_end_date0').val();
                var action='getdays';
                $.ajax({
                    type:"post",
                    url:"ajax/getModalData.php",
                    data :{'start_date' : start,'end_date' : end,'action': action },          
                    success:function(res){
// $(".start_date").val(start);

$("#er_time_duration0").val(res);

}
});

            }

        });


        $("#dr_start_date0").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            changeMonth:true,
            changeYear:true,
            onSelect: function (selected) {
                $("#dr_end_date0").datepicker("option", "minDate", selected);
            }
        });

        $("#dr_end_date0").datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 1,
            changeMonth:true,
            changeYear:true,
            onSelect: function (selected) {
                $("#dr_start_date0").datepicker("option", "maxDate", selected);
                var start = $('#dr_start_date0').val();
                var end = $('#dr_end_date0').val();
                var action='getdays';
                $.ajax({
                    type:"post",
                    url:"ajax/getModalData.php",
                    data :{'start_date' : start,'end_date' : end,'action': action },          
                    success:function(res){
                        $("#time_duration0").val(res);
                    }
                });              

            }
        });



    });



    

    

    $("#country_id").change(function() {
        var id = this.value;
        $.ajax({
            type: "GET", 
            url: 'ajax/getModalData.php',
            data: {id:id,type:'getUCRState'},
            beforeSend: function () {
            },
            success: function (response) {
                //console.log(response);
                $(".state_id").html(response);
            }
        });

        $.ajax({
            type: "GET", 
            url: 'ajax/getModalData.php',
            data: {id:id,type:'getState'},
            beforeSend: function () {
            },
            success: function (response) {
                $("#mstate_id").html(response);
            }
        });

    });

    $('#state_id0').change(function() {
        var id = $('#state_id0').val();
        var action='get_UCR_state_id'
        $.ajax({
            type:"post",
            url:"ajax/getModalData.php",
            data :{
                'key' : id,'action': action              
            },          
            success:function(res){

                $('#univercity_id0').html(res); 

            }
        });
    });

    $('#univercity_id0').change(function() {
        var id = $('#univercity_id0').val();
        var action='get_UCR_course_id'
        $.ajax({
            type:"post",
            url:"ajax/getModalData.php",
            data :{
                'key' : id,'action': action              
            },          
            success:function(res){

                $('#course_id0').html(res); 

            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $("#studentfrm").validate();
    var maxField = 10; //Input fields increment limitation 

    //============================================================relation===================================================
    var addrelationButton = $('.add_field_relation');
    var wrapperrelation = $('#add_relation');
    var relex = 1;
    $(addrelationButton).click(function(){
    if(relex < maxField){ 
        if(relex==1){
            $toplength = "top: 81%;";
        }else{
            $toplength = "top: 10%;";
        }
    relex++;
    $(wrapperrelation).append('<div class="course_add1" style="position:relative"><div class="row" style="margin-left:0px;"><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Relation.</div><select class="form-control" name="relation['+relex+'][relation]"><option value="">Select Relation</option><option value="1">Father</option><option value="2">Mother</option></select></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Name</div><input type="text" class="form-control" placeholder="Name" name="relation['+relex+'][name]" value=""  maxlength="50"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Date of Birth</div><input type="date" class="form-control required" name="relation['+relex+'][dob]" value=""></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Contact No.</div><input type="text" class="form-control" placeholder="Contact No" name="relation['+relex+'][contact_no]" value=""  maxlength="10"></div></div></div><div class="col-md-4"><div class="form-group"><div class="input-group"><div class="input-group-addon">Email ID.</div><input type="text" class="form-control" placeholder="Email ID" name="relation['+relex+'][email]" value="" maxlength="50"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Sponser</div><select name="relation['+relex+'][sponser]" id="sponser" class="form-control required"><option value="">Select</option><option value="1">Yes</option><option value="2">No</option></select></div></div></div></div><a href="#" class="remove_relation_field delete_btn" style="position: absolute;'+$toplength+' right: 74px;">X</a></div>');
    }
    });

    $(wrapperrelation).on('click', '.remove_relation_field', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
        relex--;
    });
    //============================================================relation===================================================


    var addButton = $('.add_field_button'); //Add button selector

    var wrapper = $('#add'); //Input field wrapper
    <?php
    if($_REQUEST['id']!=''){?>
    var x = <?php echo $i-1; ?>; //Initial field counter is 1
    var y = <?php echo $i; ?>
    <?php }else{?>
    var x = 0; //Initial field counter is 1
    var y = 0;
    <?php }?>
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
        x++; //Increment field counter
        y++; //Increment field counter
        $(wrapper).append('<div class="course_add1 "><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;" ><div class="form-group"  ><select class="form-control state_id" name="result['+x+'][state_id]" id="state_id'+x+'" style="width:240px;"><option value="">Select State</option></select></div><div class="form-group"><select class="form-control" name="result['+x+'][univercity_id]" id="univercity_id'+x+'" style="width:260px;"><option>Select your University</option></select></div><select class="form-control" name="result['+x+'][course_id]" id="course_id'+x+'" style="width: 240px;"><option value="">Select your Course</option></select><div class="form-group"><select class="form-control" id="month" name="result['+x+'][month]"><option value="">intake </option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November </option><option value="12">December</option></select></div><div class="form-group"> <select class="form-control" id="year" name="result['+x+'][year]"><?php $firstYear = (int)date('Y');$lastYear = $firstYear + 10;for($i=$firstYear;$i<=$lastYear;$i++){echo '<option value='.$i.'>'.$i.'</option>';}?></select></div><a href="#" class="remove_field uni-recom delete_btn">X</a></div></div><script>$("#state_id'+x+'").change(function() {  var id=$(this).val(); var action="get_UCR_state_id" ; $.ajax({ url:"ajax/getModalData.php" ,data:{key:id,action:action},success:function(result){ $("#univercity_id'+x+'").html(result);}});});$("#univercity_id'+x+'").change(function() {  var id=$(this).val(); var action="get_UCR_course_id" ; $.ajax({ url:"ajax/getModalData.php" ,data:{key:id,action:action},success:function(result){ $("#course_id'+x+'").html(result);}});});<' + '/' + 'script>');
        }
    });
    $("#stateButton").click(function() {
        var id = $('#country_id').val();
        if (id!="") {
            $.ajax({
                type: "GET", 
                url: 'ajax/getModalData.php',
                data: {id:id,type:'getUCRState'},
                beforeSend: function () {
                },
                success: function (response) {
                    console.log(response);
                    $("#state_id"+x).html(response);
                }
            });
        }
    });



//Once remove button is clicked
    $(wrapper).on('click', '.remove_field', function(e){
        e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    x--; //Decrement field counter
    });

// <script>$("#stateButton").click(function() {var id = $('#country_id').val();$.ajax({type: "GET", url: 'ajax/getModalData.php',data: {id:id,type:'getState'},success:function(result){ $("#state_id'+x+'").val(result);}});});<' + '/' + 'script>



$('#phonevalidate').on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;
        $(this).val(formattedNumber);
});

$('#phonevalidateman').on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;
        $(this).val(formattedNumber);
});

var addButton = $('.add_field_button2'); //Add button selector

var wrapper2 = $('#add2'); //Input field wrapper
<?php
if($_REQUEST['id']!=''){?>
var x = <?php echo $i-1; ?>; //Initial field counter is 1
var y = <?php echo $i; ?>
<?php }else{?>
var a = 0; //Initial field counter is 1
var b = 0;
<?php }?>
//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(a < maxField){ 
a++; //Increment field counter
b++; //Increment field counter

$("#extra_field"+a).hide();
$(wrapper2).append('<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group"><select class="form-control" name="data['+a+'][diploma_id]" id="diploma_id"><option value="">Select your Diploma</option><?php $sql=$obj->query("select * from $tbl_diploma where status=1 group by name",$debug=-1);while($line=$obj->fetchNextObject($sql)){ if($line->name!=''){?><option value="<?php echo $line->id ?>"><?php echo $line->name ?></option><?php } } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data['+a+'][start_date]" id="dr_start_date'+a+'"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data['+a+'][end_date]" id="dr_end_date'+a+'"></div><div class="form-group"><input class="form-control form-control-lg" id="time_duration'+a+'" type="text" placeholder="0 Year,0 Months" name="data['+a+'][time_duration]"></div><div class="form-group"><select class="form-control" name="data['+a+'][status]" id="dr_status'+a+'"><option value="status">Status</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option><option value="send_request">Send Request</option></select></div></div><div class="extra_field" id="extra_field'+a+'" style="display: flex; justify-content:space-between;"><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_slip_number'+a+'" name="data['+a+'][slip_number]" placeholder="Request Slip Number"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_mother_name'+a+'" name="data['+a+'][mother_name]" placeholder="Mother Name"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="phonevalidate'+a+'" name="data['+a+'][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="dr_imp_remarks'+a+'" name="data['+a+'][imp_remarks]" placeholder="Important Remarks"></div><div class="form-group"><input  type="file" name="data['+a+'][photo]" class="manage_upload_button1" placeholder="Passport Size Photo" id="fileupload'+a+'"></div><a href="#" class="remove_field2 diploma-recom delete_btn">X</a></div>');

$("#extra_field"+a).hide();


$("#dr_status"+a).change(function(){
    dr_status = $(this).val();
    if(dr_status=='send_request'){
        $("#extra_field"+a).show();
        $("#dr_slip_number"+a).addClass('required');
        $("#dr_mother_name"+a).addClass('required');
        $("#phonevalidate"+a).addClass('required');
        $("#fileupload"+a).addClass('required');
    }else{
        $("#extra_field"+a).hide();
        $("#dr_slip_number"+a).removeClass('required');
        $("#dr_mother_name"+a).removeClass('required');
        $("#phonevalidate"+a).removeClass('required');
        $("#fileupload"+a).removeClass('required');
    }
})

$('#phonevalidate'+a).on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;
        $(this).val(formattedNumber);
});

$("#dr_start_date"+a).datepicker({
    dateFormat: 'dd-mm-yy',
    numberOfMonths: 1,
    changeMonth:true,
    changeYear:true,
    onSelect: function (selected) {
        $("#dr_end_date"+a).datepicker("option", "minDate", selected);
    }
});

$("#dr_end_date"+a).datepicker({
    dateFormat: 'dd-mm-yy',
    numberOfMonths: 1,
    changeMonth:true,
    changeYear:true,
    onSelect: function (selected) {
        $("#dr_start_date"+a).datepicker("option", "maxDate", selected);
        var start = $("#dr_start_date"+a).val();
        var end = $("#dr_end_date"+a).val();
        var action='getdays';
        $.ajax({
            type:"post",
            url:"ajax/getModalData.php",
            data :{'start_date' : start,'end_date' : end,'action': action },          
            success:function(res){
// $(".start_date").val(start);
$("#time_duration"+a).val(res);

}
});


    }
});
}
});





//Once remove button is clicked
$(wrapper2).on('click', '.remove_field2', function(e){
    e.preventDefault();
$(this).parent('div').remove(); //Remove field html
a--; //Decrement field counter
});


var addButton = $('.add_field_button3'); //Add button selector

var wrapper3 = $('#add3'); //Input field wrapper
<?php
if($_REQUEST['id']!=''){?>
var x = <?php echo $i-1; ?>; //Initial field counter is 1
var y = <?php echo $i; ?>
<?php }else{?>
var  c = 0; //Initial field counter is 1
var d = 0;
<?php }?>
//Once add button is clicked
$(addButton).click(function(){





//Check maximum number of input fields
if(c < maxField){ 
c++; //Increment field counter
d++; //Increment field counter
$(wrapper3).append('<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group"><select class="form-control" name="data2['+c+'][designation_id]" id="designation_id"><option value="">Select your Designation</option><?php $sqlc=$obj->query("select * from $tbl_designation where status=1 group by name",$debug=-1);while($linec=$obj->fetchNextObject($sqlc)){ if($linec->name!=''){?><option value="<?php echo $linec->id ?>"><?php echo $linec->name ?></option><?php } } ?></select></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2['+c+'][start_date]" id="er_start_date'+c+'"></div><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="DD-MM-YY"  name="data2['+c+'][end_date]" id="er_end_date'+c+'"></div><div class="form-group"><input class="form-control form-control-lg" id="er_time_duration'+c+'" type="text" placeholder="0 Year,6 Months" name="data2['+c+'][time_duration]"></div><div class="form-group"><select class="form-control" name="data2['+c+'][status]" id="er_status'+c+'"><option value="status">Status</option><option value="self">Self </option><option value="pending_confirmation">Pending confirmation</option><option value="send_request">Send Request</option></select></div></div></div><div id="er_extra_field'+c+'" style="display: flex; justify-content:space-between;"><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_slip_number'+c+'" name="data2['+c+'][slip_number]" placeholder="Request Slip Number"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="phonevalidatee'+c+'" name="data2['+c+'][stu_contact_number]" placeholder="Student Contact Number" maxlength="13" minlength="13"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_salary'+c+'" name="data2['+c+'][salary]" placeholder="Salary"></div><div class="form-group"><input class="form-control form-control-lg" type="date" id="er_issue_date'+c+'" name="data2['+c+'][issue_date]" placeholder="Issue Date"></div><div class="form-group"><input class="form-control form-control-lg" type="text" id="er_imp_remarks'+c+'" name="data2['+c+'][imp_remarks]" placeholder="Important Remarks"><a href="#" class="remove_field3 exp-recom delete_btn">X</a></div></div>');

	$("#er_extra_field"+c).hide();

	$("#er_status"+c).change(function(){
	    er_status = $(this).val();
	    if(er_status=='send_request'){
	        $("#er_extra_field"+c).attr('style','flex');
	        $("#er_extra_field"+c).show();
            $("#er_slip_number"+c).addClass('required');
            $("#phonevalidateman"+c).addClass('required');
            $("#er_salary"+c).addClass('required');
            $("#er_issue_date"+c).addClass('required');
            $("#er_imp_remarks"+c).addClass('required');
	    }else{
	        $("#er_extra_field"+c).hide();
            $("#er_slip_number"+c).removeClass('required');
            $("#phonevalidateman"+c).removeClass('required');
            $("#er_salary"+c).removeClass('required');
            $("#er_issue_date"+c).removeClass('required');
            $("#er_imp_remarks"+c).removeClass('required');
	    }
	})



$('#phonevalidatee'+c).on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;
        $(this).val(formattedNumber);
});

$("#er_start_date"+c).datepicker({
    dateFormat: 'dd-mm-yy',
    numberOfMonths: 1,
    changeMonth:true,
    changeYear:true,
    onSelect: function (selected) {
        $("#er_end_date"+c).datepicker("option", "minDate", selected);         
    }
});

$("#er_end_date"+c).datepicker({
    dateFormat: 'dd-mm-yy',
    numberOfMonths: 1,
    changeMonth:true,
    changeYear:true,
    onSelect: function (selected) {

        $("#er_start_date"+c).datepicker("option", "maxDate", selected);
        var start = $("#er_start_date"+c).val();
        var end = $("#er_end_date"+c).val();


        var action='getdays';

        $.ajax({
            type:"post",
            url:"ajax/getModalData.php",
            data :{'start_date' : start,'end_date' : end,'action': action },          
            success:function(res){
// $(".start_date").val(start);
$("#er_time_duration"+c).val(res);

}
});


    }
});

}
});

//Once remove button is clicked
$(wrapper3).on('click', '.remove_field3', function(e){
    e.preventDefault();
$(this).parent('div').remove(); //Remove field html
c--; //Decrement field counter
});




var addButton = $('.add_field_button4'); //Add button selector

var wrapper4 = $('#add4'); //Input field wrapper
<?php
if($_REQUEST['id']!=''){?>
var x = <?php echo $i-1; ?>; //Initial field counter is 1
var y = <?php echo $i; ?>
<?php }else{?>
var  e = 0; //Initial field counter is 1
var f = 0;
<?php }?>
//Once add button is clicked
$(addButton).click(function(){
//Check maximum number of input fields
if(e < maxField){ 
e++; //Increment field counter
f++; //Increment field counter
$(wrapper4).append('<div class="course_add1 " style="position:relative"><div class="course_form add_mrgin" style="display:flex; justify-content: start;"><div class="form-group"><input class="form-control form-control-lg" type="text" placeholder="Amount(INR)" name="data3['+e+'][amount]" id="amount"></div><div class="form-group" ><input class="form-control form-control-lg" type="text" placeholder="Notes"  name="data3['+e+'][notes]" id="notes"></div><div class="form-group"><select class="form-control" name="data3['+e+'][status]"><option value="status">Status</option><option value="outside">Outside</option><option value="self">Self </option><option value="partial">Partial </option><option value="hold">Hold </option><option value="pending_confirmation">Pending confirmation</option></select></div><a href="#" class="remove_field4 fund-recom delete_btn">X</a></div></div></div></div>');
}
});

//Once remove button is clicked
$(wrapper4).on('click', '.remove_field4', function(e){
    e.preventDefault();
$(this).parent('div').remove(); //Remove field html
e--; //Decrement field counter
});



var addButton = $('.add_field_button5');
var wrapper5 = $('#add5');
var s = 0;
$(addButton).click(function(){
if(s < maxField){ 
s++;
t = s+1;

$(wrapper5).append('<div class="course_add1 " style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon" style="height: 35px;color: #fff;">Company '+t+'</div></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><input type="text" class="required form-control" placeholder="Company Name" name="weresult['+s+'][company_name]" id="company_name" value="" style="width: 250px;"></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="text" class="required form-control" placeholder="Designation" name="weresult['+s+'][designation]" id="designation" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="date" class="form-control" placeholder="Start Date" name="weresult['+s+'][start_date]" id="start_date" value="" style="width: 140px;"></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group"><input type="date" class="form-control" placeholder="End Date" name="weresult['+s+'][end_date]" id="end_date" value="" style="width: 140px;"></div></div></div><a href="#" class="remove_field5 fund-recom delete_btn">X</a></div></div>');
}
});


$(wrapper5).on('click', '.remove_field5', function(e){
    e.preventDefault();
    $(this).parent('div').remove();
    s--;
});






$("#course").change(function(){
    var cname = $(this).val();
    if(cname=='MOI'){
        $('#wirting').attr("disabled","disabled");
        $('#reading').attr("disabled","disabled");
        $('#listening').attr("disabled","disabled");
        $('#speaking').attr("disabled","disabled");
        $('#overall_bands').attr("disabled","disabled");
        $('#exam_date').attr("disabled","disabled");
    }else{
        $('#wirting').attr("disabled",false);
        $('#reading').attr("disabled",false);
        $('#listening').attr("disabled",false);
        $('#speaking').attr("disabled",false);
        $('#overall_bands').attr("disabled",false);
        $('#exam_date').attr("disabled",false);
    }

})
//English Proficiency

var addButtonmm = $('.add_english_proficiency'); //Add button selector
var wrappermm = $('#add_english_proficiency_form'); //Input field wrapper
<?php
if($_REQUEST['id']!=''){?>
    var mm = <?php echo $i-1; ?>; //Initial field counter is 1
<?php }else{?>
    var mm = 0; //Initial field counter is 1
<?php }?>
//Once add button is clicked
$(addButtonmm).click(function(){
//Check maximum number of input fields
if(mm < maxField){ 
    mm++; //Increment field counter
    $(wrappermm).append('<div class="course_add1"><div class="course_form add_mrgin" style="display: flex;justify-content: space-between;position: relative;"><div class="form-group" ><select class="form-control course" name="epresult['+mm+'][course]" id="course'+mm+'"><option value="">Select Course</option><option value="IELTS">IELTS</option><option value="PTE">PTE</option><option value="TOEFL">TOEFL</option><option value="Duolingo">Duolingo</option><option value="MOI">MOI</option></select></div><div class="form-group"><input type="text" class="form-control wirting" placeholder="Writing" name="epresult['+mm+'][wirting]" id="wirting'+mm+'" value="" style="width: 140px;"></div><div class="form-group"> <input type="text" class="form-control" placeholder="Reading " name="epresult['+mm+'][reading]" id="reading'+mm+'" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Listening " name="epresult['+mm+'][listening]" id="listening'+mm+'" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Speaking " name="epresult['+mm+'][speaking]" id="speaking'+mm+'" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Overall Bands" name="epresult['+mm+'][overall_bands]" id="overall_bands'+mm+'" value="" style="width: 140px;"></div><div class="form-group"><input type="text" class="form-control" placeholder="Date of Exam" name="epresult['+mm+'][exam_date]" id="exam_date'+mm+'" value="" style="width: 140px;"></div><a href="#" class="remove_english_proficiency diploma-recom delete_btn">X</a></div></div>'); 

    }


    $("#course"+mm).change(function(){
        var cnamee = $(this).val();
        if(cnamee=='MOI'){
            $('#wirting'+mm).attr("disabled","disabled");
            $('#reading'+mm).attr("disabled","disabled");
            $('#listening'+mm).attr("disabled","disabled");
            $('#speaking'+mm).attr("disabled","disabled");
            $('#overall_bands'+mm).attr("disabled","disabled");
            $('#exam_date'+mm).attr("disabled","disabled");
        }else{
            $('#wirting'+mm).attr("disabled",false);
            $('#reading'+mm).attr("disabled",false);
            $('#listening'+mm).attr("disabled",false);
            $('#speaking'+mm).attr("disabled",false);
            $('#overall_bands'+mm).attr("disabled",false);
            $('#exam_date'+mm).attr("disabled",false);
        }

    })



});




//Once remove button is clicked
$(wrappermm).on('click', '.remove_english_proficiency', function(e){
    e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    mm--; //Decrement field counter
});


$("#passport_no").keyup(function(){

    var value = $('#passport_no').val();

    var action='getpasport'
    $.ajax({
        type:"post",
        url:"ajax/getModalData.php",
        data :{
            'key' : value,'action': action              
        },          
        success:function(res){
            if (res==0) {
                $("#submitbtn").removeAttr("disabled","disabled");
            }else{
                $('#showSearchResult').show().html('This passprot number already add'); 
                $("#submitbtn").attr("disabled","disabled");
            }

        }
    });

});



$("#dr_status").change(function(){
    dr_status = $(this).val();
    if(dr_status=='send_request'){
        $(".extra_field").attr('style','flex');
        $(".extra_field").show();
        $("#dr_slip_number").addClass('required');
        $("#dr_mother_name").addClass('required');
        $("#phonevalidate").addClass('required');
        $("#fileupload").addClass('required');
    }else{
        $(".extra_field").hide();
        $("#dr_slip_number").removeClass('required');
        $("#dr_mother_name").removeClass('required');
        $("#phonevalidate").removeClass('required');
        $("#fileupload").removeClass('required');
    }
})

$("#er_status").change(function(){
    dr_status = $(this).val();
    if(dr_status=='send_request'){
        $("#er_extra_field").attr('style','flex');
        $("#er_extra_field").show();
        $("#er_slip_number").addClass('required');
        $("#phonevalidateman").addClass('required');
        $("#er_salary").addClass('required');
        $("#er_issue_date").addClass('required');
        $("#er_imp_remarks").addClass('required');
    }else{
        $("#er_extra_field").hide();
        $("#er_slip_number").removeClass('required');
        $("#phonevalidateman").removeClass('required');
        $("#er_salary").removeClass('required');
        $("#er_issue_date").removeClass('required');
        $("#er_imp_remarks").removeClass('required');
    }
})



$(".course").change(function(){
    val = $(this).val();
    //alert(val);
    // if(val=='MOI'){
    //     $(".wirting").attr("readonly", "readonly");
    //     $("#reading").attr("readonly", "readonly");
    //     $("#listening").attr("readonly", "readonly");
    //     $("#speaking").attr("readonly", "readonly");
    //     $("#overall_bands").attr("readonly", "readonly");
    // }else{
    //     $("#wirting").removeAttr("readonly", "readonly");
    //     $("#reading").removeAttr("readonly", "readonly");
    //     $("#listening").removeAttr("readonly", "readonly");
    //     $("#speaking").removeAttr("readonly", "readonly");
    //     $("#overall_bands").removeAttr("readonly", "readonly");
    // }
    
})

    $("#ten_percent").change(function(){
        pval = $(this).val()/25;
        $("#ten_grade").val(pval);
    })
    $("#twl_percent").change(function(){
        pval = $(this).val()/25;
        $("#twl_grade").val(pval);
    })
    $("#dip_percent").change(function(){
        pval = $(this).val()/25;
        $("#dip_grade").val(pval);
    })
    $("#dip1_percent").change(function(){
        pval = $(this).val()/25;
        $("#dip1_grade").val(pval);
    })
    $("#grd_percent").change(function(){
        pval = $(this).val()/25;
        $("#grd_grade").val(pval);
    })
    $("#grd1_percent").change(function(){
        pval = $(this).val()/25;
        $("#grd1_grade").val(pval);
    })
    $("#pgrd_percent").change(function(){
        pval = $(this).val()/25;
        $("#pgrd_grade").val(pval);
    })
    $("#pgdrd_percent").change(function(){
        pval = $(this).val()/25;
        $("#pgdrd_grade").val(pval);
    })

});


$("#passport_no").keypress(function(){
    $("#showSearchResult").hide();
})



</script>
<script>
    $( function() {

        var dateToday = new Date(); 

        var dateFormat = "yy-mm-dd",
        from = $( ".start_date" )

        .datepicker({
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd",
// minDate: dateToday ,
// This was done to ensure that if user want he can change date to back date. It was temporarily.

})
        .on( "change", function() {
            to.datepicker( "option", "minDate", getDate( this ) );
//enableAllTheseDays();
}),
        to = $( ".end_date" ).datepicker({
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: "yy-mm-dd",
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
//enableAllTheseDays();
});

        function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }

            return date;
        }
    } );




    function formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('-');
    }

function enableAllTheseDays(date) {

    var start= $("#start_date").val();
    var end= $("#end_date").val();   
    var startDate = new Date(start); //YYYY-MM-DD
    var endDate = new Date(end); //YYYY-MM-DD

    var getDateArray = function(start, end) {
    var arr = new Array();
    var dt = new Date(start);
    while (dt <= end) {
    arr.push(formatDate(new Date(dt)));
    dt.setDate(dt.getDate() + 1);
    }
    return arr;
}

var dateArr = getDateArray(startDate, endDate);
enableDays=(dateArr);

var sdate = $.datepicker.formatDate( 'dd-mm-yy', date)
if($.inArray(sdate, enableDays) != -1) {
    return [true];
}
return [false];
}



</script>

</body>
</html>