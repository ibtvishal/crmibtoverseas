<?php 
include('include/config.php');
include("include/functions.php");
validate_admin();
$_SESSION['reload']="1";

  if($_REQUEST['submitForm']=='yes'){

  $name=$obj->escapestring($_POST['name']);
  $username=$obj->escapestring($_POST['username']);
  $email=$obj->escapestring($_POST['email']);
  $phone=$obj->escapestring($_POST['phone']);
  $password=$obj->escapestring($_POST['password']);
 
  $level_id=$obj->escapestring($_POST['level_id']);
  $type = (array)$_REQUEST['branch_id'];
	$branch_id=implode(',',$type);
  if($_REQUEST['id']==''){
	  $obj->query("insert into $tbl_admin set name='$name',email='$email',phone='$phone',password='$password',username='$username',branch_id='$branch_id',level_id='$level_id'",1);//die;
	  $_SESSION['sess_msg']='User added sucessfully';  
	  
       }else{ 
	  $obj->query("update $tbl_admin set name='$name',email='$email',phone='$phone',password='$password',username='$username',branch_id='$branch_id',level_id='$level_id' where id=".$_REQUEST['id']);
	  $_SESSION['sess_msg']='User updated sucessfully';   
        }
   header("location:user-list.php");
   exit();
  }      
	   
	   
if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_admin where id=".$_REQUEST['id']);
$result=$obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
</head>
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
						  <h5 class="txt-dark">Manage User</h5>
						</div>
						<!-- Breadcrumb -->
						<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
						  <ol class="breadcrumb">
							<li><a href="welcome.php">Dashboard</a></li>
							<li class="active"><span><a href="user-list.php">Manage User</a></span></li>
						  </ol>
						</div>
						<!-- /Breadcrumb -->
					</div>
					<!-- /Title -->
					
					<!-- Row -->
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> User</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="form-wrap">
											<form action="" method="post">
												<input type="hidden" name="submitForm" value="yes">
												<div class="form-group">
																		<label class="control-label mb-10">Branch</label>
																		<select class="form-control" name="branch_id[]" id="branch_id" required multiple='' >
																			
																			<?php
																			$i=1;
																			$sql=$obj->query("select * from $tbl_branch where 1=1",$debug=-1);
																			while($line=$obj->fetchNextObject($sql)){?>
																			<option value="<?php echo $line->id ?>" <?php if($result->branch_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
																			<?php } ?>
																		
																		</select>
																	</div>

																				<div class="form-group">
																		<label class="control-label mb-10">User Type</label>
																		<select class="form-control" name="level_id" id="level_id" required>
																			<option>User Type</option>
																			<option value="2" <?php if($result->level_id==2){?>selected<?php } ?>>Sr Account Manager</option>
																			<option value="3" <?php if($result->level_id==3){?>selected<?php } ?>>Account Manager</option>
																			<option value="4" <?php if($result->level_id==4){?>selected<?php } ?>>Counsellor </option>
																		</select>
																	</div>

												<div class="form-group">
													<label class="control-label mb-10 text-left"> Name :</label>
													<input type="text" class="form-control" placeholder=" Name" name="name" id="name" value="<?php echo stripslashes($result->name); ?>" required>
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left"> User Name :</label>
													<input type="text" class="form-control" placeholder=" User Name" name="username" id="username" value="<?php echo stripslashes($result->username); ?>" required>
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left">Email :</label>
													<input type="text" class="form-control" placeholder=" Email" name="email" id="email" value="<?php echo stripslashes($result->email); ?>" required>
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left">Phone :</label>
													<input type="text" class="form-control" placeholder=" Phone" name="phone" id="phone" value="<?php echo stripslashes($result->phone); ?>" required>
												</div>
												<div class="form-group">
													<label class="control-label mb-10 text-left">Password :</label>
													<input type="text" class="form-control" placeholder=" Password" name="password" id="password" value="<?php echo stripslashes($result->password); ?>" required>
												</div>
												
																	
															

																																	
												
												<div class="form-group">
													<label class="control-label mb-10 text-left"></label>
														<button type="submit" class="btn btn-success " style="position: absolute;margin-left: 14px;
												">Submit</button>
												</div>
												
												
												
												
											
											
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->
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
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->

		<?php include("footer.php"); ?>

		
	</body>
</html>