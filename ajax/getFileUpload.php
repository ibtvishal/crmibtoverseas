<?php 
include("../include/config.php");
include("../include/functions.php"); 

$did = $_POST['did'];
$action = $_POST['action'];
$type = $_POST['ttype'];
if($did!='' && $type==1){
    if($_FILES['file']['size']>0 && $_FILES['file']['error']==0){
      $img=$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/".$img);
    } 
    $obj->query("update $tbl_student_diploma set pimg = '$img' where id='$did'",-1); //die;
    echo 1;
}else if($did!='' && $type==2){
    if($_FILES['file']['size']>0 && $_FILES['file']['error']==0){
      $img=$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/".$img);
    } 
    $obj->query("update $tbl_student_experience set pimg = '$img' where id='$did'",-1); //die;
    echo 1;
}else if($did!='' && $type==3){
    if($_FILES['file']['size']>0 && $_FILES['file']['error']==0){
      $img=rand('100','9999999').$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/".$img);
    } 
    $obj->query("update $tbl_admin set img = '$img' where id='$did'",-1); //die; 
    echo 1;
}

?>



