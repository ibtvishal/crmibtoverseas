<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
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
	#datable_1_filter label {
    display: none;
}
	div#datable_1_length label {
    display: none;
}

div#datable_1_info {
    display: none;
}
table.dataTable.display tbody td {
    border-top: none;
}
.2row th.sorting_asc {
    display: block !important;
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
						<h5 class="txt-dark">Manage Search Gap</h5>
					</div>


					
			<!-- Breadcrumb 
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="welcome.php">Dashboard</a></li>
					
				</ol>
			</div>
			 /Breadcrumb -->
		</div>
		<!-- /Title -->
		
<!-- /Row -->
		<!-- Row -->
		<div class="row">
			<div class="search-programm-side col-sm-3">
<h5>Search Gap</h5>
<div class="programmes search">
	<form class="prgrm_search-form">
   <select class="form-select" aria-label="Default select example" name="qualification" id="qualification" >
  <option selected value="">--Select Qualification--</option>
<?php
$i=1;
$sql=$obj->query("select * from $tbl_qualification where status=1",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
<option value="<?php echo $line->id ?>" <?php if($result->qualification==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
<?php } ?>
</select>

<select class="form-select" aria-label="Default select example" name="stream" id="stream">
  <option selected value="">--Programme Stream--</option>
  <?php
$i=1;
$sql=$obj->query("select * from $tbl_gap where status=1 GROUP BY stream",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
  <option value="<?php echo $line->stream ?>"><?php echo $line->stream ?></option>
 <?php } ?>
</select>
<select class="form-select" aria-label="Default select example" name="gap" id="gap">
  <option selected value="">--Select Gap--</option>
 <?php
$i=1;
$sql=$obj->query("select * from $tbl_manage_gap where status=1 order by name asc",$debug=-1);
while($line=$obj->fetchNextObject($sql)){

	$gname = number_format($line->name/12,2); 
	$gArr = explode('.', $gname);
	$gyear = $gArr[0];
	$gMonth = round($gArr[1]*12/100);
	?>
  <option value="<?php echo $line->id ?>"><?php if($gyear>0){ echo $gyear." Year, "; } ?><?php if($gMonth >0){ echo $gMonth." Months"; } ?> </option>
 <?php } ?>
</select>
<select class="form-select" aria-label="Default select example" name="preferred_course" id="preferred_course">
  <option selected value="">--Select Preferred course--</option>
 <?php
$i=1;
$sql=$obj->query("select * from $tbl_gap where status=1 GROUP BY preferred_course",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
  <option value="<?php echo $line->preferred_course ?>"><?php echo $line->preferred_course ?></option>
 <?php } ?>
</select>

</form>
</div>
			</div>
			<div class="col-sm-9">
				<div class="panel panel-default card-view">

<form name="frm" method="post" action="programmes-del.php" enctype="multipart/form-data">
	<div class="panel-wrapper collapse in">
		<div class="panel-body">
			<div class="table-wrap">
				<div class="table-responsive">
					<table id="datable_1" class="table table-hover display  pb-30 2row" >
						<thead>
							<tr class="">
								
							<th>Diploma</th>
							<th>Duration</th>
							<th>Designation</th>
							<th>Experience Duration</th>


							</tr>
						</thead>
						<tfoot>
							<tr>
								
								<th>Diploma</th>
								<th>Duration</th>
								<th>Designation</th>
								<th>Experience Duration</th>
								
							</tr>
						</tfoot>
						<tbody id="programmeData">
					
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
<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	

<!-- <script src="vendors/bower_components/moment/min/moment.min.js"></script> -->
<!-- <script src="vendors/bower_components/FooTable/compiled/footable.min.js" type="text/javascript"></script>
<script src="dist/js/footable-data.js"></script> -->
<script src="dist/js/jquery.slimscroll.js"></script>
<script src="dist/js/dropdown-bootstrap-extended.js"></script>
<script src="vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="vendors/bower_components/switchery/dist/switchery.min.js"></script>
<script src="dist/js/init.js"></script>


 <script src="vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
<!-- <script src="dist/js/simpleweather-data.js"></script> -->
<script src="vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
<script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
<script src="vendors/chart.js/Chart.min.js"></script>
<script src="vendors/bower_components/raphael/raphael.min.js"></script>
<script src="vendors/bower_components/morris.js/morris.min.js"></script>
<script src="vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){

$('#qualification').change(function() {
var qualification=$(this).val();  
var stream = $('#stream').val(); 
var gap = $('#gap').val(); 
var preferred_course = $('#preferred_course').val(); 
fileter(qualification,stream,gap,preferred_course);
})
$('#gap').change(function() {
var gap=$(this).val(); 
var qualification = $('#qualification').val(); 
var stream = $('#stream').val(); 
var preferred_course = $('#preferred_course').val(); 
fileter(qualification,stream,gap,preferred_course);
})
$('#preferred_course').change(function() {
var preferred_course=$(this).val(); 
var gap = $('#gap').val(); 
var qualification = $('#qualification').val(); 
var stream = $('#stream').val(); 
fileter(qualification,stream,gap,preferred_course);
})
$('#stream').change(function() {
var stream=$(this).val(); 
var preferred_course = $('#preferred_course').val(); 
var gap = $('#gap').val(); 
var qualification = $('#qualification').val(); 
fileter(qualification,stream,gap,preferred_course);
})
})


 function fileter(qualification,stream,gap,preferred_course)
{

// $('#datable_1_wrapper').html('');
	// $('#datable_1').DataTable().clear().destroy();

  $.ajax({
type: "post", 
url: 'ajax/getGapData.php',
data: {qualification:qualification,stream:stream,gap:gap,preferred_course:preferred_course,type:'filter'}, //set data

success: function (response) {
$('#datable_1').DataTable().clear().destroy();
$("#programmeData").html(response);
}
});
};


</script>

<script src="js/change-status.js"></script>


</body>
</html>



