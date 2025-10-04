<?php
session_start();
include("include/config.php");
include("include/functions.php");
validate_admin();



 if(isset($_POST['programmesList']))
 {   

    $table_name = $_GET['table_name'];
    $sql=$GLOBALS['obj']->query("select * from $table_name where 1=1",$debug=-1); //die;

    $sql = $obj->query("select id,country,state,univercity,program_level,stream,course_name,intake,program_duration,tuition_fee,student_bachelors,percentage,ielts,pte,duolingo,tofel,moi,fees,scholarship,scholarship_percentage,special_requirement,status,course_type from $table_name where 1=1",$debug=-1); //die;

    $columnHeader = '';  
    $columnHeader = "Id" . "\t" . "Country Id" . "\t" . "State Id" . "\t" . "Univercity" . "\t" . "Program Level" . "\t" . "Stream" . "\t" . "Course Name" . "\t" . "Intake" . "\t" . "Program Duration" . "\t" . "Tuition Fee" . "\t" . "Student Bachelors" . "\t" . "Percentage" . "\t" . "Ielts" . "\t" . "Pte" . "\t" . "Duolingo" . "\t" . "Tofel" . "\t" . "MOI" . "\t" . "120 Fee" . "\t" . "scholarship" . "\t". "scholarship_percentage" . "\t". "special_requirement" . "\t". "Status" . "\t"."Course Type" . "\t";  
    $setData = '';    
      while ($rec = $obj->fetchNextObject($setRec)) {  
        $rowData = '';  
        foreach ($rec as $value) {  
          $value = '"' . $value . '"' . "\t";  
          $rowData .= $value;  
        }  
        $setData .= trim($rowData) . "\n";  
      }  

      header("Content-type: application/octet-stream");  
      header("Content-Disposition: attachment; filename=Programmes_Detail_".date('d_m_Y').".xls");  
      header("Pragma: no-cache");   
      header("Expires: 0");  

      echo ucwords($columnHeader) . "\n" . $setData . "\n";       
}
        
?>