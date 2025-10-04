<?php
include("include/config.php");
include("include/functions.php");
validate_admin();


if(isset($_POST["productImport"]))
{ 
  $filename=$_FILES["file"]["tmp_name"];    
  $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

  if(!empty($_REQUEST['filter_country']) && !empty($_REQUEST['filter_state']) && !empty($_REQUEST['filter_university'])){

    if($_FILES["file"]["size"] > 0 && in_array($_FILES['file']['type'],$csvMimes))
    {
      //Delete old data 
      $obj->query("delete from $tbl_programmes where country ='".$_REQUEST['filter_country']."' and state='".$_REQUEST['filter_state']."' and univercity='".$_REQUEST['filter_university']."'",-1); //die;
      //=======================================================================
      $file = fopen($filename, "r");
      $i=0;

      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
      {  

        if($i!=0){
            $getSql = $obj->query("select country_id,state_id from $tbl_univercity where id='".trim($getData[3])."'",-1); //die;
            $getResult = $obj->fetchNextObject($getSql);
            if($getResult->country_id==trim($getData[1]) && $getResult->state_id==trim($getData[2])){
              $sqlp = "INSERT into $tbl_programmes set 
              country='".trim($getData[1])."',
              state='".trim($getData[2])."',
              univercity='".trim($getData[3])."',
              program_level ='".trim($getData[4])."',
              stream ='".trim($getData[5])."',
              course_name ='".trim($getData[6])."',
              intake ='".trim($getData[7])."',
              program_duration ='".trim($getData[8])."',
              tuition_fee ='".trim($getData[9])."',
              student_bachelors  ='".trim($getData[10])."',
              percentage  ='".trim($getData[11])."',
              ielts ='".trim($getData[12])."',
              pte  ='".trim($getData[13])."',
              duolingo  ='".trim($getData[14])."',
              tofel  ='".trim($getData[15])."',
              moi  ='".trim($getData[17])."',
              fees ='".trim($getData[16])."',
              scholarship ='".trim($getData[18])."',
              scholarship_percentage ='".trim($getData[19])."',
              special_requirement ='".trim($getData[20])."',
              course_type ='".trim($getData[22])."'";
              //echo $sqlp; die;
              $exeqryp=$obj->query($sqlp);
            }
        }
        $i++;
      }
      fclose($file);  

    $_SESSION['sess_msg']='CSV file sucessfully uploaded.'; 
    header("location:programmes-list.php");
    }
    else
    {
      $_SESSION['err_msg']='Please Upload CSV File.'; 
      header("location:programmes-list.php");
    }
  }else{
     $_SESSION['err_msg']='Country & State field are required.'; 
     header("location:programmes-list.php");
  }
}




if(isset($_POST["gapImport"]))
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

          $sqlp = "INSERT into $tbl_gap set 
          qualification='".trim($getData[0])."',
          stream='".trim($getData[1])."',
          gap='".trim($getData[2])."',
          preferred_course ='".trim($getData[3])."',
          diploma ='".trim($getData[4])."',
          duration ='".trim($getData[5])."',
          exp_duration ='".trim($getData[7])."',
          designation  ='".trim($getData[6])."'";
          $exeqryp=$obj->query($sqlp);  
          
          
            $_SESSION['sess_msg']='CSV file sucessfully uploaded.'; 
            header("location:gap-list.php");
      }
      $i++;
    }
    fclose($file);  
  }
  else
  {
    $_SESSION['err_msg']='Please Upload CSV File.'; 
    header("location:programmes-list.php");
  }
}



if(isset($_POST["CoruseImport"]))
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
          $sqlp = "INSERT into $tbl_course set 
          country_id='".$getData[1]."',
          state_id='".$getData[2]."',
          university_id='".$getData[3]."',
          name ='".$getData[4]."'";
          $exeqryp=$obj->query($sqlp);          
          
          $_SESSION['sess_msg']='CSV file sucessfully uploaded.'; 
          header("location:course-list.php");
      }
      $i++;
    }
    fclose($file);  
  }
  else
  {
    $_SESSION['err_msg']='Please Upload CSV File.'; 
    header("location:course-list.php");
  }
}

?>