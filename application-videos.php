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
						  <h5 class="txt-dark">Manage University Application Videos</h5>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
						  <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						  <h5 style="color:red"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
						</div>
						<!-- Breadcrumb -->
				
						<div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
						  <ol class="breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
                            <?php
                            if($_SESSION['level_id'] == 1){
                            ?>
							<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add University Application Videos</a></span></li>
                            <?php } ?>
							
						  </ol>
						</div>
						<!-- /Breadcrumb -->
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
		
							 <form name="frm" method="post" action="univercity-del.php" enctype="multipart/form-data">
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>Id</th>
														<th>University Name</th>
														<th>Video </th>
														<th>Video Title </th>
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
														<th>Id</th>
														<th>University Name </th>
														<th>Video </th>
														<th>Video Title </th>
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
                                                    $whr = '';
                                                    if($_SESSION['level_id']!=1){
                                                        $whr = " and status=1";
                                                    }
													$sql=$obj->query("select * from $tbl_univercity_application_video where 1=1 $whr",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
													<tr>
														<td><?php echo $line->id ?></td>
														<td><?php echo getField('name',$tbl_univercity,$line->university_id) ?></td>
														<td>
														<iframe width="200px" height="150px"
                                                                                src="https://www.youtube.com/embed/<?php echo $line->video_url ?>?si=4ULQDenKsAedh161"
                                                                                title="YouTube video player"
                                                                                frameborder="0"
                                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                                referrerpolicy="strict-origin-when-cross-origin"
                                                                                allowfullscreen></iframe>	
														</td>
														<td><?php echo $line->video_title ?></td>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1){
                                                        ?>
														<td>  <div class="material-switch">
															<input id="someSwitchOptionPrimary<?php echo $i; ?>"  type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_univercity_application_video?>"/>
															<label for="someSwitchOptionPrimary<?php echo $i; ?>" class="label-primary"></label>
														</div> </td>

														<td>
															<a href="javascript:void(0);"  onclick="getModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
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
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form  method="post" id="addstate" name="addstate">
								 <input type="hidden" name="id" id="id" value="">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h5 class="modal-title" id="exampleModalLabel1">Add University</h5>
								</div>

									<div class="modal-body">	

										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">University:</label>
											<select class="form-control university_id" name="university_id" id="university_id" required>
												<option value="">--Select University--</option>
												<?php
												$i=1;
												$sql=$obj->query("select * from $tbl_univercity where 1=1",$debug=-1);
												while($line=$obj->fetchNextObject($sql)){?>
												<option value="<?php echo $line->id ?>"><?php echo $line->name ?></option>
												<?php } ?>
											</select>
											<span id="err_university_id" style="color:red;"></span>
											
										</div>
									<span id="err_name" style="color:red;"></span>
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10"> Video Code:</label>
											<input type="text" class="form-control" id="video_url" name="video_url">
										</div>
									
									<span id="err_video_url" style="color:red;"></span>
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10"> Video Title:</label>
											<input type="text" class="form-control" id="video_title" name="video_title">
										</div>
									
									<span id="err_video_title" style="color:red;"></span>
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
	$("#exampleModalLabel1").html("Add University");
	$("#university_id").val("");
	$("#id").val("");
	$("#video_url").val("");
	$("#video_title").val("");
	$("#err_video_url").html("");
	$("#exampleModal").modal('show');
	$("#err_state_name").hide();
}
function getModalData(id) 
{	
	$("#exampleModalLabel1").html("Update University");
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,type:'getUnivercityvideo'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
            response = response.split('##');
            $("#id").val(response[0]);
            $("#university_id").val(response[1]);
            $("#video_url").val(response[2]);
            $("#video_title").val(response[3]);

          	$("#exampleModal").modal('show');
        }
    });

}

$("#btnSubmit").on("click", function() {	
    var id = $("#id").val();
    university_id = $("#university_id").val();
    video_url = $("#video_url").val();
    video_title = $("#video_title").val();
    if(university_id==''){
		$("#err_university_id").show().html("This field is required.");
		return;
	}
    if(video_url==''){
		$("#err_video_url").show().html("This field is required.");
		return;
	}
    if(video_title==''){
		$("#err_video_title").show().html("This field is required.");
		return;
	}
    if(id==''){
    	action='addUnivercityvideo';
    }else{
    	action='updateUnivercityvideo';    	
    }
	$.ajax({
        type: "POST", 
        url: 'ajax/submitData.php', 
        data: {'id':id,'university_id':university_id,'video_url':video_url,'video_title':video_title,'action':action}, 
        success: function (response) {
        	//console.log(response); return;
        	if(response==1){
        		$("#exampleModal").modal('hide');
        		location.reload(true);
        	}
        },
    });
});
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