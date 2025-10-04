<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="welcome.php">
							<img class="brand-img" src="img/logo.svg" alt="brand" style="width: 88px;" />
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
				<form id="search_form" role="search" class="top-nav-search collapse pull-left">
					<div class="input-group">
						<input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
						<span class="input-group-btn">
						<button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
						</span>
					</div>
				</form>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					
					
					<li class="dropdown auth-drp">

						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><span style="margin: 0px 11px 0px 0px;
    font-size: 16px !important;"><?php echo getField('name',$tbl_admin,$_SESSION['sess_admin_id']); ?></span><img src="img/user1.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a href="change-password.php"><i class="zmdi zmdi-account"></i><span>Change Password</span></a>
							</li>
							
							<li>
								<a href="logout.php"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>
<!-- Left Sidebar Menu -->
<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
				<li class="navigation-header">
					<span>Dashboard</span> 
					<i class="zmdi zmdi-more"></i>
				</li>
				<?php 
				if($_SESSION['level_id']==1){?>

				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='country-list.php' || basename($_SERVER['SCRIPT_NAME'])=='country-addf.php')?'active' :'' ?>" href="country-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-my-location mr-20"></i><span class="right-nav-text">Manage Country</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>

				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='state-list.php' || basename($_SERVER['SCRIPT_NAME'])=='state-addf.php')?'active' :'' ?>" href="state-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-my-location mr-20"></i><span class="right-nav-text">Manage State</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='univercity-list.php' || basename($_SERVER['SCRIPT_NAME'])=='univercity-addf.php')?'active' :'' ?>" href="univercity-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="fa-solid fa-building-columns mr-20 zmdi" style="color: #fff;"></i><span class="right-nav-text">Manage Univercity</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='branch-list.php' || basename($_SERVER['SCRIPT_NAME'])=='branch-addf.php')?'active' :'' ?>" href="branch-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-local-store mr-20"></i><span class="right-nav-text">Manage Branch</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='user-list.php' || basename($_SERVER['SCRIPT_NAME'])=='user-addf.php')?'active' :'' ?>" href="user-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-local-wc mr-20"></i><span class="right-nav-text">Manage User</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='stage-list.php' || basename($_SERVER['SCRIPT_NAME'])=='stage-addf.php')?'active' :'' ?>" href="stage-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-map mr-20"></i><span class="right-nav-text">Manage Stage</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
				</li>
				<?php }?>			
				
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='student-list.php' || basename($_SERVER['SCRIPT_NAME'])=='student-addf.php' || basename($_SERVER['SCRIPT_NAME'])=='student-editf.php')?'active' :'' ?>" href="student-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-account mr-20"></i><span class="right-nav-text">Manage Student</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>				
				<li>
					<a class="<?php echo (basename($_SERVER['SCRIPT_NAME'])=='programmes-list.php' || basename($_SERVER['SCRIPT_NAME'])=='programmes-addf.php')?'active' :'' ?>" href="programmes-list.php" data-toggle="collapse" data-target="#maps_dr"><div class="pull-left"><i class="zmdi zmdi-plus-circle-o-duplicate mr-20"></i><span class="right-nav-text">Manage programmes</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				</li>
			</ul>
		</div>
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->