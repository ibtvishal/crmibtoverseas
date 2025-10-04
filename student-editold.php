<?php 
include('include/config.php');
include("include/functions.php");
validate_user();


if($_REQUEST['userDetails']=='yes'){
$stu_name=$obj->escapestring($_POST['stu_name']);
$father_name=$obj->escapestring($_POST['father_name']);
$dob=$obj->escapestring($_POST['dob']);
$passport_no=$obj->escapestring($_POST['passport_no']);
$country_id=$obj->escapestring($_POST['country_id']);
$visa_id=$obj->escapestring($_POST['visa_id']);
$am_id=$obj->escapestring($_POST['am_id']);
$id=$obj->escapestring($_POST['id']);

$obj->query("update $tbl_student set stu_name='$stu_name',father_name='$father_name',dob='$dob',passport_no='$passport_no',country_id='$country_id',visa_id='$visa_id',am_id='$am_id' where id=".$id,-1); //die;
$_SESSION['sess_msg']='Student updated sucessfully';   
header("location:student-list.php");
exit();
}


if ($_REQUEST['userRecovery']=='yes') {
    $emailId=$obj->escapestring($_REQUEST['offical_email']);
    $recovery_email=$obj->escapestring($_REQUEST['recovery_email']);
if ($emailId!=$recovery_email) {        
$obj->query("insert into $tbl_user_recovery set user_id='".$obj->escapestring($_REQUEST['user_id'])."',student_id='".$obj->escapestring($_REQUEST['student_id'])."',offical_email='".$obj->escapestring($_REQUEST['offical_email'])."',password='".$obj->escapestring($_REQUEST['password'])."',recovery_email='".$obj->escapestring($_REQUEST['recovery_email'])."',recovery_number='".$obj->escapestring($_REQUEST['recovery_number'])."'",-1); //die; 
$_SESSION['sess_msg']='Student updated sucessfully';   
header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($obj->escapestring($_REQUEST['student_id'])))));
}
$_SESSION['sess_msg']='Both are email id same '; 
header("location:student-editf.php?id=".base64_encode(base64_encode(base64_encode($obj->escapestring($_REQUEST['student_id'])))));

}    

if($_REQUEST['id']!=''){
$sql=$obj->query("select * from $tbl_student where id=".base64_decode(base64_decode(base64_decode($_REQUEST['id']))),-1); //die;
$result=$obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('head.php'); ?>
<link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
</head>
<style>

.document-new-class{
margin-top: 10px;   
}

.document-new-class img{
	height: 150px !important;
	width: 150px !important;
	padding: 5px;
}

.upload-files-container {

width: 175px;
height: 230px;
border: 1px solid #000;
display: flex;
align-items: center;
justify-content: center;
flex-direction: column;
margin-top: 10px;
}
.drag-file-area {

border-radius: 40px;
margin: 10px 0 15px;

width: 100%;
text-align: center;
}
.drag-file-area .upload-icon {
font-size: 50px;
}
.drag-file-area h3 {
font-size: 13px;
margin: 15px 0;
}
.drag-file-area label {
font-size: 14px;
}
.drag-file-area label .browse-files-text {
color: #363e91;
font-weight: bolder;
cursor: pointer;
}
.browse-files span {
position: relative;
top: -25px;
}
.default-file-input {
opacity: 0;
}
.cannot-upload-message {
background-color: #ffc6c4;
font-size: 17px;
display: flex;
align-items: center;
margin: 5px 0;
padding: 5px 10px 5px 30px;
border-radius: 5px;
color: #BB0000;
display: none;
}
@keyframes fadeIn {
0% {opacity: 0;}
100% {opacity: 1;}
}
.cannot-upload-message span, .upload-button-icon {
padding-right: 10px;
}
.cannot-upload-message span:last-child {
padding-left: 20px;
cursor: pointer;
}
.file-block {
color: #f7fff7;
background-color: #7b2cbf;
transition: all 1s;
width: ;
position: relative;
display: none;
flex-direction: row;
justify-content: space-between;
align-items: center;
margin: 10px 0 15px;
padding: 10px 20px;
border-radius: 25px;
cursor: pointer;
}
.file-info {
display: flex;
align-items: center;
font-size: 15px;
}
.file-icon {
margin-right: 10px;
}
.file-name, .file-size {
padding: 0 3px;
}
.remove-file-icon {
cursor: pointer;
}
.progress-bar {
display: flex;
position: absolute;
bottom: 0;
left: 4.5%;
width: 0;
height: 5px;
border-radius: 25px;
background-color: #4BB543;
}
.upload-button {
font-family: 'Montserrat';
background-color: #7b2cbf;
color: #f7fff7;
display: flex;
align-items: center;
font-size: 18px;
border: none;
border-radius: 20px;
margin: 10px;
padding: 7.5px 50px;
cursor: pointer;
}
.upload-button1 {
    position: relative;
     
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform .4s;
      position: absolute;
    top: 40%;
    left: 40%;
      
color: #000;
}
.drag-file-area .label img {
height: 30px;
position: absolute;
right: 45%;
top: 45%;
}
.documnt {
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
margin-top: 10px;
position: relative;
}

.documnt1 {
display: flex;
flex-direction: column;
justify-content: center;
align-items: center;
margin-top: 10px;
}
#appdatable_1_length{display: none;}
#statusdatable_1_length{display: none;}



h3 {
line-height: 30px;
text-align: center;
}

#drop_file_area1 {
height: 150px;
width: 150px;
border: 2px dashed #ccc;
line-height: 143px;
text-align: center;
font-size: 11px;
background: #f9f9f9;
margin-bottom: 15px;
}

#drop_file_area2 {
height: 150px;
width: 150px;
border: 2px dashed #ccc;
line-height: 143px;
text-align: center;
font-size: 11px;
background: #f9f9f9;
margin-bottom: 15px;
}

#drop_file_area3 {
height: 150px;
width: 150px;
border: 2px dashed #ccc;
line-height: 143px;
text-align: center;
font-size: 11px;
background: #f9f9f9;
margin-bottom: 15px;
}

#drop_file_area4 {
height: 150px;
width: 150px;
border: 2px dashed #ccc;
line-height: 143px;
text-align: center;
font-size: 11px;
background: #f9f9f9;
margin-bottom: 15px;
}

.drag_over {
color: #000;
border-color: #000;
}

.thumbnail {
width: 140px;
height: 150px !important;
padding: 2px;
margin: 2px;
border: 2px solid lightgray;
border-radius: 3px;
float: left;
}

#upload_file {
display: none;
}

</style>
<?php
if($_SESSION['level_id']==1 || $_SESSION['level_id']==2){
$readonly = "";
$udisabled = "";
}else{
$readonly = "readonly";
$udisabled = "disabled";
}
?>
<body>
<div class="preloader-it">
<div class="la-anim-1"></div>
</div>
<div class="wrapper theme-1-active pimary-color-green">
<?php include("header.php"); ?>
<?php include("menu.php"); ?>
<div class="page-wrapper">
<div class="container">

    <h5 style="text-align: center;
    color: red;"> <?php echo $_SESSION['sess_msg']; ?></h5>
<div class="student_filter">
<h4 class="my-3">Student Details</h4>
<form method="post" action="" >
<input type="hidden" name="userDetails" id="userDetails" value="yes">
<input type="hidden" name="id" id="id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
<div class="row">
<div class="col-md-2">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Student ID</div>
<input type="text"  class="form-control" id="student_no" name="student_no" placeholder="" value="<?php echo $result->student_no ?>" readonly>
</div>
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Name</div>
<input type="text" class="form-control" id="stu_name" name="stu_name" placeholder="" value="<?php echo $result->stu_name ?>" <?php echo $readonly ?>>
</div>
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Father's Name</div>
<input type="text" class="form-control" name="father_name" id="father_name" placeholder="" value="<?php echo $result->father_name ?>" <?php echo $readonly ?>>
</div>
</div>
</div>
<div class="col-md-2">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">D.O.B</div>
<input type="date" class="form-control" name="dob" id="dob" placeholder="" value="<?php echo $result->dob ?>" <?php echo $readonly ?> style="width: 133px;">
</div>
</div>
</div>
<div class="col-md-2">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Passport No.</div>
<input type="text" class="form-control" id="passport_no" name="passport_no" placeholder="" value="<?php echo $result->passport_no ?>" <?php echo $readonly ?>>
</div>
</div>
</div>
<div class="col-md-2">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Country</div>
<select class="form-control" name="country_id" id="country_id" <?php echo $udisabled; ?>>
<option value="">--Select your Country--</option>
<?php
$i=1;
$sql=$obj->query("select * from $tbl_country where status=1",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
<option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
<?php } ?>
</select>

</div>
</div>
</div>
<div class="col-md-2">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Visa Type</div>
<select class="form-control" name="visa_id" id="visa_id" <?php echo $udisabled; ?>>
<option value="">--Select your Visa Type--</option>
<option value="1" <?php if($result->visa_id==1){?> selected <?php } ?>>Study Visa</option>
<option value="2" <?php if($result->visa_id==2){?> selected <?php } ?>>Tourist Visa</option>
<option value="3" <?php if($result->visa_id==3){?> selected <?php } ?>>Visitor Visa</option>
<option value="4" <?php if($result->visa_id==4){?> selected <?php } ?>>Work Visa</option>
</select>
</div>
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Counsellor Name</div>
<input type="text" class="form-control" id="exampleInputuname_1" placeholder="" value="<?php echo getField('name',$tbl_admin,$result->c_id); ?>" readonly>
</div>
</div>
</div>
<div class="col-md-3">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Account Manager</div>									
<select class="form-control" name="am_id" id="am_id" <?php echo $udisabled; ?>>
<option value=""><--Select--></option>
<?php
$sql=$obj->query("select * from $tbl_admin where 1=1 and status=1 and FIND_IN_SET('$result->branch_id',branch_id) and level_id in (2,3)",-1); //die;

while($resultt=$obj->fetchNextObject($sql)){?>
<option value="<?php echo $resultt->id ?>"<?php if($resultt->id==$result->am_id){?>selected<?php } ?>><?php echo $resultt->email ?></option>
<?php } ?>
</select>
</div>
</div>
</div>
<?php
if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2) {?>
<div class="col-md-2">
<button type="submit"  class="btn mr-10">Submit</button>
</div>
<?php } ?>
</div>
</form>
</div>

<div class="">
<div class="panel panel-default card-view" style="background:transparent;">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="tab-struct custom-tab-1 mt-40">
<ul role="tablist" class="nav nav-tabs" id="myTabs_7">
<li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab"
role="tab" id="home_tab_7" href="#home_7">Documents</a></li>

<!-- <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7"
role="tab" href="javascript:void(0);" aria-expanded="false">Application</a></li>
<li class="" role="presentation"><a aria-expanded="true" data-toggle="tab"
role="tab" id="status_tab_7" href="javascript:void(0);">Status</a></li> -->

<li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7"
role="tab" href="#profile_7" aria-expanded="false">Application</a></li>
<li class="" role="presentation"><a aria-expanded="true" data-toggle="tab"
role="tab" id="status_tab_7" href="#status_7">Status</a></li>

<li role="presentation" class=""><a data-toggle="tab" id="notes_tab_7"
role="tab" href="#notes_7" aria-expanded="false">Notes</a></li>
</ul>
<div class="tab-content" id="myTabContent_7">
<div id="home_7" class="tab-pane fade active in" role="tabpanel">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="pills-struct vertical-pills">
<ul role="tablist" class="nav nav-pills ver-nav-pills"
id="myTabs_10">
<li class="active" role="presentation"><a
aria-expanded="true" data-toggle="tab"
role="tab" id="home_tab_10"
href="#home_10">Academics</a></li>
<li role="presentation" class=""><a data-toggle="tab"
id="profile_tab_10" role="tab"
href="#profile_10"
aria-expanded="false">Language Proficiency</a>
</li>
<li role="presentation" class=""><a data-toggle="tab"
id="profile_tab_11" role="tab"
href="#profile_11"
aria-expanded="false">Financial</a></li>
<li role="presentation" class=""><a data-toggle="tab"
id="profile_tab_12" role="tab"
href="#profile_12" aria-expanded="false">CA
Report</a></li>
<li role="presentation" class=""><a data-toggle="tab"
id="profile_tab_13" role="tab"
href="#profile_13" aria-expanded="false">Trash Documents </a></li>
</ul>
<div class="tab-content" id="myTabContent_10">
<div id="home_10" class="tab-pane fade active in"
role="tabpanel">
<div class="acedmics-certificate">
<form method="post" action="">
<input type="hidden" name="dtype" id="dtype1" value="1">
<input type="hidden" name="stu_id" id="stu_id1" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
<div class="row">
<div class="col-md-2 col-12 documnt">            
<div id="drop_file_area1">
    <label class="upload-area">
    <input type="file" multiple id="gallery-photo-add1" style="    height: 150;
    width: 145px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background-color: #DDF;
    opacity: 0;">
    <span class="upload-button1">
      <i class="fas fa-upload" style="font-size:24px;"></i>
    </span>
  </label>
</div>
</div>
<div id="uploaded_file1"></div>
<?php
$fsql = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=1 and status=1");
while($fResult = $obj->fetchNextObject($fsql)){
if ($fResult->desiredExt=='jpg') {?>
<div class="col-md-2 col-12 documnt">
<img src="uploads/<?php echo $fResult ->name; ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult ->id ?>)"></a>
</div>
<?php }else{ ?>
<div class="col-md-2 col-12 documnt">
    <a href="uploads/<?php echo $fResult ->name ?>" download >
<img src="uploads/download.png ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
</a>
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult ->id ?>)"></a>
</div>
<?php } }?>
</div> 
</form>
</div>
</div>
<div id="profile_10" class="tab-pane fade"
role="tabpanel">
<div class="acedmics-certificate">
<form method="post" action="">
<input type="hidden" name="dtype" id="dtype2" value="2">
<input type="hidden" name="stu_id" id="stu_id2" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
<div class="row">
<div class="col-md-2 col-12 documnt">            
<div id="drop_file_area2">
    <label class="upload-area">
    <input type="file" multiple id="gallery-photo-add" style="    height: 150;
    width: 145px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background-color: #DDF;
    opacity: 0;">
    <span class="upload-button1">
      <i class="fas fa-upload" style="font-size:24px;"></i>
    </span>
  </label>
</div>
</div>
<div id="uploaded_file2"></div>
<?php
$fsql2 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=2 and status=1");
while($fResult2 = $obj->fetchNextObject($fsql2)){
if ($fResult2->desiredExt=='jpg') {?>
<div class="col-md-2 col-12 documnt">
<img src="uploads/<?php echo $fResult2->name; ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult2->id ?>)"></a>
</div>
<?php }else{ ?>
<div class="col-md-2 col-12 documnt">
    <a href="uploads/<?php echo $fResult2->name ?>" download >
<img src="uploads/download.png ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
</a>
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult2->id ?>)"></a>
</div>
<?php } }?>
</div> 
</form>
</div>
</div>
<div id="profile_11" class="tab-pane fade "
role="tabpanel">
<div class="acedmics-certificate">
<form method="post" action="">
<input type="hidden" name="dtype" id="dtype3" value="3">
<input type="hidden" name="stu_id" id="stu_id3" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
<div class="row">
<div class="col-md-2 col-12 documnt">            
<div id="drop_file_area3">
    <label class="upload-area">
    <input type="file" multiple id="gallery-photo-add3" style="    height: 150;
    width: 145px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background-color: #DDF;
    opacity: 0;">
    <span class="upload-button1">
      <i class="fas fa-upload" style="font-size:24px;"></i>
    </span>
  </label>
</div>
</div>
<div id="uploaded_file3"></div>
<?php
$fsql3 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=3 and status=1");
while($fResult3 = $obj->fetchNextObject($fsql3)){
if ($fResult3->desiredExt=='jpg') {?>
<div class="col-md-2 col-12 documnt">
<img src="uploads/<?php echo $fResult3->name; ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult3->id ?>)"></a>
</div>
<?php }else{ ?>
<div class="col-md-2 col-12 documnt">
    <a href="uploads/<?php echo $fResult3->name ?>" download >
<img src="uploads/download.png ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
</a>
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult3->id ?>)"></a>
</div>
<?php } }?>
</div> 
</form>
</div>
</div>
<div id="profile_12" class="tab-pane fade"
role="tabpanel">
<div class="acedmics-certificate">
<form method="post" action="">
<input type="hidden" name="dtype" id="dtype4" value="4">
<input type="hidden" name="stu_id" id="stu_id4" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">    
<div class="row">
<div class="col-md-2 col-12 documnt">            
<div id="drop_file_area4">
    <label class="upload-area">
    <input type="file" multiple id="gallery-photo-add4" style="    height: 150;
    width: 145px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    background-color: #DDF;
    opacity: 0;">
    <span class="upload-button1">
      <i class="fas fa-upload" style="font-size:24px;"></i>
    </span>
  </label>
</div>
</div>
<div id="uploaded_file4"></div>
<?php
$fsql4 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and dtype=4 and status=1");
while($fResult4 = $obj->fetchNextObject($fsql4)){
    if ($fResult4->desiredExt=='jpg') {?>
<div class="col-md-2 col-12 documnt">
<img src="uploads/<?php echo $fResult4->name; ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult4->id ?>)"></a>
</div>
<?php }else{ ?>
<div class="col-md-2 col-12 documnt">
    <a href="uploads/<?php echo $fResult4->name ?>" download >
<img src="uploads/download.png ?>" alt="" style="width: 140px;
    height: 150px;
    border: 1px solid #7777;
    padding: 3px;
    margin: 0px 10px;
">
</a>
<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,<?php echo $fResult4->id ?>)"></a>
</div>
<?php } }?>
</div> 
</form> 
</div>
</div>
<div id="profile_13" class="tab-pane fade"
role="tabpanel">
<div class="acedmics-certificate">
<div class="row">
<?php
$fsql4 = $obj->query("select * from $tbl_student_document where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' and status=0");
while($fResult4 = $obj->fetchNextObject($fsql4)){

if ($fResult4->desiredExt=='pdf') {?>
   <div class="col-md-2 col-12 documnt">
<img src="uploads/download.png" alt="" style="width: 140px; height: 150px;">
<a href="javascript:void(0);" class="documnet-undo" onclick="documentundo(this,<?php echo $fResult4->id ?>)"></a>
</div>
<?php }else{?>

    <div class="col-md-2 col-12 documnt">
<img src="uploads/<?php echo $fResult4->name; ?>" alt="" style="width: 140px; height: 150px;">
<a href="javascript:void(0);" class="documnet-undo" onclick="documentundo(this,<?php echo $fResult4->id ?>)"></a>
</div>
    <?php
}

 }?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="profile_7" class="tab-pane fade" role="tabpanel">
<div class="table-wrap">
<div class="table-responsive">
<?php
$usql=$obj->query("select * from $tbl_user_recovery where student_id='$result->id'",-1);
$uresult=$obj->fetchNextObject($usql);
?>
<div class="student_filter application_filter">
<form method="post" action="" >
<input type="hidden" name="uid" id="uid" value="<?php echo $uresult->id ?>">
<input type="hidden" name="userRecovery" id="userRecovery" value="yes">
<input type="hidden" name="user_id" id="user_id" value="<?php print_r($_SESSION['sess_admin_id']); ?>">
<input type="hidden" name="student_id" id="student_id" value="<?php echo $result->id; ?>">
<div class="row">
<div class="col-md-3" style="padding-right:5px; padding-left:5px">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Offical Email</div>
<input type="email"  class="form-control" id="offical_email" name="offical_email" placeholder="" value="<?php echo $uresult->offical_email ?>" required <?php if($uresult->offical_email!=''){?> readonly <?php } ?>>
</div>
</div>
</div>
<div class="col-md-2" style="padding-right:5px; padding-left:5px">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Password</div>
<input type="text" class="form-control" id="password" name="password" placeholder="" value="<?php echo $uresult->password ?>" required <?php if($uresult->password!=''){?> readonly <?php } ?>>
</div>
</div>
</div>
<div class="col-md-3" style="padding-right:5px; padding-left:5px">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Recovery Email</div>
<input type="email" class="form-control" name="recovery_email" id="recovery_email" placeholder="" value="<?php echo $uresult->recovery_email ?>" required <?php if($uresult->recovery_email!=''){?> readonly <?php } ?>>
</div>
</div>
</div>
<div class="col-md-3" style="padding-right:5px; padding-left:5px">
<div class="form-group">
<div class="input-group">
<div class="input-group-addon">Recovery Number</div>
<input type="number" class="form-control" name="recovery_number" id="recovery_number" placeholder="" value="<?php echo $uresult->recovery_number ?>" required maxlength="11" minlength="10" <?php if($readonly!=''){?> readonly <?php } ?>>
</div>
</div>
</div>
<?php if($readonly==''){?>
<div class="col-md-1" style="padding-right:5px; padding-left:5px">
<button type="submit"  class="btn btn-sm mr-10">Submit</button>
</div>
<?php }?>

</div>
</form>
</div>
<?php if ($uresult->id !='') {?>
<table id="appdatable_1" class="table table-hover display  pb-30" >
<thead>
<tr>
<th>Id</th>
<th>Institution Name</th>
<th>Location</th>
<th>Course</th>
<th>Intake</th>
<th>Year</th>
<th>Status</th>
<th>Edit</th>
</tr>
</thead>

<tbody>
<?php
$i=1;
$sql=$obj->query("select * from $tbl_student_application where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."'",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $line->college_name ?></td>
<td><?php echo $line->location ?></td>
<td><?php echo $line->course ?></td>
<td><?php echo $line->month ?></td>
<td><?php echo $line->year ?></td>
<td> <?php 
if($line->status==0){
echo "Pending";
}else if($line->status==1){
echo "Process";
}else if($line->status==2){
echo "Review";
}else if($line->status==3){
echo "Approved";
}else if($line->status==4){
echo "Canceled";
}
?>
</td>
<td>
<a href="javascript:void(0);" onclick="getAppModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
<a href="student-aaplication-del.php?aid=<?php echo $line->id ?>&stu_id=<?php echo  $_REQUEST['id'] ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
</tr>
<?php ++$i;} ?>
</tbody>
</table>
<?php } ?>
</div>
</div>
<?php if ($uresult->id !='' && $_SESSION['level_id']!=4 ) {?>
<button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowAppModal()" class="add-application">Add
Application</a></button>
<?php } ?>

</div>

<div id="status_7" class="tab-pane fade " role="tabpanel">
<?php
if($result->am_id!=0){?>
<div class="table-wrap">
<div class="table-responsive">

<table id="statusdatable_1" class="table table-hover display  pb-30">
<thead>
<tr>
<th>DATE</th>
<th>TIME</th>
<th>STAGE</th>
<th>STATUS</th>
<th>REMARKS</th>
<th>ADDED BY</th>
<th>Edit</th>
</tr>
</thead>

<tbody>
<?php
$i=1;
$sql=$obj->query("select * from $tbl_student_status where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."' ",$debug=-1);
while($line=$obj->fetchNextObject($sql)){?>
<tr>
<td><?php echo date('d-M-Y',strtotime($line->cdate)); ?></td>
<td><?php echo date('h:i a',strtotime($line->cdate)); ?></td>
<td><?php echo getField('stage',$tbl_stage,$line->stage_id); ?></td>
<td> <?php echo $line->cstatus?>
</td>
<td><?php echo $line->remarks ?></td>
<td><?php echo getField('name',$tbl_admin,$line->user_id) ?></td>
<td>
<a href="javascript:void(0);" onclick="getStatusModalData(<?php echo $line->id ?>)"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
<a href="student-aaplication-del.php?sid=<?php echo $line->id ?>&stu_id=<?php echo  $_REQUEST['id'] ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent; border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
</tr>
<?php ++$i;} ?>
</tbody>

</table>
</div>
</div>
<?php if ($_SESSION['level_id']!=4) { ?>
<button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowStatusModal()" class="add-application">Add Status</a></button>

<?php } }?>
</div>
<div id="notes_7" class="tab-pane fade" role="tabpanel">
<div class="panel panel-default card-view">
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="panel-group accordion-struct" id="accordion_1"
role="tablist" aria-multiselectable="true">

<?php 
$note=0;
$noteSql = $obj->query("select * from $tbl_student_notes where stu_id='".base64_decode(base64_decode(base64_decode($_REQUEST['id'])))."'");
while($noteResult = $obj->fetchNextObject($noteSql)){ $note++; ?>
<div class="panel panel-default">
<div class="panel-heading  <?php if($note==1){?> activestate <?php }?>" role="tab" id="heading_<?php echo $note; ?>">
<a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_<?php echo $note; ?>"  aria-expanded="false" class="collapsed ">
<?php echo getField('name',$tbl_admin,$noteResult->user_id); ?>
- 
<?php echo $noteResult->subject; ?>        

</a>
<div class="comment_icon">

<a href="javascript:void(0);" class="comment-box" onclick="showCommentBox(<?php echo $noteResult->id; ?>)"><span class="comment-box"><?php echo getField('stage',$tbl_stage,$noteResult->stage_id); ?> Stage</span><i></a>
</div> 
</div>
<div id="collapse_<?php echo $note; ?>" class="panel-collapse collapse <?php if($note==1){?> in <?php }?>" role="tabpanel" aria-expanded="false"
style="height: auto;">
<div class="panel-body pa-15">
<p> <?php echo $noteResult->remarks; ?></p>

<?php
$repSql = $obj->query("select * from $tbl_student_notes_comment where note_id='".$noteResult->id."'");
while($repResult = $obj->fetchNextObject($repSql)){?>
<div class="comments ml-30 ">
<div class="comment-header">
<p class="comment-author">
<i class="fa fa-user user-icon"></i><span class="comment-author-name" itemprop="name"><a href="" class="comment-author-link"><?php echo  getField('name','tbl_admin',$repResult->sender_id); ?></a></span></p>

<p class="comment-meta"><?php echo $repResult->cdate; ?></p>
</div>
<div class="comment-content" ><p><?php echo $repResult->comments; ?></p>
</div>
</div>
<div class="replies my-3"></div>
<?php }?>

</div>
</div>
</div>
<?php }?>
</div>
</div>
</div>
</div>
<?php if ($_SESSION['level_id']!=4) { ?>
<button class="application-btn btn"><a href="javascript:void(0);" onclick="ShowNotesModal()" class="add-application">Add Notes</a></button>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Add Comment -->
<div class="modal" id="student_comment" tabindex="-1" role="dialog">
<form method="post"  id="addcomment" name="addcomment">
<input type="text" name="note_id" id="note_id" value="">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Comment</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<div class="form-group">
<textarea name="comments" id="comments" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea> 
<span id="err_comment" style="color: red;"></span>  
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" id="btnSubmitComment">Submit</button>
</div>
</div>
</form>
</div>
</div>
<!-- Comment Section End -->
<!-- Add Application-->
<div class="modal fade" id="add_application" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
aria-hidden="true">×</span></button>
<h5 class="modal-title" id="applicationModalLabeladd">Add Application</h5>
</div>
<form  method="post" id="addApplication" name="addApplication">
<input type="hidden" name="appid" id="appid">
<input type="hidden" name="student_id" id="appstudent_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
<div class="modal-body">                

<div class="form-group">
<input type="text" class="form-control" name="collegename" id="appcollegename" placeholder="College Name">
<span id="err_appcollegename" style="color:red;"></span>
</div>
<div class="form-group">
<input type="text" class="form-control" name="location" id="applocation" placeholder="Location">
<span id="err_applocation" style="color:red;"></span>
</div>
<div class="form-group">
<input type="text" class="form-control" name="course" id="appcourse" placeholder="Course">
<span id="err_appcourse" style="color:red;"></span>
</div>

<div class="form-group">
<select class="form-control" name="month" id="appmonth" required="">
<option value="">Select Intake</option>
<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>
</select>
<span id="err_appmonth" style="color:red;"></span>
</div>
<div class="form-group">
<select class="form-control" name="year" id="appyear" required="">
<option value="">Select Year</option>
<?php
$date = date('Y');
$newDate = date('Y', strtotime($date. ' + 5 years'));

for($i=2023; $i < $newDate; $i++){?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php }?>
</select>
<span id="err_appyear" style="color:red;"></span>
</div>

<div class="form-group app_status">
<select class="form-control" name="app_status" id="app_status" required="">
<option value="">Select Status</option>
<option value="0">Pending</option>
<option value="1">Process</option>
<option value="2">Review</option>
<option value="3">Approved</option>
<option value="4">Canceled</option>
</select>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="btnSubmitApplication" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
</div>
</div>
<!------------------------------------------->

<!-- Add Status-->
<div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
aria-hidden="true">×</span></button>
<h5 class="modal-title" id="statusModalLabeladd">Add Status</h5>
</div>
<form  method="post" id="addStatus" name="addStatus">
<input type="hidden" name="statusid" id="statusid">
<input type="hidden" name="statusstudent_id" id="status_student_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
<div class="modal-body">                

<div class="form-group">
<select class="form-control" name="status_stage" id="status_stage" required="">
<option value="">Select Stage</option>
<?php 

// $query = $obj->query("SELECT tbl_stage.* FROM tbl_student_status , tbl_stage WHERE tbl_stage.country_id = '$result->country_id' And tbl_student_status.stu_id = '$result->id' AND tbl_stage.id!= tbl_student_status.stage_id",-1);//die;



$ssql = $obj->query("select * from $tbl_stage where status=1 and country_id='".$result->country_id."'");
while($sResult = $obj->fetchNextObject($ssql)){

?>
<option value="<?php echo $sResult->id; ?>"><?php echo $sResult->stage; ?></option>
<?php  }?>

</select>
<span id="err_status_stage" style="color:red;"></span>
</div>
<div class="form-group">
<select class="form-control" name="status_status" id="status_status" required="">
<option value="">Select Status</option>
<!-- <option value="0">Pending</option>
<option value="1">Process</option>
<option value="2">Review</option>
<option value="3">Approved</option>
<option value="4">Canceled</option> -->
</select>
<span id="err_status_status" style="color:red;"></span>
</div>

<div class="form-group">
<textarea name="status_remarks" id="status_remarks" class="form-control"></textarea>
<span id="err_status_remarks" style="color:red;"></span>
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="btnSubmitStatus" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
</div>
</div>
<!-- -------------------------------------- -->
<div class="modal fade" id="add_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
aria-hidden="true">×</span></button>
<h5 class="modal-title" id="NotesModalLabeladd">Add Notes</h5>
</div>
<div class="modal-body">
<form method="post"  id="addnotes" name="addnotes">
<input type="hidden" name="notesid" id="notesid" value="">
<input type="hidden" name="notes_student_id" id="notes_student_id" value="<?php echo base64_decode(base64_decode(base64_decode($_REQUEST['id']))); ?>">
<div class="form-group">
<select class="form-control" name="notes_stage_id" id="notes_stage_id" required="">
<option value="">Stage</option>
<?php

$sql=$obj->query("select * from $tbl_stage where 1=1 and country_id='$result->country_id'",-1);
while($resultt=$obj->fetchNextObject($sql)){?>
<option value="<?php echo $resultt->id ?>"><?php echo $resultt->stage ?></option>
<?php } ?>
</select>
<span id="err_notes_stage_id" style="color:red;"></span>
</div>
<div class="form-group">
<input type="text" class="form-control" name="notes_subject" id="notes_subject" placeholder="Subject">
<span id="err_notes_subject" style="color:red;"></span>
</div>
<div class="form-group">
<textarea class="form-control" rows="3" placeholder="Remarks" id="notes_remarks" name="notes_remarks"></textarea>
<span id="err_notes_remarks" style="color:red;"></span>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="btnSubmitNotes" class="btn btn-primary">Submit</button>
</div>
</div>
</div>
</div>
<footer class="footer container-fluid pl-30 pr-30">
<div class="row">
<div class="col-sm-12">
<p>2017 &copy; Philbert. Pampered by Hencework</p>
</div>
</div>
</footer>
</div>

<?php include("footer.php"); ?>
</body>

<script type="text/javascript">
$(document).on('.collapse.in', '.panel-collapse', function (e) {
$(this).siblings('.panel-heading').addClass('activestate');
});

$(document).on('hide.bs.collapse', '.panel-collapse', function (e) {
$(this).siblings('.panel-heading').removeClass('activestate');
});
$(".panel-heading").on("click", function () {
$(".panel-heading").removeClass("activestate");
});

</script>


<script>




function documentdel(pthis,id){
$(pthis).parent('.documnt').remove();
$.ajax({
type: "GET", 
url: 'ajax/submitData.php',
data: {id:id,action:'getDocumentDel'}, //set data
beforeSend: function () {
},
success: function (data) {
location.reload();
//
}
});
}


function documentundo(pthis,id){
$(pthis).parent('.documnt').remove();
$.ajax({
type: "GET", 
url: 'ajax/submitData.php',
data: {id:id,action:'getDocumentUndo'}, //set data
beforeSend: function () {
},
success: function (data) {
location.reload();
}
});
}


//=============Comment Section Start=================
function showCommentBox(id){
$("#err_comment").hide();
$("#note_id").val(id);
$("#student_comment").modal('show');
}


$("#btnSubmitComment").on("click", function() {    
comments = $("#comments").val();
if(comments==''){
$("#err_comment").show().html("This field is required.");
return; 
}
note_id = $("#note_id").val();
$.ajax({
type: "POST", 
url: 'ajax/submitData.php', 
data: {'note_id':note_id,'comments':comments,'action':'addcomment'}, 
success: function (response) {
if(response==1){
$("#student_comment").modal('hide');
location.reload(true);
}
},
});
});


function ShowAppModal(){
$("#err_appcollegename").hide();
$("#err_applocation").hide();
$("#err_appcourse").hide();
$("#err_appmonth").hide();
$("#err_appyear").hide();
$("#applicationModalLabeladd").html("Add Application");
$("#appid").val("");
$("#appcollegename").val("");
$("#applocation").val("");
$("#appcourse").val("");
$(".app_status").hide();
$("#app_status").val("");    
$("#appmonth").val("");
$("#appyear").val("");
$("#add_application").modal('show');
}

function getAppModalData(id) 
{   

$("#applicationModalLabeladd").html("Update Application");
$.ajax({
type: "GET", 
url: 'ajax/getModalData.php',
data: {id:id,type:'getApplication'}, //set data
beforeSend: function () {
},
success: function (response) {
response = response.split('##');
$("#appid").val(response[0]);
$("#appcollegename").val(response[1]);
$("#applocation").val(response[2]);
$("#appcourse").val(response[3]);
$(".app_status").show();
$("#app_status").val(response[6]);
$("#appmonth").val(response[4]);
$("#appyear").val(response[5]);
$("#add_application").modal('show');
}
});
}

$("#btnSubmitApplication").on("click", function() {    
id = $("#appid").val();
student_id = $("#appstudent_id").val();
collegename = $("#appcollegename").val();
if(collegename==''){
$("#err_appcollegename").show().html("This field is required.");
return;
}
alocation = $("#applocation").val();
if(alocation==''){
$("#err_applocation").show().html("This field is required.");
return;
}
course = $("#appcourse").val();
if(course==''){
$("#err_appcourse").show().html("This field is required.");
return;
}
app_status = $("#app_status").val();
month = $("#appmonth").val();
if(month==''){
$("#err_appmonth").show().html("This field is required.");
return;
}
year = $("#appyear").val();
if(year==''){
$("#err_appyear").show().html("This field is required.");
return;
}
if(id==''){
action='addApplication';
}else{
action='updateApplication';      
}
$.ajax({
type: "POST", 
url: 'ajax/submitData.php', 
data: {'id':id,'student_id':student_id,'collegename':collegename,'location':alocation,'course':course,'app_status':app_status,'month':month,'year':year,'action':action}, 
success: function (response) {
if(response==1){
//console.log(response);
$("#add_application").modal('hide');
location.reload(true);
}
},
});
});



function ShowStatusModal(){
$("#err_status_stage").hide();
$("#err_status_status").hide();
$("#err_status_remarks").hide();
$("#statusModalLabeladd").html("Add Status");
$("#statusid").val("");
$("#status_stage").val("");
$("#status_status").val("");
$("#status_remarks").val("");
$("#add_status").modal('show');
}

function getStatusModalData(id) 
{   

$("#applicationModalLabeladd").html("Update Status");
$.ajax({
type: "GET", 
url: 'ajax/getModalData.php',
data: {id:id,type:'getStatus'}, //set data
beforeSend: function () {
},
success: function (response) {
response = response.split('##');
$("#statusid").val(response[0]);
$("#status_stage").val(response[1]);
$("#status_status").val(response[2]);
$("#status_remarks").val(response[3]);
$("#add_status").modal('show');
}
});
}

$("#btnSubmitStatus").on("click", function() {    
id = $("#statusid").val();
student_id = $("#status_student_id").val();
status_stage = $("#status_stage").val();
if(status_stage==''){
$("#err_status_stage").show().html("This field is required.");
return;
}
status_status = $("#status_status").val();
if(status_status==''){
$("#err_status_status").show().html("This field is required.");
return;
}
status_remarks = $("#status_remarks").val();
if(status_remarks==''){
$("#err_status_remarks").show().html("This field is required.");
return;
}

if(id==''){
action='addStatus';
}else{
action='updateStatus';      
}
$.ajax({
type: "POST", 
url: 'ajax/submitData.php', 
data: {'id':id,'student_id':student_id,'status_stage':status_stage,'status_status':status_status,'status_remarks':status_remarks,'action':action}, 
success: function (response) {
if(response==1){
$("#add_status").modal('hide');
location.reload(true);
}
},
});
});


function ShowNotesModal(){
$("#err_notes_stage_id").hide();
$("#err_notes_subject").hide();
$("#err_notes_remarks").hide();
$("#NotesModalLabeladd").html("Add Notes");
$("#notesid").val("");
$("#notes_stage_id").val("");
$("#notes_subject").val("");
$("#notes_remarks").val("");
$("#add_notes").modal('show');
}

function getNotesModalData(id) 
{   

$("#NotesModalLabeladd").html("Update Notes");
$.ajax({
type: "GET", 
url: 'ajax/getModalData.php',
data: {id:id,type:'getNotes'}, //set data
beforeSend: function () {
},
success: function (response) {
response = response.split('##');
$("#notesid").val(response[0]);
$("#notes_stage_id").val(response[1]);
$("#notes_subject").val(response[2]);
$("#notes_remarks").val(response[3]);
$("#add_notes").modal('show');
}
});
}

$("#btnSubmitNotes").on("click", function() {    
id = $("#notesid").val();
student_id = $("#notes_student_id").val();
notes_stage = $("#notes_stage_id").val();
if(notes_stage==''){
$("#err_notes_stage_id").show().html("This field is required.");
return;
}
notes_subject = $("#notes_subject").val();
if(notes_subject==''){
$("#err_notes_subject").show().html("This field is required.");
return;
}
notes_remarks = $("#notes_remarks").val();
if(notes_remarks==''){
$("#err_notes_remarks").show().html("This field is required.");
return;
}
if(id==''){
action='addNotes';
}else{
action='updateNotes';      
}
$.ajax({
type: "POST", 
url: 'ajax/submitData.php', 
data: {'id':id,'student_id':student_id,'notes_stage':notes_stage,'notes_subject':notes_subject,'notes_remarks':notes_remarks,'action':action}, 
success: function (response) {
if(response==1){
$("#add_notes").modal('hide');
location.reload(true);
}
},
});
});


$("#appcollegename").keypress(function(){
$("#err_appcollegename").hide();
})

$("#applocation").keypress(function(){
$("#err_applocation").hide();
})

$("#appcourse").keypress(function(){
$("#err_appcourse").hide();
})

$("#app_status").keypress(function(){
$("#err_app_status").hide();
})

$("#appmonth").keypress(function(){
$("#err_appmonth").hide();
})

$("#appyear").keypress(function(){
$("#err_appyear").hide();
})

$("#status_stage").change(function() {
//get the selected value
var id = this.value;

//make the ajax call
$.ajax({
type: "GET", 
url: 'ajax/getModalData.php',
data: {id:id,type:'getStageStatus'}, //set data
beforeSend: function () {
},
success: function (response) {
console.log(response);
$("#status_status").html(response);
}
});
});

$(function() {
var imagesPreview = function(input, placeToInsertImagePreview) {
dtype = $("#dtype2").val();
stu_id = $("#stu_id2").val();
$(this).removeClass('drag_over');
if (input.files) {
var filesAmount = input.files.length;
var formData = new FormData();
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.readAsDataURL(input.files[i]);
formData.append('file[]', input.files[i]);
formData.append('dtype', dtype);
formData.append('stu_id', stu_id);
}
uploadFormData(formData,2);
}
};
$('#gallery-photo-add').on('change', function() {
imagesPreview(this, 'div.gallery');
});
function uploadFormData(form_data,val) {
$.ajax({
url: "file_upload.php",
method: "POST",
data: form_data,
contentType: false,
cache: false,
processData: false,
success: function (data) {
$('#uploaded_file'+val).append(data);
}
});
}
});
$(function() {
var imagesPreview = function(input, placeToInsertImagePreview) {
dtype = $("#dtype1").val();
stu_id = $("#stu_id1").val();
$(this).removeClass('drag_over');
if (input.files) {
var filesAmount = input.files.length;
var formData = new FormData();
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.readAsDataURL(input.files[i]);
formData.append('file[]', input.files[i]);
formData.append('dtype', dtype);
formData.append('stu_id', stu_id);
}
uploadFormData(formData,1);
}
};
$('#gallery-photo-add1').on('change', function() {
imagesPreview(this, 'div.gallery');
});
function uploadFormData(form_data,val) {
$.ajax({
url: "file_upload.php",
method: "POST",
data: form_data,
contentType: false,
cache: false,
processData: false,
success: function (data) {
$('#uploaded_file'+val).append(data);
}
});
}
});
$(function() {
var imagesPreview = function(input, placeToInsertImagePreview) {
dtype = $("#dtype3").val();
stu_id = $("#stu_id3").val();
$(this).removeClass('drag_over');
if (input.files) {
var filesAmount = input.files.length;
var formData = new FormData();
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.readAsDataURL(input.files[i]);
formData.append('file[]', input.files[i]);
formData.append('dtype', dtype);
formData.append('stu_id', stu_id);
}
uploadFormData(formData,3);
}
};
$('#gallery-photo-add3').on('change', function() {
imagesPreview(this, 'div.gallery');
});
function uploadFormData(form_data,val) {
$.ajax({
url: "file_upload.php",
method: "POST",
data: form_data,
contentType: false,
cache: false,
processData: false,
success: function (data) {
$('#uploaded_file'+val).append(data);
}
});
}
});
$(function() {
var imagesPreview = function(input, placeToInsertImagePreview) {
dtype = $("#dtype4").val();
stu_id = $("#stu_id4").val();
$(this).removeClass('drag_over');
if (input.files) {
var filesAmount = input.files.length;
var formData = new FormData();
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.readAsDataURL(input.files[i]);
formData.append('file[]', input.files[i]);
formData.append('dtype', dtype);
formData.append('stu_id', stu_id);
}
uploadFormData(formData,4);
}
};
$('#gallery-photo-add4').on('change', function() {
imagesPreview(this, 'div.gallery');
});
function uploadFormData(form_data,val) {
$.ajax({
url: "file_upload.php",
method: "POST",
data: form_data,
contentType: false,
cache: false,
processData: false,
success: function (data) {
$('#uploaded_file'+val).append(data);
}
});
}
});




</script>
</html>