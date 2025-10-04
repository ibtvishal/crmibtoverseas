<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['reload']="1";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.js"></script>

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
                        <h5 class="txt-dark">Manage Incentive Plan</h5>
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
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Incentive Plan</a></span></li>
                        </ol>
                    </div>0
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->


                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <form name="frm" method="post" action="state-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_1s" class="table table-hover display pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Branch</th>
                                                            <th>Body</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Branch</th>
                                                            <th>Body</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
													$i=1;
                                                    $whr = '';
                                                    if($_SESSION['level_id'] != 1){
                                                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                        $whr .= " and branch_id in ($branch_id)";
                                                    }
													$sql=$obj->query("select * from tbl_incentive where 1=1 $whr",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){
                                                        $body = $line->body;
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo getField('name',$tbl_branch,$line->branch_id) ?>
                                                            </td>
                                                            <td><?php echo $line->body ?></td>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="getModalData(<?php echo $line->id ?>)"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>
                                                            </td>
                                                            <?php } ?>
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
                                <input type="hidden" name="id" id="idd" value="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                    <h5 class="modal-title" id="exampleModalLabel1">Add Incentive Plan</h5>
                                </div>

                                <div class="modal-body">
                                    <span id="err_subject" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Branch:</label>
                                        <select name="branch_id" id="branch_id" class="form-control">
                                            <option value="">Select Branch</option>
                                            <?php
                                                    $branchSql = $obj->query("select * from $tbl_branch where status=1");
                                                    while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                            <option value="<?php echo $branchResult->id; ?>"><?php echo $branchResult->name; ?></option>
                                            <?php }?>
                                        </select>
                                        <span id="err_branch_id" style="color:red;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Body:</label>
                                        <textarea class="form-control" id="body" name="body"></textarea>
                                    </div>
                                    <span id="err_body" style="color:red;"></span>
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
    $('textarea#body').summernote({
        placeholder: 'Enter Body',
        tabsize: 2,
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['help', ['help']]
        ],
    });
    </script>
    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add Incentive Plan");
        $("#branch_id").val("");
        $("#body").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_body").hide();
        $("#err_branch_id").hide();
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update Incentive Plan");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getIncentivePlan'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#idd").val(response[0]);
                $('#body').summernote('code', response[1]);
                $("#branch_id").val(response[2]);
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        var id = $("#idd").val();
        body = $("#body").val();
        branch_id = $("#branch_id").val();
         if (branch_id == '') {
            $("#err_branch_id").show().html("This field is required.");
            return;
        }
         if (body == '') {
            $("#err_body").show().html("This field is required.");
            return;
        }
        if (id == '') {
            action = 'addIncentivePlan';
        } else {
            action = 'updateIncentivePlan';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'body': body,
                'branch_id': branch_id,
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
    $("#body").keypress(function() {
        $("#err_body").hide();
    })
    $("#branch_id").change(function() {
        $("#err_branch_id").hide();
    })
    </script>
    <script>
    function form_submit() {
        $("#form_submit").submit();
    }
    </script>

    <script src="js/change-status.js"></script>
    <script>
    $(document).ready(function() {
        $('#datable_1s').DataTable({
            "ordering": false
        });
    });
    </script>
</body>

</html>