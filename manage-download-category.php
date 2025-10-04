<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
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
						  <h5 class="txt-dark">Manage Category</h5>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
						  <h5 style="color:#2a911d;" id="sess_msg"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						    <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
						</div>
						<!-- Breadcrumb -->
				
						<div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
						  <ol class=" breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
							<li class="active"><span><a href="javascript:void();" onclick="ShowModal();">Add Category</a></span></li>
							
						  </ol>
						</div>
						<!-- /Breadcrumb -->
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
		
							 <form name="frm" method="post" action="category-del.php" enctype="multipart/form-data">
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="datable_1" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Status</th>
														<th>Action</th>
													
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Status</th>
														<th>Action</th>
														
													</tr>
												</tfoot>
												<tbody>
													<?php
													$i=1;
													$sql=$obj->query("select * from $tbl_download_category where 1=1",$debug=-1);
													while($line=$obj->fetchNextObject($sql)){?>
													<tr>
														<td><?php echo $i ?></td>
														<td><?php echo $line->name ?></td>
														<td>  <div class="material-switch">
															<input id="someSwitchOptionPrimary<?php echo $i; ?>"  type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_download_category?>"/>
															<label for="someSwitchOptionPrimary<?php echo $i; ?>" class="label-primary"></label>
														</div> </td>

														<td>
															<a href="javascript:void(0);"  onclick="getModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 

															<a href="category-del.php?download_id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
															border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
														</tr>
														<?php $i++;} ?>
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
								<form  method="post" id="addcategory" name="addcategory">
								 <input type="hidden" name="id" id="id" value="">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h5 class="modal-title" id="exampleModalLabel1">Add Category</h5>
								</div>
								<div class="modal-body">									
										<div class="form-group">
											<label for="recipient-name" class="control-label mb-10">Category Name:</label>
											<input type="text" class="form-control" id="cname" name="name">
										</div>
									
									<span id="err_category_name" style="color:red;"></span>
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
	$("#exampleModalLabel1").html("Add Category");
	$("#cname").val("");
	$("#id").val("");
	$("#exampleModal").modal('show');
	$("#err_category_name").hide();
}
function getModalData(id) 
{	
	$("#exampleModalLabel1").html("Update Category");
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,type:'getdownloadCategory'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
            response = response.split('##');
            $("#id").val(response[0]);
            $("#cname").val(response[1]);
          	$("#exampleModal").modal('show');
        }
    });

}

$("#btnSubmit").on("click", function() {
	$(this).attr("disabled","disabled");
    var id = $("#id").val();
    name = $("#cname").val();
    if(name==''){
	$("#err_category_name").show().html("This field is required.");
	$(this).removeAttr("disabled","disabled");
	return;
	}
    if(id==''){
    	action='addDownloadCategory';
    }else{
    	action='updateDownlaodCategory';    	
    }
	$.ajax({
        type: "POST", 
        url: 'ajax/submitData.php', 
        data: {'id':id,'name':name,'action':action}, 
        success: function (response) {
        	if(response==1){
        		$("#exampleModal").modal('hide');
        		location.reload(true);
        	}
        },
    });
});
$("#cname").keypress(function(){
$("#err_category_name").hide();
})


function chagnedisplayOrder(id,ival) 
{	
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,ival:ival,type:'changecatDisplayOrder'}, //set data
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