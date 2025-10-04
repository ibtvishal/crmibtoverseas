<?php
include("include/config.php");
include("include/functions.php");

if($_GET['did']){

	$aSql=$obj->query("select a.stu_name,a.father_name,a.dob,b.mother_name,b.roll_no_1,b.time_duration,b.start_date,b.end_date,b.institute_id,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id  where b.id='".$_GET['did']."'",$debug=-1);
	$aResult = $obj->fetchNextObject($aSql);

	$sdyear = CalculateRollTime($aResult->start_date,$aResult->end_date);

if($sdyear >= 1){
	$cd = "Certificate";
}
if($sdyear >= 2){
	$cd = "Diploma";
}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Log in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			downloadPDF();
		})
	</script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
<script type="text/javascript">
function downloadPDF(){
	var container = document.getElementById("recieptcontainer"); // full page 
	//var container = document.getElementById("printDiv");; // full page 
	html2canvas(container,{allowTaint : true}).then(function(canvas) {

	var imgData = canvas.toDataURL('image/png');
	console.log('Report Image URL: '+imgData);
	var doc = new jsPDF('p', 'mm', [150, 150]); //210mm wide and 297mm high

	doc.addImage(imgData, 'PNG', 0, 0);
	doc.save('diploma.pdf');
	window.location.href = "student-diploma.php";
});

}
</script>
</head>
<body>
<style type="text/css">
	.e-sign{
		position: absolute;
	    right: 0;
	    bottom: 45%;
	    width: 160px;
	}
</style>
<section>
<div class="secprint" id="recieptcontainer">
	<div class="printpage">
		<div class="table-responsive" style="margin:50px 0px 0px 30px">
			  <p>This is to certify that Mr/Ms. <strong><?php echo $aResult->stu_name; ?></strong> Son/Daughter of Sh. <strong><?php echo $aResult->father_name; ?></strong><br> and Smt. <strong><?php echo $aResult->mother_name; ?></strong>  having D.0.B.<strong><?php echo $aResult->dob; ?></strong> and Roll No. <strong><?php echo $aResult->roll_no_1; ?></strong> <br>has successfully completed the training program <br><strong><?php echo $cd; ?></strong> in <strong><?php echo $aResult->diploma_name; ?></strong> from <strong><?php echo getField('name',$tbl_institute,$aResult->institute_id); ?> </strong> with Grade A of duration.<br> <strong><?php echo $aResult->time_duration; ?></strong> conducted from <strong><?php echo $aResult->start_date; ?></strong> to <strong><?php echo $aResult->end_date; ?></strong><br> hereby awarded with this certificate.</p>
		</div>
	</div>  	
</div>
</section>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

