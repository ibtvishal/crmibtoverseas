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
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Stage</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
                        <h5 style="color:#2a911d;" id="sess_msg"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-section col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add
                                        Stage</a></span></li>
                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <!-- <div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">data Table</h6>
								</div>
								<div class="clearfix"></div>
							</div> -->
                            <form name="frm" method="post" action="stage-del.php" enctype="multipart/form-data">
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
                                                            <th>Stage Status</th>
                                                            <th>Status</th>
                                                            <th>User Type</th>
                                                            <th>Display Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Country Name</th>
                                                            <th>Visa Type</th>
                                                            <th>Stage Status</th>
                                                            <th>Status</th>
                                                            <th>User Type</th>
                                                            <th>Display Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
													$i=1;
													$sql=$obj->query("select * from $tbl_stage where 1=1",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo getField('name',$tbl_country,$line->country_id);?>
                                                            </td>
                                                            <td><?php 
														if($line->visa_id==1){
															echo "Study Visa";
														}elseif ($line->visa_id==2) {
															echo "Tourist Visa";
														}elseif ($line->visa_id==3) {
															echo "Visitor Visa";
														}
                                                        elseif ($line->visa_id==4) {
															echo "Work Visa";
														} 
                                                        elseif ($line->visa_id==5) {
															echo "Spouse";
														} 
														?></td>
                                                            <td><?php echo $line->stage ?></td>
                                                            <td><?php echo $line->cstatus ?></td>
                                                            <td><?php
														$array=explode(',',$line->user_roles);
														$user_t = [];
														foreach($array as $key => $res){
															if($key != 0){
																echo ', ';
															}
															 get_user_role($res, 0);
														}
														?></td>
                                                            <td> <input type="text" size="5" maxlength="2"
                                                                    value="<?php echo $line->displayorder ?>"
                                                                    onchange="chagnedisplayOrder(<?php echo $line->id; ?>,this.value)">
                                                            </td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_stage?>" />
                                                                    <label
                                                                        for="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if($_SESSION['sess_admin_id'] == '116' || $_SESSION['sess_admin_id'] == '1' || $_SESSION['level_id'] == '1'){
                                                                ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="getModalData(<?php echo $line->id ?>)"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>
                                                                <?php } ?>
                                                                <!-- <a href="stage-del.php?id=<?php echo $line->id ?>"
                                                                    value="Delete" type="submit" class="delete_button"
                                                                    onclick="return confirm('Are you sure you want to delete record(s)')"
                                                                    style=" background: transparent;
														            border: none;"><i class="fa fa-trash" style="margin-right: 6px;font-size: 16px;"></i> </a> -->
                                                            </td>


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
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                                <h5 class="modal-title" id="exampleModalLabel1">Add Stage</h5>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="addStage" name="addStage">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Country:</label>
                                        <select class="form-control" name="country_id" id="country_id" required>
                                            <option value="">--Select Country--</option>
                                            <?php
												$i=1;
												$sql=$obj->query("select * from $tbl_country where 1=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($result->country_id==$line->id){?>selected<?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="err_country_id" style="color:red;"></span>

                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Visa Type:</label>
                                        <select class="form-control" name="visa_id" id="visa_id">
                                            <option value="">--Select Visa Type--</option>
                                            <option value="1" <?php if($result->visa_id==1){?> selected <?php } ?>>Study
                                                Visa</option>
                                            <option value="2" <?php if($result->visa_id==2){?> selected <?php } ?>>
                                                Tourist Visa</option>
                                            <option value="3" <?php if($result->visa_id==3){?> selected <?php } ?>>
                                                Visitor Visa</option>
                                            <option value="4" <?php if($result->visa_id==4){?> selected <?php } ?>>Work
                                                Visa</option>
                                            <option value="5" <?php if($result->visa_id==5){?> selected <?php } ?>>Spouse Visa</option>
                                        </select>
                                        <span id="err_visa_id" style="color:red;"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Stage:</label>
                                        <input type="text" class="form-control" name="stage" id="stage" required>
                                    </div>
                                    <span id="err_stage" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Status:</label>
                                        <input type="text" class="form-control" name="cstatus" id="cstatus" required>
                                    </div>
                                    <span id="err_status" style="color:red;"></span>
                                    <div class="form-group new-class-width">
                                        <label for="recipient-name" class="control-label mb-10">User Type:</label>
                                        <select class="form-control select2 user_types" multiple name="user_roles[]"
                                            id="user_roles" required <?=$_SESSION['level_id'] != 1 ? 'disabled' : ''?>>
                                            <?=get_user_roles()?>
                                        </select>
                                    </div>
                                    <span id="err_user_roles" style="color:red;"></span>
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
    <script src="js/select2.full.min.js"></script>

    <script>
    $(".select2").select2();
    $(".user_types").select2({
        placeholder: "Select Types",
        allowClear: true
    });
    </script>
    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add Stage");
        $("#country_id").val("");
        $("#stage").val("");
        $("#cstatus").val("");
        $("#visa_id").val("");
        $("#user_roles").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_stage").hide();
        $("#err_status").hide();
        $("#err_user_roles").hide();
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update Stage");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getStage'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#country_id").val(response[1]);
                $("#stage").val(response[2]);
                $("#cstatus").val(response[3]);
                $("#visa_id").val(response[4]);

                roles = response[5].split(',');
                $("#user_roles").val(roles).change();
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        id = $("#id").val();
        country_id = $("#country_id").val();
        stage = $("#stage").val();
        cstatus = $("#cstatus").val();
        visa_id = $("#visa_id").val();
        user_roles = $("#user_roles").val();
        if (country_id == '') {
            $("#err_country_id").show().html("This field is required.");
            return;
        }
        if (visa_id == '') {
            $("#err_visa_id").show().html("This field is required.");
            return;
        }
        if (stage == '') {
            $("#err_stage").show().html("This field is required.");
            return;
        }
        if (cstatus == '') {
            $("#err_status").show().html("This field is required.");
            return;
        }
        if (user_roles == '') {
            $("#err_user_roles").show().html("This field is required.");
            return;
        }
        if (id == '') {
            action = 'addStage';
        } else {
            action = 'updateStage';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'country_id': country_id,
                'visa_id': visa_id,
                'stage': stage,
                'cstatus': cstatus,
                'user_roles': user_roles,
                'action': action
            },
            success: function(response) {
                //console.log(response);
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

    $("#visa_id").change(function() {
        $("#err_visa_id").hide();
    })
    $("#stage").keypress(function() {
        $("#err_stage").hide();
    })
    $("#cstatus").keypress(function() {
        $("#err_status").hide();
    })
    </script>
    <script>
    /*Sidebar Navigation*/
    $(document).on('click', '#toggle_nav_btn,#open_right_sidebar,#setting_panel_btn', function(e) {
        $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
        return false;
    });
    $(document).on('click', '#toggle_nav_btn', function(e) {
        $wrapper.removeClass('open-right-sidebar open-setting-panel').toggleClass('slide-nav-toggle');
        return false;
    });

    $(document).on('click', '#open_right_sidebar', function(e) {
        $wrapper.toggleClass('open-right-sidebar').removeClass('open-setting-panel');
        return false;

    });

    $(document).on('click', '.product-carousel .owl-nav', function(e) {
        return false;
    });

    $(document).on('click', 'body', function(e) {
        if ($(e.target).closest('.fixed-sidebar-right,.setting-panel').length > 0) {
            return;
        }
        $('body > .wrapper').removeClass('open-right-sidebar open-setting-panel');
        return;
    });

    $(document).on('show.bs.dropdown', '.nav.navbar-right.top-nav .dropdown', function(e) {
        $wrapper.removeClass('open-right-sidebar open-setting-panel');
        return;
    });

    $(document).on('click', '#setting_panel_btn', function(e) {
        $wrapper.toggleClass('open-setting-panel').removeClass('open-right-sidebar');
        return false;
    });
    $(document).on('click', '#toggle_mobile_nav', function(e) {
        $wrapper.toggleClass('mobile-nav-open').removeClass('open-right-sidebar');
        return;
    });


    $(document).on("mouseenter mouseleave", ".wrapper > .fixed-sidebar-left", function(e) {
        if (e.type == "mouseenter") {

            $wrapper.addClass("sidebar-hover");

        } else {
            $wrapper.removeClass("sidebar-hover");

        }
        return false;
    });

    $(document).on("mouseenter mouseleave", ".wrapper > .setting-panel", function(e) {
        if (e.type == "mouseenter") {
            $wrapper.addClass("no-transition");
        } else {
            $wrapper.removeClass("no-transition");
        }
        return false;
    });
    </script>
    <script>
    function chagnedisplayOrder(id, ival) {
        $.ajax({
            type: "GET",
            url: 'controller.php',
            data: {
                changeDisplayOrder: id,
                ival: ival
            },
            success: function(response) {
                $("#sess_msg").html("Order successfully updated.");
                setTimeout(function() {
                    $("#sess_msg").hide();
                }, 1000);
            }
        });

    }
    </script>
    <script src="js/change-status.js"></script>
</body>

</html>