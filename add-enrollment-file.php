<?php
include('include/config.php');
include("include/functions.php");
validate_user();

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
                    unset($_SESSION['sess_msg']);  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        unset($_SESSION['sess_msg_error']);  ?></h5>
                <div class="student_filter">
                    <h4 class="my-3">Add Enrollment</h4>
                    <form method="post" action="controller.php" name="visitfrm" id="form-validate" enctype=multipart/form-data meaning>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><span><i class="fa-solid fa-file"
                                                    style="font-size:15px;"></i></span><span> CSV File</span></div>
                                        <input type="file" class="required form-control" name="file" accept=".csv">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="text-align: center;">
                                <div class="">
                                    <div style="text-align: center; padding: 10px;">
                                        <p class="text-danger" id="text-error">
                                        <button type="submit" id="submitbtn" name="btn_add_enrollment" class="btn mr-10">Submit</button>
                                    </div>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
            <script type="text/javascript" src="js/jquery.validate.min.js"></script>
            <link rel="stylesheet" href="calender/css/jquery-ui.css">
            <script src="calender/js/jquery-ui.js"></script>
            <script src="js/select2.full.min.js"></script>
            <script src="js/select2.full.min.js"></script>
            <script>
            $(document).ready(function() {
                $("#form-validate").validate();
            });
            </script>
       
</body>

</html>