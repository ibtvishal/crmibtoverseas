<?php 
include('include/config.php');
include("include/functions.php");
if($_SESSION['visit_data']==''){
    @header("location:visit-addf.php");
}

if($_REQUEST['otpDetails']=='yes'){
    $enquiry_otp1 = $obj->escapestring($_POST['enquiry_otp1']); 
    $enquiry_otp2 = $obj->escapestring($_POST['enquiry_otp2']);
    $enquiry_otp3 = $obj->escapestring($_POST['enquiry_otp3']);
    $enquiry_otp4 = $obj->escapestring($_POST['enquiry_otp4']);

    $enquiry_otp = intval($enquiry_otp1).intval($enquiry_otp2).intval($enquiry_otp3).intval($enquiry_otp4);
    $get_branchs = $obj->query("SELECT * FROM `tbl_branch` WHERE id='".$_SESSION['branch_id']."'");
    $get_branch = $obj->fetchNextObject($get_branchs);
    //echo $enquiry_otp."=".$_SESSION['votp']; die;
    if(intval($enquiry_otp)==intval($_SESSION['votp']) || intval($enquiry_otp) == $get_branch->student_otp){
        $_POST = $_SESSION['visit_data'];      

        $applicant_name=$obj->escapestring($_POST['applicant_name']);
        if($applicant_name!=''){
            $sql .= "applicant_name='$applicant_name'";
        }

        if($_SESSION['branch_id']){
            $sql .= ",branch_id='".$_SESSION['branch_id']."'";
        }

        $father_name=$obj->escapestring($_POST['father_name']);
        if($father_name!=''){
            $sql .= ",father_name='$father_name'";
        }
        $dob=$obj->escapestring($_POST['dob']);
        if($dob!=''){
            $dob = date('Y-m-d',strtotime($dob));
            $sql .= ",dob='$dob'";
        }
        $marital_status=$obj->escapestring($_POST['marital_status']);
        if($marital_status!=''){
            $sql .= ",marital_status='$marital_status'";
        }
        $country_id=$obj->escapestring($_POST['country_id']);
        if($country_id!=''){
            $sql .= ",country_id='$country_id'";
        }
        $applicant_contact_no=$obj->escapestring($_POST['applicant_contact_no']);
        if($applicant_contact_no!='' && $applicant_contact_no!=1000){
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
        
        if(isset($_POST['visa_type']) && count($_POST['visa_type'])>0){
            $visa_type=implode(',',$_POST['visa_type']);
            if($visa_type!=''){
                $sql .= ",visa_type='$visa_type'";
            }
        }
        if(isset($_POST['refuesed_visa_type']) && count($_POST['refuesed_visa_type'])> 0){
            $refuesed_visa_type=implode(',',$_POST['refuesed_visa_type']);
            if($refuesed_visa_type!=''){
                $sql .= ",refuesed_visa_type='$refuesed_visa_type'";
            }
        }
        $address=$obj->escapestring($_POST['address']);
        if($address!=''){
            $sql .= ",address='$address'";
        }
        $refuesed_date=$obj->escapestring($_POST['refuesed_date']);
        if($address!=''){
            $sql .= ",refuesed_date='$refuesed_date'";
        }
        $embassy=$obj->escapestring($_POST['embassy']);
        if($embassy!=''){
            $sql .= ",embassy='$embassy'";
        }
        $visa_earlier=$obj->escapestring($_POST['visa_earlier']);
        if($visa_earlier!=''){
            $sql .= ",visa_earlier='$visa_earlier'";
        }
        $earlier_country_id=$obj->escapestring($_POST['earlier_country_id']);
        if($earlier_country_id!=''){
            $sql .= ",earlier_country_id='$earlier_country_id'";
        }
        $pre_country_id=$obj->escapestring($_POST['pre_country_id']);
        if($pre_country_id!=''){
            $sql .= ",pre_country_id='$pre_country_id'";
        }

        $pre_state_id=$obj->escapestring($_POST['pre_state_id']);
        if($pre_state_id!=''){
            $sql .= ",pre_state_id='$pre_state_id'";
        }
        $matri_board=$obj->escapestring($_POST['matri_board']);
        if($matri_board!=''){
            $sql .= ",matri_board='$matri_board'";
        }
        $matri_start_year=$obj->escapestring($_POST['matri_start_year']);
        if($matri_start_year!=''){
            $sql .= ",matri_start_year='$matri_start_year'";
        }
        $matri_finish_year=$obj->escapestring($_POST['matri_finish_year']);
        if($matri_finish_year!=''){
            $sql .= ",matri_finish_year='$matri_finish_year'";
        }
        $matri_percentage=$obj->escapestring($_POST['matri_percentage']);
        if($matri_percentage!=''){
            $sql .= ",matri_percentage='$matri_percentage'";
        }
        $matri_backlog=$obj->escapestring($_POST['matri_backlog']);
        if($matri_backlog!=''){
            $sql .= ",matri_backlog='$matri_backlog'";
        }

        $secondary_board=$obj->escapestring($_POST['secondary_board']);
        if($secondary_board!=''){
            $sql .= ",secondary_board='$secondary_board'";
        }
        
        $secondary_stream=$obj->escapestring($_POST['secondary_stream']);
        if($secondary_stream!=''){
            $sql .= ",secondary_stream='$secondary_stream'";
        }
        $secondary_start_year=$obj->escapestring($_POST['secondary_start_year']);
        if($secondary_start_year!=''){
            $sql .= ",secondary_start_year='$secondary_start_year'";
        }

        $secondary_finish_year=$obj->escapestring($_POST['secondary_finish_year']);
        if($secondary_finish_year!=''){
            $sql .= ",secondary_finish_year='$secondary_finish_year'";
        }
        $secondary_percentage=$obj->escapestring($_POST['secondary_percentage']);
        if($secondary_percentage!=''){
            $sql .= ",secondary_percentage='$secondary_percentage'";
        }
        $secondary_backlog=$obj->escapestring($_POST['secondary_backlog']);
        if($secondary_backlog!=''){
            $sql .= ",secondary_backlog='$secondary_backlog'";
        }
        $diploma_board=$obj->escapestring($_POST['diploma_board']);
        if($diploma_board!=''){
            $sql .= ",diploma_board='$diploma_board'";
        }
        $diploma_stream=$obj->escapestring($_POST['diploma_stream']);
        if($diploma_stream!=''){
            $sql .= ",diploma_stream='$diploma_stream'";
        }
        $diploma_start_year=$obj->escapestring($_POST['diploma_start_year']);
        if($diploma_start_year!=''){
            $sql .= ",diploma_start_year='$diploma_start_year'";
        }
        $diploma_finish_year=$obj->escapestring($_POST['diploma_finish_year']);
        if($diploma_finish_year!=''){
            $sql .= ",diploma_finish_year='$diploma_finish_year'";
        }
        $diploma_percentage=$obj->escapestring($_POST['diploma_percentage']);
        if($diploma_percentage!=''){
            $sql .= ",diploma_percentage='$diploma_percentage'";
        }

        $diploma_backlog=$obj->escapestring($_POST['diploma_backlog']);
        if($diploma_backlog!=''){
            $sql .= ",diploma_backlog='$diploma_backlog'";
        }
        $bachelor_board=$obj->escapestring($_POST['bachelor_board']);
        if($bachelor_board!=''){
            $sql .= ",bachelor_board='$bachelor_board'";
        }
        $bachelor_stream=$obj->escapestring($_POST['bachelor_stream']);
        if($bachelor_stream!=''){
            $sql .= ",bachelor_stream='$bachelor_stream'";
        }
        $bachelor_start_year=$obj->escapestring($_POST['bachelor_start_year']);
        if($bachelor_start_year!=''){
            $sql .= ",bachelor_start_year='$bachelor_start_year'";
        }
        $bachelor_finish_year=$obj->escapestring($_POST['bachelor_finish_year']);
        if($bachelor_finish_year!=''){
            $sql .= ",bachelor_finish_year='$bachelor_finish_year'";
        }
        $bachelor_percentage=$obj->escapestring($_POST['bachelor_percentage']);
        if($bachelor_percentage!=''){
            $sql .= ",bachelor_percentage='$bachelor_percentage'";
        }
        $bachelor_backlog=$obj->escapestring($_POST['bachelor_backlog']);
        if($bachelor_backlog!=''){
            $sql .= ",bachelor_backlog='$bachelor_backlog'";
        }

        $master_board=$obj->escapestring($_POST['master_board']);
        if($master_board!=''){
            $sql .= ",master_board='$master_board'";
        }
        $master_stream=$obj->escapestring($_POST['master_stream']);
        if($master_stream!=''){
            $sql .= ",master_stream='$master_stream'";
        }
        $master_start_year=$obj->escapestring($_POST['master_start_year']);
        if($master_start_year!=''){
            $sql .= ",master_start_year='$master_start_year'";
        }
        $master_finish_year=$obj->escapestring($_POST['master_finish_year']);
        if($master_finish_year!=''){
            $sql .= ",master_finish_year='$master_finish_year'";
        }
        $master_percentage=$obj->escapestring($_POST['master_percentage']);
        if($master_percentage!=''){
            $sql .= ",master_percentage='$master_percentage'";
        }
        $master_backlog=$obj->escapestring($_POST['master_backlog']);
        if($master_backlog!=''){
            $sql .= ",master_backlog='$master_backlog'";
        }
        $available_funds=$obj->escapestring($_POST['available_funds']);
        if($available_funds!=''){
            $sql .= ",available_funds='$available_funds'";
        }
        $source=$obj->escapestring($_POST['source']);
        if($source!=''){
            $sql .= ",source='$source'";
        }
        $enquiry_type=$obj->escapestring($_POST['enquiry_type']);
        if($enquiry_type!=''){
            if($enquiry_type == 'Old Walkin'){
                $sql .= ",cdate=null";
            }
            if($enquiry_type == 'Re-apply'){
                $sql .= ",reapply_status=1";
            }
            $sql .= ",enquiry_type='$enquiry_type'";
        }
        $visa_outcome=$obj->escapestring($_POST['visa_outcome']);
        if($visa_outcome!=''){
            $sql .= ",visa_outcome='$visa_outcome'";
        }
        $university_name=$obj->escapestring($_POST['university_name']);
        if($university_name!=''){
            $sql .= ",university_name='$university_name'";
        }
        $course_name=$obj->escapestring($_POST['course_name']);
        if($course_name!=''){
            $sql .= ",course_name='$course_name'";
        }
        $family_fund=$obj->escapestring($_POST['family_fund']);
        if($family_fund!=''){
            $sql .= ",family_fund='$family_fund'";
        }

        $vN = $obj->query("select enquiry_id from $tbl_visit where 1=1 order by id desc");
        $vNum = $obj->numRows($vN);
        if($vNum>0){
            $Vresult = $obj->fetchNextObject($vN);
            $enquiry_id=$Vresult->enquiry_id+1;
        }else{
            $enquiry_id=10000;
        }


        $city_id=$obj->escapestring($_POST['city_id']);
        if($city_id!=1000){
            $sql .= ",city_id='$city_id'";
        }

        if($city_id==1000){
            $city_name=$obj->escapestring($_POST['city_name']);
            $obj->query("insert into tbl_location_cities set name='$city_name',country_id=0,state_id='$state_id'",-1); //die;
            $city_id = $obj->lastInsertedId();
            $sql .= ",city_id='$city_id'";
        }
    
       $sql .= ",enquiry_id='$enquiry_id'";
       if(isset($_SESSION['sess_admin_id'])){
        $user_id = $_SESSION['sess_admin_id'];
       }else{
        $user_id = '0';
       }
       $vN = $obj->query("select * from $tbl_visit where applicant_contact_no in ('$applicant_contact_no','$applicant_alternate_no') or applicant_alternate_no in ('$applicant_contact_no','$applicant_alternate_no') ");
       if($obj->numRows($vN) == 0){
       $insert =  $obj->query("insert into $tbl_visit set user_id='$user_id', $sql",-1); //die;
       $vid = $obj->lastInsertedId();
      $insert =  $obj->query("update $tbl_lead set status='0' where applicant_contact_no='$applicant_contact_no' or applicant_alternate_no='$applicant_contact_no' or applicant_contact_no = '$applicant_alternate_no' or applicant_alternate_no = '$applicant_alternate_no'",-1); //die;

        $educationResult = $_POST['education'];
        $empDetailsResult = $_POST['empDetails'];
        $langDetailsResult = $_POST['langDetails'];
        $examSectionResult = $_POST['exam_section'];

        // echo "<pre>";
        // print_r($examSectionResult); die;
       
        if ($educationResult!='') {
            if(count($educationResult)>0){
                $sql="delete from $tbl_visit_education where visit_id='".$vid."'"; 
                $obj->query($sql);
                foreach($educationResult as $val){
                    $obj->query("insert into $tbl_visit_education set visit_id='$vid', master_board='".$val['master_board']."',master_stream='".$val['master_stream']."',master_start_year='".$val['master_start_year']."',master_finish_year='".$val['master_finish_year']."',master_percentage='".$val['master_percentage']."',master_backlog='".$val['master_backlog']."'",-1); //die;
                }
            }
        }
 
        if ($empDetailsResult!='') {
            if(count($empDetailsResult)>0){
                $sql="delete from $tbl_visit_employee_details where visit_id='".$vid."'"; 
                $obj->query($sql);
                foreach($empDetailsResult as $val){
                    if(!empty($val['company_name'])){   
                        $obj->query("insert into $tbl_visit_employee_details set visit_id='$vid', company_name='".$val['company_name']."',designation='".$val['designation']."',start_date='".$val['start_date']."',end_date='".$val['end_date']."',last_salary='".$val['last_salary']."'",-1);//die;
                    }
                }
            }
        }



        if ($langDetailsResult!='') {
            if(count($langDetailsResult)>0){
                $sql="delete from $tbl_visit_language_details where visit_id='".$vid."'"; 
                $obj->query($sql);
                foreach($langDetailsResult as $val){
                    if(!empty($val['exam_name'])){
                        $obj->query("insert into $tbl_visit_language_details set visit_id='$vid', exam_name='".$val['exam_name']."',lang_listening='".$val['lang_listening']."',lang_reading='".$val['lang_reading']."',lang_writing='".$val['lang_writing']."',lang_speaking='".$val['lang_speaking']."',scrore='".$val['scrore']."',exam_date='".$val['exam_date']."'",-1);//die;
                    }
                }
            }
        }
       
        if ($examSectionResult!='') {
            if(count($examSectionResult)>0){
                $sql="delete from $tbl_visit_exam_section where visit_id='".$vid."'"; 
                $obj->query($sql);
                foreach($examSectionResult as $val){
                    $esql='';
                    if($val['exam_name']!=''){
                        $esql .= ",exam_name='".$val['exam_name']."'";
                    }
                    if($val['value1']!=''){
                        $esql .= ",value1='".$val['value1']."'";
                    }
                    if($val['value2']!=''){
                        $esql .= ",value2='".$val['value2']."'";
                    }
                    if($val['value3']!=''){
                        $esql .= ",value3='".$val['value3']."'";
                    }
                    if($val['value4']!=''){
                        $esql .= ",value4='".$val['value4']."'";
                    }
                    if($val['scrore']!=''){
                        $esql .= ",scrore='".$val['scrore']."'";
                    }
                    $obj->query("insert into $tbl_visit_exam_section set visit_id='$vid' $esql",-1); //die;
                }
            }
        }
        
        if($insert){
            unset($_SESSION['enquiry_otp1']);
            unset($_SESSION['enquiry_otp2']);
            unset($_SESSION['enquiry_otp3']);
            unset($_SESSION['enquiry_otp4']);
            unset($_SESSION['visit_data']); 
            unset($_SESSION['sess_msg_error']);
            if(isset($_SESSION['sess_admin_id'])){
                @header("location:visit-list.php");
            }else{
                @header("location:thankyou.php");
            }
        }else{
            $_SESSION['enquiry_otp1'] = $enquiry_otp1;
            $_SESSION['enquiry_otp2'] = $enquiry_otp2;
            $_SESSION['enquiry_otp3'] = $enquiry_otp3;
            $_SESSION['enquiry_otp4'] = $enquiry_otp4;

            $_SESSION['sess_msg_error']='Your OTP is not valid. Please try again.';
            header("location:visit-user-otp-verify.php");
        }
    }else{
        // @header("location:visit-list.php");
        echo '<script>Please change the number</script>';
    }
    }else{
       $_SESSION['sess_msg_error']='Your OTP is not valid. Please try again.';
       header("location:visit-user-otp-verify.php");
    }

   
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <style>
    .code::-webkit-inner-spin-button,
    .code::-webkit-outer-spin-button {
        -webkit-appearance: none !important;
        margin: 0;
    }

    .code:valid {
        border: 2px solid green;
        box-shadow: 0 0 5px green;
    }

    @media (max-width: 600px) {
        .width-set {
            width: 100%;
        }
    }

    @media (min-width: 601px) {
        .width-set {
            width: 600px;
        }
    }
    </style>
</head>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php //include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container">
                <div class="row text-center" style="padding-top:50px;">
                    <form method="post" action="" name="otpfrm" id="otpfrm" enctype=multipart/form-data meaning>
                        <input type="hidden" name="otpDetails" id="otpDetails" value="yes">
                        <div class="col-12">
                            <h5 style="color:red;">
                                <?php if($_SESSION['sess_msg_error']){ echo $_SESSION['sess_msg_error'];  } ?></h5>
                            <div class="width-set"
                                style="margin:auto; height: 300px; background: white; box-shadow: 6px 6px 12px lightgray; border-radius: 5px;">
                                <div class="" style="padding: 20px;">
                                    <p class="text-center">Please Enter Student OTP</p>
                                </div>
                                <div class="align-items-center d-flex justify-content-center align-items-center"
                                    style="display: flex; justify-content:center; align-items:center; gap:20px;">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="enquiry_otp1"
                                        id="enquiry_otp1" value="<?php echo $_SESSION['enquiry_otp1']; ?>">
                                    <input class="form-control text-center m-1 code " type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="enquiry_otp2"
                                        id="enquiry_otp2" value="<?php echo $_SESSION['enquiry_otp2']; ?>">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="enquiry_otp3"
                                        id="enquiry_otp3" value="<?php echo $_SESSION['enquiry_otp3']; ?>">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="enquiry_otp4"
                                        id="enquiry_otp4" value="<?php echo $_SESSION['enquiry_otp4']; ?>">

                                </div>
                                <div style="margin-top: 20px;">
 
                                    <button type="button" class="btn btn-danger mt-3"
                                        onclick="window.location='visit-addf.php'">Change Number</button>
                                    <button type="submit" class="btn btn-danger mt-3"
                                        style="background-color: #dd2c83;">Submit</button>
                                </div>
                                <p class="text-center mt-3">Didn't receive OTP ? <span class="text-primary"> <a href="#"
                                            class="text-decoration-none">Resend OTP</a> </span></p>
                            </div>
                        </div>
                    </form>
                </div>
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2024 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
            </div>
            <?php include("footer.php"); ?>
            <script type="text/javascript" src="js/jquery.validate.min.js"></script>
            <link rel="stylesheet" href="calender/css/jquery-ui.css">
            <script src="calender/js/jquery-ui.js"></script>
            <script>
            $(document).ready(function() {
                $("#otpfrm").validate();
                $("#enquiry_otp4").attr('max', 9);
                $("#enquiry_otp4").attr('min', 0);
            })

            const codes = document.querySelectorAll(".code");
            codes[0].focus();

            document.addEventListener("input", function(e) {
                const target = e.target;
                if (target.classList.contains("code")) {
                    const maxLength = parseInt(target.getAttribute("maxlength"));
                    const currentLength = target.value.length;

                    if (currentLength >= maxLength) {
                        const nextInput = target.nextElementSibling;
                        if (nextInput) {
                            nextInput.focus();
                        }
                    }
                }
            });

            document.addEventListener("keydown", function(e) {
                const target = e.target;
                if (target.classList.contains("code") && e.key === "Backspace" && target.value.length === 0) {
                    const prevInput = target.previousElementSibling;
                    if (prevInput) {
                        prevInput.focus();
                    }
                }
            });
            </script>
</body>

</html>