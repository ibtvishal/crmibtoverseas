<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css">
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
                        <h5 class="txt-dark">Manage Event</h5>
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
                            <li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add
                                        Event</a></span></li>

                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <form name="frm" method="post" action="question-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_3" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Event Date</th>
                                                            <th>Event Time</th>
                                                            <th>Title</th>
                                                            <th>Link</th>
                                                            <th>Link Label</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Event Date</th>
                                                            <th>Event Time</th>
                                                            <th>Title</th>
                                                            <th>Link</th>
                                                            <th>Link Label</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
										$i=1;
										$sql=$obj->query("select * from $tbl_event where 1=1 order by id desc",$debug=-1);
										while($line=$obj->fetchNextObject($sql)){?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo $line->event_date; ?></td>
                                                            <td><?php echo $line->event_time; ?></td>
                                                            <td><?php echo $line->title; ?></td>
                                                            <td><a href="<?php echo $line->link; ?>"><?php echo $line->link; ?></a></td>
                                                            <td><?php echo $line->link_label; ?></td>

                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_event?>" />
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

                                                                <a href="controller.php?event_delete_id=<?php echo $line->id ?>"
                                                                    value="Delete" type="submit" class="delete_button"
                                                                    onclick="return confirm('Are you sure you want to delete record(s)')"
                                                                    style=" background: transparent;
												border: none;"><i class="fa fa-trash" style="margin-right: 6px;font-size: 16px;"></i> </a>
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
                        <div class="modal-content" style="width: 800px;">
                            <form method="post" id="addquestion" name="addquestion" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" value="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                    <h5 class="modal-title" id="exampleModalLabel1">Add Event</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Event Date:</label>
                                        <input type="date" class="form-control" id="event_date" name="event_date">
                                    </div>
                                    <span id="err_event_date" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Event Time:</label>
                                        <input type="time" class="form-control" id="event_time" name="event_time">
                                    </div>
                                    <span id="err_event_time" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Title:</label>
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                    <span id="err_title" style="color:red;"></span>
                                    <!-- <div class="form-group">
                            <label for="recipient-name" class="control-label mb-10">Image:</label>

                            <input type="hidden" name="old_image" id="old_image" value="">
                            <input type="file" class="form-control" id="img" name="img">
                            <span id="imagePreview"></span>
                        </div> -->
                                    <span id="err_question" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Description: (Max Characters: 400)</label>
                                        <textarea class="form-control" id="description" name="description" maxlength="400"></textarea>
                                    </div>
                                    <span id="err_description" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Link:</label>
                                        <input type="text" class="form-control" id="link" name="link">
                                    </div>
                                    <span id="err_link" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Link Label:</label>
                                        <input type="text" class="form-control" id="link_label" name="link_label">
                                    </div>
                                    <span id="err_link_label" style="color:red;"></span>
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
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <script>
    // $(document).ready(function() {
    //     // Replace the <textarea> with a CKEditor instance
    //     CKEDITOR.replace('description');
    // });
    
    </script>
    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add Event");
        $("#event_date").val("");
        $("#event_time").val("");
        $("#link").val("");
        $("#link_label").val("");
        $("#title").val("");
        $("#img").val("");
        $("#description").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_title").hide();
    }

    function getModalData(id) {

        $("#exampleModalLabel1").html("Update Event");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'Events1'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#title").val(response[1]);
                $("#event_date").val(response[4]);
                $("#event_time").val(response[5]);
                $("#link").val(response[6]);
                $("#link_label").val(response[7]);
                // $("#old_image").val(response[2]);
                // $("#imagePreview").html(`<img src="uploads/event/${response[2]}" alt="Image" class="img-fluid" style="width: 100px; height: 100px;"/>`);
                $("#description").html(response[3]);
                $("#exampleModal").modal('show');
            }
        });

    }


    $("#btnSubmit").on("click", function() {
        var form = document.getElementById("addquestion");
        var formData = new FormData(form);
        var id = $("#id").val();
        var action = (id === '') ? 'addEvent' : 'updateEvent';

        formData.append('action', action);

        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == 1) {
                    $("#exampleModal").modal('hide');
                    location.reload(true);
                } else {
                    alert("Error: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });



    $("#title").keypress(function() {
        $("#err_err_title").hide();
    })
    $("#description").keypress(function() {
        $("#err_description").hide();
    })
    </script>
    <script src="js/change-status.js"></script>
</body>

</html>