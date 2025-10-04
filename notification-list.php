<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

$whr="";
$_SESSION['whr']='';
if($_REQUEST['filter_status']!=''){
	$whr .= " and a.status='".$_REQUEST['filter_status']."'";
}
if($_REQUEST['filter_type']!=''){
	$whr .= " and a.type='".$_REQUEST['filter_type']."'";
}

$_SESSION['whr']= $whr;
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
				<div class="row heading-bg">
					<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">Manage Notes</h5>
					</div>
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-left">
						<h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
						<h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
					</div>
					<div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>							
						</ol>
					</div>
				</div>
				 <form method="post" name="searchfrm" id="searchfrm" action="notification-list.php">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper">
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="filter_status" id="filter_status" class="form-control">
                        <option value="" <?php if($_REQUEST['filter_status']==''){?> selected <?php } ?>>All</option>
                        <option value="2" <?php if($_REQUEST['filter_status']==2){?> selected <?php } ?>>Read</option>
                        <option value="1" <?php if($_REQUEST['filter_status']==1){?> selected <?php } ?>>Unread</option>
                      </select>
                    </div>
                  </div>

                  <!-- <div class="col-md-3">
                    <div class="form-group">
                      <select name="filter_type" id="filter_type" class="form-control">
                        <option value="">Type</option>
                        <option value="1" <?php //if($_REQUEST['filter_type']==1){?> selected <?php //} ?>>New</option>
                        <option value="2" <?php //if($_REQUEST['filter_type']==2){?> selected <?php //} ?>>Updated</option>
                        <option value="3" <?php //if($_REQUEST['filter_type']==3){?> selected <?php //} ?>>Reply</option>
                      </select>
                    </div>
                  </div> -->                              
              </div>
            </div>
          </div>
        </div>
         </form>
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
															<th>TIme Stamp</th>
															<th>Student Code</th>
															<th>Name</th>
															<th>University or General</th>
															<th>Sender</th>
															<th>Remarks</th>
															<th>Read/Unread</th>
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
				url :"notification-list-ajax.php",
				type: "post",
				error: function(){ 
					$(".product-grid-error").html("");
					$("#product-grid").append('<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#product-grid_processing").css("display","none");
				}
			}
		})

		$("#filter_status").change(function(){
			$("#searchfrm").submit();
		})
		$("#filter_type").change(function(){
			$("#searchfrm").submit();
		})

	</script>
	<script src="js/change-status.js"></script> 
</body>
</html>