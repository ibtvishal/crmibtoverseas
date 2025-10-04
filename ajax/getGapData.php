<?php 
include('../include/config.php');
include("../include/functions.php");
$where='';



  $i=0;
  $whr="";

if($_REQUEST['type']=='filter'){



if (!empty($_POST["qualification"])) {
      $qualification=$_POST["qualification"];
      $whr.="and qualification='$qualification'";
  }

if (!empty($_POST["gap"])) {
      $gap=$_POST["gap"];
      $whr.="and gap='$gap'";
  }

  if (!empty($_POST["preferred_course"])) {
     
      $preferred_course=$_POST["preferred_course"];
      $whr .="and preferred_course like '%$preferred_course%'";
  } 
  if (!empty($_POST["stream"])) {
       $stream=$_POST["stream"];
      $whr .="and stream like '%$stream%'";
  } 

if ($whr !='') {

$mSql = $obj->query("select * from $tbl_gap where status=1 $whr ",$debug=-1); //die;

$numRows=$obj->numRows($mSql);

if ($numRows>=1) {
while($pline=$obj->fetchNextObject($mSql)){

$diplomaArr = explode(',',$pline->diploma);
$designationArr = explode(',',$pline->designation);



?>


<tr>
	<th>
    <?php foreach($diplomaArr as $DR){
    echo $DR;
    echo "<br>";
    } ?>
  </th>
  <th><?php echo $pline->duration ?></th>
  <th>
    <?php foreach($designationArr as $design){
    echo $design;
    echo "<br>";
    } ?>
  <th><?php echo $pline->exp_duration ?></th>
  </th>
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



