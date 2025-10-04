<?php 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
if($_REQUEST['id']!=''){
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $sql = $obj->query("select * from $tbl_student_enrollment where stu_id='$id'");
    $result = $obj->fetchNextObject($sql);
     $get = $obj->query("SELECT * FROM tbl_student_commision where stu_id='$id'");
     $res1=$obj->fetchNextObject($get);
}
?>
<!DOCTYPE html>
<html lang="en" style="background:white">

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





<?php include("footer.php"); ?>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<link rel="stylesheet" href="calender/css/jquery-ui.css">
<script src="calender/js/jquery-ui.js"></script>
<script src="js/select2.full.min.js"></script>


</body>

</html> 