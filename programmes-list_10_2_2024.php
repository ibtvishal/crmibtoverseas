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

	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>

	<div class="wrapper theme-1-active pimary-color-green">
		<?php include("menu.php"); ?>


		<div class="page-wrapper">
			<div class="container-fluid">
				<div class="row heading-bg prgrm_bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">Manage Programmes</h5>
					</div>
					
					<form class="form-horizontal form_csv_download" action="download_excel.php?table_name=tbl_programmes&amp;p=programmes-list" method="post" name="upload_excel" enctype="multipart/form-data"  style="">
						<div class="row">

							<div class="col-md-4 col-6">
								<input type="submit" name="programmesList" class="btn btn-primary download_csv_button" value="Download Excel">
							</div>
						</div>                    
					</form>
				<div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="welcome.php">Dashboard</a></li>
					<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Programmes</a></span></li>
				</ol>
			</div>
		</div>

		
        <div class="row">
          <div class="col-sm-12" style="margin-left:115px;">
            <div class="panel panel-default card-view">
            	<form class="form-horizontal" action="csv.php" method="post" name="upload_excel" enctype="multipart/form-data">
              <div class="panel-wrapper">                       
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="filter_country" id="filter_country" class="form-control" required="">
						<option value="">Select Country</option>
						<?php
						$i=1;
						$sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
						while($line=$obj->fetchNextObject($sql)){?>
							<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
						<?php } ?>
					</select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-left:12px;">
                      <select name="filter_state" id="filter_state" class="form-control" required="">
						<option value="">Select State</option>
					</select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-left:12px;">
                      <select name="filter_university" id="filter_university" class="form-control" required="">
						<option value="">Select University</option>
					</select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group" style="margin-left:12px;">
                      <input  type='file' name='file' class="manage_upload_button" required="">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type='submit' name='productImport' value='Upload' class="btn upload_csv_button btn-primary" style="">
                    </div>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
         





		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default card-view">
					
					<form name="frm" method="post" action="programmes-del.php" enctype="multipart/form-data">
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="table-wrap">
									<div class="table-responsive">
										<table id="datable_1" class="table table-hover display  pb-30" >
											<div class="choose_prog" style="">
												<h5 style="color:#2a911d; padding-left: 300px; font-size: 16px; font-weight: bold;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
											</div>
											<thead>
												<tr>
													<th>Id</th>
													<th>Country</th>
													<th>State</th>
													<th>University</th>
													<th>Program level</th>
													<th>Stream</th>
													<th>Course Name</th>
													<th>Intake</th>
													<th>Program Duration</th>
													<th>Tuition Fee</th>
													<th>Student Bachelors</th>
													<th>Percentage</th>
													<th>IELTS</th>
													<th>PTE</th>
													<th>Duolingo</th>
													<th>TOEFL</th>
													<th>MOI</th>
													<th>i20 Fee</th>
													<th>Status</th>
													<th>Action</th>

												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Id</th>
													<th>Country</th>
													<th>State</th>
													<th>University</th>
													<th>Program level</th>
													<th>Stream</th>
													<th>Course Name</th>
													<th>Intake</th>
													<th>Program Duration</th>
													<th>Tuition Fee</th>
													<th>Student Bachelors</th>
													<th>Percentage</th>
													<th>IELTS</th>
													<th>PTE</th>
													<th>Duolingo</th>
													<th>TOEFL</th>
													<th>MOI</th>
													<th>i20 Fee</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_programmes where 1=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
													<tr>
														<td><?php echo $line->id ?></td>

														<td><?php echo getField('name',$tbl_country,$line->country) ?></td>
														<td><?php echo getField('state',$tbl_state,$line->state) ?></td>
														<td><?php echo getField('name',$tbl_univercity,$line->univercity) ?></td>
														<td><?php echo $line->program_level ?></td>
														<td><?php echo $line->stream ?></td>
														<td><?php echo $line->course_name ?></td>
														<td><?php echo $line->intake ?></td>
														<td><?php echo $line->program_duration ?></td>
														<td><?php echo $line->tuition_fee ?></td>
														<td><?php echo $line->student_bachelors ?></td>
														<td><?php echo $line->percentage ?></td>
														<td><?php echo $line->ielts ?></td>
														<td><?php echo $line->pte ?></td>
														<td><?php echo $line->duolingo ?></td>
														<td><?php echo $line->tofel ?></td>
														<td><?php echo $line->moi ?></td>
														<td><?php echo $line->fees ?></td>

														<td>  
															<div class="material-switch">
																<input id="someSwitchOptionPrimary<?php echo $i; ?>"  type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_programmes?>"/>
																<label for="someSwitchOptionPrimary<?php echo $i; ?>" class="label-primary"></label>
															</div> 
														</td>

														<td>
															<a href="javascript:void(0);" onclick="getModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
															<a href="programmes-del.php?id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
															border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
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

			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">

					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h5 class="modal-title" id="exampleModalLabel1">Add Programmes</h5>
						</div>
						<div class="modal-body">
							<form  method="post" id="addProgrammes" name="addProgrammes">
								<input type="hidden" name="id" id="id" value="">

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Country:</label>
											<select name="country" id="country" class="form-control">
												<option value="">Select Country</option>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
													<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
												<?php } ?>
											</select>
											<span id="err_country" style="color:red;"></span>
										</div>

									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">State:</label>
											<select name="state" id="state" class="form-control">
												<option value="">Select State</option>
											</select>
											<span id="err_state" style="color:red;"></span>
										</div>
									</div>
								</div>
									<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">University:</label>
											<select name="univercity" id="univercity" class="form-control">
												<option value="">Select University</option>
											</select>
											<span id="err_univercity" style="color:red;"></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Program Level:</label>
											<input type="text" class="form-control" name="program_level" id="program_level" required>
											<span id="err_program_level" style="color:red;"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Stream:</label>
											<input type="text" class="form-control" name="stream" id="stream" required>
											<span id="err_stream" style="color:red;"></span>
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Course Name:</label>
											<select name="course_name" id="course_name" class="form-control" required>
												<option value="">Select Course</option>
											</select>
											<span id="err_course_name" style="color:red;"></span>
										</div>
									</div>
									</div>
									<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Intake:</label>
											<input type="text" class="form-control" name="intake" id="intake" required>
											<span id="err_intake" style="color:red;"></span>
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Program Duration:</label>
											<input type="text" class="form-control" name="program_duration" id="program_duration" required>
											<span id="err_program_duration" style="color:red;"></span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Tuition Fee:</label>
											<input type="text" class="form-control" name="tuition_fee" id="tuition_fee" required max="2" min="0"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
											<span id="err_tuition_fee" style="color:red;"></span>
										</div>					
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Student Bachelors:</label>
											<input type="text" class="form-control" name="student_bachelors" id="student_bachelors"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

										</div>

									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Percentage:</label>
											<input type="text" class="form-control" name="percentage" id="percentage" required  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>
										<span id="err_percentage" style="color:red;"></span>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">IELTS:</label>
											<input type="text" class="form-control" name="ielts" id="ielts"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>

									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">PTE:</label>
											<input type="text" class="form-control" name="pte" id="pte"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">DUOLINGO:</label>
											<input type="text" class="form-control" name="duolingo" id="duolingo"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">TOEFL:</label>
											<input type="text" class="form-control" name="tofel" id="tofel"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>

									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">MOI:</label>
											<input type="text" class="form-control" name="moi" id="moi">								
										</div>
										<span id="err_moi" style="color:red;"></span>						
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">i20 Fee:</label>
											<input type="text" class="form-control" name="fees" id="fees">								
										</div>
										<span id="err_fees" style="color:red;"></span>						
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
	$(document).ready(function(){


		

		$('#filter_country').change(function() {
			var country_id=$(this).val(); 
			$.ajax({
				type: "GET", 
				url: 'ajax/getModalData.php',
				data: {id:country_id,type:'getState'},
				success: function (response) {
					//response = response.split('##');
					$("#filter_state").html(response);
				}
			});
		})

		$('#filter_state').change(function() {
			var state_id=$(this).val(); 
			$.ajax({
				type: "GET", 
				url: 'ajax/getModalData.php',
				data: {state_id:state_id,type:'getunivercityprogramme'},
				success: function (response) {
					//response = response.split('##');
					$("#filter_university").html(response);
				}
			});
		})

		
		

		$('#country').change(function() {
			var country_id=$(this).val(); 
			$.ajax({
				type: "GET", 
				url: 'ajax/getModalData.php',
				data: {id:country_id,type:'getState'}, 

				success: function (response) {
					//response = response.split('##');

					$("#state").html(response);
				}
			});
		})

		$('#state').change(function() {
			var state_id=$(this).val(); 
			$.ajax({
				type: "GET", 
				url: 'ajax/getModalData.php',
				data: {state_id:state_id,type:'getunivercityprogramme'},
				success: function (response) {
					response = response.split('##');
					$("#univercity").html(response);
				}
			});
		})



		$('#univercity').change(function() {
			var univercity=$(this).val(); 
			$.ajax({
				type: "GET", 
				url: 'ajax/getModalData.php',
				data: {univercity:univercity,type:'getcoursedrop'},
				success: function (response) {
					response = response.split('##');
					$("#course_name").html(response);
				}
			});
		})





	})
	function getState(country_id,state_id){

		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {id:country_id,type:'getState'},

			success: function (response) {
				response = response.split('##');

				$("#state").html(response);
				$("#state").val(state_id);

			}
		});
	}

	function getUnivercity(country_id,state_id,univercity){
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {state_id:state_id,country_id:country_id,type:'getunivercityprogramme'},
			success: function (response) {
				$("#univercity").html(response);
				$("#univercity").val(univercity);
			}
		});
	}


	function getCourse(univercity,course_id){
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {univercity:univercity,type:'getcoursedropprogram'},
			success: function (response) {
				$("#course_name").html(response);
				$("#course_name").val(course_id);
			}
		});
	}

	function ShowModal(){
		$("#exampleModalLabel1").html("Add Programmes");

		$("#id").val("");
		$("#country").val("");
		$("#state").val("");
		$("#univercity").val("");
		$("#program_level").val("");
		$("#stream").val("");
		$("#course_name").val("");
		$("#intake").val("");
		$("#program_duration").val("");
		$("#tuition_fee").val("");
		$("#student_bachelors").val("");
		$("#percentage").val("");
		$("#ielts").val("");
		$("#pte").val("");
		$("#duolingo").val("");
		$("#tofel").val("");
		$("#err_country").hide("");
		$("#err_state").hide("");
		$("#err_univercity").hide("");
		$("#err_program_level").hide("");
		$("#err_stream").hide("");
		$("#err_course_name").hide("");
		$("#err_intake").hide("");
		$("#err_program_duration").hide("");
		$("#err_tuition_fee").hide("");
		$("#err_percentage").hide();
		$("#err_ielts").hide();
		$("#err_pte").hide();
		$("#err_duolingo").hide();
		$("#err_tofel").hide();
		$("#err_moi").hide();
		$("#err_fees").hide();
		$("#exampleModal").modal('show');

	}
	function getModalData(id) 
	{	
		$("#exampleModalLabel1").html("Update Programmes");
		$.ajax({
			type: "GET", 
			url: 'ajax/getModalData.php',
			data: {id:id,type:'updateProgrammes'},
			beforeSend: function () {
			},
			success: function (response) {
				console.log(response);
				response = response.split('##');
				$("#id").val(response[0]);
				$("#country").val(response[1]);
				$("#state").val(response[2]);
				$("#univercity").val(response[3]);
				$("#program_level").val(response[4]);
				$("#stream").val(response[5]);
				$("#course_name").val(response[6]);
				$("#intake").val(response[7]);
				$("#program_duration").val(response[8]);
				$("#tuition_fee").val(response[9]);
				$("#student_bachelors").val(response[10]);
				$("#percentage").val(response[11]);
				$("#ielts").val(response[12]);
				$("#pte").val(response[13]);
				$("#duolingo").val(response[14]);
				$("#tofel").val(response[15]);
				$("#moi").val(response[16]);
				$("#fees").val(response[17]);
				getState(response[1],response[2]);
				getUnivercity(response[1],response[2],response[3]);
				getCourse(response[3],response[6]);
				$("#exampleModal").modal('show');
			}
		});

	}

	$("#btnSubmit").on("click", function() {	

		id = $("#id").val();
		country = $("#country").val();
		state = $("#state").val();
		univercity = $("#univercity").val();
		program_level =$("#program_level").val();
		stream = $("#stream").val();
		course_name = $("#course_name").val();
		intake = $("#intake").val();
		program_duration = $("#program_duration").val();
		tuition_fee = $("#tuition_fee").val();
		student_bachelors = $("#student_bachelors").val();
		percentage = $("#percentage").val();
		ielts = $("#ielts").val();
		pte = $("#pte").val();
		duolingo = $("#duolingo").val();
		tofel = $("#tofel").val();
		moi = $("#moi").val();
		fees = $("#fees").val();


		if(country==''){
			$("#err_country").show().html("This field is required.");
			return;
		}
		if(state==''){
			$("#err_state").show().html("This field is required.");
			return;
		}
		if(univercity==''){
			$("#err_univercity").show().html("This field is required.");
			return;
		}
		if(program_level==''){
			$("#err_program_level").show().html("This field is required.");
			return;
		}
		if(stream==''){
			$("#err_stream").show().html("This field is required.");
			return;
		}
		if(course_name==''){
			$("#err_course_name").show().html("This field is required.");
			return;
		}
		if(intake==''){
			$("#err_intake").show().html("This field is required.");
			return;
		}
		if(program_duration==''){
			$("#err_program_duration").show().html("This field is required.");
			return;
		}
		if(tuition_fee==''){
			$("#err_tuition_fee").show().html("This field is required.");
			return;
		}
		// if(moi==''){
		// 	$("#err_moi").show().html("This field is required.");
		// 	return;
		// }

		// if(fees==''){
		// 	$("#err_fees").show().html("This field is required.");
		// 	return;
		// }

		if(id==''){
			action='addProgrammes';
		}else{
			action='updateProgrammes';    	
		}

		$.ajax({
			type: "POST", 
			url: 'ajax/submitData.php', 
			data: {'id':id,'country':country,'state':state,'univercity':univercity,'stream':stream,'course_name':course_name,'intake':intake,'program_duration':program_duration,'tuition_fee':tuition_fee,'student_bachelors':student_bachelors,'percentage':percentage,'ielts':ielts,'pte':pte,'duolingo':duolingo,'tofel':tofel,'program_level':program_level,'moi':moi,'fees':fees,'action':action}, 
			success: function (response) {
				if(response==1){
					$("#exampleModal").modal('hide');
					location.reload(true);
				}
			},
		});
	});
	$("#country").change(function(){
		$("#err_country").hide();
	})
	$("#state").change(function(){
		$("#err_state").hide();
	})
	$("#univercity").change(function(){
		$("#err_univercity").hide();
	})
	$("#program_level").change(function(){
		$("#err_program_level").hide();
	})
	$("#stream").change(function(){
		$("#err_stream").hide();
	})
	$("#course_name").change(function(){
		$("#err_course_name").hide();
	})
	$("#intake").change(function(){
		$("#err_intake").hide();
	})
	$("#program_duration").change(function(){
		$("#err_program_duration").hide();
	})
	$("#tuition_fee").change(function(){
		$("#err_tuition_fee").hide();
	})
	$("#student_bachelors").change(function(){
		$("#err_student_bachelors").hide();
	})
	$("#percentage").change(function(){
		$("#err_percentage").hide();
	})
	$("#ielts").change(function(){
		$("#err_ielts").hide();
	})
	$("#pte").change(function(){
		$("#err_pte").hide();
	})
	$("#duolingo").change(function(){
		$("#err_duolingo").hide();
	})
	$("#tofel").change(function(){
		$("#err_tofel").hide();
	})
	$("#fees").change(function(){
		$("#err_fees").hide();
	})
</script>
<script src="js/change-status.js"></script> 
</body>
</html>