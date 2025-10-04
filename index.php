<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
check_cokkie();
//phpinfo();
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
	<style>
		page-wrapper.auth-page {
			background: transparent !important; 
		}
	</style>
	<div class="wrapper pa-0" style="border: 1px solid #ede6e6;background: #fdfcfc;">

		<!-- Main Content -->
		<div class="page-wrapper pa-0 ma-0 auth-page">
			<div class="container-fluid">
				<!-- Row -->
				<div class="table-struct full-width full-height">
					<div class="table-cell vertical-align-middle auth-form-wrap">
						<div class="auth-form  ml-auto mr-auto no-float">
							<div class="row">
								<div class="col-sm-12 col-xs-12" style="background: #f5f5f5">
									<div class="mb-30" style="margin-left: 75px;">
										<img class="brand-img mr-10" src="img/logo.svg" alt="brand"/>
										<div class="col-md-12"><p style="text-align:left;"><?php if($_SESSION['sess_msg']){ ?><span class="box-title" style="font-size:16px;color:#a94442"><strong><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></strong></span> <?php }?></p></div>
									</div>	
									<div class="form-wrap">
										<form name="loginform" id="loginform" method="post" action="">
											<input type="hidden" name="logged" value="yes" />
											<div id="mobileDiv">
												<div class="col-xs-12">
													<input type="text" class="form-control" name="usermobile" id="usermobile" placeholder="Enter mobile number" required maxlength="13" minlength="13" >
												</div>
												<div class="col-xs-12">
													<button type="button" id="mobilebtn" class="btn btn-primary btn-block btn-flat"  name="mobilebtn" style="margin-top: 10px;">Submit</button>
												</div>
											</div>
											<div id="otpDiv" style="display: none">
												<input name="otp" id="otp" class="form-control" id="" type="text" placeholder="Enter your OTP OR Passcode">
												<div class="dflexbuttons">
													<button type="button" class="btn btn-primary btn-block btn-flat" id="otpbtn" name="otpbtn" style="width: 45%">Verify OTP</button>
													<button type="button" class="btn btn-primary btn-block btn-flat" id="resendbtn" name="resendbtn" style="width: 45%">Resend OTP</button>
												</div> 
											</div>
											<div class="row">
												<div class="col-xs-12">
													<div class="login_message" id="add_err" style="padding:5px; color: red; font-size: 13px;"></div>
												</div>
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

		</div>
		<!-- /Main Content -->

	</div>
	<!-- /#wrapper -->

	<?php include("footer.php"); ?>
</body>
</html>
<script type="text/javascript">
	/***************  Mobile number verification ********************/
	$('#usermobile').on('input', function() {
    const phoneNumber = $(this).val();

    // Remove all non-numeric characters from the input value
    const numericOnly = phoneNumber.replace(/\D/g, '');

    // Ensure the number is limited to 10 digits
    const limitedNumber = numericOnly.slice(0, 14);

    // Add "+91" as a prefix if the number doesn't already start with "+91"
    const formattedNumber = limitedNumber.startsWith('91') ? "+" + limitedNumber : "+91" + limitedNumber;

    $(this).val(formattedNumber);
});
	$("#mobilebtn").click(function(){
		$('.login_message').show();
		var mobile = $("#usermobile").val();
		if(mobile!=''){
			$('.login_message').html('<i class="fa fa-spinner fa-spin" style="font-size:45px"></i>');
			$.ajax({
				type: "POST",
				url: "ajax/otpvalidate.php",
				data:{'name':mobile,'action':'mobilevalidate'},
				success: function(data){
					var result = JSON.parse(data);
					if(result['success']==1){
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);

						$("#mobileDiv").hide();
						$("#otpDiv").show();
					}else{
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);
					}
				}
			});
		}else{
			$('.login_message').html('Please enter mobile number.');
			setTimeout(function(){
				$('.login_message').hide();
			}, 5000);

		}

	})

	/***************  OTP verification ********************/

	$("#otpbtn").click(function(){
		$('.login_message').show();
		var otp = $("#otp").val();
		var mobile = $("#usermobile").val();
		if(otp!=''){
			$('.login_message').html('<i class="fa fa-spinner fa-spin" style="font-size:45px"></i>');
			$.ajax({
				type: "POST",
				url: "ajax/otpvalidate.php",
				data:{'name':otp,'mobile':mobile,'action':'otpvalidate'},
				success: function(data){
					var result = JSON.parse(data);
					if(result['success']==1){
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);
						location.href='welcome.php';                  
					}else{
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);
					}
				}
			});
		}else{
			$('.login_message').html('Please enter otp.');
			setTimeout(function(){
				$('.login_message').hide();
			}, 5000);

		}

	})

	/***************  Resend OTP ********************/

	$("#resendbtn").click(function(){
		$('.login_message').show();
		var mobile = $("#usermobile").val();
		if(mobile!=''){
			$('.login_message').html('<i class="fa fa-spinner fa-spin" style="font-size:45px"></i>');
			$.ajax({
				type: "POST",
				url: "ajax/otpvalidate.php",
				data:{'name':mobile,'action':'resendotp'},
				success: function(data){
					var result = JSON.parse(data);
					if(result['success']==1){
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);

					}else{
						$('.login_message').html(result['message']);
						setTimeout(function(){
							$('.login_message').hide();
						}, 3000);
					}
				}
			});
		}else{
			$('.login_message').html('Please enter mobile number.');
			setTimeout(function(){
				$('.login_message').hide();
			}, 5000);

		}

	})

</script>
