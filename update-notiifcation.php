<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['reload']="1";
$whr = '';
if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and country_id=$country_id";
}
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
                        <h5 class="txt-dark">Manage Update & Notifications</h5>
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
                            <?php
                                if($_SESSION['level_id'] == 1){
                            ?>
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add
                                        Update & Notifications</a></span></li>
                            <?php } ?>
                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <form action="" id="form_submit" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_ids" class="form-control"
                                    onchange="form_submit()">
                                    <option value="">Select <?=$_REQUEST['country_id'] == 7 ? 'Area' : 'Country'?>
                                    </option>
                                    <?php                       
                                                    $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                                                    while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" name="subit" class="btn btn-primary download_csv_button"
                                    style="width: 170px; height: 40px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                                                            <th>Date</th>
                                                            <th>Country</th>
                                                            <th>Subject</th>
                                                            <th>Body</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Country</th>
                                                            <th>Subject</th>
                                                            <th>Body</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
													$i=1;
                                                    if($_SESSION['level_id'] != 1){
                                                        $whr .= " and status=1";
                                                    }
													$sql=$obj->query("select * from tbl_update_notification where 1=1 $whr order by date desc",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $line->date ?></td>
                                                            <td><?php echo getField('name',$tbl_country,$line->country_id) ?>
                                                            </td>
                                                            <td><?php echo $line->subject ?></td>
                                                            <?php
                                                            $body = $line->body;
                                                            $words = explode(' ', strip_tags($body));
                                                            $short_text = implode(' ', array_slice($words, 0, 50));
                                                            $is_long = count($words) > 50;
                                                            ?>
                                                            <td>
                                                                <span
                                                                    class="short-text"><?php echo $is_long ? $short_text : $body; ?><?php echo $is_long ? '...' : ''; ?></span>

                                                                <?php if ($is_long): ?>
                                                                <span class="full-text"
                                                                    style="display:none;"><?php echo $body; ?></span>
                                                                <a href="javascript:void(0);" class="read-more"
                                                                    onclick="toggleText(this)">Read more</a>
                                                                <?php endif; ?>
                                                            </td>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo 'tbl_update_notification'?>" />
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
                                <input type="hidden" name="id" id="id" value="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                    <h5 class="modal-title" id="exampleModalLabel1">Add State</h5>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>
                                    <span id="err_date" style="color:red;"></span>
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
                                        <label for="recipient-name" class="control-label mb-10">Subject:</label>
                                        <input type="text" class="form-control" id="subject" name="subject">
                                    </div>
                                    <span id="err_subject" style="color:red;"></span>
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
        $("#exampleModalLabel1").html("Add state");
        $("#country_id").val("");
        $("#subject").val("");
        $("#body").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_body").hide();
        $("#err_subject").hide();
        $("#err_date").hide();
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update state");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getUpdateNotifications'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#date").val(response[1]);
                $("#subject").val(response[2]);
                $('#body').summernote('code', response[3]);
                $("#country_id").val(response[4]);
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        var id = $("#id").val();
        date = $("#date").val();
        country_id = $("#country_id").val();
        subject = $("#subject").val();
        body = $("#body").val();
        if (date == '') {
            $("#err_date").show().html("This field is required.");
            return;
        }
        if (country_id == '') {
            $("#err_country_id").show().html("This field is required.");
            return;
        }
        if (subject == '') {
            $("#err_subject").show().html("This field is required.");
            return;
        }
        if (body == '') {
            $("#err_body").show().html("This field is required.");
            return;
        }
        if (id == '') {
            action = 'addUpdateNotification';
        } else {
            action = 'updateUpdateNotification';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'date': date,
                'country_id': country_id,
                'subject': subject,
                'body': body,
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
    $("#date").change(function() {
        $("#err_date").hide();
    })
    $("#country_id").change(function() {
        $("#err_country_id").hide();
    })
    $("#body").keypress(function() {
        $("#err_body").hide();
    })
    $("#subject").keypress(function() {
        $("#err_subject").hide();
    })
    </script>
    <script>
    function form_submit() {
        $("#form_submit").submit();
    }
    </script>

    <script src="js/change-status.js"></script>
    <script>
    function toggleText(el) {
        const td = el.closest('td');
        const shortText = td.querySelector('.short-text');
        const fullText = td.querySelector('.full-text');

        if (fullText.style.display === 'none' || fullText.style.display === '') {
            shortText.style.display = 'none';
            fullText.style.display = 'inline';
            el.textContent = 'Read less';
        } else {
            shortText.style.display = 'inline';
            fullText.style.display = 'none';
            el.textContent = 'Read more';
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        $('#datable_1s').DataTable({
            "ordering": false
        });
    });
    </script>
</body>

</html>