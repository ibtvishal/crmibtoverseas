<?php 
include('include/config.php');
include("include/functions.php");


if($_REQUEST['userDetails']=='yes'){

    $_SESSION['visit_data']=$_POST;

    @header("location:visit-otp-verify.php");
}
if($_SESSION['visit_data']){
    $_POST = $_SESSION['visit_data'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('head.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style type="text/css">
    .refused-visa-type label.error {
        position: absolute !important;
        top: 25px !important;
    }

    .label-required1 label.error {
        position: absolute !important;
        bottom: -15px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 0 !important;
    }

    .label-required label.error {
        position: absolute !important;
        bottom: -56px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 480px !important;
    }

    .removecls {
        position: absolute;
        top: 3px;
        right: 0px;
        font-size: 20px;
    }

    .removemastercls {
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 20px;
    }

    .removeeducatoncls {
        position: absolute;
        top: 52px;
        right: 15px;
        font-size: 20px;
    }

    #err_applicant_alternate_no {
        color: red;
    }

    #err_applicant_contact_no {
        color: red;
    }

    .removeeducatoncls {
        position: absolute;
        top: 52px;
        right: 15px;
        font-size: 20px;
    }

    .removelangcls {
        position: absolute;
        top: 50px;
        right: 248px;
        font-size: 20px;
    }

    .add-section-removeeducaton {
        position: absolute;
        top: -241px;
        right: 13px;
    }

    @media (max-width: 650px) {
        .display_flex {
            display: block
        }

        .display_input1 {
            margin-left: 0;
        }
    }

    @media (max-width: 992px) {
        .label-required label.error {
            position: absolute !important;
            bottom: -280px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 0 !important;
        }

        .label-required1 label.error {
            position: absolute !important;
            bottom: -40px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 0 !important;
        }
    }

    @media (min-width: 650px) {
        .display_input {
            width: 100% !important;
        }

        .display_input input {
            width: 100% !important;
        }

        .display_flex {
            display: flex
        }

        .display_input1 {
            margin-left: 10px;
        }
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    </style>
</head>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php 
        if(isset($_SESSION['sess_admin_id'])){
        include("menu.php");
        }
         ?>
        <div class="page-wrapper">
            <div class="container">
                <div class="d-flex" style="height:60px;display: flex;">
                    <div style="width: 46%;text-align: right;height: 100%;border-right:2px solid;">
                        <img src="img/logo.svg" alt="" style="width: 130px;">
                    </div>
                    <div style="width:46%;">
                        <h1 class="text-bold" style="font-size:2rem; margin: 0 10px"><b style="font-weight:bold">VISIT
                            </b> FORM</h1>
                    </div>
                </div>
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">Add Visit</h4>
                    <form method="post" action="" name="visitfrm" id="visitfrm" enctype=multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Applicant Name
                                                &nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Applicant Name"
                                            name="applicant_name" id="applicant_name"
                                            value="<?php echo $_POST['applicant_name']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Father
                                                Name&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Father Name"
                                            name="father_name" id="father_name"
                                            value="<?php echo $_POST['father_name']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-calendar"
                                                    style="font-size:15px;"></i></span><span>&nbsp; &nbsp; Date Of Birth
                                                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="text" class="required form-control datepicker change-date"
                                            placeholder="Date Of Birth" name="dob" id="dob"
                                            value="<?php echo $_POST['dob']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"> <span><i class="fa-solid fa-people-group"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Marital Status
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="marital_status" id="marital_status">
                                            <option value="">Select Marital Status</option>
                                            <option value="1" <?php if($_POST['marital_status']==1){?> selected
                                                <?php } ?>>Married</option>
                                            <option value="2" <?php if($_POST['marital_status']==2){?> selected
                                                <?php } ?>>Unmarrried</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-phone-volume"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Phone Number</span>
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Phone Number"
                                            name="applicant_contact_no" id="applicant_contact_no"
                                            value="<?php echo $_POST['applicant_contact_no']; ?>" maxlength="10">
                                    </div>
                                    <span id="err_applicant_contact_no"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-tty"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Alternate
                                                Number</span></div>
                                        <input type="text" class="required form-control" placeholder="Alternate Number"
                                            name="applicant_alternate_no" id="applicant_alternate_no"
                                            value="<?php echo $_POST['applicant_alternate_no']; ?>" maxlength="10">
                                    </div>
                                    <span id="err_applicant_alternate_no"></span>
                                    <input type="checkbox" id="same_as_primary_number">
                                    <label for="same_as_primary_number" class="text-primary">Same as Primary
                                        Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-question-circle"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Enquiry Type</span>
                                        </div>
                                        <select name="enquiry_type" class="form-control form-select">
                                            <option value="">Select Type</option>
                                            <option value="Online"
                                                <?php echo $_POST['enquiry_type'] == 'Online' ? 'selected' : ''  ?>>
                                                Online</option>
                                            <?php
                                                if($_SESSION['level_id'] != 9){
                                                ?>
                                            <option value="Walkin"
                                                <?php echo  $_POST['enquiry_type'] == 'Walkin' ? 'selected' : ''  ?>
                                                <?=!$_POST['enquiry_type'] ? 'selected' : ''?>>
                                                Walkin</option>
                                            <!-- <option value="Old Walkin"
                                                <?php echo $_POST['enquiry_type'] == 'Old Walkin' ? 'selected' : ''  ?>>
                                                Old Walkin</option> -->
                                            <option value="Re-apply"
                                                <?php echo $_POST['enquiry_type'] == 'Re-apply' ? 'selected' : ''  ?>>
                                                Re-apply (Existing IBT Student)</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Address</span>
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Address"
                                            name="address" id="address" value="<?php echo $_POST['address']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row " style="margin-bottom:10px;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon text-uppercase "><span><i
                                                    class="fa-solid fa-location-dot" style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon space-state"> Country</div>
                                        <select class="required form-control" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            <option value="1" selected>India
                                            </option>
                                            <option value="2" <?=$_POST['country_id'] == '2' ? 'selected' : ''?>>UK
                                            </option>
                                            <option value="3" <?=$_POST['country_id'] == '3' ? 'selected' : ''?>>Canada
                                            </option>
                                            <option value="4" <?=$_POST['country_id'] == '4' ? 'selected' : ''?>>UAE
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-location-dot"
                                                    style="font-size:15px;"></i></span>
                                            &nbsp; <span>State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="state_id" id="state_id">
                                            <option value="">Select State</option>
                                            <?php
                                            $i=1;
                                            if($_POST['country_id']){
                                                $country_id = $_POST['country_id'];
                                            }else{
                                                $country_id = 1;
                                            }
                                            $sql=$obj->query("select * from $tbl_location_states where 1=1 and country_id='$country_id' and status=1 order by name",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($_POST['state_id']==$line->id){?> selected <?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "> <span><i class="fa-solid fa-city"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>District</span>
                                        </div>
                                        <select class="required form-control" name="city_id" id="city_id">
                                            <option value="">Select District</option>
                                            <?php
                                            if($_POST['state_id']!=''){
                                                $citysql=$obj->query("select * from $tbl_location_cities where 1=1 and status=1 and state_id ='".$_POST['state_id']."' group by name order by name",$debug=-1);
                                                while($cityline=$obj->fetchNextObject($citysql)){?>
                                            <option value="<?php echo $cityline->id ?>"
                                                <?php if($_POST['city_id']==$cityline->id){?> selected <?php } ?>>
                                                <?php echo $cityline->name ?></option>
                                            <?php } ?>
                                            <!-- <option value="1000" <?php if($_POST['city_id']==1000){?> selected
                                                <?php } ?>>Other</option> -->
                                            <?php }?>
                                        </select>
                                    </div>
                                    <input type="text" name="city_name" id="city_name"
                                        value="<?php echo $_POST['city_name'] ?>" class="form-control"
                                        placeholder="Add Your District Here" <?php if($_POST['city_id']==1000){?>
                                        style="display:block;" <?php }else{?> style="display:none;" <?php } ?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "> <span><i class="fa-solid fa-globe"
                                                    style="font-size:15px;"></i></span>
                                            <span id="change_country">Preferred
                                                <?=$_POST['pre_country_id'] == 7 ? 'Area' : 'Country'?></span>
                                        </div>

                                        <select class="required form-control" name="pre_country_id" id="pre_country_id"
                                            onchange="change_country(this.value)">
                                            <option value="">Select Preferred
                                                <?=$_POST['pre_country_id'] == 7 ? 'Area' : 'Country'?></option>
                                            <?php
                                            $psql=$obj->query("select * from $tbl_country where 1=1 and status=1 group by name order by displayorder",-1);
                                            while($pResult=$obj->fetchNextObject($psql)){?>
                                            <option value="<?php echo $pResult->id ?>"
                                                <?php if($_POST['pre_country_id']==$pResult->id){?> selected <?php } ?>>
                                                <?php echo $pResult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><i class="fa-solid fa-location-crosshairs"
                                                style="font-size:15px;"></i>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate"
                                            id="change_state">Preferred
                                            <?=$_POST['pre_country_id'] == 7 ? 'Country' : 'State'?>
                                            (Optional)
                                        </div>

                                        <select class="form-control" name="pre_state_id" id="pre_state_id">
                                            <option value="">Select
                                                <?=$_POST['pre_country_id'] == 7 ? 'Country' : 'State'?></option>
                                            <?php
                                            if($_POST['pre_country_id']!=''){
                                                $stateSql=$obj->query("select * from $tbl_state where 1=1 and status=1 and country_id='".$_POST['pre_country_id']."' group by state",-1);
                                                while($stateResult=$obj->fetchNextObject($stateSql)){?>
                                            <option value="<?php echo $stateResult->id ?>"
                                                <?php if($_POST['pre_state_id']==$stateResult->id){?> selected
                                                <?php } ?>><?php echo $stateResult->state; ?></option>
                                            <?php } 
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                <div class=""
                                    style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                    <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span>
                                    <Span> Visa type&nbsp;</Span>
                                </div>

                                <?php
                                $visaArr = array();
                                if($_POST['visa_type']!=''){
                                    $visaArr = $_POST['visa_type'];
                                }
                                
                                ?>
                                <div class="refused-visa-type">
                                    <input class="form-check-input required visatypecls"
                                        onchange="change_matriculation(this.value);" type="checkbox" name="visa_type[]"
                                        value="Study" id="flexCheckChecked" <?php if(in_array('Study',$visaArr)) {?>
                                        checked <?php }?>>
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Study
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input required visatypecls" type="checkbox"
                                        name="visa_type[]" value="Visitior/tourist" id="flexCheckCheckeds"
                                        <?php if(in_array('Visitior/tourist',$visaArr)) {?> checked <?php }?>
                                        onchange="change_matriculation(this.value)">
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Visitor/tourist
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check- required visatypecls"
                                        onchange="change_matriculation(this.value)" type="checkbox" name="visa_type[]"
                                        value="Spouse" id="flexCheckChecked" <?php if(in_array('Spouse',$visaArr)) {?>
                                        checked <?php }?>>
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Spouse
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input required visatypecls"
                                        onchange="change_matriculation(this.value)" type="checkbox" name="visa_type[]"
                                        value="Work" id="flexCheckChecked" <?php if(in_array('Work',$visaArr)) {?>
                                        checked <?php }?>>
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Work
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" name="visa_type[]"
                                        value="Interview Preparation" id="visa_type_Interview"
                                        <?php if(in_array('Interview Preparation',$visaArr)){?> checked <?php } ?>
                                        <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    <label for="visa_type_Interview" class="form-check-label" style="margin-top:8px;">
                                        Interview Preparation
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" name="visa_type[]"
                                        value="Filing Only" id="visa_type_filing"
                                        <?php if(in_array('Filing Only',$visaArr)){?> checked <?php } ?>
                                        <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    <label for="visa_type_filing" class="form-check-label" style="margin-top:8px;">
                                        Filing Only
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 form-group" style="display:flex;gap:1px;">
                                <div class=""
                                    style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                    <span><i class="fa-solid fa-message" style="font-size:15px;"></i></span> <Span
                                        style="font-size:11px;"> Whether tried for Visa earlier</Span>
                                </div>
                                <input name="visa_earlier" class="form-check-input" type="radio" value="1"
                                    id="visa_earlier1" <?php if($_POST['visa_earlier']==1){?> checked <?php }?>> &nbsp;
                                <label class="form-check-label" style="margin-top:8px;">
                                    Yes
                                </label>

                                <input name="visa_earlier" class="form-check-input" type="radio" value="2"
                                    id="visa_earlier2" <?php if($_POST['visa_earlier']==2){?> checked <?php }?>> &nbsp;
                                <label class="form-check-label" style="margin-top:8px;">
                                    No
                                </label>
                            </div>
                            <div class="col-md-2 earliercountry" <?php if($_POST['visa_earlier']==1){?>
                                style="display:block;" <?php }else{?> style="display:none;" <?php }?>>
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="earlier_country_id" id="earlier_country_id"
                                            style="width: 158px;" onchange="change_earlier_country_id(this.value)">
                                            <option value="">Select Country</option>
                                            <?php
                                            $ctsql=$obj->query("select * from $tbl_country where 1=1 and status=1 group by name order by displayorder",-1);
                                            while($ctresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $ctresult->id ?>"
                                                <?php if($_POST['earlier_country_id']==$ctresult->id){?> selected
                                                <?php } ?>><?php echo $ctresult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row earliercountry" <?php if($_POST['visa_earlier']==1){?> style="display:block;"
                            <?php }else{?> style="display:none;" <?php }?>>
                            <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                <div class=""
                                    style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                    <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span>
                                    <Span> Previous Visa Type&nbsp;</Span>
                                </div>

                                <?php
                                $refuesed_visa_type = array();
                                if($_POST['refuesed_visa_type']!=''){
                                    $refuesed_visa_type = $_POST['refuesed_visa_type'];
                                }
                                
                                ?>
                                <div class="refused-visa-type">
                                    <input class="form-check-input refuesed_visa_type" type="checkbox"
                                        name="refuesed_visa_type[]" value="Study" id="flexCheckChecked1"
                                        <?php if(in_array('Study',$refuesed_visa_type)) {?> checked <?php }?>
                                        onchange="change_university(this)">
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Study
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input refuesed_visa_type" type="checkbox"
                                        name="refuesed_visa_type[]" value="Visitior/tourist" id="flexCheckChecked"
                                        <?php if(in_array('Visitior/tourist',$refuesed_visa_type)) {?> checked
                                        <?php }?>>
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Visitor/tourist
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input refuesed_visa_type" type="checkbox"
                                        name="refuesed_visa_type[]" value="Spouse" id="flexCheckChecked2"
                                        <?php if(in_array('Spouse',$refuesed_visa_type)) {?> checked <?php }?>
                                        onchange="change_university1(this)">
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Spouse
                                    </label>
                                </div>
                                <div>
                                    <input class="form-check-input refuesed_visa_type" type="checkbox"
                                        name="refuesed_visa_type[]" value="Work" id="flexCheckChecked"
                                        <?php if(in_array('Work',$refuesed_visa_type)) {?> checked <?php }?>>
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Work
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <div class="input-group-addon">Previous Visa Outcome</div>
                                        <select class="form-control" name="visa_outcome" id="visa_outcome"
                                            onchange="change_refused(this.value)">
                                            <option value="">Select Previous Visa Outcome</option>
                                            <option value="Approved"
                                                <?=$_POST['visa_outcome'] == 'Approved' ? 'selected' : ''?>>Approved
                                            </option>
                                            <option value="Refused"
                                                <?=$_POST['visa_outcome'] == 'Refused' ? 'selected' : ''?>>Refused
                                            </option>
                                            <option value="Refused"
                                                <?=$_POST['visa_outcome'] == 'File Withdrawn' ? 'selected' : ''?>>File
                                                Withdrawn
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" id="refused_date_change">
                                            <?=isset($_POST['visa_outcome']) ? $_POST['visa_outcome'] : 'Refused' ?>
                                            Date</div>
                                        <input type="month" class="form-control" id="refuesed_date"
                                            placeholder="Refused Date" name="refuesed_date"
                                            value="<?=$_POST['refuesed_date']?>" style="width: 85%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" id="embassy_show"
                                <?=$_POST['earlier_country_id'] == 3 ? '' : ' style="display:none"'?>>
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <div class="input-group-addon">Embassy/Consulate</div>
                                        <select class="form-control" name="embassy" id="embassy">
                                            <option value="">Select Embassy/Consulate</option>
                                            <option value="Delhi" <?=$_POST['embassy'] == 'Delhi' ? 'selected' : ''?>>
                                                Delhi</option>
                                            <option value="Mumbai" <?=$_POST['embassy'] == 'Mumbai' ? 'selected' : ''?>>
                                                Mumbai</option>
                                            <option value="Kolkata"
                                                <?=$_POST['embassy'] == 'Kolkata' ? 'selected' : ''?>>Kolkata</option>
                                            <option value="Hyderabad"
                                                <?=$_POST['embassy'] == 'Hyderabad' ? 'selected' : ''?>>Hyderabad
                                            </option>
                                            <option value="Chennai"
                                                <?=$_POST['embassy'] == 'Chennai' ? 'selected' : ''?>>Chennai</option>
                                            <option value="Ahmedabad"
                                                <?=$_POST['embassy'] == 'Ahmedabad' ? 'selected' : ''?>>Ahmedabad
                                            </option>
                                            <option value="Bengaluru"
                                                <?=$_POST['embassy'] == 'Bengaluru' ? 'selected' : ''?>>Bengaluru
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="earlieruniversity"
                                <?php if(in_array('Spouse',$refuesed_visa_type) && $_POST['earlier_country_id']!=3){?>
                                style="display:none;"
                                <?php }elseif($_POST['visa_earlier']==1 && (in_array('Study',$refuesed_visa_type) || in_array('Spouse',$refuesed_visa_type))){ ?>
                                style="display:block;" <?php } else{?> style="display:none;" <?php }?>>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                University/Collage</div>
                                            <input type="text" class="form-control" id="university_name"
                                                placeholder="University/Collage" name="university_name"
                                                value="<?=$_POST['university_name']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                Course Name</div>
                                            <input type="text" class="form-control" id="course_name"
                                                placeholder="Course Name" name="course_name"
                                                value="<?=$_POST['course_name']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row " style="margin-top:10px;">

                        </div>

                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px">
                                    Educational
                                    Details <a class="add_master_field_button button"
                                        style="cursor: pointer;color:white;float: right;">Add
                                        More</a></h6>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <P
                                        style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                        Matriculation </P>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" id="matri_board_refresh">
                                    <div class="input-group" style="width:100%;">
                                        <select name="matri_board" id="matri_board"
                                            class="<?php if(!in_array('Visitior/tourist',$visaArr)){?>required <?php } ?>form-control"
                                            onchange="change_matric_board(this.value, 'matri_board')">
                                            <option value="">Select Board</option>
                                            <?php
                                            $catSql = $obj->query("select * from tbl_board where status = 1 order by name asc");
                                            while($res = $obj->fetchNextObject($catSql)){
                                                ?>
                                            <option value="<?=$res->name?>"
                                                <?php if($_POST['matri_board']==$res->name){?> selected <?php }?>>
                                                <?=$res->name?></option>
                                            <?php } ?>
                                            <?php
                                            if($_SESSION['level_id'] == 1){
                                            ?>
                                            <option value="other" <?php if($_POST['matri_board']=='other'){?> selected
                                                <?php }?>>Other</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control addpercentage" placeholder="Stream"
                                            name="stream" id="stream" value="General" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?php if(!in_array('Visitior/tourist',$visaArr)){?>required <?php } ?>form-control"
                                            name="matri_start_year" id="matri_start_year"
                                            onchange="change_last_year(this.value, 'matri_finish_year')">
                                            <option value="">Start Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['matri_start_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?php if(!in_array('Visitior/tourist',$visaArr)){?>required <?php } ?>form-control"
                                            name="matri_finish_year" id="matri_finish_year">
                                            <option value="">Finish Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['matri_finish_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text"
                                            class="<?php if(!in_array('Visitior/tourist',$visaArr)){?>required <?php } ?>form-control addpercentage"
                                            placeholder="Percentage" name="matri_percentage" id="matri_percentage"
                                            value="<?php echo $_POST['matri_percentage']; ?>"
                                            onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Any Backlog"
                                            name="matri_backlog" id="matri_backlog"
                                            value="<?php echo $_POST['matri_backlog']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p
                                        style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                        Sr. Secondary <span class="text-passed">(If Passed)</span></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" id="secondary_board_refresh">
                                    <div class="input-group" style="width:100%;">
                                        <select name="secondary_board" id="secondary_board" class="form-control"
                                            onchange="change_matric_board(this.value,'secondary_board')">
                                            <option value="">Select Board</option>
                                            <?php
                                        $catSql = $obj->query("select * from tbl_board where status = 1 order by name asc");
                                        while($res = $obj->fetchNextObject($catSql)){
                                            ?>
                                            <option value="<?=$res->name?>"
                                                <?php if($_POST['matri_board']==$res->name){?> selected <?php }?>>
                                                <?=$res->name?></option>
                                            <?php } ?>
                                            <?php
                                            if($_SESSION['level_id'] == 1){
                                            ?>
                                            <option value="other">Other</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Stream"
                                            name="secondary_stream" id="secondary_stream"
                                            value="<?php echo $_POST['secondary_stream']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="secondary_start_year"
                                            id="secondary_start_year"
                                            onchange="change_last_year(this.value, 'secondary_finish_year')">
                                            <option value="">Start Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['secondary_start_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="secondary_finish_year"
                                            id="secondary_finish_year">
                                            <option value="">Finish Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['secondary_finish_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control addpercentage" placeholder="Percentage"
                                            name="secondary_percentage" id="secondary_percentage"
                                            value="<?php echo $_POST['secondary_percentage']; ?>"
                                            onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Any Backlog"
                                            name="secondary_backlog" id="secondary_backlog"
                                            value="<?php echo $_POST['secondary_backlog']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p
                                        style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                        Any Diploma <span class="text-passed">(If Passed)</span></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Institute/University"
                                            name="diploma_board" id="diploma_board"
                                            value="<?php echo $_POST['diploma_board']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Stream"
                                            name="diploma_stream" id="diploma_stream"
                                            value="<?php echo $_POST['diploma_stream']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="diploma_start_year" id="diploma_start_year"
                                            onchange="change_last_year(this.value, 'diploma_finish_year')">
                                            <option value="">Start Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['diploma_start_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="diploma_finish_year"
                                            id="diploma_finish_year">
                                            <option value="">Finish Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['diploma_finish_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control addpercentage" placeholder="Percentage"
                                            name="diploma_percentage" id="diploma_percentage"
                                            value="<?php echo $_POST['diploma_percentage']; ?>"
                                            onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Any Backlog"
                                            name="diploma_backlog" id="diploma_backlog"
                                            value="<?php echo $_POST['diploma_backlog']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <p
                                        style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                        Bachelor <span class="text-passed">(If Passed)</span></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Institute/University"
                                            name="bachelor_board" id="bachelor_board"
                                            value="<?php echo $_POST['bachelor_board']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Stream"
                                            name="bachelor_stream" id="bachelor_stream"
                                            value="<?php echo $_POST['bachelor_stream']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="bachelor_start_year" id="bachelor_start_year"
                                            onchange="change_last_year(this.value, 'bachelor_finish_year')">
                                            <option value="">Start Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['bachelor_start_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select class="form-control" name="bachelor_finish_year"
                                            id="bachelor_finish_year">
                                            <option value="">Finish Year</option>
                                            <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                            <option value="<?php echo $i; ?>"
                                                <?php if($_POST['bachelor_finish_year']==$i){?> selected <?php } ?>>
                                                <?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control addpercentage" placeholder="Percentage"
                                            name="bachelor_percentage" id="bachelor_percentage"
                                            value="<?php echo $_POST['bachelor_percentage']; ?>"
                                            onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Any Backlog"
                                            name="bachelor_backlog" id="bachelor_backlog"
                                            value="<?php echo $_POST['bachelor_backlog']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="masterDetails_add" style="position:relative">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p
                                            style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Masters <span class="text-passed">(If Passed)</span></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Institute/University"
                                                name="master_board" id="master_board"
                                                value="<?php echo $_POST['master_board']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Stream"
                                                name="master_stream" id="master_stream"
                                                value="<?php echo $_POST['master_stream']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="master_start_year" id="master_start_year"
                                                onchange="change_last_year(this.value, 'master_finish_year')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($_POST['master_start_year']==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="master_finish_year"
                                                id="master_finish_year">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($_POST['master_finish_year']==$i){?> selected <?php } ?>>
                                                    <?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control addpercentage"
                                                placeholder="Percentage" name="master_percentage" id="master_percentage"
                                                value="<?php echo $_POST['master_percentage']; ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group" style="display:flex; gap:15px;">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="master_backlog" id="master_backlog"
                                                value="<?php echo $_POST['master_backlog']; ?>">
                                        </div>

                                    </div>
                                </div>
                            </div>






                            <?php
                        $edu=0;
                        if(isset($_POST['education'])){
                            foreach($_POST['education'] as $educationVal){?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <p
                                            style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">
                                            Others</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Institute/University"
                                                name="education[<?php echo $edu; ?>][master_board]" id="master_board"
                                                value="<?php echo $educationVal['master_board'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="Stream"
                                                name="education[<?php echo $edu; ?>][master_stream]" id="master_stream"
                                                value="<?php echo $educationVal['master_stream'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control"
                                                name="education[<?php echo $edu; ?>][master_start_year]"
                                                id="master_start_year"
                                                onchange="change_last_year(this.value, 'master_finish_year_other')">
                                                <option value="">Start Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($educationVal['master_start_year']==$i){?> selected
                                                    <?php } ?>><?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="required form-control"
                                                name="education[<?php echo $edu; ?>][master_finish_year]"
                                                id="master_finish_year_other">
                                                <option value="">Finish Year</option>
                                                <?php
                                            for($i=date('Y')-30; $i <=date('Y'); $i++){?>
                                                <option value="<?php echo $i; ?>"
                                                    <?php if($educationVal['master_finish_year']==$i){?> selected
                                                    <?php } ?>><?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control addpercentage"
                                                placeholder="Percentage"
                                                name="education[<?php echo $edu; ?>][master_percentage]"
                                                id="master_percentage"
                                                value="<?php echo $educationVal['master_percentage'] ?>"
                                                onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group" style="display:flex; gap:15px;">
                                        <div class="input-group" style="width:80%;">
                                            <input type="text" class="form-control" placeholder="Any Backlog"
                                                name="education[<?php echo $edu; ?>][master_backlog]"
                                                id="master_backlog"
                                                value="<?php echo $educationVal['master_backlog'] ?>">
                                        </div>

                                    </div>
                                </div>
                                <a href="#" class="remove_field removeeducatoncls delete_btn">X</a>
                            </div>
                            <?php $edu++; }
                        }
                        ?>


                        </div>

                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Language
                                    Proficiency Details</h6>
                            </div>
                        </div>
                        <div id="langDetails_add" style="position:relative">
                            <?php
                        $ld=0;
                        if(isset($_POST['langDetails'])){                    
                            foreach($_POST['langDetails'] as $langDetails){?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Name</div>
                                            <select name="langDetails[<?php echo $ld; ?>][exam_name]"
                                                id="exam_name<?php echo $ld; ?>" class="form-control">
                                                <option value="">Select</option>
                                                <option value="IELTS" <?php if($langDetails['exam_name']=='IELTS'){?>
                                                    selected <?php } ?>>IELTS</option>
                                                <option value="PTE" <?php if($langDetails['exam_name']=='PTE'){?>
                                                    selected <?php } ?>>PTE</option>
                                                <option value="TOEFL" <?php if($langDetails['exam_name']=='TOEFL'){?>
                                                    selected <?php } ?>>TOEFL</option>
                                                <option value="DUOLINGO"
                                                    <?php if($langDetails['exam_name']=='DUOLINGO'){?> selected
                                                    <?php } ?>>DUOLINGO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Listening</div>
                                            <input type="text" class="form-control" placeholder="Listening"
                                                name="langDetails[<?php echo $ld; ?>][lang_listening]"
                                                id="lang_listening<?php echo $ld; ?>"
                                                value="<?php echo $langDetails['lang_listening'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Reading</div>
                                            <input type="text" class="form-control" placeholder="Reading"
                                                id="readings<?php echo $ld; ?>"
                                                name="langDetails[<?php echo $ld; ?>][lang_reading]"
                                                value="<?php echo $langDetails['lang_reading'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Writing</div>
                                            <input type="text" class="form-control" placeholder="Writing"
                                                id="writings<?php echo $ld; ?>"
                                                name="langDetails[<?php echo $ld; ?>][lang_writing]"
                                                value="<?php echo $langDetails['lang_writing'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Speaking</div>
                                            <input type="text" class="form-control" placeholder="Speaking"
                                                id="speakings<?php echo $ld; ?>"
                                                name="langDetails[<?php echo $ld; ?>][lang_speaking]"
                                                value="<?php echo $langDetails['lang_speaking'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="scorelabel<?php echo $ld; ?>">Overall
                                                Bands</div>
                                            <input type="text" class="form-control" placeholder="Overall Bands"
                                                id="score<?php echo $ld; ?>"
                                                name="langDetails[<?php echo $ld; ?>][scrore]"
                                                value="<?php echo $langDetails['scrore'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Date</div>
                                            <input type="date" id="exam_date<?php echo $ld; ?>"
                                                class="form-control change-date" placeholder="Exam Date"
                                                name="langDetails[<?php echo $ld; ?>][exam_date]"
                                                value="<?php echo $langDetails['exam_date'] ?>"
                                                <?php if($langDetails['exam_name']==''){?> readonly <?php } ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                            $("#exam_name<?php echo $ld; ?>").change(function() {
                                examval = $(this).val();
                                if (examval != '') {
                                    $("#exam_date<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                    $("#score<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                    $("#speakings<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                    $("#writings<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                    $("#readings<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                    $("#lang_listening<?php echo $ld; ?>").removeAttr("readonly", 'readonly');
                                } else {
                                    $("#exam_date<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    $("#score<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    $("#speakings<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    $("#writings<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    $("#readings<?php echo $ld; ?>").attr("readonly", 'readonly');
                                    $("#lang_listening<?php echo $ld; ?>").attr("readonly", 'readonly');
                                }
                                if (examval == 'IELTS') {
                                    $("#score<?php echo $ld; ?>").attr("placeholder", "Overall Bands");
                                    $("#scorelabel").html("Overall Bands");
                                } else {
                                    $("#score<?php echo $ld; ?>").attr("placeholder", "Overall Score");
                                    $("#scorelabel<?php echo $ld; ?>").html("Overall Score");
                                }
                            })
                            </script>
                            <?php $ld++; }
                    }else{?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Name</div>
                                            <select name="langDetails[0][exam_name]" id="exam_name"
                                                class="form-control">
                                                <option value="">Select</option>
                                                <option value="IELTS">IELTS</option>
                                                <option value="PTE">PTE</option>
                                                <option value="TOEFL">TOEFL</option>
                                                <option value="DUOLINGO">DUOLINGO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Listening</div>
                                            <input type="text" class="form-control" placeholder="Listening"
                                                name="langDetails[0][lang_listening]" id="lang_listening" value=""
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Reading</div>
                                            <input type="text" class="form-control" placeholder="Reading"
                                                name="langDetails[0][lang_reading]" value="" id="lang_reading" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Writing</div>
                                            <input type="text" class="form-control" placeholder="Writing"
                                                name="langDetails[0][lang_writing]" value="" id="lang_writing" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Speaking</div>
                                            <input type="text" class="form-control" placeholder="Speaking"
                                                name="langDetails[0][lang_speaking]" value="" id="lang_speaking"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="scorelabel">Overall Bands</div>
                                            <input type="text" class="form-control" placeholder="Overall Bands"
                                                id="score" name="langDetails[0][scrore]" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Date</div>
                                            <input type="date" id="exam_date" class="form-control change-date"
                                                placeholder="Exam Date" name="langDetails[0][exam_date]" value=""
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="add-section">
                                <a class="add_lang_field_button button" style="cursor: pointer;color:white">Add More</a>
                            </div>
                        </div>









                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Other Exam
                                    (If Appeared)
                                </h6>
                            </div>
                        </div>
                        <div id="exam_section_add" style="position:relative">
                            <?php
                        $lds=0;
                        if(isset($_POST['exam_section'])){                    
                            foreach($_POST['exam_section'] as $exam_section){?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Name</div>
                                            <select name="exam_section[<?php echo $lds; ?>][exam_name]"
                                                id="exam_section_exam_name<?php echo $lds; ?>" class="form-control">
                                                <option value="">Select</option>
                                                <option value="GRE" <?php if($exam_section['exam_name']=='GRE'){?>
                                                    selected <?php } ?>>GRE</option>
                                                <option value="GMAT" <?php if($exam_section['exam_name']=='GMAT'){?>
                                                    selected <?php } ?>>GMAT</option>
                                                <option value="SAT" <?php if($exam_section['exam_name']=='SAT'){?>
                                                    selected <?php } ?>>SAT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value1_label<?php echo $lds; ?>">
                                                <?=$exam_section['exam_name'] == 'GRE' || $exam_section['exam_name'] == 'GMAT' ? 'Analytical Reasoning' : 'Writing' ?>
                                            </div>
                                            <input type="number" class="form-control"
                                                placeholder="<?=$exam_section['exam_name'] == 'GRE' || $exam_section['exam_name'] == 'GMAT' ? 'Analytical Reasoning' : 'Writing' ?>"
                                                id="value1<?php echo $lds; ?>"
                                                name="exam_section[<?php echo $lds; ?>][value1]"
                                                value="<?=$exam_section['value1']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value2_label<?php echo $lds; ?>">
                                                <?php if($exam_section['exam_name'] == 'GRE'){ echo 'Quantitative Reasoning'; }elseif($exam_section['exam_name'] == 'GMAT'){ echo 'Integrated Reasoning'; }else{echo 'Critical Reading';} ?>
                                            </div>
                                            <input type="number" class="form-control"
                                                placeholder="<?php if($exam_section['exam_name'] == 'GRE'){ echo 'Quantitative Reasoning'; }elseif($exam_section['exam_name'] == 'GMAT'){ echo 'Integrated Reasoning'; }else{echo 'Critical Reading';} ?>"
                                                id="value2<?php echo $lds; ?>"
                                                name="exam_section[<?php echo $lds; ?>][value2]"
                                                value="<?=$exam_section['value2']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value3_label<?php echo $lds; ?>">
                                                <?php if($exam_section['exam_name'] == 'GRE'){ echo 'Verbal Reasoning'; }elseif($exam_section['exam_name'] == 'GMAT'){ echo 'Quantitative'; }else{ echo 'Mathematics ';} ?>
                                            </div>
                                            <input type="number" class="form-control"
                                                placeholder="<?php if($exam_section['exam_name'] == 'GRE'){ echo 'Verbal Reasoning'; }elseif($exam_section['exam_name'] == 'GMAT'){ echo 'Quantitative'; }else{ echo 'Mathematics ';} ?>"
                                                id="value3<?php echo $lds; ?>"
                                                name="exam_section[<?php echo $lds; ?>][value3]"
                                                value="<?=$exam_section['value3']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value4_label<?php echo $lds; ?>">Verbal
                                            </div>
                                            <input type="number" class="form-control" placeholder="Verbal"
                                                id="value4<?php echo $lds; ?>"
                                                name="exam_section[<?php echo $lds; ?>][value4]"
                                                value="<?=$exam_section['value4']?>"
                                                <?=$exam_section['exam_name'] != 'GMAT' ? 'readonly' : ''?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon"
                                                id="exam_section_score_label<?php echo $lds; ?>">Overall Score
                                            </div>
                                            <input type="number" class="form-control" placeholder="Overall Score"
                                                id="exam_section_score<?php echo $lds; ?>"
                                                name="exam_section[<?php echo $lds; ?>][scrore]"
                                                value="<?=$exam_section['scrore']?>">
                                        </div>
                                    </div>
                                </div>
                                <a class="remove_field">x</a>
                            </div>

                            <script>
                            $("#exam_section_exam_name<?=$lds?>").change(function() {
                                examval = $(this).val();
                                if (examval != '') {
                                    $("#exam_section_score<?=$lds?>").removeAttr('readonly', 'readonly');
                                    $("#value1<?=$lds?>").removeAttr('readonly', 'readonly');
                                    $("#value2<?=$lds?>").removeAttr('readonly', 'readonly');
                                    $("#value3<?=$lds?>").removeAttr('readonly', 'readonly');
                                    $("#value4<?=$lds?>").removeAttr('readonly', 'readonly');

                                    $("#exam_section_score<?=$lds?>").addClass('required');
                                    if (examval == 'GRE') {
                                        $("#value1<?=$lds?>").addClass('required');
                                        $("#value2<?=$lds?>").addClass('required');
                                        $("#value3<?=$lds?>").addClass('required');

                                        $("#value1_label<?=$lds?>").html('Analytical Reasoning');
                                        $("#value2_label<?=$lds?>").html('Quantitative Reasoning');
                                        $("#value3_label<?=$lds?>").html('Verbal Reasoning');

                                        $("#value4<?=$lds?>").removeClass('required');
                                        $("#value4<?=$lds?>").attr('readonly', 'readonly');

                                        $("#value1<?=$lds?>").attr('placeholder', 'Analytical Reasoning');
                                        $("#value2<?=$lds?>").attr('placeholder', 'Quantitative Reasoning');
                                        $("#value3<?=$lds?>").attr('placeholder', 'Verbal Reasoning');

                                    } else if (examval == 'GMAT') {
                                        $("#value1<?=$lds?>").addClass('required');
                                        $("#value2<?=$lds?>").addClass('required');
                                        $("#value3<?=$lds?>").addClass('required');
                                        $("#value4<?=$lds?>").addClass('required');

                                        $("#value1_label<?=$lds?>").html('Analytical Reasoning');
                                        $("#value2_label<?=$lds?>").html('Integrated Reasoning');
                                        $("#value3_label<?=$lds?>").html('Quantitative');
                                        $("#value4_label<?=$lds?>").html('Verbal');

                                        $("#value1<?=$lds?>").attr('placeholder', 'Analytical Reasoning');
                                        $("#value2<?=$lds?>").attr('placeholder', 'Integrated Reasoning');
                                        $("#value3<?=$lds?>").attr('placeholder', 'Quantitative');

                                        $("#value4<?=$lds?>").addClass('required');

                                        $("#value4<?=$lds?>").removeAttr('readonly');
                                    } else if (examval == 'SAT') {
                                        $("#value1<?=$lds?>").addClass('required');
                                        $("#value2<?=$lds?>").addClass('required');
                                        $("#value3<?=$lds?>").addClass('required');

                                        $("#value1_label<?=$lds?>").html('Writing');
                                        $("#value2_label<?=$lds?>").html('Critical Reading');
                                        $("#value3_label<?=$lds?>").html('Mathematics ');

                                        $("#value4<?=$lds?>").removeClass('required');
                                        $("#value4<?=$lds?>").attr('readonly', 'readonly');

                                        $("#value1<?=$lds?>").attr('placeholder', 'Writing');
                                        $("#value2<?=$lds?>").attr('placeholder', 'Critical Reading');
                                        $("#value3<?=$lds?>").attr('placeholder', 'Mathematics');
                                    }
                                } else {
                                    $("#exam_section_score<?=$lds?>").removeClass('required');
                                    $("#value1<?=$lds?>").removeClass('required');
                                    $("#value2<?=$lds?>").removeClass('required');
                                    $("#value3<?=$lds?>").removeClass('required');
                                    $("#value4<?=$lds?>").removeClass('required');
                                    $("#exam_section_score<?=$lds?>").attr('readonly', 'readonly');
                                    $("#value1<?=$lds?>").attr('readonly', 'readonly');
                                    $("#value2<?=$lds?>").attr('readonly', 'readonly');
                                    $("#value3<?=$lds?>").attr('readonly', 'readonly');
                                    $("#value4<?=$lds?>").attr('readonly', 'readonly');
                                }

                            })
                            var wrapperrs = $('#exam_section_add');
                            $(wrapperrs).on('click', '.remove_field', function(e) {
                                e.preventDefault();
                                $(this).parent('div').remove();
                                x--;
                            });
                            </script>
                            <?php $lds++; }
                    }else{?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Exam Name</div>
                                            <select name="exam_section[0][exam_name]" id="exam_section_exam_name"
                                                class="form-control">
                                                <option value="">Select</option>
                                                <option value="GRE">GRE</option>
                                                <option value="GMAT">GMAT</option>
                                                <option value="SAT">SAT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value1_label">Analytical Reasoning</div>
                                            <input type="number" class="form-control" placeholder="Analytical Reasoning"
                                                id="value1" name="exam_section[0][value1]" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value2_label">Integrated Reasoning</div>
                                            <input type="number" class="form-control" placeholder="Integrated Reasoning"
                                                id="value2" name="exam_section[0][value2]" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value3_label">Quantitative</div>
                                            <input type="number" class="form-control" placeholder="Quantitative"
                                                id="value3" name="exam_section[0][value3]" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="value4_label">Verbal</div>
                                            <input type="number" class="form-control" placeholder="Verbal" id="value4"
                                                name="exam_section[0][value4]" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon" id="exam_section_score_label">Overall Score
                                            </div>
                                            <input type="number" class="form-control" placeholder="Overall Score"
                                                id="exam_section_score" name="exam_section[0][scrore]" value=""
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="add-section">
                                <a class="add_exam_section_button button" style="cursor: pointer;color:white">Add
                                    More</a>
                            </div>
                        </div>






                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Employment
                                    Details (If Employed Anywhere)</h6>
                            </div>
                        </div>
                        <div id="empDetails_add" style="position:relative">
                            <?php
                        $ed=0;
                        if(isset($_POST['empDetails'])){                    
                            foreach($_POST['empDetails'] as $empDetails){?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Company Name</div>
                                            <input type="text" class="form-control" placeholder="Company Name"
                                                name="empDetails[<?php echo $ed; ?>][company_name]" id="company_name"
                                                value="<?php echo $empDetails['company_name'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Designation</div>
                                            <input type="text" class="form-control" placeholder="Designation"
                                                name="empDetails[<?php echo $ed; ?>][designation]" id="designation"
                                                value="<?php echo $empDetails['designation'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 display_flex">
                                    <div class="form-group display_input">
                                        <div class="input-group">
                                            <div class="input-group-addon">Start Date</div>
                                            <input type="date" class="form-control" style="width: 85%"
                                                placeholder="Start Date"
                                                name="empDetails[<?php echo $ed; ?>][start_date]"
                                                value="<?php echo $empDetails['start_date'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group display_input display_input1">
                                        <div class="input-group">
                                            <div class="input-group-addon">End Date</div>
                                            <input type="date" class="form-control" style="width: 85%"
                                                placeholder="End Date" name="empDetails[<?php echo $ed; ?>][end_date]"
                                                value="<?php echo $empDetails['end_date'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Last Salary</div>
                                            <input type="number" class="form-control" placeholder="Last Salary"
                                                name="empDetails[<?php echo $ed; ?>][last_salary]"
                                                value="<?php echo $empDetails['last_salary'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $ed++; }
                    }else{?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Company Name</div>
                                            <input type="text" class="form-control" placeholder="Company Name"
                                                name="empDetails[0][company_name]" id="company_name" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon">Designation</div>
                                            <input type="text" class="form-control" placeholder="Designation"
                                                name="empDetails[0][designation]" id="designation" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 display_flex">
                                    <div class="form-group display_input">
                                        <div class="input-group">
                                            <div class="input-group-addon">Start Date</div>
                                            <input type="date" class="form-control" style="width: 85% !important"
                                                placeholder="Start Date" name="empDetails[0][start_date]" value="">
                                        </div>
                                    </div>
                                    <div class="form-group display_input display_input">
                                        <div class="input-group">
                                            <div class="input-group-addon">End Date</div>
                                            <input type="date" class="form-control" placeholder="End Date"
                                                style="width: 85% !important" name="empDetails[0][end_date]" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">Last Salary</div>
                                            <input type="number" class="form-control" placeholder="Last Salary"
                                                name="empDetails[0][last_salary]"
                                                value="<?php echo $edReslut->last_salary; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="add-section">
                                <a class="add_field_button button" style="cursor: pointer; color:white">Add More</a>
                            </div>
                        </div>



                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Available
                                    Funds</h6>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="input-group" style="width:100%;">
                                    <div class="input-group-addon">Do you have any previous fund?</div>
                                    <div class="col-md-1 label-required1">
                                        <div class="input-group" style="display: flex; align-items: center;">
                                            <input class="required form-check-input"
                                                onchange="get_family_fund(this.value)" name="family_fund" type="radio"
                                                value="Yes" <?php if($_POST['family_fund']=='Yes'){?> checked
                                                <?php } ?>>
                                            &nbsp;
                                            <label class="form-check-label" style="margin-top:4px;">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-1 label-required1">
                                        <div class="input-group" style="display: flex; align-items: center;">
                                            <input class="required form-check-input"
                                                onchange="get_family_fund(this.value)" name="family_fund" type="radio"
                                                value="No" <?php if($_POST['family_fund']=='No'){?> checked <?php } ?>>
                                            &nbsp;
                                            <label class="form-check-label" style="margin-top:4px;">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" id="family_fund_show"
                            <?=$_POST['family_fund'] == 'Yes' ? '' : 'style="display:none"'?>>
                            <div class="col-md-12">
                                <div class="input-group" style="width:100%;">
                                    <div class="input-group-addon">Total Funds</div>
                                    <input type="text" class="form-control"
                                        placeholder="Total Funds Available in all accounts" name="available_funds"
                                        id="available_funds" value="<?php echo $_POST['available_funds']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="padding: 0 15px">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">How Do you
                                    find us?</h6>
                            </div>
                        </div>
                        <div class="row" style="font-size: 11px;">
                            <div class="col-md-3 label-required">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Youtube"
                                        <?php if($_POST['source']=='Youtube'){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Youtube
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Facebook"
                                        <?php if($_POST['source']=='Facebook'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Facebook
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Instagram" <?php if($_POST['source']=='Instagram'){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Instagram
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Google"
                                        <?php if($_POST['source']=='Google'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Google
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Website"
                                        <?php if($_POST['source']=='Website'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Website
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Hoarding/Banner" <?php if($_POST['source']=='Hoarding/Banner'){?> checked
                                        <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Hoarding/Banner
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Friends"
                                        <?php if($_POST['source']=='Friends'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Friends
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Paper Ad"
                                        <?php if($_POST['source']=='Paper Ad'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Newspaper Advertisement
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio" value="Seminar"
                                        <?php if($_POST['source']=='Seminar'){?> checked <?php } ?>> &nbsp;
                                    <label class="form-check-label" style="margin-top:4px;">
                                        Seminar
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Relatives" <?php if($result->source=='Relatives'){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Relatives
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Seminar/Education Fair"
                                        <?php if($result->source=='Seminar/Education Fair'){?> checked <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Seminar/Education Fair
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Direct Visit" <?php if($result->source=='Direct Visit'){?> checked
                                        <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Direct Visit
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Recommend by other Consultant"
                                        <?php if($result->source=='Recommend by other Consultant'){?> checked
                                        <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Recommend by other Consultant
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group" style="display: flex; align-items: center;">
                                    <input class="required form-check-input" name="source" type="radio"
                                        value="Telecalling" <?php if($result->source=='Telecalling'){?> checked
                                        <?php } ?>>
                                    &nbsp;
                                    <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Telecalling
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <div class="row">
                <div class="add_stdnt_btn">
                    <button type="button" onclick="check_validation()" id="submitbtn" class="btn mr-10"
                        disabled>Submit</button>
                </div>
            </div>
            </form>
            <footer class="footer container-fluid pl-30 pr-30">
                <div class="row">
                    <div class="col-sm-12">
                        <p>2024 &copy; Powered by IBT India Pvt Ltd</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Board</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body student_filter" style="margin: 0;">
                    <form id="submit_board" method="post">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group" style="width:100%;">
                                    <input type="text" class="form-control required" placeholder="Board Name"
                                        name="name" id="board_name">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $("#visitfrm").validate();

        $("#dob").datepicker({
            format: 'dd/mm/yy',
            minDate: new Date('<?php echo date('Y-m-d', strtotime('-80 year')) ?>'),
            maxDate: new Date('<?php echo date('Y-m-d') ?>'),
            changeMonth: true,
            changeYear: true,
            revereseYear: true
        });

        $("#city_id").change(function() {
            var id = this.value;
            if (id == 1000) {
                $("#city_name").show();
                $("#city_name").addClass("required");
            } else {
                $("#city_name").hide();
                $("#city_name").removeClass("required");
            }
        });

        $(".visatypecls").click(function() {
            let visatype = [];
            $("input:checkbox[name=visa_type]:checked").each(function() {
                alert($(this).val());
            });
            console.log(visatype);
        })

        $("#visa_earlier1, #visa_earlier2").change(function() {

            if ($("#visa_earlier1").is(":checked") == true) {
                $('.earliercountry').show();
                $("#earlier_country_id").addClass("required");
                $("#visa_outcome").addClass("required");
                $("#refuesed_date").addClass("required");
                $("#embassy").addClass("required");
            }

            if ($("#visa_earlier2").is(":checked") == true) {
                $('.earliercountry').hide();
                $("#visa_outcome").removeClass("required");
                $("#refuesed_date").removeClass("required");
                $("#embassy").removeClass("required");
                $("#earlier_country_id").removeClass("required");
            }
        });


        $(".addpercentage").change(function() {
            v1 = $(this).val();
            if (v1 < 101) {
                v2 = "%";
                $(this).val(v1.concat(v2));
            } else {
                $(this).val('100%');
            }
        })


        $("#applicant_contact_no").change(function() {
            appcontactNo = $(this).val();
            $("#err_applicant_contact_no").show();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    mobile: appcontactNo,
                    type: 'checkContactNumber'
                },
                beforeSend: function() {},
                success: function(response) {
                    if (response == 1) {
                        $("#err_applicant_contact_no").html(
                            "Your contact number is already added.");
                        $("#applicant_contact_no").focus();
                        $("#submitbtn").attr('disabled', 'disabled');
                    } else {
                        $("#err_applicant_contact_no").hide();
                        $("#submitbtn").removeAttr('disabled', 'disabled');
                    }
                }
            });
        })


        $("#applicant_alternate_no").change(function() {
            appcontactNo = $(this).val();
            $("#err_applicant_alternate_no").show();
            contactNo = $("#applicant_contact_no").val();
            // if (appcontactNo == contactNo) {
            //     $("#err_applicant_alternate_no").html("Can not be same as phone number.");
            //     $("#applicant_contact_no").focus();
            //     $("#submitbtn").attr('disabled', 'disabled');
            // } else {

            $("#err_applicant_alternate_no").hide();
            $("#submitbtn").removeAttr('disabled', 'disabled');

            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    mobile: appcontactNo,
                    type: 'checkContactNumber'
                },
                beforeSend: function() {},
                success: function(response) {
                    if (response == 1) {
                        $("#err_applicant_alternate_no").show();
                        $("#err_applicant_alternate_no").html(
                            "Your contact number is already added.");
                        $("#applicant_alternate_no").focus();
                        $("#submitbtn").attr('disabled', 'disabled');
                    } else {
                        $("#err_applicant_alternate_no").hide();
                        $("#submitbtn").removeAttr('disabled', 'disabled');
                    }
                }
            });
            // }

        })


        $("#country_id").change(function() {
            var id = this.value;
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getLeadState'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#state_id").html(response);
                }
            });
        });
        $("#state_id").change(function() {
            var id = this.value;
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getLeadCity'
                },
                beforeSend: function() {},
                success: function(response) {
                    $("#city_id").html(response);
                }
            });
        });


        $("#pre_country_id").change(function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    id: id,
                    type: 'getState'
                },
                beforeSend: function() {},
                success: function(response) {
                    //console.log(response);
                    $("#pre_state_id").html(response);
                }
            });
        });

        var addButton = $('.add_field_button');
        var wrapper = $('#empDetails_add');
        <?php
                if(isset($_POST['empDetails'])){ ?>
        var x = <?php echo $ed-1; ?>;
        <?php }else{?>
        var x = 0;
        <?php }?>
        maxField = 10;
        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                $(wrapper).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Company Name</div><input type="text" class="form-control" placeholder="Company Name" name="empDetails[' +
                    x +
                    '][company_name]" id="company_name" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Designation</div><input type="text" class="form-control" placeholder="Designation" name="empDetails[' +
                    x +
                    '][designation]" id="designation" value=""></div></div></div><div class="col-md-6 display_flex"><div class="form-group display_input"><div class="input-group" ><div class="input-group-addon">Start Date</div><input type="date" class="form-control" style="width: 85% !important" placeholder="Start Date" name="empDetails[' +
                    x +
                    '][start_date]" value=""></div></div><div class="form-group display_input display_input1"><div class="input-group" ><div class="input-group-addon">End Date</div><input type="date" style="width: 80% !important" class="form-control" placeholder="End Date" name="empDetails[' +
                    x +
                    '][end_date]" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon">Last Salary</div><input type="number" class="form-control" placeholder="Last Salary"name="empDetails[' +
                    x +
                    '][last_salary]"></div></div></div></div><a href="#" class="remove_field removecls delete_btn">X</a></div>'
                );
            }
        });


        $(wrapper).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });


        $("#exam_name").change(function() {
            examval = $(this).val();
            if (examval != '') {
                if (examval == 'IELTS') {
                    $("#score").attr("placeholder", "Overall Bands");
                    $("#scorelabel").html("Overall Bands");
                } else {
                    $("#score").attr("placeholder", "OVERALL SCORE");
                    $("#scorelabel").html("OVERALL SCORE");
                }

                if (examval == 'DUOLINGO') {
                    $("#lang_listening").attr('readonly', 'readonly');
                    $("#lang_reading").attr('readonly', 'readonly');
                    $("#lang_writing").attr('readonly', 'readonly');
                    $("#lang_speaking").attr('readonly', 'readonly');

                    $("#lang_listening").removeClass('required');
                    $("#lang_reading").removeClass('required');
                    $("#lang_writing").removeClass('required');
                    $("#lang_speaking").removeClass('required');
                    $("#exam_date").addClass('required');
                } else {
                    $("#lang_listening").removeAttr('readonly');
                    $("#lang_reading").removeAttr('readonly');
                    $("#lang_writing").removeAttr('readonly');
                    $("#lang_speaking").removeAttr('readonly');

                    // $("#    ").addClass('required');
                    $("#lang_listening").addClass('required');
                    $("#lang_reading").addClass('required');
                    $("#lang_writing").addClass('required');
                    $("#lang_speaking").addClass('required');
                    $("#exam_date").addClass('required');
                }
            } else {
                $("#lang_listening").removeClass('required');
                $("#lang_reading").removeClass('required');
                $("#lang_writing").removeClass('required');
                $("#lang_speaking").removeClass('required');
                $("#score").removeClass('required');
                $("#exam_date").removeClass('required');
            }

        })

        var addButtonns = $('.add_lang_field_button');
        var wrapperrs = $('#langDetails_add');
        <?php
                if(isset($_POST['langDetails'])){ ?>
        var p = <?php echo $ld-1; ?>;
        <?php }else{?>
        var p = 0;
        <?php }?>
        maxField = 10;
        $(addButtonns).click(function() {
            if (p < maxField) {
                p++;
                $(wrapperrs).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Exam Name</div><select name="langDetails[' +
                    p + '][exam_name]" id="exam_name' + p +
                    '" class="form-control"><option value="">Select</option><option value="IELTS">IELTS</option><option value="PTE">PTE</option><option value="TOEFL">TOEFL</option><option value="DUOLINGO">DUOLINGO</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Listening</div><input type="text" class="form-control" placeholder="Listening" name="langDetails[' +
                    p + '][lang_listening]" readonly id="lang_listening' + p +
                    '" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Reading</div><input type="text" class="form-control" placeholder="Reading" name="langDetails[' +
                    p + '][lang_reading]" value="" readonly id="lang_reading' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Writing</div><input type="text" class="form-control" placeholder="Writing" name="langDetails[' +
                    p + '][lang_writing]" value=""  readonly id="lang_writing' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Speaking</div><input type="text" class="form-control" placeholder="Speaking" name="langDetails[' +
                    p + '][lang_speaking]" value="" readonly id="lang_speaking' + p +
                    '"></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="scorelabel' +
                    p + '">Overall Bands</div><input type="text" class="form-control" id="score' +
                    p + '" placeholder="Overall Bands" name="langDetails[' + p +
                    '][scrore]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">EXAM DATE</div><input type="date" id="exam_date' +
                    p +
                    '" class="form-control change-date" placeholder="READING" name="langDetails[' +
                    p +
                    '][exam_date]" value="" readonly></div></div></div></div><a href="#" class="remove_field removelangcls delete_btn">X</a></div>'
                );



                $("#exam_name" + p).change(function() {
                    examval = $(this).val();
                    if (examval != '') {
                        $("#exam_date" + p).removeAttr("readonly", 'readonly');
                        $("#score" + p).removeAttr("readonly", 'readonly');
                        $("#lang_speaking" + p).removeAttr("readonly", 'readonly');
                        $("#lang_writing" + p).removeAttr("readonly", 'readonly');
                        $("#lang_reading" + p).removeAttr("readonly", 'readonly');
                        $("#lang_listening" + p).removeAttr("readonly", 'readonly');
                        if (examval == 'IELTS') {
                            $("#score" + p).attr("placeholder", "Overall Bands");
                            $("#scorelabel" + p).html("Overall Bands");
                        } else {
                            $("#score" + p).attr("placeholder", "OVERALL SCORE");
                            $("#scorelabel" + p).html("OVERALL SCORE");
                        }

                        if (examval == 'DUOLINGO') {
                            $("#lang_listening" + p).attr('readonly', 'readonly');
                            $("#lang_reading" + p).attr('readonly', 'readonly');
                            $("#lang_writing" + p).attr('readonly', 'readonly');
                            $("#lang_speaking" + p).attr('readonly', 'readonly');

                            $("#lang_listening" + p).removeClass('required');
                            $("#lang_reading" + p).removeClass('required');
                            $("#lang_writing" + p).removeClass('required');
                            $("#lang_speaking" + p).removeClass('required');
                        } else {
                            $("#lang_listening" + p).removeAttr('readonly');
                            $("#lang_reading" + p).removeAttr('readonly');
                            $("#lang_writing" + p).removeAttr('readonly');
                            $("#lang_speaking" + p).removeAttr('readonly');

                            $("#score" + p).addClass('required');
                            $("#lang_listening" + p).addClass('required');
                            $("#lang_reading" + p).addClass('required');
                            $("#lang_writing" + p).addClass('required');
                            $("#lang_speaking" + p).addClass('required');
                        }
                    } else {
                        $("#lang_listening" + p).removeClass('required');
                        $("#lang_reading" + p).removeClass('required');
                        $("#lang_writing" + p).removeClass('required');
                        $("#lang_speaking" + p).removeClass('required');
                        $("#score" + p).removeClass('required');
                        $("#exam_date" + p).attr("readonly", 'readonly');
                        $("#score" + p).attr("readonly", 'readonly');
                        $("#lang_speaking" + p).attr("readonly", 'readonly');
                        $("#lang_writing" + p).attr("readonly", 'readonly');
                        $("#lang_reading" + p).attr("readonly", 'readonly');
                        $("#lang_listening" + p).attr("readonly", 'readonly');
                    }
                })
            }

        });


        $(wrapperrs).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });

        $("#exam_name").change(function() {
            var examid = $(this).val();
            if (examid != '') {
                $("#exam_date").removeAttr("readonly", 'readonly');
                $("#score").removeAttr("readonly", 'readonly');
                $("#lang_speaking").removeAttr("readonly", 'readonly');
                $("#lang_writing").removeAttr("readonly", 'readonly');
                $("#lang_reading").removeAttr("readonly", 'readonly');
                $("#lang_listening").removeAttr("readonly", 'readonly');
                if (examid == 'DUOLINGO') {
                    $("#lang_listening").attr('readonly', 'readonly');
                    $("#lang_reading").attr('readonly', 'readonly');
                    $("#lang_writing").attr('readonly', 'readonly');
                    $("#lang_speaking").attr('readonly', 'readonly');
                } else {
                    $("#lang_listening").removeAttr('readonly');
                    $("#lang_reading").removeAttr('readonly');
                    $("#lang_writing").removeAttr('readonly');
                    $("#lang_speaking").removeAttr('readonly');
                    $("#score").removeAttr('readonly');
                }
            } else {
                $("#exam_date").attr("readonly", 'readonly');
                $("#score").attr("readonly", 'readonly');
                $("#lang_speaking").attr("readonly", 'readonly');
                $("#lang_writing").attr("readonly", 'readonly');
                $("#lang_reading").attr("readonly", 'readonly');
                $("#lang_listening").attr("readonly", 'readonly');
            }
        })


        var addButtonn = $('.add_master_field_button');
        var wrapperr = $('#masterDetails_add');
        var y = 0;

        <?php
                if(isset($_POST['education'])){?>
        var m = 0;
        <?php }else{?>
        var m = 0;
        <?php }?>

        maxField = 10;
        $(addButtonn).click(function() {
            if (y < maxField) {
                y++;
                $(wrapperr).append(
                    '<div class="add" style="position:relative"><div class="row"><div class="col-md-2"><div class="form-group"><p style="text-align: left; ;background:#4b4b4d; padding:5px; color:white; border-radius:5px;font-size:x-small">Others</p></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control" placeholder="Institute/University" name="education[' +
                    m +
                    '][master_board]" id="master_board" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control" placeholder="Degree" name="education[' +
                    m +
                    '][master_stream]" id="master_stream" value=""></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><select class="form-control"  onchange="change_last_year(this.value, ' +
                    "'" + 'master_finish_year' + m + "'" + ')" name="education[' +
                    m +
                    '][master_start_year]" id="master_start_year"><option value="">Start Year</option><?php for($i=date('Y')-30; $i <=date('Y'); $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div><div class="col-md-2"><div class="form-group"><div class="input-group" style="width:100%;"><select class="form-control" name="education[' +
                    m +
                    '][master_finish_year]" id="master_finish_year' + m +
                    '"><option value="">Finish Year</option><?php for($i=date('Y')-30; $i <=date('Y'); $i++){?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php }?></select></div></div></div><div class="col-md-1"><div class="form-group"><div class="input-group" style="width:100%;"><input type="text" class="form-control addpercentage" placeholder="Percentage" name="education[' +
                    m +
                    '][master_percentage]" id="master_percentage" value="" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)"></div></div></div><div class="col-md-1"><div class="form-group" style="display:flex; gap:15px;"><div class="input-group" style="width:80%;"><input type="text" class="form-control" placeholder="Any Backlog" name="education[' +
                    m +
                    '][master_backlog]" id="master_backlog" value="" ></div></div></div></div><a href="#" class="remove_field removemastercls delete_btn">X</a></div>'
                );
                m++;
            }


            $(".addpercentage").change(function() {
                v1 = $(this).val();
                v2 = "%";
                $(this).val(v1.concat(v2));
            })

        });


        $(wrapperr).on('click', '.remove_field', function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });


    })
    </script>
    <script>
    function change_matric_board(val, id) {
        if (val == 'other') {
            $("#board_name").val('');
            $("#" + id).val('');

            $("#" + id + "_refresh").html(
                '<form id="submit_board" method="post"><div class="input-group" style="width:100%;display: flex;"><input type="text" onblur="submit_form()" class="form-control" placeholder="Board Name"name="name" id="board_name"><p style="cursor: pointer;margin: auto;padding-left: 5px;" onclick="refresh_div(' +
                "'" + id + "'" + ')">x</p></div></div></form>');
        }
    }

    function refresh_div(id) {
        if (id == 'matri_board') {
            $("#matri_board_refresh").load(location.href +
                " #matri_board_refresh");
        } else {
            $("#secondary_board_refresh").load(location.href +
                " #secondary_board_refresh");
        }
    }

    function submit_form() {
        $("#submit_board").submit();
    }

    $(document).ready(function() {
        $("#submit_board").submit(function(e) {
            e.preventDefault();
            let name = $("#board_name").val();
            if (name == '') {
                toastr.options.timeOut = 10000;
                toastr.error("Please enter board name");
            } else {
                $.ajax({
                    method: "POST",
                    url: 'ajax/ajax.php',
                    data: {
                        name: name,
                        submit_board_name: '1'
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.trim() === '2') {
                            toastr.options.timeOut = 10000;
                            toastr.error("This board is already exist");
                        } else {
                            $("#exampleModal").modal('hide');
                            $("#board_name").val('');
                            $("#matri_board_refresh").load(location.href +
                                " #matri_board_refresh");
                            $("#secondary_board_refresh").load(location.href +
                                " #secondary_board_refresh");
                            toastr.options.timeOut = 10000;
                            toastr.success("Board Added Successfully");
                        }
                    }
                })
            }
        })
    })
    </script>
    <script>
    function change_last_year(val, id) {
        if (val != '') {
            data = '';
            data += '<option value="">Finish Year</option>';
            for (i = val; i <= <?=date('Y')?>; i++) {
                data += '<option value="' + i + '">' + i + '</option>'
            }
            $("#" + id).html(data);
        } else {
            data = '';
            data += '<option value="">Finish Year</option>';
            for (i = <?=date('Y')-30?>; i <= <?=date('Y')?>; i++) {
                data += '<option value="' + i + '">' + i + '</option>'
            }
            $("#" + id).html(data);
        }
    }
    </script>
    <script>
    function change_refused(val) {
        $("#refused_date_change").html(val + " Date");
    }
    </script>



    <script>
    $("#exam_section_exam_name").change(function() {
        examval = $(this).val();
        if (examval != '') {
            $("#exam_section_score").removeAttr('readonly', 'readonly');
            $("#value1").removeAttr('readonly', 'readonly');
            $("#value2").removeAttr('readonly', 'readonly');
            $("#value3").removeAttr('readonly', 'readonly');
            $("#value4").removeAttr('readonly', 'readonly');
            $("#exam_section_score").addClass('required');
            if (examval == 'GRE') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');

                $("#value1_label").html('Analytical Reasoning');
                $("#value2_label").html('Quantitative Reasoning');
                $("#value3_label").html('Verbal Reasoning');

                $("#value4").removeClass('required');
                $("#value4").attr('readonly', 'readonly');

                $("#value1").attr('placeholder', 'Analytical Reasoning');
                $("#value2").attr('placeholder', 'Quantitative Reasoning');
                $("#value3").attr('placeholder', 'Verbal Reasoning');

            } else if (examval == 'GMAT') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');
                $("#value4").addClass('required');

                $("#value1_label").html('Analytical Reasoning');
                $("#value2_label").html('Integrated Reasoning');
                $("#value3_label").html('Quantitative');
                $("#value4_label").html('Verbal');

                $("#value1").attr('placeholder', 'Analytical Reasoning');
                $("#value2").attr('placeholder', 'Integrated Reasoning');
                $("#value3").attr('placeholder', 'Quantitative');

                $("#value4").addClass('required');

                $("#value4").removeAttr('readonly');
            } else if (examval == 'SAT') {
                $("#value1").addClass('required');
                $("#value2").addClass('required');
                $("#value3").addClass('required');

                $("#value1_label").html('Writing');
                $("#value2_label").html('Critical Reading');
                $("#value3_label").html('Mathematics ');

                $("#value4").removeClass('required');
                $("#value4").attr('readonly', 'readonly');

                $("#value1").attr('placeholder', 'Writing');
                $("#value2").attr('placeholder', 'Critical Reading');
                $("#value3").attr('placeholder', 'Mathematics');
            }
        } else {
            $("#exam_section_score").removeClass('required');
            $("#value1").removeClass('required');
            $("#value2").removeClass('required');
            $("#value3").removeClass('required');
            $("#value4").removeClass('required');

            $("#exam_section_score").attr('readonly', 'readonly');
            $("#value1").attr('readonly', 'readonly');
            $("#value2").attr('readonly', 'readonly');
            $("#value3").attr('readonly', 'readonly');
            $("#value4").attr('readonly', 'readonly');
        }

    })

    var addButtonns = $('.add_exam_section_button');
    var wrapperrs = $('#exam_section_add');
    <?php
                if(isset($_POST['exam_section'])){ ?>
    var p = <?php echo $lds-1; ?>;
    <?php }else{?>
    var p = 0;
    <?php }?>
    maxField = 10;
    $(addButtonns).click(function() {
        if (p < maxField) {
            p++;
            $(wrapperrs).append(
                '<div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon">Exam Name</div><select name="exam_section[' +
                p + '][exam_name]" id="exam_section_exam_name' + p +
                '" class="form-control"><option value="">Select</option><option value="GRE">GRE</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option></select></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value1_label' +
                p +
                '">Analytical Reasoning</div><input type="number" class="form-control" placeholder="Analytical Reasoning" id="value1' +
                p + '" name="exam_section[' + p +
                '][value1]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value2_label' +
                p +
                '">Integrated Reasoning</div><input type="number" class="form-control" placeholder="Integrated Reasoning" id="value2' +
                p + '" name="exam_section[' + p +
                '][value2]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value3_label' +
                p +
                '">Quantitative</div><input type="number" class="form-control" placeholder="Quantitative" id="value3' +
                p + '" name="exam_section[' + p +
                '][value3]" value=""></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="value4_label' +
                p +
                '" readonly>Verbal</div><input type="number" class="form-control" placeholder="Verbal" id="value4' +
                p + '" name="exam_section[' + p +
                '][value4]" value="" readonly></div></div></div><div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon" id="exam_section_score_label' +
                p +
                '">Overall Score</div><input type="number" class="form-control" placeholder="Overall Score" id="exam_section_score' +
                p + '" name="exam_section[' +
                p + '][scrore]" value="" readonly></div></div></div><a class="remove_field">x</a></div>');



            $("#exam_section_exam_name" + p).change(function() {
                examval = $(this).val();
                if (examval != '') {
                    $("#exam_section_score" + p).removeAttr('readonly', 'readonly');
                    $("#value1" + p).removeAttr('readonly', 'readonly');
                    $("#value2" + p).removeAttr('readonly', 'readonly');
                    $("#value3" + p).removeAttr('readonly', 'readonly');
                    $("#value4" + p).removeAttr('readonly', 'readonly');
                    $("#exam_section_score").addClass('required');
                    if (examval == 'GRE') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');

                        $("#value1_label" + p).html('Analytical Reasoning');
                        $("#value2_label" + p).html('Quantitative Reasoning');
                        $("#value3_label" + p).html('Verbal Reasoning');

                        $("#value4" + p).removeClass('required');
                        $("#value4" + p).attr('readonly', 'readonly');

                        $("#value1" + p).attr('placeholder', 'Analytical Reasoning');
                        $("#value2" + p).attr('placeholder', 'Quantitative Reasoning');
                        $("#value3" + p).attr('placeholder', 'Verbal Reasoning');

                    } else if (examval == 'GMAT') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');
                        $("#value4" + p).addClass('required');

                        $("#value1_label" + p).html('Analytical Reasoning');
                        $("#value2_label" + p).html('Integrated Reasoning');
                        $("#value3_label" + p).html('Quantitative');
                        $("#value4_label" + p).html('Verbal');

                        $("#value1" + p).attr('placeholder', 'Analytical Reasoning');
                        $("#value2" + p).attr('placeholder', 'Integrated Reasoning');
                        $("#value3" + p).attr('placeholder', 'Quantitative');

                        $("#value4" + p).addClass('required');

                        $("#value4" + p).removeAttr('readonly');
                    } else if (examval == 'SAT') {
                        $("#value1" + p).addClass('required');
                        $("#value2" + p).addClass('required');
                        $("#value3" + p).addClass('required');

                        $("#value1_label" + p).html('Writing');
                        $("#value2_label" + p).html('Critical Reading');
                        $("#value3_label" + p).html('Mathematics ');

                        $("#value4" + p).removeClass('required');
                        $("#value4" + p).attr('readonly', 'readonly');

                        $("#value1" + p).attr('placeholder', 'Writing');
                        $("#value2" + p).attr('placeholder', 'Critical Reading');
                        $("#value3" + p).attr('placeholder', 'Mathematics');
                    }
                } else {
                    $("#exam_section_score" + p).removeClass('required');
                    $("#value1" + p).removeClass('required');
                    $("#value2" + p).removeClass('required');
                    $("#value3" + p).removeClass('required');
                    $("#value4" + p).removeClass('required');

                    $("#exam_section_score" + p).attr('readonly', 'readonly');
                    $("#value1" + p).attr('readonly', 'readonly');
                    $("#value2" + p).attr('readonly', 'readonly');
                    $("#value3" + p).attr('readonly', 'readonly');
                    $("#value4" + p).attr('readonly', 'readonly');
                }

            });
        }
    });

    $(wrapperrs).on('click', '.remove_field', function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
    </script>
    <script>
    function change_matriculation() {
        var check = document.getElementsByClassName('visatypecls');
        var checkedCount = 0;
        var checkedValue = false;
        for (var i = 0; i < check.length; i++) {
            if (check[i].checked) {
                if (check[i].value == "Visitior/tourist") {
                    checkedValue = true;
                } else {
                    checkedValue = false;
                }
                checkedCount++;
            }
        }
        if (checkedCount == 1 && checkedValue == true) {
            $("#matri_board").removeClass('required error');
            $("#matri_board").next('.error').hide();
            $("#matri_start_year").removeClass('required error');
            $("#matri_start_year").next('.error').hide();
            $("#matri_finish_year").removeClass('required error');
            $("#matri_finish_year").next('.error').hide();
            $("#matri_percentage").removeClass('required error');
            $("#matri_percentage").next('.error').hide();
        } else {
            $("#matri_board").addClass('required');
            $("#matri_start_year").addClass('required');
            $("#matri_finish_year").addClass('required');
            $("#matri_percentage").addClass('required');
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        $(".change-date").change(function() {
            var val = $(this).val();
            if (val != '') {
                $(this).removeClass('required');
                $(this).next('.error').hide();
                $(this).css("color", "black");
            } else {
                $(this).addClass('required');
                $(this).next('.error').show();
                $(this).css("color", "red");
            }
        });
    });
    </script>
    <script>
    function same_primary() {
        if ($("#same_as_primary_number").prop('checked')) {
            $("#applicant_alternate_no").val($("#applicant_contact_no").val());
        } else {
            $("#applicant_alternate_no").val('');
        }
    }

    $("#same_as_primary_number").on("change", same_primary);
    </script>
    <script>
    function change_university(val) {
        get = document.getElementById("visa_earlier1").checked;
        if (val.checked == 1 && get == 1) {
            $(".earlieruniversity").show();
            $(".earlieruniversity input").addClass('required');
        } else {
            $(".earlieruniversity").hide();
            $(".earlieruniversity input").removeClass('required');
            $("#university_name").val('');
            $("#course_name").val('');
        }
    }

    function change_university1(val) {
        get = document.getElementById("visa_earlier1").checked;
        earlier_country_id = $("#earlier_country_id").val();
        if (val.checked == 1 && get == 1 && earlier_country_id == 3) {
            $(".earlieruniversity").show();
            $(".earlieruniversity").show();
            $(".earlieruniversity input").addClass('required');
        } else {
            $(".earlieruniversity").hide();
            $(".earlieruniversity input").removeClass('required');
            $("#university_name").val('');
            $("#course_name").val('');
        }
    }
    }
    </script>
    <script>
    function check_validation() {
        applicant_contact_no = $("#applicant_contact_no").val();
        applicant_alternate_no = $("#applicant_alternate_no").val();
        $.ajax({
            type: "post",
            url: 'controller.php',
            data: {
                applicant_contact_no: applicant_contact_no,
                applicant_alternate_no: applicant_alternate_no,
                check_visit_validation: 1
            },
            success: function(data) {
                if (data == 1) {
                    alert('Please enter another mobile number');
                } else {
                    $("#visitfrm").submit();
                }
            }
        });
    }
    </script>
    <script>
    function get_family_fund(val) {
        if (val == 'Yes') {
            $("#family_fund_show").show();
            $("#available_funds").addClass('required');
        } else {
            $("#family_fund_show").hide();
            $("#available_funds").val('');
            $("#available_funds").removeClass('required');
        }
    }
    </script>
    <script>
    function change_earlier_country_id(val) {
        $(".earlieruniversity").hide();
        $(".earlieruniversity input").removeClass('required');
        $(".earlieruniversity input").val('');
        flexCheckChecked1 = document.getElementById('flexCheckChecked1').checked;
        flexCheckChecked2 = document.getElementById('flexCheckChecked2').checked;
        if (val == 3) {
            $("#embassy_show").show();
            $("#embassy").addClass('required');
            if (flexCheckChecked1 == true || flexCheckChecked2 == true) {
                $(".earlieruniversity").show();
                $(".earlieruniversity input").addClass('required');
            }
        } else {
            if (flexCheckChecked1 == true) {
                $(".earlieruniversity").show();
                $(".earlieruniversity input").addClass('required');
            }
            $("#embassy_show").hide();
            $("#embassy").val('');
            $("#embassy").removeClass('required');
        }

    }
    </script>
    <script>
    function change_country(val) {
        if (val == 7) {
            $("#change_country").html("Preferred Area");
            $("#change_state").html("Preferred Country (Optional)");
            $("#pre_country_id option:first").text("Preferred Area");
            $("#pre_state_id option:first").text("Preferred Country");
        } else {
            $("#change_country").html("Preferred Country");
            $("#change_state").html("Preferred State (Optional)");
            $("#pre_country_id option:first").text("Preferred Country");
            $("#pre_state_id option:first").text("Preferred State");
        }
    }
    </script>
</body>

</html>