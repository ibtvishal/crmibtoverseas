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
                        <h5 class="txt-dark">Manage User</h5>
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
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add
                                        User</a></span></li>
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
                                                            <th>Designation</th>
                                                            <th>Personal Email</th>
                                                            <th>Additional Role</th>
                                                            <th>Phone</th>
                                                            <th>Branch</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                                            ?>
                                                            <th>Passcode</th>
                                                            <th>Status</th>
                                                            <th>Management Status</th>
                                                            <?php } ?>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Designation</th>
                                                            <th>Personal Email</th>
                                                            <th>Additional Role</th>
                                                            <th>Phone</th>
                                                            <th>Branch</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                                            ?>
                                                            <th>Passcode</th>
                                                            <th>Status</th>
                                                            <th>Management Status</th>
                                                            <?php } ?>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
														$i=1; $whr='';
														if(!empty($_REQUEST['level_id'])){
															$whr = "and level_id='".base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))."'";
														}
                                                        $addtional_role = explode(',',$_SESSION['additional_role']);
                                                        if(isset($_GET['account']) ||in_array(8,$addtional_role)){
                                                            $whr = ' and level_id=2';
                                                        }
														$sql=$obj->query("select * from $tbl_admin where 1=1 and level_id!=1 $whr ORDER BY id DESC ",$debug=-1);
														while($line=$obj->fetchNextObject($sql)){?>
                                                        <?php if ($line->id != 1) {?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo $line->name ?></td>
                                                            <td><?=get_user_role($line->level_id, $line->director)?>
                                                            </td>
                                                            <td><?php echo $line->email ?></td>
                                                            <td>
                                                                <?php
																	$arr = explode(',',$line->additional_role);
                                                                    foreach($arr as $a){
                                                                        echo get_additional_role($a).'<br>';
                                                                    }
                                                                    ?>
                                                                <?php echo $linew->name;?>
                                                                <br>
                                                            </td>
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
                                                            <?php
                                                            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                                            ?>
                                                            <td><?php echo $line->passcode ?></td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_admin?>" />
                                                                    <label
                                                                        for="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if($line->level_id == 19){
                                                                ?>
                                                                <div class="material-switch">
                                                                    <input
                                                                        id="someSwitchOptionPrimarys<?php echo $i; ?>"
                                                                        type="checkbox"
                                                                        onchange="chagne_management_member_status(this)"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->management_member=="1")?'checked':'' ?> />
                                                                    <label
                                                                        for="someSwitchOptionPrimarys<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                                <?php } ?>
                                                            </td>
                                                            <?php } ?>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="getModalData(<?php echo $line->id ?>)"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>
                                                                <!-- <a href="user-del.php?id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
	                                                                    border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a>  -->
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
                                <h5 class="modal-title" id="exampleModalLabel1">Add User</h5>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="addUser" name="addUser">
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="form-group new-class-width">
                                        <label class="control-label mb-10"><span style="font-weight: 700;">Branch</span>
                                            (You can select multiple)</label>
                                        <select class="form-control select2 brancharr" name="branch_id[]" id="branch_id"
                                            required multiple="" onchange="get_account_manager()"
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
                                        <label class="control-label mb-10">User Type</label>
                                        <select class="form-control" name="level_id" id="level_id" required
                                            onchange="get_account_manager()"
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                            <option value="">User Type</option>
                                            <?=get_user_roles()?>
                                        </select>
                                    </div>
                                    <div class="form-group" id="director_show" style="display:none">
                                        <label class="control-label mb-10 text-left">As a Director</label>
                                        <input type="checkbox" name="director" id="director" value="1">
                                    </div>
                                    <div class="form-group" id="reapply_counsellor_show" style="display:none">
                                        <label class="control-label mb-10 text-left">Retake Counsellor</label>
                                        <input type="checkbox" name="reapply_counsellor" id="reapply_counsellor"
                                            value="1">
                                    </div>
                                    <span id="err_level_id" style="color:red;"></span>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left"> Name :</label>
                                        <input type="text" class="form-control" placeholder="Name" name="name" id="name"
                                            required <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                    </div>
                                    <span id="err_user_name" style="color:red;"></span>
                                    <!-- <div class="form-group">
                                        <label class="control-label mb-10 text-left"> User Name :</label>
                                        <input type="text" class="form-control" placeholder="User Name" name="username" id="username" required>
                                        </div> -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Personal Email :</label>
                                        <input type="text" class="form-control" placeholder="Email" name="email"
                                            id="email" required <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                    </div>
                                    <span id="err_email" style="color:red;"></span>

                                    <div class="form-group" style="position: relative;">
                                        <label class="control-label mb-10 text-left">Phone :</label>
                                        <input type="text" class="form-control" placeholder="Phone" name="phone"
                                            id="phone" required maxlength="13" minlength="13"
                                            <?=$_SESSION['level_id'] != 1 && $_SESSION['level_id'] != 25 ? 'disabled' : ''?>>
                                        <!--<a href="javascript:void(0);" class="btn btn-sm btn-primary otp-new-button" onclick="SendOtp();">Send OTP</a>-->

                                    </div>
                                    <span id="err_phone" style="color:red;"></span>
                                    <div id="otpinput"></div>



                                    <!-- <div class="form-group">
                                    <label class="control-label mb-10 text-left">Passcode :</label>
                                    <input type="text" class="form-control" placeholder="Password" name="password" id="password"  required>
                                    </div> -->
                                    <span id="err_password" style="color:red;"></span>

                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">Additional Role :</label>
                                        <?php
                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                        ?>
                                        <input type="checkbox" name="additional_role" id="additional_role1" value="1"
                                            class="additional_role"><label style="margin-left:5px;">Front Desk</label>
                                        <input type="checkbox" name="additional_role" id="additional_role4" value="4"
                                            class="additional_role"><label style="margin-left:5px;">CRM Review
                                            Manager</label>
                                        <?php } ?>
                                        <input type="checkbox" name="additional_role" id="additional_role2" value="2"
                                            class="additional_role" onchange="get_account_manager()"><label
                                            style="margin-left:5px;">Admission Review Manager</label>
                                        <?php
                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25){
                                        ?>
                                        <input type="checkbox" name="additional_role" id="additional_role3" value="3"
                                            class="additional_role"><label style="margin-left:5px;">Slot
                                            Executive</label>
                                        <input type="checkbox" name="additional_role" id="additional_role5" value="5"
                                            class="additional_role"><label style="margin-left:5px;">Branch
                                            Manager</label>
                                        <input type="checkbox" name="additional_role" id="additional_role6" value="6"
                                            class="additional_role"><label style="margin-left:5px;">Accountant</label>
                                        <input type="checkbox" name="additional_role" id="additional_role7" value="7"
                                            class="additional_role"><label style="margin-left:5px;">Auditor</label>
                                        <input type="checkbox" name="additional_role" id="additional_role8" value="8"
                                            class="additional_role"><label style="margin-left:5px;">Admission Review
                                            Admin</label>
                                        <input type="checkbox" name="additional_role" id="additional_role9" value="9"
                                            class="additional_role"><label style="margin-left:5px;">NOC Review
                                            Manager</label>
                                        <input type="checkbox" name="additional_role" id="additional_role10" value="10"
                                            class="additional_role"><label style="margin-left:5px;">Immegration Trainner</label>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group new-class-width" id="account_manager_show"
                                        style="display:none">
                                        <label class="control-label mb-10"><span style="font-weight: 700;">Account
                                                Manage</span> (You can select multiple)</label>
                                        <select class="form-control select2 accountmanager" name="account_manager[]"
                                            id="get_account_managers" multiple="">

                                        </select>
                                    </div>
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
    function get_account_manager() {
        check = document.getElementById('additional_role2');
        val = $("#branch_id").val();
        level_id = $("#level_id").val();
        if (level_id == '22') {
            $("#additional_role2").prop('checked', true);
        } else {
            // $("#additional_role2").prop('checked',false);
        }
        if ((check.checked == true && val != null && level_id == '2') || level_id == '22') {
            $.ajax({
                method: 'post',
                url: "controller.php",
                data: {
                    account_manage: val
                },
                success: function(data) {
                    $("#get_account_managers").html(data);
                    $("#account_manager_show").show();
                }
            })
        } else {
            $("#get_account_managers").val('');
            $("#get_account_managers").html('');
            $("#account_manager_show").hide();
        }
        if (level_id == 4) {
            $("#reapply_counsellor_show").show();
        } else {
            $("#reapply_counsellor_show").hide();
            $("#reapply_counsellor").prop("checked", false);
        }
        if (level_id == 19) {
            $("#director_show").show();
        } else {
            $("#director_show").hide();
            $("#director").prop("checked", false);
        }
    }
    </script>
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
        $("#username").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#id").val("");
        $("#reapply_counsellor_show").hide();
        $("#reapply_counsellor").prop("checked", false);
        $("#director_show").hide();
        $("#director").prop("checked", false);
        $("#exampleModal").modal('show');
        $("#err_user_otp").hide();
        $("#err_user_name").hide();
        $("#err_branch_id").hide();
        $("#err_level_id").hide();
        $("#err_email").hide();
        $("#err_phone").hide();
        // $(".additional_role").val("");

    }

    function getModalData(id) {
    $("#exampleModalLabel1").html("Update User");

    $.ajax({
        type: "GET",
        url: 'ajax/getModalData.php',
        data: {
            id: id,
            type: 'getUser'
        },
        beforeSend: function() {
            console.log("Fetching user data...");
        },
        success: function(response) {
            response = response.split('##');
            console.log("Response received:", response);

            let branchArr = response[1].split(',');
            $(".brancharr").val(branchArr).change();

            // ✅ Clear previous Account Manager data
            $("#get_account_managers").html('');
            let accountRequests = [];
            let accountHtml = "";

            // ✅ Handle Account Manager Section
            if (response[9] !== '') {
                $("#account_manager_show").show();
                let accounts = response[9].split(',');

                accounts.forEach(acc => {
                    let request = $.post('controller.php', { get_account: acc })
                        .done(res => {
                            console.log(`Response for account ${acc}:`, res);
                            accountHtml += res; // Store responses in a variable
                        })
                        .fail((jqXHR, textStatus, errorThrown) => {
                            console.error(`Error fetching account ${acc}:`, textStatus, errorThrown);
                        });

                    accountRequests.push(request);
                });
            } else {
                $("#get_account_managers").val('').html('');
                $("#account_manager_show").hide();
            }

            // ✅ Populate Form Fields
            $("#id").val(response[0]);
            $("#level_id").val(response[2]);
            $("#name").val(response[3]);
            $("#username").val(response[4]);
            $("#email").val(response[5]);
            $("#phone").val(response[6]);

            if (response[2] == 4) {
                $("#reapply_counsellor_show").show();
                $("#reapply_counsellor").prop("checked", response[10] == 1);
            } else {
                $("#reapply_counsellor_show").hide();
                $("#reapply_counsellor").prop("checked", false);
            }

            if (response[2] == 19) {
                $("#director_show").show();
                $("#director").prop("checked", response[11] == 1);
            } else {
                $("#director_show").hide();
                $("#director").prop("checked", false);
            }

            // ✅ Handle Additional Roles
            let additional_roles = response[8].split(',');
            $(".additional_role").prop("checked", false); // Reset all checkboxes
            additional_roles.forEach(role => {
                if (role) {
                    $('#additional_role' + role).prop('checked', true);
                }
            });

            // ✅ Ensure all AJAX requests complete before updating the DOM
            Promise.all(accountRequests).then(() => {
                $("#get_account_managers").html(accountHtml); // Update the DOM once all requests complete
                console.log("All account managers loaded. Showing modal...");
                $("#exampleModal").modal('show');
            }).catch(err => {
                console.error("Error loading account managers:", err);
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
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
        account_manager = $("#get_account_managers").val();

        let additional_role = [];
        $("input:checkbox[name=additional_role]:checked").each(function() {
            additional_role.push($(this).val());
        });

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

        review_manager = document.getElementById('additional_role2');
        if (review_manager.checked) {
            review_manager_status = 1;
        } else {
            review_manager_status = 0;
        }
        check = document.getElementById('reapply_counsellor');
        if (check.checked) {
            reapply_counsellor = 1;
        } else {
            reapply_counsellor = 0;
        }
        director_c = document.getElementById('director');
        if (director_c.checked) {
            director = 1;
        } else {
            director = 0;
        }
        if (id == '') {
            action = 'addUser';
        } else {
            action = 'updateUser';
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
                'additional_role': additional_role,
                'account_manager': account_manager,
                'reapply_counsellor': reapply_counsellor,
                'director': director,
                'review_manager_status': review_manager_status,
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

    function SendOtp() {
        phone = $("#phone").val();
        action = 'SendOtp';
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'phone': phone,
                'action': action
            },
            success: function(response) {
                $("#otpinput").html(response);
            },
        });
    }
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
    </script>
    <script>
    function chagne_management_member_status(val) {
        if (val.checked == true) {
            status = 1;
        } else {
            status = 0;
        }
        id = val.value;
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                chagne_management_member_status: id,
                status: status
            },
            success: function(response) {},
        });
    }
    </script>
    <script src="js/change-status.js"></script>
</body>


</html>