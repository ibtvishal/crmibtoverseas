<?php
include("include/config.php");
include("include/functions.php");
validate_admin();


if(isset($_POST["productImport"]))
{ 
  $filename=$_FILES["file"]["tmp_name"];    
  $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
  if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
  {
    $file = fopen($filename, "r");
    $i=0;

    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
    {   


      if($i!=0){
        $sqlsel="select id from $tbl_gap where stream='".$getData[2]."'";

        $qursel=$obj->query($sqlsel);

        $res=$obj->numRows($qursel);  
 
        if($res>0)
        {
     
          $resultpu=$obj->fetchNextObject($qursel);

          $sqlpu="UPDATE $tbl_gap set
          qualification='".$getData[1]."',
          stream='".$getData[2]."',
          gap='".$getData[3]."',
          preferred_course ='".$getData[4]."',
          diploma ='".$getData[5]."',
          experience ='".$getData[6]."'
          where id='".$resultpu->id."'";
          $exeqrypu=$obj->query($sqlpu);  
          

            $_SESSION['sess_msg']='CSV file sucessfully uploaded.'; 
            header("location:gap-list.php");
     
        }
        else{

          $sqlp = "INSERT into $tbl_gap set 
          qualification='".$getData[1]."',
          stream='".$getData[2]."',
          gap='".$getData[3]."',
          preferred_course ='".$getData[4]."',
          diploma ='".$getData[5]."',
          experience ='".$getData[6]."'";
          $exeqryp=$obj->query($sqlp);  

          
            $_SESSION['sess_msg']='CSV file sucessfully uploaded.'; 
            header("location:gap-list.php");
     
        }   
      }
      $i++;
    }
    fclose($file);  
  }
  else
  {
    $_SESSION['err_msg']='Please Upload CSV File.'; 
    header("location:gap-list.php");
  }
}




?>