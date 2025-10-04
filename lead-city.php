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
                        <h5 class="txt-dark">Manage District</h5>
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
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add
                            District</a></span></li>

                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">

                            <form name="frm" method="post" action="controller.php" enctype="multipart/form-data">
                                <div class="row">
									<?php
									if(isset($_GET['transfer'])){
									?>
                                    <div class="col-md-3" style="margin-top: 10px;">
                                        <select name="transfer_to" id="transfer_to" class="form-control" required>
                                            <option value="">Select Transfer To District</option>
                                            <?php
												$i=1;
												$sql=$obj->query("select * from $tbl_location_cities where 1=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){ ?>
                                            <option value="<?=$line->id?>">(<?=$line->id?>) <?=$line->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
									<?php } ?>
									<div class="col-md-4" style="margin-top: 10px;">
									<?php
									if(isset($_GET['transfer'])){
									?>
										<button type="submit" class="btn btn-primary" name="btn_city_transfer">Transfer</button>
										<?php }else{ ?>
									<button type="submit" class="btn btn-danger" name="btn_city_delete">Delete</button>
									<?php } ?>
									</div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="ApplicationList" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Check</th>
                                                            <th>Id</th>
                                                            <th>State Name</th>
                                                            <th>District Name</th>
                                                            <th>Data</th>
                                                            <th>Status</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Check</th>
                                                            <th>Id</th>
                                                            <th>State Name</th>
                                                            <th>District Name</th>
                                                            <th>Data</th>
                                                            <th>Status</th>
                                                            <th>Action</th>

                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

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
                                    <h5 class="modal-title" id="exampleModalLabel1">Add State</h5>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">State:</label>
                                        <select class="form-control" name="state_id" id="state_id" required>
                                            <option value="">--Select Country--</option>
                                            <?php
												$i=1;
												$sql=$obj->query("select * from $tbl_location_states where status=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($result->country_id==$line->id){?>selected<?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="err_country_id" style="color:red;"></span>

                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">District Name:</label>
                                        <input type="text" class="form-control" id="city_name" name="city_name">
                                    </div>

                                    <span id="err_state_name" style="color:red;"></span>
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
    <script src="js/change-status.js"></script>
    <script>
    $("#transfer_to").select2({});
    </script>
    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add District");
        $("#state_id").val("");
        $("#city_name").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_state_name").hide();
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update District");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getcity'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#state_id").val(response[1]);
                $("#city_name").val(response[2]);
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        var id = $("#id").val();
        state_id = $("#state_id").val();
        city_name = $("#city_name").val();
        if (state_id == '') {
            $("#err_country_id").show().html("This field is required.");
            return;
        }
        if (city_name == '') {
            $("#err_state_name").show().html("This field is required.");
            return;
        }
        if (id == '') {
            action = 'addcity';
        } else {
            action = 'updatecity';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'name': city_name,
                'state_id': state_id,
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

    <script>
    var dataTable = $('#ApplicationList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1]
            }
        ],
        "ajax": {
            url: "lead-city-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        }
    })
    </script>
    <script>
    function change_status(val, id) {
        if (val.checked) {
            status = 1;
        } else {
            status = 0;
        }

        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                'change_city_status_id': id,
                'status': status
            },
            success: function(response) {

            },
        });
    }
    </script>


</body>

</html>