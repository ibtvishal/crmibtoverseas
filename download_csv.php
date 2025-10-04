<?php
session_start();
include("include/config.php");
include("include/functions.php");
validate_user();



 if(isset($_POST['programmesList']))
 {
    

      $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=programmes.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
       fputcsv($output, array('SL. No.', 'Country Id', 'State Id',  'Univercity',  'Program Level',  'Stream', 'Course Name', 'Intake', 'Program Duration', 'Tuition Fee', 'Student Bachelors', 'Percentage', 'Ielts', 'Pte', 'Duolingo','Tofel','MOI','120 Fee','Status'));
       $sql=$GLOBALS['obj']->query("select * from $table_name where 1=1",$debug=-1); //die;

      $data= mysqli_num_rows($sql);

      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($record = mysqli_fetch_assoc($sql))  
      {   
        
          
                $row['Sl. NO.']=$no;
                $row['Country Id']=$record['country'];
                $row['State Id'] = $record['state'];
                $row['Univercity'] = $record['univercity'];
                $row['Program Level'] = $record['program_level'];
                $row['Stream'] = $record['stream'];
                $row['Course Name'] = $record['course_name'];
                $row['Intake'] = $record['intake'];
                $row['Program Duration'] = $record['program_duration'];
                $row['Tuition Fee'] = $record['tuition_fee'];
                $row['Student Bachelors'] = $record['student_bachelors'];
                $row['Percentage'] = $record['percentage'];
                $row['Ielts'] = $record['ielts'];
                $row['Pte'] = $record['pte'];
                $row['Duolingo'] = $record['duolingo'];
                $row['Tofel'] = $record['tofel'];
                $row['MOI'] = $record['moi'];
                $row['Fees'] = $record['fees'];
                $row['Status'] = $record['status'];
               
                fputcsv($output,$row);  
                $no++;
             }
                fclose($output);
          }
        

   if(isset($_POST['GapList']))
 {
    

      $table_name = $_GET['table_name'];

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=gap.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
       fputcsv($output, array('Qualification', 'Stream',  'Gap',  'Preferred Course',  'Duration','Diploma','Experience Duration','Designation','Status'));
       $sql=$GLOBALS['obj']->query("select * from $table_name where 1=1",$debug=-1); //die;


      $data= mysqli_num_rows($sql);
  
      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($record = mysqli_fetch_assoc($sql))  
      {   
        
          
                $row['Qualification']=$record['qualification'];
                $row['Stream'] = $record['stream'];
                $row['Gap'] = $record['gap'];
                $row['Preferred Course'] = $record['preferred_course'];
                $row['Duration'] = $record['duration'];
                $row['Diploma'] = $record['diploma'];
                $row['Experience Duration'] = $record['exp_duration'];
                $row['Designation'] = $record['designation'];
                $row['Status'] = $record['status'];
                fputcsv($output,$row);
          
                $no++;
             }
                fclose($output);
          }
     
if(isset($_POST['studentList']))
 {
    

      $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=student.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
      $whr='';
      $whr1='';
      $whr2='';
      if($_SESSION['whr']){
        $whr = $_SESSION['whr'];
      }
      if($_SESSION['whr1']){
        $whr1 = $_SESSION['whr1'];
      }
      if($_SESSION['whr2']){
        $whr2 = $_SESSION['whr2'];
      }
       fputcsv($output, array('SL. No.', 'Student Id', 'Name',  'Father Name', 'DOB', 'Passport No', 'Country', 'Visa Type', 'Counsellor Name', 'Account Manager'));


       if ($_SESSION['level_id']==1){
          if($_SESSION['stage_id']){
            $sql=$GLOBALS['obj']->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 $whr1 ",$debug=-1);
          }else{
            $sql=$GLOBALS['obj']->query("select * from $tbl_student where 1=1 $whr ",$debug=-1); 
          }
       }else if ($_SESSION['level_id']==2) {
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
         if($_SESSION['stage_id']){
            $sql=$GLOBALS['obj']->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) $whr1 ",$debug=-1); 
          }else{                                
            $sql=$GLOBALS['obj']->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) $whr",$debug=-1);
          }
       
        }else if ($_SESSION['level_id']==3) {   
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
          if($_SESSION['stage_id']){
            $sql=$GLOBALS['obj']->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' $whr1 ",$debug=-1); 
          }else{                                
            $sql=$GLOBALS['obj']->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
          }
        }else if ($_SESSION['level_id']==4) {   
            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
            if($_SESSION['stage_id']){
            $sql=$GLOBALS['obj']->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' $whr1 ",$debug=-1); 
            }else{                                
            $sql=$GLOBALS['obj']->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' $whr ",$debug=-1);
            }

        }else if ($_SESSION['level_id']==7) {  
            $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
            $msql="select a.*";
            $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id)";
            if($_REQUEST['country_id']==1){
             $msql .=" and a.country_id = 1 and b.stage_id='3' and b.cstatus='Tuition Fees Paid'";
            }else if($_REQUEST['country_id']==2){
             $msql .=" and a.country_id = 2 and b.stage_id='30' and b.cstatus='COE Received'";
            }else if($_REQUEST['country_id']==3){
             $msql .=" and a.country_id = 3 and b.stage_id='8' and b.cstatus='I-20 Issued'";
            }else if($_REQUEST['country_id']==6){
              $msql .=" and a.country_id = 6 and b.stage_id='24' and b.cstatus='CAS Received'";
            }else{
             $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','CAS Received')";  
            }

            $msql .=" $whr2 group by a.id";
            $sql=$GLOBALS['obj']->query($msql); 
        }else if ($_SESSION['level_id']==8) {   
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
          $sql=$GLOBALS['obj']->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id!=0 $whr1 ",$debug=-1);
       }

      $data= mysqli_num_rows($sql);

      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($record = mysqli_fetch_assoc($sql))  
      {   
                
                if($record['visa_id']==1){
                    $visa_type= 'Study Visa';
                }else if($record['visa_id']==2){
                  $visa_type= 'Tourist Visa';
                }else if($record['visa_id']==3){
                  $visa_type= 'Visitor Visa';
                }else if($record['visa_id']==4){
                  $visa_type= 'Work Visa';
                }
          
                $row['Sl. NO.']=$no;
                $row['Student Id']=$record['student_no'];
                $row['Name'] = $record['stu_name'];
                $row['Father Name'] = $record['father_name'];
                $row['DOB'] = $record['dob'];
                $row['Passport No'] = $record['passport_no'];
                $row['Country'] = getField('name',$tbl_country,$record['country_id']);
                $row['Visa Type'] = $visa_type;
                $row['Counsellor Name'] = getField('name',$tbl_admin,$record['c_id']);
                $row['Account Manager'] = getField('name',$tbl_admin,$record['am_id']);
               
                fputcsv($output,$row);  
                $no++;
             }
                fclose($output);
          }

 if(isset($_POST['courseList']))
 {
    

      $table_name = $_GET['table_name'];
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=course.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
       fputcsv($output, array('SL. No.', 'Country Id', 'State Id',  'University Id',  'Course Name', 'Status'));
       $sql=$GLOBALS['obj']->query("select * from $table_name where 1=1",$debug=-1); //die;

      $data= mysqli_num_rows($sql);

      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($record = mysqli_fetch_assoc($sql))  
      {   
        $row['Sl. NO.']=$no;
        $row['Country Id']=$record['country_id'];
        $row['State Id'] = $record['state_id'];
        $row['University Id'] = $record['university_id'];
        $row['Course Name'] = $record['name'];
        $row['Status'] = $record['status'];
       
        fputcsv($output,$row);  
        $no++;
      }
      fclose($output);
}


 if(isset($_POST['diplomaList']))
 {

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=diploma.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
      if($_SESSION['level_id']==5){
        fputcsv($output, array('SL. No.', 'Timestamp', 'IBT Student Code',  'Request Slip No',  'Institute Name', 'Registration No','Student Name','Father Name','Monther Name','Date of Birth','Course Name','Duration','Start Date','End Date','Passport Size Photo','Branch Name','Counseller Name','Student Contact No','10th Passing Year','12th Passing Year','Important Remarks','Student Approval','Media & Gap Manager Status','Upload Document'));
      }else if($_SESSION['level_id']==1){
        fputcsv($output, array('SL. No.', 'Timestamp', 'IBT Student Code',  'Request Slip No',  'Institute Name', 'Registration No','Student Name','Father Name','Monther Name','Date of Birth','Course Name','Duration','Start Date','End Date','Passport Size Photo','Branch Name','Counseller Name','Student Contact No','10th Passing Year','12th Passing Year','Important Remarks','Student Approval','Media & Gap Manager Status','Upload Document'));
      }

      $whr ="";
      if(!empty($_SESSION['whr'])){
        $whr = $_SESSION['whr'];
      }

        if ($_SESSION['level_id']==5){
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
          $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.imp_remarks,b.institute_id,c.name as diploma_name,a.ten_end_year,a.twl_end_year from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' $whr",$debug=-1);
        }else if ($_SESSION['level_id']==6){
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
          $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.slip_photo,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.media_gap_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.pimg,b.imp_remarks,b.institute_id,c.name as diploma_name,a.ten_end_year,a.twl_end_year from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.student_approval_status=1 $whr",$debug=-1);                             
        }else if($_SESSION['level_id']==1){
          $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.slip_photo,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.media_gap_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.pimg,b.imp_remarks,b.institute_id,c.name as diploma_name,a.ten_end_year,a.twl_end_year from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and b.status='send_request' $whr",$debug=-1);
        }

      $data= $obj->numRows($sql);

      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($line = $obj->fetchNextObject($sql))  
      {   
        $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
        $rResult = $obj->fetchNextObject($rSql);
        $father_name = $rResult->name;

        $row['Sl. NO.']=$no;
        $row['Timestamp']=date("d M y",strtotime($line->cdate));
        $row['IBT Student Code']=$line->student_no;
        $row['Request Slip No']=$line->slip_number;
        $row['Institute Name']=getField('name',$tbl_institute,$line->institute_id);
        $row['Registration No']=$line->registration_no;
        $row['Student Name']=$line->stu_name;
        $row['Father Name']=$father_name;
        $row['Monther Name']=$line->mother_name;
        $row['Date of Birth']=$line->dob;
        $row['Course Name']=$line->diploma_name;
        $row['Duration']=$line->time_duration;
        $row['Start Date']=$line->start_date;
        $row['End Date']=$line->end_date;
        $row['Passport Size Photo']=SITE_URL."uploads/".$line->photo;
        $row['Branch Name']=getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id));
        $row['Counseller Name']=getField('name',$tbl_admin,$line->c_id);
        $row['Student Contact No']=$line->stu_contact_number;
        $row['10th Passing Year']=date('Y',strtotime($line->ten_end_year));
        $row['12th Passing Year']=date('Y',strtotime($line->twl_end_year));
        $row['Important Remarks']=$line->imp_remarks;
        if($line->student_approval_status==0){
          $student_approval_status = "Pending";
        }else{
          $student_approval_status = "Approved";
        }
        $row['Counseller Approval']=$student_approval_status;

        if($line->media_gap_status==0){
          $media_gap_status = "Pending";
        }else{
          $media_gap_status = "Approved";
        }
        $row['Media & Gap Manager Status']=$media_gap_status;
        $row['Student Approval']=SITE_URL."uploads/".$line->pimg;

       
        fputcsv($output,$row);  
        $no++;
      }
      fclose($output);
}



if(isset($_POST['experienceList']))
 {

      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=Experience.csv');  
      $output = fopen("php://output", "w");  
   
      // output the column headings
      if($_SESSION['level_id']==5){
        fputcsv($output, array('SL. No.', 'Timestamp', 'IBT Student Code',  'Request Slip No','Student Name','Father Name','Company Name','Designation','Start Date','End Date','Duration','Salary','Issued Date','Branch Name','Counseller Name','Student Contact No','Important Remarks','Counseller Approval','Upload Document')); 
      }else if($_SESSION['level_id']==1){
        fputcsv($output, array('SL. No.', 'Timestamp', 'IBT Student Code',  'Request Slip No','Student Name','Father Name','Company Name','Designation','Start Date','End Date','Duration','Salary','Issued Date','Branch Name','Counseller Name','Student Contact No','Important Remarks','Resume','Address Proof','Counseller Approval','Upload Document'));      
      }

      $whr ="";
      if(!empty($_SESSION['whr'])){
        $whr = $_SESSION['whr'];
      }
        if ($_SESSION['level_id']==5){
          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
          $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.slip_photo,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.counsellor_status,b.company_id,c.name as designation,b.pimg from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' $whr",$debug=-1);
                            
        }else if($_SESSION['level_id']==1){
          $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.slip_photo,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.counsellor_status,b.company_id,c.name as designation,b.pimg from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and b.status='send_request' $whr",$debug=-1);
        }

      $data= $obj->numRows($sql);

      if(empty($data)|| $data==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($line = $obj->fetchNextObject($sql))  
      {   
        $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
        $rResult = $obj->fetchNextObject($rSql);
        $father_name = $rResult->name;

        $row['Sl. NO.']=$no;
        $row['Timestamp']=date("d M y",strtotime($line->cdate));
        $row['IBT Student Code']=$line->student_no;
        $row['Request Slip No']=$line->slip_number;
        $row['Student Name']=$line->stu_name;
        $row['Father Name']=$father_name;
        $row['Company Name'] = getField('name',$tbl_company,$line->company_id);
        $row['Designation']=$line->designation;
        $row['Start Date']=$line->start_date;
        $row['End Date']=$line->end_date;
        $row['Duration']=$line->time_duration;
        $row['Salary']=$line->salary;
        $row['Issued Date']=$line->issue_date;
        $row['Branch Name']=getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id));
        $row['Counseller Name']=getField('name',$tbl_admin,$line->c_id);
        $row['Student Contact No.']=$line->stu_contact_number;
        $row['Important Remarks']=$line->imp_remarks;
        
        if($line->counsellor_status==0){
            $counsellor_status = "Pending";
          }else{
            $counsellor_status = "Approved";
          }
        $row['Counseller Approval']=$counsellor_status;
        $row['Upload Document']=SITE_URL."uploads/".$line->pimg;  
     
       
        fputcsv($output,$row);  
        $no++;
      }
      fclose($output);
}




if(isset($_POST['applicationList']))
 {
    
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=application.csv');  
      $output = fopen("php://output", "w");  
   
      fputcsv($output, array('SL.No.', 'App Id', 'Student Id',  'Student Name',  'Office Email', 'Institute Name','Location','Course','Intake','Year','Branch','Counsellor Name','Account Manager','Filling Executive','Last Updated Status','Remarks'));

      $whr=''; $whr1='';
      if($_SESSION['whr']){
        $whr = $_SESSION['whr'];
      }
      if($_SESSION['whr1']){
        $whr1 = $_SESSION['whr1'];
      }
      

      if($_SESSION['filling_executive_id']){
        $sql="select a.*,b.id as sid,b.student_no,b.stu_name,b.branch_id,b.c_id,b.am_id,b.fm_id,c.fe_id from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id left join $tbl_filing_credentials as c ON a.stu_id=c.student_id where 1=1 and c.fe_id='".$_SESSION['filling_executive_id']."' $whr $whr1";
      }else{
        $sql="select a.*,b.id as sid,b.student_no,b.stu_name,b.branch_id,b.c_id,b.am_id,b.fm_id from $tbl_student_application as a left join $tbl_student as b on a.stu_id=b.id where 1=1 $whr $whr1";
      }


      $query = $obj->query($sql);
      $totalFiltered=$obj->numRows($query);

      if(empty($totalFiltered)|| $totalFiltered==0)
      {
        
         fputcsv($output,array("Sorry, No Result Found"));
         exit;
      }
      
      $no=1;
     
      while($line=$obj->fetchNextObject($query)){   

        $uemail='';
        $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->sid."'");
        while($urResult = $obj->fetchNextObject($urSql)){
          if($urResult->offical_email!=''){
            $uemail .= $urResult->offical_email;
            $uemail .="</br>";
          }
        }

        $row['Sl.NO.']=$no;
        $row['App Id'] = $line->app_id;
        $row['Student Id'] = $line->student_no;
        $row['Student Name'] = $line->stu_name;
        $row['Office Email'] = $uemail;
        $row['Institute Name'] = getField('name','tbl_univercity',$line->college_name);
        $row['Location'] = getField('state','tbl_state',$line->location);
        $row['Course'] = $line->course;
        $row['Intake'] = $line->month;
        $row['Year'] = $line->year;
        $row['Branch'] = getField('name',$tbl_branch,$line->branch_id);
        $row['Counsellor Name'] = getField('name',$tbl_admin,$line->c_id);
        $row['Account Manager'] = getField('name',$tbl_admin,$line->am_id);
        $row['Filling Executive'] = $filingManger;
        $row['Last Updated Status'] = $line->status;
        $row['Remarks'] = $line->remarks;

        fputcsv($output,$row);  
        $no++;
      }
      fclose($output);
}

?>