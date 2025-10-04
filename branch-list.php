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
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
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
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <h5 class="txt-dark">Manage Branch</h5>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-3 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#" onclick="ShowModal();">Add
                                        Branch</a></span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <form name="frm" method="post" action="branch-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_1" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Code</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Address</th>
                                                            <th>Billing Name</th>
                                                            <th>State</th>
                                                            <th>State Code</th>
                                                            <th>GST</th>
                                                            <th>Approval Members</th>
                                                            <th>Franchise Bill</th>
                                                            <th>Status</th>
                                                            <th>Insentive</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Code</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Address</th>
                                                            <th>Billing Name</th>
                                                            <th>State</th>
                                                            <th>State Code</th>
                                                            <th>GST</th>
                                                            <th>Approval Members</th>
                                                            <th>Franchise Bill</th>
                                                            <th>Status</th>
                                                            <th>Insentive</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
														$i=1;
														$sql=$obj->query("select * from $tbl_branch where 1=1",$debug=-1);
														while($line=$obj->fetchNextObject($sql)){?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo $line->branch_code ?></td>
                                                            <td><?php echo $line->name ?></td>
                                                            <td><?php echo $line->email ?></td>
                                                            <td><?php echo $line->phone ?></td>
                                                            <td><?php echo $line->address ?></td>
                                                            <td><?php echo $line->billing_name ?></td>
                                                            <td><?php echo $line->state ?></td>
                                                            <td><?php echo $line->state_code ?></td>
                                                            <td><?php echo $line->gst ?></td>
                                                            <td><?php echo $line->approval_members ?></td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary1<?php echo $i; ?>"
                                                                        type="checkbox" onchange="change_frachise(this, <?php echo $line->id;?>)"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->franchise_bill=="1")?'checked':'' ?> />
                                                                    <label
                                                                        for="someSwitchOptionPrimary1<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_branch?>" />
                                                                    <label
                                                                        for="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        class="label-primary"></label>
                                                                </div>
                                                            </td>
                                                            <td><a href="javascript:void" class="btn btn-success"
                                                                    onclick="insentive(<?=$line->id?>)">Insentive</a>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="getModalData(<?php echo $line->id ?>)"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>
                                                                <!-- 	<a href="branch-del.php?id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a>  -->
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

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                                <h5 class="modal-title" id="exampleModalLabel1">Add Branch</h5>
                            </div>
                            <form method="post" id="addBranch" name="addBranch">
                                <input type="hidden" name="id" id="id" value="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="branch_code" class="control-label mb-10">Code:</label>
                                        <input type="text" class="form-control" name="branch_code" id="branch_code">
                                    </div>
                                    <span id="err_branch_code" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Name:</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                    <span id="err_name" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Email:</label>
                                        <input type="text" class="form-control" name="email" id="email">
                                    </div>
                                    <span id="err_email" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Phone:</label>

                                        <input type="text" class="form-control" placeholder="Phone" name="phone"
                                            id="phone" required maxlength="13" minlength="13">

                                    </div>
                                    <span id="err_phone" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Billing Name:</label>
                                        <input type="text" class="form-control" name="billing_name" id="billing_name">
                                    </div>
                                    <span id="err_billing_name" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Address:</label>
                                        <input type="text" class="form-control" name="address" id="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">State:</label>
                                        <input type="text" class="form-control" name="state" id="state">
                                        <span id="err_state" style="color:red;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">State Code:</label>
                                        <input type="text" class="form-control" name="state_code" id="state_code">
                                        <span id="err_state_code" style="color:red;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">GST:</label>
                                        <input type="text" class="form-control" name="gst" id="gst">
                                    </div>
                                    <span id="err_gst" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="approval_members" class="control-label mb-10">Approval
                                            Members:</label>
                                        <input type="text" class="form-control" name="approval_members"
                                            id="approval_members">
                                    </div>
                                    <div class="form-group new-class-width hideclass">
                                        <label for="recipient-name" class="control-label mb-10">User Type:</label>
                                        <select class="form-control select2 user_types" multiple name="user_roles[]"
                                            id="user_roles" <?=$_SESSION['level_id'] != 1 ? 'disabled' : ''?>
                                            onchange="change_team(this.value)">
                                            <?=get_user_roles()?>
                                        </select>
                                    </div>
                                    <div class="form-group new-class-width hideclass">
                                        <label for="recipient-name" class="control-label mb-10">Select Team
                                            Member:</label>
                                        <select class="form-control select2 team_member" multiple name="users[]"
                                            id="users" <?=$_SESSION['level_id'] != 1 ? 'disabled' : ''?>>
                                            <?php
                                               $get = $obj->query("select * from $tbl_support_user where  status=1",-1);
                                               while($res = $obj->fetchNextObject($get)){
                                                   ?><option value='<?=$res->id?>'><?=$res->name?>
                                                (<?=get_user_role($res->level_id, $res->director)?>)</option><?php
                                               }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <span id="err_address" style="color:red;"></span>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="btnSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal" id="insentive" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl" role="document" style="width: 1200px; height: 500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Insentive </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="controller.php" method="post">
                                    <input type="hidden" name="branch_id" id="branch_id">
                                    <div id="show_data">
                                        
                                    </div>
                                    <button type="submit" name="insentive_submit" class="btn btn-success mt-20">Submit</button>
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
    $(".user_types").select2({
        placeholder: "Select Types",
        allowClear: true
    });
    $("#users").select2({
        placeholder: "Select Team Members",
        allowClear: true
    });
    </script>
    <script>
    $('#phone').on('input', function() {
        const phoneNumber = $(this).val();
        const numericOnly = phoneNumber.replace(/\D/g, '');
        const limitedNumber = numericOnly.slice(0, 14);
        const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;
        $(this).val(formattedNumber);
    });

    function ShowModal() {
        $("#exampleModalLabel1").html("Add Branch");
        $(".hideclass").hide();
        $("#user_roles").val([]);
        $("#users").val([]);
        $("#branch_code").val("");
        $("#name").val("");
        $("#email").val("");
        $("#phone").val("");
        $("#address").val("");
        $("#state").val("");
        $("#state_code").val("");
        $("#billing_name").val("");
        $("#gst").val("");
        $("#id").val("");
        $("#approval_members").val("");
        $("#err_name").hide();
        $("#err_gst").hide();
        $("#err_billing_name").hide();
        $("#err_email").hide();
        $("#err_phone").hide();
        $("#err_address").hide();
        $("#err_state").hide();
        $("#err_state_code").hide();
        $("#exampleModal").modal('show');
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update Branch");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getBranch'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $(".hideclass").show();
                $("#id").val(response[0]);
                $("#name").val(response[1]);
                $("#address").val(response[2]);
                $("#phone").val(response[3]);
                $("#email").val(response[4]);
                $("#gst").val(response[5]);
                $("#branch_code").val(response[6]);
                $("#billing_name").val(response[7]);
                $("#approval_members").val(response[8]);
                $("#state").val(response[9]);
                $("#state_code").val(response[10]);
                user_roles = response[11].split(',');
                usersw = response[12].split(',');

                $("#user_roles").select2('destroy').val(user_roles).select2();
                $("#users").select2('destroy').val(usersw).select2();
                $("#exampleModal").modal('show');
            }
        });
    }
    $("#btnSubmit").on("click", function() {
        id = $("#id").val();
        name = $("#name").val();
        email = $("#email").val();
        phone = $("#phone").val();
        address = $("#address").val();
        gst = $("#gst").val();
        branch_code = $("#branch_code").val();
        billing_name = $("#billing_name").val();
        approval_members = $("#approval_members").val();
        state = $("#state").val();
        state_code = $("#state_code").val();

        if (branch_code == '') {
            $("#err_branch_code").show().html("This field is required.");
            return;
        }
        if (name == '') {
            $("#err_name").show().html("This field is required.");
            return;
        }
        if (email == '') {
            $("#err_email").show().html("This field is required.");
            return;
        }
        if (phone == '') {
            $("#err_phone").show().html("This field is required.");
            return;
        }
        if (address == '') {
            $("#err_address").show().html("This field is required.");
            return;
        }
        if (state == '') {
            $("#err_state").show().html("This field is required.");
            return;
        }
        if (state_code == '') {
            $("#err_state_code").show().html("This field is required.");
            return;
        }
        if (gst == '') {
            $("#err_gst").show().html("This field is required.");
            return;
        }
        if (billing_name == '') {
            $("#err_billing_name").show().html("This field is required.");
            return;
        }
        if (id == '') {
            action = 'addBranch';
        } else {
            action = 'updateBranch';
        }
        var select = document.getElementById("user_roles");
        var selectedValues = [];
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].selected) {
                selectedValues.push(select.options[i].value);
            }
        }
        var selectedValuesString = selectedValues.join(',');


        var select1 = document.getElementById("users");
        var selectedValues1 = [];
        for (var i = 0; i < select1.options.length; i++) {
            if (select1.options[i].selected) {
                selectedValues1.push(select1.options[i].value);
            }
        }
        var selectedValuesString1 = selectedValues1.join(',');
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'name': name,
                'email': email,
                'phone': phone,
                'address': address,
                'gst': gst,
                'branch_code': branch_code,
                'billing_name': billing_name,
                'approval_members': approval_members,
                'state_code': state_code,
                'state': state,
                'user_roles': selectedValuesString,
                'users': selectedValuesString1,
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
        $("#err_name").hide();
    })
    $("#email").keypress(function() {
        $("#err_email").hide();
    })
    $("#phone").keypress(function() {
        $("#err_phone").hide();
    })
    $("#address").keypress(function() {
        $("#err_address").hide();
    })
    </script>
    <script>
    function change_team() {
        var select = document.getElementById("user_roles");
        branch_id = $("#id").val();
        var selectedValues = [];
        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].selected) {
                selectedValues.push(select.options[i].value);
            }
        }
        var selectedValuesString = selectedValues.join(',');


        var select1 = document.getElementById("users");
        var selectedValues1 = [];
        for (var i = 0; i < select1.options.length; i++) {
            if (select1.options[i].selected) {
                selectedValues1.push(select1.options[i].value);
            }
        }
        var selectedValuesString1 = selectedValues1.join(',');
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                'users': selectedValuesString1,
                'get_team_member': selectedValuesString,
                'branch_id': branch_id,
            },
            success: function(data) {
                $("#users").html(data);
            },
        });
    }
    </script>
    <script>
    function insentive(id) {
        $("#insentive").modal('show');
        $("#branch_id").val(id);
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                insentive_branch_id: id
            },
            success: function(data) {
                $("#show_data").html(data);
            }
        })
    }
    </script>
   
    <script>
    function change_frachise(val,id) {
        if(val.checked == true){
            status = 1;
        }else{
            status = 0;
        }
        $.ajax({
            method: "post",
            url: "controller.php",
            data: {
                frachise_branch_id: id,
                status: status
            },
            success: function(data) {
                $("#show_data").html(data);
            }
        })
    }
    </script>
   
    <script src="js/change-status.js"></script>
</body>

</html>