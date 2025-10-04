<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();
if(isset($_GET['id'])){
    $id = base64_decode(base64_decode(base64_decode($_GET['id'])));
    $sql=$obj->query("select * from $tbl_enrolled_fee where id='$id' order by id desc");
	$res=$obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <style>
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
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Title -->
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <h5 class="txt-dark"><?=isset($_GET['id']) ? 'Update' : 'Add'?> Enrolled Fee</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
                        <h5 style="color:#2a911d;" id="sess_msg">
                            <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <!-- Breadcrumb -->

                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
                        <ol class=" breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="manage-enrolled-fee.php">Manage Enrolled Fee</a></span>
                            </li>
                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->
                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view student_filter">
                            <form action="controller.php" id="form-validate" enctype="multipart/form-data"
                                method="post">
                                <input type="hidden" name="id" value="<?=$res->id?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Country
                                                            &nbsp;</span></div>
                                                <select name="country_id" id="country_id"
                                                    class="required form-control form-select"
                                                    onchange="get_visa_sub_type()">
                                                    <option value="">Select Country</option>
                                                    <?php
													$sql=$obj->query("select * from $tbl_country where status='1'  order by id desc");
													while($line=$obj->fetchNextObject($sql)){ ?>
                                                    <option value="<?=$line->id?>"
                                                        <?=$res->country_id == $line->id ? "selected" : ''?>>
                                                        <?=$line->name?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Visa Type
                                                            &nbsp;</span></div>
                                                <select name="visa_type" id="visa_type"
                                                    class="required form-control form-select"
                                                    onchange="get_visa_sub_type()">
                                                    <option value="">Select Type</option>
                                                    <option value="Study"
                                                        <?=$res->visa_type == 'Study' ? "selected" : ''?>>Study</option>
                                                    <option value="Visitor"
                                                        <?=$res->visa_type == 'Visitor' ? "selected" : ''?>>
                                                        Visitor</option>
                                                    <option value="Tourist"
                                                        <?=$res->visa_type == 'Tourist' ? "selected" : ''?>>
                                                        Tourist</option>
                                                    <option value="Spouse"
                                                        <?=$res->visa_type == 'Spouse' ? "selected" : ''?>>Spouse
                                                    </option>
                                                    <option value="Work"
                                                        <?=$res->visa_type == 'Work' ? "selected" : ''?>>Work</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Payment Type
                                                            &nbsp;</span></div>
                                                <select name="visa_sub_type" id="visa_sub_type"
                                                    class="required form-control form-select">
                                                    <?php
                                                            if(isset($_GET['id'])){
                                                                $country_id = $res->country_id;
                                                                $visa_type = $res->visa_type;
                                                                $sql=$obj->query("select * from $tbl_visa_sub_type where 1=1 and country_id='$country_id' and visa_type='$visa_type'",$debug=-1);
                                                                ?>
                                                    <option value="">Select Payment Type</option>
                                                    <?php
                                                                while($line=$obj->fetchNextObject($sql)){
                                                                ?>
                                                    <option value="<?=$line->id?>"
                                                        <?=$res->visa_sub_type == $line->id ? 'selected' : ''?>>
                                                        <?=$line->visa_sub_type?></option>
                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Registration
                                                            Percentage</span></div>
                                                <input type="number" max="100" class="required form-control"
                                                    name="registration_percentage"
                                                    value="<?=$res->registration_percentage?>"
                                                    placeholder="Enter Registration %">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  <div class="row">
                                   <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Amount
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control" name="amount"
                                                    value="<?=$res->amount?>" placeholder="Enter Amount"
                                                    onchange="change_amount_after_gst(this.value,'amount_after_gst')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>GST %
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control" name="gst" value="18%"
                                                    readonly placeholder="Enter GST">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Amount After
                                                            GST&nbsp;</span></div>
                                                <input type="text" class="required form-control" id="amount_after_gst"
                                                    name="amount_after_gst" value="<?=intval($res->amount + $res->amount*18/100)?>" readonly
                                                    placeholder="Enter Amount After GST">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Max Discount Allowed
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control" name="discount"
                                                    value="<?=$res->discount?>"
                                                    placeholder="Enter Max Discount Allowed">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <!--     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>After Visa Amount
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control"
                                                    name="after_visa_amount" value="<?=$res->after_visa_amount?>"
                                                    placeholder="Enter After Visa Amount" onchange="change_amount_after_gst(this.value,'after_visa_amount_after_gst')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>GST %
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control" name="after_visa_gst"
                                                    value="18%" readonly placeholder="Enter GST">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Amount After
                                                            GST&nbsp;</span></div>
                                                <input type="text" class="required form-control" id="after_visa_amount_after_gst"
                                                    name="after_visa_amount_after_gst" value="<?=intval($res->after_visa_amount + ($res->after_visa_amount*18/100))?>" readonly
                                                    placeholder="Enter Amount After GST">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><span> &nbsp; <span>Max Discount Allowed
                                                            &nbsp;</span></div>
                                                <input type="text" class="required form-control"
                                                    name="after_visa_discount" value="<?=$res->after_visa_discount?>"
                                                    placeholder="Enter Max Discount Allowed">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                Update
                                                <input type="radio" class="required" name="type"
                                                    <?=$res->type == 'Fresh' ? 'checked' : ''?> value="Fresh">
                                                Upgrade
                                                <input type="radio" class="required" name="type"
                                                    <?=$res->type == 'Reapply' ? 'checked' : ''?> value="Reapply">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        if(isset($_GET['id'])){
                                            ?>
                                <button class="btn btn-success" type="submit" name="btn_update_enrolled_fee">Update
                                    Enrolled Fee</button>
                                <?php }else{ ?>
                                <button class="btn btn-success" type="submit" name="btn_add_enrolled_fee">Add Enrolled
                                    Fee</button>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
                <!-- Footer -->
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
                <!-- /Footer -->
            </div>
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /#wrapper -->
    <?php include("footer.php"); ?>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
    <script src="js/change-status.js"></script>
    <script>
    $(document).ready(function() {
        $("#form-validate").validate();
    });
    </script>
    <script>
    function get_visa_sub_type() {
        country_id = $("#country_id").val();
        visa_type = $("#visa_type").val();
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                country_id: country_id,
                visa_type: visa_type
            },
            success: function(data) {
                $("#visa_sub_type").html(data);
            }
        })
    }
    </script>
    <script>
    function change_amount_after_gst(val, id) {
        var value = parseFloat(val);
        var amount_after_gst = value + (value * 18 / 100);
        amount_after_gst = amount_after_gst.toFixed(0);
        $("#" + id).val(amount_after_gst);
    }
    </script>
</body>

</html>