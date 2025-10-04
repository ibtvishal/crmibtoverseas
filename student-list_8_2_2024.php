<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = "";
$whr1 = "";
$_SESSION['whr'] = '';
$_SESSION['whr1']='';
$_SESSION['whr2'] = '';
$_SESSION['stage_status'] = '';
if($_GET['filter']){
  $_REQUEST['filter'] = base64_decode(base64_decode(base64_decode($_GET['filter'])));
}
if($_GET['b_id']){
  $_REQUEST['branch_id'] = explode(',',base64_decode(base64_decode(base64_decode($_GET['b_id']))));
}
if($_GET['c_id']){
  $_REQUEST['counsellor_id'] = base64_decode(base64_decode(base64_decode($_GET['c_id'])));
}

if($_GET['a_id']){
  $_REQUEST['account_manager_id'] = base64_decode(base64_decode(base64_decode($_GET['a_id'])));
}

if($_GET['f_id']){
  $_REQUEST['filling_manager_id'] = base64_decode(base64_decode(base64_decode($_GET['f_id'])));
}

if($_GET['fe_id']){
  $_REQUEST['filling_executive_id'] = base64_decode(base64_decode(base64_decode($_GET['fe_id'])));
}


if($_REQUEST['filter']==2){
  $whr = " and am_id =0";
  $whr1 = " and a.am_id =0";
  $whr2 = " and a.am_id =0";
}
if($_REQUEST['filter']==3){
  $whr = " and am_id !='0'";
  $whr1 = " and am_id !='0'";
  $whr2 = " and am_id !='0'";
}
if($_REQUEST['filter']==4){
  $whr = " and status=0";
  $whr1 = " and a.status=0";
  $whr2 = " and a.status=0";
}

if($_REQUEST['country_id']){
  $country_id = $_REQUEST['country_id'];
  $whr .= " and country_id=$country_id";
  $whr1 .= " and a.country_id=$country_id";
}
if($_REQUEST['visa_id']){
  $visa_id = $_REQUEST['visa_id'];
  $whr .= " and visa_id=$visa_id";
  $whr1 .= " and visa_id=$visa_id";
  $whr2 .= " and visa_id=$visa_id";
}

if($_REQUEST['stage_id']){
  $stage_id = $_REQUEST['stage_id'];
  $whr1 .= " and b.stage_id=$stage_id";
  $_SESSION['stage_id'] = $stage_id;
}

if($_REQUEST['stage_status']){
  $stage_status = $_REQUEST['stage_status'];
  $whr1 .= " and b.cstatus='$stage_status'";

}

if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and branch_id in ($branch_id)";
  $whr1 .= " and a.branch_id in ($branch_id)";
}

if($_REQUEST['account_manager_id']){
  $account_manager_id = $_REQUEST['account_manager_id'];
  $whr .= " and am_id in ($account_manager_id)";
  $whr1 .= " and a.am_id in ($account_manager_id)";
}

if($_REQUEST['counsellor_id']){
  $counsellor_id = $_REQUEST['counsellor_id'];
  $whr .= " and c_id in ($counsellor_id)";
  $whr1 .= " and a.c_id in ($counsellor_id)";
}

if($_REQUEST['filling_manager_id']){
  // $branchArr = $_REQUEST['branch_id'];
  // $branch_id = implode(',',$branchArr);
  // $filling_manager_id = $_REQUEST['filling_manager_id'];
  // $whr .= " and branch_id in ($branch_id)";
  // $whr1 .= " and a.branch_id in ($branch_id)";
}

if($_REQUEST['filling_executive_id']){
  // $filling_executive_id = $_REQUEST['filling_executive_id'];
  // $whr .= " and fe_id in ($filling_executive_id)";
  // $whr1 .= " and a.fe_id in ($filling_executive_id)";
}


$_SESSION['whr'] = $whr;
$_SESSION['whr1'] = $whr1;
$_SESSION['whr2'] = $whr2;

if(!empty($_REQUEST['transfer_val']) && !empty($_REQUEST['transfer_user_to_id'])){
  if(!empty($_REQUEST['userIdarr']) && count($_REQUEST['userIdarr'])>0){
    $transfer_user_from_id = $_REQUEST['transfer_user_from_id'];
    $transfer_user_type = $_REQUEST['transfer_user_type'];
    $transfer_user_to_id = $_REQUEST['transfer_user_to_id'];
    $userIdarr = implode(',',$_REQUEST['userIdarr']);

    $fsql='';
    if($transfer_user_type==3){
      $fsql .= "am_id='$transfer_user_to_id'";
    }else if($transfer_user_type==4){
      $branch_id = getField('branch_id','tbl_admin',$transfer_user_to_id);
      if($branch_id!=''){
        $fsql .= "branch_id='$branch_id',c_id='$transfer_user_to_id'";
      }
    }else if($transfer_user_type==8){
      $fsql .= "fe_id='$transfer_user_to_id'";
    }
    
    $obj->query("update $tbl_student set $fsql where id in ($userIdarr)",-1); //die;
    foreach($_REQUEST['userIdarr'] as $val){
      $obj->query("insert into $tbl_transfer_student set stu_id='$val',user_type='$transfer_user_type',user_from_id='$transfer_user_from_id',user_to_id='$transfer_user_to_id'");
    }    
    $_SESSION['sess_msg'] = "Student Successfully Transfered.";
  }else{
    $_SESSION['sess_msg'] = "Please select check box.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('head.php'); ?>
</head>
<style type="text/css">

  .material-switch > input[type="checkbox"] {
    display: none;   
  }

  .material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
  }

  .material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
  }
  .material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
  }
  .material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
  }
  .material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
  }
</style>
<body>
  <div class="preloader-it">
    <div class="la-anim-1"></div>
  </div>
  <div class="wrapper theme-1-active pimary-color-green">
    <?php include("menu.php"); ?>

    <div class="page-wrapper">
      <div class="container-fluid">
        <h5 style="color:#2a911d; text-align: center;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
        <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
        <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage Student</h5>
          </div>
          <?php  if ($_SESSION['level_id']==1){?>
            <form class="form-horizontal form_csv_download_student" action="download_csv.php?table_name=tbl_student&amp;p=student-list" method="post" name="upload_excel" enctype="multipart/form-data"  style="">
              <div class="row">                  
                <div class="col-md-4 col-6">
                  <input type="submit" name="studentList" class="btn btn-primary download_csv_button" value="Download CSV" style="background: yellow; color: #000">
                </div>
              </div>                    
            </form>
          <?php }?>

          <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="welcome.php">Dashboard</a></li>
              <li class="active"><span><a href="student-addf.php">Add Student</a></span></li>
            </ol>
          </div>
        </div>

        <?php
        if(base64_decode(base64_decode(base64_decode($_GET['transfer'])))!=1){?>
        <form method="post" name="searchfrm" id="searchfrm" action="student-list.php" >
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper">
              <?php  if ($_SESSION['level_id']==1){?>                
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="branch_id[]" id="branch_id" class="form-control select2" multiple="">
                        <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                        }else{
                          $branchArr = array();
                        }                       
                        
                        $branchSql = $obj->query("select * from $tbl_branch where status=1");
                        while($branchResult = $obj->fetchNextObject($branchSql)){?>
                          <option value="<?php echo $branchResult->id; ?>" <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?> selected <?php }} ?>><?php echo $branchResult->name; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="account_manager_id" id="account_manager_id" class="form-control">
                        <option value="">Account Manager</option>
                        <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $idArr = $_REQUEST['branch_id'];
                          $i=1; $whrr='';
                          foreach($idArr as $val){
                            if($i==1){
                              $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                            }else{
                              $whrr .=" or FIND_IN_SET($val, branch_id)";
                            }
                            if($i==count($idArr)){
                              $whrr .=" )";
                            }
                            $i++;
                          }

                          $amSql = $obj->query("select * from $tbl_admin where status=1 and level_id=3 $whrr",-1);
                          while($amResult = $obj->fetchNextObject($amSql)){?>
                            <option value="<?php echo $amResult->id; ?>" <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected <?php } ?>><?php echo $amResult->name; ?></option>
                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="counsellor_id" id="counsellor_id" class="form-control">
                        <option value="">Counsellor</option>
                        <?php
                        if(!empty($_REQUEST['branch_id'])){                          
                          $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                            <option value="<?php echo $clResult->id; ?>" <?php if($_REQUEST['counsellor_id']==$clResult->id){?> selected <?php } ?>><?php echo $clResult->name; ?></option>
                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="filling_manager_id" id="filling_manager_id" class="form-control">
                        <option value="">Filling Manager</option>
                        <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $idArr = $_REQUEST['branch_id'];
                          $i=1; $whrr='';
                          foreach($idArr as $val){
                            if($i==1){
                              $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                            }else{
                              $whrr .=" or FIND_IN_SET($val, branch_id)";
                            }
                            if($i==count($idArr)){
                              $whrr .=" )";
                            }
                            $i++;
                          }                          
                          $fmSql = $obj->query("select * from $tbl_admin where status=1 and level_id=7 $whrr",-1);
                          while($fmResult = $obj->fetchNextObject($fmSql)){?>
                            <option value="<?php echo $fmResult->id; ?>" <?php if($_REQUEST['filling_manager_id']==$fmResult->id){?> selected <?php } ?>><?php echo $fmResult->name; ?></option>
                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="filling_executive_id" id="filling_executive_id" class="form-control">
                        <option value="">Filling Executive</option>
                        <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $idArr = $_REQUEST['branch_id'];
                          $i=1; $whrr='';
                          foreach($idArr as $val){
                            if($i==1){
                              $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                            }else{
                              $whrr .=" or FIND_IN_SET($val, branch_id)";
                            }
                            if($i==count($idArr)){
                              $whrr .=" )";
                            }
                            $i++;
                          }      
                          $feSql = $obj->query("select * from $tbl_admin where status=1 and level_id=8 $whrr");
                          while($feResult = $obj->fetchNextObject($feSql)){?>
                            <option value="<?php echo $feResult->id; ?>" <?php if($_REQUEST['filling_executive_id']==$feResult->id){?> selected <?php } ?>><?php echo $feResult->name; ?></option>
                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                <?php }?>

                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="country_id" id="country_id" class="form-control">
                        <option value="">Select Country</option>
                        <?php
                        $cSql = $obj->query("select * from $tbl_country where status=1 and id in (1,2,3,6)");
                        while($cResult = $obj->fetchNextObject($cSql)){?>
                          <option value="<?php echo $cResult->id; ?>" <?php if($_REQUEST['country_id']==$cResult->id){?> selected <?php } ?>><?php echo $cResult->name; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="visa_id" id="visa_id" class="form-control">
                        <option value="">Select Visa</option>
                        <option value="1" <?php if($_REQUEST['visa_id']==1){?> selected <?php } ?>>Study Visa</option>
                        <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist Visa</option>
                        <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor Visa</option>
                        <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work Visa</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="stage_id" id="stage_id" class="form-control">
                        <option value="">Select Stage</option>
                        <?php
                        if($_REQUEST['country_id']){
                          $swhr="";
                          if($_REQUEST['visa_id']){
                            $swhr = " and visa_id='".$_REQUEST['visa_id']."'";
                          }
                          $sSql = $obj->query("select * from $tbl_stage where country_id='".$_REQUEST['country_id']."' and status=1 $swhr");
                          while($sResult = $obj->fetchNextObject($sSql)){?>
                            <option value="<?php echo $sResult->id; ?>" <?php if($_REQUEST['stage_id']==$sResult->id){?> selected <?php } ?>><?php echo $sResult->stage; ?></option>
                          <?php }
                        }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="stage_status" id="stage_status" class="form-control">
                        <option value="">Select Stage Status</option>
                        <?php
                        if($_REQUEST['stage_id']){   
                          $cstatusArr = array();
                          $ssSql = $obj->query("select cstatus from $tbl_stage where id='".$_REQUEST['stage_id']."'");
                          $ssResult = $obj->fetchNextObject($ssSql);
                          $cstatusArr = explode(',',$ssResult->cstatus);
                          if(sizeof($cstatusArr)>0){
                            foreach($cstatusArr as $csval){?>
                              <option value="<?php echo $csval; ?>" <?php if($_REQUEST['stage_status']==$csval){?> selected <?php } ?>><?php echo $csval; ?></option>
                            <?php }
                          }
                        }?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="filter" id="filter" class="form-control">
                        <option value="1" <?php if($_REQUEST['filter']==1){?> selected <?php } ?>>All</option>
                        <option value="3" <?php if($_REQUEST['filter']==3){?> selected <?php } ?>>Allocated </option>
                        <option value="2" <?php if($_REQUEST['filter']==2){?> selected <?php } ?>>Unallocated </option>
                        <option value="4" <?php if($_REQUEST['filter']==4){?> selected <?php } ?>>Inactive </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" name="subit" class="btn btn-primary download_csv_button" style="width: 170px; height: 40px;">Submit</button>
                    </div>
                  </div>
               
              </div>
            </div>
          </div>
        </div>
         </form>
       <?php }?>


        <?php  
        if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
        <form method="post" name="filterfrm" id="filterfrm" action="student-list.php?transfer=<?php echo base64_encode(base64_encode(base64_encode(1))); ?>" >
          <input type="hidden" name="transfer_val" value="yes">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper">                              
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="transfer_branch_id" id="transfer_branch_id" class="form-control" placeholder="Select Branch">          
                        <option value="">Select Branch</option>
                        <?php                          
                        $branchSql1 = $obj->query("select * from $tbl_branch where status=1");
                        while($branchResult1 = $obj->fetchNextObject($branchSql1)){?>
                          <option value="<?php echo $branchResult1->id; ?>" <?php if($branchResult1->id==$_REQUEST['transfer_branch_id']){?> selected <?php } ?>><?php echo $branchResult1->name; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="transfer_user_type" id="transfer_user_type" class="form-control">
                        <option value="">Type of User</option>                        
                            <!-- <option value="2" <?php if($_REQUEST['transfer_user_type']==2){?> selected <?php } ?>>Sr Account Manager</option>  -->                         
                            <option value="3" <?php if($_REQUEST['transfer_user_type']==3){?> selected <?php } ?>>Account Manager</option>
                            <option value="4" <?php if($_REQUEST['transfer_user_type']==4){?> selected <?php } ?>>Counseller</option>
                            <!-- <option value="5" <?php if($_REQUEST['transfer_user_type']==5){?> selected <?php } ?>>Document Manager</option>
                            <option value="6" <?php if($_REQUEST['transfer_user_type']==6){?> selected <?php } ?>>Media Manager</option>
                            <option value="7" <?php if($_REQUEST['transfer_user_type']==7){?> selected <?php } ?>>File Manager</option> -->
                            <option value="8" <?php if($_REQUEST['transfer_user_type']==8){?> selected <?php } ?>>File Executive</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="transfer_user_from_id" id="transfer_user_from_id" class="form-control">
                        <option value="">Shift From</option>
                        <?php
                        if(!empty($_REQUEST['transfer_branch_id']) && !empty($_REQUEST['transfer_user_type'])){
                          $transfer_branch_id = $_REQUEST['transfer_branch_id'];
                          $t_user_type = $_REQUEST['transfer_user_type'];
                          
                          $ssql = $obj->query("select * from $tbl_admin where status=1 and level_id='$t_user_type' and FIND_IN_SET($transfer_branch_id, branch_id)",-1); //die();
                          while($sResult = $obj->fetchNextObject($ssql)){?>
                            <option value="<?php echo $sResult->id; ?>" <?php if($_REQUEST['transfer_user_from_id']==$sResult->id){?> selected <?php } ?>><?php echo $sResult->name; ?></option>';
                          <?php }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <select name="transfer_user_to_id" id="transfer_user_to_id" class="form-control">
                        <option value="">Shift To</option>  
                        <?php
                        if(!empty($_REQUEST['transfer_branch_id']) && !empty($_REQUEST['transfer_user_type'])){
                          $transfer_branch_id = $_REQUEST['transfer_branch_id'];
                          $t_user_type = $_REQUEST['transfer_user_type'];
                          $transfer_user_from_id='';
                          if($_REQUEST['transfer_user_from_id']){
                            $transfer_user_from_id = $_REQUEST['transfer_user_from_id'];
                          }
                          $ssql = $obj->query("select * from $tbl_admin where status=1 and level_id='$t_user_type' and FIND_IN_SET($transfer_branch_id, branch_id) and id!='$transfer_user_from_id'",-1); //die();
                          while($sResult = $obj->fetchNextObject($ssql)){?>
                            <option value="<?php echo $sResult->id; ?>"><?php echo $sResult->name; ?></option>';
                          <?php }
                        }
                        ?>                     
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" name="subit" class="btn btn-primary download_csv_button" style="width: 170px; height: 40px;">Transfer</button>
                    </div>
                  </div>
               
              </div>
            </div>
          </div>
        </div>
         
         <?php }?>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper collapse in">
                <div class="panel-body">
                  <div class="table-wrap">
                    <div class="table-responsive">
                      <table id="datable_3" class="table table-hover display  pb-30" >
                        <div class="choose_prog" style="">
                        </div>
                          <thead>
                            <tr> 
                              <?php  
                              if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                                <th></th>
                              <?php }?>
                              <th>Student Id</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Father Name</th>
                              <th>Passport No.</th>
                              <th>Country</th>
                              <th>Counsellor Name</th>
                              <th>Sr.Account Manager</th>
                              <th>Account Manager</th>
                              <th>Branch Name</th>
                               <?php  
                              if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))!=1){?>
                              <!-- <th>Filling Manager</th> -->
                              <?php }?>
                              <?php  
                              if ($_SESSION['level_id']==1){?>
                                <th>Filling Executive</th>
                                <th>Status</th>
                              <?php } ?>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <?php  
                              if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                                <th></th>
                              <?php }?>
                              <th>Student Id</th>
                              <th>Date</th>
                              <th>Name</th>
                              <th>Father Name</th>
                              <th>Passport No.</th>
                              <th>Country</th>
                              <th>Counsellor Name</th>
                              <th>Sr.Account Manager</th>
                              <th>Account Manager</th>
                              <th>Branch Name</th>
                               <?php  
                              if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))!=1){?>
                              <!-- <th>Filling Manager</th> -->
                              <?php }?>
                              <?php  
                              if ($_SESSION['level_id']==1){?>
                                <th>Filling Executive</th>
                              <?php }?>
                              <?php  if ($_SESSION['level_id']==1){ ?>
                                <th>Status</th>
                              <?php } ?>
                              <th>Action</th>

                            </tr>
                          </tfoot>
                          <tbody >
                            <?php
                            $i=1;                          
                            if ($_SESSION['level_id']==4){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              if($_REQUEST['stage_id']){
                                $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' $whr1 ",$debug=-1); 
                              }else{                                
                                $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and c_id='".$_SESSION['sess_admin_id']."' $whr ",$debug=-1);
                              }

                            }else if ($_SESSION['level_id']==1){
                              if($_REQUEST['stage_id']){
                                $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 $whr1 ",$debug=-1); 
                              }else{
                                $sql=$obj->query("select * from $tbl_student where 1=1 $whr ",$debug=-1); 
                              }


                              if(!empty($_REQUEST['filling_manager_id'])){
                                $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','CAS Received') $whr1",-1); //die;
                              }
                              
                              if(!empty($_REQUEST['filling_executive_id'])){
                               $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and b.fe_id='".$_REQUEST['filling_executive_id']."' $whr1 ",$debug=-1);
                              }

                              if(base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){
                                  if(!empty($_REQUEST['transfer_branch_id'])){
                                    $transfer_branch_id = $_REQUEST['transfer_branch_id'];
                                    $tswhr .=" and FIND_IN_SET($transfer_branch_id, branch_id)";
                                  }
                                  if(!empty($_REQUEST['transfer_user_from_id'])){
                                    $user_from_id = $_REQUEST['transfer_user_from_id'];
                                    $t_user_type = $_REQUEST['transfer_user_type'];
                                    if($t_user_type==3){
                                      $tswhr .=" and am_id='$user_from_id'";
                                    }else if($t_user_type==4){
                                      $tswhr .=" and c_id='$user_from_id'";
                                    }else if($t_user_type==8){
                                      $tswhr .=" and c_id='$user_from_id'";
                                    }
                                  }
                                  
                                  $sql=$obj->query("select * from $tbl_student where 1=1 $tswhr ",$debug=-1); 
                              }
                              

                            }elseif ($_SESSION['level_id']==2) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);

                              if($_REQUEST['stage_id']){
                                $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) $whr1 ",$debug=-1); 
                              }else{                                
                                $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) $whr",$debug=-1);
                              }

                            }elseif ($_SESSION['level_id']==3) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              if($_REQUEST['stage_id']){
                                $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' $whr1 ",$debug=-1); 
                              }else{                                
                                $sql=$obj->query("select * from $tbl_student where 1=1 and branch_id in ($branch_id) and am_id='".$_SESSION['sess_admin_id']."' $whr",$debug=-1);
                              }

                            }elseif ($_SESSION['level_id']==7) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $msql="select a.*,b.stage_id,b.cstatus";
                              $msql .=" from $tbl_student as a inner join $tbl_student_status as b ON  a.id=b.stu_id where 1=1 and branch_id in ($branch_id)";
                              if($_REQUEST['country_id']==1){
                                $msql .=" and a.country_id = 1 and b.stage_id='3' and b.cstatus='Tuition Fees Paid'";
                                $msql .=" and a.country_id = 1 and b.stage_id='16' and b.cstatus='GIC Paid'";
                              }else if($_REQUEST['country_id']==2){
                                $msql .=" and a.country_id = 2 and b.stage_id='30' and b.cstatus='COE Received'";
                              }else if($_REQUEST['country_id']==3){
                                $msql .=" and a.country_id = 3 and b.stage_id='8' and b.cstatus='I-20 Issued'";
                              }else if($_REQUEST['country_id']==6){
                                $msql .=" and a.country_id = 6 and b.stage_id='24' and b.cstatus='CAS Received'";
                              }else{                   
                                $msql .=" and a.country_id in (1,2,3,6) and b.stage_id in (3,30,8,24,16) and b.cstatus in ('Tuition Fees Paid','COE Received','I-20 Issued','CAS Received','GIC Paid')";  
                              }
                              //echo $msql;
                              $sql=$obj->query($msql);
                            }elseif ($_SESSION['level_id']==8) {
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.* from $tbl_student as a inner join $tbl_filing_credentials as b ON  a.id=b.student_id where 1=1 and a.branch_id in ($branch_id) and b.fe_id!=0 $whr1 ",$debug=-1);
                            }
                            //echo $sql;
                            while($line=$obj->fetchNextObject($sql)){

                              if($line->country_id==1 && $_SESSION['level_id']==7){
                                $showval = 0;
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
                              //echo $showval;
                              if($showval == 1){
                                $color='';

                                if($_SESSION['level_id']==2){
                                  if($line->am_id==0){
                                    $color = "style='color:red'"; 
                                  }
                                }else if($_SESSION['level_id']==3){
                                  if($line->application_check==1){
                                    $color = "style='color:blue'";
                                  }else if($line->accept_student==0 || $line->am_id==0){
                                    $color = "style='color:red'";    
                                  }                                                              
                                }else if($_SESSION['level_id']==7){
                                  $sqlf = $obj->query("select fe_id from $tbl_filing_credentials where student_id='".$line->id."'");
                                  $ResultF = $obj->fetchNextObject($sqlf);
                                  if($ResultF->fe_id==0){
                                    $color = "style='color:red'";
                                  }
                                }else if($_SESSION['level_id']==8){
                                  $sqlf = $obj->query("select pstatus from $tbl_filing_credentials where student_id='".$line->id."'",-1);
                                  $ResultF = $obj->fetchNextObject($sqlf);
                                  if($ResultF->psatus==0)
                                  {
                                    $color = "style='color:red'";
                                  }
                                }
                                ?>
                                <tr <?php echo $color; ?>>
                                  <?php  
                                  if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                                    <th><input type="checkbox" name="userIdarr[]" value="<?php echo $line->id; ?>"></th>
                                  <?php }?>
                                  <td><?php echo $line->student_no ?></td>
                                  <td><?php echo date("d M y",strtotime($line->cdate)); ?></td>
                                  <td><?php echo $line->stu_name ?></td>
                                  <td>
                                    <?php 
                                    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
                                    $rResult = $obj->fetchNextObject($rSql);
                                    echo $rResult->name;
                                    ?>
                                  </td>
                                  <td><?php echo $line->passport_no ?></td>
                                  <td><?php echo getField('name',$tbl_country,$line->country_id) ?></td>
                                  <td><?php echo getField('name',$tbl_admin,$line->c_id) ?></td>
                                  <td><?php echo getField('name',$tbl_admin,$line->am_id) ?></td>
                                  <td><?php echo getField('name',$tbl_admin,$line->am_id) ?></td>
                                  <td><?php echo getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id)) ?></td>
                                  <?php if ($_SESSION['level_id']==1 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))!=1){?>
                                  <!-- <td>
                                    <?php 
                                    $b_id = $line->branch_id;
                                    $fmSql = $obj->query("select name from $tbl_admin where FIND_IN_SET($b_id,branch_id) and level_id=7");
                                    while($fmResult = $obj->fetchNextObject($fmSql)){
                                      echo $fmResult->name."<br>";
                                    }
                                    ?>                                      
                                  </td> -->
                                <?php }?>
                                  <?php 
                                  if ($_SESSION['level_id']==1){?>
                                  <td>
                                    <?php 
                                      $feSql = $obj->query("select fe_id from $tbl_filing_credentials where student_id='".$line->id."'",-1);
                                      $feResult = $obj->fetchNextObject($ffeSqlmSql);
                                      echo getField('name',$tbl_admin,$feResult->fe_id);                                   
                                    ?>    
                                  </td>
                                <?php }?>
                                  <?php  if ($_SESSION['level_id']==1){ ?>
                                    <td>  <div class="material-switch">
                                      <input id="someSwitchOptionPrimary<?php echo $i; ?>"  type="checkbox" class="chkstatus" value="<?php echo $line->id;?>" <?php echo ($line->status=="1")?'checked':'' ?> data-one="<?php echo $tbl_student?>"/>
                                      <label for="someSwitchOptionPrimary<?php echo $i; ?>" class="label-primary"></label>
                                    </div> </td>
                                  <?php } ?>


                                  <td>

                                    <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==2 || $_SESSION['level_id']==3 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8){?>
                                      <a href="student-editf.php?id=<?php echo base64_encode(base64_encode(base64_encode($line->id))) ?>"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i> </a> 
                                    <?php }?>

                                    <!--    <?php
                                    if($_SESSION['level_id']==1 || $_SESSION['level_id']==4){?>
                                    <a href="student-del.php?id=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
                                    border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
                                    <?php }?> -->

                                  </tr>
                                <?php ++$i; } 
                                }?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>  
</div>
</div>
</form>
<!-- /Row -->

<!-- Footer -->
<footer class="footer container-fluid pl-30 pr-30">
  <div class="row">
    <div class="col-sm-12">
      <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
    </div>
  </div>
</footer>
</div>
</div>
</div>
<?php include("footer.php"); ?>
<script src="js/select2.full.min.js"></script>


<script>
  $(".select2").select2({
    placeholder: "Select Branch",
    allowClear: true
});
  function del_prompt(frmobj,comb)
  {
    alert(comb);
    if(comb=='Delete'){
      if(confirm ("Are you sure you want to delete record(s)"))
      {
        frmobj.action = "student-del.php";
        frmobj.what.value="Delete";
        frmobj.submit();

      }
      else{ 
        return false;
      }
    }
    else if(comb=='Disable'){
      frmobj.action = "student-del.php";
      frmobj.what.value="Disable";
      frmobj.submit();
    }
    else if(comb=='Enable'){
      frmobj.action = "student-del.php";
      frmobj.what.value="Enable";
      frmobj.submit();
    }

  }


  $('select').on('change', function() {
    var id=$(this).find(":selected").val() ;

    action='getStudnetData'; 
    $.ajax({
      type: "POST", 
      url: 'student-list.php', 
      data: {'id':id,'action':action}, 
      success: function (response) {

        $("#datastudent").html(response);


      },
    });
  });


  $('#country_id').change(function() {
    var id = $('#country_id').val();
    var action='get_stage_id'
    $.ajax({
      type:"post",
      url:"ajax/getModalData.php",
      data :{
        'key' : id,'action': action              
      },          
      success:function(res){

        $('#stage_id').html(res); 
        $("#searchfrm").submit();

      }
    });
  });

  $('#visa_id').change(function() {
    var country_id = $('#country_id').val();
    var id = $('#visa_id').val();
    var action='get_cstage_id'
    $.ajax({
      type:"post",
      url:"ajax/getModalData.php",
      data :{
        'key' : id,'country_id':country_id,'action': action              
      },          
      success:function(res){
        $('#stage_id').html(res); 
        $("#searchfrm").submit();

      }
    });
  });


  $("#stage_id").change(function(){
    $("#searchfrm").submit();
  })

  $("#stage_status").change(function(){
    $("#searchfrm").submit();
  })

  $("#filter").change(function(){
    $("#searchfrm").submit();
  })

  $("#branch_id").change(function(){
    $("#searchfrm").submit();
  })

  $("#account_manager_id").change(function(){
    $("#searchfrm").submit();
  })

  $("#counsellor_id").change(function(){
    $("#searchfrm").submit();
  })

  $("#filling_manager_id").change(function(){
    $("#searchfrm").submit();
  })
  
  $("#filling_executive_id").change(function(){
    $("#searchfrm").submit();
  })
  



  $("#branch_id").change(function(){
    var branch_id = $(this).val();
    $.ajax({
      type:"post",
      url:"ajax/getModalData.php",
      data :{
        'id' : branch_id,'action':'getAcffManagerList'              
      },          
      success:function(res){
        res = res.split('##');
        $('#account_manager_id').html(res[0]); 
        $('#counsellor_id').html(res[1]); 
        $('#filling_manager_id').html(res[2]); 
        $('#filling_executive_id').html(res[3]); 
      }
    });
  })

  // $("#transfer_user_type").change(function(){
  //   var t_user_type = $(this).val();
  //   var t_branch_id = $("#transfer_branch_id").val();
  //   $.ajax({
  //     type:"post",
  //     url:"ajax/getModalData.php",
  //     data :{
  //       'user_type' : t_user_type,'t_branch_id':t_branch_id,'action':'getTransferUserList'              
  //     },          
  //     success:function(res){
  //       res = res.split('##');
  //       $('#transfer_user_from_id').html(res[0]); 
  //       $('#transfer_user_to_id').html(res[1]); 
  //     }
  //   });
  // })


  
  

  $("#transfer_branch_id").change(function(){
    $("#filterfrm").submit();
  })

  $("#transfer_user_type").change(function(){
    $("#filterfrm").submit();
  })
  $("#transfer_user_from_id").change(function(){
    $("#filterfrm").submit();
  })
  
</script>

<script src="js/change-status.js"></script> 
</body>
</html>