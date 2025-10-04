<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.select2-search__field {
    width: 100% !important;
}

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
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Support User</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                                            ?>
                            <!-- <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Support
                                        User</a></span></li> -->
                            <?php } ?>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <form name="frm" method="post" action="user-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_3" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>User Type</th>
                                                            <th>Personal Email</th>
                                                            <th>Phone</th>
                                                            <th>Branch</th>
                                                            <th>Display Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>User Type</th>
                                                            <th>Personal Email</th>
                                                            <th>Phone</th>
                                                            <th>Branch</th>
                                                            <th>Display Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
														$i=1; $whr='';
														$sql=$obj->query("select * from $tbl_support_user where 1=1 and level_id!=1 $whr ORDER BY id DESC ",$debug=-1);
														while($line=$obj->fetchNextObject($sql)){?>
                                                        <?php if ($line->id != 1) {?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo $line->name ?></td>
                                                            <td><?php echo getField('name',$tbl_department,$line->designation) ?></td>
                                                            <td><?=get_user_role($line->level_id, $line->director)?></td>
                                                            <td><?= $line->email ?></td>
                                                            <td><?php echo $line->phone ?></td>
                                                            <td>
                                                                <?php
																	$array=array_map('intval', explode(',',$line->branch_id));
																	$array = implode("','",$array);

                                                                    $sqld=$obj->query("select * from $tbl_branch where 1=1 and id IN ('".$array."')",$debug=-1);//die();
                                                                    while($linew=$obj->fetchNextObject($sqld)){?>
                                                                <?php echo $linew->name;?>
                                                                <br>
                                                                <?php } ?>
                                                            </td>
                                                            <td><input type="text" size="5" maxlength="2" value="<?php echo $line->display_order ?>" onkeyup="chagnedisplayOrder(<?php echo $line->id; ?>,this.value)"></td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_support_user?>" />
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
                                                        </tr>
                                                        <?php } ?>
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
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                                <h5 class="modal-title" id="exampleModalLabel1">Add Support User</h5>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="addUser" name="addUser">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="form-group new-class-width">
                                        <label class="control-label mb-10"><span style="font-weight: 700;">Branch</span>
                                            (You can select multiple)</label>
                                        <select class="form-control select2 brancharr" name="branch_id[]" id="branch_id"
                                            required multiple=""
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                            <?php
                                            $i=1;
                                            $sql=$obj->query("select * from $tbl_branch where status=1",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"><?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <span id="err_branch_id" style="color:red;"></span>
                                    <div class="form-group">
                                        <label class="control-label mb-10">User Department</label>
                                        <select class="form-control" name="designation" id="designation" required>
                                            <option value="">User Department</option>
                                            <?php
                                            $sql=$obj->query("select * from $tbl_department where 1=1",$debug=-1);
                                            while($line=$obj->fetchNextObject($sql)){
                                                ?>
                                                <option value="<?=$line->id?>"><?=$line->name?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span id="err_designation" style="color:red;"></span>
                                    <div class="form-group">
                                        <label class="control-label mb-10">User Type</label>
                                        <select class="form-control" name="level_id" id="level_id" required
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                            <option value="">User Type</option>
                                            <?=get_user_roles()?>
                                        </select>
                                    </div>
                                    <span id="err_level_id" style="color:red;"></span>

                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left"> Name :</label>
                                        <input type="text" class="form-control" placeholder="Name" name="name" id="name"
                                            required
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                    </div>
                                    <span id="err_user_name" style="color:red;"></span>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Personal Email :</label>
                                        <input type="text" class="form-control" placeholder="Email" name="email"
                                            id="email" 
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                    </div>
                                    <span id="err_email" style="color:red;"></span>

                                    <div class="form-group" style="position: relative;">
                                        <label class="control-label mb-10 text-left">Phone :</label>
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"
                                            id="phone" required maxlength="13" minlength="13"
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>

                                    </div>
                                    <span id="err_phone" style="color:red;"></span>
                                    <div id="otpinput"></div>
                                    <span id="err_password" style="color:red;"></span>


                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left"></label>
                                        <button type="button" id="btnSubmit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>


            </div>
        </div>


    </div>


    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script>
    $('#phone').on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;

        $(this).val(formattedNumber);
    });

    $(".select2").select2();
    $(".brancharr").select2({
        placeholder: "Select Branch",
        allowClear: true
    });
    $(".accountmanager").select2({
        placeholder: "Select Admission Executive",
        allowClear: true
    });

    function ShowModal() {

        $("#exampleModalLabel1").html("Add User");
        $("#branch_id").val("");
        $("#level_id").val("");
        $("#name").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#designation").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_user_otp").hide();
        $("#err_user_name").hide();
        $("#err_branch_id").hide();
        $("#err_level_id").hide();
        $("#err_email").hide();
        $("#err_phone").hide();
        $("#err_designation").hide();
        // $(".additional_role").val("");

    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update User");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getSupportUser'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                //console.log(response);
                branchArr = response[1].split(',');

                $(".brancharr").val(branchArr).change();
                datas = '';

                $("#id").val(response[0]);
                $("#level_id").val(response[2]);
                $("#name").val(response[3]);
                $("#email").val(response[4]);
                $("#phone").val(response[5]);
                $("#designation").val(response[6]);


                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        id = $("#id").val();
        branch_id = $(".brancharr").val();
        level_id = $("#level_id").val();
        name = $("#name").val();
        email = $("#email").val();
        phone = $("#phone").val();
        designation = $("#designation").val();


        if (branch_id == '' || branch_id == null) {
            $("#err_branch_id").show().html("This field is required.");
            return;
        }
        if (level_id == '' || level_id == null) {
            $("#err_level_id").show().html("This field is required.");
            return;
        }
        if (name == '') {
            $("#err_user_name").show().html("This field is required.");
            return;
        }
        // if (email == '') {
        //     $("#err_email").show().html("This field is required.");
        //     return;
        // }
        if (phone == '') {
            $("#err_phone").show().html("This field is required.");
            return;
        }
        if (designation == '') {
            $("#err_designation").show().html("This field is required.");
            return;
        }

        if (id == '') {
            action = 'addSupportUser';
        } else {
            action = 'updateSupportUser';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'branch_id': branch_id,
                'level_id': level_id,
                'name': name,
                'email': email,
                'phone': phone,
                'designation': designation,
                'action': action
            },
            success: function(response) {
                if (response == 1) {
                    $("#exampleModal").modal('hide');
                    location.reload(true);
                }
            },
        });
    });


    $("#name").keypress(function() {
        $("#err_user_name").hide();
    })
    $(".otp").keypress(function() {
        $("#err_user_otp").hide();
    })
    $("#branch_id").change(function() {
        $("#err_branch_id").hide();
    })
    $("#level_id").change(function() {
        $("#err_level_id").hide();
    })
    $("#email").keypress(function() {
        $("#err_email").hide();
    })
    $("#phone").keypress(function() {
        $("#err_phone").hide();
    })
    $("#designation").keypress(function() {
        $("#err_designation").hide();
    })
    </script>
    <script>
    function chagnedisplayOrder(id,val) {
     
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                chagnedisplayOrderSupportUser: id,
                val: val
            },
            success: function(response) {

            },
        });
    }
    </script>
    <script src="js/change-status.js"></script>
</body>


</html>