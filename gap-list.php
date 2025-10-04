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
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">Manage Gap</h5>
					</div>

					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-left">
						  <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						    <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
						</div>
						<form class="form-horizontal form_csv" action="csv.php" method="post" name="upload_excel"   
						enctype="multipart/form-data" style="">

						<input  type='file' name='file'    class="manage_upload_button">
					</br>
					<input type='submit' name='gapImport' value='Submit' class="btn  upload_csv_button" style="font-size: 13px;padding: 6px 10px 6px 10px;border-radius: 7px;">

				</form> 
				<form class="form-horizontal form_csv_download" action="download_csv.php?table_name=tbl_gap&amp;p=gap-list" method="post" name="upload_excel" enctype="multipart/form-data"  style="">
					<div class="row">

						<div class="col-md-4 col-6">
							<input type="submit" name="GapList" class="btn btn-primary download_csv_button" value="Download CSV">
						</div>
					</div>                    
				</form> 
			<!-- Breadcrumb -->
			<div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="welcome.php">Dashboard</a></li>
					<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Gap</a></span></li>
				</ol>
			</div>
			<!-- /Breadcrumb -->
		</div>
		<!-- /Title -->

		<!-- Row -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default card-view">

<form name="frm" method="post" action="programmes-del.php" enctype="multipart/form-data">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<div class="table-wrap">
				<div class="table-responsive">
					<table id="gapList" class="table table-hover display  pb-30" >
						<thead>
							<tr>
								<th>Id</th>
								<th>Qualification</th>
								<th>Stream</th>
								<th>Gap</th>
								<th>Preferred Course</th>
								<th>Diploma Name</th>
								<th>Diploma Duration</th>
								<th>Designation</th>
								<th>Exp. Duration</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
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
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h5 class="modal-title" id="exampleModalLabel1">Add Gap</h5>
			</div>
			<div class="modal-body">
				<form  method="post" id="addProgrammes" name="addgap">
					<input type="hidden" name="id" id="id" value="">

					<div class="row">
					

						
					
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Qualification :</label>
								
									<select class="form-control" name="qualification" id="qualification" required>
												<option value="">--Select Qualification--</option>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_qualification where 1=1 and status=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
												<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
												<?php } ?>
											</select>
								<span id="err_qualification" style="color:red;"></span>
							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Stream :</label>
								<input type="text" class="form-control" name="stream" id="stream" required>
								<span id="err_stream" style="color:red;"></span>
							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Gap :</label>
							
									<select class="form-control" name="gap" id="gap" required>
												<option value="">--Select Gap--</option>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_manage_gap where 1=1 and status=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){
													$gname = number_format($line->name/12,2); 
													$gArr = explode('.', $gname);
													$gyear = $gArr[0];
													$gMonth = round($gArr[1]*12/100);
												?>
												<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $gyear ?> Year, <?php echo $gMonth ?> Months</option>
												<?php } ?>
											</select>
								<span id="err_gap" style="color:red;"></span>
							</div>

						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Preferred Course :</label>
								<input type="text" class="form-control" name="preferred_course" id="preferred_course" required>
								<span id="err_preferred_course" style="color:red;"></span>
							</div>

						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Diploma Duration :</label>
								<input type="text" class="form-control" name="duration" id="duration" required>
								<span id="err_duration" style="color:red;"></span>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Experience Duration :</label>
								<input type="text" class="form-control" name="exp_duration" id="exp_duration">
								<span id="err_exp_duration" style="color:red;"></span>
							</div>					
						</div>

						


						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Diploma Name :</label>
								<input type="text" class="form-control" name="diploma" id="diploma" required>
								<span id="err_diploma" style="color:red;"></span>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label mb-10">Designation :</label>
								<input type="text" class="form-control" name="designation" id="designation">
								<span id="err_designation" style="color:red;"></span>
							</div>					
						</div>

						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<script>
	var dataTable = $('#gapList').DataTable({
      "processing": true,
      "serverSide": true,
      "stateSave": false,
      "lengthMenu": [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
      "pageLength": 10,
      "ajax":{
        url :"gap-list-ajax.php",
        type: "post",
        error: function(){ 
          $(".product-grid-error").html("");
          $("#product-grid").append('<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
          $("#product-grid_processing").css("display","none");
        }
      }
    })

	function ShowModal(){
		$("#exampleModalLabel1").html("Add Gap");
		
		$("#id").val("");
		$("#qualification").val("");
		$("#stream").val("");
		$("#gap").val("");
		$("#preferred_course").val("");
		$("#diploma").val("");
		$("#duration").val("");
		$("#exp_duration").val("");
		$("#designation").val("");
		$("#exampleModal").modal('show');

	}
	function getModalData(id) 
	{	
		$("#exampleModalLabel1").html("Update Gap");
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {id:id,type:'updategap'},
			beforeSend: function () {
			},
			success: function (response) {
				console.log(response);
				response = response.split('##');
				$("#id").val(response[0]);
				$("#qualification").val(response[1]);
				$("#stream").val(response[2]);
				$("#gap").val(response[3]);
				$("#preferred_course").val(response[4]);
				$("#diploma").val(response[5]);
				$("#duration").val(response[6]);
				$("#exp_duration").val(response[7]);
				$("#designation").val(response[8]);
				$("#exampleModal").modal('show');
			}
		});

	}

	$("#btnSubmit").on("click", function() {	
		id = $("#id").val();
		qualification = $("#qualification").val();
		stream = $("#stream").val();
		gap = $("#gap").val();
		preferred_course =$("#preferred_course").val();
		diploma = $("#diploma").val();
		duration = $("#duration").val();
		exp_duration = $("#exp_duration").val();
		designation = $("#designation").val();


		if(qualification==''){
			$("#err_qualification").show().html("This field is required.");
			return;
		}
		if(stream==''){
			$("#err_stream").show().html("This field is required.");
			return;
		}
		if(gap==''){
			$("#err_gap").show().html("This field is required.");
			return;
		}
		if(preferred_course==''){
			$("#err_preferred_course").show().html("This field is required.");
			return;
		}
		
		
		if(id==''){
			action='addGap';
		}else{
			action='updateGap';    	
		}

		$.ajax({
			type: "POST", 
			url: 'ajax/submitData.php', 
			data: {'id':id,'qualification':qualification,'stream':stream,'gap':gap,'preferred_course':preferred_course,'diploma':diploma,'duration':duration,'exp_duration':exp_duration,'designation':designation,'action':action}, 
			success: function (response) {
				//console.log(response);
				if(response==1){
					$("#exampleModal").modal('hide');
					location.reload(true);
				}
			},
		});
	});
	$("#qualification").change(function(){
		$("#err_qualification").hide();
	})
	$("#stream").keypress(function(){
		$("#err_stream").hide();
	})
	$("#gap").change(function(){
		$("#err_gap").hide();
	})
	$("#preferred_course").change(function(){
		$("#err_preferred_course").hide();
	})
	$("#diploma").change(function(){
		$("#err_diploma").hide();
	})
	$("#duration").change(function(){
		$("#err_duration").hide();
	})
	$("#exp_duration").change(function(){
		$("#err_exp_duration").hide();
	})
	$("#designation").change(function(){
		$("#err_designation").hide();
	})
</script>
<script src="js/change-status.js"></script> 
</body>
</html>