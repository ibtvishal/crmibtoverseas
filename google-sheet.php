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

.material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
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
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
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
						  <h5 class="txt-dark">Manage Google Sheet</h5>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
						  <h5 style="color:#2a911d;" id="sess_msg"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						    <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
						</div>
						<!-- Breadcrumb -->
						<div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
						  <ol class=" breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
							<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Google Sheet</a></span></li>
							
						  </ol>
						</div>
						<!-- /Breadcrumb -->
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
		
							 <form name="frm" method="post" enctype="multipart/form-data">
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Url</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
                                                    <tr>
                                                        <th>Id</th>
														<th>Name</th>
                                                        <th>Url</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>
													<?php
													$i=1;
													$sql=$obj->query("select * from tbl_google_sheet where 1=1",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
													<tr>
														<td><?php echo $line->id ?></td>
														<td><?php echo $line->name ?></td>
														<td><?php echo $line->url ?></td>
														<td>
															<a href="javascript:void(0);"  onclick="getModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
															<a href="javascript:void(0);" onclick="delete_modal(<?php echo $line->id ?>)" class="text-danger"><i class="fa fa-trash" style="margin-right: 6px;font-size: 16px;"></i></a> 
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
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form  method="post" id="addCountry" name="addCountry">
								 <input type="hidden" name="id" id="id" value="">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h5 class="modal-title" id="exampleModalLabel1">Add Google Sheet</h5>
								</div>
								<div class="modal-body">									
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Name:</label>
											<input type="text" class="form-control" id="name" name="name">
										</div>
                                        <span id="err_name" style="color:red;"></span>
										<div class="form-group">
                                            <label for="recipient-name" class="control-label mb-10">Url:</label>
											<input type="text" class="form-control" id="url" name="url">
										</div>
                                        <span id="err_url" style="color:red;"></span>
                                        
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

function ShowModal(){
	$("#exampleModalLabel1").html("Add Google Sheet");
	$("#name").val("");
	$("#url").val("");
	$("#id").val("");
	$("#exampleModal").modal('show');
	$("#err_name").hide();
	$("#err_url").hide();
}
function getModalData(id) 
{	
	$("#exampleModalLabel1").html("Update Google Sheet");
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,type:'getGoogleSheet'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
            response = response.split('##');
            $("#id").val(response[0]);
            $("#name").val(response[1]);
            $("#url").val(response[2]);
          	$("#exampleModal").modal('show');
        }
    });
}

$("#btnSubmit").on("click", function() {
	$(this).attr("disabled","disabled");
    var id = $("#id").val();
    name = $("#name").val();
    url = $("#url").val();
    if(name==''){
	$("#err_name").show().html("This field is required.");
	$(this).removeAttr("disabled","disabled");
	return;
	}
    if(url==''){
	$("#err_url").show().html("This field is required.");
	$(this).removeAttr("disabled","disabled");
	return;
	}
    if(id==''){
    	action='addGoogleSheet';
    }else{
    	action='updateGoogleSheet';    	
    }
	$.ajax({
        type: "POST", 
        url: 'ajax/submitData.php', 
        data: {'id':id,'name':name,'url':url,'action':action}, 
        success: function (response) {
        	if(response==1){
        		$("#exampleModal").modal('hide');
        		location.reload(true);
        	}
        },
    });
});
$("#name").keypress(function(){
$("#err_name").hide();
})
$("#url").keypress(function(){
$("#err_url").hide();
})
</script>
<script>
    function delete_modal(id){
        var r = confirm("Are you sure to delete this record?");
        if (r == true) {
            window.location.href = 'controller.php?delete_google_sheet='+id;
        } else {
            return false;
        }
    }
</script>
<script src="js/change-status.js"></script> 
</body>

</html>