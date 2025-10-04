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
                        <h5 class="txt-dark">Manage Question</h5>
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
                                        Question</a></span></li>

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
                                                            <th>Cate ID</th>
                                                            <th>Subcate ID</th>
                                                            <th>Question</th>
                                                            <th>Answer</th>
                                                            <th>Display Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Cate ID</th>
                                                            <th>Subcate ID</th>
                                                            <th>Question</th>
                                                            <th>Answer</th>
                                                            <th>Order</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
													$i=1;
													$sql=$obj->query("select * from $tbl_question where 1=1 order by id desc",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
                                                        <tr>
                                                            <td><?php echo $line->id ?></td>
                                                            <td><?php echo getField('name',$tbl_category,$line->cat_id) ?>
                                                            </td>
                                                            <td><?php echo getField('name','tbl_subcategory',$line->subcat_id) ?>
                                                            </td>
                                                            <td><?php echo $line->question ?></td>
                                                            <td><?php echo $line->answer ?></td>
                                                            <td><input type="text" size="5" maxlength="2"
                                                                    value="<?php echo $line->displayorder ?>"
                                                                    onchange="chagnedisplayOrder(<?php echo $line->id; ?>,this.value)">
                                                            </td>
                                                            <td>
                                                                <div class="material-switch">
                                                                    <input id="someSwitchOptionPrimary<?php echo $i; ?>"
                                                                        type="checkbox" class="chkstatus"
                                                                        value="<?php echo $line->id;?>"
                                                                        <?php echo ($line->status=="1")?'checked':'' ?>
                                                                        data-one="<?php echo $tbl_question?>" />
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

                                                                <a href="question-del.php?id=<?php echo $line->id ?>"
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
                            <form method="post" id="addquestion" name="addquestion">
                                <input type="hidden" name="id" id="id" value="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">×</span></button>
                                    <h5 class="modal-title" id="exampleModalLabel1">Add Question</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Category:</label>
                                        <select name="cat_id" id="cat_id" class="form-control"
                                            onchange="get_subcat('tbl_subcategory',this.value)">
                                            <option value="">Select Category</option>
                                            <?php
												$i=1;
												$csql=$obj->query("select * from $tbl_category where 1=1",$debug=-1);
												while($cline=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cline->id ?>"><?php echo $cline->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Subcategory:</label>
                                        <select name="subcat_id" id="subcat_id" class="form-control">
                                            <option value="">Select Subcategory</option>
                                            <?php
												$i=1;
												$csql=$obj->query("select * from tbl_subcategory where 1=1",$debug=-1);
												while($cline=$obj->fetchNextObject($csql)){?>
                                            <option value="<?php echo $cline->id ?>"><?php echo $cline->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <span id="err_cat_id" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Question:</label>
                                        <input type="text" class="form-control" id="question" name="question">
                                    </div>
                                    <span id="err_question" style="color:red;"></span>
                                    <div class="form-group">
                                        <label for="recipient-name" class="control-label mb-10">Answer:</label>
                                        <textarea class="form-control" id="answer" name="answer"></textarea>
                                    </div>
                                    <!-- <span id="err_answer" style="color:red;"></span> -->
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
    <script>
   (function() {
	var $sumNote = $("#answer")
		.summernote({
			callbacks: {
				onPaste: function(e,x,d) {
					$sumNote.code(($($sumNote.code()).find("font").remove()));
				}
			},

			dialogsInBody: true,
			dialogsFade: true,
			disableDragAndDrop: true,
			disableResizeEditor:true,
			height: "150px",
			tableClassName: function() {
				alert("tbl");
				$(this)
					.addClass("table table-bordered")

					.attr("cellpadding", 0)
					.attr("cellspacing", 0)
					.attr("border", 1)
					.css("borderCollapse", "collapse")
					.css("table-layout", "fixed")
					.css("width", "100%");

				$(this)
					.find("td")
					.css("borderColor", "#ccc")
					.css("padding", "4px");
			}
		})
		.data("summernote");
})();

    </script>
    <script>
    function ShowModal() {
        $("#exampleModalLabel1").html("Add Question");
        $("#subcat_id").val("");
        $("#cat_id").val("");
        $("#question").val("");
        $("#answer").val("");
        $("#id").val("");
        $("#exampleModal").modal('show');
        $("#err_question").hide();
    }

    function getModalData(id) {
        $("#exampleModalLabel1").html("Update Question");
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                type: 'getQuestion'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                response = response.split('##');
                $("#id").val(response[0]);
                $("#subcat_id").val(response[4]);
                $("#cat_id").val(response[1]);
                $("#question").val(response[2]);
                $("#answer").html(CKEDITOR.instances['answer'].setData(response[3]));
                $("#exampleModal").modal('show');
            }
        });

    }

    $("#btnSubmit").on("click", function() {
        $(this).attr("disabled", "disabled");
        var id = $("#id").val();
        cat_id = $("#cat_id").val();
        subcat_id = $("#subcat_id").val();
        if (cat_id == '') {
            $("#err_cat_id").show().html("This field is required.");
            $(this).removeAttr("disabled", "disabled");
            return;
        }
        question = $("#question").val();
        if (question == '') {
            $("#err_question").show().html("This field is required.");
            $(this).removeAttr("disabled", "disabled");
            return;
        }
        var answer = CKEDITOR.instances['answer'].getData();

        if (id == '') {
            action = 'addQuestion';
        } else {
            action = 'updateQuestion';
        }
        $.ajax({
            type: "POST",
            url: 'ajax/submitData.php',
            data: {
                'id': id,
                'cat_id': cat_id,
                'question': question,
                'answer': answer,
                'subcat_id': subcat_id,
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

    $("#cat_id").keypress(function() {
        $("#err_cat_id").hide();
    })
    $("#question").keypress(function() {
        $("#err_question").hide();
    })


    function chagnedisplayOrder(id, ival) {
        $.ajax({
            type: "GET",
            url: 'ajax/getModalData.php',
            data: {
                id: id,
                ival: ival,
                type: 'changeDisplayOrder'
            }, //set data
            beforeSend: function() {},
            success: function(response) {
                $("#sess_msg").html("Order successfully updated.");
                setTimeout(function() {
                    $("#sess_msg").hide();
                }, 1000);
            }
        });
    }
    </script>
    <script>
    function get_subcat(tbl,id) {
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                tbl:tbl,
                id: id
            },
            success: function(data) {
                $("#subcat_id").html(data);
            }
        })
    }

	function chagnedisplayOrder(id,ival) 
{	
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,ival:ival,type:'changequestionDisplayOrder'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
        	$("#sess_msg").html("Order successfully updated.");
        	setTimeout(function(){ $("#sess_msg").hide(); }, 1000);        	
        }
    });

}
    </script>
    <script src="js/change-status.js"></script>
</body>

</html>