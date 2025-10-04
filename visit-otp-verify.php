<?php 
include('include/config.php');
include("include/functions.php");
if($_SESSION['visit_data']==''){
    @header("location:visit-addf.php");
}
if($_REQUEST['otpDetails']=='yes'){

    $office_otp1 = $obj->escapestring($_POST['office_otp1']);
    $branch_id = $obj->escapestring($_POST['branch_id']);
    $office_otp2 = $obj->escapestring($_POST['office_otp2']);
    $office_otp3 = $obj->escapestring($_POST['office_otp3']);
    $office_otp4 = $obj->escapestring($_POST['office_otp4']);

    $office_otp = intval($office_otp1).intval($office_otp2).intval($office_otp3).intval($office_otp4);

    if($office_otp == 1111){    
        unset($_SESSION['office_otp1']);
        unset($_SESSION['office_otp2']);
        unset($_SESSION['office_otp3']);
        unset($_SESSION['office_otp4']);
        $_SESSION['branch_id']= $branch_id;
        $number = $_SESSION['visit_data']['applicant_contact_no'];
        $otp = rand(1000,9999);
        //$otp = 2222;
        $_SESSION['votp'] = $otp;
        otpsms($number,$otp);

        header("location:visit-user-otp-verify.php");
    }else{
        $_SESSION['sess_msg_error']='Office OTP is not valid. Please try again.'; 
        $_SESSION['office_otp1'] = $office_otp1;
        $_SESSION['office_otp2'] = $office_otp2;
        $_SESSION['office_otp3'] = $office_otp3;
        $_SESSION['office_otp4'] = $office_otp4;
        header("location:visit-otp-verify.php");
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
        .width-set{
            width: 100%;
        }
    }
    @media (min-width: 601px) {
        .width-set{
            width: 600px ;
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
                                <p style="color: green;">Thanks for filling the Enquiry form. <br>Kindly pass this device to IBT Reception staff to fill official passcode.</p>
                                    <p class="text-center">Please Enter Passcode</p>
                                </div>


                                <div class="align-items-center d-flex justify-content-center align-items-center"
                                    style="display: flex; justify-content:center; align-items:center; gap:20px; margin-bottom: 20px;">
                                    
                                    <select class="form-control" name="branch_id" id="branch_id" style="width: 43%;" required>
                                             <option value="">Select IBT Branch</option>
                                            <?php

                                            $csql=$obj->query("select * from $tbl_branch where 1=1 and status=1 group by name",-1);
                                            while($cresult=$obj->fetchNextObject($csql)){?>
                                                <option value="<?php echo $cresult->id ?>"><?php echo $cresult->name; ?></option>
                                            <?php } ?>                                          
                                        </select>
                                </div>
                            


                                <div class="align-items-center d-flex justify-content-center align-items-center"
                                    style="display: flex; justify-content:center; align-items:center; gap:20px;">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="office_otp1"
                                        id="office_otp1" value="<?php echo $_SESSION['office_otp1']; ?>">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="office_otp2"
                                        id="office_otp2" value="<?php echo $_SESSION['office_otp2']; ?>">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="office_otp3"
                                        id="office_otp3" value="<?php echo $_SESSION['office_otp3']; ?>">
                                    <input class="form-control text-center m-1 code" type="number" min="0" max="9"
                                        placeholder="0" maxlength="1" required style="width: 50px;" name="office_otp4"
                                        id="office_otp4" value="<?php echo $_SESSION['office_otp4']; ?>">
                                </div>
                                <div style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-danger mt-3"
                                        style="background-color: #dd2c83;">Submit</button>
                                </div>
                                <!-- <p class="text-center mt-3">Didn't receive OTP ? Ask to administrator.</p> -->
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
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $("#otpfrm").validate();
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