<?php 
include("../include/config.php");
include("../include/functions.php"); 

if(isset($_POST['action'])){
$did = $_POST['did'];
$action = $_POST['action'];
$type = $_POST['ttype'];
if($did!='' && $type==1){
    if($_FILES['file']['size']>0 && $_FILES['file']['error']==0){
      $img=rand('100','9999999').$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'],"../uploads/".$img);
    } 
    $obj->query("update $tbl_student_diploma set draft = '$img' where id='$did'",-1); //die;
    echo 1;
}
}

if(isset($_POST['changes'])){
    $val = $obj->escapestring($_POST['val']);
    $id = $_POST['id'];
    $obj->query("update $tbl_student_diploma set changes = '$val' where id='$id'",-1); //die;
    echo 1;
}
?>



