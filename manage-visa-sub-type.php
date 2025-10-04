<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();
$_SESSION['reload']="1";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.material-switch>input[type="checkbox"] {
    display: none;
}

.material-switch>label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
}

.material-switch>label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position: absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}

.material-switch>label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}

.material-switch>input[type="checkbox"]:checked+label::before {
    background: inherit;
    opacity: 0.5;
}

.material-switch>input[type="checkbox"]:checked+label::after {
    background: inherit;
    left: 20px;
}
</style>

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
                        <h5 class="txt-dark">Manage Payment Type</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <!-- Breadcrumb -->

                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#" onclick="ShowModal();">Add Payment Type</a></span></li>

                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">

                            <form name="frm" method="post" action="state-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_1" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Country Name</th>
                                                            <th>Visa Type</th>
                                                            <th>Payment Type</th>
                                                            <th>Registration (%)</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Country Name</th>
                                                            <th>Visa Type</th>
                                                            <th>Payment Type</th>
                                                            <th>Registration (%)</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
													$i=1;
													$sql=$obj->query("select * from $tbl_visa_sub_type where 1=1",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){
                                                      
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo getField('name',$tbl_country,$line->country_id) ?>
                                                            </td>
                                                            <td><?php echo $line->visa_type ?></td>
                                                            <td><?php echo $line->visa_sub_type ?></td>
                                                            <td><?php echo $line->registration_percentage ?></td>
                                                            <td><?=$line->type ?></td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_visa_sub_type?>" />
                                                                    <label
                                                                        for="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="getModalData(<?php echo $line->id ?>)"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>

                                                                <!-- <a href="controller.php?delete_visa_sub_type=<?php echo $line->id ?>"
                                                                    value="Delete" type="submit" class="delete_button"
                                                                    onclick="return confirm('Are you sure you want to delete record(s)')"
                                                                    style=" background: transparent; border: none;"><i class="fa fa-trash" style="margin-right: 6px;font-size: 16px;"></i> </a> -->
                                                        </tr>
                                                        <?php ++$i;} ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Modal Add -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="post" id="addstate" name="addstate">
                                <input type="hidden" name="id" id="id" value="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                    <h5 class="modal-title" id="exampleModalLabel1">Add Payment Type</h5>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Country:</label>
                                        <select class="form-control" name="country_id" id="country_id" required>
                                            <option value="">--Select Country--</option>
                                            <?php
												$i=1;
												$sql=$obj->query("select * from $tbl_country where status=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($result->country_id==$line->id){?>selected<?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="err_country_id" style="color:red;"></span>

                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Visa Type</label>
                                        <select name="visa_type" id="visa_type"
                                            class="required form-control form-select">
                                            <option value="">Select Type</option>
                                            <option value="Study">Study</option>
                                            <option value="Visitor">Visitior</option>
                                            <option value="Tourist">Tourist</option>
                                            <option value="Spouse">Spouse</option>
                                            <option value="Work">Work</option>
                                        </select>
                                        <span id="err_visa_type" style="color:red;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Payment Type</label>
                                        <input type="text" class="form-control" id="visa_sub_type" name="visa_sub_type">
                                    </div>
									<div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Registration Percentage</label>
                                        <input type="text" class="form-control" id="registration_percentage" name="registration_percentage" max="100">
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="student_show" id="student_show" value="1"
                                            class="student_show"><label style="margin-left:5px;">Welcome Call</label>
                                        <input type="checkbox" name="enrollment_count" id="enrollment_count" value="1"
                                            class="enrollment_count"><label style="margin-left:5px;">Enrollment
                                            Setting</label>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="radio" class="required" name="type"
                                                <?=$res->type == 'Fresh' ? 'checked' : ''?> value="Fresh">
                                                Fresh
                                            <input type="radio" class="required" name="type"
                                            <?=$res->type == 'Reapply' ? 'checked' : ''?> value="Reapply">
                                            Reapply
                                            <input type="radio" class="required" name="type"
                                            <?=$res->type == 'University Transfer' ? 'checked' : ''?> value="University Transfer">
                                            University Transfer
                                            <input type="radio" class="required" name="type"
                                            <?=$res->type == 'Refund' ? 'checked' : ''?> value="Refund">
                                            Refund
                                        </div>
                                    </div>

                                    <span id="err_visa_sub_type" style="color:red;"></span>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="btnSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>



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


    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add Payment Type");
        $("#country_id").val("");
        $("#visa_type").val("");
        $("#visa_sub_type").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_state_name").hide();

        $("#student_show").prop("checked", false);
        $("#enrollment_count").prop("checked", false);
    }

    function getModalData(id) {
        $("#student_show").prop("checked", false);
        $("#enrollment_count").prop("checked", false);
        $("#exampleModalLabel1").html("Update Payment Type");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'get_visa_sub_type'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#country_id").val(response[1]);
                $("#visa_type").val(response[2]);
                $("#visa_sub_type").val(response[3]);
				$("input[name='type'][value='" + response[6] + "']").prop("checked", true);
                $("#registration_percentage").val(response[7]);
                if (response[4] == 1) {
                    $("#student_show").prop("checked", true);
                }
                if (response[5] == 1) {
                    $("#enrollment_count").prop("checked", true);
                }
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        var id = $("#id").val();
        country_id = $("#country_id").val();
        visa_type = $("#visa_type").val();
        visa_sub_type = $("#visa_sub_type").val();
        enrollment_count = $("#enrollment_count").val();
        student_show = $("#student_show").val();
        registration_percentage = $("#registration_percentage").val();
		type = $("input[name='type']:checked").val();
        if (country_id == '') {
            $("#err_country_id").show().html("This field is required.");
            return;
        }
        if (visa_type == '') {
            $("#err_visa_type").show().html("This field is required.");
            return;
        }
        if (visa_sub_type == '') {
            $("#err_visa_sub_type").show().html("This field is required.");
            return;
        }
        if (document.getElementById('enrollment_count').checked === false) {
            enrollment_count = 0;
        } else {
            enrollment_count = 1;
        }
        if (document.getElementById('student_show').checked === false) {
            student_show = 0;
        } else {
            student_show = 1;
        }
        if (id == '') {
            action = 'add_visa_sub_type';
        } else {
            action = 'update_visa_sub_type';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'visa_sub_type': visa_sub_type,
                'visa_type': visa_type,
                'country_id': country_id,
                'enrollment_count': enrollment_count,
                'student_show': student_show,
                'registration_percentage': registration_percentage,
                'type': type,
                'action': action
            },
            success: function(response) {
                //console.log(response); return;
                if (response == 1) {
                    $("#exampleModal").modal('hide');
                    location.reload(true);
                }
            },
        });
    });
    $("#country_id").change(function() {
        $("#err_country_id").hide();
    })
    $("#state_name").keypress(function() {
        $("#err_state_name").hide();
    })
    </script>

    <script src="js/change-status.js"></script>
</body>

</html>