<?php 
include('../include/config.php');
include("../include/functions.php");
$where='';
$i=0;
$whr="";  


if($_REQUEST['type']=='filter'){

	if (!empty($_POST["country_id"])) {
	  $cid=$_POST["country_id"];
	  $whr.="and country='$cid'";
	}

	if (!empty($_POST["state_id"])) {
	  $sid=$_POST["state_id"];
	  $whr.=" and state='$sid'";
	}

	if (!empty($_POST["univercity"])) {
	  $univerid=$_POST["univercity"];
	  $whr.=" and univercity='$univerid'";
	} 

	if (!empty($_POST["programme_level"])) {     
	  $programme_level=$_POST["programme_level"];
	  $whr .=" and program_level like '%$programme_level%'";
	} 
	if (!empty($_POST["stream"])) {
	  $stream=$_POST["stream"];
	  //$whr .=" and FIND_IN_SET('$stream', stream)";
	  $whr .=" and stream like '%$stream%'";
	} 

	if (!empty($_POST["percentage"])) {
	  $percentage=explode('-',$_POST["percentage"]);
	  $whr .=" and percentage between $percentage[0] and $percentage[1]";
	} 
	if (!empty($_POST["intake"])) {
	  $intake=$_POST["intake"];
	  $whr .=" and intake like '%$intake%'";
	} 
	if (!empty($_POST["student_bachelor"])) {
	   $student_bachelor=$_POST["student_bachelor"];
	  $whr .=" and student_bachelors like '%$student_bachelor%'";
	} 
	if (!empty($_POST["course_type"])) {
	   $course_type=$_POST["course_type"];
	  $whr .=" and course_type like '%$course_type%'";
	} 

	if (!empty($_POST["multipalData"])) {
		$mpid=$_POST["multipalData"];
		if ($mpid==1) {
		$whr.=" and ielts!='' and ielts!='0'";
		}
		if ($mpid==2) {
		$whr.=" and pte!='' and pte!='0'";
		}
		if ($mpid==3) {
		$whr.=" and duolingo!='' and duolingo!='0'";
		}
		if ($mpid==4) {
		$whr.=" and tofel!='' and tofel!='0'";
		}
		if ($mpid==5) {
			$whr.=" and moi!='' and moi!='0'";
		}
	}

	if (!empty($_POST["global_search"])) {
	   $global_search=$_POST["global_search"];
	   $whr .=" and ( program_level like '%$global_search%' OR stream like '%$global_search%' OR course_name like '%$global_search%' OR intake like '%$global_search%' OR program_duration like '%$global_search%' OR tuition_fee like '%$global_search%' OR student_bachelors like '%$global_search%' OR percentage like '%$global_search%' OR ielts like '%$global_search%' OR pte like '%$global_search%' OR duolingo like '%$global_search%' OR tofel like '%$global_search%' OR moi like '%$global_search%' OR fees like '%$global_search%')";
	} 

// echo $whr;
if ($whr !='') {
$mSql = $obj->query("select * from $tbl_programmes where status=1 $whr group by course_name asc",$debug = -1); //die;
$numRows=$obj->numRows($mSql);
if ($numRows>=1) {
while($pline=$obj->fetchNextObject($mSql)){
?>
<tr>
						<td style="padding:0px !important;">
							<div class="prgrm-data_section">
							<?php if ($pline->program_duration!='' && $pline->program_duration!='0') { ?>
						    <span><?php echo $pline->program_duration; ?></span>	
							<?php } ?>
							<h4 class="my-3" style="font-size: 20px;"><?php echo $pline->course_name ?> <?=$pline->country == 3 && $pline->course_type!=null ? '('.$pline->course_type.')' : ''?></h4>
							<h5 class="my-3"><?php echo $pline->program_level ?></h5>
							<p><?php echo getField('name','tbl_univercity',$pline->univercity) ?></p>
							<p><?php echo getField('name','tbl_country',$pline->country) ?>, <?php echo getField('state','tbl_state',$pline->state) ?></p>
							

							<?php if ($pline->intake!='') { ?>
								<div class="details_list last-tab">
								<span style="text-decoration:underline;">Intake</span>
								<p><?php echo $pline->intake; ?></p>
							 </div>
							<?php } ?>


							
							<div class="prgrm_details">
							<?php if ($pline->percentage!='') { ?>
                             <div class="details_list">
								<span >Required Percentage</span>
								<p><?php echo $pline->percentage ?>%</p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->ielts!='' && $pline->ielts!=0) { ?>
							 <div class="details_list">
								<span>IELTS</span>
								<p><?php echo $pline->ielts ?></p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->pte!='' && $pline->pte!='0') { ?>
							 <div class="details_list">
								<span>PTE </span>
								<p><?php echo $pline->pte ?></p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->duolingo!='' && $pline->duolingo!='0') { ?>
							 <div class="details_list">
								<span>Duolingo</span>
								<p><?php echo $pline->duolingo ?></p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->tofel!='' && $pline->tofel!='0') { ?>
							  <div class="details_list">
								<span>TOEFL</span>
								<p><?php echo $pline->tofel ?></p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->moi!='' && $pline->moi!='0') { ?>
							  <div class="details_list">
								<span><?=$pline->country == 6 ? 'Fees Before Interview': 'MOI'?></span>
								<p><?php echo $pline->moi ?></p>
							 </div>
							 <?php } ?>
							<?php if ($pline->tuition_fee!='' && $pline->tuition_fee!='0') { ?>
                             <div class="details_list">
								<span >Programme Fee</span>
								<p><?php echo $pline->tuition_fee ?></p>
							 </div>
							 <?php } ?>
							 
							 <?php if ($pline->fees!='' && $pline->fees!='0') { ?>
							  <div class="details_list">
								<span>120 Fee </span>
								<p><?php echo $pline->fees ?></p>
							 </div>
							 <?php } ?>

							 <?php if ($pline->student_bachelors!='') { ?>
								<div class="details_list">
								<span style="text-decoration:underline;">Bachelor’s Duration</span>
								<p><?php echo $pline->student_bachelors; ?></p>
							 </div>
							<?php } ?>


							</div>

							<div class="prgrm_details">
							<?php if ($pline->scholarship!='') { ?>
                             <div class="details_list">
								<span >Scholarship</span>
								<p>$<?php echo $pline->scholarship ?></p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->scholarship_percentage!='') { ?>
                             <div class="details_list">
								<span >Scholarship Percentage</span>
								<p><?php echo $pline->scholarship_percentage ?>%</p>
							 </div>
							 <?php } ?>
							 <?php if ($pline->special_requirement!='') { ?>
                             <div class="details_list">
								<span >Special Requirement</span>
								<p><?php echo $pline->special_requirement ?></p>
							 </div>
							 <?php } ?>

							</div>
						</td>
					</tr>
							
<tr>
	<td style="padding:0px !important;">
	</td>
</tr>






<?php $i++; } 
}
}
 }

?>



<!-- <script src="dist/js/dataTables-data.js"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
	"use strict";
	// $('#datable_1').DataTable().clear().destroy();
	$('#datable_1').DataTable();
} );
</script>



