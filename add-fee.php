<?php
include('include/config.php');
include("include/functions.php");
validate_user();
if ($_REQUEST['id'] != '') {
    $telecaller_id = 0;
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $sql = $obj->query("select * from $tbl_visit where id='$id'");
    $result = $obj->fetchNextObject($sql);
    $enq_id = 1000 + $id;
    $sql1 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='".$_GET['type']."'");
    $result_fee = $obj->fetchNextObject($sql1);
    $sql1s = $obj->query("select * from $tbl_visit_fee where visit_id='$id'");
    $result_fees = $obj->fetchNextObject($sql1s);
    $result_fee_count = $obj->numRows($sql1);
    $total = $result_fee->cash + $result_fee->upi + $result_fee->cheque + $result_fee->bank + $result_fee->swipe;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style type="text/css">
    .removecls {
        position: absolute;
        top: 3px;
        right: 0px;
        font-size: 20px;
    }


    .removeuniclss {
        position: absolute;
        top: 3px;
        right: -12px;
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

    .counsller_visit {
        background: green;
        padding: 9px 12px;
        border-radius: 3px;
        color: white;
        text-transform: uppercase;
        text-align: center !important;
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

    @media (max-width: 992px) {
        .text-center-in-mobile-tab {
            text-align: center;
        }
    }

    @media (min-width: 541px) {
        .display-flex {
            display: flex;
        }

        .display-flex .boxing {
            width: 50%;
        }

        .display-flex .boxing1 {
            width: 50%;
            margin-left: 10px;
        }
    }

    @media (max-width: 541px) {
        .display-flex .boxing {
            width: 100%;
        }
    }

    .label-required label.error {
        position: absolute !important;
        bottom: -56px !important;
        width: 12pc !important;
        max-width: 145px !important;
        left: 480px !important;
    }

    @media (max-width: 992px) {
        .label-required label.error {
            position: absolute !important;
            bottom: -280px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 0 !important;
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

    .reapply-red {
        border: 1px solid red !important;
        color: red !important
    }
    </style>
</head>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container">
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg'];
                    $_SESSION['sess_msg'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="student_filter">
                    <?php
                        if($_GET['type'] == 'Enrollment'){
                                  $sql = $obj->query("select count(*) as total from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                                   $results = $obj->fetchNextObject($sql);
                                   if($results->total == 0){
                                       $type = 'Direct Enrollment';
                                    }else{
                                        $type = $_GET['type'];
                                    }
                                }else{
                                    $type = $_GET['type'];
                                }
                                ?>
                    <h4 class="my-3">
                        <?php
                        if ($_REQUEST['id'] != '') { ?>
                        <!-- <?=$type?> Now -->
                        Update Profile
                        <?php } ?>

                    </h4>
                    <form method="post" action="controller.php" name="visitfrm" id="form-validate"
                        enctype='multipart/form-data' meaning>
                        <input type="hidden" name="btn_visit_fee" value='1'>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="visit_id" id="" value="<?php echo $id ?>">

                        <input type="hidden" name="payment_type" id="" value="<?=$type?>">
                        <input type="hidden" id="fee_id" name="fee_id"
                            value="<?= $result_fee_count > 0 ? $result_fee->id : '' ?>" readonly>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Enquiry ID
                                                &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Enquiry ID"
                                            name="enquiry_id" id="enquiry_id" value="<?php echo $result->enquiry_id; ?>"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Enquiry
                                                Date&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <input type="date" class="required form-control" name="enquiry_date"
                                            id="enquiry_date"
                                            value="<?php if ($result->enquiry_date != '') {
                                                                                                                                            echo $result->enquiry_date;
                                                                                                                                        } else {
                                                                                                                                            echo date('Y-m-d');
                                                                                                                                        } ?>"
                                            readonly>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp;
                                            <span>Telecaller&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;
                                                &nbsp;</span>
                                        </div>

                                        <?php
                                        $get_tel = $obj->query("select * from $tbl_lead where applicant_contact_no in ('" . $result->applicant_contact_no . "','" . $result->applicant_alternate_no . "') or applicant_alternate_no in ('" . $result->applicant_contact_no . "','" . $result->applicant_alternate_no . "')");
                                        $res_get_tel = $obj->fetchNextObject($get_tel);
                                        ?>
                                        <select name="telecaller_id" id="telecaller_id" class="form-control" disabled>
                                            <option value="">Telecaller</option>
                                            <?php

                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                            while ($clResult = $obj->fetchNextObject($clSql)) { ?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?php if ($result->telecaller_id == $clResult->id || $res_get_tel->crm_executive_id == $clResult->id) { ?>
                                                selected <?php } ?>>
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Councellor
                                                &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select name="councellor_id[]" id="councellor_id"
                                            class="required form-control select2" multiple disabled>
                                            <option value="">Councellor</option>
                                            <?php
                                            $coun = explode(',', $result->councellor_id);
                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 and FIND_IN_SET($result->branch_id, branch_id) order by name");
                                            while ($clResult = $obj->fetchNextObject($clSql)) { ?>
                                            <option value="<?php echo $clResult->id; ?>"
                                                <?php if (in_array($clResult->id, $coun)) { ?> selected <?php } ?>>
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Applicant Name
                                                &nbsp;</span></div>
                                        <input type="text" class="required form-control" placeholder="Applicant Name"
                                            name="applicant_name" id="applicant_name"
                                            value="<?php echo $result->applicant_name; ?>" disabled>
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
                                            value="<?php echo $result->father_name; ?>" disabled>
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
                                        <input type="text" class="required form-control change-date"
                                            placeholder="Date Of Birth" name="dob" id="dob"
                                            value="<?php echo $result->dob; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"> <span><i class="fa-solid fa-people-group"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Marital Status
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="marital_status" id="marital_status"
                                            disabled>
                                            <option value="">Select Marital Status</option>
                                            <option value="1" <?php if ($result->marital_status == 1) { ?> selected
                                                <?php } ?>>Married</option>
                                            <option value="2" <?php if ($result->marital_status == 2) { ?> selected
                                                <?php } ?>>Unmarried</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-phone-volume"
                                                    style="font-size:15px;"></i></span>
                                            &nbsp; <span>Phone Number</span></div>
                                        <input type="text" class="required form-control" placeholder="Phone Number"
                                            name="applicant_contact_no" id="applicant_contact_no"
                                            value="<?php echo $result->applicant_contact_no; ?>" maxlength="10"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-tty"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Alternate
                                                Number</span></div>
                                        <input type="text" class="form-control" placeholder="Alternate Number"
                                            name="applicant_alternate_no" id="applicant_alternate_no"
                                            value="<?php echo $result->applicant_alternate_no; ?>" maxlength="10"
                                            readonly>
                                    </div>
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
                                        <select name="enquiry_type" class="form-control form-select" disabled>
                                            <option value="">Select Type</option>
                                            <option value="Online"
                                                <?php echo $result->enquiry_type == 'Online' ? 'selected' : ''  ?>>
                                                Online</option>
                                            <option value="Walkin"
                                                <?php echo $result->enquiry_type == 'Walkin' ? 'selected' : ''  ?>>
                                                Walkin</option>
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
                                        <input type="text" class="form-control" placeholder="Address" name="address"
                                            id="address" value="<?php echo $result->address; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-location-dot"
                                                    style="font-size:15px;"></i></span>
                                            &nbsp; <span>State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                                        <select class="required form-control" name="state_id" id="mstate_id" disabled>
                                            <option value="">Select State</option>
                                            <?php
                                            $i = 1;
                                            $sql = $obj->query("select * from $tbl_location_states where 1=1 order by name", $debug = -1);
                                            while ($line = $obj->fetchNextObject($sql)) { ?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if ($result->state_id == $line->id) { ?> selected <?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"> <span><i class="fa-solid fa-city"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>District</span>
                                        </div>
                                        <select class="required form-control" name="city_id" id="city_id" disabled>
                                            <option value="">Select District</option>
                                            <?php
                                            $i = 1;
                                            $citysql = $obj->query("select * from $tbl_location_cities where 1=1 and state_id='" . $result->state_id . "' order by name", $debug = -1);
                                            while ($cityline = $obj->fetchNextObject($citysql)) { ?>
                                            <option value="<?php echo $cityline->id ?>"
                                                <?php if ($result->city_id == $cityline->id) { ?> selected <?php } ?>>
                                                <?php echo $cityline->name ?></option>
                                            <?php } ?>
                                            <option value="1000">Other</option>
                                        </select>
                                    </div>
                                    <input type="text" name="city_name" id="city_name" value="" class="form-control"
                                        placeholder="Add Your City Here" style="display:none;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "> <span><i class="fa-solid fa-globe"
                                                    style="font-size:15px;"></i></span>
                                            <span>Preferred Country</span>
                                        </div>

                                        <select class="required form-control" name="pre_country_id" id="pre_country_id"
                                            disabled>
                                            <option value="">Select Preferred Country</option>
                                            <?php
                                            $psql = $obj->query("select * from $tbl_country where 1=1 and status=1 group by name order by displayorder", -1);
                                            while ($pResult = $obj->fetchNextObject($psql)) { ?>
                                            <option value="<?php echo $pResult->id ?>"
                                                <?php if ($result->pre_country_id == $pResult->id) { ?> selected
                                                <?php } ?>><?php echo $pResult->name; ?></option>
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
                                        <div class="input-group-addon space-Alternate space-Alternate">Preferred
                                            State</div>

                                        <select
                                            class="<?php if (!in_array(1, $addtional_role)) { ?> required <?php } ?> form-control"
                                            name="pre_state_id" id="pre_state_id" disabled>
                                            <option value="">Select State</option>
                                            <?php
                                            if ($result->pre_country_id != '') {
                                                $stateSql = $obj->query("select * from $tbl_state where 1=1 and status=1 and country_id='" . $result->pre_country_id . "' group by state", -1);
                                                while ($stateResult = $obj->fetchNextObject($stateSql)) { ?>
                                            <option value="<?php echo $stateResult->id ?>"
                                                <?php if ($result->pre_state_id == $stateResult->id) { ?> selected
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
                            <div class="col-md-6 form-group">
                                <div id="refresh_div" style="display:flex; gap:10px; flex-wrap:wrap;">
                                    <div class=""
                                        style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                        <span><i class="fa-solid fa-plane-departure" style="font-size:15px;"></i></span>
                                        <Span> Visa type&nbsp;</Span>
                                        <?php
                                        $visaArr = array();
                                        if(isset($_SESSION['visa_type_session'])){
                                            $visaArr = explode(',', $_SESSION['visa_type_session']);
                                        }elseif($result_fees->visa_type != ''){
                                            $visaArr = explode(',', $result_fees->visa_type);
                                        }else{
                                            $visaArr = explode(',', $result->visa_type);
                                        }
                                     ?>
                                    </div>


                                    <div>
                                        <input class="form-check-input change_visa_sub_type" type="checkbox"
                                            name="visa_type[]" value="Study" id="flexCheckChecked"
                                            <?php if (in_array('Study', $visaArr)) { $visa_type = 'Study';  ?> checked
                                            <?php } ?> <?=$result->visa_type != '' ? '' : ''?>>
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Study
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input change_visa_sub_type" type="checkbox"
                                            name="visa_type[]" value="Visitor" id="flexCheckCheckeds"
                                            <?php if (in_array('Visitior/tourist', $visaArr) || in_array('Visitor', $visaArr)) { $visa_type = 'Visitor'; ?>
                                            checked <?php } ?> <?=$result->visa_type != '' ? '' : ''?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Visitior
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input change_visa_sub_type" type="checkbox"
                                            name="visa_type[]" value="Tourist" id="flexCheckCheckeds"
                                            <?php if (in_array('Visitior/tourist', $visaArr) || in_array('Tourist', $visaArr)) { $visa_type = 'Tourist'; ?>
                                            checked <?php } ?> <?=$result->visa_type != '' ? '' : ''?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Tourist
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input change_visa_sub_type" type="checkbox"
                                            name="visa_type[]" value="Spouse" id="flexCheckChecked"
                                            <?php if (in_array('Spouse', $visaArr)) { $visa_type = 'Spouse'; ?> checked
                                            <?php } ?> <?=$result->visa_type != '' ? '' : ''?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Spouse
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input change_visa_sub_type" type="checkbox"
                                            name="visa_type[]" value="Work" id="flexCheckChecked"
                                            <?php if (in_array('Work', $visaArr)) {  $visa_type = 'Work';?> checked
                                            <?php } ?> <?=$result->visa_type != '' ? '' : ''?>> &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:8px;">
                                            Work
                                        </label>
                                    </div>
                                    <?php
                                    if(count($visaArr) > 1){
                                        ?>
                                    <span class="text-danger" id="hide_error">Please select only one visa type</span>
                                    <?php
                                    }
                                    ?>
                                    <span class="text-danger" id="show_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="refresh_div2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "><i class="fa-solid fa-location-crosshairs"
                                                    style="font-size:15px;"></i>
                                            </div>
                                            <div class="input-group-addon space-Alternate space-Alternate">Visa Sub Type
                                            </div>
                                            <select
                                                class="form-control <?=$_GET['type'] == 'Reapply' ? 'reapply-red' : ''?>"
                                                name="visa_sub_type" id="visit_sub_type"
                                                onchange="get_visa_sub_type(this.value)"
                                                <?php if($result->visa_sub_type != '') { if($_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 14){ echo 'disabled'; } }  ?>>
                                                <option value="">Select Visa Sub Type</option>
                                                <?php
                                                $whr = " and a.type='{$_GET['type']}'";
                                                // if (strpos($_GET['type'], 'Reapply') !== false) {
                                                //     $whr = " AND b.visa_sub_type LIKE '%Reapplied%'";
                                                // }
                                                $stateSqls = $obj->query("select a.* from $tbl_visa_sub_type as a where a.country_id='".$result->pre_country_id."' and a.visa_type='$visa_type' and status=1 $whr order by id asc", -1);
                                                while ($stateResult = $obj->fetchNextObject($stateSqls)) { ?>
                                                <option value="<?php echo $stateResult->id ?>"
                                                    <?php if (($result->visa_sub_type == $stateResult->id) || $_SESSION['visa_sub_type'] == $stateResult->id) { ?>
                                                    selected <?php } ?>>
                                                    <?php echo $stateResult->visa_sub_type;?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <span id="show_registration_percentage" style="color:red"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="refresh_div1" <?php if($result->visa_sub_type == ''){ ?> style="display:none"
                            <?php } ?>>
                            <div id="refresh_all">
                                <?php
                                $min = 100;
                                $max = 100;
                                $value = '';
                                $remark = '';
                                $label = 'Profile Completion (%)';
                                $placeholder = 'Enter Profile Completion (%)';
                                $statu_id = base64_decode(base64_decode(base64_decode($_GET['profile'])));
                                $profile_s1 = $obj->query("SELECT * FROM $tbl_profile_status where id='$statu_id'");
                                $profile_s_count = $obj->query("SELECT * FROM $tbl_profile_status where visit_id='$id'");
                                $get_pro_per = $obj->fetchNextObject($obj->query("SELECT * FROM $tbl_visa_sub_type where id='{$_SESSION['visa_sub_type']}'"));
                                if($obj->numRows($profile_s_count) == 0){
                                    $min = 0; 
                                    $max = 100;
                                }else{
                                    $profile_s_counts = $obj->fetchNextObject($profile_s_count);
                                    $min = $min - $profile_s_counts->percentage;
                                    $max = 100 - $profile_s_counts->percentage;
                                    $label = 'Profile Completion ('.$profile_s_counts->percentage.'%)';
                                    $placeholder = 'Enter Pending Profile Completion (%)';
                                }
                                if($obj->numRows($profile_s1) > 0){
                                    $profile_s1s = $obj->fetchNextObject($profile_s1);
                                    $value = $profile_s1s->percentage;
                                    $remark = $profile_s1s->remark;
                                    $max = 100;
                                    $min = 0;
                                    ?>
                                <input type="hidden" name="status_id" value="<?=$statu_id?>">
                                <?php
                                }
                                if($_GET['type'] == 'Reapply' || $_GET['type'] == 'Refund' || $_GET['type'] == 'University Transfer'){
                                    $min = 100;
                                    $max = 100;
                                    ?>
                                <input type="hidden" name="reapply" value="1">
                                <?php
                                }
                                ?>
                                <input type="hidden" name="type" value="<?=$_GET['type']?>">
                                <input type="hidden" id="last_payment" value="<?=$profile_s_counts->percentage?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate">
                                                    <?=$label?></div>
                                                <input type="number" class="form-control"
                                                    placeholder="<?=$placeholder?>" name="profile_status"
                                                    id="profile_status" max="<?=$max?>" min="<?=$min?>"
                                                    value="<?=$value?>" required>
                                                <small id="error_msg" style="color: red; display: none;"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate">Remark
                                                </div>
                                                <input type="text" class="form-control" placeholder="Enter Remark"
                                                    name="remark" value="<?=$remark?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (strpos($_GET['type'], 'Reapply') !== false) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Allocate
                                                        Councellor</span>
                                                </div>
                                                <select type="text" class="form-control" name="allocate_counsellor"
                                                    id="allocate_counsellor" required>
                                                    <option value="">Allocate Councellor</option>
                                                    <?php
                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 and FIND_IN_SET($result->branch_id, branch_id) order by name");
                                            while ($clResult = $obj->fetchNextObject($clSql)) { ?>
                                                    <option value="<?php echo $clResult->id; ?>">
                                                        <?php echo $clResult->name; ?></option>
                                                    <?php }
                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                   <?php
                                        $get_dulingo = $obj->query("SELECT * FROM $tbl_duolingo_classe where visit_id='$id'");
                                        $dulingo_count = $obj->numRows($get_dulingo);
                                        $dulingo = $obj->fetchNextObject($get_dulingo);
                                    ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate">Duolingo</div>
                                                     <select class="form-control required" name="duolingo" id="duolingo" onchange="change_duling(this.value)" required  <?=$dulingo_count > 0 ? 'disabled' : ''?>>
                                                    <option value="">Select Duolingo</option>
                                                    <option value="Yes" <?=$dulingo_count > 0 ? 'selected' : ''?>>Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <div class="col-md-4 doulingo_classes" <?=$dulingo_count > 0 ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate">Mode
                                                </div>
                                                <select class="form-control" name="duolingo_mode" id="duolingo_mode"  <?=$dulingo_count > 0 ? 'disabled' : ''?>>
                                                    <option value="">Select Duolingo Mode</option>
                                                    <option value="Online" <?=$dulingo->class_mode == 'Online' ? 'selected' : ''?>>Online</option>
                                                    <option value="Offline" <?=$dulingo->class_mode == 'Offline' ? 'selected' : ''?>>Offline</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 doulingo_classes" <?=$dulingo_count > 0 ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate"
                                                    style="height:34px">Duolingo Days</div>
                                                <input type="text" class="form-control" placeholder="Duolingo Days"
                                                    name="duolingo_days" id="duolingo_days"  <?=$dulingo_count > 0 ? 'disabled' : ''?> value="<?=$dulingo->no_of_days?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                        $get_spoken = $obj->query("SELECT * FROM $tbl_spoken_classe where visit_id='$id'");
                                        $spoken_count = $obj->numRows($get_spoken);
                                        $spoken = $obj->fetchNextObject($get_spoken);
                                    ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate">Spken</div>
                                                     <select class="form-control required" name="spoken" id="spoken" onchange="change_spoken(this.value)" required  <?=$spoken_count > 0 ? 'disabled' : ''?>>
                                                    <option value="">Select Spoken</option>
                                                    <option value="Yes" <?=$spoken_count > 0 ? 'selected' : ''?>>Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 spoken_classes" <?=$spoken_count > 0 ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><i
                                                        class="fa-solid fa-location-crosshairs"
                                                        style="font-size:15px;"></i>
                                                </div>
                                                <div class="input-group-addon space-Alternate space-Alternate"
                                                    style="height:34px">Spoken Days</div>
                                                <input type="text" class="form-control" placeholder="Spoken Days"
                                                    name="spoken_days" id="spoken_days"  <?=$spoken_count > 0 ? 'disabled' : ''?> value="<?=$spoken->no_of_days?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center;">
                                        <div class="">
                                            <div style="text-align: center; padding: 10px;">
                                                <button type="submit" id="submitbtn" name="btn_visit_fee"
                                                    class="btn mr-10">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="refresh_div1" <?php if($result->visa_sub_type == ''){ ?> style="display:none"
                            <?php } ?>>
                            <div id="refresh_all">
                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center;">
                                        <div class="form-group">
                                            <div style="text-align: center; padding: 10px;">
                                                <a href="javascript:void(0);" class="counsller_visit" id="toggle"
                                                    style="color:white">Payment Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Date</span>
                                                </div>
                                                <input type="date" class="form-control" placeholder="Date" name="date"
                                                    id="date"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->payment_date : date('Y-m-d') ?>"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                if($result->visa_sub_type != ''){
                                    $visa_sub_type = $result->visa_sub_type;
                                }
                                if(isset($_SESSION['visa_sub_type'])){
                                $visa_sub_type = $_SESSION['visa_sub_type'];
                                }
                                     $get = $obj->query("select * from $tbl_enrolled_fee where country_id='".$result->pre_country_id."' and visa_type='$visa_type' and visa_sub_type='$visa_sub_type'");
                                 $res = $obj->fetchNextObject($get);
                                 $max_amount = $res->amount;
                                 $result_enrolled_count = $obj->numRows($get);
                                if($_GET['type'] == 'Registration'){
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Registration
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Registration Amount" name="registration_amount"
                                                    id="registration_amount" 
                                                    value="<?= $result_fee_count > 0 ? $result_fee->registration_amount : '' ?>"
                                                    onkeyup="change_registration_amount()" onblur="enable_button()" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }elseif($_GET['type'] == 'Enrollment'){
                                $sql = $obj->query("select count(*) as total,registration_amount from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                                $results = $obj->fetchNextObject($sql);
                                $already = $result_fee_count > 0 ? $result_fee->amount_already_paid : $results->registration_amount;
                                if($result_enrolled_count > 0){
                                    $enrollment_fee = $res->amount;
                                    $gst = round((($enrollment_fee-$already) * 18)/100,0);
                                    $discount = $res->discount;
                                }else{
                                    $enrollment_fee = 0;
                                    $gst = 0;
                                    $discount = 0;
                                }
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Enrollment
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Enrollment Amount"
                                                    name="enrollment_amount" id="enrollment_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->enrollment_amount : $enrollment_fee ?>"
                                                    onkeyup="change_registration_amount();change_pending_amount();"
                                                    onblur="enable_button()" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                   if($results->total > 0){
                                 
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Registration Amount</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Registration Amount" name="amount_already_paid"
                                                    id="amount_already_paid" value="<?= $already ?>"
                                                    onkeyup="change_registration_amount();change_pending_amount();"
                                                    onblur="enable_button()" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Pending
                                                        Enrollment
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Pending Enrollment Amount"
                                                    name="pending_enrollement_amount" id="pending_enrollement_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->pending_enrollement_amount : $enrollment_fee - $already ?>"
                                                    onkeyup="change_registration_amount();change_pending_amount();"
                                                    onblur="enable_button()" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Discount Amount"
                                                    name="discount_amount" id="discount_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->discount_amount : '' ?>"
                                                    max="<?=$discount?>"
                                                    onkeyup="change_pending_amount(); get_discount(this.value,'<?=$discount?>','discount_error')"
                                                    onblur="enable_button()" style="width: 98%;border-radius: 0 5px 5px 0;">
                                                    <div style="cursor:pointer;background: green;border-radius: 5px" onclick="discount_calculate()" class="input-group-addon"><span><span>Discount - Tax</span></div>
                                                </div>
                                                <span style="color:red" id="discount_error"></span>
                                        </div>
                                    </div>
                                    <?php
                                    if($_GET['type']!='Registration'){
                                    ?>
                                    <div class="col-md-3" id="accepted_by_show1"
                                        <?=$result_fee->discount_reason !='' ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount Reason</span>
                                                </div>
                                                <select name="discount_reason" id="discount_reason"
                                                    class="form-control form-select">
                                                    <option value="">Select Discount Approved By</option>
                                                    
                                                    <option value="Social Media Discount" <?=$result_fee->discount_reason  == 'Social Media Discount' ? 'selected' : ''?>>Social Media Discount</option>
                                                    <option value="Approved in written in Paper" <?=$result_fee->discount_reason  == 'Approved in written in Paper' ? 'selected' : ''?>>Approved in written in Paper</option>
                                                    <option value="Approved in Whatsapp" <?=$result_fee->discount_reason  == 'Approved in Whatsapp' ? 'selected' : ''?>>Approved in Whatsapp</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="accepted_by_show"
                                        <?=$result_fee->accepted_by !='' ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount Approved By</span>
                                                </div>
                                                <select name="accepted_by" id="accepted_by"
                                                    class="form-control form-select">
                                                    <option value="">Select Discount Approved By</option>
                                                    <?php
                                                   $branch = getField('approval_members',$tbl_branch,$result->branch_id);
                                                   $branch = explode(',',$branch);
                                                   foreach($branch as $ress){
                                                    ?>
                                                    <option value="<?=$ress?>"
                                                        <?=$result_fee->accepted_by  == $ress ? 'selected' : ''?>>
                                                        <?=$ress?></option>
                                                    <?php
                                                   }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Net
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Net Amount"
                                                    name="net_amount" id="net_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->net_amount : $enrollment_fee - $already  ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }else{
                                    if($result_enrolled_count > 0){
                                        if($_GET['type'] == 'After Visa'){    
                                            $enrollment_fee = $res->after_visa_amount;
                                            $gst = round(($enrollment_fee * 18)/(100),0);
                                            $discount = $res->after_visa_discount;
                                        }else{
                                            $enrollment_fee = $res->amount;
                                            $gst = round(($enrollment_fee * 18)/(100),0);
                                            $discount = $res->discount;
                                        }
                                    }else{
                                        $enrollment_fee = 0;
                                        $gst = 0;
                                        $discount = 0;
                                    }
                                ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp;
                                                    <span>Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Amount"
                                                    name="enrollment_amount" id="enrollment_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->enrollment_amount : $enrollment_fee ?>"
                                                    onkeyup="change_registration_amount()" onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Discount Amount"
                                                    name="discount_amount" id="discount_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->discount_amount : '' ?>"
                                                    max="<?=$discount?>"
                                                    onkeyup="change_pending_amount(); get_discount(this.value,'<?=$discount?>','discount_error1')"
                                                    onblur="enable_button()">
                                                    <div style="cursor:pointer;background: green;border-radius: 5px;" onclick="discount_calculate()" class="input-group-addon"><span><span>Discount - Tax</span></div>
                                                </div>
                                                <span style="color:red" id="discount_error1"></span>
                                        </div>
                                    </div>
                                     <?php
                                    if($_GET['type']!='Registration'){
                                    ?>
                                    <div class="col-md-3" id="accepted_by_show1"
                                        <?=$result_fee->discount_reason !='' ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount Reason</span>
                                                </div>
                                                <select name="discount_reason" id="discount_reason"
                                                    class="form-control form-select">
                                                    <option value="">Select Discount Approved By</option>
                                                    
                                                    <option value="Social Media Discount" <?=$result_fee->discount_reason  == 'Social Media Discount' ? 'selected' : ''?>>Social Media Discount</option>
                                                    <option value="Approved in written in Paper" <?=$result_fee->discount_reason  == 'Approved in written in Paper' ? 'selected' : ''?>>Approved in written in Paper</option>
                                                    <option value="Approved in Whatsapp" <?=$result_fee->discount_reason  == 'Approved in Whatsapp' ? 'selected' : ''?>>Approved in Whatsapp</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="accepted_by_show"
                                        <?=$result_fee->accepted_by !='' ? '' : 'style="display:none"'?>>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Discount Approved By</span>
                                                </div>
                                                <select name="accepted_by" id="accepted_by"
                                                    class="form-control form-select">
                                                    <option value="">Select Discount Approved By</option>
                                                    <?php
                                                   $branch = getField('approval_members',$tbl_branch,$result->branch_id);
                                                   $branch = explode(',',$branch);
                                                   foreach($branch as $ress){
                                                    ?>
                                                    <option value="<?=$ress?>"
                                                        <?=$result_fee->accepted_by  == $ress ? 'selected' : ''?>>
                                                        <?=$ress?></option>
                                                    <?php
                                                   }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-house"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Net
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Net Amount"
                                                    name="net_amount" id="net_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->net_amount : $enrollment_fee ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                 } ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>GST </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="GST Amount"
                                                    name="gst_amount" id="gst_amount"
                                                    <?php if($_GET['type'] == 'Registration'){ ?>
                                                    onkeyup="change_registration_amount()"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->gst_amount .'' : '' ?>"
                                                    <?php }else{ ?>onclick="change_pending_amount()"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->gst_amount  : $gst ?>"
                                                    <?php } ?> <?php if($_GET['type']=='Registration'){ ?> readonly<?php } ?> readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Total <?=$_GET['type']=='Registration' ? 'Registration' : ''?>
                                                        Amount</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Total <?=$_GET['type']=='Registration' ? 'Registration' : ''?> Amount"
                                                    name="total_amount" id="total_amount"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->total_amount : $enrollment_fee - $already + $gst ?>"
                                                    onblur="enable_button()" <?php if($_GET['type']=='Registration'){ ?> max="<?=$max_amount?>" onkeyup="change_registration_gst_amount(this.value)" <?php }else{ echo "readonly"; } ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                        <div class=""
                                            style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                            <Span> Payment Mode&nbsp;</Span>
                                        </div>


                                        <div>
                                            <input class="form-check-input checkedbox" type="checkbox" value="Cash"
                                                id="flexCheckChecked_Cash" data-idi='cash'
                                                onchange="show_module('flexCheckChecked_Cash','cash_show','cash')"
                                                <?php if($result_fee->cash != ''){?> checked<?php } ?>>
                                            <label class="form-check-label" for="flexCheckChecked_Cash"
                                                style="margin-top:8px;">
                                                Cash
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input checkedbox" type="checkbox" value="UPI"
                                                id="flexCheckChecked_UPI" data-idi='upi'
                                                onchange="show_module('flexCheckChecked_UPI','upi_show','upi')"
                                                <?php if($result_fee->upi != ''){?> checked<?php } ?>>
                                            <label class="form-check-label" for="flexCheckChecked_UPI"
                                                style="margin-top:8px;">
                                                UPI
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input checkedbox" type="checkbox"
                                                value="Net Banking" id="flexCheckChecked_net" data-idi='bank'
                                                onchange="show_module('flexCheckChecked_net','banking_show','bank')"
                                                <?php if($result_fee->bank != ''){?> checked<?php } ?>>
                                            <label class="form-check-label" for="flexCheckChecked_net"
                                                style="margin-top:8px;">
                                                Net Banking
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input checkedbox" type="checkbox" value="Cheque"
                                                id="flexCheckChecked_Cheque" data-idi='cheque'
                                                onchange="show_module('flexCheckChecked_Cheque','cheque_show','cheque')"
                                                <?php if($result_fee->cheque != ''){?> checked<?php } ?>>
                                            <label class="form-check-label" for="flexCheckChecked_Cheque"
                                                style="margin-top:8px;">
                                                Cheque / DD
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input checkedbox" type="checkbox" value="Swipe"
                                                id="flexCheckChecked_Swipe" data-idi='swipe'
                                                onchange="show_module('flexCheckChecked_Swipe','swipe_show','swipe')"
                                                <?php if($result_fee->swipe != ''){?> checked<?php } ?>>
                                            <label class="form-check-label" for="flexCheckChecked_Swipe"
                                                style="margin-top:8px;">
                                                Swipe
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="cash_show" <?php if($result_fee->cash == ''){?>
                                    style="display:none" <?php } ?>>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-money"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Cash</span>
                                                </div>
                                                <input type="text" class="form-control payment_modes" placeholder="Enter Amount"
                                                    name="cash" id="cash"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->cash : '' ?>"
                                                    onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row" id="upi_show" <?php if($result_fee->upi == ''){?> style="display:none"
                                    <?php } ?>>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Upi</span>
                                                </div>
                                                <input type="text" class="form-control payment_modes" placeholder="Enter Amount"
                                                    name="upi" id="upi"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->upi : '' ?>"
                                                    onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Upi
                                                        Transaction
                                                        ID</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Upi Transaction ID"
                                                    name="upi_tid" id="upi_tid"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->upi_tid : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="banking_show" <?php if($result_fee->bank == ''){?>
                                    style="display:none" <?php } ?>>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Bank
                                                        Transfer</span>
                                                </div>
                                                <input type="text" class="form-control payment_modes" placeholder="Enter Amount"
                                                    name="bank" id="bank"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->bank : '' ?>"
                                                    onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Bank
                                                        Transaction
                                                        ID</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Bank Transaction ID" name="bank_tid" id="bank_tid"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->bank_tid : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row" id="cheque_show" <?php if($result_fee->cheque == ''){?>
                                    style="display:none" <?php } ?>>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Cheque /
                                                        DD</span>
                                                </div>
                                                <input type="text" class="form-control payment_modes" placeholder="Enter Amount"
                                                    name="cheque" id="cheque"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->cheque : '' ?>"
                                                    onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Cheque / DD
                                                        Number</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Cheque / DD Number"
                                                    name="cheque_tid" id="cheque_tid"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->cheque_tid : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="swipe_show" <?php if($result_fee->swipe == ''){?>
                                    style="display:none" <?php } ?>>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Swipe</span>
                                                </div>
                                                <input type="text" class="form-control payment_modes" placeholder="Enter Amount"
                                                    name="swipe" id="swipe"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->swipe : '' ?>"
                                                    onblur="enable_button()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-bank"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Swipe
                                                        Transaction
                                                        ID</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Swipe Transaction ID" name="swipe_tid" id="swipe_tid"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->swipe_tid : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <?php
                                    if($_GET['type'] == 'Enrollment' || $_GET['type'] == 'Direct Enrollment'){
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>After Visa
                                                        Fee Commitment</span>
                                                </div>
                                                <input type="text" class="form-control required" required
                                                    placeholder="After Visa Fee Commitment"
                                                    name="after_visa_fee_commitment" id="after_visa_fee_commitment"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->after_visa_fee_commitment : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Accountant Remarks</span>
                                                </div>
                                                <input type="text" class="form-control"
                                                    placeholder="Accountant Remarks"
                                                    name="accountant_remark" id="accountant_remark"
                                                    value="<?= $result_fee_count > 0 ? $result_fee->accountant_remark : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (strpos($_GET['type'], 'Reapply') !== false) {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "><span><i class="fa-solid fa-GST"
                                                            style="font-size:15px;"></i></span>&nbsp; <span>Allocate Councellor</span>
                                                </div>
                                                <select type="text" class="form-control" name="allocate_counsellor" id="allocate_counsellor" required>
                                                    <option value="">Allocate Councellor</option>
                                                    <?php
                                            $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 and FIND_IN_SET($result->branch_id, branch_id) order by name");
                                            while ($clResult = $obj->fetchNextObject($clSql)) { ?>
                                            <option value="<?php echo $clResult->id; ?>">
                                                <?php echo $clResult->name; ?></option>
                                            <?php }
                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12" style="text-align: center;">
                                        <div class="">
                                            <div style="text-align: center; padding: 10px;">
                                                <p class="text-danger" id="text-error">
                                                    <?php if($total == $result_fee->total_amount && $result_fee_count > 0){ echo ''; }else{ ?>Please
                                                    match total amount with payment<?php } ?></p>
                                                <button type="submit" id="submitbtn" name="btn_visit_fee"
                                                    class="btn mr-10"
                                                    <?php if($total == $result_fee->total_amount && $result_fee_count > 0){ echo ''; }else{ echo 'disabled';} ?>>Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="refresh_table">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Visa Type</th>
                                                <th>Payment Type</th>
                                                <th>Before Visa Amount</th>
                                                <th>After Visa Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?=getField('name',$tbl_country,$res->country_id)?></td>
                                                <td><?=$res->visa_type?></td>
                                                <td><?=getField('visa_sub_type',$tbl_visa_sub_type,$res->visa_sub_type)?>
                                                </td>
                                                <td>
                                                    <p><b>Amount: </b><?=$res->amount?></p>
                                                    <p><b>GST: </b><?=$res->gst?>%</p>
                                                </td>
                                                <td>
                                                    <p><b>Amount: </b><?=$res->after_visa_amount?></p>
                                                    <p><b>GST: </b><?=$res->after_visa_gst?>%</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script type="text/javascript" src="js/jquery.validate.min.js"></script>
            <link rel="stylesheet" href="calender/css/jquery-ui.css">
            <script src="calender/js/jquery-ui.js"></script>
            <script src="js/select2.full.min.js"></script>
            <script>
            // document.getElementById('form-validate').addEventListener('submit', function() {
            //     setTimeout(function() {
            //         window.location.href = 'visit-list.php';
            //     }, 1000);
            // });
            $(document).ready(function() {
                $("#form-validate").validate();
            });
            </script>
            <script>
            $(".select2").select2();
            </script>
            <script>
            function change_pending_amount() {
                var enrollment_amount = parseFloat($("#enrollment_amount").val()) || 0;
                var amount_already_paid = parseFloat($("#amount_already_paid").val()) || 0;
                var discount_amount = parseFloat($("#discount_amount").val()) || 0;
                var gst_amount = parseFloat($("#gst_amount").val()) || 0;

                var pending_enrollment_amount = enrollment_amount - amount_already_paid;
                var net_amount = pending_enrollment_amount - discount_amount;
                var total_amount = net_amount + (net_amount * 18 / 100);

                $("#pending_enrollement_amount").val(pending_enrollment_amount.toFixed(0) + '.00');
                $("#net_amount").val(net_amount.toFixed(0) + '.00');
                $("#total_amount").val(total_amount.toFixed(0) + '.00');
                $("#gst_amount").val((net_amount * 18 / 100).toFixed(0) + '.00');
            }
            </script>
            <script>
            function change_registration_amount() {
                var registration_amount = parseFloat($("#registration_amount").val()) || 0;
                $("#gst_amount").val((registration_amount * 18 / 100).toFixed(0) + '.00');
                var gst_amount = parseFloat($("#gst_amount").val()) || 0;
                // var total_amount = registration_amount + (registration_amount * gst_amount / 100);
                $("#total_amount").val(registration_amount + gst_amount);
            }
            </script>
            <script>
            function enable_button() {
                var total_amount = parseFloat($("#total_amount").val()) || 0;
                var bank = parseFloat($("#bank").val()) || 0;
                var cash = parseFloat($("#cash").val()) || 0;
                var cheque = parseFloat($("#cheque").val()) || 0;
                var upi = parseFloat($("#upi").val()) || 0;
                var swipe = parseFloat($("#swipe").val()) || 0;

                var total_payment = cash + bank + cheque + upi + swipe;

                var checkedValues = $(".change_visa_sub_type:checked").map(function() {
                    return $(this).val();
                }).get();
                if (total_amount === total_payment && checkedValues.length == 1) {
                    $('#submitbtn').prop('disabled', false);
                    $("#text-error").html('');
                } else {
                    var remaining_amount = total_amount - total_payment;
                    if (remaining_amount > 0) {
                        $("#text-error").html('Please add ₹' + remaining_amount.toFixed(0) +
                            ' to match total amount with payment.');
                        $('#submitbtn').prop('disabled', true);
                    } else if (remaining_amount < 0) {
                        var remaining_amount = total_payment - total_amount;
                        $("#text-error").html('Please less ₹' + remaining_amount.toFixed(0) +
                            ' to match total amount with payment.');
                        $('#submitbtn').prop('disabled', true);
                    }
                }
            }
            </script>
            <script>
            function getCheckedDataIds() {
                var checkedBoxes = document.querySelectorAll('.checkedbox:checked');
                var dataIds = [];

                checkedBoxes.forEach(function(box) {
                    dataIds.push(box.getAttribute('data-idi'));
                });

                return dataIds;
            }

            function show_module(id, val, i_id) {
                var isChecked = document.getElementById(id).checked;
                var form = document.getElementById(val);

                if (isChecked === true) {
                    document.getElementById(val).style.display = 'block';

                    var inputs = form.getElementsByTagName("input");
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].classList.add('required');
                        inputs[i].setAttribute('required', 'required');
                    }
                } else {
                    document.getElementById(val).style.display = 'none';

                    var inputs = form.getElementsByTagName("input");
                    for (var i = 0; i < inputs.length; i++) {
                        inputs[i].classList.remove('required');
                        inputs[i].value = "";
                        inputs[i].removeAttribute('required');
                    }
                }
                var checkedCount = $('.checkedbox').filter(function() {
                    return $(this).prop('checked') === true;
                }).length;
                var total_amount = parseFloat($("#total_amount").val()) || 0;
                if (checkedCount == 1) {
                    data_i = getCheckedDataIds()
                    $("#" + data_i).val(total_amount);
                } else if (checkedCount == 2) {
                    val_i = $("#" + data_i).val();
                    if (val_i == total_amount) {
                        $(".payment_modes").val('');
                    }
                } else {
                    $("#" + i_id).val('');
                }
                enable_button();
            }
            </script>
            <script>
            function get_discount(val, max, id) {
                var val = parseFloat(val) || 0;
                var max = parseFloat(max) || 0;
                if (val > max) {
                    $('#' + id).html('Exceeding max discount amount');
                } else {
                    $('#' + id).html('');
                }
                if (val != '' || val != '0') {
                    $("#accepted_by_show").show();
                    $("#accepted_by_show1").show();
                    $("#accepted_by").addClass('required');
                    $("#accepted_by").attr('required', 'required');
                    $("#discount_reason").addClass('required');
                    $("#discount_reason").attr('required', 'required');
                } else {
                    $("#accepted_by_show").hide();
                    $("#accepted_by_show1").hide();
                    $("#accepted_by").val('');
                    $("#accepted_by").removeClass('required');
                    $("#accepted_by").removeAttr('required', 'required');
                    $("#discount_reason").val('');
                    $("#discount_reason").removeClass('required');
                    $("#discount_reason").removeAttr('required', 'required');
                }
            }
            </script>
            <script>
            // function get_visa_sub_type(val) {
            //     $.ajax({
            //         method: "POST",
            //         url: "controller.php",
            //         data: {
            //             get_visa_sub_type: val
            //         },
            //         success: function(data) {
            //             $("#refresh_div1").show();
            //             $("#refresh_all").load(location.href + " #refresh_all");
            //             $("#refresh_table").load(location.href + " #refresh_table > *");
            //         }
            //     })
            // }
            function get_visa_sub_type(val) {
                $.ajax({
                    method: "POST",
                    url: "controller.php",
                    data: {
                        get_visa_sub_type: val
                    },
                    success: function(data) {
                        $("#show_registration_percentage").html('Registration % is > ' + data);
                        $("#refresh_div1").show();
                        $("#refresh_all").load(location.href + " #refresh_all");
                        $("#refresh_table").load(location.href + " #refresh_table > *");
                    }
                })
            }
            </script>
            <script>
            $(document).ready(function() {
                function refreshContent() {
                    $("#refresh_div").load(location.href + " #refresh_div > *", function() {
                        $(".change_visa_sub_type").change(handleVisaTypeChange);
                    });
                    $("#refresh_div2").load(location.href + " #refresh_div2 > *", function() {
                        $(".change_visa_sub_type").change(handleVisaTypeChange);
                    });
                    // location.reload();
                }

                function handleVisaTypeChange() {
                    var checkedValues = $(".change_visa_sub_type:checked").map(function() {
                        return $(this).val();
                    }).get();


                    var visa_type = checkedValues.join(",");
                    fee_id = $("#fee_id").val();
                    $.ajax({
                        method: "post",
                        url: 'controller.php',
                        data: {
                            change_visa_type: visa_type,
                            id: fee_id,
                            type: '<?=$_GET['type']?>',
                            visit_id: '<?=$id?>'
                        },
                        success: function(data) {
                            refreshContent();
                            $('#hide_error').hide();
                            if (checkedValues.length > 1) {
                                $('#show_error').html('Please select only one visa type');
                                $('#submitbtn').prop('disabled', true);
                            } else {
                                $('#show_error').html('');
                                $('#submitbtn').prop('disabled', false);
                            }
                        }
                    });
                }

                $(".change_visa_sub_type").change(handleVisaTypeChange);
            });
            </script>
            <script>
            function change_registration_gst_amount(val) {
                var val = parseFloat(val) || 0;
                total = val * 100 / 118;
                gst = val * 18 / 118;
                $("#registration_amount").val(total.toFixed(0) + '.00');
                $("#gst_amount").val(gst.toFixed(0) + '.00');
            }
            </script>
            <script>
            function discount_calculate() {
                var enrollment_amount = parseFloat($("#enrollment_amount").val()) || 0;
                var amount_already_paid = parseFloat($("#amount_already_paid").val()) || 0;
                var discount_amount = parseFloat($("#discount_amount").val()) || 0;
                pending_amount = (enrollment_amount - amount_already_paid) + ((enrollment_amount -
                    amount_already_paid) * 18 / 100);
                total_amount = pending_amount - discount_amount;
                gst_amount = total_amount * 18 / 118;
                net_amount = total_amount * 100 / 118;
                $("#total_amount").val(total_amount.toFixed(0) + '.00');
                $("#gst_amount").val(gst_amount.toFixed(0) + '.00');
                $("#net_amount").val(net_amount.toFixed(0) + '.00');
                discount_amount = (enrollment_amount - amount_already_paid) - net_amount;
                $("#discount_amount").val(discount_amount.toFixed(0));
            }
            </script>
            <script>
            document.getElementById("profile_status").addEventListener("input", function() {
                let min = parseInt(this.min);
                let max = parseInt(this.max);
                let value = parseInt(this.value);
                let errorMsg = document.getElementById("error_msg");

                if (min == 100 && max == 100) {
                    if (value < min) {
                        errorMsg.textContent = `Value must be  ${min}.`;
                        errorMsg.style.display = "block";
                    } else if (value > max) {
                        errorMsg.textContent = `Value must be  ${max}.`;
                        errorMsg.style.display = "block";
                    } else {
                        errorMsg.style.display = "none";
                    }
                } else {
                    if (value < min) {
                        errorMsg.textContent = `Value must be greater than  ${min}.`;
                        errorMsg.style.display = "block";
                    } else if (value > max) {
                        errorMsg.textContent = `Value must be less than  ${max}.`;
                        errorMsg.style.display = "block";
                    } else {
                        errorMsg.style.display = "none";
                    }
                }
            });
            </script>
            <script>
            document.getElementById("visitfrm").addEventListener("submit", function() {
                document.getElementById("submitbtn").disabled = true;
            });
            </script>
            <script>
                function change_duling(val){
                    if(val == 'Yes'){
                    $(".doulingo_classes").show();
                    $(".doulingo_classes input").addClass('required');
                    $(".doulingo_classes select").addClass('required');
                }else{
                        $(".doulingo_classes").hide();
                        $(".doulingo_classes input").removeClass('required');
                        $(".doulingo_classes select").removeClass('required');
                    }
                }
            </script>
            <script>
                function change_spoken(val){
                    if(val == 'Yes'){
                    $(".spoken_classes").show();
                    $(".spoken_classes input").addClass('required');
                    $(".spoken_classes select").addClass('required');
                }else{
                        $(".spoken_classes").hide();
                        $(".spoken_classes input").removeClass('required');
                        $(".spoken_classes select").removeClass('required');
                    }
                }
            </script>
</body>

</html>
<?php
if(isset($_SESSION['visa_sub_type'])){
    unset($_SESSION['visa_sub_type']);
}
?>