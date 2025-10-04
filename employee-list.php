<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

if($_POST['level_id']){
	$url = "employee-list.php?level_id=".base64_encode(base64_encode(base64_encode($_POST['level_id'])))."&branch_id=".base64_encode(base64_encode(base64_encode($_POST['branch_id'])));
	header("location:".$url);
	exit;
}

if($_POST['branch_id']){
	$url = "employee-list.php?level_id=".base64_encode(base64_encode(base64_encode($_POST['level_id'])))."&branch_id=".base64_encode(base64_encode(base64_encode($_POST['branch_id'])));
	header("location:".$url);
	exit;
}

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
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<h5 class="txt-dark">
							<?php 
							if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==2){
							echo "Senior Account Manager";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==3){
							echo "Account Manager";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==4){
							echo "Counselor";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==5){
							echo "Document Manager";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==6){
							echo "Media Manager";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==7){
							echo "Filling Manager";
							}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==8){
							echo "Filling Executive";
							}else{
								header("location:welcome.php");
							} ?>
							List
						</h5>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
					</div>
					<div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
						<ol class="breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
						</ol>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default card-view">
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="table-wrap">
											<div class="table-responsive">
												<table id="datable_3" class="table table-hover display  pb-30" >
													<?php
													if ($_SESSION['level_id']==1){?>
													<div class="choose_prog" style="">
														<form method="post" name="searchfrm" id="searchfrm" action="employee-list.php">
								                            <select name="branch_id" id="branch_id" class="search-select" style="width: 250px;">
								                              <option value="">Select Branch</option>
								                              <?php
								                              $cSql = $obj->query("select * from $tbl_branch where status=1");
								                              while($cResult = $obj->fetchNextObject($cSql)){?>
								                              <option value="<?php echo $cResult->id; ?>" <?php if(base64_decode(base64_decode(base64_decode($_REQUEST['branch_id'])))==$cResult->id){?> selected <?php } ?>><?php echo $cResult->name; ?></option>
								                            <?php }?>
								                            </select>
								                            <select name="level_id" id="level_id" class="search-select" style="width: 250px;">
								                              <option value="">Select User</option>
								                              <option value="3" <?php if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==3){?> Selected <?php }?>>Account Manager</option>
								                              <option value="4" <?php if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==4){?> Selected <?php }?>>Counselor</option>
								                              <option value="7" <?php if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==7){?> Selected <?php }?>>File Manager</option>
								                              <option value="8" <?php if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==8){?> Selected <?php }?>>File Executive</option>
								                            </select> 
							                             	<!-- <button type="submit" name="subit" class="manage-student-button">Submit</button> -->
                          								</form>
							                        </div>
							                    <?php }?>
													<thead>
														<tr>
															<th>Name</th>
															<th>Total Project</th>
															<th>Personal Email</th>
															<th>Phone</th>
															<th width="350px;">Branch</th>
															<th>Project View</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th>Name</th>
															<th>Total Project</th>
															<th>Personal Email</th>
															<th>Phone</th>
															<th width="350px;">Branch</th>
															<th>Project View</th>
														</tr>
													</tfoot>
													<tbody>
														<?php
														$i=1; $whr='';
														if(!empty($_REQUEST['level_id'])){
															$whr = " and level_id='".base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))."'"; 
														}
														if(!empty($_REQUEST['branch_id'])){	
															$branch_id = base64_decode(base64_decode(base64_decode($_REQUEST['branch_id'])));							
															$whr .= " and FIND_IN_SET($branch_id, branch_id)";
														}
														//echo $whr;
														if ($_SESSION['level_id']==1){
															$sql=$obj->query("select * from $tbl_admin where 1=1 $whr ORDER BY id DESC ",$debug=-1);
														}else{
															$branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                        	$sql=$obj->query("select * from tbl_admin where 1=1 and level_id='".base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))."' and FIND_IN_SET($branch_id, branch_id)",$debug=-1);
														}
														while($line=$obj->fetchNextObject($sql)){?>
																<tr>
																	<td><?php echo $line->name ?></td>
																	<td>
																	<?php
																	echo getTotalProject($line->id,$line->level_id,$line->branch_id);
																	?>
																	</td>
																	<td><?php echo $line->email ?></td>
																	<td><?php echo $line->phone ?></td>
																	<td width="350px;">
																		<?php
																		$array=array_map('intval', explode(',',$line->branch_id));
																		$array = implode("','",$array);
																		$i=1;
																		$sqld=$obj->query("select * from $tbl_branch where 1=1 and id IN ('".$array."')",$debug=-1);
																		$sqlNum = $obj->numRows($sqld);
																		while($linew=$obj->fetchNextObject($sqld)){
																			echo $linew->name;
																			// if($i!=$sqlNum){
																			// 	echo ",";
																			// }
																			
																		$i++; } ?>
																	</td>

																	<td>
																		<?php 
																		$url="";
																		if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==3){
																		$url = "student-list.php?b_id=".base64_encode(base64_encode(base64_encode($line->branch_id)))."&a_id=".base64_encode(base64_encode(base64_encode($line->id)));
																		}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==4){
																		$url = "student-list.php?b_id=".base64_encode(base64_encode(base64_encode($line->branch_id)))."&c_id=".base64_encode(base64_encode(base64_encode($line->id)));
																		}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==7){
																		$url = "student-list.php?b_id=".base64_encode(base64_encode(base64_encode($line->branch_id)))."&f_id=".base64_encode(base64_encode(base64_encode($line->id)));
																		}else if(base64_decode(base64_decode(base64_decode($_REQUEST['level_id'])))==8){
																		$url = "student-list.php?b_id=".base64_encode(base64_encode(base64_encode($line->branch_id)))."&fe_id=".base64_encode(base64_encode(base64_encode($line->id)));
																		} ?>

																		<a href="<?php echo $url; ?>"><i class="fa fa-eye" style="margin-right: 6px;font-size: 16px;"></i> </a> 
																</tr>
															<?php ++$i;} ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
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
		<script src="js/select2.full.min.js"></script>
		<script type="text/javascript">
			$("#branch_id").change(function(){
    			$("#searchfrm").submit();
  			})
  			$("#level_id").change(function(){
    			$("#searchfrm").submit();
  			})
		</script>
	</body>
	</html>