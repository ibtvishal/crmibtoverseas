          <?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 

validate_user();

$requestData= $_REQUEST;

$columns = array(
  0 =>'student_no', 
  1 =>'cdate', 
  2=>'stu_name',
  3 => 'passport_no',
  4 =>'country_id',
  5=>'c_id',
);

$sql=$obj->query("select COUNT(id) as num_rows from $tbl_student where 1=1 ",$debug=-1);

$line=$obj->fetchNextObject($sql);
$totalData=$line->num_rows;
$totalFiltered = $totalData; 


$whr = $_SESSION['whr'];

if(isset($_SESSION['whq']) && $_SESSION['whq']!=''){
  $sql = $_SESSION['whq'];
}elseif(isset($_SESSION['get_status']) && $_SESSION['get_status']!=''){
  $sql = $_SESSION['get_status'];  
}else{
  $addtional_role = explode(',',$_SESSION['additional_role']);
  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==25){
    if($_SESSION['stage_id']){
      if(!empty($_SESSION['filling_executive_id'])){
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_filing_credentials as c ON a.id=c.student_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and c.fe_id='".$_SESSION['filling_executive_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_filing_credentials as c ON a.id=c.student_id where 1=1 and c.fe_id='".$_SESSION['filling_executive_id']."' and b.parent_id=0 $whr ";
        }
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and c.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and b.parent_id=0 $whr ";
        }
      }
    }else{
      
      if(!empty($_SESSION['filling_executive_id'])){
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON a.id=b.student_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and b.fe_id='".$_SESSION['filling_executive_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON a.id=b.student_id where 1=1 and b.fe_id='".$_SESSION['filling_executive_id']."'  $whr ";
        }       
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and b.stu_status='".$_SESSION['founds_source']."' $whr "; 
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 $whr"; 
        }      
      }
      if(!empty($_SESSION['filter_admission_check'])){
        if($_SESSION['filter_admission_check']=='never'){
          $date = date('Y-m-d', strtotime('-3 days'));
          $sql="select a.* from $tbl_student as a left join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and (date(b.cdate) < '$date' )$whr";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' $whr";
        }
      }
    }
    // if(!empty($_SESSION['filling_manager_id'])){
    //   $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id where 1=1 and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','CAS Received') $whr ";
    // }


    if(base64_decode(base64_decode(base64_decode($_SESSION['transfer'])))==1){
      if(!empty($_SESSION['transfer_branch_id'])){
        $transfer_branch_id = $_SESSION['transfer_branch_id'];
        $tswhr .=" and FIND_IN_SET($transfer_branch_id, branch_id)";
      }
      if(!empty($_SESSION['transfer_user_from_id'])){
        $user_from_id = $_SESSION['transfer_user_from_id'];
        $t_user_type = $_SESSION['transfer_user_type'];
        if($t_user_type==3){
          $tswhr .=" and am_id='$user_from_id'";
        }else if($t_user_type==4){
          $tswhr .=" and c_id='$user_from_id'";
        }else if($t_user_type==8){
          $tswhr .=" and c_id='$user_from_id'";
        }
      }
      $sql="select a.* from $tbl_student as a where 1=1 $tswhr "; 
    } 

  }
  else if ($_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23){
    if($_SESSION['level_id']==2 || $_SESSION['level_id']==31){
      $whr1 = " and visa_id in(1,4)";
    }elseif($_SESSION['level_id'] == 18 || in_array(9, $addtional_role)){
      $whr1 = " and visa_id in(1,2,3,4,5)";
    }else{
      $whr1 = " and visa_id in(2,3,5)";
    }
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['stage_id']){
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr $whr1"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr $whr1"; 
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr $whr1"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr $whr1"; 
          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and b.parent_id=0 and branch_id in ($branch_id) and c.stu_status='".$_SESSION['founds_source']."' $whr $whr1 "; 
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and b.parent_id=0 $whr $whr1 ";
        }      
      }    
    }else{
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr $whr1";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr $whr1";
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' $whr $whr1";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' $whr $whr1";
          }
        }
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and branch_id in ($branch_id) and b.stu_status='".$_SESSION['founds_source']."' $whr $whr1";
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 and branch_id in ($branch_id) $whr $whr1";
        }      
      }
    }
  }
  else if ($_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25 || $_SESSION['level_id']==17){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['stage_id']){
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr"; 
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr"; 
          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and b.parent_id=0 and branch_id in ($branch_id) and c.stu_status='".$_SESSION['founds_source']."' $whr "; 
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and b.parent_id=0 $whr ";
        }      
      }    
    }else{
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr";
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' $whr";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' $whr";
          }
        }
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and branch_id in ($branch_id) and b.stu_status='".$_SESSION['founds_source']."' $whr";
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 and branch_id in ($branch_id) $whr";
        }      
      }
    }
  }
  else if ($_SESSION['level_id']==14 || in_array(6,$addtional_role)){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['stage_id']){
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr"; 
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr"; 
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr"; 
          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and b.parent_id=0 and branch_id in ($branch_id) and c.stu_status='".$_SESSION['founds_source']."' $whr "; 
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and b.parent_id=0 $whr ";
        }      
      }    
    }else{
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr";
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' $whr";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id)  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' $whr";
          }
        }
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and branch_id in ($branch_id) and b.stu_status='".$_SESSION['founds_source']."' $whr";
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 and branch_id in ($branch_id) $whr";
        }      
      }
    }
  }
  else if ($_SESSION['level_id']==3 || $_SESSION['level_id']==24){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['stage_id']){
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 and a.work_status=1 $whr ";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 and a.work_status=1 $whr ";
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id  where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 and a.work_status=1 $whr ";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id  where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 and a.work_status=1 $whr ";
          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."' and c.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 and a.work_status=1 $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."' and b.parent_id=0 and a.work_status=1 $whr ";
        }      
      }     
    }else{
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' and a.work_status=1 $whr";

          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' and c.stu_status='".$_SESSION['founds_source']."' and a.work_status=1 $whr";

          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate)  < '$date' and b.level_id='".$_SESSION['level_id']."' and a.work_status=1 $whr";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and b.level_id='".$_SESSION['level_id']."' and a.work_status=1 $whr";

          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."' and b.stu_status='".$_SESSION['founds_source']."' and a.work_status=1 $whr";
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 and a.branch_id in ($branch_id) and a.am_id='".$_SESSION['sess_admin_id']."' and a.work_status=1 $whr";
        }
      }    
    }
  }
  else if ($_SESSION['level_id']==4){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['stage_id']){
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr ";
          }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr ";

          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr ";
        }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and b.parent_id=0 $whr ";
          }
        }
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."' and c.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0 $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."' and b.parent_id=0 $whr ";
        }      
      }
    }else{
      if($_SESSION['filter_admission_check']){
        if(!empty($_SESSION['founds_source'])){
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
          $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' and c.stu_status='".$_SESSION['founds_source']."' $whr ";
        }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' and c.stu_status='".$_SESSION['founds_source']."' $whr ";
          }
        }else{
          if($_SESSION['filter_admission_check']=='never'){
            $date = date('Y-m-d', strtotime('-3 days'));
          $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) < '$date' $whr ";
        }else{
            $sql="select a.* from $tbl_student as a inner join $tbl_student_updated_time as b on a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."'  and b.user_id='".$_SESSION['sess_admin_id']."' and date(b.cdate) ='".$_SESSION['filter_admission_check']."' $whr ";
          }
        }      
      }else{
        if(!empty($_SESSION['founds_source'])){
          $sql="select a.* from $tbl_student as a inner join $tbl_student_found as b on a.id=b.sutdent_id where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."' and b.stu_status='".$_SESSION['founds_source']."' $whr ";
        }else{
          $sql="select a.* from $tbl_student as a where 1=1 and a.branch_id in ($branch_id) and a.c_id='".$_SESSION['sess_admin_id']."' $whr ";
        }
      }                                
    }

  }
  else if ($_SESSION['level_id']==7){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $sql="select a.*,b.stage_id,b.cstatus";
    if($_SESSION['filter_admission_check']){
      if(!empty($_SESSION['founds_source'])){
        if($_SESSION['filter_admission_check']=='never'){
          $date = date('Y-m-d', strtotime('-3 days'));
          $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0";
      }else{
          $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id)  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0";
        }
      }else{
        if($_SESSION['filter_admission_check']=='never'){
          $date = date('Y-m-d', strtotime('-3 days'));
          $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as d on a.id=d.stu_id where 1=1 and a.branch_id in ($branch_id) and date(d.cdate) < '$date' and d.level_id='".$_SESSION['level_id']."' and b.parent_id=0";
      }else{
          $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_updated_time as d on a.id=d.stu_id where 1=1 and a.branch_id in ($branch_id) and date(d.cdate) ='".$_SESSION['filter_admission_check']."' and d.level_id='".$_SESSION['level_id']."' and b.parent_id=0";
        }
      }
    }else{
      if(!empty($_SESSION['founds_source'])){
        $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and c.stu_status='".$_SESSION['founds_source']."' and b.parent_id=0";
      }else{
        $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and a.branch_id in ($branch_id) and b.parent_id=0";
      }     
    }
    
    if($_SESSION['country_id']==1){
      $sql .=" and a.country_id = 1 and b.stage_id='3' and b.cstatus='Tuition Fees Paid'";
      $sql .=" and a.country_id = 1 and b.stage_id='16' and b.cstatus='GIC Paid'";
    }else if($_SESSION['country_id']==2){
      $sql .=" and a.country_id = 2 and b.stage_id='30' and b.cstatus='COE Received'";
    }else if($_SESSION['country_id']==3){
      $sql .=" and a.country_id = 3 and b.stage_id='8' and ( b.cstatus='I-20 Issued' OR b.cstatus='Proceed on Dummy I-20')";
    }else if($_SESSION['country_id']==6){
      $sql .=" and a.country_id = 6 and b.stage_id='24' and b.cstatus='CAS Received'";
    }else{                   
      $sql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24,16) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','Proceed on Dummy I-20','CAS Received','GIC Paid')" ;  
    }
    $sql .=" and a.type='Enrolled' $whr";
  }
  else if ($_SESSION['level_id']==8){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    if($_SESSION['filter_admission_check']){
      if(!empty($_SESSION['founds_source'])){
        if($_SESSION['filter_admission_check']=='never'){
          $date = date('Y-m-d', strtotime('-3 days'));
        $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' $whr ";
      }else{
          $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id inner join $tbl_student_updated_time as c on a.id=c.stu_id inner join $tbl_student_found as d on a.id=d.sutdent_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' and d.stu_status='".$_SESSION['founds_source']."' $whr ";
        }
      }else{
        if($_SESSION['filter_admission_check']=='never'){
          $date = date('Y-m-d', strtotime('-3 days'));
        $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) < '$date' and c.level_id='".$_SESSION['level_id']."' $whr ";
      }else{
        $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id inner join $tbl_student_updated_time as c on a.id=c.stu_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."'  and c.user_id='".$_SESSION['sess_admin_id']."' and date(c.cdate) ='".$_SESSION['filter_admission_check']."' and c.level_id='".$_SESSION['level_id']."' $whr ";
        }
      }
    }else{
      if(!empty($_SESSION['founds_source'])){
        $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id inner join $tbl_student_found as c on a.id=c.sutdent_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' and c.stu_status='".$_SESSION['founds_source']."' $whr ";
      }else{
        $sql="select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id='".$_SESSION['sess_admin_id']."' $whr ";
      }
    }

  }
  else if ($_SESSION['level_id']==10){
    $whr_slot = $_SESSION['whr_slot'];
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $sql="select a.*,b.stage_id,b.cstatus";
        $sql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id left join $tbl_appointment as c on c.student_id=a.id where 1=1 and a.branch_id in ($branch_id) and b.parent_id=0";
    $sql .=" and b.stage_id='34' and b.cstatus='Move to Visa Appointment'" ;
    $sql .=" $whr_slot";
  }
}

if( !empty($requestData['search']['value'])) {
  $sql.=" AND ( a.student_no LIKE '%".$requestData['search']['value']."%' ";    
  $sql.=" OR a.cdate LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.stu_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.student_contact_no LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.alternate_contact LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.intake LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR a.passport_no LIKE '".$requestData['search']['value']."%') ";
}
// echo $sql; die;
$sql .= " group by student_no";
$query = $obj->query($sql);
$totalFiltered=$obj->numRows($query);

if($_SESSION['level_id']==3 || $_SESSION['level_id']==24){
  $sql.= " order by application_check desc, id desc LIMIT ".$requestData['start']." ,".$requestData['length']." ";
}elseif($_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25){
  $sql.= " order by  CASE WHEN am_id = 0 THEN 0 ELSE 1 END ASC, id desc LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}else{
  $requestData['order'][0]['dir']='desc';
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
}
// echo $sql;die;

$query = $obj->query($sql);


$data = array();
$i=1;
if(isset($_SESSION['stage_status']) && $_SESSION['stage_status']!=''){
  $vcstatus = "cstatus='".$_SESSION['stage_status']."'";
}else{
  $vcstatus = "cstatus in ('Visa Approved', 'Visa Refused', 'Back-Out')";
}
while($line=$obj->fetchNextObject($query)) {
  $last_student = $obj->fetchNextObject($obj->query("select * from $tbl_student where student_no='".$line->student_no."' order by id desc"));
  $nestedData=array(); 
 
  if($line->country_id==1 && $_SESSION['level_id']==7){
    $showval = 1;
    if($line->stage_id==3 && $line->cstatus=='Tuition Fees Paid'){
      $rsql = $obj->query("select stage_id,cstatus from $tbl_student_status where stu_id='".$line->id."'");
      $rResult = $obj->fetchNextObject($rsql);
      if($rResult->stage_id==16 && $rResult->cstatus=='GIC Paid'){
        $showval = 1;
      }
    }else if($line->stage_id==16 && $line->cstatus=='GIC Paid'){
      $rsql = $obj->query("select stage_id,cstatus from $tbl_student_status where stu_id='".$line->id."'");
      $rResult = $obj->fetchNextObject($rsql);
      if($rResult->stage_id==3 && $rResult->cstatus=='Tuition Fees Paid'){
        $showval = 1;
      }
    }
  }else{
    $showval = 1;
  }
  if($showval == 1){
    $color='';
    if($_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25  || $_SESSION['level_id']==17){
      if($last_student->am_id==0){
        $color = "style='color:red'"; 
      }
    }else if($_SESSION['level_id']==3 || $_SESSION['level_id']==24){
      if($last_student->application_check==1){ 
        $color = "style='color:blue'";
      }else if($last_student->accept_student==0 || $last_student->am_id==0){
        $color = "style='color:red'";    
      }      
                                       
    }else if($_SESSION['level_id']==7){
      $sqlf = $obj->query("select fe_id,pstatus from $tbl_filing_credentials where student_id='".$line->id."'",-1); //die;
      $ResultF = $obj->fetchNextObject($sqlf);
      if($ResultF->fe_id==0){
        $color = "style='color:red'";
      }
    }else if($_SESSION['level_id']==8){

      $sqlf = $obj->query("select pstatus from $tbl_filing_credentials where student_id='".$line->id."'",-1); //die;
      $ResultF = $obj->fetchNextObject($sqlf);
      if($ResultF->pstatus==0)
      {
        $color = "style='color:red'";
      }
    }else if($_SESSION['level_id']==10){
      $sqlf = $obj->query("select id from $tbl_appointment where student_id='".$line->id."'",-1); //die;
      $ResultNum = $obj->numRows($sqlf);
      if($ResultNum>0){
        $color = "";
      }else{
        $color = "style='color:red'";
      }
      
    }


    $chk = "";
    //--------------------------------Father Name Start-------------------------------------------
    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
    $rResult = $obj->fetchNextObject($rSql);
    //--------------------------------Father Name End-------------------------------------------
    //--------Check Status Start-----------------------------------------------------------------
    $chk='';
    $chk = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatus" value="'.$tbl_student.'"';
    if($line->status=="1"){
      $chk .= 'checked ';
    }
    $chk .= 'onclick="return changeStatusRecord('.$line->id.',this.checked,this.value);"/><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div>';

    $chk1='';
    $chk1 = '<div class="material-switch"><input id="someSwitchOptionPrimarys'.$i.'" type="checkbox" class="" value="1"';
    if($line->student_login=="1"){
      $chk1 .= 'checked ';
    }
    $chk1 .= 'onclick="chage_login_status('.$line->id.',this);"/><label for="someSwitchOptionPrimarys'.$i.'" class="label-primary"></label></div>';
    //-------------------------------------------------------------------------------------------
    if (($_SESSION['level_id']==1 || $_SESSION['level_id']==25) && base64_decode(base64_decode(base64_decode($_SESSION['transfer'])))==1){
      $nestedData[] = '<th><input type="checkbox" name="userIdarr[]" value="'.$line->id.'"></th>';
    }
    // if($line->student_type==1){
    //   $student_type='New'; 
    // }else if($line->student_type==6){
    //   $student_type='Re-apply(Defer)';
    // }
    // else if($line->student_type==3){
    //   $student_type='Refused';
    // }
    // else if($line->student_type==4){
    //   $student_type='Re-apply (Same Intake)';
    // }
    // else if($line->student_type==5){
    //   $student_type='Re-Apply(New Applications)';
    // }
    // else if($line->student_type==2){
    //   $student_type='Defer';
    // }
    // else if($line->student_type==7){
    //   $student_type='New(Outsider Refused)';
    // }
    // else if($line->student_type==8){
    //   $student_type='New (Filing Only)';
    // }
    // else if($line->student_type==9){
    //   $student_type='University Transfer';
    // }else{
      $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$last_student->student_type);
    // }

    // $uemail='';
    // $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->id."'");
    // while($urResult = $obj->fetchNextObject($urSql)){
    //   if($urResult->offical_email!=''){
    //     $uemail = $urResult->offical_email;
    //   }
    // }
    $addtional_role = explode(',',$_SESSION['additional_role']);
    if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || $_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==11 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25  || $_SESSION['level_id']==17 || $_SESSION['level_id']==3 || $_SESSION['level_id']==24 || in_array(2,$addtional_role)){
    $get_time = $obj->query("select cdate from $tbl_student_updated_time where stu_id='".$line->id."' and user_id='".$_SESSION['sess_admin_id']."'",-1);//die();
    $timeResult=$obj->fetchNextObject($get_time);
    if($obj->numRows($get_time)>0){
      $cdate = strtotime($timeResult->cdate);
      $today = time(); 
      $datetime1 = new DateTime(date("Y-m-d", $cdate));
      $datetime2 = new DateTime(date("Y-m-d", $today));
      $interval = $datetime1->diff($datetime2);
      $difference = $interval->format('%a'); 
      if($difference > 3){
        $color = "style='color:purple'";
      }else{
        $color = $color;
      }
    }else{
      $color = $color;
    }

    // $stageSql = $obj->query("select * from $tbl_student_status where stu_id='".$line->id."' and stage_id=36");
    // if($obj->numRows($stageSql)>0){
    //   $color = "style='color:red'";
    // }
    
    
    
  }
  $stageSql = $obj->query("select * from $tbl_student_application where stu_id='".$last_student->id."' and status='I-20 Received' and parent_id=0");
  if($obj->numRows($stageSql)>1){
    $color = "style='color:green'";
  }
  $stageSql2 = $obj->query("select * from $tbl_student_status where stu_id='".$last_student->id."' order by cdate desc");
  $timeResult2=$obj->fetchNextObject($stageSql2);
 
  $stageSql1 = $obj->query("select * from $tbl_student_status where stu_id='".$last_student->id."' and $vcstatus order by cdate desc");
  $timeResult1=$obj->fetchNextObject($stageSql1);
  
  if($timeResult2->cstatus=='Visa Approved' || $timeResult2->cstatus=='Visa Refused' || $timeResult2->cstatus=='Back-out'){
    $color = 'style="color:white"';
    $status_v = $timeResult2->cstatus;
  }else{
    $status_v = $timeResult2->cstatus;
  }
$duplicate = '';
  if($_SESSION['level_id'] == 1){
    $duplicate = "<a href='student-duplicate.php?id=" . base64_encode(base64_encode(base64_encode($line->id))) . "' title='Duplicate'><i class='fa-solid fa-clone'></i></a>
    <a href='#' onclick=\"warning('Do you want to delete it?','controller.php?delete_stu_id=" . base64_encode(base64_encode(base64_encode($line->id))) . "')\" title='Delete'><i class='fa fa-trash'></i></a>";
  }

  $edit = '';
  if($_SESSION['level_id'] == 1){
    $edit .= "<a target='_blank' href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($last_student->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a> $duplicate";
    $edit .= "<br>";
    if($line->student_status == 1){
      $edit .= "<span style='color:green'>Approved</span>";
    }elseif($line->student_status == 0){
      $edit .= "<span style='color:red'>Audit Pending</span>";
    }else{
      $edit .= "<span style='color:red'>Audit Disapproved</span>";
    }
  }else{
    if($line->student_status == 1){
      $edit .= "<a target='_blank' href='student-editf.php?id=".base64_encode(base64_encode(base64_encode($last_student->id)))."'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a> $duplicate";
    }elseif($line->student_status == 0){
      $edit .= "<span style='color:red'>Audit Pending</span>";
    }else{
      $edit .= "<span style='color:red'>Audit Disapproved</span>";
    }
  }
  $month = [
    1  => 'January',
    2  => 'February',
    3  => 'March',
    4  => 'April',
    5  => 'May',
    6  => 'June',
    7  => 'July',
    8  => 'August',
    9  => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

  $count_total = $obj->numRows($obj->query("select * from $tbl_student where student_no='".$line->student_no."'"));
  $screening_interview = $obj->fetchNextObject($obj->query("select * from tbl_student_screening_interview where stu_id='".$line->id."'"));
    $nestedData[] = "<span ".$color.">".$line->student_no."<br> ".$count_total."</span>";
    $nestedData[] = "<span ".$color.">".date("d M y",strtotime($last_student->cdate))."</span>";
    $nestedData[] = "<span ".$color.">".$line->type."</span>";
    $nestedData[] = "<span ".$color.">".$line->stu_name."</span>";
    $nestedData[] = "<span ".$color.">".$line->student_contact_no."<br>".$line->alternate_contact."</span>";
    $nestedData[] = "<span ".$color.">".$rResult->name."</span>";
    $nestedData[] = "<span ".$color.">".$line->passport_no."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_country,$line->country_id)."</span>"; 
    $nestedData[] = "<span ".$color.">".$month[$line->intake] . ', ' .$line->intake_year ."</span>";
    $nestedData[] = "<span ".$color.">".$student_type."</span>";
    $nestedData[] = "<span ".$color.">".get_visa_type($line->visa_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$last_student->c_id)."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_admin,$last_student->am_id)."</span>";
    // $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id))."</span>";
    $nestedData[] = "<span ".$color.">".getField('name',$tbl_branch,$line->branch_id)."</span>";
    $nestedData[] = $status_v;
    $nestedData[] = $screening_interview->screening_interview_status;
    if($_SESSION['level_id']==1){
      $nestedData[] = "";
    }
    if($_SESSION['level_id']==4 || $_SESSION['level_id']==11 || $_SESSION['level_id']==1){
      $nestedData[] = "<a style='padding: 5px 10px;' href='#' onclick='get_modal($line->id)'><i class='fa-solid fa-school' style='margin-right: 6px;font-size: 16px;'></i></a>";
    }
    if($_SESSION['level_id']==1 || $_SESSION['level_id']==4){
      $nestedData[] = "<span ".$color.">".$line->passcode." <a href='controller.php?change_student_otp=".base64_encode(base64_encode(base64_encode($line->id)))."'><i class='fa fa-refresh'></i></a></span>";
    }
    if($_SESSION['level_id']==1){
      $nestedData[] = $chk;
      $nestedData[] = $chk1;
    }
      
    if($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==31 || $_SESSION['level_id'] == 18 || in_array(9, $addtional_role) || $_SESSION['level_id']==23 || $_SESSION['level_id']==19 || $_SESSION['level_id']==25  || $_SESSION['level_id']==17 || $_SESSION['level_id']==3 || $_SESSION['level_id']==24 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8 || $_SESSION['level_id']==10 || $_SESSION['level_id']==14 || in_array(6,$addtional_role) || $_SESSION['level_id']==11 || in_array(6,$addtional_role)){
      $nestedData[] = $edit;
    }
    $data[] = $nestedData;
  }
  
  $i++;
}

$json_data = array(
  "draw"            => intval( $requestData['draw'] ),
  "recordsTotal"    => intval( $totalData ),
  "recordsFiltered" => intval( $totalFiltered ),
  "data"            => $data
);


echo json_encode($json_data);
?>