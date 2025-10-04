<?php 
include('include/config.php');
include("include/functions.php");
validate_user();
session_start();
if($_REQUEST['userDetails']=='yes'){
    $sql='';
    $applicant_name=$obj->escapestring($_POST['applicant_name']);
    if($applicant_name!=''){
        $sql .= "applicant_name='$applicant_name'";
    }
    $applicant_contact_no=$obj->escapestring($_POST['applicant_contact_no']);
    if($applicant_contact_no!=''){
        $sql .= ",applicant_contact_no='$applicant_contact_no'";
    }
    $applicant_alternate_no=$obj->escapestring($_POST['applicant_alternate_no']);
    if($applicant_alternate_no!=''){ 
        $sql .= ",applicant_alternate_no='$applicant_alternate_no'";
    }
    $state_id=$obj->escapestring($_POST['state_id']);
    if($state_id!=''){
        $sql .= ",state_id='$state_id'";
    }
    $city_id=$obj->escapestring($_POST['city_id']);
    if($city_id!='' && $city_id!=1000){
        $sql .= ",city_id='$city_id'";
    }
    
    $father_name=$obj->escapestring($_POST['father_name']);
    if($father_name!=''){
        $sql .= ",father_name='$father_name'";
    }
    $lead_type=$obj->escapestring($_POST['lead_type']);
    if($lead_type!=''){
        $sql .= ",lead_type='$lead_type'";
    }
    if(isset($_POST['exam_type']) && count($_POST['exam_type'])> 0){
        $exam_type=implode(',',$_POST['exam_type']);
        if($exam_type!=''){
            $sql .= ",exam_type='$exam_type'";
        }
    }
    if(isset($_POST['exam_sub_type']) && count($_POST['exam_sub_type'])> 0){
        $exam_sub_type=implode(',',$_POST['exam_sub_type']);
        if($exam_sub_type!=''){
            $sql .= ",exam_sub_type='$exam_sub_type'";
        }
    }
    
    $pre_country_id=$obj->escapestring($_POST['pre_country_id']);
    if($pre_country_id!=''){
        $sql .= ",pre_country_id='$pre_country_id'";
    }
    
    $branch_id=$obj->escapestring($_POST['branch_id']);
    if($branch_id!=''){
        $sql .= ",branch_id='$branch_id'";
    }
    // $councellor_id=$obj->escapestring($_POST['councellor_id']);
    // if($councellor_id!=''){
    //     $sql .= ",counsellor_id='$councellor_id'";
    // }
    if(isset($_POST['councellor_id']) && count($_POST['councellor_id'])> 0){
        $councellor_id=implode(',',$_POST['councellor_id']);
        if($councellor_id!=''){
            $sql .= ",counsellor_id='$councellor_id'";
        }
    }
    $recent_qualification=$obj->escapestring($_POST['recent_qualification']);
    if($recent_qualification!=''){
        $sql .= ",recent_qualification='$recent_qualification'";
    }
    
    $board_id=$obj->escapestring($_POST['board_id']);
    if($board_id!='' && $board_id!='other'){
        $sql .= ",board='$board_id'";
    }else{
        $board=$obj->escapestring($_POST['board']);
        if($board!=''){
            $sql .= ",board='$board'";
        }
    }
   //echo $sql; die;

    $stream=$obj->escapestring($_POST['stream']);
    if($stream!='' && $stream!='Other'){
        $sql .= ",stream='$stream'";
    }else{
        $streams=$obj->escapestring($_POST['streams']);
        if($streams!=''){
            $sql .= ",stream='$streams'";
        }
    }

    $start_year=$obj->escapestring($_POST['start_year']);
    if($start_year!=''){
        $sql .= ",start_year='$start_year'";
    }
    $finish_year=$obj->escapestring($_POST['finish_year']);
    if($finish_year!=''){
        $sql .= ",finish_year='$finish_year'";
    }
    $rpercentage=$obj->escapestring($_POST['rpercentage']);
    if($rpercentage!=''){
        $sql .= ",rpercentage='$rpercentage'";
    }
    $backlog=$obj->escapestring($_POST['backlog']);
    if($backlog!=''){
        $sql .= ",backlog='$backlog'";
    }
    $visa_type=$obj->escapestring($_POST['visa_type']);
    if($visa_type!=''){
        $sql .= ",visa_type='$visa_type'";
    }
    
    $inital_start_date=$obj->escapestring($_POST['inital_start_date']);
    if($inital_start_date!=''){
        $inital_start_date = date('Y-m-d',strtotime($inital_start_date));
        $sql .= ",inital_start_date='$inital_start_date'";
    }
    $inital_status=$obj->escapestring($_POST['inital_status']);
    if($inital_status!=''){
        $sql .= ",inital_status='$inital_status'";
    }
    $inital_remarks=$obj->escapestring($_POST['inital_remarks']);
    if($inital_remarks!=''){
        $sql .= ",inital_remarks='$inital_remarks'";
    }

    $inital_next_followup_date=$obj->escapestring($_POST['inital_next_followup_date']);
    if($inital_next_followup_date!=''){
        $inital_next_followup_date = date('Y-m-d',strtotime($inital_next_followup_date));
        $sql .= ",inital_next_followup_date='$inital_next_followup_date'";
    }
    $inital_additional_remarks=$obj->escapestring($_POST['inital_additional_remarks']);
    if($inital_additional_remarks!=''){
        $sql .= ",inital_additional_remarks='$inital_additional_remarks'";
    }

    $followup1_start_date=$obj->escapestring($_POST['followup1_start_date']);
    if($followup1_start_date!=''){
        $followup1_start_date = date('Y-m-d',strtotime($followup1_start_date));
        $sql .= ",followup1_start_date='$followup1_start_date'";
    }
    $followup1_status=$obj->escapestring($_POST['followup1_status']);
    if($followup1_status!=''){
        $sql .= ",followup1_status='$followup1_status'";
    }
    $followup1_remarks=$obj->escapestring($_POST['followup1_remarks']);
    if($followup1_remarks!=''){
        $sql .= ",followup1_remarks='$followup1_remarks'";
    }
    $followup1_next_followup_date=$obj->escapestring($_POST['followup1_next_followup_date']);
    if($followup1_next_followup_date!=''){
        $followup1_next_followup_date = date('Y-m-d',strtotime($followup1_next_followup_date));
        $sql .= ",followup1_next_followup_date='$followup1_next_followup_date'";
    }

    $followup1_additional_remarks=$obj->escapestring($_POST['followup1_additional_remarks']);
    if($followup1_additional_remarks!=''){
        $sql .= ",followup1_additional_remarks='$followup1_additional_remarks'";
    }

    $followup2_start_date=$obj->escapestring($_POST['followup2_start_date']);
    if($followup2_start_date!=''){
        $followup2_start_date = date('Y-m-d',strtotime($followup2_start_date));
        $sql .= ",followup2_start_date='$followup2_start_date'";
    }

    $followup2_status=$obj->escapestring($_POST['followup2_status']);
    if($followup2_status!=''){
        $sql .= ",followup2_status='$followup2_status'";
    }
    $followup2_remarks=$obj->escapestring($_POST['followup2_remarks']);
    if($followup2_remarks!=''){
        $sql .= ",followup2_remarks='$followup2_remarks'";
    }
    $followup2_next_followup_date=$obj->escapestring($_POST['followup2_next_followup_date']);
    if($followup2_next_followup_date!=''){
        $followup2_next_followup_date = date('Y-m-d',strtotime($followup2_next_followup_date));
        $sql .= ",followup2_next_followup_date='$followup2_next_followup_date'";
    }
    $followup2_additional_remarks=$obj->escapestring($_POST['followup2_additional_remarks']);
    if($followup2_additional_remarks!=''){
        $sql .= ",followup2_additional_remarks='$followup2_additional_remarks'";
    }
    $followup3_start_date=$obj->escapestring($_POST['followup3_start_date']);
    if($followup3_start_date!=''){
        $followup3_start_date = date('Y-m-d',strtotime($followup3_start_date));
        $sql .= ",followup3_start_date='$followup3_start_date'";
    }
    $followup3_status=$obj->escapestring($_POST['followup3_status']);
    if($followup3_status!=''){
        $sql .= ",followup3_status='$followup3_status'";
    }
    $followup3_remarks=$obj->escapestring($_POST['followup3_remarks']); 
    if($followup3_remarks!=''){
        $sql .= ",followup3_remarks='$followup3_remarks'";
    }
    $followup3_next_followup_date=$obj->escapestring($_POST['followup3_next_followup_date']);
    if($followup3_next_followup_date!=''){
        $followup3_next_followup_date = date('Y-m-d',strtotime($followup3_next_followup_date));
        $sql .= ",followup3_next_followup_date='$followup3_next_followup_date'";
    }
    $followup3_additional_remarks=$obj->escapestring($_POST['followup3_additional_remarks']);
    if($followup3_additional_remarks!=''){
        $sql .= ",followup3_additional_remarks='$followup3_additional_remarks'";
    }
    $last_followup_start_date=$obj->escapestring($_POST['last_followup_start_date']);
    if($last_followup_start_date!=''){
        $last_followup_start_date = date('Y-m-d',strtotime($last_followup_start_date));
        $sql .= ",last_followup_start_date='$last_followup_start_date'";
    }

    $last_followup_status=$obj->escapestring($_POST['last_followup_status']);
    if($last_followup_status!=''){
        $sql .= ",last_followup_status='$last_followup_status'";
    }
    $last_followup_remarks=$obj->escapestring($_POST['last_followup_remarks']);
    if($last_followup_remarks!=''){
        $sql .= ",last_followup_remarks='$last_followup_remarks'";
    }


    $followup4_start_date=$obj->escapestring($_POST['followup4_start_date']);
    if($followup4_start_date!=''){
        $followup4_start_date = date('Y-m-d',strtotime($followup4_start_date));
        $sql .= ",followup4_start_date='$followup4_start_date'";
    }
    $followup4_status=$obj->escapestring($_POST['followup4_status']);
    if($followup4_status!=''){
        $sql .= ",followup4_status='$followup4_status'";
    }
    $followup4_remarks=$obj->escapestring($_POST['followup4_remarks']);
    if($followup4_remarks!=''){
        $sql .= ",followup4_remarks='$followup4_remarks'";
    }
    $followup4_next_followup_date=$obj->escapestring($_POST['followup4_next_followup_date']);
    if($followup4_next_followup_date!=''){
        $followup4_next_followup_date = date('Y-m-d',strtotime($followup4_next_followup_date));
        $sql .= ",followup4_next_followup_date='$followup4_next_followup_date'";
    }
    $followup4_additional_remarks=$obj->escapestring($_POST['followup4_additional_remarks']);
    if($followup4_additional_remarks!=''){
        $sql .= ",followup4_additional_remarks='$followup4_additional_remarks'";
    }
  
  
    $followup5_start_date=$obj->escapestring($_POST['followup5_start_date']);
    if($followup5_start_date!=''){
        $followup5_start_date = date('Y-m-d',strtotime($followup5_start_date));
        $sql .= ",followup5_start_date='$followup5_start_date'";
    }
    $followup5_status=$obj->escapestring($_POST['followup5_status']);
    if($followup5_status!=''){
        $sql .= ",followup5_status='$followup5_status'";
    }
    $followup5_remarks=$obj->escapestring($_POST['followup5_remarks']);
    if($followup5_remarks!=''){
        $sql .= ",followup5_remarks='$followup5_remarks'";
    }
    $followup5_next_followup_date=$obj->escapestring($_POST['followup5_next_followup_date']);
    if($followup5_next_followup_date!=''){
        $followup5_next_followup_date = date('Y-m-d',strtotime($followup5_next_followup_date));
        $sql .= ",followup5_next_followup_date='$followup5_next_followup_date'";
    }
    $followup5_additional_remarks=$obj->escapestring($_POST['followup5_additional_remarks']);
    if($followup5_additional_remarks!=''){
        $sql .= ",followup5_additional_remarks='$followup5_additional_remarks'";
    }
  
  
    $followup6_start_date=$obj->escapestring($_POST['followup6_start_date']);
    if($followup6_start_date!=''){
        $followup6_start_date = date('Y-m-d',strtotime($followup6_start_date));
        $sql .= ",followup6_start_date='$followup6_start_date'";
    }
    $followup6_status=$obj->escapestring($_POST['followup6_status']);
    if($followup6_status!=''){
        $sql .= ",followup6_status='$followup6_status'";
    }
    $followup6_remarks=$obj->escapestring($_POST['followup6_remarks']);
    if($followup6_remarks!=''){
        $sql .= ",followup6_remarks='$followup6_remarks'";
    }
    $followup6_next_followup_date=$obj->escapestring($_POST['followup6_next_followup_date']);
    if($followup6_next_followup_date!=''){
        $followup6_next_followup_date = date('Y-m-d',strtotime($followup6_next_followup_date));
        $sql .= ",followup6_next_followup_date='$followup6_next_followup_date'";
    }
    $followup6_additional_remarks=$obj->escapestring($_POST['followup6_additional_remarks']);
    if($followup6_additional_remarks!=''){
        $sql .= ",followup6_additional_remarks='$followup6_additional_remarks'";
    }


    $last_followup_next_followup_date=$obj->escapestring($_POST['last_followup_next_followup_date']);
    if($last_followup_next_followup_date!=''){
        $last_followup_next_followup_date = date('Y-m-d',strtotime($last_followup_next_followup_date));
        $sql .= ",last_followup_next_followup_date='$last_followup_next_followup_date'";
    }
    $last_followup_additional_remarks=$obj->escapestring($_POST['last_followup_additional_remarks']);
    if($last_followup_additional_remarks!=''){
        $sql .= ",last_followup_additional_remarks='$last_followup_additional_remarks'";
    }
    $telecaller_id=$obj->escapestring($_POST['crm_executive_id']);
    if($telecaller_id!=''){
        $sql .= ",crm_executive_id='$telecaller_id'";
    }
    $seen_status=$obj->escapestring($_POST['seen_status']);
    if($seen_status!=''){
        $sql .= ",seen_status='$seen_status'";
    }
    
    $url=$obj->escapestring($_POST['url']);
    if($url!=''){
        $sql .= ",url='$url'";
    }
    

   
    
    //echo $sql; die;
    if($_REQUEST['id']==''){

        if($city_id==1000){
            $city_name=$obj->escapestring($_POST['city_name']);
            $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'",-1); //die;
            $city_id = $obj->lastInsertedId();
            $sql .= ",city_id='$city_id'";
        }


        $vN = $obj->query("select lead_no from tbl_lead_enquiry where 1=1 order by id desc");
        $vNum = $obj->numRows($vN);
        if($vNum>0){
            $Vresult = $obj->fetchNextObject($vN);
            $lead_no=$Vresult->lead_no+1;
        }else{
            $lead_no=10000;
        }

        $sql .= ",lead_no='$lead_no'";
    //    echo "insert into $tbl_lead set $sql";die;
        $obj->query("insert into tbl_lead_enquiry set $sql",-1);// die;

        $l_id = $obj->lastInsertedId();
       
    }else{
        if($city_id==1000){
            $city_name=$obj->escapestring($_POST['city_name']);
            $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'");
            $city_id = $obj->lastInsertedId();
            $sql .= ",city_id='$city_id'";
        }
        $obj->query("update tbl_lead_enquiry set $sql where id='".$_REQUEST['id']."'",-1); //die;
        $l_id = $_REQUEST['id'];
    }

    $sess_msg = 'Enquiry Added Successfully....';
    // @header("location:enquiry-addf.php");
}


if($_GET['id']!=''){
    $id = base64_decode(base64_decode(base64_decode($_GET['id'])));
    $sql = $obj->query("select * from tbl_lead_enquiry where id='$id'");
    $result = $obj->fetchNextObject($sql);
}elseif($_REQUEST['enquiry_id']!=''){
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['enquiry_id'])));
    $sql = $obj->query("select * from $tbl_enquiry where id='$id'");
    $result = $obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <style>
    .counsller_visit {
        background: green;
        padding: 9px 12px;
        border-radius: 3px;
        color: white;
        text-transform: uppercase;
        text-align: center !important;
    }

    #err_applicant_alternate_no {
        color: red;
    }

    #err_applicant_contact_no {
        color: red;
    }

    .err_rpercentage {
        color: red;
    }

    .err_finish_year {
        color: red;
    }

    @media (max-width: 992px) {
        .label-required label.error {
            position: absolute !important;
            top: 290px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 0 !important;
        }
    }

    @media (min-width: 992px) {
        .label-required label.error {
            position: absolute !important;
            bottom: -55px !important;
            width: 12pc !important;
            max-width: 145px !important;
            left: 480px !important;
        }
    }

    .lebel-intial-date label.error {
        position: absolute !important;
        bottom: -22px !important;
        width: 12pc !important;
        max-width: 145px !important;
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
                    <?php echo $sess_msg; $sess_msg ='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">
                        <?php
                    if($_REQUEST['id']==''){?>
                        Add Enquiry
                        <?php }else{?>
                        Edit Enquiry
                        <?php }?>
                    </h4>
                    <form method="post" action="" name="leadfrm" id="leadfrm" enctype=multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="seen_status" id="seen_status"
                            value="<?=isset($_GET['lead_appointment']) ? 1 : 0?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Applicant Name
                                                &nbsp;&nbsp;&nbsp; </span></div>
                                        <input type="text" class="required form-control" placeholder="Applicant Name"
                                            name="applicant_name" id="applicant_name"
                                            value="<?php if(isset($_GET['enquiry_id'])) { echo $result->name; }else{ echo stripslashes($result->applicant_name) ; } ?>"
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon  "><span><i class="fa-solid fa-phone-volume"
                                                    style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon space-Alternate space-Alternate">Phone Number
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Phone Number"
                                            name="applicant_contact_no" id="applicant_contact_no"
                                            value="<?php if(isset($_GET['enquiry_id'])) { echo $result->number ; }else{ echo stripslashes($result->applicant_contact_no); } ?>"
                                            <?php if($_REQUEST['id']!='' && $_SESSION['level_id'] != 1){?> readonly
                                            <?php } ?> <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    </div>
                                    <span id="err_applicant_contact_no"></span>
                                </div>
                            </div>


                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><i
                                                class="fa-solid fa-location-crosshairs" style="font-size:15px;"></i>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate"> Branch
                                        </div>

                                        <select class="required form-control select2" name="branch_id" id="branch_id"
                                            onchange="change_counsellor(this.value)">
                                            <option value="">Select IBT Branch</option>
                                            <?php
                                                    $b_con = '';
                                                    if($_SESSION['level_id']!=1){
                                                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                        $b_con = " and id in ($branch_id)";
                                                    }
                                                $csql=$obj->query("select * from $tbl_branch where 1=1 and status=1 $b_con group by name",-1);
                                                while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($cresult->id==$result->branch_id){?>selected<?php } ?>>
                                                <?php echo $cresult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><i class="fa-solid fa-location-crosshairs"
                                                style="font-size:15px;"></i>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate"> Country
                                        </div>

                                        <select class="required form-control" name="pre_country_id" id="pre_country_id">
                                            <option value="">Select Country</option>
                                            <?php
                                                $csql=$obj->query("select * from $tbl_country where 1=1 and status=1 group by name",-1);
                                                while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($cresult->id==$result->pre_country_id){?>selected<?php } ?>>
                                                <?php echo $cresult->name; ?></option>
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
                                        <div class="input-group-addon  space-Alternate space-Alternate"> Visa Type
                                        </div>

                                        <select class="form-control" name="visa_type">
                                            <option value="">Select Visa Type</option>
                                            <option value="Study" <?php if($result->visa_type=='Study'){?> selected
                                                <?php }?>>Study</option>
                                            <option value="Visitior/tourist"
                                                <?php if($result->visa_type=='Visitior/tourist'){?> selected <?php }?>>
                                                Visitor/tourist</option>
                                            <option value="Spouse" <?php if($result->visa_type=='Spouse'){?> selected
                                                <?php }?>>Spouse</option>
                                            <option value="Work" <?php if($result->visa_type=='Work'){?> selected
                                                <?php }?>>Work</option>
                                            <option value="Interview Preparation"
                                                <?php if($result->visa_type=='Interview Preparation'){?> selected
                                                <?php }?>>Interview Preparation</option>
                                            <option value="Filing Only" <?php if($result->visa_type=='Filing Only'){?>
                                                selected <?php }?>>
                                                Filing Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp; <span>Page URL
                                                &nbsp;&nbsp;&nbsp; </span></div>
                                        <input type="text" class="form-control" placeholder="Page URL"
                                            name="url" id="url"
                                            value="<?php if(isset($_GET['id'])) { echo $result->url; }else{ echo ''; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><i class="fa-solid fa-location-crosshairs"
                                                style="font-size:15px;"></i>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate"> CRM Executive
                                        </div>

                                        <select class="required form-control" name="crm_executive_id"
                                            id="crm_executive_id">
                                            <option value="">Select CRM Executive</option>
                                            <?php
                                            $b_whr = '';
                                            if($_SESSION['level_id'] == 9){
                                                $b_whr = " and id='{$_SESSION['sess_admin_id']}'";
                                            }
                                                $csql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and level_id='9' $b_whr group by name",-1);
                                                while($cresult=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cresult->id ?>"
                                                <?php if($cresult->id==$result->crm_executive_id){?>selected<?php } ?>>
                                                <?php echo $cresult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if(isset($_GET['id'])){
                        ?>

                        <div class="row form-group" style="padding:15px; 15px;">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Remark
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon  text-upparcase" style="height: 35px; color: #fff;">
                                        Inital remark</div>
                                </div>
                            </div>


                            <?php
                                   $readonly = '';
                                    $disabled = '';
                                    $readonly1 = 'readonly';
                                    $disabled1 = 'disabled';
                                    $readonly2 = 'readonly';
                                    $disabled2 = 'disabled';
                                    $readonly3 = 'readonly';
                                    $disabled3 = 'disabled';
                                    $readonly4 = 'readonly';
                                    $disabled4 = 'disabled';
                                    $readonly5 = 'readonly';
                                    $disabled5 = 'disabled';
                                    $readonly6 = 'readonly';
                                    $disabled6 = 'disabled';
                                    $readonly7 = 'readonly';
                                    $disabled7 = 'disabled';
                                    $todate = strtotime(date('Y-m-d'));
                                    
                                    if($result->inital_remarks!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = '';
                                        $disabled1 = '';
                                    }

                                    if($result->followup1_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = '';
                                        $disabled2 = '';
                                    }

                                    if($result->followup2_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = 'readonly';
                                        $disabled2 = 'disabled';
                                        $readonly3 = '';
                                        $disabled3 = '';
                                    }

                                    if($result->followup3_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = 'readonly';
                                        $disabled2 = 'disabled';
                                        $readonly3 = 'readonly';
                                        $disabled3 = 'disabled';
                                        $readonly4 = '';
                                        $disabled4 = '';
                                    }

                                    if($result->followup4_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = 'readonly';
                                        $disabled2 = 'disabled';
                                        $readonly3 = 'readonly';
                                        $disabled3 = 'disabled';
                                        $readonly4 = 'readonly';
                                        $disabled4 = 'disabled';
                                        $readonly5 = '';
                                        $disabled5 = '';
                                    }
                                    if($result->followup5_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = 'readonly';
                                        $disabled2 = 'disabled';
                                        $readonly3 = 'readonly';
                                        $disabled3 = 'disabled';
                                        $readonly4 = 'readonly';
                                        $disabled4 = 'disabled';
                                        $readonly5 = 'readonly';
                                        $disabled5 = 'disabled';
                                        $readonly6 = '';
                                        $disabled6 = '';
                                    }
                                    if($result->followup6_status!=0){
                                        $readonly = 'readonly';
                                        $disabled = 'disabled';
                                        $readonly1 = 'readonly';
                                        $disabled1 = 'disabled';
                                        $readonly2 = 'readonly';
                                        $disabled2 = 'disabled';
                                        $readonly3 = 'readonly';
                                        $disabled3 = 'disabled';
                                        $readonly4 = 'readonly';
                                        $disabled4 = 'disabled';
                                        $readonly5 = 'readonly';
                                        $disabled5 = 'disabled';
                                        $readonly6 = 'readonly';
                                        $disabled6 = 'disabled';
                                        $readonly7 = '';
                                        $disabled7 = '';
                                    }
                                    ?>



                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="inital_start_date" id="inital_start_date"
                                            value="<?php if($result->inital_start_date!=null){ echo $result->inital_start_date; }else{ echo date('Y-m-d'); }  ?>"
                                            placeholder="Date" class="required form-control change_required"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group lebel-intial-date">
                                    <div class="input-group" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="inital_status" id="inital_status" <?php echo $disabled; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->inital_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">

                                        <select class="required form-control select2 change_required"
                                            name="inital_remarks" id="inital_remarks" <?php echo $disabled; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->inital_status!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->inital_status."'",-1); //die();
                                                $cstatusArr = array();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->inital_remarks){?> selected <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="inital_next_followup_date" <?php if($readonly==''){?>
                                            id="inital_next_followup_date" <?php }?> placeholder="Next Follow up Date"
                                            class="required form-control change-date change_required"
                                            value="<?php if($result->inital_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->inital_next_followup_date)); }else{ if($readonly==''){ echo date('Y-m-d', strtotime(' + 2 days'));} } ?>"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text"
                                            class="form-control change_required <?=$readonly == '' ? 'required' : ''?>"
                                            placeholder="ENTER REMARK" name="inital_additional_remarks"
                                            id="inital_additional_remarks"
                                            value="<?php echo stripslashes($result->inital_additional_remarks); ?>"
                                            <?php echo $readonly; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 1</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup1_start_date)){
                                        if(!empty($result->inital_start_date)){
                                            $followup1_start_date =  date('Y-m-d'); 
                                        }                                                     
                                    }else{
                                        $followup1_start_date =  $result->followup1_start_date; 
           
                                    }
                                    ?>

                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup1_start_date" <?php if($readonly1==''){?>
                                            id="followup1_start_date" <?php }?>
                                            value="<?php echo $followup1_start_date ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly1; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup1_status" id="followup1_status" <?php echo $disabled1; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup1_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup1_remarks" id="followup1_remarks" <?php echo $disabled1; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup1_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup1_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup1_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup1_next_followup_date"
                                            <?php if($readonly1==''){?> id="followup1_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date"
                                            class="form-control change-date change_required <?php if($readonly1==''){?> required <?php }?>"
                                            value="<?php if($result->followup1_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup1_next_followup_date)); }else{ if($readonly1==''){ echo date('Y-m-d', strtotime(' + 2 days'));} } ?>"
                                            <?php echo $readonly1; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup1_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control change_required"
                                            placeholder="ENTER REMARK" name="followup1_additional_remarks"
                                            id="followup1_additional_remarks"
                                            value="<?php echo stripslashes($result->followup1_additional_remarks); ?>"
                                            <?php echo $readonly1; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 2</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <?php  
                                    if(empty($result->followup2_start_date)){
                                        if(!empty($result->followup1_start_date)){
                                            $followup2_start_date =  date('Y-m-d'); 
                                        }             
                                    }else{
                                        $followup2_start_date =  $result->followup2_start_date; 
           
                                    }
                                    ?>
                                        <input type="text" name="followup2_start_date" <?php if($readonly2==''){?>
                                            id="followup2_start_date" <?php }?>
                                            value="<?php echo $followup2_start_date; ?>" placeholder="Date"
                                            class="form-control change_required" <?php echo $readonly2; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup2_status" id="followup2_status" <?php echo $disabled2; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup2_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                        if($_REQUEST['id']!='' && $result->followup2_status!=0 && $disabled2!=''){?>
                                        <input type="hidden" name="followup2_status"
                                            value="<?php echo $result->followup2_status ?>">
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup2_remarks" id="followup2_remarks" <?php echo $disabled2; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup2_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup2_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup2_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup2_next_followup_date"
                                            <?php if($readonly2==''){?> id="followup2_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date"
                                            class="form-control change-date  change_required <?php if($readonly2==''){?> required <?php }?>"
                                            value="<?php if($result->followup2_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup2_next_followup_date)); }else{  if($readonly2==''){ echo date('Y-m-d', strtotime(' + 2 days'));} }  ?>"
                                            <?php echo $readonly2; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup2_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ENTER REMARK"
                                            name="followup2_additional_remarks" id="followup2_additional_remarks"
                                            value="<?php echo stripslashes($result->followup2_additional_remarks); ?>"
                                            <?php echo $readonly2; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Follow up 3</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup3_start_date)){
                                        if(!empty($result->followup2_start_date)){
                                            $followup3_start_date =  date('Y-m-d');
                                        }              
                                    }else{
                                        $followup3_start_date =  $result->followup3_start_date; 
           
                                    }
                                    ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup3_start_date" <?php if($readonly3==''){?>
                                            id="followup3_start_date" <?php }?>
                                            value="<?php echo $followup3_start_date; ?>" placeholder="Date"
                                            class="form-control change_required" <?php echo $readonly3; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup3_status" id="followup3_status" <?php echo $disabled3; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup3_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="required form-control select2 change_required"
                                            name="followup3_remarks" id="followup3_remarks" <?php echo $disabled3; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup3_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup3_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup3_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup3_next_followup_date"
                                            <?php if($readonly3==''){?> id="followup3_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date"
                                            class="form-control change-date change_required <?php if($readonly3==''){?> required <?php }?>"
                                            value="<?php if($result->followup3_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup3_next_followup_date)); }else{ if($readonly3==''){ echo date('Y-m-d', strtotime(' + 2 days')); } } ?>"
                                            <?php echo $readonly3; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup3_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup3_additional_remarks" id="followup3_additional_remarks"
                                            value="<?php echo stripslashes($result->followup3_additional_remarks); ?>"
                                            <?php echo $readonly3; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon" style="height: 35px; color: #fff;">
                                        Follow up 4</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup4_start_date)){
                                        if(!empty($result->followup3_start_date)){
                                            $followup4_start_date =  date('Y-m-d');
                                        }              
                                    }else{
                                        $followup4_start_date =  $result->followup4_start_date; 
           
                                    }
                                    ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup4_start_date" <?php if($readonly4==''){?>
                                            id="followup4_start_date" <?php }?>
                                            value="<?php echo $followup4_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup4_status" id="followup4_status"
                                            onchange="change_remark(this.value,'followup4_remarks');get_demo(this.value)"
                                            <?php echo $disabled4; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup4_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup4_remarks" id="followup4_remarks" <?php echo $disabled4; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup4_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup4_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup4_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup4_next_followup_date"
                                            <?php if($readonly4==''){?> id="followup4_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup4_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup4_next_followup_date)); }else{ if($readonly4==''){ echo date('Y-m-d', strtotime(' + 2 days'));} }  ?>"
                                            <?php echo $readonly4; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup4_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup4_additional_remarks" id="followup4_additional_remarks"
                                            value="<?php echo stripslashes($result->followup4_additional_remarks); ?>"
                                            <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon" style="height: 35px; color: #fff;">
                                        Follow up 5</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup5_start_date)){
                                        if(!empty($result->followup5_start_date)){
                                            $followup5_start_date =  date('Y-m-d');
                                        }              
                                    }else{
                                        $followup5_start_date =  $result->followup5_start_date; 
                                    }
                                    ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup5_start_date" <?php if($readonly5==''){?>
                                            id="followup5_start_date" <?php }?>
                                            value="<?php echo $followup5_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly5; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup5_status" id="followup5_status"
                                            onchange="change_remark(this.value,'followup5_remarks');get_demo(this.value)"
                                            <?php echo $disabled5; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup5_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup5_remarks" id="followup5_remarks" <?php echo $disabled5; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup5_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup5_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup5_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup5_next_followup_date"
                                            <?php if($readonly5==''){?> id="followup5_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup5_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup5_next_followup_date)); }else{ if($readonly5==''){ echo date('Y-m-d', strtotime(' + 2 days'));} }  ?>"
                                            <?php echo $readonly5; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup5_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup5_additional_remarks" id="followup5_additional_remarks"
                                            value="<?php echo stripslashes($result->followup5_additional_remarks); ?>"
                                            <?php echo $readonly5; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon" style="height: 35px; color: #fff;">
                                        Follow up 6</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                    if(empty($result->followup6_start_date)){
                                        if(!empty($result->followup5_start_date)){
                                            $followup6_start_date =  date('Y-m-d');
                                        }              
                                    }else{
                                        $followup6_start_date =  $result->followup6_start_date; 
           
                                    }
                                    ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup6_start_date" <?php if($readonly6==''){?>
                                            id="followup6_start_date" <?php }?>
                                            value="<?php echo $followup6_start_date; ?>" placeholder="Date"
                                            class="form-control" <?php echo $readonly6; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup6_status" id="followup6_status"
                                            onchange="change_remark(this.value,'followup6_remarks');get_demo(this.value)"
                                            <?php echo $disabled6; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup6_status){?> selected
                                                <?php } ?>>
                                                <?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <select
                                            class="<?=$_SESSION['level_id'] == '1' || in_array(1,$addtional_role) ? '' : 'required'?> form-control select2"
                                            name="followup6_remarks" id="followup6_remarks" <?php echo $disabled6; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup6_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->followup6_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup6_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="followup6_next_followup_date"
                                            <?php if($readonly6==''){?> id="followup6_next_followup_date" <?php }?>
                                            placeholder="Next Follow up Date" class="form-control"
                                            value="<?php if($result->followup6_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup6_next_followup_date)); }else{ if($readonly6==''){ echo date('Y-m-d', strtotime(' + 2 days'));} }  ?>"
                                            <?php echo $readonly6; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 2 days'))?>','followup6_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="followup6_additional_remarks" id="followup6_additional_remarks"
                                            value="<?php echo stripslashes($result->followup6_additional_remarks); ?>"
                                            <?php echo $readonly6; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon " style="height: 35px; color: #fff;">
                                        Last Follow up</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php  
                                        if(empty($result->last_followup_start_date)){
                                            if(!empty($result->followup6_start_date)){
                                                $last_followup_start_date =  date('Y-m-d');              
                                            }
                                        }else{
                                            $last_followup_start_date =  $result->last_followup_start_date; 
               
                                        }
                                        ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="last_followup_start_date" id="last_followup_start_date"
                                            value="<?php echo $last_followup_start_date; ?>" placeholder="Date"
                                            class="form-control change_required" <?php echo $readonly7; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="form-control select2 change_required" name="last_followup_status"
                                            id="last_followup_status" <?php echo $disabled7; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from tbl_enquiry_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->last_followup_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="form-control select2 change_required"
                                            name="last_followup_remarks" id="last_followup_remarks"
                                            <?php echo $disabled7; ?>>
                                            <option value="">Remarks </option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->last_followup_remarks!=0){
                                                $sSql = $obj->query("select * from tbl_enquiry_remarks_status where status=1 and stage_id='".$result->last_followup_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->last_followup_remarks){?> selected
                                                <?php } ?>>
                                                <?php echo $sResult->remarks; ?></option>
                                            <?php }                                            
                                                
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="last_followup_next_followup_date"
                                            <?php if($readonly7==''){?> id="last_followup_next_followup_date" <?php }?>
                                            placeholder="Last Follow up Date"
                                            class="form-control change-date  change_required <?php if($readonly7==''){?> required <?php }?>"
                                            value="<?php if($result->last_followup_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->last_followup_next_followup_date)); } ?>"
                                            <?php echo $readonly7; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ENTER REMARK"
                                            name="last_followup_additional_remarks"
                                            id="last_followup_additional_remarks"
                                            value="<?php echo stripslashes($result->last_followup_additional_remarks); ?>"
                                            <?php echo $readonly7; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="add_stdnt_btn">

                            <button type="button" onclick="check_validation()" id="submitbtn"
                                class="btn mr-10">Submit</button>
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
            <script src="js/select2.full.min.js"></script>
            <script>

            </script>
            <script>
            $(document).ready(function() {
                $("#exam_types").select2({
                    placeholder: "Select Exam Type",
                    allowClear: true
                });
                $("#exam_sub_types").select2({
                    placeholder: "Select Exam Sub Type",
                    allowClear: true
                });
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
            $(document).ready(function() {
                $(".select2").change(function() {
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
            $('.select2').select2({
                allowClear: false
            });

            const targetDiv = document.getElementById("third");
            const btn = document.getElementById("toggle");
            btn.onclick = function() {
                if (targetDiv.style.display !== "none") {
                    $(".counsller_visit").html("View Details");
                    targetDiv.style.display = "none";
                } else {
                    targetDiv.style.display = "block";
                    $(".counsller_visit").html("Hide Details");
                }
            };
            </script>


            <script>
            $(document).ready(function() {

                $("#leadfrm").validate();

                $("#finish_year").change(function() {
                    fyear = $(this).val()
                    syear = $("#start_year").val();
                    if (fyear <= syear) {
                        $(".err_finish_year").show();
                        $(".err_finish_year").html("Finish year cannot be greater than start year.");
                        $("#start_year").focus();
                        $("#submitbtn").attr('disabled', 'disabled');
                    } else {
                        $("#submitbtn").removeAttr('disabled', 'disabled');
                        $(".err_finish_year").hide();
                    }
                })


                $("#inital_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(), tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#inital_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#inital_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#inital_next_followup_date").datepicker({
                    minDate: 1,
                });





                $("#followup1_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(), tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup1_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup1_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup1_next_followup_date").datepicker({
                    minDate: 1
                });


                $("#followup2_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(), tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup2_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup2_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup2_next_followup_date").datepicker({
                    minDate: 1
                });


                $("#followup3_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(), tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup3_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup3_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup3_next_followup_date").datepicker({
                    minDate: 1
                });


                $("#followup4_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(),
                            tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup3_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup3_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup4_next_followup_date").datepicker({
                    minDate: '<?=date('m/d/Y', strtotime($result->followup2_next_followup_date . ' +1 day'))?>'
                });


                $("#followup5_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(),
                            tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup3_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup3_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup5_next_followup_date").datepicker({
                    minDate: '<?=date('m/d/Y', strtotime($result->followup2_next_followup_date . ' +1 day'))?>'
                });

                $("#followup6_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(),
                            tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#followup3_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#followup3_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#followup6_next_followup_date").datepicker({
                    minDate: '<?=date('m/d/Y', strtotime($result->followup2_next_followup_date . ' +1 day'))?>'
                });

                $("#last_followup_start_date").datepicker({
                    minDate: 0,
                    onSelect: function(selected) {
                        console.log(selected);
                        var date = $(this).datepicker('getDate');
                        var tempStartDate = new Date(date);
                        var default_end = new Date(tempStartDate.getFullYear(), tempStartDate
                            .getMonth(), tempStartDate.getDate() + 1
                        ); //this parses date to overcome new year date weirdness
                        $("#last_followup_next_followup_date").datepicker("option", "minDate",
                            default_end);
                        $('#last_followup_next_followup_date').datepicker('setDate',
                            default_end); // Set as default
                    }
                });

                $("#last_followup_next_followup_date").datepicker({
                    minDate: 1
                });



                $("#recent_qualification").change(function() {
                    id = $(this).val();
                    if (id == 1) {
                        $(".streamcls").hide();
                        $(".mystreamcls1").show();
                        $(".mystreamcls2").hide();


                        $(".streamcls").hide();
                        $(".streamcls1").hide();
                        $(".streamcls2").show();
                        $("#board").attr("placeholder", "Board");

                    } else if (id == 2 || id == 3 || id == 4 || id == 5) {
                        $(".streamcls").show();


                        if (id == 2) {
                            $(".streamcls").show();
                            $(".streamcls1").hide();
                            $(".streamcls2").show();

                            $("#board").attr("placeholder", "Board");

                            $(".mystreamcls1").hide();
                            $(".mystreamcls2").show();

                        } else {
                            $(".streamcls1").show();
                            $(".streamcls2").hide();
                            $("#board").attr("placeholder", "University/Institute Name");
                            $(".mystreamcls1").show();
                            $(".mystreamcls2").hide();
                        }

                    }
                })

                $("#streams").change(function() {
                    strms = $(this).val();

                    if (strms == 'Other') {
                        $(".mystreamcls1").show();
                    }
                })

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

                $("#city_id").change(function() {
                    var id = this.value;
                    if (id == 1000) {
                        $("#city_name").show();
                        $("#city_name").addClass("required");
                    } else {
                        $("#city_name").hide();
                        $("#city_name").removeClass("required")
                    }
                });

                $("#inital_status").change(function() {
                    var id = $(this).val();

                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#inital_remarks").html(response);
                        }
                    });

                    if (id == 4) {
                        $("#inital_next_followup_date").removeClass("required");
                    } else {
                        $("#inital_next_followup_date").addClass("required");
                    }
                })

                $("#followup1_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup1_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#followup1_next_followup_date").removeClass("required");
                    } else {
                        $("#followup1_next_followup_date").addClass("required");
                    }
                })


                $("#followup2_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup2_remarks").html(response);
                        }
                    });

                    if (id == 4) {
                        $("#followup2_next_followup_date").removeClass("required");
                    } else {
                        $("#followup2_next_followup_date").addClass("required");
                    }
                })
                $("#followup3_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup3_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#followup3_next_followup_date").removeClass("required");
                    } else {
                        $("#followup3_next_followup_date").addClass("required");
                    }
                })
                $("#followup4_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup4_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#followup4_next_followup_date").removeClass("required");
                    } else {
                        $("#followup4_next_followup_date").addClass("required");
                    }
                })
                $("#followup5_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup5_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#followup5_next_followup_date").removeClass("required");
                    } else {
                        $("#followup5_next_followup_date").addClass("required");
                    }
                })
                $("#followup6_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#followup6_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#followup6_next_followup_date").removeClass("required");
                    } else {
                        $("#followup6_next_followup_date").addClass("required");
                    }
                })
                $("#last_followup_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getEnquiryRemarks'
                        },
                        beforeSend: function() {},
                        success: function(response) {
                            $("#last_followup_remarks").html(response);
                        }
                    });
                    if (id == 4) {
                        $("#last_followup_next_followup_date").removeClass("required");
                    } else {
                        $("#last_followup_next_followup_date").addClass("required");
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
                            <?php
                            if(isset($_GET['id'])){
                                ?>
                            id: '<?=base64_decode(base64_decode(base64_decode($_REQUEST['id'])))?>',
                            <?php
                            }
                            ?>
                            type: 'checkLeadContactNumber'
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
            })
            </script>
            <script>
            function change_matriculation(val) {
                var check = document.getElementById('flexCheckCheckeds');
                if (check.checked == true) {
                    $("#recent_qualification").removeClass('required');
                    document.getElementById('get_history').style.display = 'flex';
                } else {
                    $("#get_history").hide();
                    $('#show_country').hide();
                    $("#recent_qualification").addClass('required');
                    document.getElementById('visa_earlier1').checked = false;
                    document.getElementById('visa_earlier2').checked = false;
                    $("#visa_earlier1").val('');
                    $("#visa_earlier2").val('');
                    $("#country1").val('');
                    $("#country2").val('');
                }
            }

            $("#visa_earlier1, #visa_earlier2").change(function() {

                if ($("#visa_earlier1").is(":checked") == true) {
                    $('#show_country').show();
                }

                if ($("#visa_earlier2").is(":checked") == true) {
                    $('#show_country').hide();
                    $("#country1").val('');
                    $("#country2").val('');
                }
            });
            </script>
            <script>
            $("#exam_name").change(function() {
                examval = $(this).val();
                if (examval == 'IELTS') {
                    $("#overall_bond").attr("placeholder", "Overall Bands");
                    $("#scorelabel").html("Overall Bands");
                } else {
                    $("#overall_bond").attr("placeholder", "Overall Score");
                    $("#scorelabel").html("Overall Score");
                }
            });
            var addButtonns = $('.add_lang_field_button');
            var wrapperrs = $('#langDetails_add');
            <?php
                if($ldNum > 0){?>
            var p = <?php echo $ld-1; ?>;
            <?php }else{?>
            var p = 0;
            <?php }?>
            maxField = 10;
            $(addButtonns).click(function() {
                if (p < maxField) {
                    p++;
                    $(wrapperrs).append(
                        '<div class="add" style="position:relative"><div class="row"><div class="col-md-3"><div class="form-group"><div class="input-group"><div class="input-group-addon "> Exam name </div><select class="form-control" name="langDetails[' +
                        p +
                        '][exam_name]" id="exam_name' + p +
                        '"><option value="">Select Exam Name</option><option value="IELTS">IELTS</option><option value="PTE">PTE</option><option value="TOEFL">TOEFL</option><option value="Duolingo">Duolingo</option></select></div></div></div>' +
                        '<div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon " id="scorelabel' +
                        p +
                        '">Overall Bonds</div><input type="text" class="form-control" placeholder="Overall Bonds" name="langDetails[' +
                        p + '][overall_bond]" id="overall_bond' + p + '" value=""></div></div></div>' +
                        '<div class="col-md-3"><div class="form-group"><div class="input-group" style="width:100%;"><div class="input-group-addon ">Exam Date</div><input type="date" class="form-control" name="langDetails[' +
                        p +
                        '][exam_date]" id="exam_date" value=""></div></div></div><a href="#" class="remove_field removelangcls delete_btn">X</a></div></div>'
                    );
                }
                $("#exam_name" + p).change(function() {
                    examval = $(this).val();
                    if (examval == 'IELTS') {
                        $("#overall_bond" + p).attr("placeholder", "Overall Bands");
                        $("#scorelabel" + p).html("Overall Bands");
                    } else {
                        $("#overall_bond" + p).attr("placeholder", "Overall Score");
                        $("#scorelabel" + p).html("Overall Score");
                    }
                });
            });
            $(wrapperrs).on('click', '.remove_field', function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            });
            </script>
            <script>
            function change_validation_remark(val, date, id) {
                if (val == date) {
                    $("#" + id).removeClass('required');
                } else {
                    $("#" + id).addClass('required');
                }
            }
            </script>
            <script>
            function same_primary() {
                $("#applicant_alternate_no").val($("#applicant_contact_no").val());
            }
            </script>
            <script>
            function change_required() {
                $(".change_required").removeClass('required')
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
                        <?php
                            if(isset($_GET['id'])){
                                ?>
                        id: '<?=base64_decode(base64_decode(base64_decode($_REQUEST['id'])))?>',
                        <?php
                            }
                            ?>
                        check_lead_validation: 1
                    },
                    success: function(data) {
                        if (data == 1) {
                            alert('Please enter another mobile number');
                        } else {
                            $("#leadfrm").submit();
                        }
                    }
                });
            }
            </script>
            <script>
            function chagne_exam_sub_type(id) {
                var selectedIds = $("#exam_types").val();
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        chagne_exam_sub_type: selectedIds
                    },
                    success: function(data) {
                        $("#exam_sub_types").html(data);
                    }
                })
            }
            </script>
            <script>
            function change_counsellor(id) {
                $.ajax({
                    type: "post",
                    url: "controller.php",
                    data: {
                        'change_counsellor_id': id
                    },
                    success: function(data) {
                        $("#councellor_id").html(data);
                    }
                });
            }
            </script>
            <script>
            function change_remark(val, id) {
                $.ajax({
                    type: "GET",
                    url: 'ajax/getModalData.php',
                    data: {
                        id: val,
                        type: 'getEnquiryRemarks'
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        $("#" + id).html(response);
                    }
                });
            }
            </script>
</body>

</html>