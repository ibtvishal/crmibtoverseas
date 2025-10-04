<?php 
include('include/config.php');
include("include/functions.php");
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_REQUEST['userDetails']=='yes'){
    $sql='';
  
    $applicant_name=$obj->escapestring($_POST['applicant_name']);
    if($applicant_name!=''){
        $sql .= "applicant_name='$applicant_name'";
    }
    $management_datetime=$obj->escapestring($_POST['management_datetime']);
    if($management_datetime!=''){
        $sql .= ",management_datetime='$management_datetime'";
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
 
    $visa_type_c = count($_POST['visa_type']);
    if($visa_type_c != '' && $visa_type_c > 0){
        $visa_type=implode(',',$_POST['visa_type']);
        $sql .= ",visa_type='$visa_type'";
    }
    
    $father_name=$obj->escapestring($_POST['father_name']);
    if($father_name!=''){
        $sql .= ",father_name='$father_name'";
    }
    $country_id=$obj->escapestring($_POST['country_id']);
    if($country_id!=''){
        $sql .= ",country_id='$country_id'";
    }
    $lead_type=$obj->escapestring($_POST['lead_type']);
    if($lead_type!=''){
        $sql .= ",lead_type='$lead_type'";
    }
    $service_type=$obj->escapestring($_POST['service_type']);
    if($service_type!=''){
        $sql .= ",service_type='$service_type'";
    }
    $pre_country_id=$obj->escapestring($_POST['pre_country_id']);
    if($pre_country_id!=''){
        $sql .= ",pre_country_id='$pre_country_id'";
    }

    $branch_id=$obj->escapestring($_POST['branch_id']);
    if($branch_id!=''){
        $sql .= ",branch_id='$branch_id'";
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
    $source=$obj->escapestring($_POST['source']);
    if($source!=''){
        $sql .= ",source='$source'";
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
    $last_followup_next_followup_date=$obj->escapestring($_POST['last_followup_next_followup_date']);
    if($last_followup_next_followup_date!=''){
        $last_followup_next_followup_date = date('Y-m-d',strtotime($last_followup_next_followup_date));
        $sql .= ",last_followup_next_followup_date='$last_followup_next_followup_date'";
    }
    $last_followup_additional_remarks=$obj->escapestring($_POST['last_followup_additional_remarks']);
    if($last_followup_additional_remarks!=''){
        $sql .= ",last_followup_additional_remarks='$last_followup_additional_remarks'";
    }
    
    $support_inital_start_date=$obj->escapestring($_POST['support_inital_start_date']);
    $support_inital_additional_remarks=$obj->escapestring($_POST['support_inital_additional_remarks']);
    $support_followup1_additional_remarks=$obj->escapestring($_POST['support_followup1_additional_remarks']);
    $support_followup2_additional_remarks=$obj->escapestring($_POST['support_followup2_additional_remarks']);
    $support_followup3_additional_remarks=$obj->escapestring($_POST['support_followup3_additional_remarks']);
    $support_last_followup_additional_remarks=$obj->escapestring($_POST['support_last_followup_additional_remarks']);
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_inital_additional_remarks!=''){
        $sql .= ",support_inital_start_date='$support_inital_start_date'";
    }
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_inital_additional_remarks!=''){
        $sql .= ",support_inital_additional_remarks='$support_inital_additional_remarks'";
    }
    $support_followup1_start_date=$obj->escapestring($_POST['support_followup1_start_date']);
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup1_additional_remarks!=''){
        $sql .= ",support_followup1_start_date='$support_followup1_start_date'";
    }
    $support_followup2_start_date=$obj->escapestring($_POST['support_followup2_start_date']);
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup2_additional_remarks!=''){
        $sql .= ",support_followup2_start_date='$support_followup2_start_date'";
    }
    $support_followup3_start_date=$obj->escapestring($_POST['support_followup3_start_date']);
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup3_additional_remarks!=''){
        $sql .= ",support_followup3_start_date='$support_followup3_start_date'";
    }
    $support_last_followup_start_date=$obj->escapestring($_POST['support_last_followup_start_date']);
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_last_followup_additional_remarks!=''){
        $sql .= ",support_last_followup_start_date='$support_last_followup_start_date'";
    }
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup1_additional_remarks!=''){
        $sql .= ",support_followup1_additional_remarks='$support_followup1_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup2_additional_remarks!=''){
        $sql .= ",support_followup2_additional_remarks='$support_followup2_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_followup3_additional_remarks!=''){
        $sql .= ",support_followup3_additional_remarks='$support_followup3_additional_remarks'";
    }
    if(($_SESSION['level_id'] == 1 || in_array(4,$addtional_role)) && $support_last_followup_additional_remarks!=''){
        $sql .= ",support_last_followup_additional_remarks='$support_last_followup_additional_remarks'";
    }
    $telecaller_id=$obj->escapestring($_POST['telecaller_id']);
    if($telecaller_id!=''){
        $sql .= ",crm_executive_id='$telecaller_id'";
    }
    $seen_status=$obj->escapestring($_POST['seen_status']);
    if($seen_status!=''){
        $sql .= ",seen_status='$seen_status'";
    }
    
    $visa_earlier=$obj->escapestring($_POST['visa_earlier']);
    if($visa_earlier!=''){
        $sql .= ",visa_earlier='$visa_earlier'";
    }else{
        $sql .= ",visa_earlier='0'";
    }
    
    $country1=$obj->escapestring($_POST['country1']);
    if($country1!=''){
        $sql .= ",country1='$country1'";
    }else{
        $sql .= ",country1=''";
    }
    
    $country2=$obj->escapestring($_POST['country2']);
    if($country2!=''){
        $sql .= ",country2='$country2'";
    }else{
        $sql .= ",country2=''";
    }
    
   
    
    //echo $sql; die;
    if($_REQUEST['id']==''){

        if($city_id==1000){
            $city_name=$obj->escapestring($_POST['city_name']);
            $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'",-1); //die;
            $city_id = $obj->lastInsertedId();
            $sql .= ",city_id='$city_id'";
        }


        $vN = $obj->query("select lead_no from $tbl_lead where 1=1 order by id desc");
        $vNum = $obj->numRows($vN);
        if($vNum>0){
            $Vresult = $obj->fetchNextObject($vN);
            $lead_no=$Vresult->lead_no+1;
        }else{
            $lead_no=10000;
        }

        $sql .= ",lead_no='$lead_no'";
       
        $obj->query("insert into $tbl_lead set $sql",-1);// die;

        $l_id = $obj->lastInsertedId();
       
    }else{
        if($city_id==1000){
            $city_name=$obj->escapestring($_POST['city_name']);
            $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'");
            $city_id = $obj->lastInsertedId();
            $sql .= ",city_id='$city_id'";
        }
        $obj->query("update $tbl_lead set $sql where id='".$_REQUEST['id']."'",-1); //die;
        $l_id = $_REQUEST['id'];
    }
    $langDetailsResult = $_POST['langDetails'];
    if ($langDetailsResult!='') {
        if(count($langDetailsResult)>0){
            $sql="delete from $tbl_lead_language_details where lead_id='".$l_id."'"; 
            $obj->query($sql);
            foreach($langDetailsResult as $val){
                $sqls = '';
                if($val['exam_name']!=''){
                    $sqls .= " , exam_name='".$val['exam_name']."'";
                }

                if($val['overall_bond']!=''){
                    $sqls .= ", overall_bond='".$val['overall_bond']."'";
                }

                if($val['exam_date']!=''){
                    $sqls .= " ,exam_date='".$val['exam_date']."'";
                }
                $obj->query("insert into $tbl_lead_language_details set lead_id='$l_id' $sqls",-1); //die;
            }
        }
    }
    @header("location:lead-list.php");
}


if($_REQUEST['id']!=''){
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $sql = $obj->query("select * from $tbl_lead where id='$id'");
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

    .support_manager_div {
        background: red !important;
        background: #edf1f5 !important;
        color: black !important;
        border: none !important;
    }

    .line-dotted {
        border-top: 1.5px solid #4b4b4d;
        margin-bottom: 20px;
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
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">
                        <?php
                    if($_REQUEST['id']==''){?>
                        Add Lead
                        <?php }else{?>
                        Edit Lead
                        <?php }?>
                    </h4>
                    <form method="post" action="" name="leadfrm" id="leadfrm" enctype=multipart/form-data meaning>
                        <input type="hidden" name="userDetails" id="userDetails" value="yes">
                        <input type="hidden" name="seen_status" id="seen_status"
                            value="<?=isset($_GET['lead_appointment']) ? 1 : 0?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                        <div class="row">
                            <?php
                            if($_REQUEST['id']){?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> </div>
                                        <div class="input-group-addon inputlable">Applicant ID</div>
                                        <input type="text" class="required form-control" placeholder="Applicant ID"
                                            name="applicant_id" id="applicant_id"
                                            value="<?php echo stripslashes($result->lead_no); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> </div>
                                        <div class="input-group-addon inputlable">Enquiery Date</div>
                                        <input type="date" class="required form-control" name="cdate" id="cdate"
                                            value="<?php echo date('Y-m-d',strtotime($result->cdate)); ?>"
                                            <?=$_SESSION['level_id']!=1 ? 'readonly' : '' ?>>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span> &nbsp;
                                            <span>Telecaller&nbsp;&nbsp;&nbsp; </span>
                                        </div>
                                        <select name="telecaller_id" id="telecaller_id" class="required form-control" <?=$_SESSION['level_id'] != '1' && isset($_GET['id']) ? 'disabled' : ''?>>
                                            <?php 
                                        if($_SESSION['level_id']==1 || in_array(4,$addtional_role)){?>
                                            <option value="">Select Telecaller</option>
                                            <?php }?>
                                            <?php 
                                            $selected='';
                                            if($_SESSION['level_id']==1 || in_array(4,$addtional_role)){
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=9 order by name");
                                            }else{
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and id='".$_SESSION['sess_admin_id']."'");
                                                
                                            }                        
                                          
                                          while($clResult = $obj->fetchNextObject($clSql)){
                                            if($_SESSION['level_id']==1 || in_array(4,$addtional_role)){
                                               if($result->crm_executive_id==$clResult->id){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                } 
                                            }else{
                                                if($_SESSION['sess_admin_id']==$clResult->id){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $clResult->id; ?>" <?php echo $selected; ?>>
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon  "><span><i
                                                    class="fa-solid fa-phone-volume" style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon  space-Alternate space-Alternate">Phone Number
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Phone Number"
                                            name="applicant_contact_no" id="applicant_contact_no"
                                            value="<?php if(isset($_GET['enquiry_id'])) { echo $result->number ; }else{ echo stripslashes($result->applicant_contact_no); } ?>"
                                            maxlength="10"
                                            <?php if($_REQUEST['id']!='' && $_SESSION['level_id'] != 1){?> readonly
                                            <?php } ?> <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    </div>
                                    <span id="err_applicant_contact_no"></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-tty"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Alternate
                                                Number</span></div>
                                        <input type="text" class="required form-control"
                                            placeholder="Alternate Phone Number" name="applicant_alternate_no"
                                            id="applicant_alternate_no"
                                            value="<?php echo stripslashes($result->applicant_alternate_no); ?>"
                                            maxlength="10"
                                            <?php if($_REQUEST['id']!='' && $_SESSION['level_id'] != 1){?> readonly
                                            <?php } ?> <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                    </div>
                                    <span id="err_applicant_alternate_no"></span>
                                    <input type="checkbox" id="same_as_primary_number">
                                    <label for="same_as_primary_number" class="text-primary">Same as Primary
                                        Number</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-user"
                                                    style="font-size:15px;"></i></span>&nbsp; <span>Father Name</span>
                                        </div>
                                        <input type="text" class="required form-control" placeholder="Father Name"
                                            name="father_name" id="father_name"
                                            value="<?php echo isset($_GET['id']) ? stripslashes($result->father_name) : 'N/A' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon  "><span><i
                                                    class="fa-solid fa-location-dot" style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon  space-state"> Country</div>
                                        <select class="required form-control" name="country_id" id="country_id"
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                            <option value="">Select Country</option>
                                            <option value="1" <?=$result->country_id == '1' || !isset($_GET['id']) ? 'selected' : ''?>>India
                                            </option>
                                            <option value="2" <?=$result->country_id == '2' ? 'selected' : ''?>>UK
                                            </option>
                                            <option value="3" <?=$result->country_id == '3' ? 'selected' : ''?>>Canada
                                            </option>
                                            <option value="4" <?=$result->country_id == '4' ? 'selected' : ''?>>UAE
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon  "><span><i
                                                    class="fa-solid fa-location-dot" style="font-size:15px;"></i></span>
                                        </div>
                                        <div class="input-group-addon  space-state"> State</div>
                                        <select class="required form-control" name="state_id" id="state_id"
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                            <option value="">Select State</option>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_location_states where 1=1 and  country_id ='".$result->country_id."' and status=1 order by name",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($result->state_id==$line->id){?> selected <?php } ?>>
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
                                                    style="font-size:15px;"></i></span> </div>

                                        <div class="input-group-addon space-city">District</div>
                                        <select class="required form-control" name="city_id" id="city_id"
                                            <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                            <option value="">Select District</option>
                                            <?php
                                            $i=1;
                                            $citysql=$obj->query("select * from $tbl_location_cities where 1=1 and status=1 and state_id ='".$result->state_id."' order by name",$debug=-1);
                                            while($cityline=$obj->fetchNextObject($citysql)){?>
                                            <option value="<?php echo $cityline->id ?>"
                                                <?php if($result->city_id==$cityline->id){?> selected <?php } ?>>
                                                <?php echo $cityline->name ?></option>
                                            <?php } ?>
                                            <!-- <option value="1000">Other</option> -->
                                        </select>
                                    </div>
                                    <input type="text" name="city_name" id="city_name" value="" class="form-control"
                                        placeholder="Add Your City Here" style="display:none;">
                                </div>
                            </div>


                            <?php
                            if($_REQUEST['id']){?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <div class="form-group">
                                    <div style="text-align: center; padding: 10px;">
                                        <a href="javascript:void(0);" class="counsller_visit" id="toggle" style="">View
                                            Details </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="third" style="display:none;">
                            <div class="row">
                                <?php }?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "> <span><i
                                                        class="fa-solid fa-globe" style="font-size:15px;"></i></span>
                                                <span id="change_country">Preferred <?=$result->pre_country_id == 7 ? 'Area' : 'Country'?></span>
                                            </div>
                                            <select class="required form-control" name="pre_country_id"
                                                id="pre_country_id" onchange="change_country(this.value)"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">Select Preferred <?=$result->pre_country_id == 7 ? 'Area' : 'Country'?></option>
                                                <?php
                                            $ctsql=$obj->query("select * from $tbl_country where status=1 order by displayorder",-1);
                                            while($ctresult=$obj->fetchNextObject($csql)){?>
                                                <option value="<?php echo $ctresult->id ?>"
                                                    <?php if($ctresult->id==$result->pre_country_id || $result->country == $ctresult->name){?>selected<?php } ?>>
                                                    <?php echo $ctresult->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group" style="display:flex; gap:10px; flex-wrap:wrap;">
                                            <div class=" inputlableivisa"
                                                style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                                <span><i class="fa-solid fa-plane-departure"
                                                        style="font-size:15px;"></i></span> <Span
                                                    class="space-Alternate"
                                                    style="font-size: 12px; margin: 0 0 0 10px;"> Visa type</Span>
                                            </div>
                                            <div>
                                                <?php
                                            $visaArr = array();
                                            $visaArr = explode(',',$result->visa_type);
                                            ?>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    value="Study" id="visa_type_study"
                                                    <?php if(in_array('Study',$visaArr)){?> checked <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="visa_type_study" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Study
                                                </label>
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    onchange="change_matriculation(this.value)" value="Visitior/tourist"
                                                    id="flexCheckCheckeds"
                                                    <?php if(in_array('Visitior/tourist',$visaArr)){?> checked
                                                    <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="flexCheckCheckeds" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Visitor/tourist
                                                </label>
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    value="Spouse" id="visa_type_spouse"
                                                    <?php if(in_array('Spouse',$visaArr)){?> checked <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="visa_type_spouse" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Spouse
                                                </label>
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    value="Work" id="visa_type_work"
                                                    <?php if(in_array('Work',$visaArr)){?> checked <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="visa_type_work" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Work
                                                </label>
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    value="Interview Preparation" id="visa_type_Interview"
                                                    <?php if(in_array('Interview Preparation',$visaArr)){?> checked
                                                    <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="visa_type_Interview" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Interview Preparation
                                                </label>
                                            </div>
                                            <div>
                                                <input class="form-check-input" type="checkbox" name="visa_type[]"
                                                    value="Filing Only" id="visa_type_filing"
                                                    <?php if(in_array('Filing Only',$visaArr)){?> checked <?php } ?>
                                                    <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                &nbsp;
                                                <label for="visa_type_filing" class="form-check-label"
                                                    style="margin-top:8px;">
                                                    Filing Only
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4 form-group" id="get_history"
                                    <?=$result->visa_earlier==1 || $result->visa_earlier==2 ? 'style="display:flex;gap:10px;"' : 'style="display:none;gap:10px;"'?>>
                                    <div class=""
                                        style="background:#4b4b4d; color:white; padding:5px; border-radius: 5px 0 0 5px;">
                                        <span><i class="fa-solid fa-message" style="font-size:15px;"></i></span> <Span
                                            style="font-size:11px;">Any Previous Travel/Visa History</Span>
                                    </div>
                                    <input name="visa_earlier" class="form-check-input" type="radio" value="1"
                                        id="visa_earlier1" <?php if($result->visa_earlier==1){?> checked <?php }?>>
                                    &nbsp;
                                    <label class="form-check-label" style="margin-top:8px;">
                                        Yes
                                    </label>

                                    <input name="visa_earlier" class="form-check-input" type="radio" value="2"
                                        id="visa_earlier2" <?php if($result->visa_earlier==2){?> checked <?php }?>>
                                    &nbsp;
                                    <label class="form-check-label" style="margin-top:8px;">
                                        No
                                    </label>
                                </div>
                            </div>
                            <!--     <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon "><span><i class="fa-solid fa-house" style="font-size:15px;"></i></span> </div>
                                        <input type="text" class="form-control" placeholder="Address" name="address" id="address" value="<?php echo $result->address; ?>">
                                    </div>
                                </div>
                            </div>
                        </div> -->

                            <div class="row" id="show_country"
                                <?=$result->visa_earlier==1 ? '' : 'style="display:none"'?>>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "> <span><i
                                                        class="fa-solid fa-globe" style="font-size:15px;"></i></span>
                                                <span>Country 1</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Country 1"
                                                name="country1" id="country1" value="<?php echo $result->country1; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "> <span><i
                                                        class="fa-solid fa-globe" style="font-size:15px;"></i></span>
                                                <span>Country 2</span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Country 2"
                                                name="country2" id="country2" value="<?php echo $result->country2; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row " style="margin-top:10px;">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "><i
                                                    class="fa-solid fa-location-crosshairs" style="font-size:15px;"></i>
                                            </div>
                                            <div class="input-group-addon  space-Alternate space-Alternate"> Branch
                                            </div>

                                            <select class="required form-control" name="branch_id" id="branch_id">
                                                <option value="">Select IBT Branch</option>
                                                <?php
                                                    $b_con = '';
                                                    if($_SESSION['level_id']!==19){
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "><i
                                                    class="fa-solid fa-location-crosshairs" style="font-size:15px;"></i>
                                            </div>
                                            <div class="input-group-addon  space-Alternate space-Alternate">Lead Type
                                            </div>

                                            <select class="form-control" name="lead_type" id="lead_type">
                                                <option value="">Select Lead Type</option>
                                                <option value="Call"
                                                    <?php if('Call'==$result->lead_type){?>selected<?php } ?>>Call
                                                </option>
                                                <option value="Chat"
                                                    <?php if('Chat'==$result->lead_type){?>selected<?php } ?>>Chat
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "><i
                                                    class="fa-solid fa-location-crosshairs" style="font-size:15px;"></i>
                                            </div>
                                            <div class="input-group-addon  space-Alternate space-Alternate">Service Type
                                            </div>

                                            <select class="form-control required" name="service_type" id="service_type">
                                                <option value="">Select Service Type</option>
                                                <option value="Offline"
                                                    <?php if('Offline'==$result->service_type || !isset($_GET['id'])){?>selected<?php } ?>>
                                                    Offline
                                                </option>
                                                <option value="Online"
                                                    <?php if('Online'==$result->service_type){?>selected<?php } ?>>
                                                    Online
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="padding:0 15px;">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white;  border-radius:5px;">Recent
                                        Qualifiaction</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon "> <span><i
                                                        class="fa-solid fa-graduation-cap"
                                                        style="font-size:15px;"></i></span> </div>
                                            <select
                                                class="<?php if(!in_array('Visitior/tourist',$visaArr)){?>required <?php } ?> form-control"
                                                name="recent_qualification" id="recent_qualification"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">Select Recent Qualification</option>
                                                <option value="1" <?php if($result->recent_qualification==1){?> selected
                                                    <?php } ?>>Matriculation</option>
                                                <option value="2" <?php if($result->recent_qualification==2){?> selected
                                                    <?php } ?>>Senior Secondary</option>
                                                <option value="3" <?php if($result->recent_qualification==3){?> selected
                                                    <?php } ?>>Any Diploma</option>
                                                <option value="4" <?php if($result->recent_qualification==4){?> selected
                                                    <?php } ?>>Bachelor</option>
                                                <option value="5" <?php if($result->recent_qualification==5){?> selected
                                                    <?php } ?>>Masters</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select name="board_id" id="board_id" class="form-control streamcls2"
                                                <?php if($result->recent_qualification==1 || $result->recent_qualification==2){?>
                                                style="display: block;" <?php }else{?> style="display: none;" <?php } ?>
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">Select Board</option>
                                                <option value="PSEB" <?php if($result->board=='PSEB') {?> selected
                                                    <?php }?>>Punjab School Education Board (PSEB)</option>
                                                <option value="CBSE" <?php if($result->board=='CBSE') {?> selected
                                                    <?php }?>>Central Board of Secondary Education (CBSE)</option>
                                                <option value="ICSE" <?php if($result->board=='ICSE') {?> selected
                                                    <?php }?>>Indian Certificate of Secondary Education (ICSE)</option>
                                                <option value="BSEH" <?php if($result->board=='BSEH') {?> selected
                                                    <?php }?>>Board Of School Education Haryana (BSEH)</option>
                                                <option value="other"
                                                    <?php if($_REQUEST['id']!=''){ if($result->board!='PSEB' && $result->board!='CBSE' && $result->board!='ICSE' && $result->board!='BSEH') {?>
                                                    selected <?php } }?>>Other</option>
                                            </select>

                                            <input type="text" class="form-control streamcls1" placeholder="Board"
                                                name="board" id="board" value="<?php echo $result->board; ?>"
                                                <?php if($result->board!='PSEB' && $result->board!='CBSE' && $result->board!='ICSE' && $result->board!='BSEH'){?>
                                                style="display: block;" <?php }else {?> style="display: none;"
                                                <?php }?>>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 streamcls" <?php echo $style; ?>>
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select name="stream" id="streams" class="form-control mystreamcls2"
                                                <?php if($result->recent_qualification==2){?> style="display: block;"
                                                <?php }else{?> style="display: none;" <?php } ?>
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">Select Stream</option>
                                                <option value="Medical" <?php if($result->stream=='Medical'){?> selected
                                                    <?php } ?>>Medical</option>
                                                <option value="Non-Medical" <?php if($result->stream=='Non-Medical'){?>
                                                    selected <?php } ?>>Non-Medical</option>
                                                <option value="Super Medical"
                                                    <?php if($result->stream=='Super Medical'){?> selected <?php } ?>>
                                                    Super Medical</option>
                                                <option value="Commerce" <?php if($result->stream=='Commerce'){?>
                                                    selected <?php } ?>>Commerce</option>
                                                <option value="Humanities" <?php if($result->stream=='Humanities'){?>
                                                    selected <?php } ?>>Humanities</option>
                                                <option value="Arts" <?php if($result->stream=='Arts'){?> selected
                                                    <?php } ?>>Arts</option>
                                                <option value="Other"
                                                    <?php if($_REQUEST['id']!=''){ if($result->stream!='Medical' && $result->stream!='Non-Medical' && $result->stream!='Super Medical' && $result->stream!='Commerce' && $result->stream!='Humanities'){?>
                                                    selected <?php }} ?>>Other</option>
                                            </select>

                                            <input type="text" class="form-control mystreamcls1" placeholder="Stream"
                                                name="streams" id="stream"
                                                value="<?php echo stripslashes($result->stream); ?>"
                                                <?php if($result->stream!='Medical' && $result->stream!='Non-Medical' && $result->stream!='Super Medical' && $result->stream!='Commerce' && $result->stream!='Humanities'){?>
                                                style="display: block;" <?php }else {?> style="display: none;" <?php }?>
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="start_year" id="start_year"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">START YEAR</option>
                                                <?php
                                            for($i=date('Y'); $i >=date('Y')-80; $i--){?>
                                                <option value="<?php echo $i; ?>" <?php if($result->start_year==$i){?>
                                                    selected <?php } ?>><?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <select class="form-control" name="finish_year" id="finish_year"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                                <option value="">FINISH YEAR</option>
                                                <?php
                                            for($i=date('Y'); $i >=date('Y')-80; $i--){?>
                                                <option value="<?php echo $i; ?>" <?php if($result->finish_year==$i){?>
                                                    selected <?php } ?>><?php echo $i; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <span class="err_finish_year"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="PERCENTAGE"
                                                name="rpercentage" id="rpercentage"
                                                value="<?php echo stripslashes($result->rpercentage); ?>"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                        </div>
                                        <span class="err_rpercentage"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <input type="text" class="form-control" placeholder="ANY BACKLOG"
                                                name="backlog" id="backlog"
                                                value="<?php echo stripslashes($result->backlog); ?>"
                                                <?=isset($_GET['id']) ? 'onchange="change_required()"' : ''?>>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row form-group" style="padding:0 15px;">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white;  border-radius:5px;">
                                        Language Proficiency Details <span style="float:right;cursor:pointer"
                                            class="add_lang_field_button">Add More</span></h6>
                                </div>
                            </div>
                            <div id="langDetails_add">
                                <?php
                                 $ldsql = $obj->query("select * from $tbl_lead_language_details where lead_id='$id'",-1); //die;
                                 $ldNum = $obj->numRows($ldsql);
                                if($ldNum > 0){
                                    $ld=0;
                                    while($ldResult = $obj->fetchNextObject($ldsql)){
                                        ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "> Exam name </div>
                                                <select class="form-control" name="langDetails[<?=$ld?>][exam_name]"
                                                    id="exam_name<?=$ld?>">
                                                    <option value="">Select Exam Name</option>
                                                    <option value="IELTS" <?php if($ldResult->exam_name=='IELTS'){?>
                                                        selected <?php } ?>>IELTS</option>
                                                    <option value="PTE" <?php if($ldResult->exam_name=='PTE'){?>
                                                        selected <?php } ?>>PTE</option>
                                                    <option value="TOEFL" <?php if($ldResult->exam_name=='TOEFL'){?>
                                                        selected <?php } ?>>TOEFL</option>
                                                    <option value="Duolingo"
                                                        <?php if($ldResult->exam_name=='Duolingo'){?> selected
                                                        <?php } ?>>Duolingo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon " id="scorelabel<?=$ld?>">
                                                    Overall Bonds</div>
                                                <input type="text" class="form-control" placeholder="Overall Bonds"
                                                    name="langDetails[<?=$ld?>][overall_bond]" id="overall_bond<?=$ld?>"
                                                    value="<?php echo $ldResult->overall_bond; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon ">Exam Date</div>
                                                <input type="date" class="form-control"
                                                    name="langDetails[<?=$ld?>][exam_date]" id="exam_date"
                                                    value="<?php echo $ldResult->exam_date; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <a href="#" class="remove_field removelangcls delete_btn">X</a> -->
                                </div>
                                <script type="text/javascript">
                                $("#exam_name<?php echo $ld; ?>").change(function() {
                                    examval = $(this).val();
                                    if (examval == 'IELTS') {
                                        $("#overall_bond<?php echo $ld; ?>").attr("placeholder",
                                            "Overall Bands");
                                        $("#scorelabel<?php echo $ld; ?>").html("Overall Bands");
                                    } else {
                                        $("#overall_bond<?php echo $ld; ?>").attr("placeholder",
                                            "Overall Score");
                                        $("#scorelabel<?php echo $ld; ?>").html("Overall Score");
                                    }
                                })
                                </script>
                                <?php
                                 $ld++;    } 
                                }else{
                                ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon "> Exam name </div>
                                                <select class="form-control" name="langDetails[0][exam_name]"
                                                    id="exam_name">
                                                    <option value="">Select Exam Name</option>
                                                    <option value="IELTS" <?php if($result->exam_name=='IELTS'){?>
                                                        selected <?php } ?>>IELTS</option>
                                                    <option value="PTE" <?php if($result->exam_name=='PTE'){?> selected
                                                        <?php } ?>>PTE</option>
                                                    <option value="TOEFL" <?php if($result->exam_name=='TOEFL'){?>
                                                        selected <?php } ?>>TOEFL</option>
                                                    <option value="Duolingo" <?php if($result->exam_name=='Duolingo'){?>
                                                        selected <?php } ?>>Duolingo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon " id="scorelabel">Overall
                                                    Bonds</div>
                                                <input type="text" class="form-control" placeholder="Overall Bonds"
                                                    name="langDetails[0][overall_bond]" id="overall_bond"
                                                    value="<?php echo $result->overall_bond; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group" style="width:100%;">
                                                <div class="input-group-addon ">Exam Date</div>
                                                <input type="date" class="form-control" name="langDetails[0][exam_date]"
                                                    id="exam_date" value="<?php echo $result->exam_date; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row form-group" style="padding:0 15px;">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white;  border-radius:5px;">Source
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 label-required">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_youtube" class="required form-check-input" name="source"
                                            type="radio" value="Youtube" <?php if($result->source=='Youtube'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label for="source_youtube" class="form-check-label" style="margin-top:4px;">
                                            Youtube
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_facebook" class="required form-check-input" name="source"
                                            type="radio" value="Facebook" <?php if($result->source=='Facebook'){?>
                                            checked <?php } ?>> &nbsp;
                                        <label for="source_facebook" class="form-check-label" style="margin-top:4px;">
                                            Facebook
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Instagram" id="source_instagram"
                                            <?php if($result->source=='Instagram'){?> checked <?php } ?>> &nbsp;
                                        <label for="source_instagram" class="form-check-label" style="margin-top:4px;">
                                            Instagram
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Google" id="source_google" <?php if($result->source=='Google'){?>
                                            checked <?php } ?>>
                                        &nbsp;
                                        <label for="source_google" class="form-check-label" style="margin-top:4px;">
                                            Google
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_website" class="required form-check-input" name="source"
                                            type="radio" value="Website" <?php if($result->source=='Website'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label for="source_website" class="form-check-label" style="margin-top:4px;">
                                            Website
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_handing" class="required form-check-input" name="source"
                                            type="radio" value="Hoarding/Banner"
                                            <?php if($result->source=='Hoarding/Banner'){?> checked <?php } ?>> &nbsp;
                                        <label for="source_handing" class="form-check-label" style="margin-top:4px;">
                                            Hoarding/Banner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_freinds" class="required form-check-input" name="source"
                                            type="radio" value="Friends" <?php if($result->source=='Friends'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label for="source_freinds" class="form-check-label" style="margin-top:4px;">
                                            Friends
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_paper" class="required form-check-input" name="source"
                                            type="radio" value="Paper Ad" <?php if($result->source=='Paper Ad'){?>
                                            checked <?php } ?>> &nbsp;
                                        <label for="source_paper" class="form-check-label" style="margin-top:4px;">
                                            Newspaper Advertisement
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input id="source_seminar" class="required form-check-input" name="source"
                                            type="radio" value="Seminar" <?php if($result->source=='Seminar'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label for="source_seminar" class="form-check-label" style="margin-top:4px;">
                                            Seminar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="display: flex; align-items: center;">
                                        <input class="required form-check-input" name="source" type="radio"
                                            value="Relatives" <?php if($result->source=='Relatives'){?> checked
                                            <?php } ?>>
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
                                            value="Telecalling"
                                            <?php if($result->source=='Telecalling'){?> checked
                                            <?php } ?>>
                                        &nbsp;
                                        <label class="form-check-label" for="flexCheckChecked" style="margin-top:4px;">
                                        Telecalling
                                        </label>
                                    </div>
                                </div>
                                <?php
                                if(isset($_GET['id'])){
                                ?>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="source_other" class="required form-check-input" name="source"
                                                type="radio" value="Other" <?php if($result->source=='Other'){?> checked
                                                <?php } ?>>
                                            &nbsp;
                                            <label for="source_other" class="form-check-label" style="margin-top:8px;">
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="row form-group" style="padding:15px; 15px;">
                                <div>
                                    <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Expected
                                        Visit Date</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group" style="width:100%;">
                                            <div class="input-group-addon ">Expected Visit Date</div>
                                            <input type="datetime-local" class="form-control"
                                                name="management_datetime" id="management_datetime"
                                                value="<?php echo $result->management_datetime; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                    if($_REQUEST['id']){?>
                        </div>
                        <?php }?>
                        <div class="row form-group" style="padding:15px; 15px;">
                            <div>
                                <h6 style="background:#4b4b4d;padding:5px; color:white; border-radius:5px;">Remark</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon  text-upparcase"
                                        style="height: 35px; color: #fff;">Initial remark</div>
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
                                $todate = strtotime(date('Y-m-d'));
                                
                                if($result->inital_remarks!=0){
                                    $readonly = 'readonly';
                                    $disabled = 'disabled';
                                    $readonly1 = '';
                                    $disabled1 = '';
                                }
                                if($result->followup1_remarks!=0){
                                    $readonly = 'readonly';
                                    $disabled = 'disabled';
                                    $readonly1 = 'readonly';
                                    $disabled1 = 'disabled';
                                    $readonly2 = '';
                                    $disabled2 = '';
                                }
                                if($result->followup2_remarks!=0){
                                    $readonly = 'readonly';
                                    $disabled = 'disabled';
                                    $readonly1 = 'readonly';
                                    $disabled1 = 'disabled';
                                    $readonly2 = 'readonly';
                                    $disabled2 = 'disabled';
                                    $readonly3 = '';
                                    $disabled3 = '';
                                }
                                if($result->followup3_remarks!=0){
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
                                if($result->inital_status==4){
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
                                }else if($result->followup1_status==4){
                                    $readonly = 'readonly';
                                    $disabled = 'disabled';
                                    $readonly1 = '';
                                    $disabled1 = '';
                                    $readonly2 = 'readonly';
                                    $disabled2 = 'disabled';
                                    $readonly3 = 'readonly';
                                    $disabled3 = 'disabled';
                                    $readonly4 = 'readonly';
                                    $disabled4 = 'disabled';
                                }else if($result->followup2_status==4){
                                }else if($result->followup3_status==4){
                                }else if($result->last_followup_status==4){

                                }
                        ?>



                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="inital_start_date" id="inital_start_date"
                                            value="<?php if($_REQUEST['id']){ echo $result->inital_start_date; }else{ echo date('Y-m-d'); }  ?>"
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
                                            $statussql=$obj->query("select * from $tbl_lead_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->inital_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
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
                                                $sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='".$result->inital_status."'",-1); //die();
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
                                            class="form-control change_required <?=$_SESSION['level_id'] == 9 && $readonly == '' ? 'required' : ''?>"
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
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Lead Review Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_inital_start_date"
                                            <?php if($result->support_inital_additional_remarks == ''){ ?>
                                            id="support_inital_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_inital_additional_remarks!=''){ echo date('Y-m-d',strtotime($result->support_inital_start_date)); }else{ if($readonlys == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_inital_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_inital_additional_remarks"
                                            id="support_inital_additional_remarks"
                                            value="<?php echo stripslashes($result->support_inital_additional_remarks); ?>"
                                            <?php echo $result->support_inital_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line-dotted"></div>

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
                                            class="form-control" <?php if($_SESSION['level_id'] == 9){ echo $readonly1; } ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup1_status" id="followup1_status" <?php echo $disabled1; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_lead_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup1_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup1_remarks" id="followup1_remarks" <?php echo $disabled1; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup1_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='".$result->followup1_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup1_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
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
                                            class="form-control change-date change_required <?php if($_SESSION['level_id'] == 9 && $readonly1==''){?> required <?php }?>"
                                            value="<?php if($result->followup1_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup1_next_followup_date)); }else{ if($readonly1==''){ echo date('Y-m-d', strtotime(' + 4 days'));} } ?>"
                                            <?php echo $readonly1; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 4 days'))?>','followup1_additional_remarks')">
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
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Lead Review Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup1_start_date"
                                            <?php if($result->support_followup1_additional_remarks == ''){ ?>
                                            id="support_followup1_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup1_start_date!=''){ echo date('Y-m-d',strtotime($result->support_followup1_start_date)); }else{ if($result->support_followup1_additional_remarks == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup1_additional_remarks !='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup1_additional_remarks"
                                            id="support_followup1_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup1_additional_remarks); ?>"
                                            <?php echo $result->support_followup1_additional_remarks !='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line-dotted"></div>

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
                                    if(empty($result->followup2_status) && $result->followup2_status == 0){
                                            $followup2_start_date =  date('Y-m-d'); 
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
                                        <select class="<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup2_status" id="followup2_status" <?php echo $disabled2; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_lead_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup2_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
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
                                        <select class="<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup2_remarks" id="followup2_remarks" <?php echo $disabled2; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup2_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='".$result->followup2_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup2_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
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
                                            class="form-control change-date  change_required <?php if($_SESSION['level_id'] == 9 && $readonly2==''){?> required <?php }?>"
                                            value="<?php if($result->followup2_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup2_next_followup_date)); }else{  if($readonly2==''){ echo date('Y-m-d', strtotime(' + 5 days'));} }  ?>"
                                            <?php echo $readonly2; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 5 days'))?>','followup2_additional_remarks')">
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
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Lead Review Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup2_start_date"
                                            <?php if($result->support_followup2_additional_remarks == ''){ ?>
                                            id="support_followup2_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup2_start_date!=''){ echo date('Y-m-d',strtotime($result->support_followup2_start_date)); }else{ if($result->support_followup2_additional_remarks == ''){ echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup2_additional_remarks != '' ? 'readonly' : '' ; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup2_additional_remarks"
                                            id="support_followup2_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup2_additional_remarks); ?>"
                                            <?php echo $result->support_followup2_additional_remarks != '' ? 'readonly' : '' ; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line-dotted"></div>

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
                                    if(empty($result->followup3_status) && $result->followup3_status==0){
                                            $followup3_start_date =  date('Y-m-d');
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
                                        <select class="<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup3_status" id="followup3_status" <?php echo $disabled3; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_lead_status where 1=1 and status=1 group by name order by displayorder asc",-1);
                                            while($statusResult=$obj->fetchNextObject($statussql)){?>
                                            <option value="<?php echo $statusResult->id ?>"
                                                <?php if($statusResult->id==$result->followup3_status){?> selected
                                                <?php } ?>><?php echo $statusResult->name; ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="\<?=$_SESSION['level_id'] == 9 ? 'required' : ''?> form-control select2 change_required"
                                            name="followup3_remarks" id="followup3_remarks" <?php echo $disabled3; ?>>
                                            <option value="">Remarks</option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->followup3_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='".$result->followup3_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->followup3_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
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
                                            class="form-control change-date change_required <?php if($_SESSION['level_id'] == 9 && $readonly3==''){?> required <?php }?>"
                                            value="<?php if($result->followup3_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->followup3_next_followup_date)); }else{ if($readonly3==''){ echo date('Y-m-d', strtotime(' + 6 days')); } } ?>"
                                            <?php echo $readonly3; ?>
                                            onchange="change_validation_remark(this.value,'<?=date('Y-m-d', strtotime(' + 6 days'))?>','followup3_additional_remarks')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="ENTER REMARK"
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
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Lead Review Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_followup3_start_date"
                                            <?php if($result->support_followup3_additional_remarks == ''){ ?>
                                            id="support_followup3_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_followup3_additional_remarks!=''){ echo date('Y-m-d',strtotime($result->support_followup3_start_date)); }else{ if($result->support_followup3_additional_remarks == ''){  echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_followup3_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_followup3_additional_remarks"
                                            id="support_followup3_additional_remarks"
                                            value="<?php echo stripslashes($result->support_followup3_additional_remarks); ?>"
                                            <?php echo $result->support_followup3_additional_remarks != '' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="line-dotted"></div>

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
                                            if(!empty($result->followup3_start_date)){
                                                $last_followup_start_date =  date('Y-m-d');              
                                            }
                                        }else{
                                            $last_followup_start_date =  $result->last_followup_start_date; 
               
                                        }
                                        ?>
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" name="last_followup_start_date" id="last_followup_start_date"
                                            value="<?php echo $last_followup_start_date; ?>" placeholder="Date"
                                            class="form-control change_required" <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group lebel-intial-date" style="width:100%;">
                                        <select class="form-control select2 change_required" name="last_followup_status"
                                            id="last_followup_status" <?php echo $disabled4; ?>>
                                            <option value="">Select Status</option>
                                            <?php
                                            $statussql=$obj->query("select * from $tbl_lead_status where 1=1 and status=1 group by name order by displayorder asc",-1);
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
                                            <?php echo $disabled4; ?>>
                                            <option value="">Remarks </option>
                                            <?php
                                            if($_REQUEST['id']!='' && $result->last_followup_remarks!=0){
                                                $sSql = $obj->query("select * from $tbl_lead_remarks_status where status=1 and stage_id='".$result->last_followup_status."'",-1); //die();
                                                while($sResult = $obj->fetchNextObject($sSql)){?>
                                            <option value="<?php echo $sResult->id; ?>"
                                                <?php if($sResult->id==$result->last_followup_remarks){?> selected
                                                <?php } ?>><?php echo $sResult->remarks; ?></option>
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
                                            <?php if($readonly4==''){?> id="last_followup_next_followup_date" <?php }?>
                                            placeholder="Last Follow up Date"
                                            class="form-control change-date  change_required <?php if($readonly4==''){?> required <?php }?>"
                                            value="<?php if($result->last_followup_next_followup_date!=''){ echo date('Y-m-d',strtotime($result->last_followup_next_followup_date)); } ?>"
                                            <?php echo $readonly4; ?>>
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
                                            <?php echo $readonly4; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group-addon support_manager_div text-upparcase"
                                        style="height: 35px; color: #fff;">
                                        Lead Review Manager Remark</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group" style="width:100%;">
                                        <input type="date" name="support_last_followup_start_date"
                                            <?php if($result->support_last_followup_additional_remarks == ''){ ?>
                                            id="support_last_followup_start_date" <?php } ?> placeholder="Date"
                                            class="form-control"
                                            value="<?php if($result->support_last_followup_start_date!=''){ echo date('Y-m-d',strtotime($result->support_last_followup_start_date)); }else{ if($result->support_last_followup_additional_remarks == ''){ echo date('Y-m-d'); } } ?>"
                                            <?php echo $result->support_last_followup_additional_remarks!='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width:100%;">
                                    <div class="input-group" style="width:100%;">
                                        <input type="text" class="form-control" placeholder="Enter Remark"
                                            name="support_last_followup_additional_remarks"
                                            id="support_last_followup_additional_remarks"
                                            value="<?php echo stripslashes($result->support_last_followup_additional_remarks); ?>"
                                            <?php echo $result->support_last_followup_additional_remarks!='' ? 'readonly' : ''; ?>
                                            <?=$_SESSION['level_id'] == 1 || in_array(4,$addtional_role) ? '' : 'disabled'?>>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            <script src="js/select2.full.min.js"></script>
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
                            type: 'getLeadRemarks'
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
                            type: 'getLeadRemarks'
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
                            type: 'getLeadRemarks'
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
                            type: 'getLeadRemarks'
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
                $("#last_followup_status").change(function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: 'ajax/getModalData.php',
                        data: {
                            id: id,
                            type: 'getLeadRemarks'
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


                $("#rpercentage").change(function() {
                    v1 = $(this).val();
                    if (parseInt(v1) <= 100) {
                        v2 = "%";
                        $(this).val(v1.concat(v2));
                        $(".err_rpercentage").hide();
                    } else {
                        $(".err_rpercentage").show();
                        $(".err_rpercentage").html("Percentage can not higher than 100%");
                        $(this).focus();
                    }
                })

                $("#rpercentage").click(function() {
                    v1 = $(this).val();
                    v2 = v1.substring(0, v1.length - 1);
                    $("#rpercentage").val(v2);
                })

                $("#board_id").change(function() {
                    bid = $(this).val();
                    if (bid == 'other') {
                        $("#board").show();
                    } else {
                        $("#board").hide();
                    }
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
                if ($("#same_as_primary_number").prop('checked')) {
                    $("#applicant_alternate_no").val($("#applicant_contact_no").val());
                } else {
                    $("#applicant_alternate_no").val('');
                }
            }

            $("#same_as_primary_number").on("change", same_primary);
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
                function change_country(val){
                    if(val == 7){
                        $("#change_country").html("Preferred Area");
                        $("#pre_country_id option:first").text("Preferred Area");
                    }else{
                        $("#change_country").html("Preferred Country");
                        $("#pre_country_id option:first").text("Preferred Country");
                    }
                }
            </script>
</body>

</html>