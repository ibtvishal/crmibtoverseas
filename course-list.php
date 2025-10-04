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
						  <h5 class="txt-dark">Manage Course</h5>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
						  <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						  <h5 style="color:red"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
						</div>

						<form class="form-horizontal form_csv" action="csv.php" method="post" name="upload_excel"   
						enctype="multipart/form-data" style="">
							<input  type='file' name='file'    class="manage_upload_button"></br>
							<input type='submit' name='CoruseImport' value='Upload' class="btn  upload_csv_button" style="">
						</form>
						<form class="form-horizontal form_csv_download" action="download_csv.php?table_name=tbl_course&amp;p=course-list" method="post" name="upload_excel" enctype="multipart/form-data"  style="">
						<div class="row">
							<div class="col-md-4 col-6">
								<input type="submit" name="courseList" class="btn btn-primary download_csv_button" value="Download CSV">
							</div>
						</div>                    
						</form>
				
						<div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
						  <ol class="breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
							<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Course</a></span></li>
							
						  </ol>
						</div>
						<!-- /Breadcrumb -->
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
		
							 <form name="frm" method="post" action="course-del.php" enctype="multipart/form-data">
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>Id</th>
														<th>Country </th>
														<th>State </th>
														<th>University Name</th>
														<th>Course Name</th>
														<th>Status</th>
														<th>Action</th>
													
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Id</th>
														<th>Country </th>
														<th>State </th>
														<th>University Name</th>
														<th>Course Name</th>
														<th>Status</th>
														<th>Action</th>
														
													</tr>
												</tfoot>
												<tbody>
													<?php
													$i=1;
													$sql=$obj->query("select * from $tbl_course where 1=1",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
													<tr>
														<td><?php echo $line->id ?></td>
														<td><?php echo getField('name',$tbl_country,$line->country_id) ?></td>
														<td><?php echo getField('state',$tbl_state,$line->state_id) ?></td>
														<td><?php echo getField('name',$tbl_univercity,$line->university_id) ?></td>
														<td><?php echo $line->name ?></td>
														<td>  <div class="material-switch">
															<input id="someSwitchOptionPrimary<?php echo $i; ?>"  type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_course; ?>"/>
															<label for="someSwitchOptionPrimary<?php echo $i; ?>" class="label-primary"></label>
														</div> </td>

														<td>
															<a href="javascript:void(0);"  onclick="getModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 

															<a href="course-del.php?id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
															border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
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
								<form  method="post" id="addstate" name="addstate">
								 <input type="hidden" name="id" id="id" value="">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h5 class="modal-title" id="exampleModalLabel1">Add Course</h5>
								</div>

									<div class="modal-body">	

										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Country:</label>
											<select class="form-control country_id" name="country_id" id="country_id" required>
												<option value="">--Select Country--</option>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_country where 1=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
												<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
												<?php } ?>
											</select>
											<span id="err_country_id" style="color:red;"></span>
											
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">State:</label>
											<select class="form-control" name="state_id" id="state_id" required>
												<option value="">--Select State--</option>								
											</select>
											<span id="err_state_id" style="color:red;"></span>
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">University Name:</label>
											<select class="form-control" name="university_id" id="university_id" required>
												<option value="">--Select University--</option>								
											</select>
											<span id="err_university_id" style="color:red;"></span>											
										</div>
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10"> Course Name:</label>
											<input type="text" class="form-control" id="name" name="name">
										</div>									
										<span id="err_name" style="color:red;"></span>
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
$(document).ready(function(){
	$('#country_id').change(function() {
		var country_id=$(this).val(); 
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {country_id:country_id,type:'getstatedrop'}, //set data
			success: function (response) {
				response = response.split('##');
				$("#state_id").html(response);
			}
		});
	})

	$('#state_id').change(function() {
		var state_id=$(this).val(); 
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {state_id:state_id,type:'getUniversity'}, //set data
			success: function (response) {
				response = response.split('##');
				$("#university_id").html(response);
			}
		});
	})

});


function getState(country_id,state_id){
	$.ajax({
		type: "GET", 
		url: 'ajax/getModalData.php',
		data: {country_id:country_id,type:'getstatedrop'},
		success: function (response) {
			response = response.split('##');
			$("#state_id").html(response);
			$("#state_id").val(state_id);
		}
	});
}

function getUniversity(state_id,university_id){
	$.ajax({
		type: "GET", 
		url: 'ajax/getModalData.php',
		data: {state_id:state_id,type:'getUniversitydrop'},
		success: function (response) {
			response = response.split('##');
			$("#university_id").html(response);
			$("#university_id").val(university_id);
		}
	});
}
function ShowModal(){
	$("#exampleModalLabel1").html("Add University");
	$("#country_id").val("");
	$("#state_id").val("");
	$("#university_id").val("");
	$("#name").val("");
	$("#id").val("");
	$("#exampleModal").modal('show');
	$("#err_state_name").hide();
}
function getModalData(id) 
{	
	$("#exampleModalLabel1").html("Update University");
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,type:'getCourse'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
            response = response.split('##');
            $("#id").val(response[0]);
            $("#country_id").val(response[1]);
            getState(response[1],response[2]);
            getUniversity(response[2],response[3]);
            $("#name").val(response[4]);
          	$("#exampleModal").modal('show');
        }
    });

}

$("#btnSubmit").on("click", function() {	
    var id = $("#id").val();
    country_id = $("#country_id").val();
    state_id = $("#state_id").val();
    university_id = $("#university_id").val();
    name = $("#name").val();
    if(country_id==''){
		$("#err_country_id").show().html("This field is required.");
		return;
	}
	if(state_id==''){
		$("#err_state_id").show().html("This field is required.");
		return;
	}
	if(university_id==''){
		$("#err_university_id").show().html("This field is required.");
		return;
	}	
    if(name==''){
		$("#err_name").show().html("This field is required.");
		return;
	}
    if(id==''){
    	action='addCourse';
    }else{
    	action='updateCourse';    	
    }
	$.ajax({
        type: "POST", 
        url: 'ajax/submitData.php', 
        data: {'id':id,'name':name,'country_id':country_id,'state_id':state_id,'university_id':university_id,'action':action}, 
        success: function (response) {
        	if(response==1){
        		$("#exampleModal").modal('hide');
        		location.reload(true);
        	}
        },
    });
});
$("#country_id").change(function(){
	$("#err_country_id").hide();
})
$("#state_id").change(function(){
	$("#err_state_id").hide();
})
$("#university_id").change(function(){
	$("#err_university_id").hide();
})
$("#name").keypress(function(){
	$("#err_name").hide();
})
</script>

<script src="js/change-status.js">

</script> 
</body>

</html>