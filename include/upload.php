<?php
include("../include/config.php");
include("../include/functions.php"); 

if($_REQUEST['submitForm']=='yes'){
    if($_FILES['photo']['size']>0 && $_FILES['photo']['error']==''){
        if(move_uploaded_file($_FILES['photo']['tmp_name'], '../upload_images/'.$_FILES['photo']['name'])){
            echo "uploaded";
        }else{
            echo "not uploaded";
        }
    }  
}      

?>

<form name="frm" id="frm" method="POST" enctype="multipart/form-data" action="">
<input type="hidden" name="submitForm" value="yes" />
<input type="file" name="photo" class='form-control' />
<input type="submit" name="submit" value="Submit"  class="button button-success" border="0"/>

</form>
      